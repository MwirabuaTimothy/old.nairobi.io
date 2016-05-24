<?php

namespace Justboilme\Upload;

use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\Model\MultipartUpload\UploadBuilder;

/**
 * Amazon S3 Client Class Consumer
 *
 * @author Sam Gavinio <samgavinio@easyshop.ph>
 */
class AwsUpload
{
    /**
     * The amazon web service storage client
     * @var Aws/S3/S3Client
     */
    private $awsS3Client;
    
    /**
     * Allowed file types
     *
     * @var string
     */
    private $allowedFileType;
    
    /**
     * AWS S3 Bucket name
     *
     * @var string
     */
    private $bucketName;

    /**
     * Max allowed upload size
     *
     * @var string
     */
    private $maxSizeKb;

    
    public function __construct($awsS3Client, $configuration)
    {
        $this->awsS3Client = $awsS3Client;

        $this->allowedFileType = isset($configuration['allowed_types']) ? $configuration['allowed_types'] : 'gif|jpg|png|jpeg';
        $this->maxSizeKb = isset($configuration['max_size']) ? $configuration['max_size'] : 5120;
        if(!isset($configuration['bucket'])){
            throw new \Exception('AWS S3 Bucket name not defined');
        }
        $this->bucketName = $configuration['bucket'] ;
    }

    /**
     * Uploads a file to an AWS S3 bucket
     *
     * @param string $sourceFilePath
     * @param string $destinationFilePath
     * @return bool
     *
     */
    public function uploadFile($sourceFilePath, $destinationFilePath)
    {
        if(!file_exists($sourceFilePath)){
            return false;
        }
        
        $mimeType = image_type_to_mime_type(exif_imagetype($sourceFilePath));
        $fileExtension = explode('/', $mimeType)[1];
        $allowedFileTypes = explode('|', $this->allowedFileType);
        $fileSizeByte = filesize($sourceFilePath) / 1024;
        
        if(!in_array($fileExtension, $allowedFileTypes) ||  $fileSizeByte > $this->maxSizeKb  ){
            return false;
        }
        
        $destinationFilePath = ltrim($destinationFilePath , '.');

        $result = $this->awsS3Client->putObject([
            'Bucket' =>  $this->bucketName,
            'Key'    => $destinationFilePath,
            'SourceFile'  => $sourceFilePath,
            'ContentType' => $mimeType,
            'ACL'    => 'public-read',
            'CacheControl' => 'max-age=604800',
        ]);
            
        return $result;
    }
    
    /**
     * Checks if the file exists in the bucket
     *
     * @param string $sourceFileFullPath
     * @return boolean
     */
    public function doesFileExist($sourceFileFullPath)
    {
        $cleanSourceFileFullPathClean = strpos($sourceFileFullPath, '.') === 0 ? substr($sourceFileFullPath, 1) : $sourceFileFullPath;
        return $this->awsS3Client->doesObjectExist( $this->bucketName, $cleanSourceFileFullPathClean);
    }

    
}


