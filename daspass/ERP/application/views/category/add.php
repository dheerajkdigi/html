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
            Category Management
            <small><?php echo ucfirst($this->router->fetch_method()); ?> Category Content</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="<?php echo base_url('category'); ?>"><i class="fa fa-role"></i> Category Management</a></li>
            <li class="active"> <?php echo ucfirst($this->router->fetch_method()); ?> Category Content</li>
        </ol>
    </section>
    <form role="form" id="categoryForm" class="form-horizontal" name="categoryForm" action="<?php echo $form_action;?>" method="POST">
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <input id="method" type="hidden" name="method" value="<?php echo $this->router->fetch_method(); ?>"/>

            <div class="box-body">
                <div class="form-group">
                    <label class="control-label col-sm-2 text-left" for="NAME">Name<span class="required">*</span>:</label>
                    <div class="col-sm-10">
                        <input id="NAME" class="form-control" type="text" name="NAME" value="<?php echo (isset($category->NAME)) ? $category->NAME:'';?>" required maxlength="50"/>
                    </div>
                </div>
                
            </div>

        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?php echo base_url('category'); ?>" class="btn btn-danger">Cancel</a>
        </div>
        <div id='line-example'></div>
    </section>
    <!-- /.content -->
    </form>
</aside><!-- /.right-side -->
<script type="text/javascript">
    $('document').ready(function() {
        /*-------------------------- Form Validation -------------------------*
        $.validator.addMethod('contentIds', function(value) {
            var contents = /^[0-9,]*$/;    
            return value.match(contents);
        }, 'Invalid Content Ids');
	
        $("#categoryForm").validate({
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
   
</script>