<?php
/**
 * Created by Luis Pizarro
 * Date: 02/03/12
 * Time: 5:37 PM
 * Purpose: 
 */
 
class DrinkCollectionItem {
    public $id = null;
    public $name = null;
    public $origin = null;
    public $price = null;
    public $isOnTap = null;
    public $isOffsale = null;
    public $isBottleCans = null;
    public $isHouse = null;
    public $legend = null;
    public $type = null;
    public $date = null;

    public function __construct( $data=array()) {
        if( isset( $data['id'] ) ) $this->id = (int) $data['id'];
        if( isset( $data['name'] ) ) $this->name = $data['name'];
        if( isset( $data['origin'] ) ) $this->origin = $data['origin'];
        if( isset( $data['price'] ) ) $this->price = (int) $data['price'];
        if( isset( $data['isOnTap'] ) ) $this->isOnTap = $data['isOnTap'];
        if( isset( $data['isOffsale'] ) ) $this->isOffsale = $data['isOffsale'];
        if( isset( $data['isBottleCans'] ) ) $this->isBottleCans = $data['isBottleCans'];
        if( isset( $data['isHouse'] ) ) $this->isHouse = $data['isHouse'];
        if( isset( $data['legend'] ) ) $this->legend = $data['legend'];
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
        $sql = "SELECT * FROM drink_collection WHERE id = :id";
        $st = $conn->prepare( $sql );
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ( $row ) return new DrinkCollectionItem( $row );
    }

    public static function getDrinkCollectionItemList ( $numRows=1000 , $order=" name ") {
        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM drink_collection ORDER BY".$order."LIMIT :numRows";
        $st = $conn->prepare( $sql );
        $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
        $st->execute();
        $list = array();

        while ( $row = $st->fetch() ) {
            $drinkCollectionItem = new DrinkCollectionItem( $row );
            $list[] = $drinkCollectionItem;
        }

        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
        return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }

    public static function secondQueryForPagination( $max , $order=" name "){
        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM drink_collection ORDER BY".$order."$max";
        $st = $conn->prepare( $sql );
        //$st->bindValue( ":max", $max, PDO::PARAM_INT);
        $st->execute();
        $data_p = array();

        while ( $row = $st->fetch() ) {
            $drinkCollectionItem = new DrinkCollectionItem( $row );
            $data_p[] = $drinkCollectionItem;
        }
        return $data_p;
    }

    public function insert() {
        if ( !is_null( $this->id ) ) trigger_error ("DrinkCollectionItem::insert(): Attempt to insert a Drink Collection Item object that already has its ID property set (to $this->id).", E_USER_ERROR);

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO drink_collection ( name, origin, price, isOnTap, isOffsale, isBottleCans, isHouse, legend, type, date) VALUES (:name, :origin, :price, :isOnTap, :isOffsale, :isBottleCans, :isHouse, :legend, :type, :date)";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":name", $this->name, PDO::PARAM_STR);
        $st->bindValue( ":origin", $this->origin, PDO::PARAM_STR);
        $st->bindValue( ":price", $this->price, PDO::PARAM_INT);
        $st->bindValue( ":isOnTap", $this->isOnTap, PDO::PARAM_INT);
        $st->bindValue( ":isOffsale", $this->isOffsale, PDO::PARAM_INT);
        $st->bindValue( ":isBottleCans", $this->isBottleCans, PDO::PARAM_INT);
        $st->bindValue( ":isHouse", $this->isHouse, PDO::PARAM_INT);
        $st->bindValue( ":legend", $this->legend, PDO::PARAM_STR);
        $st->bindValue( ":type", $this->type, PDO::PARAM_STR);
        $st->bindValue( ":date", $this->date, PDO::PARAM_INT);
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;
    }

    public function update() {

        if ( is_null( $this->id ) ) trigger_error( "DrinkCollectionItem::update(): Attempt to update a Drink Collection Item object that does not have its ID property set.", E_USER_ERROR);

        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "UPDATE drink_collection SET name=:name, origin=:origin, price=:price, isOnTap=:isOnTap, isOffsale=:isOffsale, isBottleCans=:isBottleCans, isHouse=:isHouse, legend=:legend, type=:type, date=:date WHERE id=:id";
        $st = $conn->prepare( $sql );
        $st->bindValue( ":name", $this->name, PDO::PARAM_STR);
        $st->bindValue( ":origin", $this->origin, PDO::PARAM_STR);
        $st->bindValue( ":price", $this->price, PDO::PARAM_INT);
        $st->bindValue( ":isOnTap", $this->isOnTap, PDO::PARAM_INT);
        $st->bindValue( ":isOffsale", $this->isOffsale, PDO::PARAM_INT);
        $st->bindValue( ":isBottleCans", $this->isBottleCans, PDO::PARAM_INT);
        $st->bindValue( ":isHouse", $this->isHouse, PDO::PARAM_INT);
        $st->bindValue( ":legend", $this->legend, PDO::PARAM_STR);
        $st->bindValue( ":type", $this->type, PDO::PARAM_STR);
        $st->bindValue( ":date", $this->date, PDO::PARAM_INT);
        $st->bindValue( ":id", $this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

//    public function printOut() {
//        $file = 'dumpTEST.php';
//        $somecontent = print_r($this, TRUE);
//        // open file
//        $fp = fopen($file, 'w') or die('Could not open file!');
//        // write to file
//        fwrite($fp, "$somecontent") or die('Could not write to file');
//        // close file
//        fclose($fp);
//    }

    public function delete() {
         if ( is_null( $this->id ) ) triger_error ("DrinkCollectionItem::delete(): Attempt to delete a Drink Collection Item object that does not have its ID property set.", E_USER_ERROR);

        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $st = $conn->prepare( "DELETE FROM drink_collection WHERE id = :id LIMIT 1" );
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }
}
