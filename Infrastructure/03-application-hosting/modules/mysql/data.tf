data "aws_subnet" "instance_subnet" {
    vpc_id = var.gallery_vpc_id
    availability_zone = "us-east-1a"

    tags = {
        Access = "private"
    }
}
