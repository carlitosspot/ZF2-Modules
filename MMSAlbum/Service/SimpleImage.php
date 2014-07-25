<?php
namespace MMSAlbum\Service;

use MMSAlbum\Service\AWS\AmazonS3 as WebService;

class SimpleImage {
    
   var $image;
   var $image_type;
   var $image_content;
   var $image_extension;
  
   function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
         $this->image_extension = '.jpg';
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
         $this->image_extension = '.png';
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);        
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }   
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   
   public function getExtension()
   {
      return $this->image_extension;
   }
   
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }   
   }
   function getWidth() {
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100; 
      $this->resize($width,$height);
   }
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
   }
   
   public function crop($x1, $y1 = 0, $x2 = 0, $y2 = 0)
    {
        if (!is_resource($this->image)) {
            throw new RuntimeException('No image set');
        }
        
        $x1 = max($x1, 0);
        $y1 = max($y1, 0);
        
        $x2 = min($x2, $this->getWidth());
        $y2 = min($y2, $this->getHeight());
        
        $width = $x2 - $x1;
        $height = $y2 - $y1;
        
        $temp = imagecreatetruecolor($width, $height);
        imagecopy($temp, $this->image, 0, 0, $x1, $y1, $width, $height);
        $this->image = $temp;
    }      
    
    public function createThumbnail($url)
    {
        $h = $this->getHeight();
        $w = $this->getWidth();
        if($h > $w){           
            $x1 = 0;
            $y1 = ($h - $w)/2;
            $x2 = $w;
            $y2 = $h - $y1;
            $this->crop($x1, $y1, $x2, $y2);
        }else{
            $x1 = ($w - $h)/2;
            $y1 = 0;
            $x2 = $w - $x1;
            $y2 = $h;
            $this->crop($x1, $y1, $x2, $y2);
        }
         $this->resize(160,160);
         $this->save($url);
    }
}
?>