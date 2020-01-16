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
        <div class="box">
            <input id="method" type="hidden" name="method" value="<?php echo $this->router->fetch_method(); ?>"/>

            <div class="box-body">
                <div class="form-group">
                    <label class="control-label col-sm-2 text-left" for="NAME">Name<span class="required">*</span>:</label>
                    <div class="col-sm-10">
                        <input id="NAME" class="form-control" type="text" name="NAME" value="<?php echo (isset($customer->NAME) && ($this->router->fetch_method()!='copy') ) ? $customer->NAME:'';?>" required maxlength="50"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 text-left" for="ADDRESS">Address<span class="required">*</span>:</label>
                    <div class="col-sm-10">
                        <!--input id="ADDRESS" class="form-control" type="text_area" name="ADDRESS" value="<?php echo (isset($customer->ADDRESS)) ? $customer->ADDRESS:'';?>" required maxlength="50"/-->
                         <textarea rows="2" id="ADDRESS" class="form-control" name="ADDRESS" required>
                        <?php echo (isset($customer->ADDRESS)) ? $customer->ADDRESS:'';?>
                    </textarea>
                    </div>

                   
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 text-left" for="CONTACT_NO">Contact No.<span class="required">*</span>:</label>
                    <div class="col-sm-10">
                        <input id="CONTACT_NO" class="form-control" type="text" name="CONTACT_NO" value="<?php echo (isset($customer->CONTACT_NO)) ? $customer->CONTACT_NO:'';?>" required maxlength="50"/>
                    </div>
                </div>
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
        /*-------------------------- Form Validation -------------------------*
        $.validator.addMethod('contentIds', function(value) {
            var contents = /^[0-9,]*$/;    
            return value.match(contents);
        }, 'Invalid Content Ids');
	
        $("#customerForm").validate({
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
    });
</script>