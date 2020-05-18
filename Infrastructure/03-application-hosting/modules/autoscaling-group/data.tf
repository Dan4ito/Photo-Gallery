data "aws_subnet_ids" "private_subnets" {
    vpc_id = var.vpc_id

    tags = {
        Access = "public"
    }
}

data "aws_iam_policy" "S3FullAccess" {
  arn = "arn:aws:iam::aws:policy/AmazonS3FullAccess"
}

data "template_file" "init" {
    template = file("./modules/autoscaling-group/user_data.sh.tpl")

    vars = {
        code_bucket_name = var.infrastructure_bucket
        images_bucket_name = var.images_bucket
        db_ip = var.mysql_ip
        region_name = var.region_name
    }
}
