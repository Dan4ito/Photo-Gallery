variable "server_ami" {
    type = string
    default = "ami-0a5f8ca3664208e54"
}

variable "gallery_alb_target_group_arn" {
    type = string
}

variable "environment" {
    type = string
}

variable "application_name" {
    type = string
}

variable "vpc_id" {
    type = string
}

variable "infrastructure_bucket" {
    type = string
}

variable "images_bucket" {
    type = string
}

variable "mysql_ip" {
    type = string
}

variable "region_name" {
    type = string
}

variable "mysql_sec_grp_id" {
    type = string
}
