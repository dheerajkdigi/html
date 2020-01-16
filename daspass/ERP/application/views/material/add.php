<style>
.chosen-container{width: 100% !important}
input.default{width: 100% !important}
</style>
<!--link rel="stylesheet" href="<?php echo base_url('assets/chosen'); ?>/chosen.css"-->
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Material Management
            <small><?php echo ucfirst($this->router->fetch_method()); ?> Material Content</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="<?php echo base_url('material'); ?>"><i class="fa fa-role"></i> Material Management</a></li>
            <li class="active"> <?php echo ucfirst($this->router->fetch_method()); ?> Material Content</li>
        </ol>
    </section>
    <form role="form" id="materialForm" class="form-horizontal" name="materialForm" action="<?php echo $form_action;?>" method="post" enctype="multipart/form-data">
    <!-- Main content -->
    <section class="content">
        <div>
            <a href="javascript:window.history.back();" class="btn btn-danger btn-lg">Back</a>
        </div>
        <div class="box">
            <div class="box-body">
                <?php //debug($material);?>
                <section id="material">
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="MATERIAL_GROUP_ID">Material Group<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="MATERIAL_GROUP_ID" class="form-control" name="MATERIAL_GROUP_ID" required>
                                <option value="">Select Group</option>
                                <?php foreach ($materialGroups as $key => $materialGroup) { ?>
                                    <option value='<?php echo $materialGroup->ID; ?>' <?php echo (isset($material->MATERIAL_GROUP_ID) && $material->MATERIAL_GROUP_ID == $materialGroup->ID) ? "selected=selected":"";?>><?php echo $materialGroup->MATERIAL_GROUP_NAME; ?></option>
                               <?php } ?>
                            </select>
                            <input type="hidden" id="MATERIAL_GROUP_NAME" name="MATERIAL_GROUP_NAME">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="MATERIAL_SUB_GROUP_ID">Material Sub Group<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="MATERIAL_SUB_GROUP_ID" class="form-control" name="MATERIAL_SUB_GROUP_ID" required>
                            </select>
                            <input type="hidden" id="MATERIAL_SUB_GROUP_NAME" name="MATERIAL_SUB_GROUP_NAME">
                        </div>
                    </div>
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ITEM_CODE">Item Code<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="ITEM_CODE" class="form-control" type="text" name="ITEM_CODE" value="<?php echo (isset($material->ITEM_CODE) ) ? $material->ITEM_CODE:'';?>" required maxlength="100"/>
                        </div>
                    </div-->
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ITEM_NAME">Item Name<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="ITEM_NAME" class="form-control" type="text" name="ITEM_NAME" value="<?php echo (isset($material->ITEM_NAME) ) ? $material->ITEM_NAME:'';?>" required maxlength="200"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="DESCRIPTION">Description<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="DESCRIPTION" class="form-control" type="text" name="DESCRIPTION" value="<?php echo (isset($material->DESCRIPTION) ) ? $material->DESCRIPTION:'';?>" required maxlength="200"/>
                        </div>
                    </div>
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="HSN_CODE">HSN Code<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="HSN_CODE" class="form-control" type="text" name="HSN_CODE" value="<?php echo (isset($material->HSN_CODE) ) ? $material->HSN_CODE:'';?>" required maxlength="200"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CLASS">Class<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="CLASS" class="form-control" name="CLASS" required>
                                <option value="">Select Class</option>
                                <option value='CLASS_1' <?php echo (isset($material->CLASS) && $material->CLASS == 'CLASS_1') ? "selected=selected":"";?>>CLASS_1</option>
                                <option value='CLASS_2' <?php echo (isset($material->CLASS) && $material->CLASS == 'CLASS_2') ? "selected=selected":"";?>>CLASS_2</option>
                            </select>
                        </div>
                    </div-->
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="UOM">UOM<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="UOM" class="form-control" type="text" name="UOM" value="<?php echo (isset($material->UOM) ) ? $material->UOM:'';?>" required maxlength="10"/>
                        </div>
                    </div>
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CONV_UOM">Conv. UOM<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="CONV_UOM" class="form-control" type="text" name="CONV_UOM" value="<?php echo (isset($material->CONV_UOM) ) ? $material->CONV_UOM:'';?>" required maxlength="10"/>
                        </div>
                    </div-->
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CONV_FACTOR">Conv. Factor<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="CONV_FACTOR" class="form-control" type="text" name="CONV_FACTOR" value="<?php echo (isset($material->CONV_FACTOR) && $material->CONV_FACTOR) ? $material->CONV_FACTOR:'';?>" required maxlength="100"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="SHOW_REPORT">Show Report<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="SHOW_REPORT" class="form-control" name="SHOW_REPORT" required>
                                <option value="">Select Show Report</option>
                                <option value='1' <?php echo (isset($material->SHOW_REPORT) && $material->SHOW_REPORT == '1') ? "selected=selected":"";?>>Yes</option>
                                <option value='0' <?php echo (isset($material->SHOW_REPORT) && $material->SHOW_REPORT == '0') ? "selected=selected":"";?>>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="BATCH_TYPE">Batch Type<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="BATCH_TYPE" class="form-control" name="BATCH_TYPE" required>
                                <option value="">Select Batch Type</option>
                                <option value='1' <?php echo (isset($material->BATCH_TYPE) && $material->BATCH_TYPE == '1') ? "selected=selected":"";?>>Yes</option>
                                <option value='0' <?php echo (isset($material->BATCH_TYPE) && $material->BATCH_TYPE == '0') ? "selected=selected":"";?>>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PO_TOLERANCE">PO Tolerance<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="PO_TOLERANCE" class="form-control" type="text" name="PO_TOLERANCE" value="<?php echo (isset($material->PO_TOLERANCE) && $material->PO_TOLERANCE) ? $material->PO_TOLERANCE:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="RATE_PICK">Rate Pick<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="RATE_PICK" class="form-control" name="RATE_PICK" required>
                                <option value="">Select Rate Pick</option>
                                <option value='RATE_PICK_1' <?php echo (isset($material->RATE_PICK) && $material->RATE_PICK == 'RATE_PICK_1') ? "selected=selected":"";?>>RATE_PICK_1</option>
                                <option value='RATE_PICK_2' <?php echo (isset($material->RATE_PICK) && $material->RATE_PICK == 'RATE_PICK_2') ? "selected=selected":"";?>>RATE_PICK_2</option>
                            </select>
                        </div>
                    </div>
                </section>
                <hr/>
                <!--section id="item_image">
                    <h4>Item Image</h4>
                </section-->
                <!--section id="item_price">
                    <h4>Item Price</h4>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="COST_RATE">Cost Rate<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="COST_RATE" class="form-control" type="text" name="COST_RATE" value="<?php echo (isset($material->COST_RATE) && $material->COST_RATE) ? $material->COST_RATE:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="MRP_RATE">MRP Rate<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="MRP_RATE" class="form-control" type="text" name="MRP_RATE" value="<?php echo (isset($material->MRP_RATE) && $material->MRP_RATE) ? $material->MRP_RATE:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="SALES_RATE">Sales Rate<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="SALES_RATE" class="form-control" type="text" name="SALES_RATE" value="<?php echo (isset($material->SALES_RATE) && $material->SALES_RATE) ? $material->SALES_RATE:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="INTEGRATED_TAX">Integrated Tax<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="INTEGRATED_TAX" class="form-control" type="text" name="INTEGRATED_TAX" value="<?php echo (isset($material->INTEGRATED_TAX) && $material->INTEGRATED_TAX) ? $material->INTEGRATED_TAX:'';?>" maxlength="50"/>
                        </div>
                    </div>
                </section-->
                <hr/>
                <section id="tax">
                    <h4>Tax</h4>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="SGST">SGST<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <select id="SGST" class="form-control" name="SGST" required>
                                <option value="">Select SGST</option>
                                <?php foreach ($gstSlabs as $key => $gstSlab) { ?>
                                    <option value='<?php echo $gstSlab; ?>' <?php echo (isset($material->SGST) && $material->SGST == $gstSlab) ? "selected=selected":"";?>><?php echo $gstSlab; ?> %</option>
                               <?php } ?>
                            </select>
                            <!--input id="SGST" class="form-control" type="text" name="SGST" value="<?php echo (isset($material->SGST) && $material->SGST) ? $material->SGST:'';?>" maxlength="2"/-->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CGST">CGST<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <select id="CGST" class="form-control" name="CGST" required>
                                <option value="">Select CGST</option>
                                <?php foreach ($gstSlabs as $key => $gstSlab) { ?>
                                    <option value='<?php echo $gstSlab; ?>' <?php echo (isset($material->CGST) && $material->CGST == $gstSlab) ? "selected=selected":"";?>><?php echo $gstSlab; ?> %</option>
                               <?php } ?>
                            </select>
                            <!--input id="CGST" class="form-control" type="text" name="CGST" value="<?php echo (isset($material->CGST) && $material->CGST) ? $material->CGST:'';?>" maxlength="2"/-->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="IGST">IGST<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="IGST" class="form-control" type="text" name="IGST" value="<?php echo (isset($material->IGST) && $material->IGST) ? $material->IGST:'';?>" />
                        </div>
                    </div>
                </section>
                <hr/>
                <section id="critical_level">
                    <h4>Critical Level</h4>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="MAX_LEVEL">Maximum Level<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="MAX_LEVEL" class="form-control" type="text" name="MAX_LEVEL" value="<?php echo (isset($material->MAX_LEVEL) && $material->MAX_LEVEL) ? $material->MAX_LEVEL:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="MIN_LEVEL">Minimum Level<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="MIN_LEVEL" class="form-control" type="text" name="MIN_LEVEL" value="<?php echo (isset($material->MIN_LEVEL) && $material->MIN_LEVEL) ? $material->MIN_LEVEL:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="REORDER_LEVEL">Reorder Level<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="REORDER_LEVEL" class="form-control" type="text" name="REORDER_LEVEL" value="<?php echo (isset($material->REORDER_LEVEL) && $material->REORDER_LEVEL) ? $material->REORDER_LEVEL:'';?>" maxlength="50"/>
                        </div>
                    </div>
                </section>
                <hr/>
                <section id="location">
                    <h4>Location</h4>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ITEM_NAME">Item Location<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="ITEM_LOCATION" class="form-control" type="text" name="ITEM_LOCATION" value="<?php echo (isset($material->ITEM_LOCATION) ) ? $material->ITEM_LOCATION:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                </section>
                <section id="location">
                    <h4>STORE_QUANTITY</h4>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="STORE_QUANTITY ">Store Quantity<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="STORE_QUANTITY" class="form-control" type="text" name="STORE_QUANTITY" value="<?php echo (isset($material->STORE_QUANTITY) ) ? $material->STORE_QUANTITY :'';?>" required maxlength="50"/>
                        </div>
                    </div>
                </section>
            </div>

        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?php echo base_url('material'); ?>" class="btn btn-danger">Cancel</a>
        </div>
        <div id='line-example'></div>
    </section>
    <!-- /.content -->
    </form>
</aside><!-- /.right-side -->
<!--script src="<?php echo base_url('assets/chosen'); ?>/chosen.jquery.js" type="text/javascript"></script-->
<script type="text/javascript">
    $('document').ready(function() {
        /*-------------------------- Form Validation -------------------------*/
        /*
        $.validator.addMethod('contentIds', function(value) {
            var contents = /^[0-9,]*$/;    
            return value.match(contents);
        }, 'Invalid Content Ids');
        */
        $("#materialForm").validate({
            rules: {
                    //SGST: {digits: true,},
                    //CGST: {digits:true},
                    MAX_LEVEL: {digits:true},
                    MIN_LEVEL: {digits:true},
                    REORDER_LEVEL: {digits:true},
            },
            invalidHandler: function(event, validator) {
                // 'this' refers to the form
                var errors = validator.numberOfInvalids();
            }
        });
        /*--------------------------------------------------------------------*/

        var materailGroupId = $('#MATERIAL_GROUP_ID').find("option:selected").val();
        var materailSubGroupId = "<?php echo (isset($material->MATERIAL_SUB_GROUP_ID) && $material->MATERIAL_SUB_GROUP_ID) ? $material->MATERIAL_SUB_GROUP_ID:0; ?>";
        
        if(materailGroupId){
            getSubGroup(materailGroupId);
        }
        $('#MATERIAL_GROUP_ID').on('change', function() {
            var materailGroupId = $(this).val();
            getSubGroup(materailGroupId);
            /*
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('material/sub_group_list/'); ?>/"+materailGroupId,
                data: { 'ajax': true },
                dataType: "json",
                success: function(data) {
                        //console.log(data);console.log(data.materialSubGroups);
                        var options = '<option value="">Select Group</option>';
                        $.each(data.materialSubGroups, function(index,val){
                            //console.log(val);
                            options += "<option value='"+val.ID+"'>"+val.MATERIAL_SUB_GROUP_NAME+"</option>";
                        });
                        $("#MATERIAL_SUB_GROUP_ID").html(options);
                },
                error: function(e) {
                        //called when there is an error
                        console.log(e.message);
                        return false;
                }
            });
            */

        });

        function getSubGroup(materailGroupId){
            var materailGroupName = $("#MATERIAL_GROUP_ID").find("option:selected").text();
            $("#MATERIAL_GROUP_NAME").val(materailGroupName);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('material/sub_group_list/'); ?>/"+materailGroupId,
                data: { 'ajax': true },
                dataType: "json",
                success: function(data) {
                        //console.log(data);console.log(data.materialSubGroups);
                        //alert(materailSubGroupId);
                        var options = '<option value="">Select Group</option>';
                        $.each(data.materialSubGroups, function(index,val){
                            //console.log(val);
                            selected = (materailSubGroupId == val.ID) ? "selected=selected" : "";
                            //alert(materailSubGroupId);alert(val.ID);
                            options += "<option value='"+val.ID+"' "+selected+">"+val.MATERIAL_SUB_GROUP_NAME+"</option>";
                        });
                        $("#MATERIAL_SUB_GROUP_ID").html(options);
                },
                error: function(e) {
                        //called when there is an error
                        console.log(e.message);
                        return false;
                }
            });
        }
        $('#MATERIAL_SUB_GROUP_ID').on('change', function() {
            var materailSubGroupName = $(this).find("option:selected").text();
            //alert(materailGroupName);
            $("#MATERIAL_SUB_GROUP_NAME").val(materailSubGroupName);
        }).trigger('change');
        /*
        if(materailSubGroupId){
            console.log(materailSubGroupId);
            var materailSubGroupName = $('#MATERIAL_SUB_GROUP_ID').find("option:selected").text();
            //alert(materailGroupName);
            $("#MATERIAL_SUB_GROUP_NAME").val(materailSubGroupName);
        };
        */
        $('#SGST,#CGST').on('change', function() {
            var sgst = parseFloat($("#SGST").val()) || 0;
            var cgst = parseFloat($("#CGST").val()) || 0;
            var igst = sgst + cgst;
            $("#IGST").val(igst);
        });
    });
    
     $( "#sortable" ).on( "sortupdate", function( event, ui ) {
        //console.log(ui);
        //updateOrder();
    } );
   
    
    /*-------------------- Chose plugin for searchable dropdown --------------*
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
    
</script>