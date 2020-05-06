# Photo-Gallery

## Apache configurtion:
```bash
file_uploads = On
post_max_size = 100M
upload_max_filesize = 100M
max_file_uploads=1000
```

## AWS Integration:
* Make EC2 instance with LAMP  
* In order to access AWS PHP SDK, we use PHP package manager called "Composer"  
* Installation of Composer on your machine (Linux) is described here - https://linuxize.com/post/how-to-install-and-use-composer-on-ubuntu-18-04/  
* The file describing dependency packages is in ```AWS/composer.json``` 
* To install them run ```composer install``` while inside the ```AWS``` folder 
* S3 Bucket is with Public Access for read and write  
* DatabaseContext.php - may change based on you AWS MySQL server credentials  
* EC2 Instance has a Role which has Full Access to S3  
