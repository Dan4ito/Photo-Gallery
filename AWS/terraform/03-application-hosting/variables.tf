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
    default = "vpc-08e86ff2591af6cd6"
}