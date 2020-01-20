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
    <form role="form" id="dispatchForm" class="form-horizontal" name="dispatchForm" action="<?php echo $form_action;?>" method="post" enctype="multipart/form-data">
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
                            <input id="CUSTOMER_ID" class="form-control" type="hidden" name="CUSTOMER_ID" value="" required maxlength="100" readonly/>
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
                <legend>Item Details</legend>
                <fieldset id="Item">
                    <legend>Item Detail</legend>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="INVOICE_NO">Invoice Number<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control INVOICE_NO" type="text" name="INVOICE_NO" value="<?php echo (isset($purchase->INVOICE_NO)) ? $purchase->INVOICE_NO:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">Invoice Value<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control INVOICE_VALUE" type="text" name="INVOICE_VALUE" value="<?php echo (isset($purchase->INVOICE_VALUE)) ? $purchase->INVOICE_VALUE:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="TRANSPORT_NAME">Transport Name<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control TRANSPORT_NAME" type="text" name="TRANSPORT_NAME" value="<?php echo (isset($purchase->TRANSPORT_NAME)) ? $purchase->TRANSPORT_NAME:'';?>" required maxlength="100"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CR_NO">GR Number<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control CR_NO" type="text" name="CR_NO" value="<?php echo (isset($purchase->CR_NO)) ? $purchase->CR_NO:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="TRANSPORT_DATE">Date of Transport<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="TRANSPORT_DATE" class="form-control datepicker" type="text" name="TRANSPORT_DATE" value="<?php echo (isset($purchase->TRANSPORT_DATE)) ? $purchase->TRANSPORT_DATE:'';?>" required maxlength="20"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="GR_DATE">GR Date<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="GR_DATE" class="form-control" type="text" name="GR_DATE" value="<?php echo (isset($purchase->GR_DATE)) ? $purchase->GR_DATE:'';?>" required maxlength="20" readonly/>
                        </div>
                    </div>
                </fieldset>
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
        /*-------------------------- Form Validation -------------------------*/
        $.validator.addMethod('contentIds', function(value) {
            var contents = /^[0-9,]*$/;    
            return value.match(contents);
        }, 'Invalid Content Ids');
	
        $("#dispatchForm").validate({
            rules: {
            },
            invalidHandler: function(event, validator) {
                // 'this' refers to the form
                var errors = validator.numberOfInvalids();
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
    $("document").ready(function() {
        
        $('#ORDER_ID').on('change', function() {
            var order = JSON.parse($(this).children("option:selected").attr('data-order_json'));
            $("#CUSTOMER_ID").val(order.CUSTOMER_ID);
            $("#CUSTOMER_NAME").val(order.CUSTOMER_NAME);
            $("#CUSTOMER_ADDRESS").val(order.CUSTOMER_ADDRESS);
        });

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
                        $("#CUSTOMER_ID").val(data.order.CUSTOMER_ID);
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

        $('#TRANSPORT_DATE').on('change', function(){
            $('#GR_DATE').val($(this).val());
        });
    });
</script>