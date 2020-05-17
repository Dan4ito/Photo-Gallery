resource "aws_security_group" "mysql_group" {
    vpc_id = var.gallery_vpc_id

    name = "mysql-security-group"  
    ingress {
        from_port   = 22
        to_port     = 22
        protocol    = "tcp"
        cidr_blocks = ["0.0.0.0/0"]
    }

    ingress {
        from_port   = 3306
        to_port     = 3306
        protocol    = "tcp"
        cidr_blocks = ["0.0.0.0/0"]
    }

    tags = {
        Environment = var.environment,
        Application = var.application_name
    }
}

resource "aws_instance" "mysql_ec2" {
    ami                    = var.mysql_ami_id
    instance_type          = "t2.micro"
    vpc_security_group_ids = [aws_security_group.mysql_group.id] 
    subnet_id              = var.private_subnet_id

    tags = {
        Name = "Gallery-DB",
        Environment = var.environment,
        Application = var.application_name
    }
}
