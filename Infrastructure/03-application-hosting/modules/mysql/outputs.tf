output "private_ip" {
  value       = aws_instance.mysql_ec2.private_ip
  description = "The private IP of the mysql EC2"
}