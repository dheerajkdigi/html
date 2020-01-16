<!DOCTYPE html>
<html> 
    <head>
        <meta charset="UTF-8">
        <title>ERP</title>
        <!--link rel="icon" type="img/ico" href="<?php echo BASE_PATH; ?>assets/images/favicon.ico"-->
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
       
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- JQuery -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="<?php echo BASE_PATH; ?>assets/js/bootbox.min.js"></script>
        
        <!-- Morris chart --
        <link href="<?php echo BASE_PATH; ?>assets/AdminLTE/css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?php echo BASE_PATH; ?>assets/AdminLTE/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="<?php echo BASE_PATH; ?>assets/AdminLTE/css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?php echo BASE_PATH; ?>assets/AdminLTE/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php echo BASE_PATH; ?>assets/AdminLTE/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Data Table -->
        <link href="<?php echo BASE_PATH; ?>assets/AdminLTE/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo BASE_PATH; ?>assets/AdminLTE/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo BASE_PATH; ?>assets/css/style.css" rel="stylesheet" type="text/css" />
        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
        <link href="<?php echo BASE_PATH; ?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
    <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo base_url(); ?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a href="<?php echo base_url(); ?>">
                    <div class="topheader">
                        Daspass
                    </div>
                </a>
                <?php if(isset($this->session->userdata('user')->id)){
                    $u = $this->session->userdata('user');?>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo ucwords($u->first_name.' '.$u->last_name); ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue" style="height:auto;">
                                    <!--img alt="User Image" class="img-circle" src="<?php echo base_url('assets/AdminLTE'); ?>/img/avatar04.png"-->
                                    <p>
                                        <?php echo ucwords($u->first_name.' '.$u->last_name); ?>
                                        <small>Member since <?php echo date('M',strtotime($u->created_date)).'. '.date('Y',strtotime($u->created_date)); ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body --
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <!--div class="pull-left">
                                        <a class="btn btn-default btn-flat" href="#">Profile</a>
                                    </div-->
                                    <div class="pull-right">
                                        <a class="btn btn-default btn-flat" href="<?php echo base_url('user/logout'); ?>">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <?php } ?>
            </nav>
        </header>

        
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <!--div class="pull-left image">
                            <img src="<?php echo base_url('assets/AdminLTE'); ?>/img/avatar04.png" class="img-circle" alt="User Image" />
                        </div-->
                        <div class="pull-left info">
                            <p>Hello, <?php echo ucfirst($u->first_name); ?></p>

                            <!--a href="#"><i class="fa fa-circle text-success"></i> Online</a-->
                        </div>
                    </div>
                    <!-- search form --
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="<?php echo base_url(); ?>">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>

                        <!--li class="treeview">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user"></i> <span>User Management</span><i class="fa pull-right fa-angle-left"></i>
                            </a>
                            <ul class="treeview-menu">    
                                <li>
                                    <a href="<?php echo base_url('user'); ?>">
                                        <i class="fa fa-list"></i>List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('user'); ?>/add">
                                        <i class="fa fa-plus"></i>Add</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-group"></i> <span>Role Management</span><i class="fa pull-right fa-angle-left"></i>
                            </a>
                            <ul class="treeview-menu">    
                                <li>
                                    <a href="<?php echo base_url('role'); ?>">
                                        <i class="fa fa-list"></i>List</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('role'); ?>/add">
                                        <i class="fa fa-plus"></i>Add</span>
                                    </a>
                                </li>
                            </ul>
                        </li-->
                        <!--li class="treeview">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-cubes"></i> <span>Order Management</span><i class="fa pull-right fa-angle-left"></i>
                            </a>
                            <ul class="treeview-menu">    
                                <li>
                                    <a href="<?php echo base_url('category'); ?>">
                                        <i class="fa fa-list"></i>List
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('category'); ?>/add">
                                        <i class="fa fa-plus"></i>Add
                                    </a>
                                </li>
                            </ul>
                        </li-->
                        <!--li class="treeview">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-gamepad"></i> <span>Inventory Management</span><i class="fa pull-right fa-angle-left"></i>
                            </a>
                            <ul class="treeview-menu">    
                                <li>
                                    <a href="<?php echo base_url('inventory'); ?>/catList">
                                        <i class="fa fa-list"></i>Categories
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('inventory'); ?>/catAdd">
                                        <i class="fa fa-plus"></i>Add Category
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('inventory'); ?>/add">
                                        <i class="fa fa-plus"></i>Add Product
                                    </a>
                                </li>
                            </ul>
                        </li-->
                        <?php if(in_array($u->role,array(1,2))) { ?>
                        <li class="treeview">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-cubes"></i> <span>Material Management</span><i class="fa pull-right fa-angle-left"></i>
                            </a>
                            <ul class="treeview-menu">    
                                <li>
                                    <a href="<?php echo base_url('material'); ?>">
                                        <i class="fa fa-list"></i>List
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('material'); ?>/add">
                                        <i class="fa fa-plus"></i>Add
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('material'); ?>/add_group">
                                        <i class="fa fa-plus"></i>Add Group
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('material'); ?>/add_sub_group">
                                        <i class="fa fa-plus"></i>Add Sub Group
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if(in_array($u->role,array(1,3))) { ?>
                        <li class="treeview">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-vendor"></i> <span>Vendor Management</span><i class="fa pull-right fa-angle-left"></i>
                            </a>
                            <ul class="treeview-menu">    
                                <li>
                                    <a href="<?php echo base_url('vendor'); ?>">
                                        <i class="fa fa-list"></i>List
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('vendor'); ?>/add">
                                        <i class="fa fa-plus"></i>Add
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if(in_array($u->role,array(1,7))) { ?>
                        <li class="treeview">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-gamepad"></i> <span>Customer Management</span><i class="fa pull-right fa-angle-left"></i>
                            </a>
                            <ul class="treeview-menu">    
                                <li>
                                    <a href="<?php echo base_url('customer'); ?>">
                                        <i class="fa fa-list"></i>List
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('customer'); ?>/add">
                                        <i class="fa fa-plus"></i>Add
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if(in_array($u->role,array(1,2,3,4,6))) { ?>
                        <li class="treeview">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-shopping-cart"></i> <span>Purchase Management</span><i class="fa pull-right fa-angle-left"></i>
                            </a>
                            <ul class="treeview-menu">  
                                <?php if(in_array($u->role,array(1,3))) { ?>  
                                <li>
                                    <a href="<?php echo base_url('purchase'); ?>">
                                        <i class="fa fa-list"></i>List
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('purchase'); ?>/shortMaterials">
                                        <i class="fa fa-list"></i>Short Materials
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('purchase'); ?>/add">
                                        <i class="fa fa-plus"></i>Add
                                    </a>
                                </li>
                                <?php } ?>
                                <?php if(in_array($u->role,array(1,6))) { ?>
                                <li>
                                    <a href="<?php echo base_url('purchase'); ?>/gate">
                                        <i class="fa fa-plus"></i>Gate
                                    </a>
                                </li>
                                <?php } ?>
                                <?php if(in_array($u->role,array(1,4))) { ?>
                                <li>
                                    <a href="<?php echo base_url('purchase'); ?>/quality">
                                        <i class="fa fa-plus"></i>Quality
                                    </a>
                                </li>
                                <?php } ?>
                                <?php if(in_array($u->role,array(1,2))) { ?>
                                <li>
                                    <a href="<?php echo base_url('purchase'); ?>/store">
                                        <i class="fa fa-plus"></i>Store
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if(in_array($u->role,array(1,2,4,5,7))) { ?>
                        <li class="treeview">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-gamepad"></i> <span>Order Management</span><i class="fa pull-right fa-angle-left"></i>
                            </a>
                            
                            <ul class="treeview-menu"> 
                                <?php if(in_array($u->role,array(1,2,7))) { ?>
                                <li>
                                    <a href="<?php echo base_url('order'); ?>">
                                        <i class="fa fa-list"></i>Orders
                                    </a>
                                </li>
                                <?php if(in_array($u->role,array(1,7))) { ?>
                                <li>
                                    <a href="<?php echo base_url('order/add'); ?>">
                                        <i class="fa fa-plus"></i>Add Order
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('order/planning'); ?>">
                                        <i class="fa fa-plus"></i>Planning
                                    </a>
                                </li>
                                <?php } } ?>
                                <?php if(in_array($u->role,array(1,4,5))) { ?>
                                <li>
                                    <a href="<?php echo base_url('order/production'); ?>">
                                        <i class="fa fa-plus"></i>Production
                                    </a>
                                </li>
                                <?php } ?>
                                <?php if(in_array($u->role,array(1,4,5))) { ?>
                                <li>
                                    <a href="<?php echo base_url('order/dispatch'); ?>">
                                        <i class="fa fa-plus"></i>Dispatch
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('order/dispatch_doc'); ?>">
                                        <i class="fa fa-plus"></i>Dispatch Document
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if(in_array($u->role,array(1,7))) { ?>
                        <li class="treeview">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-list-alt"></i> <span>Quotation Management</span><i class="fa pull-right fa-angle-left"></i>
                            </a>
                            <ul class="treeview-menu">    
                                <li>
                                    <a href="<?php echo base_url('quotation'); ?>">
                                        <i class="fa fa-list"></i>List
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('quotation'); ?>/add">
                                        <i class="fa fa-plus"></i>Add
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

        <!--/div><!-- ./wrapper -->
        <?php $this->load->view($content); ?>
        <!-- add new calendar event modal -->

        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        
        <!-- Morris.js charts --
        <script src="<?php echo BASE_PATH; ?>assets/AdminLTE/js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="<?php echo BASE_PATH; ?>assets/AdminLTE/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="<?php echo BASE_PATH; ?>assets/AdminLTE/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_PATH; ?>assets/AdminLTE/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="<?php echo BASE_PATH; ?>assets/AdminLTE/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="<?php echo BASE_PATH; ?>assets/AdminLTE/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- datepicker -->
        <script src="<?php echo BASE_PATH; ?>assets/AdminLTE/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php echo BASE_PATH; ?>assets/AdminLTE/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <!--script src="<?php echo BASE_PATH; ?>assets/AdminLTE/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script-->
        <!--script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.js" type="text/javascript"></script-->
        <!-- DATA TABES SCRIPT -->
        <script src="<?php echo BASE_PATH; ?>assets/AdminLTE/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?php echo BASE_PATH; ?>assets/AdminLTE/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo BASE_PATH; ?>assets/AdminLTE/js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) --
        <script src="<?php echo BASE_PATH; ?>assets/AdminLTE/js/AdminLTE/dashboard.js" type="text/javascript"></script>

        <!-- AdminLTE for demo purposes --
        <script src="<?php echo BASE_PATH; ?>assets/AdminLTE/js/AdminLTE/demo.js" type="text/javascript"></script>
        -->
        <script src="<?php echo BASE_PATH; ?>assets/js/jquery.validate.js"></script>
        <script src="<?php echo BASE_PATH; ?>assets/js/additional-methods.min.js"></script>
        
        <script src="<?php echo BASE_PATH; ?>assets/js/moment.js"></script>
        <script src="<?php echo BASE_PATH; ?>assets/js/bootstrap-datetimepicker.min.js"></script>
        <script>
        $(function(){
        /*-------------------------- Date Picker -----------------------------*/
        $('.datepicker').datepicker({ format: 'yyyy-mm-dd',autoclose:true });  
        /*--------------------------------------------------------------------*/
        
        /*--------------------------Data Table--------------------------------*/
        $("#example1").dataTable({
            'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': ['nosort']
                }]
            });
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
        $('#example3').dataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
        /*--------------------------------------------------------------------*/
        
        /*------------------------------- Detail -----------------------------*/
        $(".detail").on("click",function(){
            var detailResult = '';
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url().$this->router->fetch_class().'/detail'; ?>/"+$(this).data('detail'),
                success: function(data) {
                            //called when successful
                            if(data.detail){
                                var detailResult = '<table class="table table-bordered table-striped"><tr><th>Field</th><th>Value</th></tr>';
                                var i =1;
                                $.each( data.detail, function(index,value) {
                                        detailResult += "<tr><td>"+index+"</td><td>"+value+"</td></tr>";
                                        i++;
                                });
                                detailResult += '</table>';
                            }
                            else{
                                detailResult = "<div class='alert alert-warning'><i class='fa fa-warning'></i>No Detail Found!</div>";
                            }
                            $("#detail").html(detailResult);
                            $('#myModal').modal({ show:true,backbrop:false });
                },
                error: function(e) {
                        //console.log(e);
                        detailResult = "<div class='alert alert-danger'><i class='fa fa-ban'></i>Some Error Occured!</div>";
                        $("#detail").html(detailResult);
                        $('#myModal').modal({ show:true,backbrop:false });
                }
            });
            return false;
        });

        /*--------------------------------------------------------------------*/
        
        /*------------------------------ Change Status -----------------------*/
        //$(".change-status").on('click',function(){
		$("#example1").on('click','.change-status',function(){
            //alert('change status');return false;
            var status_link = this;
            var id = $(this).data('id');
            var status = +!$(this).data('status');
            var changeStatus = (status) ? 'Deactivate':'Activate';
            var msg = $(this).parent().siblings('.name').html();
            msg += (status) ? ' activated':' deactivated';
            msg += ' successfully!';
            $.ajax({
                    type: "POST",
                    url: "<?php echo base_url($this->router->fetch_class().'/changeStatus'); ?>",
                    data: { 'id': id, 'status': status },
                    success: function(data) {
                            //called when successful
                            if(data>0){
                                //alert('email already registered.');
                                $(status_link).children('i').toggleClass("fa-ban fa-check-square-o");
                                $(status_link).data('status',status);
                                $(status_link).attr('title',changeStatus);
                                bootbox.alert(msg);
                                //BootstrapDialog.alert('success!');
                                //return false;
                            }
                            return true;
                    },
                    error: function(e) {
                            //called when there is an error
                            console.log(e.message);
                            return false;
                    }
                });
            });
         /*-------------------------------------------------------------------*/
        });
        </script>
    </body>
</html>