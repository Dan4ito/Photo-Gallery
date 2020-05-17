# VPC
resource "aws_vpc" "gallery_vpc" {
    cidr_block = "10.0.0.0/16"
    instance_tenancy = "default"
    enable_dns_hostnames = "true"
    tags = {
        Name = "gallery-vpc",
        Environment = var.environment,
        Application = var.application_name
    }
}

# Subnets
resource "aws_subnet" "gallery_public_subnet_a" {
    vpc_id = aws_vpc.gallery_vpc.id
    cidr_block = "10.0.1.0/24"
    map_public_ip_on_launch = "true"
    availability_zone = var.availability_zone_a

    tags = {
        Name = "gallery-public-subnet-a",
        Environment = var.environment
        Application = var.application_name
        Access = "public"
    }
}

resource "aws_subnet" "gallery_public_subnet_b" {
    vpc_id = aws_vpc.gallery_vpc.id
    cidr_block = "10.0.2.0/24"
    map_public_ip_on_launch = "true"
    availability_zone = var.availability_zone_b

    tags = {
        Name = "gallery-public-subnet-b",
        Environment = var.environment
        Application = var.application_name
        Access = "public"
    }
}

resource "aws_subnet" "gallery_private_subnet_a" {
    vpc_id = aws_vpc.gallery_vpc.id
    cidr_block = "10.0.3.0/24"
    availability_zone = var.availability_zone_a

    tags = {
        Name = "gallery-private-subnet-a",
        Environment = var.environment,
        Application = var.application_name
        Access = "private"
    }
}

resource "aws_subnet" "gallery_private_subnet_b" {
    vpc_id = aws_vpc.gallery_vpc.id
    cidr_block = "10.0.4.0/24"
    availability_zone = var.availability_zone_b

    tags = {
        Name = "gallery-private-subnet-b",
        Environment = var.environment,
        Application = var.application_name
        Access = "private"
    }
}

# Security Groups
resource "aws_default_security_group" "gallery_default_sg" {
    vpc_id = aws_vpc.gallery_vpc.id
    
    # Ingress
    ingress {
        protocol  = "-1"
        from_port = 0
        to_port   = 0
        self      = true
    }

    # Egress
    egress {
        protocol    = "-1"
        from_port   = 0
        to_port     = 0
        cidr_blocks = ["0.0.0.0/0"]
    }

    tags = {
        Name = "gallery-default-sg",
        Environment = var.environment,
        Application = var.application_name
    }
}


# Internet Gateway
resource "aws_internet_gateway" "gallery_ig" {
    vpc_id = aws_vpc.gallery_vpc.id
    tags = {
        Name = "gallery-ig",
        Environment = var.environment,
        Application = var.application_name
    }
}

# Route Tables
resource "aws_route_table" "gallery_public_rt" {
    vpc_id = aws_vpc.gallery_vpc.id
    route {
        cidr_block = "0.0.0.0/0"
        gateway_id = aws_internet_gateway.gallery_ig.id
    }
    tags = {
        Name = "gallery-public-rt",
        Environment = var.environment,
        Application = var.application_name
    }
}

resource "aws_route_table" "gallery_private_rt" {
    vpc_id = aws_vpc.gallery_vpc.id
    tags = {
        Name = "gallery-private-rt",
        Environment = var.environment,
        Application = var.application_name
    }
}

# Route Associations
resource "aws_route_table_association" "gallery_public_subnet_rta_a" {
    subnet_id = aws_subnet.gallery_public_subnet_a.id
    route_table_id = aws_route_table.gallery_public_rt.id
}

resource "aws_route_table_association" "gallery_public_subnet_rta_b" {
    subnet_id = aws_subnet.gallery_public_subnet_b.id
    route_table_id = aws_route_table.gallery_public_rt.id
}

resource "aws_route_table_association" "gallery-private-subnet-rta-a" {
    subnet_id = aws_subnet.gallery_private_subnet_a.id
    route_table_id = aws_route_table.gallery_private_rt.id
}

resource "aws_route_table_association" "gallery-private-subnet-rta-b" {
    subnet_id = aws_subnet.gallery_private_subnet_b.id
    route_table_id = aws_route_table.gallery_private_rt.id
}
