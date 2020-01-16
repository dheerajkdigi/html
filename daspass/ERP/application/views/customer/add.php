<style>
.chosen-container{width: 100% !important}
input.default{width: 100% !important}
</style>
<link rel="stylesheet" href="<?php echo base_url('assets/chosen'); ?>/chosen.css">
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Customer Management
            <small><?php echo ucfirst($this->router->fetch_method()); ?> Customer</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="<?php echo base_url('customer'); ?>"><i class="fa fa-role"></i> Customer Management</a></li>
            <li class="active"> <?php echo ucfirst($this->router->fetch_method()); ?> Customer</li>
        </ol>
    </section>
    <form role="form" id="customerForm" class="form-horizontal" name="customerForm" action="<?php echo $form_action;?>" method="post" enctype="multipart/form-data">
    <!-- Main content -->
    <section class="content">
        <div>
            <a href="javascript:window.history.back();" class="btn btn-danger btn-lg">Back</a>
        </div>
        <div class="box">

            <div class="box-body">
                <section id="customer">
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="NAME">Name<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="NAME" class="form-control" type="text" name="NAME" value="<?php echo (isset($customer->NAME)) ? $customer->NAME:'';?>" required maxlength="100"/>
                        </div>
                    </div>
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="NAME">Print Name<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="PRINT_NAME" class="form-control" type="text" name="PRINT_NAME" value="<?php echo (isset($customer->PRINT_NAME) ) ? $customer->PRINT_NAME:'';?>" required maxlength="100"/>
                        </div>
                    </div-->
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CATEGORY">Category<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="CATEGORY" class="form-control" name="CATEGORY" required>
                                <option value="">Select category</option>
                                <option value='CREDITOR' <?php echo (isset($customer->CATEGORY) && $customer->CATEGORY == 'CREDITOR') ? "selected=selected":"";?>>Creditor</option>
                                <option value='DEBTOR' <?php echo (isset($customer->CATEGORY) && $customer->CATEGORY == 'DEBTOR') ? "selected=selected":"";?>>Debtor</option>
                                <option value='DEBTOR-CREDITOR' <?php echo (isset($customer->CATEGORY) && $customer->CATEGORY == 'DEBTOR-CREDITOR') ? "selected=selected":"";?>>Debtor-Creditor</option>
                            </select>
                        </div>
                    </div!-->
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CODE">Code<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="CODE" class="form-control" type="text" name="CODE" value="<?php echo (isset($customer->CODE)) ? $customer->CODE:'';?>" maxlength="50"/>
                        </div>
                    </div-->
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="OPENING_AMOUNT">Opening Amount<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="OPENING_AMOUNT" class="form-control" type="text" name="OPENING_AMOUNT" value="<?php echo (isset($customer->OPENING_AMOUNT)) ? $customer->OPENING_AMOUNT:'';?>" maxlength="10"/>
                        </div>
                    </div>
                    <hr/>
                </section>
                <section id="company">
                    <h4>Company Information</h4>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CONTACT_PERSON">Contact Person<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="CONTACT_PERSON" class="form-control" type="text" name="CONTACT_PERSON" value="<?php echo (isset($customer->CONTACT_PERSON)) ? $customer->CONTACT_PERSON:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="MOBILE">Mobile Number<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="MOBILE" class="form-control" type="text" name="MOBILE" value="<?php echo (isset($customer->MOBILE)) ? $customer->MOBILE:'';?>" required minlength="10" maxlength="10"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="EMAIL_ID">Email ID<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="EMAIL_ID" class="form-control" type="text" name="EMAIL_ID" value="<?php echo (isset($customer->EMAIL_ID)) ? $customer->EMAIL_ID:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PIN_CODE">Pin Code<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="PIN_CODE" class="form-control" type="text" name="PIN_CODE" value="<?php echo (isset($customer->PIN_CODE)) ? $customer->PIN_CODE:'';?>" required minlength="6" maxlength="6"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ADDRESS_1">Address 1<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="ADDRESS_1" class="form-control" type="text" name="ADDRESS_1" value="<?php echo (isset($customer->ADDRESS_1)) ? $customer->ADDRESS_1:'';?>" required maxlength="200"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ADDRESS_2">Address 2<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="ADDRESS_2" class="form-control" type="text" name="ADDRESS_2" value="<?php echo (isset($customer->ADDRESS_2)) ? $customer->ADDRESS_2:'';?>" required maxlength="200"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CITY">City<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="CITY" class="form-control" type="text" name="CITY" value="<?php echo (isset($customer->CITY)) ? $customer->CITY:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="STATE">State<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="STATE" class="form-control" type="text" name="STATE" value="<?php echo (isset($customer->STATE)) ? $customer->STATE:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="COUNTRY">Country<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="COUNTRY" class="form-control" type="text" name="COUNTRY" value="India" maxlength="50" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="WEBSITE">Website<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="WEBSITE" class="form-control" type="text" name="WEBSITE" value="<?php echo (isset($customer->WEBSITE)) ? $customer->WEBSITE:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PHONE">Phone No.<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="PHONE" class="form-control" type="text" name="PHONE" value="<?php echo (isset($customer->PHONE)) ? $customer->PHONE:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="FAX">Fax No.<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="FAX" class="form-control" type="text" name="FAX" value="<?php echo (isset($customer->FAX)) ? $customer->FAX:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <hr/>
                </section>
                <section id="statutory">
                    <h4>Statutory Information</h4>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PAN">Pan No.:</label>
                        <div class="col-sm-10">
                            <input id="PAN" class="form-control" type="text" name="PAN" value="<?php echo (isset($customer->PAN)) ? $customer->PAN:'';?>" maxlength="10" onkeyup="this.value = this.value.toUpperCase();"/>
                        </div>
                    </div>
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="TAN">Tan No.<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="TAN" class="form-control" type="text" name="TAN" value="<?php echo (isset($customer->TAN)) ? $customer->TAN:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="COMMODITY">Commodity<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="COMMODITY" class="form-control" type="text" name="COMMODITY" value="<?php echo (isset($customer->COMMODITY)) ? $customer->COMMODITY:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ECC">E.C.C. No.<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="ECC" class="form-control" type="text" name="ECC" value="<?php echo (isset($customer->ECC)) ? $customer->ECC:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="RC">R.C. No.<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="RC" class="form-control" type="text" name="RC" value="<?php echo (isset($customer->RC)) ? $customer->RC:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="DIVISION">Division<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="DIVISION" class="form-control" type="text" name="DIVISION" value="<?php echo (isset($customer->DIVISION)) ? $customer->DIVISION:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="C_RANGE">Range<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="C_RANGE" class="form-control" type="text" name="C_RANGE" value="<?php echo (isset($customer->C_RANGE)) ? $customer->C_RANGE:'';?>" maxlength="50"/>
                        </div>
                    </div-->
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="GSTIN">GSTIN<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="GSTIN" class="form-control" type="text" name="GSTIN" value="<?php echo (isset($customer->GSTIN)) ? $customer->GSTIN:'';?>" maxlength="15" onkeyup="this.value = this.value.toUpperCase();"/>
                        </div>
                    </div>
                    <!--div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="COMMISSIONRATE">Commissionrate<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="COMMISSIONRATE" class="form-control" type="text" name="COMMISSIONRATE" value="<?php echo (isset($customer->COMMISSIONRATE)) ? $customer->COMMISSIONRATE:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="TIN">Tin No.<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="TIN" class="form-control" type="text" name="TIN" value="<?php echo (isset($customer->TIN)) ? $customer->TIN:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="TIN_DATE">TIN Date<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="TIN_DATE" class="form-control" type="text" name="TIN_DATE" value="<?php echo (isset($customer->TIN_DATE) && $customer->TIN_DATE!="0000-00-00") ? $customer->TIN_DATE:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CST">CST No.<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="CST" class="form-control" type="text" name="CST" value="<?php echo (isset($customer->CST)) ? $customer->CST:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CST_DATE">CST Date<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="CST_DATE" class="form-control" type="text" name="CST_DATE" value="<?php echo (isset($customer->CST_DATE) && $customer->CST_DATE!="0000-00-00") ? $customer->CST_DATE:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="SERVICE_TAX_NO">Service Tax No.<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="SERVICE_TAX_NO" class="form-control" type="text" name="SERVICE_TAX_NO" value="<?php echo (isset($customer->SERVICE_TAX_NO)) ? $customer->SERVICE_TAX_NO:'';?>" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="REG_DATE">Reg. Date<span class="required"></span>:</label>
                        <div class="col-sm-10">
                            <input id="REG_DATE" class="form-control" type="text" name="REG_DATE" value="<?php echo (isset($customer->REG_DATE) && $customer->REG_DATE!="0000-00-00") ? $customer->REG_DATE:'';?>" maxlength="50"/>
                        </div>
                    </div-->
                </section>
            </div>

        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?php echo base_url('customer'); ?>" class="btn btn-danger">Cancel</a>
        </div>
        <div id='line-example'></div>
    </section>
    <!-- /.content -->
    </form>
</aside><!-- /.right-side -->
<script src="<?php echo base_url('assets/chosen'); ?>/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    $('document').ready(function() {
        /*-------------------------- Form Validation -------------------------*/
        $.validator.addMethod("pan", function(value, element) {
            return this.optional(element) || /^[A-Z]{5}\d{4}[A-Z]{1}$/.test(value);
        }, "Please enter a valid PAN");
        $.validator.addMethod("gstin", function(value, element) {
            return this.optional(element) || /^0[1-9]|^[1-2][0-9]|^3[0-5][A-Z]{5}\d{4}[A-Z]{1}[1-2]Z[A-Z0-9]{1}$/.test(value);
            //[01-35]{2}[A-Z]{5}\d{4}[A-Z]{1}[1-2]Z[A-Z0-9]{1}
        }, "Please enter a valid GSTIN");
        $("#customerForm").validate({
            rules: {
                    MOBILE: {digits: true,},
                    PIN_CODE: {digits:true},
                    EMAIL_ID: {email:true},
                    PAN: {pan:true},
                    GSTIN: {gstin:true},
            },
            invalidHandler: function(event, validator) {
                // 'this' refers to the form
                var errors = validator.numberOfInvalids();
                /*
                if (errors) {
                var message = errors == 1
                    $('#myModal').modal('hide');
                } else {
                //$("div.error").hide();
                }
                */
            }
        });
        /*--------------------------------------------------------------------*/
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
    /*------------------------ Image Preview ---------------------------------*/
    $("#customerForm").on('change','#customer_image',function () {
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
        $('#category_id').on('change', function () {
            var selectVal = $("#category_id option:selected").data('unit');
            $("#category-unit").html(selectVal);
        });
        $('#PIN_CODE').on('focusout', function(){
            var pincode = $(this).val();
            //alert(pincode.length);
            if(!isNaN(pincode) && pincode.length == 6) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('vendor/pinCodeDetail/'); ?>/"+pincode,
                    data: { 'ajax': true },
                    dataType: "json",
                    success: function(data) {
                            //console.log(data);
                            if(data.state) {
                                $("#STATE").val(data.state);
                                $("#CITY").val(data.district); 
                            } else {
                                alert("Pincode detail not found");
                                $("#STATE").val('');
                                $("#CITY").val('');
                            }
                    },
                    error: function(e) {
                            //called when there is an error
                            console.log(e.message);
                            return false;
                    }
                });
            }
        });
    });
</script>