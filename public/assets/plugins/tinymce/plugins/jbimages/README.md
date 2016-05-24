## README ##

JustBoil.me Images is a simple, elegant image upload plugin for TinyMCE. It is free, opensource and licensed under Creative Commons Attribution 3.0 Unported License.

Docs & stuff at: http://justboil.me
Donation gives you the right to remove attribution: http://justboil.me/donate/


### S3 Upload Functionality For JBIMAGES (Optional) ###

#### Requires ####

- [Composer](https://getcomposer.org) for autoloading PHP dependencies 

#### How to use: ####
Change directory into the `/ci` dir and run:
```
composer install
```
Edit the config file in `ci/application/config/aws.php`. The file is pretty much self explanatory.

```
$config['s3']['enable'] = true;
$config['s3']['url'] = "http://your-s3-url";
$config['s3']['key'] = 'SAMPLEKEY';
$config['s3']['secret'] = 'samplesecret';
$config['s3']['bucket'] = "bucketname";
$config['s3']['allowed_types'] = 'gif|jpg|png|jpeg';
$config['s3']['max_size'] = 5000;

```
#### Special Note: ###
Be extra cautious about not comitting this config file with your actual s3 credentials into public repositories.


Have a nice day! ))

