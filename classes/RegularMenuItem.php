<?php
/**
 * Created by Luis Pizarro
 * Date: 29/01/12
 * Time: 2:45 PM
 * Purpose: 
 */
 
class RegularMenuItem {

    public $id = null;
    public $name = null;
    public $description = null;
    public $price = null;
    public $type = null;
    public $date = null;

    public function __construct( $data=array()) {
        if( isset( $data['id'] ) ) $this->id = (int) $data['id'];
        if( isset( $data['name'] ) ) $this->name = $data['name'];
        if( isset( $data['description'] ) ) $this->description = preg_replace ("[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]","", $data['description'] );
        if( isset( $data['price'] ) ) $this->price = (int) $data['price'];
        if( isset( $data['type'] ) ) $this->type = $data['type'];
        if( isset( $data['date'] ) ) $this->date = $data['date'];
    }

    public function storeFormValues( $params) {
        $this->__construct( $params);

        if( isset($params['date']) ) {
            $date = explode ( '-',$params['date'] );

            if( count($date) == 3 ) {
                list ($y, $m, $d) = $date;
                $this->date = mktime (0, 0, 0, $m, $d, $y);
            }
        }
    }

    public static function getById( $id ) {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM reg_menu WHERE id = :id";
        $st = $conn->prepare( $sql );
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ( $row ) return new RegularMenuItem( $row );
    }

    public static function getRegularMenuItemList ( $numRows=1000, $order=" name " ) {
        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM reg_menu ORDER BY :order LIMIT :numRows";
        $st = $conn->prepare( $sql );
        $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
        $st->bindValue( ":order", $order, PDO::PARAM_STR );
        $st->execute();
        $list = array();

        while ( $row = $st->fetch() ) {
            $regularMenuItem = new RegularMenuItem( $row );
            $list[] = $regularMenuItem;
        }

        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
        return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }

    public static function secondQueryForPagination( $max, $order = " name " ){
        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM reg_menu ORDER BY :order :max";
        $st = $conn->prepare( $sql );
        $st->bindValue( ":order", $order, PDO::PARAM_STR);
        $st->bindValue( ":max", $max, PDO::PARAM_STR);
        $st->execute();
        $data_p = array();

        while ( $row = $st->fetch() ) {
            $regularMenuItem = new RegularMenuItem( $row );
            $data_p[] = $regularMenuItem;
        }
        return $data_p;
    }

    public function insert() {
        if ( !is_null( $this->id ) ) trigger_error ("RegularMenuItem::insert(): Attempt to insert a RegularMenuItem object that already has its ID property set (to $this->id).", E_USER_ERROR);

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO reg_menu ( name, description, price, type, date) VALUES (:name, :description, :price, :type, FROM_UNIXTIME(:date) )";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":name", $this->name, PDO::PARAM_STR);
        $st->bindValue( ":description", $this->description, PDO::PARAM_STR);
        $st->bindValue( ":price", $this->price, PDO::PARAM_INT);
        $st->bindValue( ":type", $this->type, PDO::PARAM_STR);
        $st->bindValue( ":date", $this->date, PDO::PARAM_INT);
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;
    }

    public function update() {

        if ( is_null( $this->id ) ) trigger_error( "RegularMenuItem::update(): Attempt to update a RegularMenuItem object that does not have its ID property set.", E_USER_ERROR);

        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "UPDATE reg_menu SET name=:name, description=:description, price=:price, type=:type, FROM_UNIXTIME(:date) WHERE id=:id";
        $st = $conn->prepare( $sql );
        $st->bindValue( ":name", $this->name, PDO::PARAM_STR );
        $st->bindValue( ":description", $this->description, PDO::PARAM_STR );
        $st->bindValue( ":price", $this->price, PDO::PARAM_INT );
        $st->bindValue( ":type", $this->type, PDO::PARAM_STR);
        $st->bindValue( ":id",$this->id, PDO::PARAM_INT);
        $st->bindValue( ":date",$this->date, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

    public function delete() {
         if ( is_null( $this->id ) ) triger_error ("RegularMenuItem::update(): Attempt to delete a RegularMenuItem object that does not have its ID property set.", E_USER_ERROR);

        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $st = $conn->prepare( "DELETE FROM reg_menu WHERE id = :id LIMIT 1" );
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }
}
