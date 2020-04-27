<!DOCTYPE html>
<html lang="en">
    <head>
	    <title>Add Product</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="view/css/stylesadd.css"> 
    </head>
    <body>
        <form id="productForm" action="index.php?controller=product&action=add" method="POST">
            <div class="flex-container">
                <div style="display:flex; justify-content:flex-start; width:100%;" ><h2>Product Add</h2></div>
                <div  style="display:flex; justify-content:flex-end; width:100%; ">
                    <button class="btn btn-primary btn-add" input type="submit" value="Submit" >Add </button> </div>  
                </div>
            
            <div class="row2">
                <!-- Input forms -->
                <input type="hidden" name="destination" value="<?php echo $_SERVER["REQUEST_URI"]; ?>"/>
               
                <div class="form-group row">
                    <label for="SKU" class="col-sm-2 col-form-label">SKU</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="SKU" name="SKU" placeholder="SKU" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="Name" name="Name" placeholder="Name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="Price" class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-10">
                      <input type="number" min="0" class="form-control" id="Price"name="Price" placeholder="Price" required>
                    </div>
                </div>
                <!-- I wanted to add here form "amount" in case user wants to add multiple identical products, 
                but the example didn't have form like that -->
                <div class="form-group row">
                    <label for="Type" class="col-sm-2 col-form-label">Type</label>
                    <div class="col-sm-10">
                        <?php
                            //generates dropdown of possible product types. Types are already provided in database
                        if (!empty($types)){
                            echo '<select class="custom-select mr-sm-2" id="Type"name="Type">';
                            foreach ($types as $type) {
       	                        echo '<option>'. $type->TypeName.'</option>';
                            }
                            echo '</select>';
                        }
                        ?>
                    </div>
                </div>

                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>  
                <script> 
                   $('.required').prop('required', function(){
                       return  $(this).is(':visible');
                    });

                    //code that allows to show forms if something is selected in "Type" dropdown
                    $(document).ready(function(){
                        $("#Type").change(function(){
                        var url =  $(this).children(":selected").text(); //get the selected option value
                        switch (url) {
                            case "Book":
                                $('#TypeBook').show();
                                $('#TypeDVD').hide();
                                $('#TypeDVD :input').removeAttr('required');  
                                $('#TypeFurniture').hide();
                                $('#TypeFurniture :input').removeAttr('required');  
                            break;
                            case "DVD-disc":
                                $('#TypeBook').hide();
                                $('#TypeBook :input').removeAttr('required');  
                                $('#TypeDVD').show();
                                $('#TypeFurniture').hide();
                                $('#TypeFurniture :input').removeAttr('required');  
                            break;
                            case "Furniture":
                                $('#TypeBook').hide();
                                $('#TypeBook :input').removeAttr('required');  
                                $('#TypeDVD').hide();
                                $('#TypeDVD :input').removeAttr('required');  
                                $('#TypeFurniture').show();
                            break;
                            default:
                                $("#Types").attr('action', '#');
                            }
                        }); 
                    }); 
                </script>
                <!-- Input forms, hidden at first -->
                <div id="TypeDVD">
                    <div class="form-group row"  >
                        <label for="Size" class="col-sm-2 col-form-label">Size</label>
                        <div class="col-sm-10">
                          <input type="number" min="1" class="form-control" id="Size"name="Size" placeholder="Size" required>
                        </div>
                         <small id="bookHelp" class="col-sm-12 form-text text-muted">Please provide size in megabytes (MB). Size must be greater than 0.</small>
                    </div>
                </div>
                <div id="TypeBook">
                    <div class="form-group row">
                        <label for="Weight" class="col-sm-2 col-form-label">Weight</label>
                        <div class="col-sm-10">
                          <input type="number" min="1" class="form-control" id="Weight"name="Weight" placeholder="Weight"required>
                        </div>
                        <small id="bookHelp" class="col-sm-12 form-text text-muted">Please provide weight in kilograms (Kg). Weight must be greater than 0.</small>
                    </div>
                </div>
                <div id="TypeFurniture">
                    <div class="form-group row">
                        <label for="Height" class="col-sm-2 col-form-label">Height</label>
                        <div class="col-sm-10">
                          <input type="number" min="1" class="form-control" id="Height" name="Height" placeholder="Height" required >
                        </div>
                        <label for="Width" class="col-sm-2 col-form-label">Width</label>
                        <div class="col-sm-10">
                          <input type="number" min="1" class="form-control" id="Width"name="Width" placeholder="Width"required>
                        </div>
                        <label for="Length" class="col-sm-2 col-form-label">Length</label>
                        <div class="col-sm-10">
                          <input type="number" min="1" class="form-control" id="Length"name="Length" placeholder="Length"required>
                        </div>
                        <small id="furnitureHelp" class="col-sm-12 form-text text-muted">Please provide dimensions in HxWxL format. All values must be greater than 0.</small>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>
