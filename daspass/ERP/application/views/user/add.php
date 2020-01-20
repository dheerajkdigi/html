<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User Management
            <small><?php echo $page_heading; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="<?php echo base_url('user'); ?>"><i class="fa fa-user"></i> User Management</a></li>
            <li class="active"> <?php echo $page_heading; ?></li>
        </ol>
    </section>

    <!-- Main content -->
    
    <section class="content">
        <div class="box">
            <form role="form" id="userform" class="form-horizontal" name="userform" action="<?php echo $form_action;?>" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="fname">First Name<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="fname" class="form-control" type="text" name="first_name" value="<?php echo (isset($user->first_name)) ? $user->first_name:'';?>" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="mname">Middle Name:</label>
                        <div class="col-sm-10">
                            <input id="mname" class="form-control" type="text" name="middle_name" value="<?php echo (isset($user->middle_name)) ? $user->middle_name:'';?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="lname">Last Name<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="lname" class="form-control" type="text" name="last_name" value="<?php echo (isset($user->last_name)) ? $user->last_name:'';?>" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="email">Email<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="email" class="form-control" type="text" name="email" value="<?php echo (isset($user->email)) ? $user->email:'';?>" <?php echo (isset($user->email)) ? 'disabled':'';?> required email="true"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="password">Password<?php echo (!isset($user)) ? '<span class="required">*</span>':'';?>:</label>
                        <div class="col-sm-10">
                            <input id="password" class="form-control" type="password" name="password" <?php echo (!isset($user)) ? 'required':'';?>/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="mobile">Mobile<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="mobile" class="form-control" type="text" name="mobile" maxlength="10" value="<?php echo (isset($user->mobile)) ? $user->mobile:'';?>" required mobile="true"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="acc_allowed">Acc Allowed<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="acc_allowed" class="form-control" type="text" name="acc_allowed" value="<?php echo (isset($user->acc_allowed)) ? $user->acc_allowed:'';?>" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="ip">IP<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="ip" class="form-control" type="text" name="ip" value="<?php echo (isset($user->ip)) ? $user->ip:'';?>" required ipv4="true"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="auth_for_site">Authorised for site:<span class="required">*</span></label>
                        <div class="col-sm-10">
                            <select id="auth_for_site" class="form-control" name="auth_for_site" required>
                                <option value="">Select</option>
                                <?php foreach ($sites as $site) { ?>
                                <option value='<?php echo $site->id; ?>' <?php echo (isset($user->auth_for_site) && ($user->auth_for_site==$site->id)) ? 'selected="selected"':''; ?>><?php echo $site->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="role">Role:</label>
                        <div class="col-sm-10">
                            <select id="role" class="form-control" name="role" required>
                                <option value="">Select</option>
                                <?php foreach ($roles as $role) { ?>
                                <option value='<?php echo $role->id; ?>' <?php echo (isset($user->role) && ($user->role==$role->id)) ? 'selected="selected"':''; ?>><?php echo $role->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <?php foreach($this->menus as $menu){ ?>
                        <fieldset>
                            <legend><?php echo $menu->name; ?></legend>
                            <input type="checkbox" id="select_all_<?php echo $menu->id; ?>" class="select_all" data-menu_id="<?php echo $menu->id; ?>"> Select All<br/>
                            <?php foreach($sub_menus[$menu->id] as $sub_menu) { ?>
                            <input type="checkbox" name="permissions[]" value="<?php echo $sub_menu->id; ?>" id="sub_menu_<?php echo $sub_menu->id; ?>" class="sub_menu_<?php echo $menu->id; ?>" <?php echo (isset($user->permissions) && (in_array($sub_menu->id,$user->permissions))) ? 'checked="checked"':''; ?>> <?php echo $sub_menu->name; ?><br/>
                            <?php } ?>
                        </fieldset>
                    <?php } ?>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="<?php echo base_url('user'); ?>" class="btn btn-danger">Cancel</a>
                    </div>
            </form>
        </div>
        <div id='line-example'></div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
<script>
$("document").ready(function(){
    /*------------------------ select/unselect all ---------------------------*/
    $('.select_all').on('ifChecked', function(event){
        $('.sub_menu_'+$(this).data('menu_id')).iCheck('check');
    });
    $('.select_all').on('ifUnchecked', function(event){
        $('.sub_menu_'+$(this).data('menu_id')).iCheck('uncheck');
    });
    /*------------------------------------------------------------------------*/
    /*----------------- dynamically select capabilities based on role --------*/
    var roles = <?php echo json_encode($roles); ?>;
    $("#role").on('change',function(){
	$("[class^=sub_menu_]").iCheck('uncheck');
        var role_id = $(this).val();
	var permissions = roles[role_id].permissions.split(',');
        //console.log(permissions);return false;
        $.each(permissions, function(i, item) {
            //console.log(item);
            $("#sub_menu_"+item).iCheck('check');
        });
    });
    /*------------------------------------------------------------------------*/
    /*----------------  User form validation ---------------------------------*/
    $.validator.addMethod('ipv4', function(value) {
        var ipv4 = /^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/;    
        return value.match(ipv4);
    }, 'Invalid IP address');
    $.validator.addMethod('mobile', function(value) {
        var mobile = /^[7-9][0-9]{9}$/;    
        return value.match(mobile);
    }, 'Invalid Mobile number');
    $("#userform").validate({
        /*
        rules: {
                name: {
                required: true,
                minlength: 2
                }
            },
        messages: {
            name: {
            required: "We need your email address to contact you"
            }
        },
        */
        //onsubmit: false,
        submitHandler: function(form) {
            <?php //echo (isset($user->email)) ? 'return true;':'';?>
            var email = $("#email").val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('user/emailExist'); ?>",
                data: { 'email': email },
                success: function(data) {
                        //called when successful
                        if(data>0){
                            //alert('email already registered.');
                            $("#email").after('<label id="email-error" class="error" for="email">Email already registered.</label>');
                            
                            $("#email").focus();
                            $("#email").val('').val(email);
                            return false;
                        }
                        console.log(data);
                        return true;
                        //$('#ajaxphp-results').html(data);
                },
                error: function(e) {
                        //called when there is an error
                        console.log(e.message);
                        return false;
                }
            });
            //return false;
            //$(form).ajaxSubmit();
            return true;
            alert('submit');
            //return false;
            //$(form).submit();
        }
    });
    /*------------------------------------------------------------------------*/
	/*
    function select_all(menu_id){
        alert('test');
        if ($("#select_all_"+menu_id).is(':checked'))
            $(".sub_menu_"+menu_id).prop('checked', true);
        else
            $(".sub_menu_"+menu_id).prop('checked', false);
    }
	*/
});


</script>