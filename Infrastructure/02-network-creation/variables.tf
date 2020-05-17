variable "environment" {
    type    = string
    default = "dev"
}

variable "region" {
    type    = string
    default = "us-east-1"
}

variable "availability_zone_a" {
    type = string
    default = "us-east-1a"
}

variable "availability_zone_b" {
    type = string
    default = "us-east-1b"
}


variable "application_name" {
    type = string
    default = "gallery-project"
}
