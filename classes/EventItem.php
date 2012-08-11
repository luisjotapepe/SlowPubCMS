<?php
/**
 * Created by Luis Pizarro
 * Date: 02/03/12
 * Time: 4:51 PM
 * Purpose: 
 */
 
class EventItem {

    public $id = null;
    public $name = null;
    public $description = null;
    public $date = null;

    public function __construct( $data=array()) {
        if( isset( $data['id'] ) ) $this->id = (int) $data['id'];
        if( isset( $data['name'] ) ) $this->name = $data['name'];
        if( isset( $data['description'] ) ) $this->description = preg_replace ("[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]","", $data['description'] );
        if( isset( $data['date'] ) ) $this->date = (int) $data['date'];
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
        $sql = "SELECT *, UNIX_TIMESTAMP(date) AS date FROM events WHERE id = :id";
        $st = $conn->prepare( $sql );
        $st->bindValue( ':id', $id, PDO::PARAM_INT );
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ( $row ) return new EventItem( $row );
    }

    public static function getEventItemList ( $numRows=1000000 ) { //i didnt specify order for the list.
        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(date) AS date FROM events LIMIT :numRows";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ':numRows', $numRows, PDO::PARAM_INT );
        $st->execute();
        $list = array();

        while ( $row = $st->fetch() ) {
            $eventItem = new EventItem( $row );
            $list[] = $eventItem;
        }

        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
        return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }

    public static function secondQueryForPagination( $max, $order = " name " ){
        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM events ORDER BY :order :max";
        $st = $conn->prepare( $sql );
        $st->bindValue( ":max", $max, PDO::PARAM_STR);
        $st->bindValue( ":order", $order, PDO::PARAM_STR);
        $st->execute();
        $data_p = array();

        while ( $row = $st->fetch() ) {
            $eventItem = new EventItem( $row );
            $data_p[] = $eventItem;
        }
        return $data_p;
    }

    public function insert() {
        if ( !is_null( $this->id ) ) trigger_error ("EventItem::insert(): Attempt to insert a Event Item object that already has its ID property set (to $this->id).", E_USER_ERROR);

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO events ( date, name, description) VALUES ( FROM_UNIXTIME(:date), :name, :description )";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ':name', $this->name, PDO::PARAM_STR);
        $st->bindValue( ':description', $this->description, PDO::PARAM_STR);
        $st->bindValue( ':date', $this->date, PDO::PARAM_INT);
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;
    }

    public function update() {

        if ( is_null( $this->id ) ) trigger_error ("EventItem::update(): Attempt to update an Event Item object that does not have its ID property set.", E_USER_ERROR);

        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "UPDATE events SET name=:name, description=:description, date=FROM_UNIXTIME(:date) WHERE id = :id";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ':name', $this->name, PDO::PARAM_STR );
        $st->bindValue( ':description', $this->description, PDO::PARAM_STR );
        $st->bindValue( ':date', $this->date, PDO::PARAM_INT);
        $st->bindValue( ':id',$this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

    public function delete() {

        if ( is_null( $this->id ) ) trigger_error ("EventItem::delete(): Attempt to delete an Event Item object that does not have its ID property set.", E_USER_ERROR);

        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $st = $conn->prepare ( "DELETE FROM events WHERE id = :id LIMIT 1" );
        $st->bindValue( ':id', $this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }
}
