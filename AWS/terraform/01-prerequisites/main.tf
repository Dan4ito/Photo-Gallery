provider "aws" {
    region = var.region
    profile = "default"
}

resource "aws_s3_bucket" "s3_bucket_infra" {
    bucket        = var.s3_bucket_infra
    acl           = "private"
    region        = data.aws_region.current.name
    force_destroy = true

    tags = {
        Name = var.s3_bucket_infra,
        Application = var.application_name,
        Environment = var.environment
    }
}

# Block all public access to the S3 bucket
resource "aws_s3_bucket_public_access_block" "s3_bucket_infra_block_public" {
    bucket                  = aws_s3_bucket.s3_bucket_infra.id
    block_public_acls       = true
    block_public_policy     = true
    ignore_public_acls      = true
    restrict_public_buckets = true

    depends_on = [
        aws_s3_bucket.s3_bucket_infra
    ]
}

# Copy the project into the S3 bucket so the autoscalling group can access it afterwards
resource "null_resource" "s3_copy_deployment_file" {
    provisioner "local-exec" {
        command = "aws s3 sync ../00-deployment-files/ s3://${aws_s3_bucket.s3_bucket_infra.id}/00-deployment-files/ --delete --region ${data.aws_region.current.name}"
    }
}


# Create DynamoDB for the storage of the remote state lock
resource "aws_dynamodb_table" "basic-dynamodb-table" {
  # Do not modify name ! , or change name also in the following stacks
  name           = "dynamodb-photo-gallery-terraform-lock"
  billing_mode   = "PROVISIONED"
  read_capacity  = 1
  write_capacity = 1
  hash_key       = "LockID"

  attribute {
    name = "LockID"
    type = "S"
  }

  server_side_encryption {
    enabled = true
  }

  tags = {
    Name = "Terraform Lock Table for ${var.environment} Photo gallery",
    Application = var.application_name,
    Environment = var.environment
  }
}
