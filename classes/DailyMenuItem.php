<?php
/**
 * Created by Luis Pizarro
 * Date: 23/01/12
 * Time: 8:05 PM
 * Purpose: Class to handle Daily Menu Items
 */
 
class DailyMenuItem {

    //Properties

    /**
     * @var int The item ID from the database
     */

    public $id = null;
    public $name = null;
    public $description = null;
    public $price = null;
    public $date = null;

    public function __construct( $data=array()) {
        if( isset( $data['id'] ) ) $this->id = (int) $data['id'];
        if( isset( $data['name'] ) ) $this->name = $data['name'];
        if( isset( $data['description'] ) ) $this->description = preg_replace ("[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]","", $data['description'] );
        if( isset( $data['price'] ) ) $this->price = (int) $data['price'];
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
        $sql = "SELECT *, UNIX_TIMESTAMP(date) AS date FROM daily_menu WHERE id = :id";
        $st = $conn->prepare( $sql );
        $st->bindValue( ':id', $id, PDO::PARAM_INT );
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ( $row ) return new DailyMenuItem( $row );
    }

    public static function getDailyMenuItemList ( $numRows=1000000 , $order=" name ") {
        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(date) AS date FROM daily_menu ORDER BY :order LIMIT :numRows";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ':numRows', $numRows, PDO::PARAM_INT );
        $st->bindValue( ':order', $order, PDO::PARAM_STR );
        $st->execute();
        $list = array();

        while ( $row = $st->fetch() ) {
            $dailyMenuItem = new DailyMenuItem( $row );
            $list[] = $dailyMenuItem;
        }

        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
        return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }

    public function insert() {
        if ( !is_null( $this->id ) ) trigger_error ("DailyMenuItem::insert(): Attempt to insert a DailyMenuItem object that already has its ID property set (to $this->id).", E_USER_ERROR);

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO daily_menu ( date, name, description, price) VALUES ( FROM_UNIXTIME(:date), :name, :description, :price )";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ':name', $this->name, PDO::PARAM_STR);
        $st->bindValue( ':description', $this->description, PDO::PARAM_STR);
        $st->bindValue( ':price', $this->price, PDO::PARAM_INT);
        $st->bindValue( ':date', $this->date, PDO::PARAM_INT);
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;
    }

    public function update() {

        if ( is_null( $this->id ) ) trigger_error ("DailyMenuItem::update(): Attempt to update a DailyMenuItem object that does not have its ID property set.", E_USER_ERROR);

        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "UPDATE daily_menu SET name=:name, description=:description, price=:price, date=FROM_UNIXTIME(:date) WHERE id = :id";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ':name', $this->name, PDO::PARAM_STR );
        $st->bindValue( ':description', $this->description, PDO::PARAM_STR );
        $st->bindValue( ':price', $this->price, PDO::PARAM_INT );
        $st->bindValue( ':date', $this->date, PDO::PARAM_INT);
        $st->bindValue( ':id',$this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

    public function delete() {

        if ( is_null( $this->id ) ) trigger_error ("DailyMenuItem::update(): Attempt to delete a DailyMenuItem object that does not have its ID property set.", E_USER_ERROR);

        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $st = $conn->prepare ( "DELETE FROM daily_menu WHERE id = :id LIMIT 1" );
        $st->bindValue( ':id', $this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

    public function convert_type( $price ) {
        if( is_numeric( $price ) )
            return abs($price);
    }
}
?>