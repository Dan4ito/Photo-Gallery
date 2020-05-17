resource "aws_iam_instance_profile" "configuration_profile" {
  name = "gallery-server-instance-profile"
  role = aws_iam_role.configuration_role.name
}

resource "aws_iam_role" "configuration_role" {
    name = "gallery-server-role"
    path = "/"

    assume_role_policy = <<EOF
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Action": "sts:AssumeRole",
            "Principal": {
               "Service": "ec2.amazonaws.com"
            },
            "Effect": "Allow",
            "Sid": ""
        }
    ]
}
EOF
}

resource "aws_iam_role_policy_attachment" "sto-readonly-role-policy-attach" {
  role       = aws_iam_role.configuration_role.name
  policy_arn = data.aws_iam_policy.S3FullAccess.arn
}
