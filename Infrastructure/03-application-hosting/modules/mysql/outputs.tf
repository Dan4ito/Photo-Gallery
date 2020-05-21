output "private_ip" {
    value       = aws_instance.mysql_ec2.private_ip
    description = "The private IP of the mysql EC2"
}

output "db_sec_grp_id" {
    value       = aws_security_group.mysql_group.id
    description = "The ID of the security group"
}