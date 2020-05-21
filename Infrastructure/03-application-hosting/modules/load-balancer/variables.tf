variable "elb_port" {
    description = "The port of the load balancer"
    type        = number
    default     = 80
}

variable "vpc_id" {
    type = string
}

variable "environment" {
    type = string
}

variable "application_name" {
    type = string
}
