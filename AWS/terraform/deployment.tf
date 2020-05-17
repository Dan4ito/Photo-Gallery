provider "aws" {
  region = "us-east-1"
  shared_credentials_file = "~/.aws/credentials"
}

variable "ec2_ami" {
  description = "The EC2 Amazon Image that is used"
  type        = string
  default     = "ami-0915e09cc7ceee3ab"
}

variable "server_port" {
  description = "The port the server will use for HTTP requests"
  type        = number
  default     = 80
}

variable "elb_port" {
  description = "The port the load balancer"
  type        = number
  default     = 80
}



# resource "aws_security_group" "mysql_group" {
#   name = "mysql-security-group"  
#   ingress {
#     from_port   = 22
#     to_port     = 22
#     protocol    = "tcp"
#     cidr_blocks = ["0.0.0.0/0"]
#   }
# }

# resource "aws_instance" "mysql_ec2" {       # EC2 Instance
#   ami                    = var.ec2_ami
#   instance_type          = "t2.micro"
#   vpc_security_group_ids = [aws_security_group.mysql_group.id] 

#   tags = {
#     Name = "mysql-ec2"
#   }
# }

resource "aws_security_group" "galleries_group" {
  name = "gallery-instances-security-group"  
  ingress {
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }
  ingress {
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }
}

# output "public_ip" {
#   value       = aws_instance.mysql_ec2.public_ip
#   description = "The public IP of the mysql EC2"
# }

resource "aws_launch_configuration" "config" {
  image_id        = var.ec2_ami
  instance_type   = "t2.micro"
  security_groups = [aws_security_group.galleries_group.id]  
  user_data = <<-EOF
              #!/bin/bash
              echo "Hello, World" > index.html
              nohup busybox httpd -f -p "${var.server_port}" &
              EOF  
  lifecycle {
    create_before_destroy = true
  }
}

data "aws_availability_zones" "all" {}

resource "aws_autoscaling_group" "replica_autoscaling_group" {
  launch_configuration = aws_launch_configuration.config.id
  availability_zones = data.aws_availability_zones.all.names
  min_size = 2
  max_size = 3
  
  load_balancers = [aws_elb.load_balancer.name]
  health_check_type = "ELB"

  tag {
    key = "Name"
    value = "galleries-autoscaling-group"
    propagate_at_launch = true
  }
}

resource "aws_security_group" "elb" {
  name = "galleries-load-balancer-security-group"  
  # Allow all outbound
  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }  
  # Inbound HTTP from anywhere
  ingress {
    from_port   = var.elb_port
    to_port     = var.elb_port
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }
}

resource "aws_elb" "load_balancer" {
  name               = "galleries-autoscaling-group"
  security_groups    = [aws_security_group.elb.id]
  availability_zones = data.aws_availability_zones.all.names  
  health_check {
    target              = "HTTP:${var.server_port}/"
    interval            = 30
    timeout             = 3
    healthy_threshold   = 2
    unhealthy_threshold = 2
  }  
  # This adds a listener for incoming HTTP requests.
  listener {
    lb_port = var.elb_port
    lb_protocol = "http"
    instance_port = var.server_port
    instance_protocol = "http"
  }
}

output "clb_dns_name" {
  value       = aws_elb.load_balancer.dns_name
  description = "The domain name of the load balancer"
}



