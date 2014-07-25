<?php
namespace MMSAlbum\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Aws\Common\Aws;
use Aws\S3\S3Client;
use Aws\Common\Enum\Region;
use MMSAlbum\Service\MMSAlbum as Service;
use Zend\Validator\File\Size;
use MMSAlbum\Form\PictureForm as profileForm;
use MMSAlbum\Form\PictureFilter as Profile;

class MMSAlbumController extends AbstractActionController
{
    private $service;    
    public function indexAction()
    { 
        
    }   
    
    public function addAction()
    {
        if (!$this->MMSUserAuthentication()->hasIdentity()) {
           return $this->redirect()->toRoute('mmsuser/login');
        }
        
        $form = new ProfileForm();
        $file  = $this->params()->fromFiles('image_file');            
        $request = $this->getRequest();  
        $user = $this->MMSUserAuthentication()->getIdentity();
        
        if ($request->isPost()) {
            if(!$file['error'])
                {
                    if (is_uploaded_file($file['tmp_name'])) 
                    {                                             
                        $this->getService()->storeFile($file, $user, $this->params());         
                        return $this->redirect()->toRoute('MMSAlbum', array(
                                                    'action' => 'display'
                                                ));
                    }
                 }
            
        }
         
        return array('form' => $form);
    
    } 
    
    public function displayAction()
    {
        if (!$this->MMSUserAuthentication()->hasIdentity()) {
           return $this->redirect()->toRoute('mmsuser/login');
        }
        $user = $this->MMSUserAuthentication()->getIdentity();
        $service = $this->getService();        
        $pics = $service->getPicturesByUserId($user->getId());
        
        return array('pics' => $pics);
    }

    public function getService()
    {
        if(null == $this->service)
        {
            $this->setService($this->getServiceLocator()->get('mmsalbum_service'));
        }
        return $this->service;
    }
    
    public function setService(Service $service)
    {
        $this->service = $service;
        return $this;
    }
} 