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
        <div class="box">
            <input id="method" type="hidden" name="method" value="<?php echo $this->router->fetch_method(); ?>"/>

            <div class="box-body">
                <fieldset>
                    <legend>Customer Detail</legend>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="NAME">Name<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="NAME" class="form-control" type="text" name="NAME" value="<?php echo (isset($order->NAME) && ($this->router->fetch_method()!='copy') ) ? $order->NAME:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ADDRESS">Address<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                             <textarea rows="2" id="ADDRESS" class="form-control" name="ADDRESS" required>
                            <?php echo (isset($order->ADDRESS)) ? $order->ADDRESS:'';?>
                        </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CONTACT_NO">Contact No.<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="CONTACT_NO" class="form-control" type="text" name="CONTACT_NO" value="<?php echo (isset($order->CONTACT_NO)) ? $order->CONTACT_NO:'';?>" required maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
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
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PAYMENT_TERM">Payment Term<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                             <textarea rows="2" id="PAYMENT_TERM" class="form-control" name="PAYMENT_TERM" required>
                            <?php echo (isset($order->PAYMENT_TERM)) ? $order->PAYMENT_TERM:'';?>
                        </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="DELIVERY_TERM">Delivery Term<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                             <textarea rows="2" id="DELIVERY_TERM" class="form-control" name="DELIVERY_TERM" required>
                            <?php echo (isset($order->DELIVERY_TERM)) ? $order->DELIVERY_TERM:'';?>
                        </textarea>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Item Detail</legend>
                    <div class="form-group" id="Item">
                        <label class="control-label col-sm-2 text-left" for="inventory">Item<span class="required">*</span>:</label>
                        <div class="col-sm-6">
                            <select id="inventory_id" class="form-control inventory" name="inventory_id[]" required>
                                <option value="">Select inventories</option>
                                <?php foreach ($inventories as $inventory) { ?>
                                <option value='<?php echo $inventory->ID; ?>' <?php echo (isset($inventory->CATEGORY_ID) && $inventory->CATEGORY_ID == $inventory->ID) ? "selected=selected":"";?> data-unit="<?php echo $inventory->UNIT; ?>"><?php echo $inventory->NAME; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input class="form-control QUANTITY" type="text" name="QUANTITY[]" value="<?php echo (isset($order->QUANTITY)) ? $order->QUANTITY:'';?>" required maxlength="50"/>
                        </div>
                        <div class="inventory-unit col-sm-1 bold"></div>
                    </div>
                    <button id="add-more-item" class="btn-primary">Add More Item</button>
                </fieldset>
            </div>

        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Save</button>
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
        /*-------------------------- Form Validation -------------------------*
        $.validator.addMethod('contentIds', function(value) {
            var contents = /^[0-9,]*$/;    
            return value.match(contents);
        }, 'Invalid Content Ids');
	
        $("#orderForm").validate({
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
    $("#orderForm").on('change','#order_image',function () {
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
            var newItem = $("#Item").clone().append('<div class="col-sm-1 remove-item text-danger" style="cursor: pointer;">X</div>');
            $(this).before(newItem);
        });
        $(document.body).on('click', '.remove-item' ,function(){
            $(this).parents("#Item").remove();
        });
    });
</script>