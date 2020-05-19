variable "gallery_vpc_id" {
    type = string
}

variable "environment" {
    type    = string
}

variable "application_name" {
    type = string
}

variable "mysql_ami_id" {
    type = string
    default = "ami-0c6d0b790d9cd0925"
}
