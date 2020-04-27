<?php


class product{
 
    //return all the products
    function all(){
        //use the model to get all the products from the database
        $products=product_model::all();
        $types=type::all();
        require_once("view/ProductList.php");
    }

    //delete a product
    function delete(){
        //if at least 1 checkbox was selected
        if(isset($_POST["checkbox"])){
            //count of selected checkboxes, used only to customize message
            $rowCount = count($_POST["checkbox"]); 
            if($rowCount>0){
                product_model::delete($_POST["checkbox"]);
                if($rowCount>1){
                    echo "<script>
                        var message = '$rowCount products deleted';
		                alert(message);
		                window.location.href='index.php?controller=product&action=all';
	                    </script>";   
				}else{
                    echo "<script>
                        var message = 'Product deleted';
		                alert(message);
		                window.location.href='index.php?controller=product&action=all';
	                    </script>";   
				}   
            }
        //if at none of checkboxes were selected
		}else{
            echo "<script>
                    var message = 'Please select at least 1 product';
		            alert(message);
		            window.location.href='index.php?controller=product&action=all';
	                </script>";           
		}  
    }
    //redirect to Add page
    public static function addPage( ) {
        $types=type::all();
        require_once("view/ProductAdd.php");
    }
    //add a product
    function add(){
        //read the data send over post method
        if(isset($_POST['SKU'], $_POST['Name'], $_POST['Price'], $_POST['Type'])) {
            $SKU = $_POST["SKU"];
            $Name = $_POST["Name"];
            $Price = $_POST["Price"];
            $dvd=true;
            $book=true;
            $furniture=true;
            $TypeID = type::determineid($_POST['Type']);
            //if size was submitted
            if(isset($_POST['Size'])&&!empty($_POST['Size'])){
                $Size=$_POST["Size"];
                //add a new dvd using the model
                $dvd = dvd::add( $SKU, $Name, $Price, $TypeID, $Size, Null, null);
			}
            //if weight was submitted
            if (isset($_POST['Weight'])&&!empty($_POST['Weight'])){
                $Weight=$_POST['Weight'];
                $book = book::add( $SKU, $Name, $Price, $TypeID, $Weight, null, null);
			}
            //if dimensions were submitted
            if (isset($_POST['Height'], $_POST['Width'], $_POST['Length'])&&!empty($_POST['Height'])&&!empty($_POST['Width'])&&!empty($_POST['Length']))
            {
                $Height=$_POST["Height"];
                $Width=$_POST["Width"];
                $Length=$_POST["Length"];
                $furniture = furniture::add( $SKU, $Name, $Price, $TypeID, $Height, $Width, $Length);
			}
            //if submitted SKU exists already, but rest of the data doesn't match
            if($dvd==false||$book==false||$furniture==false)  {
                echo "<script>
                    var message = 'SKU already exists in database';
		            alert(message);
		            window.location.href='javascript:history.go(-1)';
	                </script>";   
            }
            if($dvd==true&&$book==true&&$furniture==true)
            echo "<script>
                var message = 'Product added';
		        alert(message);
		        window.location.href='index.php?controller=product&action=all';
	            </script>";   
            
        }
    }
}
?>