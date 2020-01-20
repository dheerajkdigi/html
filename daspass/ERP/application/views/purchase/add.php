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
        <div>
            <a href="javascript:window.history.back();" class="btn btn-danger btn-lg">Back</a>
        </div>
        <div class="box">

            <div class="box-body">
                <fieldset>
                    <legend>P.O. Details</legend>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PO_TYPE">PO Type<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="PO_TYPE" class="form-control poType" name="PO_TYPE" required>
                                <option value="">Select PO Type</option>
                                <?php foreach ($poTypes as $poType) { ?>
                                <option value='<?php echo $poType; ?>' <?php echo (isset($purchase->PO_TYPE) && $purchase->PO_TYPE == $poType) ? "selected=selected":"";?>>
                                    <?php echo str_replace("_", " ", $poType); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PO_NUMBER">PO No.<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="PO_NUMBER" class="form-control" type="text" name="PO_NUMBER" value="<?php echo (isset($purchase->PO_NUMBER)) ? $purchase->PO_NUMBER:'';?>" required maxlength="50"/>
                        </div>
                    </div-->
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="APPROVED">APPROVED<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="APPROVED" class="form-control poType" name="APPROVED" required>
                                <option value="">Select APPROVED</option>
                                <option value='NO' <?php echo (isset($purchase->APPROVED) && $purchase->APPROVED == "NO") ? "selected=selected":"";?>>No</option>
                                <option value='YES' <?php echo (isset($purchase->APPROVED) && $purchase->APPROVED == "YES") ? "selected=selected":"";?>>Yes</option>
                            </select>
                        </div>
                    </div-->
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="STATUS">STATUS<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="STATUS" class="form-control poType" name="STATUS" required>
                                <option value="">Select STATUS</option>
                                <option value='PENDING' <?php echo (isset($purchase->STATUS) && $purchase->STATUS == "PENDING") ? "selected=selected":"";?>>Pending</option>
                                <option value='APPROVED' <?php echo (isset($purchase->APPROVED) && $purchase->APPROVED == "APPROVED") ? "selected=selected":"";?>>Approved</option>
                            </select>
                        </div>
                    </div-->
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="DELIVERY_ADDRESS">Delivery Address<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <!--input id="DELIVERY_ADDRESS" class="form-control" type="text" name="DELIVERY_ADDRESS" value="<?php echo (isset($purchase->DELIVERY_ADDRESS)) ? $purchase->DELIVERY_ADDRESS:'';?>" required maxlength="200"/-->
                            <textarea rows="2" id="DELIVERY_ADDRESS" class="form-control" name="DELIVERY_ADDRESS" readonly>Daspass Sales Corporation Plot No. - A4, Street No. - 4, Anand Parbat Industrial Area, New Delhi - 110005</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="DELIVERY_MODE">DELIVERY_MODE<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="DELIVERY_MODE" class="form-control" name="DELIVERY_MODE" required>
                                <option value="">Select DELIVERY_MODE</option>
                                <?php foreach ($deliveryModes as $key => $deliveryMode) { ?>
                                    <option value='<?php echo $deliveryMode; ?>' <?php echo (isset($purchase->DELIVERY_MODE) && $purchase->DELIVERY_MODE == $deliveryMode) ? "selected=selected":"";?>>By-<?php echo $deliveryMode; ?></option>
                               <?php } ?>
                            </select>
                            <!--input id="DELIVERY_MODE" class="form-control" type="text" name="DELIVERY_MODE" value="<?php echo (isset($purchase->DELIVERY_MODE)) ? $purchase->DELIVERY_MODE:'';?>" required maxlength="20"/-->
                        </div>
                    </div>
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PO_DATE">PO_DATE<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="PO_DATE" class="form-control" type="text" name="PO_DATE" value="<?php echo (isset($purchase->PO_DATE)) ? $purchase->PO_DATE:'';?>" required maxlength="20"/>
                        </div>
                    </div-->
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="DELIVERY_SCHEDULE">DELIVERY_SCHEDULE<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="DELIVERY_SCHEDULE" class="form-control datepicker" type="text" name="DELIVERY_SCHEDULE" value="<?php echo (isset($purchase->DELIVERY_SCHEDULE)) ? $purchase->DELIVERY_SCHEDULE:'';?>" required maxlength="20"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="REMARKS">REMARKS:</label>
                        <div class="col-sm-10">
                             <textarea rows="2" id="REMARKS" class="form-control" name="REMARKS"><?php echo (isset($purchase->REMARKS)) ? $purchase->REMARKS:'';?></textarea>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Supplier Detail</legend>
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="VENDOR_OUTSIDE_DELHI">Vendor Outside Delhi:</label>
                        <div class="col-sm-1">
                            <input id="VENDOR_OUTSIDE_DELHI" class="form-control stage" type="checkbox" name="VENDOR_OUTSIDE_DELHI" value="1" <?php echo (isset($purchase->VENDOR_OUTSIDE_DELHI)) ? 'disabled="disabled"':'';?>/>
                        </div>
                    </div-->
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="VENDOR_ID">Firm Name<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="VENDOR_ID" class="form-control chosen-select" name="VENDOR_ID" required>
                                <option value="">Select Vendor</option>
                                <?php foreach ($vendors as $vendor) { ?>
                                <option value='<?php echo $vendor->ID; ?>' <?php echo (isset($purchase->VENDOR_ID) && $vendor->ID == $purchase->VENDOR_ID) ? "selected=selected":"";?> data-vendor_json='<?php echo json_encode($vendor); ?>'>
                                    <?php echo $vendor->NAME; ?></option>
                                <?php } ?>
                            </select>
                            <input id="VENDOR_NAME" class="form-control" type="hidden" name="VENDOR_NAME" value="<?php echo (isset($purchase->VENDOR_NAME)) ? $purchase->VENDOR_NAME:'';?>" required maxlength="100"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php //echo "<pre>"; print_r($purchase); exit;?>
                        <label class="control-label col-sm-2 text-left" for="VENDOR_ADDRESS">VENDOR_ADDRESS<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="VENDOR_ADDRESS" class="form-control" type="text" name="VENDOR_ADDRESS" value="<?php echo (isset($purchase->VENDOR_ADDRESS)) ? $purchase->VENDOR_ADDRESS:'';?>" required readonly/>
                            <input id="VENDOR_STATE" class="form-control" type="hidden" name="VENDOR_STATE" value="<?php echo (isset($purchase->VENDOR_STATE)) ? $purchase->VENDOR_STATE:'';?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="GSTIN">GST No.<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="GSTIN" class="form-control" type="text" name="GSTIN" value="<?php echo (isset($purchase->GSTIN)) ? $purchase->GSTIN:'';?>" required readonly/>
                        </div>
                    </div>
                </fieldset>
                <legend>Item Details</legend>
                
                    <?php if(isset($purchaseMaterials)){ 
                        //print_r($purchaseMaterials);exit;
                        foreach($purchaseMaterials as $purchaseMaterial){ ?>
                    <fieldset id="Item" class="item">
                    <legend>Item Detail</legend>
                            <input class="form-control PURCHASE_MATERIAL_ID" type="hidden" name="PURCHASE_MATERIAL_ID[]" value="<?php echo (isset($purchaseMaterial->ID)) ? $purchaseMaterial->ID:'';?>" required/>
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
                            <input class="form-control UOM" type="text" name="UOM[]" value="<?php echo (isset($purchaseMaterial->UOM)) ? $purchaseMaterial->UOM:'';?>" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">Quantity<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control QUANTITY" type="text" name="QUANTITY[]" value="<?php echo (isset($purchaseMaterial->QUANTITY)) ? $purchaseMaterial->QUANTITY:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">Rate<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control RATE" type="text" name="RATE[]" value="<?php echo (isset($purchaseMaterial->RATE)) ? $purchaseMaterial->RATE:'';?>" required maxlength="50"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">Packaging & Forwarding:</label>
                        <div class="col-sm-10">
                            <input class="form-control PACKAGING_FORWARDING" type="text" name="PACKAGING_FORWARDING[]" value="<?php echo (isset($purchaseMaterial->PACKAGING_FORWARDING)) ? $purchaseMaterial->PACKAGING_FORWARDING:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">Freight:</label>
                        <div class="col-sm-10">
                            <input class="form-control FREIGHT" type="text" name="FREIGHT[]" value="<?php echo (isset($purchaseMaterial->FREIGHT)) ? $purchaseMaterial->FREIGHT:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    
                    <div class="form-group SGST">
                        <label class="control-label col-sm-2 text-left" for="inventory">SGST(<span class="SGST_PERCENTAGE"><?php echo $materials[$purchaseMaterial->MATERIAL_ID]->SGST; ?></span>)%<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control SGST" type="text" name="SGST[]" value="<?php echo (isset($purchaseMaterial->SGST)) ? $purchaseMaterial->SGST:'';?>" required readonly/>
                        </div>
                    </div>
                    <div class="form-group CGST">
                        <label class="control-label col-sm-2 text-left" for="inventory">CGST(<span class="CGST_PERCENTAGE"><?php echo $materials[$purchaseMaterial->MATERIAL_ID]->CGST; ?></span>)%<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control CGST" type="text" name="CGST[]" value="<?php echo (isset($purchaseMaterial->CGST)) ? $purchaseMaterial->CGST:'';?>" required readonly/>
                        </div>
                    </div>
                    <div class="form-group IGST">
                        <label class="control-label col-sm-2 text-left" for="inventory">IGST(<span class="IGST_PERCENTAGE"><?php echo $materials[$purchaseMaterial->MATERIAL_ID]->IGST; ?></span>)%<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control IGST" type="text" name="IGST[]" value="<?php echo (isset($purchaseMaterial->IGST)) ? $purchaseMaterial->IGST:'';?>" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">BASIC_PRICE<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control BASIC_PRICE" type="text" name="BASIC_PRICE[]" value="<?php echo (isset($purchaseMaterial->BASIC_PRICE)) ? $purchaseMaterial->BASIC_PRICE:'';?>" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">PRICE<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control PRICE" type="text" name="PRICE[]" value="<?php echo (isset($purchaseMaterial->PRICE)) ? $purchaseMaterial->PRICE:'';?>" required readonly/>
                        </div>
                    </div>
                    </fieldset>
                <?php } } else { ?>
                    <fieldset id="Item" class="item">
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
                        <label class="control-label col-sm-2 text-left" for="inventory">Packaging & Forwarding:</label>
                        <div class="col-sm-10">
                            <input class="form-control PACKAGING_FORWARDING" type="text" name="PACKAGING_FORWARDING[]" value="<?php echo (isset($purchaseMaterial->PACKAGING_FORWARDING)) ? $purchaseMaterial->PACKAGING_FORWARDING:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">Freight:</label>
                        <div class="col-sm-10">
                            <input class="form-control FREIGHT" type="text" name="FREIGHT[]" value="<?php echo (isset($purchaseMaterial->FREIGHT)) ? $purchaseMaterial->FREIGHT:'';?>" required maxlength="50"/>
                        </div>
                    </div>

                    <div class="form-group SGST">
                        <label class="control-label col-sm-2 text-left" for="inventory">SGST(<span class="SGST_PERCENTAGE"></span>)%<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control SGST" type="text" name="SGST[]" value="<?php echo (isset($purchase->SGST)) ? $purchase->SGST:'';?>" required readonly/>
                        </div>
                    </div>
                    <div class="form-group CGST">
                        <label class="control-label col-sm-2 text-left" for="inventory">CGST(<span class="CGST_PERCENTAGE"></span>)%<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control CGST" type="text" name="CGST[]" value="<?php echo (isset($purchase->CGST)) ? $purchase->CGST:'';?>" required readonly/>
                        </div>
                    </div>
                    <div class="form-group IGST">
                        <label class="control-label col-sm-2 text-left" for="inventory">IGST(<span class="IGST_PERCENTAGE"></span>)%<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control IGST" type="text" name="IGST[]" value="<?php echo (isset($purchase->IGST)) ? $purchase->IGST:'';?>" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">BASIC_PRICE<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control BASIC_PRICE" type="text" name="BASIC_PRICE[]" value="<?php echo (isset($purchase->BASIC_PRICE)) ? $purchase->BASIC_PRICE:'';?>" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="inventory">PRICE<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input class="form-control PRICE" type="text" name="PRICE[]" value="<?php echo (isset($purchase->PRICE)) ? $purchase->PRICE:'';?>" required readonly/>
                        </div>
                    </div>
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
        $("#purchaseForm").validate({
            rules: {
                    'QUANTITY[]': {number: true,required: true},
                    'RATE[]': {number: true,required:true},
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
            var newItem = $("#Item").clone().find("input").val("").end().find('option:first-child').attr('selected',false).end().trigger('chosen:updated').append('<button id="add-more-item" class="btn-danger remove-item">Remove Item</button>');
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
            calculateTotalPrice();
            return false;
        });

        $('#VENDOR_ID').on('change', function() {
            var vendor = JSON.parse($(this).children("option:selected").attr('data-vendor_json'));
            
            $("#VENDOR_NAME").val(vendor.NAME);
            $("#VENDOR_ADDRESS").val(vendor.ADDRESS_1+" "+vendor.ADDRESS_2+" "+vendor.CITY+" "+vendor.STATE+" "+vendor.COUNTRY);
            $("#VENDOR_STATE").val(vendor.STATE);
            $("#GSTIN").val(vendor.GSTIN);
            $("fieldset.item").each(function(){
                //console.log(this);
                calculatePrice(this);
            })
            
            calculateTotalPrice();
            /*
            if(vendor.STATE == "delhi"){
                $(".form-group.SGST,.form-group.CGST").hide();
                $(".form-group.IGST").show();
            }
            else{
                 $(".form-group.SGST,.form-group.CGST").show();
                $(".form-group.IGST").hide();
            }
            */
        });

        $(document).on('change','.MATERIAL_ID', function() {
            $("#btnSubmit").attr("disabled", true);
            var material_json = JSON.parse($(this).children("option:selected").attr('data-material_json'));
            var parent = $(this).closest("fieldset");
            var material = $(this).children("option:selected");
            var material_id = $(material).val();
            var material_count = 0;
            $(".MATERIAL_ID").each(function(key,value){
                console.log($(value).children("option:selected").val());
                if(material_id == $(value).children("option:selected").val()) {
                    material_count += 1;
                }
            });
            if(material_count > 1) {
                alert("Please select different material");
                console.log(material);
                $(this).val('').trigger('chosen:updated');
                return false;
            }
            //console.log(material_json);
            //console.log(material_json.ITEM_NAME);
            $(parent).find(".ITEM_NAME").val(material_json.ITEM_NAME);
            $(parent).find(".UOM").val(material_json.UOM);
            $(parent).find(".SGST_PERCENTAGE").html(material_json.SGST);
            $(parent).find(".CGST_PERCENTAGE").html(material_json.CGST);
            $(parent).find(".IGST_PERCENTAGE").html(material_json.IGST);
            $(parent).find(".QUANTITY").val(0);
            $(parent).find(".RATE").val(0);
            $(parent).find(".PACKAGING_FORWARDING").val(0);
            $(parent).find(".FREIGHT").val(0);
            $(parent).find(".SGST").val(0);
            $(parent).find(".CGST").val(0);
            $(parent).find(".IGST").val(0);
            $(parent).find(".BASIC_PRICE").val(0);
            $(parent).find(".PRICE").val(0);
            $('#btnSubmit').removeAttr("disabled");
        });
        $(document).on('change','.QUANTITY, .RATE, .PACKAGING_FORWARDING, .FREIGHT', function() {
            var parent = $(this).closest("fieldset");
            calculatePrice(parent);
            //calculatePrice($(this));
            calculateTotalPrice();
        });
        function calculatePrice(parent) {
            var vendor_state= $("#VENDOR_STATE").val();
            //var parent      = thisObj.closest("fieldset");
            var quantity    = parseFloat($(parent).find(".QUANTITY").val()) || 0;
            var rate        = parseFloat($(parent).find(".RATE").val()) || 0;
            var pkg         = parseFloat($(parent).find(".PACKAGING_FORWARDING").val()) || 0;
            var freight     = parseFloat($(parent).find(".FREIGHT").val()) || 0;
            var sgst        = parseFloat($(parent).find(".SGST_PERCENTAGE").html()) || 0;
            var cgst        = parseFloat($(parent).find(".CGST_PERCENTAGE").html()) || 0;
            var igst        = parseFloat($(parent).find(".IGST_PERCENTAGE").html()) || 0;
            var basic_price = parseFloat(quantity*rate);
            var sgst_price  = parseFloat(parseFloat((basic_price+pkg)*(sgst/100)).toFixed(2));
            var cgst_price  = parseFloat(parseFloat((basic_price+pkg)*(cgst/100)).toFixed(2));
            var igst_price  = parseFloat(parseFloat((basic_price+pkg)*(igst/100)).toFixed(2));

            if(vendor_state.toLowerCase() == "delhi"){
                igst_price = 0;
            }
            else{
                sgst_price = 0;
                cgst_price = 0; 
            }
            var price       = parseFloat(basic_price + pkg + freight + sgst_price + cgst_price + igst_price);
            price = price.toFixed(2)
            console.log("rate:"+rate+"quantity:"+quantity+"pkg:"+pkg+"freight:"+freight+"sgst:"+sgst+"cgst:"+cgst+"igst:"+igst+"sgst_price:"+sgst_price+"cgst_price"+cgst_price+"igst_price"+igst_price);
            $(parent).find(".SGST").val(sgst_price);
            $(parent).find(".CGST").val(cgst_price);
            $(parent).find(".IGST").val(igst_price);
            $(parent).find(".BASIC_PRICE").val(basic_price);
            $(parent).find(".PRICE").val(price);
        }
        function calculateTotalPrice(){
            var total_price = 0;
            $(".PRICE").each(function(){
                var price = parseFloat($(this).val());
                total_price += price;
            });
            total_price = total_price.toFixed(2)
            $("#TOTAL_PRICE").val(total_price);
        }
    });
</script>