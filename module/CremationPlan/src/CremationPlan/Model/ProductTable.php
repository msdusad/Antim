<?php

namespace CremationPlan\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ProductTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($paginated = false, $search = '') {
        if ($paginated) {
            // create a new Select object for the table cms
            $select = new Select('product');

            $dbSelect = $select->columns(array('id', 'product_image', 'category_id', 'title', 'description', 'sku', 'price', 'quantity'));
            if ($search != '') {
                $dbSelect->where("product.category_id = '$search'");
            }
            //  echo  $dbSelect->getSqlString();die;
            // create a new result set based on the Album entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Product());
            // create a new pagination adapter object
            $paginatorAdapter = new DbSelect(
                    // our configured select object
                    $dbSelect,
                    // the adapter to run it against
                    $this->tableGateway->getAdapter(),
                    // the result set to hydrate
                    $resultSetPrototype
            );
            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function fetchOrders($paginated = false, $search = '') {
        if ($paginated) {
            // create a new Select object for the table cms
            $select = new Select('orders');

            $dbSelect = $select->columns(array('id', 'total_quantity', 'total_amount', 'status', 'created_at'))
                    ->join('user', 'orders.customer_id = user.user_id', array('user' => 'display_name', 'user_id', 'email'), 'left')
                    ->join('product', 'orders.product_id = product.id', array('title', 'description', 'product_image', 'price', 'productid' => 'id'), 'left')
                    ->join('category', 'product.category_id = category.id', array('category' => 'title', 'category_id' => 'id'), 'left');
            $dbSelect->order(array('orders.id asc'));

            if ($search != '') {
                $dbSelect->where("product.category_id = '$search'");
            }
            //  echo  $dbSelect->getSqlString();die;
            // create a new result set based on the Album entity
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Product());
            // create a new pagination adapter object
            $paginatorAdapter = new DbSelect(
                    // our configured select object
                    $dbSelect,
                    // the adapter to run it against
                    $this->tableGateway->getAdapter(),
                    // the result set to hydrate
                    $resultSetPrototype
            );
            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getProduct($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveProduct(Product $product) {

        $data = array(
            'category_id' => $product->category_id,
            'title' => $product->title,
            'description' => $product->description,
            'sku' => $product->sku,
            'price' => $product->price,
            'quantity' => $product->quantity,
            'product_image' => $product->product_image,
        );

        if ($data['product_image'] == '') {
            unset($data['product_image']);
        }


        $id = (int) $product->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getProduct($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
        return $id;
    }

    public function deleteProduct($id) {

        $product = $this->getProduct($id);
        if ($product != '') {

            $dirName = dirname(__DIR__) . '/../../assets/product/';

            if (file_exists($dirName . 'thumb/' . $product->id . '_' . $product->product_image)) {

                unlink($dirName . 'thumb/' . $product->id . '_' . $product->product_image);
            }
            if (file_exists($dirName . $product->product_image)) {

                unlink($dirName . $product->product_image);
            }
            $this->tableGateway->delete(array('id' => $id));
        }
    }

    public function multiDelete($ids) {

        $id = implode(",", $ids);
        $sql = "SELECT id,product_image FROM product WHERE id IN (" . $id . ")";
        $sqlStatement = $this->tableGateway->getAdapter()->query($sql);
        $res = $sqlStatement->execute();
        $dirName = dirname(__DIR__) . '/../../assets/product/';

        foreach ($res as $photo) {
            if (file_exists($dirName . 'thumb/' . $photo['id'] . '_' . $photo['product_image'])) {

                unlink($dirName . 'thumb/' . $photo['id'] . '_' . $photo['product_image']);
            }
            if (file_exists($dirName . $photo['product_image'])) {

                unlink($dirName . $photo['product_image']);
            }
        }

        $sql = "DELETE FROM product WHERE id IN (" . $id . ")";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
    }

    public function getCategories() {

        $sql = "SELECT * FROM category WHERE type='product'";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows[$row['id']] = array(
                'value' => $row['id'],
                'label' => $row['title'],
            );
        }
        return $rows;
    }

    public function getOrder($id) {

        $sql = 'SELECT orders.id AS id, orders.total_quantity AS total_quantity, orders.total_amount AS total_amount, orders.status AS status, orders.created_at AS created_at, user.display_name AS user, user.user_id AS user_id, user.email AS email, product.title AS title, product.description AS description, product.product_image AS product_image, product.price AS price, product.id AS productid, category.title AS category, category.id AS category_id FROM orders LEFT JOIN user ON orders.customer_id = user.user_id LEFT JOIN product ON orders.product_id = product.id LEFT JOIN category ON product.category_id = category.id WHERE orders.id=' . $id . ' ORDER BY orders.id ASC';
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $res = $statement->execute();

        $rows = array();
        foreach ($res as $row) {
            $rows = $row;
        }
        return $rows;
    }
    public function deleteOrder($id) {

       $sql = "DELETE FROM orders WHERE id =".$id;
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
        
    }
    public function multiDeleteOrders($ids) {

        $id = implode(",", $ids);   
        $sql = "DELETE FROM orders WHERE id IN (" . $id . ")";
        $statement = $this->tableGateway->getAdapter()->query($sql);
        $statement->execute();
        return true;
    }

}