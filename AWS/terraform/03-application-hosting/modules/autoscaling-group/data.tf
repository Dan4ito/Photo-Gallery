data "aws_subnet_ids" "private_subnets" {
    vpc_id = var.vpc_id

    tags = {
        Access = "private"
    }
}
