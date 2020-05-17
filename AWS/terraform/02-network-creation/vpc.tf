# VPC
resource "aws_vpc" "gallery-vpc" {
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
resource "aws_subnet" "gallery-public-subnet" {
    vpc_id = aws_vpc.gallery-vpc.id
    cidr_block = "10.0.1.0/24"
    map_public_ip_on_launch = "true"
    tags = {
        Name = "gallery-public-subnet",
        Environment = var.environment
        Application = var.application_name
    }
}

resource "aws_subnet" "gallery-private-subnet" {
    vpc_id = aws_vpc.gallery-vpc.id
    cidr_block = "10.0.2.0/24"
    tags = {
        Name = "gallery-private-subnet",
        Environment = var.environment,
        Application = var.application_name
    }
}

# Security Groups
resource "aws_default_security_group" "gallery-default-sg" {
    vpc_id = aws_vpc.gallery-vpc.id
    
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
resource "aws_internet_gateway" "gallery-ig" {
    vpc_id = aws_vpc.gallery-vpc.id
    tags = {
        Name = "gallery-ig",
        Environment = var.environment,
        Application = var.application_name
    }
}

# Route Tables
resource "aws_route_table" "gallery-public-rt" {
    vpc_id = aws_vpc.gallery-vpc.id
    route {
        cidr_block = "0.0.0.0/0"
        gateway_id = aws_internet_gateway.gallery-ig.id
    }
    tags = {
        Name = "gallery-public-rt",
        Environment = var.environment,
        Application = var.application_name
    }
}

resource "aws_route_table" "gallery-private-rt" {
    vpc_id = aws_vpc.gallery-vpc.id
    tags = {
        Name = "gallery-private-rt",
        Environment = var.environment,
        Application = var.application_name
    }
}

# Route Associations
resource "aws_route_table_association" "gallery-public-subnet-rta" {
    subnet_id = aws_subnet.gallery-public-subnet.id
    route_table_id = aws_route_table.gallery-public-rt.id
}

resource "aws_route_table_association" "gallery-private-subnet-rta" {
    subnet_id = aws_subnet.gallery-private-subnet.id
    route_table_id = aws_route_table.gallery-private-rt.id
}
