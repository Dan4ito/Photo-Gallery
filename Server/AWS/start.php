<?php

use Aws\S3\S3Client;

require 'vendor/autoload.php';

$config = require('config.php');

// S3
$s3 = S3Client::factory(
        [
                'region' => $config['s3']['region'],
                'version' => $config['s3']['version']
        ]
);
