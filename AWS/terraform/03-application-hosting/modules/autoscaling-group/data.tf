data "aws_subnet_ids" "private_subnets" {
    vpc_id = var.vpc_id

    tags = {
        Access = "private"
    }
}

data "aws_iam_policy" "S3FullAccess" {
  arn = "arn:aws:iam::aws:policy/AmazonS3FullAccess"
}
