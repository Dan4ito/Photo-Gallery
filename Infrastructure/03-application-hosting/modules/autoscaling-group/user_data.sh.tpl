#!/bin/bash

aws s3 sync s3://${code_bucket_name}/00-deployment-files/ /var/www/html/ --delete"
echo -n "<html><body><h1>ID: " > /var/www/html/index.html
echo -n $RANDOM >> /var/www/html/index.html
echo "</h1></body></html>" >> /var/www/html/index.html
sed -i 's/PLACE_BUCKET_NAME_HERE/${images_bucket_name}/g' /var/www/html/AWS/config.php
sed -i 's/PLACE_REGION_NAME_HERE/${region_name}/g' /var/www/html/AWS/config.php
sed -i 's/PLACE_DB_ADDRESS_HERE/${db_ip}/g' '/var/www/html/Data Layer/DatabaseContext.php'
