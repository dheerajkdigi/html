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
                        <label class="control-label col-sm-2 text-left" for="MATERIAL_GROUP_NAME">Group Name<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="MATERIAL_GROUP_NAME" class="form-control" type="text" name="MATERIAL_GROUP_NAME" value="<?php echo (isset($material->MATERIAL_GROUP_NAME) ) ? $material->MATERIAL_GROUP_NAME:'';?>" required maxlength="50"/>
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
<script type="text/javascript">
    $('document').ready(function() {
        /*-------------------------- Form Validation -------------------------*
        $("#materialForm").validate({
            rules: {
                    SGST: {digits: true,},
            },
            invalidHandler: function(event, validator) {
                // 'this' refers to the form
                var errors = validator.numberOfInvalids();
            }
        });
        /*--------------------------------------------------------------------*/
    });
</script>