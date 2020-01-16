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
                    <legend>P.O. Details</legend>

                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PURCHASE_ID">PO Number<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="PURCHASE_ID" class="form-control chosen-select" name="PURCHASE_ID" required>
                                <option value="">PO Number</option>
                                <?php foreach ($purchases as $purchase) { ?>
                                <option value='<?php echo $purchase->ID; ?>' data-vendor_json='<?php echo json_encode($purchase); ?>'>
                                    <?php echo $purchase->ID; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PO_TYPE">PO Type<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="PO_TYPE" class="form-control" type="text" name="PO_TYPE" required readonly/>
                        </div>
                    </div>
              
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="DELIVERY_ADDRESS">Delivery Address<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="DELIVERY_ADDRESS" class="form-control" type="text" name="DELIVERY_ADDRESS" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="DELIVERY_MODE">DELIVERY_MODE<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="DELIVERY_MODE" class="form-control" type="text" name="DELIVERY_MODE" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PO_DATE">PO_DATE<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="PO_DATE" class="form-control" type="text" name="PO_DATE" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="DELIVERY_SCHEDULE">DELIVERY_SCHEDULE<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="DELIVERY_SCHEDULE" class="form-control" type="text" name="DELIVERY_SCHEDULE" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="REMARKS">REMARKS:</label>
                        <div class="col-sm-10">
                             <textarea rows="2" id="REMARKS" class="form-control" name="REMARKS" readonly><?php echo (isset($purchase->REMARKS)) ? $purchase->REMARKS:'';?></textarea>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Supplier Detail</legend>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="VENDOR_ID">Firm Name<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="VENDOR_NAME" class="form-control" type="text" name="VENDOR_NAME" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="VENDOR_ADDRESS">VENDOR_ADDRESS<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="VENDOR_ADDRESS" class="form-control" type="text" name="VENDOR_ADDRESS" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="GSTIN">GST No.<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="GSTIN" class="form-control" type="text" name="GSTIN" required readonly/>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Bill Detail</legend>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="BILL_NUMBER">Bill Number<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="BILL_NUMBER" class="form-control" type="text" name="BILL_NUMBER" required readonly />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="BILL_DATE">Bill Date<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="BILL_DATE" class="form-control" type="text" name="BILL_DATE" required readonly />
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Supplier Detail</legend>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CHALLAN_NUMBER">Challan Number:</label>
                        <div class="col-sm-10">
                            <input id="CHALLAN_NUMBER" class="form-control" type="text" name="CHALLAN_NUMBER" readonly />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CHALLAN_DATE">Challan Date:</label>
                        <div class="col-sm-10">
                            <input id="CHALLAN_DATE" class="form-control" type="text" name="CHALLAN_DATE" readonly />
                        </div>
                    </div>
                </fieldset>
                <div id="itemDetails">
                    <legend>Item Details</legend>
                </div>
                <!--fieldset id="Item">
                    <legend>Item Detail</legend>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="MATERIAL_ID">Material Name<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                             <input class="form-control ITEM_NAME" type="text" name="ITEM_NAME[]" required readonly/>
                        </div>
                        <input class="form-control" type="hidden" name="PURCHASE_MATERIAL_ID[]" required readonly/>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">Unit<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control UOM" type="text" name="UOM[]" value="<?php echo (isset($purchase->UOM)) ? $purchase->UOM:'';?>" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">Quantity<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control QUANTITY" type="text" name="QUANTITY[]" value="<?php echo (isset($purchase->QUANTITY)) ? $purchase->QUANTITY:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">Rate<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control RATE" type="text" name="RATE[]" value="<?php echo (isset($purchase->RATE)) ? $purchase->RATE:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">SGST(<span class="SGST_PERCENTAGE"></span>)%<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control SGST" type="text" name="SGST[]" value="<?php echo (isset($purchase->SGST)) ? $purchase->SGST:'';?>" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">CGST(<span class="CGST_PERCENTAGE"></span>)%<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control CGST" type="text" name="CGST[]" value="<?php echo (isset($purchase->CGST)) ? $purchase->CGST:'';?>" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">PRICE<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control PRICE" type="text" name="PRICE[]" value="<?php echo (isset($purchase->PRICE)) ? $purchase->PRICE:'';?>" required readonly/>
                        </div>
                    </div>
                </fieldset-->
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
        $('#PURCHASE_ID').on('change', function() {
            var purchaseId = $(this).val();
            //alert(purchaseId);return;
            $("#btnSubmit").attr("disabled", true);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('purchase/detail/'); ?>/"+purchaseId,
                data: { 'ajax': true },
                dataType: "json",
                success: function(data) {
                        //called when successful
                        //console.log(data.purchase);
                        console.log(data.purchaseMaterials);
                        $("#PO_TYPE").val(data.purchase.PO_TYPE);
                        $("#DELIVERY_ADDRESS").val(data.purchase.DELIVERY_ADDRESS);
                        $("#DELIVERY_MODE").val(data.purchase.DELIVERY_MODE);
                        $("#DELIVERY_SCHEDULE").val(data.purchase.DELIVERY_SCHEDULE);
                        $("#REMARKS").val(data.purchase.REMARKS);
                        $("#PO_DATE").val(data.purchase.CREATED_ON);
                        $("#VENDOR_NAME").val(data.purchase.VENDOR_NAME);
                        $("#VENDOR_ADDRESS").val(data.purchase.VENDOR_ADDRESS);
                        $("#BILL_NUMBER").val(data.purchase.BILL_NUMBER);
                        $("#BILL_DATE").val(data.purchase.BILL_DATE);
                        $("#CHALLAN_NUMBER").val(data.purchase.CHALLAN_NUMBER);
                        $("#CHALLAN_DATE").val(data.purchase.CHALLAN_DATE);
                        $("#GSTIN").val(data.purchase.GSTIN);
                        var itemDetails = "<legend>Item Details</legend>";
                        $.each(data.purchaseMaterials,function(index,val) {
                            itemDetails += '<fieldset id="Item"><legend>Item Detail</legend>                    <div class="form-group">                        <label class="control-label col-sm-2 text-left" for="MATERIAL_ID">Material Name:</label>                        <div class="col-sm-10">                             <input class="form-control ITEM_NAME" type="text" name="ITEM_NAME[]" value="'+val.ITEM_NAME+'" required readonly/>                        </div><input class="form-control" type="hidden" name="MATERIAL_ID[]" value="'+val.MATERIAL_ID+'"/>                        <input class="form-control" type="hidden" name="PURCHASE_MATERIAL_ID[]" required readonly/>                    </div>                    <div class="form-group">                        <label class="control-label col-sm-2 text-left" for="inventory">Unit:</label>                        <div class="col-sm-10">                            <input class="form-control UOM" type="text" name="UOM[]" value="'+val.UOM+'"required readonly/>                        </div>                    </div>                    <div class="form-group">                        <label class="control-label col-sm-2 text-left" for="inventory">Quantity:</label>                        <div class="col-sm-10">                            <input class="form-control QUANTITY" type="text" name="QUANTITY[]" value="'+val.QUANTITY+'" required readonly/>                        </div>                    </div>   <div class="form-group">                        <label class="control-label col-sm-2 text-left" for="inventory">Quantity:</label>                        <div class="col-sm-10">                            <input class="form-control ACTUAL_QUANTITY" type="text" name="ACTUAL_QUANTITY[]" value="'+val.ACTUAL_QUANTITY+'" required readonly/>                        </div>                    </div>                 <div class="form-group">                        <label class="control-label col-sm-2 text-left" for="inventory">Rate:</label>                        <div class="col-sm-10">                            <input class="form-control RATE" type="text" name="RATE[]" value="'+val.RATE+'" required readonly/>                        </div>                    </div>                    <div class="form-group">                        <label class="control-label col-sm-2 text-left" for="inventory">SGST(<span class="SGST_PERCENTAGE"></span>)%:</label>                        <div class="col-sm-10">                            <input class="form-control SGST" type="text" name="SGST[]" value="'+val.SGST+'" required readonly/>                        </div>                    </div>                    <div class="form-group">                        <label class="control-label col-sm-2 text-left" for="inventory">CGST(<span class="CGST_PERCENTAGE"></span>)%:</label>                        <div class="col-sm-10">                            <input class="form-control CGST" type="text" name="CGST[]" value="'+val.CGST+'" required readonly/>                        </div>                    </div>                    <div class="form-group">                        <label class="control-label col-sm-2 text-left" for="inventory">PRICE:</label>                        <div class="col-sm-10">                            <input class="form-control PRICE" type="text" name="PRICE[]" value="'+val.PRICE+'" required readonly/>                        </div>                    </div><div class="form-group">                        <label class="control-label col-sm-2 text-left" for="inventory">Gate Status:</label><div class="col-sm-10">                            <input class="form-control" type="text" name="GATE_STATUS[]" value="'+val.GATE_STATUS+'" required readonly/>                        </div></div><div class="form-group">                        <label class="control-label col-sm-2 text-left" for="inventory">Quality Status:</label><div class="col-sm-10">                            <input class="form-control" type="text" name="QUALITY_STATUS[]" value="'+val.QUALITY_STATUS+'" required readonly/>                      </div>               </fieldset>';
                                //$("#itemDetails").after(itemDetail);                   
                        });
                        $("#itemDetails").html(itemDetails);            
                        /*
                        //alert('email already registered.');
                        $("#email").after('<label id="email-error" class="error" for="email">Email already registered.</label>');
                        
                        $("#email").focus();
                        $("#email").val('').val(email);
                        */
                        //console.log(data);
                        $('#btnSubmit').removeAttr("disabled");
                        return true;
                        //$('#ajaxphp-results').html(data);
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

