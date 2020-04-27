<?php

//a class for dealing with a object comment saving, reading and deleting it from the database
class product_model{
    public $sku, $name, $price, $type, $value1, $dummy, $dummy1, $dummy2;
    function __construct($sku1, $name1, $price1, $type1, $value11) { // constructor for the products
        $this->SKU = $sku1;
        $this->Name = $name1;
        $this->Price = $price1;
        $this->TypeID = $type1;
        $this->Value1 = $value11;
    }
    //returns a list of all products
    public static function all(){
        $list = [];
        $db = Db::getInstance();
        $result = mysqli_query($db,'SELECT * FROM product');
        while($row = mysqli_fetch_assoc($result)){
            $list[] = new product_model($row['SKU'],$row['Name'],$row['Price'],$row['TypeID'],$row['Value1']);
        }
        return $list;
    }
     //returns amount of a product based on SKU
    public static function getamount($id){
        $db = Db::getInstance();
        $sql = "SELECT Value1 FROM product WHERE SKU='$id'";
        $result = mysqli_query($db, $sql);
        $row = $result->fetch_assoc();
        return $row["Value1"]; 
    }
    //Checks if SKU already exists in database
    public static function checkifSKUexsists($id){
        $db = Db::getInstance();
        $sql = "SELECT * FROM product WHERE SKU='$id'";
        $result = mysqli_query($db, $sql);
        if ($result->num_rows>0) return true;
        else return false;
    } 
    //deletes products based on their SKU
    public static function delete($list){ 
        $db = Db::getInstance();
        $rowCount = count($list);
        for($i=0;$i<$rowCount;$i++){
            //if amount of the product is 1, deletes entire row of table "product"
            //all foreign keys are deleted automatically (sql script included 'ON DELETE CASCADE')
            if(product_model::getamount($list[$i])==1){
                $del_id = $list[$i];
                $sql = "DELETE FROM product WHERE SKU='$del_id'";
                $result = mysqli_query($db, $sql);
            //if amount of the product is more than 1, updates table "product" by reducing amount (column Value1) by 1
			} else {
                $del_id = $list[$i];
                $newvalue=product_model::getamount($list[$i])-1;
                $sql = "UPDATE product SET Value1='$newvalue' WHERE SKU='$del_id'";
                $result = mysqli_query($db, $sql);
			}
        }
        return true;
    }
    //inserts product in database
    public static function add( $sku, $name, $price, $type, $dummy, $dummy1, $dummy2) {
        $db = Db::getInstance();
        $result = mysqli_query($db,"Insert into product ( SKU, Name, Price, TypeID, Value1) Values ( '$sku', '$name', '$price', '$type', '1')");
        $id=mysqli_insert_id($db);
        return true;
    }
    
 }

class dvd extends product_model { // child class that adds a dvd attribute to the object
    public $size,  $dummy, $dummy1, $dummy2 ;
    function __construct($sku1, $name1, $price1, $type1, $value11,  $size1) {
        parent::__construct($sku1, $name1, $price1, $type1, $value11);
        $this->SKUID = $sku1;
        $this->Size = $size1;
    }
    //prints dvd' special attribute
    public static function print($sku1){
        $db = Db::getInstance();
        $result = mysqli_query($db,"SELECT * FROM `dvd` WHERE `SKUID` = '$sku1'");
        $row = $result->fetch_assoc();
        echo "Size: ".$row["Size"]." MB";
    }
    //checks if submitted product exsists in database, all values have to match
    public static function checkifproductexists($SKU, $Name, $Price, $value1){
        $db = Db::getInstance();
        $result = mysqli_query($db,"SELECT * FROM product INNER JOIN dvd ON product.SKU = dvd.SKUID
                                    WHERE 
                                        product.SKU =  '$SKU' AND
                                        product.Name =  '$Name' AND
                                        product.Price =  '$Price' AND
                                        dvd.Size =  '$value1'");
        if ($result->num_rows>0) return true;
        else return false;
    }
    //inserts dvd in database
    public static function add($sku, $name, $price, $type, $size, $dummy, $dummy1) {
        //if product already exists, amount is increased by 1, no new rows are added
        if(dvd::checkifproductexists($sku, $name, $price, $size)){
            $db = Db::getInstance();
            $newvalue=product_model::getamount($sku)+1;
            $sql = "UPDATE product SET Value1='$newvalue' WHERE SKU='$sku'";
            $result = mysqli_query($db, $sql);
        //if product doesn't exist
		}else{
            //checks if sku exists already in database
            if(product_model::checkifSKUexsists($sku)) return false;
            //if sku doesn't exist, a new row is added
            parent::add($sku, $name, $price, $type, null, null, null);
            $db = Db::getInstance();
            $result = mysqli_query($db,"Insert into dvd (SKUID, Size ) Values ('$sku', '$size')");
            $id=mysqli_insert_id($db);   
		} 
        return true;
    }
}

class book extends product_model { 
    public $weight,  $dummy, $dummy1, $dummy2; 
    function __construct($sku1, $name1, $price1, $type1, $value11, $weight1) {
        parent::__construct($sku1, $name1, $price1, $type1, $value11);
        $this->SKUID = $sku1;
        $this->Weight = $weight1;
    }
    public static function all(){
        $list = [];
        $db = Db::getInstance();
        $result = mysqli_query($db,'SELECT * FROM product s inner join book c on c.SKUID = s.SKU inner join type b on b.ID = s.TypeID');
        while($row = mysqli_fetch_assoc($result)){
            $list[] = new book($row['s.SKU'],$row['s.Name'],$row['s.Price'],$row['s.TypeID'],$row['s.Value1'],$row['c.Weight']);
        }
        return $list;
    }
    public static function print($sku1){
        $db = Db::getInstance();
        $result = mysqli_query($db,"SELECT * FROM `Book` WHERE `SKUID` = '$sku1'");
        $row = $result->fetch_assoc();
        echo  "Weight: ".$row["Weight"]." KG"; 
    }   

    public static function checkifproductexists($SKU, $Name, $Price, $value1){
        $db = Db::getInstance();
        $result = mysqli_query($db,"SELECT * FROM product INNER JOIN book ON product.SKU = book.SKUID
                                    WHERE 
                                    product.SKU =  '$SKU' AND
                                    product.Name =  '$Name' AND
                                    product.Price =  '$Price' AND
                                    book.Weight =  '$value1'");
        if ($result->num_rows>0) return true;
        else return false;
    }

    public static function add($sku, $name, $price, $type, $size, $dummy, $dummy1) {
        if(book::checkifproductexists($sku, $name, $price, $size)){

            $db = Db::getInstance();
            $newvalue=product_model::getamount($sku)+1;
            $sql = "UPDATE product SET Value1='$newvalue' WHERE SKU='$sku'";
            $result = mysqli_query($db, $sql);
		} else{
            if(product_model::checkifSKUexsists($sku)) return false;
            parent::add($sku, $name, $price, $type, null, null, null);
            $db = Db::getInstance();
            $result = mysqli_query($db,"Insert into book (SKUID, Weight ) Values ('$sku', '$size')");
            $id=mysqli_insert_id($db); 
		} 
        return true;
    }
}

class furniture extends product_model { 
    public $h, $w, $l;
    function __construct($sku1, $name1, $price1, $type1, $value11, $h1, $w1, $l1) {
        parent::__construct($sku1, $name1, $price1, $type1, $value11);
        $this->SKUID = $sku1;
        $this->Height = $h1;
        $this->Width = $w1;
        $this->Length = $l1;
    }
    public static function all(){
   
        $list = [];
        $db = Db::getInstance();
        $result = mysqli_query($db,'SELECT * FROM product s inner join furniture c on c.SKUID = s.SKU inner join type b on b.ID = s.TypeID');
        while($row = mysqli_fetch_assoc($result)){
            $list[] = new furniture($row['s.SKU'],$row['s.Name'],$row['s.Price'],$row['s.TypeID'],$row['s.Value1'],$row['c.Height'],$row['c.Width'],$row['c.Size']);
        }
        return $list;
    }
    public static function print($sku1){
        $db = Db::getInstance();
        $result = mysqli_query($db,"SELECT * FROM `furniture` WHERE `SKUID` = '$sku1'");
        $row = $result->fetch_assoc();
        echo "Dimension: ".$row["Height"]."x".$row["Width"]."x".$row["Length"];
    }

    public static function checkifproductexists($SKU, $Name, $Price, $value1,$value2,$value3 ){
        $db = Db::getInstance();
        $result = mysqli_query($db,"SELECT * FROM product INNER JOIN furniture ON product.SKU = furniture.SKUID
                                WHERE 
                                    product.SKU =  '$SKU' AND
                                    product.Name =  '$Name' AND
                                    product.Price =  '$Price' AND
                                    furniture.Height =  '$value1' AND
                                    furniture.Width =  '$value2' AND
                                    furniture.Length =  '$value3'");
        if ($result->num_rows>0) return true;
        else return false;
    }
    public static function add($sku, $name, $price, $type, $value1,$value2,$value3) {
        if(furniture::checkifproductexists($sku, $name, $price, $value1,$value2,$value3)){
            $db = Db::getInstance();
            $newvalue=product_model::getamount($sku)+1;
            $sql = "UPDATE product SET Value1='$newvalue' WHERE SKU='$sku'";
            $result = mysqli_query($db, $sql);
		} else{
            if(product_model::checkifSKUexsists($sku)) return false;
            parent::add($sku, $name, $price, $type, null, null, null);
            $db = Db::getInstance();
            $result = mysqli_query($db,"Insert into  furniture (SKUID,  Height, Width, Length ) Values ('$sku',  '$Height', '$Width', '$Length')");
            $id=mysqli_insert_id($db); 
		} 
        return true; 
    }
}
class type extends product_model { // subclass that adds a type attribute to the object
    public $typeid, $typename; 
    function __construct( $typeid1, $typename1) {
        $this->ID = $typeid1;
        $this->TypeName = $typename1;
    }
    //list of all types
    public static function all(){
        $list = [];
        $db = Db::getInstance();
        $result = mysqli_query($db,'SELECT * FROM type');
        while($row = mysqli_fetch_assoc($result)){
            $list[] = new type($row['ID'],$row['TypeName']);
        }
        return $list;
    }
    //get type name by id
    public static function determinename($sku1){
        $db = Db::getInstance();
        $result = mysqli_query($db,"SELECT * FROM type WHERE '$sku1' = ID");
        $row = $result->fetch_assoc();
        return $row["TypeName"];     
    }
    //get type id by name
    public static function determineid($name){
        $db = Db::getInstance();
        $result = mysqli_query($db,"SELECT * FROM type WHERE '$name' = TypeName");
        $row = $result->fetch_assoc();
        return $row["ID"];     
    }     
}

?>