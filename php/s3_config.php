<?php
// Bucket Name
$bucket="foodnfellas";
if (!class_exists('S3'))require_once('S3.php');
			
//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAIGJXXKLR6WU6TTVQ');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');
			
//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);

$s3->putBucket($bucket, S3::ACL_PUBLIC_READ);

?>