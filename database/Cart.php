
<!-- when we press 'Add to Cart' button, we want to insert product and user_id into cart table -->

<?php 

class Cart {

    public $db = null;

    // initialize db
    public function __construct(DBController $db){
        if (!isset($db->conn)) return null;
        $this->db = $db;
    }

    // insert into cart table
    public function insertIntoCart($params = null, $table = "cart") {
        if($this->db->conn != null){
            if($params!=null) {
                // insert into cart(user_id) values (0)
                // get table columns
                $columns = implode(',', array_keys($params));

                $values = implode(',', array_values($params));

                // create sql query with sprintf( format, arg1, arg2, arg++ )
                $query_string = sprintf("INSERT INTO %s(%s) VALUES(%s)", $table, $columns, $values);
                
                // execute query
                $result = $this->db->conn->query($query_string);
                return $result;
            }       
        }
    }

    // to get user_id and item_id and insert into cart table
    public function addToCart($userid, $itemid){
        if(isset($userid) && isset($itemid)) {
            $params = array(
                'user_id' => $userid,
                'item_id' => $itemid
            );

            // insert data into cart - $_SERVER returns the filename of the currently executing script
            $result = $this->insertIntoCart($params);
            if($result){
                // reload page
                header("Location: ". $_SERVER['PHP_SELF']);
            }
        }
    }

}

?>