<?php
namespace MMSAlbum\Mapper;
use MMSAlbum\Document\Picture;

class MMSAlbum
{
    private $dm;
    
    
    /**
     * MMSAlbum::__construct()
     * 
     * @param mixed $documentManager
     * @return void
     */
    public function __construct($documentManager)
    {
        $this->dm = $documentManager;
    }
    
    public function insert(Picture $pic)
    {
        $this->dm->persist($pic);     
        $this->dm->flush();
    }
    
    public function delete(Picture $pic)
    {
        $this->dm->remove($pic);
        $this->dm->flush();
    }
    
    public function update(Picture $pic)
    {
        $this->dm->flush($pic);
    }
    
    public function findById($id)
    {
        return $this->dm->getRepository('MMSAlbum\Document\Picture')->findOneBy(array('_id'=>$id));
    }
    
    public function getPicturesByUserId($id)
    {
        return $this->dm->getRepository('MMSAlbum\Document\Picture')->findBy(array('userId'=>$id));
    }
    
    public function findByUsername($username)
    {
         return $this->dm->getRepository('MMSAlbum\Document\Picture')->findOneBy(array('username'=>$username));
    }
    
    public function findBySchoolId($schoolId)
    {
         return $this->dm->getRepository('MMSAlbum\Document\Picture')->findOneBy(array('schoolId'=>$schoolId));
    }
    
}