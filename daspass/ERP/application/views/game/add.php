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
            Game Management
            <small><?php echo ucfirst($this->router->fetch_method()); ?> Game Content</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="<?php echo base_url('game'); ?>"><i class="fa fa-role"></i> Game Management</a></li>
            <li class="active"> <?php echo ucfirst($this->router->fetch_method()); ?> Game Content</li>
        </ol>
    </section>
    <form role="form" id="gameForm" class="form-horizontal" name="gameForm" action="<?php echo $form_action;?>" method="post" enctype="multipart/form-data">
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <input id="method" type="hidden" name="method" value="<?php echo $this->router->fetch_method(); ?>"/>

            <div class="box-body">
                <div class="form-group">
                    <label class="control-label col-sm-2 text-left" for="category">Category<span class="required">*</span>:</label>
                    <div class="col-sm-10">
                        <select id="category_id" class="form-control" name="category_id" required>
                            <option value="">Select category</option>
                            <?php foreach ($categories as $category) { ?>
                            <option value='<?php echo $category->ID; ?>' <?php echo (isset($game->CATEGORY_ID) && $game->CATEGORY_ID == $category->ID) ? "selected=selected":"";?> ><?php echo $category->NAME; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 text-left" for="NAME">Name<span class="required">*</span>:</label>
                    <div class="col-sm-10">
                        <input id="NAME" class="form-control" type="text" name="NAME" value="<?php echo (isset($game->NAME) && ($this->router->fetch_method()!='copy') ) ? $game->NAME:'';?>" required maxlength="50"/>
                    </div>
                </div>
                <div class="form-group" id="game_image">
                    <label class="control-label col-sm-2 text-left" for="section_count">Game Image<?php echo (!isset($game->ID)) ? '<span class="required">*</span>' : '';?>:</label>
                    <div class="col-sm-2">
                        <span class="file-input btn btn-primary btn-file">
                            <?php echo (!isset($game->IMAGE)) ? 'Upload' : 'Change';?>
                            <input id="game_image" class="uploadFile <?php echo (!isset($game->IMAGE)) ? '' : '';?>" type="file" name="game_image" accept="image/*" <?php echo (!isset($game->IMAGE)) ? 'required' : '';?>/>
                        </span>
                    </div>
                    <div class="col-sm-8" id="imagePreview">
                        <?php echo (isset($game->IMAGE)) ? '<img src="'.base_url().$game->IMAGE.'">' : '';?>
                    </div>
                </div>
                <div class="form-group" id="game_zip">
                    <label class="control-label col-sm-2 text-left" for="section_count">Game Zip<?php echo (!isset($game->ID)) ? '<span class="required">*</span>' : '';?>:</label>
                    <div class="col-sm-2">
                        <span class="file-input btn btn-primary btn-file">
                            <?php echo (!isset($game->GAME_LOCATION)) ? 'Upload' : 'Change';?>
                            <input class="uploadFile" type="file" name="game_zip" accept="zip/*" <?php echo (!isset($game->GAME_LOCATION)) ? 'required' : '';?>/>
                        </span>
                    </div>
                </div>
            </div>

        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?php echo base_url('game'); ?>" class="btn btn-danger">Cancel</a>
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
	
        $("#gameForm").validate({
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
    $("#gameForm").on('change','#game_image',function () {
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
</script>