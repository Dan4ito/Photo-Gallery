variable "environment" {
    type    = string
    default = "dev"
}

variable "region" {
    type    = string
    default = "us-east-1"
}

variable "application_name" {
    type = string
    default = "gallery-project"
}

variable "vpc_id" {
    type = string
    default = "vpc-0a88a5f129102d1cf"
}

variable "images_bucket_name" {
    type = string
    default = "gallery-project-images-zdravko"
}
