<?php

namespace Memoralize\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Memoralize\Mapper\MediaInterface;
use Zend\Form\Form;
use Zend\Validator\File\Size;

class MediaController extends AbstractActionController {

    /**
     * @var MediaInterface
     */
    protected $mapper;

    /**
     * @var Form
     */
    protected $mediaForm;

    public function indexAction() {

        $id = (int) $this->params()->fromRoute('id', 0);
        $step = (int) $this->params()->fromRoute('step', 0);

        $form = $this->getMeadiaForm();

        $form->get('submit')->setValue('Add');
        $form->get('memoralize_id')->setValue($id);
        $form->get('action')->setValue('media');

        $images = $this->getMapper()->getMimages($id);
        $media = $this->getMapper()->getMedia($id);

        $request = $this->getRequest();
        if ($request->isPost()) {

            $data = $request->getPost();
            $action = $request->getPost('action');

            if ($action == 'cover') {

                $this->getMapper()->updateCover($data['cover']);
                return $this->redirect()->toRoute('memoralize-create-media', array('id' => $id, 'step' => $step));
            } else if ($action == 'delete') {

                $this->getMapper()->deleteImages($data['ids']);
                echo 'sucess';
                die;
            } else {


                $nonFile = $request->getPost()->toArray();
                $File = $this->params()->fromFiles('media_url');
                $data = array_merge(
                        $nonFile, //POST 
                        array('media_url' => $File['name']) //FILE...
                );

                $form->setData($data);

                if ($form->isValid()) {

                    $size = new Size(array('min' => 20000)); //minimum bytes filesize

                    $adapter = new \Zend\File\Transfer\Adapter\Http();
                    $adapter->setValidators(array($size), $File['name']);
                    if (!$adapter->isValid()) {
                        $dataError = $adapter->getMessages();
                        $error = array();
                        foreach ($dataError as $key => $row) {
                            $error[] = $row;
                        }

                        $form->setMessages(array('fileupload' => $error));

                        $this->getMapper()->saveMedia($form->getData());
                    } else {
                        $dirName = dirname(__DIR__) . '/../../assets/media';

                        $media = $this->getMapper()->getMedia($request->getPost('memoralize_id'));

                        unlink($dirName . '/' . $media->media_url);

                        $adapter->setDestination($dirName);
                        if ($adapter->receive($File['name'])) {

                            $this->getMapper()->saveMedia($form->getData());
                        }
                    }
                    return $this->redirect()->toRoute('memoralize-create-media', array('id' => $data['memoralize_id'], 'step' => '1'));
                }
            }
        }
        return array('form' => $form, 'id' => $id, 'images' => $images, 'media' => $media);
    }

    public function uploadFile($id,$method) {

     
        // HTTP headers for no cache etc
        header('Content-type: text/plain; charset=UTF-8');
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // Settings
        $targetDir = dirname(__DIR__) . '/../../assets/'.$method; //temp directory <- need these to be variable
        $finalDir = dirname(__DIR__) . '/../../assets/'.$method;
        //final directory <- need these to be variable
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 60 * 60; // Temp file age in seconds
        //5 minutes execution time
        @set_time_limit(5 * 60);
        // usleep(5000);
        // Get parameters
        $chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
        $chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
        $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

        // Clean the fileName for security reasons
        $fileName = preg_replace('/[^\w\._]+/', '', $fileName);

        // Create target dir
        if (!file_exists($targetDir))
            @mkdir($targetDir);

        // Remove old temp files
        if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
            while (($file = readdir($dir)) !== false) {
                $filePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // Remove temp files if they are older than the max age
                if (preg_match('/\\.tmp$/', $file) && (filemtime($filePath) < time() - $maxFileAge))
                    @unlink($filePath);
            }

            closedir($dir);
        }
        else
            die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');

        // Look for the content type header
        if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
            $contentType = $_SERVER["HTTP_CONTENT_TYPE"];

        if (isset($_SERVER["CONTENT_TYPE"]))
            $contentType = $_SERVER["CONTENT_TYPE"];

        if (strpos($contentType, "multipart") !== false) {
            if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
                // Open temp file
                $out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
                if ($out) {
                    
                    if($method=='images'){
                   
                        $orgData = array('memoralize_id' => $id,
                        'image_url' => $fileName,
                        'main_image' => 0,
                        'id' => '');

                    $this->getMapper()->saveImages($orgData);
                    
                    }else if($method=='themes'){
                    
                    $sm = $this->getServiceLocator();
                    $service = $sm->get('zfcuser_user_service');
                    $userId = $service->getAuthService()->getIdentity()->getId();
                    $orgData = array('user_id' => $userId,
                        'image_url' => $fileName,
                        'id' => '');

                    $this->getMapper()->saveThemes($orgData);
                    }
                    
                    // Read binary input stream and append it to temp file
                    $in = fopen($_FILES['file']['tmp_name'], "rb");

                    if ($in) {
                        while ($buff = fread($in, 4096))
                            fwrite($out, $buff);
                    }
                    else
                        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

                    fclose($out);
                    //unlink($_FILES['file']['tmp_name']);
                }
                else
                    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }
            else
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
        } else {
            // Open temp file
            $out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
            if ($out) {
                // Read binary input stream and append it to temp file
                $in = fopen("php://input", "rb");

                if ($in) {
                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }
                }
                else
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');


                fclose($out);
            }
            else
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }
        //Moves the file from $targetDir to $finalDir after receiving the final chunk
        if ($chunk == ($chunks - 1)) {
            rename($targetDir . DIRECTORY_SEPARATOR . $fileName, $finalDir . DIRECTORY_SEPARATOR . $fileName);
        }

        // Return JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }
  public function uploadthemesAction() {
 
       $id = (int) $this->params()->fromRoute('id', 0);
        
       $this->uploadFile($id,'themes');
      
       return true;
  }
   public function uploadAction() {
 
       $id = (int) $this->params()->fromRoute('id', 0);
        
       $this->uploadFile($id,'images');
      
       return true;
  }
    public function themesAction() {

        $id = (int) $this->params()->fromRoute('id', 0);
        $step = (int) $this->params()->fromRoute('step', 0);
        
        $sm = $this->getServiceLocator();
                    $service = $sm->get('zfcuser_user_service');
                    $userId = $service->getAuthService()->getIdentity()->getId();

        $images = $this->getMapper()->getThemes($userId);

        $request = $this->getRequest();
        if ($request->isPost()) {

            $data = $request->getPost();
            $action = $request->getPost('action');

            if ($action == 'cover') {

                $this->getMapper()->updateTheme($id, $data['theme']);
                return $this->redirect()->toRoute('memoralize-create-themes', array('id' => $id, 'step' => $step));
            } else if ($action == 'delete') {

                $this->getMapper()->deleteThemes($data['ids']);
                echo 'sucess';
                die;
            }
        }
        return array('id' => $id, 'step' => '2', 'images' => $images);
    }

    

    /**
     * set mapper
     *
     * @param  MediaInterface $mapper
     * @return dbmapper
     */
    public function setMapper(MediaInterface $mapper) {
        $this->mapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return MediaInterface
     */
    public function getMapper() {
        if (!$this->mapper instanceof MediaInterface) {

            $this->setMapper($this->getServiceLocator()->get('MediaMapper'));
        }
        return $this->mapper;
    }

    public function getMeadiaForm() {
        if (!$this->mediaForm) {
            $this->setMeadiaForm($this->getServiceLocator()->get('media-form'));
        }
        return $this->mediaForm;
    }

    public function setMeadiaForm(Form $infosForm) {
        $this->mediaForm = $infosForm;
        $this->flashMessenger()->setNamespace('media-form')->getMessages();
        return $this;
    }

}
