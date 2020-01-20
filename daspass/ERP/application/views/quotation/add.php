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
            Quotation Management
            <small><?php echo ucfirst($this->router->fetch_method()); ?> Quotation</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="<?php echo base_url('quotation'); ?>"><i class="fa fa-role"></i> Quotation Management</a></li>
            <li class="active"> <?php echo ucfirst($this->router->fetch_method()); ?> Quotation</li>
        </ol>
    </section>
    <form role="form" id="quotationForm" class="form-horizontal" name="quotationForm" action="<?php echo $form_action;?>" method="post" enctype="multipart/form-data">
    <!-- Main content -->
    <section class="content">
        <div><a href="javascript:window.history.back();" class="btn btn-danger btn-lg">Back</a></div>
        <div class="box">
           
            <div class="box-body">
                <section id="company_details">
                    <h4>Company Details:</h4>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CUSTOMER_ID">Firm Name<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="CUSTOMER_ID" class="form-control chosen-select" name="CUSTOMER_ID" required>
                                <option value="">Select Customer</option>
                                <?php foreach ($customers as $customer) { ?>
                                <option value='<?php echo $customer->ID; ?>' <?php echo (isset($quotation->ID) && $customer->ID == $quotation->CUSTOMER_ID) ? "selected=selected":"";?> data-customer_json='<?php echo json_encode($customer); ?>'>
                                    <?php echo $customer->NAME; ?></option>
                                <?php } ?>
                            </select>
                            <input id="CUSTOMER_NAME" class="form-control" type="hidden" name="CUSTOMER_NAME" value="" required maxlength="100"/>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CONTACT_PERSON">Contact Person<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="CONTACT_PERSON" class="form-control" type="text" name="CONTACT_PERSON" value="<?php echo (isset($quotation->CONTACT_PERSON)) ? $quotation->CONTACT_PERSON:'';?>" required readonly maxlength="100"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ADDRESS">Address<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="ADDRESS" class="form-control" type="text" name="ADDRESS" value="<?php echo (isset($quotation->ADDRESS)) ? $quotation->ADDRESS:'';?>" required readonly />
                        </div>
                    </div>
                    
                    <hr/>
                </section>
                <section id="item_details">
                    <h4>Item Details:</h4>
                    <?php
                        if(isset($products) && count($products)){ 
                        foreach ($products as $key => $item) {
                        ?>
                        <fieldset id="Item">
                            <input class="form-control PRODUCT_ID" type="hidden" name="PRODUCT_ID[]" value="<?php echo (isset($item->ID)) ? $item->ID:'';?>" required/>
                            <div class="form-group">
                                <label class="control-label col-sm-2 text-left" for="PRODUCT_NAME">Product Name<span class="required">*</span>:</label>
                                <div class="col-sm-10">
                                    <input id="PRODUCT_NAME" class="form-control" type="text" name="PRODUCT_NAME[]" value="<?php echo (isset($item->PRODUCT_NAME)) ? $item->PRODUCT_NAME:'';?>" required maxlength="200"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2 text-left" for="QUANTITY">Quantity<span class="required">*</span>:</label>
                                <div class="col-sm-10">
                                    <input class="form-control QUANTITY" type="text" name="QUANTITY[]" value="<?php echo (isset($item->QUANTITY)) ? $item->QUANTITY:'';?>" required maxlength="50"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2 text-left" for="RATE">Rate<span class="required">*</span>:</label>
                                <div class="col-sm-10">
                                    <input class="form-control RATE" type="text" name="RATE[]" value="<?php echo (isset($item->RATE)) ? $item->RATE:'';?>" required maxlength="50"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2 text-left" for="PRICE">Price<span class="required">*</span>:</label>
                                <div class="col-sm-10">
                                    <input class="form-control PRICE" type="text" name="PRICE[]" value="<?php echo (isset($item->PRICE)) ? $item->PRICE:'';?>" required readonly/>
                                </div>
                            </div>
                            <?php if($key){ ?>
                            <button class="btn-danger remove-item">Remove Item</button>
                            <?php } ?>
                            <hr/>
                        </fieldset>
                        <?php

                    } }
                    else {
                    ?>
                    <fieldset id="Item">
                        <div class="form-group">
                            <label class="control-label col-sm-2 text-left" for="PRODUCT_NAME">Product Name<span class="required">*</span>:</label>
                            <div class="col-sm-10">
                                <input id="PRODUCT_NAME" class="form-control" type="text" name="PRODUCT_NAME[]" value="<?php echo (isset($quotation->PRODUCT_NAME)) ? $quotation->PRODUCT_NAME:'';?>" required maxlength="200"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2 text-left" for="QUANTITY">Quantity<span class="required">*</span>:</label>
                            <div class="col-sm-10">
                                <input class="form-control QUANTITY" type="text" name="QUANTITY[]" value="<?php echo (isset($quotation->QUANTITY)) ? $quotation->QUANTITY:'';?>" required maxlength="50"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2 text-left" for="RATE">Rate<span class="required">*</span>:</label>
                            <div class="col-sm-10">
                                <input class="form-control RATE" type="text" name="RATE[]" value="<?php echo (isset($quotation->RATE)) ? $quotation->RATE:'';?>" required maxlength="50"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2 text-left" for="PRICE">Price<span class="required">*</span>:</label>
                            <div class="col-sm-10">
                                <input class="form-control PRICE" type="text" name="PRICE[]" value="<?php echo (isset($quotation->PRICE)) ? $quotation->PRICE:'';?>" required readonly/>
                            </div>
                        </div>
                        <hr/>
                    </fieldset>
                    <?php } ?>
                    <button id="add-more-item" class="btn-primary" style="margin-top:20px;">Add More Item</button>

                    <fieldset>
                        <legend>Total Price</legend>
                        <div class="form-group">
                            <label class="control-label col-sm-2 text-left" for="TOTAL_PRICE">TOTAL_PRICE<span class="required">*</span>:</label>
                            <div class="col-sm-10">
                                <input id="TOTAL_PRICE" class="form-control" type="text" name="TOTAL_PRICE" value="<?php echo (isset($purchase->TOTAL_PRICE)) ? $purchase->TOTAL_PRICE:'';?>" required maxlength="50" readonly/>
                            </div>
                        </div>
                    </fieldset>
                </section>
                <section id="terms">
                    <h4>Terms:</h4>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PACKING_TERM">PACKING_TERM:</label>
                        <div class="col-sm-10">
                             <textarea rows="2" id="PACKING_TERM" class="form-control" name="PACKING_TERM"><?php echo (isset($quotation->PACKING_TERM)) ? $quotation->PACKING_TERM:'';?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="FREIGHT_TERM">FREIGHT_TERM:</label>
                        <div class="col-sm-10">
                             <textarea rows="2" id="FREIGHT_TERM" class="form-control" name="FREIGHT_TERM"><?php echo (isset($quotation->FREIGHT_TERM)) ? $quotation->FREIGHT_TERM:'';?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PAYMENT_TERM">PAYMENT_TERM:</label>
                        <div class="col-sm-10">
                             <textarea rows="2" id="PAYMENT_TERM" class="form-control" name="PAYMENT_TERM"><?php echo (isset($quotation->PAYMENT_TERM)) ? $quotation->PAYMENT_TERM:'';?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="TAX_DETAIL">TAX_DETAIL:</label>
                        <div class="col-sm-10">
                             <textarea rows="2" id="TAX_DETAIL" class="form-control" name="TAX_DETAIL"><?php echo (isset($quotation->TAX_DETAIL)) ? $quotation->TAX_DETAIL:'';?></textarea>
                        </div>
                    </div>
                    
                    <hr/>
                </section>
            </div>

        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?php echo base_url('quotation'); ?>" class="btn btn-danger">Cancel</a>
        </div>
        <div id='line-example'></div>
    </section>
    <!-- /.content -->
    </form>
</aside><!-- /.right-side -->
<script src="<?php echo BASE_PATH; ?>assets/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    $('document').ready(function() {
        /*-------------------------- Form Validation -------------------------*/
        $("#quotationForm").validate({
            rules: {
                    'QUANTITY[]': {digits: true},
                    'RATE[]': {number: true},
            },
            invalidHandler: function(event, validator) {
                // 'this' refers to the form
                var errors = validator.numberOfInvalids();
            }
        });
        /*--------------------------------------------------------------------*/
        $("#quotationForm").validate({ ignore: ":hidden:not(select)" });
    });
    
     $( "#sortable" ).on( "sortupdate", function( event, ui ) {
        //console.log(ui);
        //updateOrder();
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
    $("#quotationForm").on('change','#quotation_image',function () {
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
        var customers  = <?php echo json_encode($customers); ?>;
        //console.log(customers);
        $('#category_id').on('change', function () {
            var selectVal = $("#category_id option:selected").data('unit');
            $("#category-unit").html(selectVal);
        });
        var customerId = "<?php echo (isset($quotation->CUSTOMER_ID) && $quotation->CUSTOMER_ID) ? $quotation->CUSTOMER_ID : ''; ?>";
        //alert(customerId);
        if(customerId){
            var customerName = $("#CUSTOMER_ID").children("option:selected").text().trim();
            //alert(customerName);str.trim()
            $("#CUSTOMER_NAME").val(customerName);
        }
        
        calculateTotalPrice();
        $('#CUSTOMER_ID').on('change', function() {
            //console.log($(this).html());
            //console.log($(this).children("option:selected").data('CONTACT_PERSON'));
            
            var customer = JSON.parse($(this).children("option:selected").attr('data-customer_json'));
            
            $("#CONTACT_PERSON").val(customer.CONTACT_PERSON);
            $("#ADDRESS").val(customer.ADDRESS_1+" "+customer.ADDRESS_2+" "+customer.CITY+" "+customer.STATE+" "+customer.COUNTRY);
            $("#CUSTOMER_NAME").val(customer.NAME);
        });

        $("#add-more-item").click(function(){
            //var clonedItem = $("#Item").clone();
            var newItem = '<fieldset id="Item">                           <div class="form-group">                                <label class="control-label col-sm-2 text-left" for="PRODUCT_NAME">Product Name<span class="required">*</span>:</label>                                <div class="col-sm-10">                                    <input id="PRODUCT_NAME" class="form-control" type="text" name="PRODUCT_NAME[]" value="" required maxlength="200"/>                                </div>                            </div>                            <div class="form-group">                                <label class="control-label col-sm-2 text-left" for="QUANTITY">Quantity<span class="required">*</span>:</label>                                <div class="col-sm-10">                                    <input class="form-control QUANTITY" type="text" name="QUANTITY[]" value="" required maxlength="50"/>                                </div>                            </div>                            <div class="form-group">                                <label class="control-label col-sm-2 text-left" for="RATE">Rate<span class="required">*</span>:</label>                                <div class="col-sm-10">                                    <input class="form-control RATE" type="text" name="RATE[]" value="" required maxlength="50"/>                                </div>                            </div>                            <div class="form-group">                                <label class="control-label col-sm-2 text-left" for="PRICE">Price<span class="required">*</span>:</label>                                <div class="col-sm-10">                                    <input class="form-control PRICE" type="text" name="PRICE[]" value="" required readonly/>                                </div>                            </div>                            <hr/>                        </fieldset><button id="add-more-item" class="btn-danger remove-item">Remove Item</button></br>';
            //var newItem = $("#Item").clone().find("input:text").val("").end().append('<button id="add-more-item" class="btn-danger remove-item">Remove Item</button>');
            console.log(newItem);
            //.append('<div class="col-sm-1 remove-item text-danger" style="cursor: pointer;">X</div>');
            //console.log(newItem);
            $(this).before(newItem);
            return false;
        });
        $(document.body).on('click', '.remove-item' ,function(){
            $(this).parents("#Item").remove();
            calculateTotalPrice();
            return false;
        });

        $(document).on('change','.QUANTITY, .RATE', function() {
            calculatePrice($(this));
            calculateTotalPrice();
        });
        function calculatePrice(thisObj) {
            var parent      = thisObj.closest("fieldset");
            var quantity    = parseFloat($(parent).find(".QUANTITY").val());
            var rate        = parseFloat($(parent).find(".RATE").val());
            console.log(parent,quantity,rate);
            /*
            var pkg         = parseFloat($(parent).find(".PACKAGING_FORWARDING").val());
            var freight     = parseFloat($(parent).find(".FREIGHT").val());
            var sgst        = parseFloat($(parent).find(".SGST_PERCENTAGE").html());
            var cgst        = parseFloat($(parent).find(".CGST_PERCENTAGE").html());
            var basic_price = parseFloat(quantity*rate);
            var sgst_price  = parseFloat((basic_price+pkg)*(sgst/100));
            var cgst_price  = parseFloat((basic_price+pkg)*(cgst/100));
            var price       = parseFloat(basic_price + pkg + freight + sgst_price + cgst_price);
            */
            var price       = parseFloat(quantity*rate);
            console.log(parent,quantity,rate,price);
            //console.log("rate:"+rate+"quantity:"+quantity+"sgst:"+sgst+"cgst:"+cgst+"sgst_price:"+sgst_price+"cgst_price"+cgst_price);
            // $(parent).find(".SGST").val(sgst_price);
            // $(parent).find(".CGST").val(cgst_price);
            // $(parent).find(".BASIC_PRICE").val(basic_price);
            $(parent).find(".PRICE").val(isNaN(price) ? 0 : price);
        }
        function calculateTotalPrice(){
            var total_price = 0;
            $(".PRICE").each(function(){
                var price = parseFloat($(this).val());
                total_price += isNaN(price) ? 0 : price;
            });
            $("#TOTAL_PRICE").val(parseFloat(total_price));
        }
    });
</script>