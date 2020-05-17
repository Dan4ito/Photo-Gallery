variable "environment" {
    type    = string
    default = "dev"
}

variable "region" {
    type    = string
    default = "us-east-1"
}

variable "s3_bucket_infra" {
    type    = string
    default = "gallery2020-infrastructure-bucket-zdravko"
}

variable "application_name" {
    type = string
    default = "gallery-project"
}
