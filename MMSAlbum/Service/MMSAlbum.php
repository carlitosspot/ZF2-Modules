<?php
namespace MMSAlbum\Service;

use MMSAlbum\Mapper\MMSAlbum as Mapper;
use MMSAlbum\Service\AWS\AmazonS3 as WebService;
use MMSAlbum\Document\Picture;

class MMSAlbum
{
    private $mapper;
    private $webService;

    public function getPicturesByUserId($id)
    {
        return $this->mapper->getPicturesByUserId($id);
    }
    public function storeFile($file, $user, $param)
    {
        $y1 = $param->fromPost('y1');
        $y2 = $param->fromPost('y2');
        $x1 = $param->fromPost('x1');
        $x2 = $param->fromPost('x2');
        $w  = $param->fromPost('w');
        $h  = $param->fromPost('h');
        
        $image = new SimpleImage();
        //load and save first image
        $image->load($file['tmp_name']);
        $extension = $image->getExtension();
        
        $hashFilename = md5($file['name'].$user->getId()).$extension; 
        
        $baseURL = getcwd();
        $tmp_path = $baseURL.'\public\images\\'.$user->getId();
        $tmp_tnPath = $tmp_path.'\thumbnails';    
           
        if(!is_dir($tmp_path)) mkdir($tmp_path, 0777);
        if(!is_dir($tmp_tnPath)) mkdir($tmp_tnPath, 0777);
        $path = $tmp_path.'\\'.$hashFilename;
        $tnPath = $tmp_tnPath.'\\'.$hashFilename; 
         
               
        if($w != null && $h != null )
        {
              $image->load($path);
              $image->crop((int)$x1, (int)$y1, (int)$x2, (int)$y2); 
              $image->save($path); 
        }
        
        if($image->getWidth() > 600){
           $image->resizeToWidth(600);
           $image->save($path);
        } 
              
        //load and save second image
        $image->load($path);
        $image->createThumbnail($tnPath);
        
        
        $pic = new Picture();
        $pic->setUploadTime(new \DateTime('now'))
            ->setPictureTitle('testing')
            ->setDescription('testing the image funtions')
            ->setUserId($user->getId())
            ->setUsername($user->getUsername())
            ->setSchoolId('');
            
        $fileName = $pic->getUserId().'/'.$hashFilename;
        $pic->setUrl($fileName);
         
        $orginPic = '600x/'.$fileName;
        $thumbnail = '160x/'.$fileName;        
        $a= $this->webService->storePicture($orginPic, $file['type'], $path); 
        $b= $this->webService->storePicture($thumbnail, $file['type'], $tnPath); 
       
       $serverPath = 'public\images\\'.$user->getId().'\\'.$hashFilename;
       $serverTnPath = 'public\images\\'.$user->getId().'\thumbnails\\'.$hashFilename;
      //delete tmp paths of the files
       unlink($serverPath); 
       unlink($serverTnPath);       
         
      
       $this->getMapper()->insert($pic);
        return $pic;
    }
    
    public function setMapper(Mapper $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }
    
    public function getMapper()
    {
        return $this->mapper;
    }
    
    public function setWebService(WebService $webService)
    {
        $this->webService = $webService;
        return $this;
    }
    
    public function getWebService()
    {
        if($this->webService == null)
        {
            $this->webService = new WebService();
        }
        return $this->webService;
    }
}