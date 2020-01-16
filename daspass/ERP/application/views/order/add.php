<?php
/*
echo "<pre>";print_r($customers);
echo "=========================================";
foreach ($customers as $customer) {
    print_r($customer);
}
exit;
*/
?>
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
            Order Management
            <small><?php echo ucfirst($this->router->fetch_method()); ?> Order</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="<?php echo base_url('order'); ?>"><i class="fa fa-role"></i> Order Management</a></li>
            <li class="active"> <?php echo ucfirst($this->router->fetch_method()); ?> Order</li>
        </ol>
    </section>
    <form role="form" id="orderForm" class="form-horizontal" name="orderForm" action="<?php echo $form_action;?>" method="post" enctype="multipart/form-data">
    <!-- Main content -->
    <section class="content">
        <div><a href="javascript:window.history.back();" class="btn btn-danger btn-lg">Back</a></div>
        <div class="box">
            <input id="method" type="hidden" name="method" value="<?php echo $this->router->fetch_method(); ?>"/>

            <div class="box-body">
                <fieldset>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CUSTOMER_NAME">Customer Name<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="CUSTOMER_ID" class="form-control chosen-select" name="CUSTOMER_ID" required>
                                <option value="">Select Customer</option>
                                <?php foreach ($customers as $customer) { ?>
                                <option value='<?php echo $customer->ID; ?>' <?php echo (isset($order->CUSTOMER_ID) && $customer->ID == $order->CUSTOMER_ID) ? "selected=selected":"";?> data-customer_json='<?php echo json_encode($customer); ?>'>
                                    <?php echo $customer->NAME; ?></option>
                                <?php } ?>
                            </select>
                             <input id="CUSTOMER_NAME" class="form-control" type="hidden" name="CUSTOMER_NAME" value="<?php echo (isset($order->CUSTOMER_NAME)) ? $order->CUSTOMER_NAME:'';?>" required readonly/>
                            <!--input id="CUSTOMER_ID" class="form-control" type="hidden" name="CUSTOMER_ID" value="<?php echo (isset($order->CUSTOMER_ID)) ? $order->CUSTOMER_ID:'';?>" required maxlength="100"/-->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="QUOTATION_ID">Quotaion<span class="required">*</span>:</label>
                        <div class="col-sm-10" id="QUOTATION">
                            <select id="QUOTATION_ID" class="form-control chosen-select" name="QUOTATION_ID" required>
                                <option value="">Select Quotation</option>
                            <!--
                                <?php foreach ($quotations as $quotation) { ?>
                                <option value='<?php echo $quotation->ID; ?>' <?php echo (isset($order->QUOTATION_ID) && $quotation->ID == $order->QUOTATION_ID) ? "selected=selected":"";?> data-quotation_json='<?php echo json_encode($quotation); ?>'>
                                    <?php echo $quotation->ID ."-". $quotation->CUSTOMER_NAME; ?></option>
                                <?php } ?>
                            -->
                            </select>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CUSTOMER_ADDRESS">Address<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                             <textarea rows="2" id="CUSTOMER_ADDRESS" class="form-control" name="CUSTOMER_ADDRESS" required readonly><?php echo (isset($order->CUSTOMER_ADDRESS)) ? $order->CUSTOMER_ADDRESS:'';?>
                        </textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PO_NO">PO_NO<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="PO_NO" class="form-control" type="text" name="PO_NO" value="<?php echo (isset($purchase->PO_NO)) ? $purchase->PO_NO:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PO_DATE">PO DATE<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                             <input id="PO_DATE" class="form-control datepicker" name="PO_DATE" value="<?php echo (isset($order->PO_DATE)) ? $order->PO_DATE:'';?>" required maxlength="20"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="DELIVERY_DATE">DELIVERY_DATE<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                             <input id="DELIVERY_DATE" class="form-control datepicker" name="DELIVERY_DATE" value="<?php echo (isset($order->DELIVERY_DATE)) ? $order->DELIVERY_DATE:'';?>" required maxlength="20"/>
                        </div>
                    </div>
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CUSTOMER_CONTACT_NO">Contact No.<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="CUSTOMER_CONTACT_NO" class="form-control" type="text" name="CUSTOMER_CONTACT_NO" value="<?php echo (isset($order->CUSTOMER_CONTACT_NO)) ? $order->CUSTOMER_CONTACT_NO:'';?>" required readonly maxlength="50"/>
                        </div>
                    </div-->
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="industry">Industry<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="industry_id" class="form-control industry" name="industry_id" required>
                                <option value="">Select industry</option>
                                <?php foreach ($industries as $industry) { ?>
                                <option value='<?php echo $industry->ID; ?>' <?php echo (isset($industry->CATEGORY_ID) && $industry->CATEGORY_ID == $industry->ID) ? "selected=selected":"";?>>
                                    <?php echo $industry->NAME; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div-->
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PAYMENT_TERM">Payment Term<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                             <textarea rows="2" id="PAYMENT_TERM" class="form-control" name="PAYMENT_TERM" required><?php echo (isset($order->PAYMENT_TERM)) ? $order->PAYMENT_TERM:'';?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="DELIVERY_TERM">Delivery Term<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                             <textarea rows="2" id="DELIVERY_TERM" class="form-control" name="DELIVERY_TERM" required><?php echo (isset($order->DELIVERY_TERM)) ? $order->DELIVERY_TERM:'';?></textarea>
                        </div>
                    </div-->
                </fieldset>
                <fieldset>
                    <legend>Item Detail</legend>
                    <div id="Item"></div>
                </fieldset>
                <fieldset>
                        <legend>Total Price</legend>
                        <div class="form-group">
                            <label class="control-label col-sm-2 text-left" for="TOTAL_PRICE">TOTAL_PRICE<span class="required">*</span>:</label>
                            <div class="col-sm-10">
                                <input id="TOTAL_PRICE" class="form-control" type="text" name="TOTAL_PRICE" value="<?php echo (isset($purchase->TOTAL_PRICE)) ? $purchase->TOTAL_PRICE:'';?>" required maxlength="50" readonly/>
                            </div>
                        </div>
                </fieldset>
                <fieldset>
                    <legend>Terms</legend>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PACKING_TERM">PACKING_TERM:</label>
                        <div class="col-sm-10">
                             <textarea rows="2" id="PACKING_TERM" class="form-control" name="PACKING_TERM" readonly><?php echo (isset($order->PACKING_TERM)) ? $order->PACKING_TERM:'';?>
                        </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="FREIGHT_TERM">FREIGHT_TERM:</label>
                        <div class="col-sm-10">
                             <textarea rows="2" id="FREIGHT_TERM" class="form-control" name="FREIGHT_TERM" readonly><?php echo (isset($order->FREIGHT_TERM)) ? $order->FREIGHT_TERM:'';?>
                        </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PAYMENT_TERM">PAYMENT_TERM:</label>
                        <div class="col-sm-10">
                             <textarea rows="2" id="PAYMENT_TERM" class="form-control" name="PAYMENT_TERM" readonly><?php echo (isset($order->PAYMENT_TERM)) ? $order->PAYMENT_TERM:'';?>
                        </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="TAX_DETAIL">TAX_DETAIL:</label>
                        <div class="col-sm-10">
                             <textarea rows="2" id="TAX_DETAIL" class="form-control" name="TAX_DETAIL" readonly><?php echo (isset($order->TAX_DETAIL)) ? $order->TAX_DETAIL:'';?>
                        </textarea>
                        </div>
                    </div>
                </fieldset>
            </div>

        </div>
        <div class="box-footer">
            <button id="btnSubmit" type="submit" class="btn btn-primary">Save</button>
            <a href="<?php echo base_url('order'); ?>" class="btn btn-danger">Cancel</a>
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
        $("#orderForm").validate({
            ignore: "",
            rules: {
                    'QUANTITY[]': {required:true, digits: true},
                    'ITEM_NAME[]':{required:true}
            },
            invalidHandler: function(event, validator) {
                // 'this' refers to the form
                var errors = validator.numberOfInvalids();
            }
        });
        $.validator.setDefaults({ ignore: '' });
        /*--------------------------------------------------------------------*/
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
    $("#orderForm").on('change','#order_image',function () {
        //alert('changed');
        var files       = this.files[0];
        var reader      = new FileReader();
        var img         = new Image();
        reader.onload   = function (e) {
            img.onload  = function () {
                $('#imagePreview').html($('<img>').attr('src',e.target.result));
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(files);
    });
    /*------------------------------------------------------------------------*/
    $("document").ready(function() {
        var customerId = $('#CUSTOMER_ID').find("option:selected").val();
        var quotationId = "<?php echo (isset($order->QUOTATION_ID) && $order->QUOTATION_ID) ? $order->QUOTATION_ID:0; ?>";
        if(customerId) {
            getQuotations(customerId);
        }
        $('#CUSTOMER_ID').on('change', function() {
            var customerId = $(this).val();
            getQuotations(customerId);

        });
        function getQuotations(customerId){
            //var materailGroupName = $("#MATERIAL_GROUP_ID").find("option:selected").text();
            //$("#CUSTOMER_NAME").val(materailGroupName);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('quotation/customerQuotations/'); ?>/"+customerId,
                data: { 'ajax': true },
                dataType: "json",
                success: function(data) {
                        //console.log(data);console.log(data.quotations);return;
                        var options = '<option value="">Select Quotation</option>';
                        $.each(data.quotations, function(index,val){
                            //console.log(val);
                            selected = (quotationId == val.ID) ? "selected=selected" : "";
                            //alert(materailSubGroupId);alert(val.ID);
                            options += "<option value='"+val.ID+"' "+selected+" data-quotation_json='"+JSON.stringify(val)+"'>"+val.ID+" - " +val.CUSTOMER_NAME+"</option>";
                        });
                        //console.log(options);
                        $("#QUOTATION_ID").html(options);
                        $('#QUOTATION_ID').trigger("chosen:updated");
                },
                error: function(e) {
                        //called when there is an error
                        console.log(e.message);
                        return false;
                }
            });
        }
        $('#QUOTATION_ID').on('change', function() {
            //var quotation = JSON.parse($(this).children("option:selected").attr('data-quotation_json'));
            $("#btnSubmit").attr("disabled", true);
            var quotationId = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('quotation/detail/'); ?>/"+quotationId,
                data: { 'ajax': true },
                dataType: "json",
                success: function(data) {
                        //console.log(data);console.log(data.quotations);return;
                        $("#CUSTOMER_NAME").val(data.detail.CUSTOMER_NAME);
                        $("#CUSTOMER_ADDRESS").val(data.detail.ADDRESS);
                        $("#PACKING_TERM").val(data.detail.PACKING_TERM);
                        $("#FREIGHT_TERM").val(data.detail.FREIGHT_TERM);
                        $("#PAYMENT_TERM").val(data.detail.PAYMENT_TERM);
                        $("#TAX_DETAIL").val(data.detail.TAX_DETAIL);
                        var html = '';
                        $.each(data.products, function(index,val) {
                            html += '<div class="form-group">                            <label class="control-label col-sm-2 text-left" for="ITEM_NAME">Item Name<span class="required">*</span>:</label>                                       <div class="col-sm-10">                                <input class="form-control ITEM_NAME" type="text" name="ITEM_NAME[]" value="'+val.PRODUCT_NAME+'" required maxlength="200" readonly/>                            </div>                        </div>                        <div class="form-group">                            <label class="control-label col-sm-2 text-left" for="inventory">Item Quantity<span class="required">*</span>:</label>                            <div class="col-sm-10">                                <input class="form-control QUANTITY" type="text" name="QUANTITY[]" value="'+val.QUANTITY+'" required maxlength="50" readonly/>                            </div>                                    </div>                             <div class="form-group">                            <label class="control-label col-sm-2 text-left" for="inventory">Item Quantity<span class="required">*</span>:</label>                            <div class="col-sm-10">                                <input class="form-control RATE" type="text" name="RATE[]" value="'+val.RATE+'" required maxlength="50" readonly/>                            </div>                                    </div><div class="form-group">                            <label class="control-label col-sm-2 text-left" for="inventory">Item Quantity<span class="required">*</span>:</label>                            <div class="col-sm-10">                                <input class="form-control PRICE" type="text" name="PRICE[]" value="'+val.PRICE+'" required maxlength="50" readonly/>                            </div>                                    </div>                        </div><hr/>';
                        });
                        if(html){
                            $("#TOTAL_PRICE").val(data.detail.TOTAL_PRICE);
                            //console.log(html);
                            $("#Item").html(html);
                        } else {
                            alert("Products Not found");
                            $('#QUOTATION_ID').val('').trigger('chosen:updated');
                        }
                        $('#btnSubmit').removeAttr("disabled");
                },
                error: function(e) {
                        //called when there is an error
                        console.log(e.message);
                        return false;
                }
            });
            /*
            //$("#CUSTOMER_ID").val(quotation.CUSTOMER_ID);
            $("#CUSTOMER_NAME").val(quotation.CUSTOMER_NAME );
            $("#CUSTOMER_ADDRESS").val(quotation.ADDRESS);
            $("#CUSTOMER_CONTACT_NO").val(quotation.MOBILE);
            $("#PACKING_TERM").val(quotation.PACKING_TERM);
            $("#FREIGHT_TERM").val(quotation.FREIGHT_TERM);
            $("#PAYMENT_TERM").val(quotation.PAYMENT_TERM);
            $("#TAX_DETAIL").val(quotation.TAX_DETAIL);
            */
        });
        /*
        $("#add-more-item").click(function(){
            var newItem = $("#Item").clone().append('<div class="col-sm-1 remove-item text-danger" style="cursor: pointer;">X</div>');
            $(this).before(newItem);
        });
        $(document.body).on('click', '.remove-item' ,function(){
            $(this).parents("#Item").remove();
        });
        */
    });
</script>