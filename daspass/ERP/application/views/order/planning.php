<style>
.chosen-container{width: 100% !important}
input.default{width: 100% !important}
</style>
<link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/chosen/chosen.css">
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Purchase Management
            <small><?php echo ucfirst($this->router->fetch_method()); ?> Purchase</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="<?php echo base_url('purchase'); ?>"><i class="fa fa-role"></i> Purchase Management</a></li>
            <li class="active"> <?php echo ucfirst($this->router->fetch_method()); ?> Purchase</li>
        </ol>
    </section>
    <form role="form" id="purchaseForm" class="form-horizontal" name="purchaseForm" action="<?php echo $form_action;?>" method="post" enctype="multipart/form-data">
    <!-- Main content -->
    <section class="content">
        <div><a href="javascript:window.history.back();" class="btn btn-danger btn-lg">Back</a></div>
        <div class="box">
            <div class="box-body">
                <fieldset>
                    <legend>Orders Detail</legend>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ORDER_ID">Order<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="ORDER_ID" class="form-control chosen-select" name="ORDER_ID" required>
                                <option value="">Select Order</option>
                                <?php foreach ($orders as $order) { ?>
                                <option value='<?php echo $order->ID; ?>' <?php echo (isset($order->ORDER_ID) && $order->ID == $order->ORDER_ID) ? "selected=selected":"";?> data-order_json='<?php echo json_encode($order); ?>'>
                                    <?php echo $order->ID." - ".$order->CUSTOMER_NAME; ?></option>
                                <?php } ?>
                            </select>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CUSTOMER_NAME">CUSTOMER_NAME<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="CUSTOMER_NAME" class="form-control" type="text" name="CUSTOMER_NAME" value="" required maxlength="100" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CUSTOMER_ADDRESS">CUSTOMER_ADDRESS<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="CUSTOMER_ADDRESS" class="form-control" type="text" name="CUSTOMER_ADDRESS" value="" required readonly/>
                        </div>
                    </div>
                    
                </fieldset>
                <legend>Product Details</legend>
                <fieldset id="Product"></fieldset>
                <!--legend>Item Details</legend>
                
                    <table>
                        <th>Material Name</th>
                        <th>Unit</th>
                        <th>Quantity In Store</th>
                        <th>Quantity</th>
                        
                        <td><select id="MATERIAL_ID" class="form-control chosen-select MATERIAL_ID" name="MATERIAL_ID[]" required>
                                <option value="">Select Material</option>
                                <?php foreach ($materials as $material) { ?>
                                <option value='<?php echo $material->ID; ?>' <?php echo (isset($purchaseMaterial->ID) && $material->ID == $purchaseMaterial->MATERIAL_ID) ? "selected=selected":"";?> data-material_json='<?php echo json_encode($material); ?>'>
                                    <?php echo $material->ITEM_NAME; ?></option>
                                <?php } ?>
                            </select>
                             <input class="form-control ITEM_NAME" type="hidden" name="ITEM_NAME[]" value="<?php echo (isset($purchase->ITEM_NAME)) ? $purchase->ITEM_NAME:'';?>" required maxlength="200"/></td>
                        <td><input class="form-control UOM" type="text" name="UOM[]" value="" required readonly/></td>
                        <td><input class="form-control STORE_QUANTITY" type="text" name="STORE_QUANTITY[]" value="" required readonly/></td>
                        <td><input class="form-control QUANTITY" type="text" name="QUANTITY[]" value="<?php echo (isset($purchase->QUANTITY)) ? $purchase->QUANTITY:'';?>" required maxlength="50"/></td>
                    </table-->
                
                <fieldset id="Item">
                    <legend>Item Detail</legend>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="MATERIAL_ID">Material Name<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="MATERIAL_ID" class="form-control chosen-select MATERIAL_ID" name="MATERIAL_ID[]" required>
                                <option value="">Select Material</option>
                                <?php foreach ($materials as $material) { ?>
                                <option value='<?php echo $material->ID; ?>' <?php echo (isset($purchaseMaterial->ID) && $material->ID == $purchaseMaterial->MATERIAL_ID) ? "selected=selected":"";?> data-material_json='<?php echo json_encode($material); ?>'>
                                    <?php echo $material->ITEM_NAME; ?></option>
                                <?php } ?>
                            </select>
                             <input class="form-control ITEM_NAME" type="hidden" name="ITEM_NAME[]" value="<?php echo (isset($purchase->ITEM_NAME)) ? $purchase->ITEM_NAME:'';?>" required maxlength="200"/>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">Unit<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control UOM" type="text" name="UOM[]" value="" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">Quantity In Store<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control STORE_QUANTITY" type="text" name="STORE_QUANTITY[]" value="" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">Quantity<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control QUANTITY" type="text" name="QUANTITY[]" value="<?php echo (isset($purchase->QUANTITY)) ? $purchase->QUANTITY:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                </fieldset>

                <button id="add-more-item" class="btn-primary" style="margin-top:20px;">Add More Item</button>
            </div>

        </div>
        <div class="box-footer">
            <button id="btnSubmit" type="submit" class="btn btn-primary">Save</button>
            <a href="<?php echo base_url('purchase'); ?>" class="btn btn-danger">Cancel</a>
        </div>
        <div id='line-example'></div>
    </section>
    <!-- /.content -->
    </form>
</aside><!-- /.right-side -->
<script src="<?php echo BASE_PATH; ?>assets/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    $('document').ready(function() {
        /*-------------------------- Form Validation -------------------------*
        $.validator.addMethod('contentIds', function(value) {
            var contents = /^[0-9,]*$/;    
            return value.match(contents);
        }, 'Invalid Content Ids');
	
        $("#purchaseForm").validate({
            rules: {
                    contentId: {
                        contentIds: true
                    }
            },
            invalidHandler: function(event, validator) {
                // 'this' refers to the form
                var errors = validator.numberOfInvalids();
                if (errors) {
                var message = errors == 1
                    $('#myModal').modal('hide');
                } else {
                //$("div.error").hide();
                }
            }
        });
        /*--------------------------------------------------------------------*/
    });
    
     $( "#sortable" ).on( "sortupdate", function( event, ui ) {
        //console.log(ui);
        //updatePurchase();
    } );
   
    
    /*-------------------- Chose plugin for searchable dropdown --------------*/
    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
        '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    /*------------------------------------------------------------------------*/
    /*------------------------ Image Preview ---------------------------------*/
    $("#purchaseForm").on('change','#purchase_image',function () {
        //alert('changed');
        var files = this.files[0];
        var reader = new FileReader();
        var img = new Image();
        reader.onload = function (e) {
            img.onload = function () {
                $('#imagePreview').html($('<img>').attr('src',e.target.result));
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(files);
    });
    /*------------------------------------------------------------------------*/
    $("document").ready(function() {
        $('.inventory').on('change', function () {
            var selectVal = $("option:selected", this).data('unit');
            //console.log($(this).siblings(".inventory-unit"));
            $(this).parent().siblings(".inventory-unit").html(selectVal);
        });
        $("#add-more-item").click(function(){
            $(".chosen-select").chosen('destroy');
            var newItem = $("#Item").clone().find("input:text").val("").end().append('<button id="add-more-item" class="btn-danger remove-item">Remove Item</button>');
            //.append('<div class="col-sm-1 remove-item text-danger" style="cursor: pointer;">X</div>');
            //console.log(newItem);
            $(this).before(newItem);
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
            return false;
        });
        $(document.body).on('click', '.remove-item' ,function(){
            $(this).parents("#Item").remove();
            //calculateTotalPrice();
            return false;
        });

        $('#ORDER_ID').on('change', function() {
            var order = JSON.parse($(this).children("option:selected").attr('data-order_json'));
            
            $("#CUSTOMER_NAME").val(order.CUSTOMER_NAME);
            $("#CUSTOMER_ADDRESS").val(order.CUSTOMER_ADDRESS);
        });

        $(document).on('change','.MATERIAL_ID', function() {
            var material_json = JSON.parse($(this).children("option:selected").attr('data-material_json'));
            var parent = $(this).closest("fieldset");
            var material = $(this).children("option:selected");
            var material_id = $(material).val();
            var material_count = 0;
            //console.log(material);
            $(".MATERIAL_ID").each(function(key,value){
                console.log($(material).val());
                if(material_id == $(value).children("option:selected").val()) {
                    material_count += 1;
                }
            });
            if(material_count > 1) {
                alert("Please select different material");
                $(this).val('').trigger('chosen:updated');
                return false;
            }
            //console.log(material_json);
            //console.log(material_json.ITEM_NAME);
            $(parent).find(".ITEM_NAME").val(material_json.ITEM_NAME);
            $(parent).find(".UOM").val(material_json.UOM);
            $(parent).find(".STORE_QUANTITY").val(material_json.STORE_QUANTITY);
            $(parent).find(".QUANTITY").val("");
        });

        /*
        $(document).on('change','.QUANTITY', function() {
            var parent = $(this).closest("fieldset");
            
            var quantity        = parseFloat($(parent).find(".QUANTITY").val());
            var store_quantity  = parseFloat($(parent).find(".STORE_QUANTITY").val());
            console.log("quantity:"+quantity+"store_quantity:"+store_quantity);
            if(quantity > store_quantity){
                alert("Please assign quantity based on available quantity");
                $(this).val("");
            }
            else {
                //alert("OK");
            }
        });
        */
        $('#ORDER_ID').on('change', function() {
            var orderId = $(this).val();
            //alert(orderId);return;
            $("#btnSubmit").attr("disabled", true);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('order/detail/'); ?>/"+orderId,
                data: { 'ajax': true },
                dataType: "json",
                success: function(data) {
                        //called when successful
                        //console.log(data);console.log(data.items);
                        //console.log(data.orderMaterials);
                        $("#CUSTOMER_NAME").val(data.order.CUSTOMER_NAME);
                        $("#CUSTOMER_ADDRESS").val(data.order.CUSTOMER_ADDRESS);
                        var products = "";
                        $.each(data.items, function(i, item) {
                            console.log(item);
                            products += '<div class="form-group"><label class="control-label col-sm-2 text-left" for="ITEM_NAME">ITEM_NAME<span class="required">*</span>:</label><div class="col-sm-10"><input class="form-control" type="text" value="'+item.ITEM_NAME+'" required readonly/>    </div></div><div class="form-group">    <label class="control-label col-sm-2 text-left" for="QUANTITY">QUANTITY<span class="required">*</span>:</label>    <div class="col-sm-10">        <input class="form-control" type="text" value="'+item.QUANTITY+'" required readonly/>    </div></div><div class="form-group"><label class="control-label col-sm-2 text-left" for="RATE">RATE<span class="required">*</span>:</label><div class="col-sm-10"><input class="form-control" type="text" value="'+item.RATE+'" required readonly/>    </div></div><div class="form-group">    <label class="control-label col-sm-2 text-left" for="PRICE">PRICE<span class="required">*</span>:</label>    <div class="col-sm-10">        <input class="form-control" type="text" value="'+item.PRICE+'" required readonly/>    </div></div>';
                        });
                        console.log(products);
                        $("#Product").html(products);
                        $('#btnSubmit').removeAttr("disabled");
                        // $("#ITEM_NAME").val(data.items[0].ITEM_NAME);
                        // $("#QUANTITY").val(data.items[0].QUANTITY);
                },
                error: function(e) {
                        //called when there is an error
                        console.log(e.message);
                        return false;
                }
            });

        });
    });
</script>