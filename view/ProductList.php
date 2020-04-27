<!DOCTYPE html>
<html>
    <head>
        <title>Product List</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
		<link rel="stylesheet" href="view/css/styles.css">      
    </head>
    <body>
        <div class="flex-container">
            <div style="display:flex; justify-content:flex-start; width:100%;" >
                <h2>Product List</h2>
            </div>
            <a href="index.php?controller=product&action=addPage">
                <button class="btn btn-primary btn-add" >Add Product</button>
            </a>
        </div> 
        <div class="line"> </div> 

        <form action="index.php?controller=product&action=delete" method="post">

            <?php 
            if (!empty($products)){
                foreach($products as $product){} ?>
            <div class="flex-container row1 ">
                <div  style="display:flex; justify-content:flex-start; width:100%;" >
                    <input type="checkbox"  id="select_all"/>
                </div>
                    <a href="index.php?controller=product&action=delete&SKU=<?php echo $product->SKU; ?> ">
                        <button class="btn btn-primary btn-add" name="delete" type="submit" id="delete" >Delete </button>
                    </a>
            </div> 
            <?php } ?>

            <div>
                <div class="row" id="container">
                    <?php 
                    if (!empty($products)){
                        foreach ($products as $product) {
                            for ($i = 0; $i <  $product->Value1; $i++){ ?>
                                <div class="card text-center" style="width: 10rem;">
                                    <div class="form-check">
                                        <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $product->SKU; ?>" >
                                    </div>
                                    <div class="SKU">
                                        <?php echo $product->SKU; ?>
                                    </div>
                                    <div class="Name">
                                        <?php echo $product->Name; ?>
                                    </div>
                                    <div class="Price">
                                        <?php echo $product->Price." $"; ?>
                                    </div>
                                    <div class="Size">
                                        <?php
                                        if(type::determinename($product->TypeID)=='DVD-disc') {
                                            echo dvd::print($product->SKU);  
                                        } else if(type::determinename($product->TypeID)=='Book') {
                                            echo book::print($product->SKU); 
                                        }else{
                                            echo furniture::print($product->SKU); 
                                        }
                                        ?>
                                    </div>
                                </div>  
                            <?php
                            }
                        }
                    } else { ?>
                        <div class="flex-container row1 empty"><p>0 Results</p></div>
                    <?php
                    } ?>  
                </div> 
            </div> 
        </form>
        <script src="view/js/main.js"></script>
    </body>
</html>