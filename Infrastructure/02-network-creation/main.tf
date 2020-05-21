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
    key = "terraform/02-network-creation.tfstate"
    dynamodb_table = "dynamodb-photo-gallery-terraform-lock"
    region = "us-east-1"
  }
}
