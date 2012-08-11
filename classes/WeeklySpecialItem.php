<?php
/**
 * Created by Luis Pizarro
 * Date: 01/03/12
 * Time: 11:53 PM
 * Purpose: 
 */
 
class WeeklySpecialItem {

    public $id = null;
    public $day = null;
    public $onScreen = null;
    public $onBar = null;
    public $onStereo = null;
    public $date = null;

    public function __construct(  $data=array() ) {
        if( isset( $data['id'] ) ) $this->id = (int) $data['id'];
        if( isset( $data['day'] ) ) $this->day = (int) $data['day'];
        if( isset( $data['onBar'] ) ) $this->onBar = preg_replace ("[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]","", $data['onBar'] );
        if( isset( $data['onStereo'] ) ) $this->onStereo = preg_replace ("[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]","", $data['onStereo'] );
        if( isset( $data['onScreen'] ) ) $this->onScreen = preg_replace ("[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]","", $data['onScreen'] );
        if( isset( $data['date'] ) ) $this->date = $data['date'];
    }

    public function storeFormValues( $params ) {
        $this->__construct( $params );

        if( isset($params['date']) ) {
            $date = explode ('-',$params['date'] );

            if(count($date) == 3) {
                list($y, $m, $d) = $date;
                $this->date = mktime (0,0,0, $m, $d, $y);
            }
        }
    }

    public static function getById( $id ) {
        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM weekly_special WHERE id = :id";
        $st = $conn ->prepare( $sql );
        $st->bindValue( ":id", $id, PDO::PARAM_INT );
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ( $row ) return new WeeklySpecialItem ( $row );
    }

    public static function getWeeklySpecialItemList ( $order = "day" ) {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM weekly_special ORDER BY  :order ";
        $st = $conn->prepare( $sql );
        $st->bindValue( ":order", $order, PDO::PARAM_STR );
        $st->execute();
        $list = array();

        while( $row = $st->fetch() ){
            $weeklySpecialItem = new WeeklySpecialItem( $row );
            $list[] = $weeklySpecialItem;
        }

        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
        return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }

    public function insert() {
        if ( !is_null( $this->id ) ) trigger_error ("WeeklySpecialItem::insert(): Attempt to insert a WeeklySpecialItem object that already has its ID property set to $this->id.", E_USER_ERROR);

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "INSERT INTO weekly_special (day, onScreen, onStereo, onBar, date) VALUES (:day, :onScreen, :onStereo, :onBar, FROM_UNIXTIME(:date))";
        $st = $conn->prepare($sql);
        $st->bindValue(':day', $this->day, PDO::PARAM_INT);
        $st->bindValue(':date', $this->date, PDO::PARAM_INT);
        $st->bindValue(':onScreen', $this->onScreen, PDO::PARAM_STR);
        $st->bindValue('onStereo', $this->onStereo, PDO::PARAM_STR);
        $st->bindValue('onBar', $this->onBar, PDO::PARAM_STR);
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;
    }

    public function update() {
        if ( is_null( $this->id ) ) trigger_error("WeeklySpecialItem::update(): Attempt to update a WeeklySpecialItem object that does not have its ID property set.", E_USER_ERROR);

        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "UPDATE weekly_special SET day=:day, onStereo=:onStereo, onBar=:onBar, onScreen=:onScreen , date=FROM_UNIXTIME(:date) WHERE id=:id";
        $st = $conn->prepare( $sql );
        $st->bindValue(':day', $this->day, PDO::PARAM_INT);
        $st->bindValue(':date', $this->date, PDO::PARAM_INT);
        $st->bindValue(':onScreen', $this->onScreen, PDO::PARAM_STR);
        $st->bindValue(':onStereo', $this->onStereo, PDO::PARAM_STR);
        $st->bindValue(':onBar', $this->onBar, PDO::PARAM_STR);
        $st->execute();
        $conn = null;
    }

    public function delete() {
        if ( is_null($this->id ) ) trigger_error("WeeklySpecialItem::delete(): Attempt to delete a WeeklySpecialItem object that does not have its ID property set", E_USER_ERROR);
        
        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $st = $conn->prepare("DELETE FROM weekly_special WHERE id=:id LIMIT 1");
        $st->bindValue(':id', $this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }
}
