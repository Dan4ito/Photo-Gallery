
output "alb_dns_name" {
    value       = aws_lb.load_balancer.dns_name
    description = "The domain name of the load balancer"
}

output "alb_arn" {
    value = aws_lb.load_balancer.arn
}

output "gallery_alb_target_group_arn" {
    value = aws_lb_target_group.gallery_alb_target_group.arn
}
