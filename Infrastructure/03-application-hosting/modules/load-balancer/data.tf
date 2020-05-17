data "aws_subnet_ids" "public_subnets" {
    vpc_id = var.vpc_id

    tags = {
        Access = "public"
    }
}
