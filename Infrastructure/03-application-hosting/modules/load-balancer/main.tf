resource "aws_security_group" "alb_sec_grp" {
    name = "galleries-load-balancer-security-group"
    vpc_id = var.vpc_id

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

    tags = {
        Environment = var.environment,
        Application = var.application_name
    }
}


resource "aws_lb" "load_balancer" {
    name               = "galleries-alb"
    internal           = false
    load_balancer_type = "application"
    security_groups    = [aws_security_group.alb_sec_grp.id]
    idle_timeout       = 60
    subnets            = data.aws_subnet_ids.public_subnets.ids

    tags = {
        Environment = var.environment
        Application = var.application_name
    }
}

resource "aws_lb_target_group" "gallery_alb_target_group" {  
    name     = "gallery-alb-target-group"  
    port     = var.elb_port 
    protocol = "HTTP"  
    vpc_id   = var.vpc_id

    tags = {
        Environment = var.environment
        Application = var.application_name   
    }

    stickiness {    
        type            = "lb_cookie"    
        cookie_duration = 1800    
        enabled         = true 
    }

    health_check {    
        healthy_threshold   = 3    
        unhealthy_threshold = 10    
        timeout             = 5    
        interval            = 10    
        path                = "/client/views/index.php"    
        port                = 80
    }
}

resource "aws_lb_listener" "alb_listener" {  
    load_balancer_arn = aws_lb.load_balancer.arn  
    port              = var.elb_port  
    protocol          = "HTTP"
    
    default_action {    
        target_group_arn = aws_lb_target_group.gallery_alb_target_group.arn
        type             = "forward"  
    }
}
