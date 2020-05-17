provider "aws" {
    region  = var.region
    profile = "default"
}

# S3 Backend info for Terraform tfstate file
# Unfortunatly, this parameters doesn"t support variables and must be hardcoded
terraform {
    required_version = ">= 0.12.9"
    backend "s3" {
        bucket = "gallery2020-infrastructure-bucket"
        encrypt = true
        key = "terraform/03-application-hosting.tfstate"
        dynamodb_table = "dynamodb-photo-gallery-terraform-lock"
        region = "us-east-1"
    }
}

# module "mysql_module" {
#     source = "./modules/mysql"
#     gallery_vpc_id = "vpc-0b0b3baf7a7ffc220"
#     private_subnet_id = "subnet-0cfd224f4148a2e7a"
#     environment = "dev"
#     application_name = "Gallery"
# }

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
}

output "elb_domain_name" {
    value = module.load_balancer_module.alb_dns_name
    description = "The domain name of the ELB"
}
