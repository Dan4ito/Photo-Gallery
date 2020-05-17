resource "aws_security_group" "gallery_sec_group" {
    vpc_id = var.vpc_id
    
    name = "gallery-instances-security-group"  
    ingress {
        from_port   = 80
        to_port     = 80
        protocol    = "tcp"
        cidr_blocks = ["0.0.0.0/0"]
    }
}

resource "aws_launch_configuration" "config" {
    name            = "gallery-launch-configuration"
    image_id        = var.server_ami
    instance_type   = "t2.micro"
    iam_instance_profile = aws_iam_instance_profile.configuration_profile.name
    security_groups = [aws_security_group.gallery_sec_group.id]
    user_data       = data.template_file.init.rendered

    lifecycle {
        create_before_destroy = true
    }
}

resource "aws_autoscaling_group" "replica_autoscaling_group" {
    launch_configuration = aws_launch_configuration.config.id
    vpc_zone_identifier = data.aws_subnet_ids.private_subnets.ids
    min_size = 2
    max_size = 3
    name = "gallery-autoscaling-group"

    tag {
        key = "Application"
        value = var.application_name
        propagate_at_launch = true
    }

    tag {
        key = "Environment"
        value = var.environment
        propagate_at_launch = true
    }
}

resource "aws_autoscaling_attachment" "alb_autoscale" {
    alb_target_group_arn   = var.gallery_alb_target_group_arn
    autoscaling_group_name = aws_autoscaling_group.replica_autoscaling_group.id
}
