<?php

use Aws\S3\S3Client;

require 'vendor/autoload.php';

$config = require('config.php');

// S3
$s3 = S3Client::factory(
        [
                'key' => $config['s3']['key'],
                'secret' => $config['s3']['secret'],
                'access-token' => $config['s3']['access-token'],
                'region' => $config['s3']['region'],
                'version' => $config['s3']['version']
        ]
);
