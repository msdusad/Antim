<?php

namespace Shopping\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;
use Shopping\Mapper\CategoryInterface;
use Shopping\Mapper\ItemInterface;
use Shopping\Mapper\WhishlistInterface;

class IndexController extends AbstractActionController {

    /**
     * @var Mapper
     */
    protected $categoryMapper;

    /**
     * @var Mapper
     */
    protected $itemMapper;
    
     /**
     * @var Mapper
     */
    protected $whishlistMapper;

    /**
     * display page
     */
    public function indexAction() {

        
        $auth = new AuthenticationService();

        if ($auth->hasIdentity()) {

            $userId = $auth->getIdentity();
        } else {

            $userId = 0;
           
        }              
        
        $data = array();
       
        $request = $this->getRequest();
        $search = '';
       
        if ($request->isPost() && $request->getPost('action')!='search') {
          
            $data['user_id'] = $userId;
            $data['item_ids'] = implode(',',$request->getPost('ids'));
           
            $this->getWhislistMapper()->save($data);
            $this->flashMessenger()->addMessage('Whislist added successfully');
            return $this->redirect()->toRoute('shopping');
        }else if($request->isPost()){
            
            $search = $request->getPost('name');
            
        }
        $flashMessenger = $this->flashMessenger();

        if ($flashMessenger->hasMessages()) {

            $message = $flashMessenger->getMessages();
        } else {

            $message = '';
        }

        $id = (int) $this->params()->fromRoute('id', 0);
        
        $rootCategories = $this->getCategoryMapper()->fetchAll(0);
        
        if(count($rootCategories)>0 && $id==0){
            
            $id = $rootCategories[0]['id'];
        }
       
       // $parentCategories = $this->getCategoryMapper()->getParent($id);
        //$allCategories = $this->getCategoryMapper()->fetchCategories();
        
        return new ViewModel(array('message' => $message,'rootCategories'=>$rootCategories,'id'=>$id,'userid'=>$userId,'search'=>$search));
    }
    public function parentAction() {
 
        $request = $this->getRequest();
        
        $parentCategories = array();
       
        if ($request->isPost()) {

          $id = $request->getPost('parent_id');
          $parentCategories = $this->getCategoryMapper()->getParent($id);
            
        }
        $html = '';
        foreach($parentCategories as $key => $parent){
            if($key==0){ $active = 'class="activeparent"';}else{$active= '';}
           $html .= ' <li '.$active.' data-id="'.$parent['id'].'" id="parent_'.$parent['id'].'"><a onclick="child('.$parent['id'].')" href="#">'. $parent['title'].'</a></li>';
        }
        echo $html;exit;
        
        
    }
    public function childAction() {
 
        $request = $this->getRequest();
        
        $parentCategories = array();
       
        if ($request->isPost()) {

          $id = $request->getPost('parent_id');
          $parentCategories = $this->getCategoryMapper()->getParent($id);
            
        }
        $html = '';
        
        foreach($parentCategories as $key => $parent){
            if($key==0){ $active = 'class="activechild"';}else{$active= '';}
            $item = "item('".$parent['id']."','')";
           $html .= ' <li '.$active.' data-id="'.$parent['id'].'" id="child-'.$parent['id'].'"><a href="#" onclick="'.$item.'">'. $parent['title'].'</a></li>';
        }
        echo $html;exit;
        
        
    }
    public function itemAction() {
 
        $request = $this->getRequest();
        
        $items = array();
             
        if ($request->isPost()) {

          $id = (int) $request->getPost('category_id');
          $search = $request->getPost('search');
         
          $items = $this->getItemMapper()->fetchItems($id,$search);
                     
        }
        $html = '';
        if(count($items)<=0){
        $html .= '<div class="noitems">No Items</div>';
        } 
        foreach($items as $item){
        
         $html .= '<div class="items"><input class="check" type="checkbox" name="ids[]" value="'.$item['id'].'"><span>'.$item['title'].'</span>';
         $html .= '<p>'.substr($item['description'],0,35).'</p>';
         $html .= '<p>Price : '.$item['price'].'</p>';
         if($item['url']!=''){
         $html .= '<a href="'.$item['url'].'">Add to Cart</a>';
         }else{
          $html .= '<a style="color:#428bca" href="'.$this->url()->fromRoute('whish-list',array('action'=>'add','id'=>$item['id'])).'">Add to List</a>';   
         }
         $html .= '</div>';
    
     }
     echo $html;exit;
    }

    /**
     * set mapper
     *
     * @param  CategoryInterface $mapper
     * @return dbmapper
     */
    public function setCategoryMapper(CategoryInterface $mapper) {

        $this->categoryMapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return ShoppingInterface
     */
    public function getCategoryMapper() {
        if (!$this->categoryMapper instanceof CategoryInterface) {

            $this->setCategoryMapper($this->getServiceLocator()->get('CategoryMapper'));
        }
        return $this->categoryMapper;
    }
    
    /**
     * set mapper
     *
     * @param  CategoryInterface $mapper
     * @return dbmapper
     */
    public function setItemMapper(ItemInterface $mapper) {

        $this->itemMapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return ShoppingInterface
     */
    public function getItemMapper() {
        if (!$this->itemMapper instanceof ItemInterface) {

            $this->setItemMapper($this->getServiceLocator()->get('ItemMapper'));
        }
        return $this->itemMapper;
    }
    
    /**
     * set mapper
     *
     * @param  WhishlistInterface $mapper
     * @return dbmapper
     */
    public function setWhislistMapper(WhishlistInterface $mapper) {

        $this->whishlistMapper = $mapper;

        return $this;
    }

    /**
     * get mapper
     *
     * @return WhishlistInterface
     */
    public function getWhislistMapper() {
        if (!$this->whishlistMapper instanceof WhishlistInterface) {

            $this->setWhislistMapper($this->getServiceLocator()->get('WhishlistMapper'));
        }
        return $this->whishlistMapper;
    }


}
