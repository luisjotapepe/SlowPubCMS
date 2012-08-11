<?php
/**
 * Created by Luis Pizarro
 * Date: 02/03/12
 * Time: 5:04 PM
 * Purpose: 
 */
 
class SupplierItem {
    public $id = null;
    public $name = null;
    public $description = null;
    public $url = null;
    public $picture = null;
    public $date = null;

    public function __construct( $data=array()) {
        if( isset( $data['id'] ) ) $this->id = (int) $data['id'];
        if( isset( $data['name'] ) ) $this->name = $data['name'];
        if( isset( $data['description'] ) ) $this->description = preg_replace ("[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]","", $data['description'] );
        if( isset( $data['url'] ) ) $this->url = $data['url'];
        if( isset( $data['picture'] ) ) $this->picture = $data['picture'];
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
        $sql = "SELECT * FROM suppliers WHERE id = :id";
        $st = $conn->prepare( $sql );
        $st->bindValue( ':id', $id, PDO::PARAM_INT );
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ( $row ) return new SupplierItem( $row );
    }

    public static function getSupplierItemList ( $numRows=1000000 ) { //i didn't specify order for the list.
        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM suppliers LIMIT :numRows";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ':numRows', $numRows, PDO::PARAM_INT );
        $st->execute();
        $list = array();

        while ( $row = $st->fetch() ) {
            $supplierItem = new SupplierItem( $row );
            $list[] = $supplierItem;
        }

        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query( $sql )->fetch();
        $conn = null;
        return ( array ( "results" => $list, "totalRows" => $totalRows[0] ) );
    }

    public function insert() {
        if ( !is_null( $this->id ) ) trigger_error ("SupplierItem::insert(): Attempt to insert a Supplier Item object that already has its ID property set (to $this->id).", E_USER_ERROR);

        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO suppliers ( date, name, description, url, picture) VALUES ( FROM_UNIXTIME(:date), :name, :description, :url, :picture )";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ':name', $this->name, PDO::PARAM_STR);
        $st->bindValue( ':description', $this->description, PDO::PARAM_STR);
        $st->bindValue( ':url', $this->url, PDO::PARAM_STR);
        $st->bindValue( ':date', $this->date, PDO::PARAM_INT);
        $st->bindValue( ':picture', $this->picture, PDO::PARAM_STR);
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;
    }

    public function update() {
        if ( is_null( $this->id ) ) trigger_error ("Supplier Item::update(): Attempt to update a Supplier Item object that does not have its ID property set.", E_USER_ERROR);

        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "UPDATE suppliers SET name=:name, description=:description, url=:url, picture=:picture, date=FROM_UNIXTIME(:date) WHERE id = :id";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ':name', $this->name, PDO::PARAM_STR );
        $st->bindValue( ':description', $this->description, PDO::PARAM_STR );
        $st->bindValue( ':url', $this->url, PDO::PARAM_STR);
        $st->bindValue( ':picture', $this->picture, PDO::PARAM_STR);
        $st->bindValue( ':id',$this->id, PDO::PARAM_INT);
        $st->bindValue( ':date',$this->date, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

    public function delete() {

        if ( is_null( $this->id ) ) trigger_error ("SupplierItem::delete(): Attempt to delete a Supplier Item object that does not have its ID property set.", E_USER_ERROR);

        $conn = new PDO ( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $st = $conn->prepare ( "DELETE FROM suppliers WHERE id = :id LIMIT 1" );
        $st->bindValue( ':id', $this->id, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

    public static function checkURL($url){
        if (!preg_match("#^http(s)?://[a-z0-9-_.]+\.[a-z]{2,4}#i",$url)) {
            return 1;   // returns 1 if url is invalid
        } else {
            return 0;   //otherwise returns 0 for valid input
        }
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
