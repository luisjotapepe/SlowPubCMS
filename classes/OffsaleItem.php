<?php
/**
 * Created by Luis Pizarro
 * Date: 02/03/12
 * Time: 5:24 PM
 * Purpose: 
 */
 
class OffsaleItem {
    public $id = null;
    public $name = null;
    public $price = null;
    public $date = null;

    public function __construct( $data=array()) {
        if( isset( $data['id'] ) ) $this->id = (int) $data['id'];
        if( isset( $data['name'] ) ) $this->name = $data['name'];
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
        $sql = "SELECT *, UNIX_TIMESTAMP(date) AS date FROM offsale_prices WHERE id = :id";
        $st = $conn->prepare( $sql );
        $st->bindValue( ':id', $id, PDO::PARAM_INT );
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ( $row ) return new OffsaleItem( $row );
    }

    public static function getOffsaleItemList ( $numRows=1000000 ) { //i didnt specify order for the list.
        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(date) AS date FROM offsale_prices LIMIT :numRows";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ':numRows', $numRows, PDO::PARAM_INT );
        $st->execute();
        $list = array();

        while ( $row = $st->fetch() ) {
            $offsaleItem = new OffsaleItem( $row );
            $list[] = $offsaleItem;
        }

        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
        return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }

    public function insert() {
        if ( !is_null( $this->id ) ) trigger_error ("OffsaleItem::insert(): Attempt to insert an OffsaleItem object that already has its ID property set (to $this->id).", E_USER_ERROR);

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO offsale_prices ( date, name, price) VALUES ( FROM_UNIXTIME(:date), :name, :price )";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ':name', $this->name, PDO::PARAM_STR);
        $st->bindValue( ':price', $this->price, PDO::PARAM_INT);
        $st->bindValue( ':date', $this->date, PDO::PARAM_INT);
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;
    }

    public function update() {
        if ( is_null( $this->id ) ) trigger_error ("OffsaleItem::update(): Attempt to update a OffsaleItem object that does not have its ID property set.", E_USER_ERROR);

        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "UPDATE offsale_prices SET name=:name, price=:price, date=FROM_UNIXTIME(:date) WHERE id = :id";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ':name', $this->name, PDO::PARAM_STR );
        $st->bindValue( ':price', $this->price, PDO::PARAM_INT );
        $st->bindValue( ':date', $this->date, PDO::PARAM_INT);
        $st->bindValue( ':id',$this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

    public function delete() {
        if ( is_null( $this->id ) ) trigger_error ("OffsaleItem::delete(): Attempt to delete an OffsaleItem object that does not have its ID property set.", E_USER_ERROR);

        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $st = $conn->prepare ( "DELETE FROM offsale_prices WHERE id = :id LIMIT 1" );
        $st->bindValue( ':id', $this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

    public function convert_type( $price ) {
        if( is_numeric( $price ) )
            return abs($price);
    }

    public function printOut() {
        $file = 'dumpTEST.php';
        $someContent = print_r($this, TRUE);
        // open file
        $fp = fopen($file, 'w') or die('Could not open file!');
        // write to file
        fwrite($fp, "$someContent") or die('Could not write to file');
        // close file
        fclose($fp);
    }
}
