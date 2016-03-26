<?php
namespace Menu\Model;
 
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
 
class MenuTable extends AbstractTableGateway
{
    protected $table = 'menu';
    protected $pages = 'pages';
	
	

 
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Menu());
 
        $this->initialize();
    }
	
	public function check()
	{
		$sql = "SHOW TABLES"; 
		$statement = $this->adapter->query($sql); 
		return $statement->execute(); 
		
	}
    public function saveMenu(Menu $menu)
    {
       $data =array(
                   'name'=>$menu->name,
                   'label'=>$menu->label,
                   'route'=>$menu->route,
                   'action'=>$menu->action,
                   'alias'=>$menu->alias,
                   'type'=>$menu->type,
                   'order'=>'',
                   'status'=>1,
                   'deleted'=>0
       
       );
       $resultSet = $this->insert($data);
       return $resultSet;
    }
    public function updateMenu(Menu $menu,$menu_id)
    {
       $data =array(
                   'name'=>$menu->name,
                   'label'=>$menu->label,
                   'route'=>$menu->route,
                   'action'=>$menu->action,
                   'alias'=>$menu->alias,
                   'type'=>$menu->type,
       
       );
       $resultSet = $this->update($data,array('menu_id'=>$menu_id));
       return $resultSet;
    }
    public function getMenu($menu_id)
    {
       $resultSet = $this->select(array('menu_id'=>$menu_id,'deleted'=>0));
       return $resultSet->current();   
    }
    public function updateStatus($status,$menu_id)
    {
       $resultSet = $this->update(array('status'=>$status),array('menu_id'=>$menu_id));
       return $resultSet;   
    }
    public function deleteMenu($menu_id)
    {
       $resultSet = $this->update(array('deleted'=>1),array('menu_id'=>$menu_id));
       return $resultSet;  
    }
    public function fetchAll()
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select()
                ->from(array('m' => $this->table))
				->join(array('p' =>$this->pages),'m.alias = p.id',array('link'=>'alias'))
                ->where(array('m.deleted'=>0))
                ->order('m.type ASC'); 
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = new \Zend\Db\ResultSet\ResultSet();
        $resultSet->initialize($statement->execute());
        return $resultSet;
    }
    public function getMenuForNavigation($menu)
    {
        
        $sql = new Sql($this->adapter);
        $select = $sql->select()
                      ->from(array('m' => $this->table))
				      ->join(array('p' =>$this->pages),'m.alias = p.id',array('link'=>'alias'))
                      ->where(array('m.deleted'=>0,'m.type'=>$menu))
                      ->order('m.menu_id ASC'); 
                      
        $statement = $sql->prepareStatementForSqlObject($select);
        $resultSet = new \Zend\Db\ResultSet\ResultSet();
        $resultSet->initialize($statement->execute());
        return $resultSet->toArray();
        
    }
     /**
     * change Oredr stat
     *  @cat_id  cat ID
     * @return type boolean
     */
    public function changeOrder($order,$id)
    {
         $result = $this->update(array('order'=>$order),array('menu_id'=>$id));
         return $result;
    }
}

?>