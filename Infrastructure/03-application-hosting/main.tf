provider "aws" {
    region  = var.region
    profile = "default"
}

# S3 Backend info for Terraform tfstate file
# Unfortunatly, this parameters doesn"t support variables and must be hardcoded
terraform {
    required_version = ">= 0.12.9"
    backend "s3" {
        bucket = "gallery2020-infrastructure-bucket-zdravko"
        encrypt = true
        key = "terraform/03-application-hosting.tfstate"
        dynamodb_table = "dynamodb-photo-gallery-terraform-lock"
        region = "us-east-1"
    }
}

resource "aws_s3_bucket" "images_bucket" {
    bucket = var.images_bucket_name
    acl    = "public-read"
    force_destroy = true

    tags = {
        Application = var.application_name
        Environment = var.environment
    }
}

module "mysql_module" {
    source = "./modules/mysql"
    gallery_vpc_id = var.vpc_id
    environment = var.environment
    application_name = var.application_name
}

module "load_balancer_module" {
    source = "./modules/load-balancer"

    vpc_id = var.vpc_id
    application_name = var.application_name
    environment = var.environment
}

module "autoscaling_module" {
    source = "./modules/autoscaling-group"

    gallery_alb_target_group_arn = module.load_balancer_module.gallery_alb_target_group_arn
    environment = var.environment
    application_name = var.application_name
    vpc_id = var.vpc_id
    region_name = var.region
    infrastructure_bucket = "gallery2020-infrastructure-bucket-zdravko"
    images_bucket = aws_s3_bucket.images_bucket.id
    mysql_ip = "${module.mysql_module.private_ip}:3306"
}

output "elb_domain_name" {
    value = module.load_balancer_module.alb_dns_name
    description = "The domain name of the ELB"
}

output "mysql_private_ip" {
    value = module.mysql_module.private_ip
}
