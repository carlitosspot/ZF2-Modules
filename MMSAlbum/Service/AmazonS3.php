<?php
namespace MMSAlbum\Service;

use Aws\S3\S3Client;
use Aws\Common\Enum\Region;
use Aws\S3\Enum\CannedAcl;
use Aws\S3\Exception\S3Exception;

class AmazonS3
{
    
    private $bucketName = 'bucketname.albums.net';
    private $connector;                    
                        
    public function __construct(S3Client $aws)
    {
        $this->connector = $aws;
    }
                                
    /**
     * AmazonS3::storePicture()
     * 
     * @param mixed $fileName
     * @param mixed $fileType
     * @param mixed $filePath
     * @return
     */
    public function storePicture($fileName, $fileType, &$filePath)
    {        
        try {
            $this->connector->putObject(array(
                'Bucket' => $this->bucketName,
                'Key' => $fileName, 
                'Body' =>fopen($filePath, 'r'),
                'ACL' => CannedAcl::PUBLIC_READ,
                'ContentType' => $fileType
            ));
            return True;
        }catch (S3Exception $e){
            return false;
        }        
    }
    
    /**
     * Delete a single picture by providing name of file as stored in aws
     * 
     * AmazonS3::deletePicture()
     * 
     * @param mixed $fileName
     * @return
     */
    public function deletePicture($fileName)
    {       
        try {
            $this->connector->deleteObject(array(
                            'Bucket' => $this->bucketName,
                            'Key' => $fileName
                        ));
            return True;
        }catch (S3Exception $e){
            return false;
        }
    }
    /**
     * Delete a set of 3 pictures by providing the name as stored in aws
     * AmazonS3::deletePictures()
     * 
     * @param mixed $s70x
     * @param mixed $s160x
     * @param mixed $s600x
     * @return
     */
    public function deletePictures($s70x,$s160x, $s600x)
    {       
        try {
            $this->connector->deleteObjects(array(
                            'Bucket' => $this->bucketName,
                            'Objects' => array(array('Key' => $s70x),
                                               array('Key' => $s160x),
                                               array('Key' => $s600x) 
                            )
                        ));
            return True;
        }catch (S3Exception $e){
            return false;
        }
    }
    
    /**
     * Retrieve up to 1000 pictures from aws
     * 
     * AmazonS3::listBucketContents()
     * 
     * @return
     */
    public function listBucketContents()
    {  
        foreach ($this->connector->getIterator('ListObjects', array('Bucket' => $this->bucketName)) as $object) {
            $pictures[]= $object['Key'];
        }
        
        return $pictures;
    }
}