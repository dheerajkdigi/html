
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User Management
            <small>User List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">User Management</li>
        </ol>
    </section>

    <!-- Main content -->
    
    <section class="content">
        <?php if($this->session->flashdata('msg')) { ?>
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
        <?php } ?>
		<div><a href="<?php echo base_url('user/add'); ?>" class="btn btn-primary btn-lg">Add User</a></div>
        <div class="box" style="clear:both;">
            <div class="box-header">
                <h3 class="box-title">Users</h3>
            </div><!-- /.box-header -->
            <?php if(count($users)){ ?>
            <div class="box-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">
                    
                    <table class="table table-bordered table-striped dataTable" id="example1" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="nosort">Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th rowspan="1" colspan="1">#</th>
                                <th rowspan="1" colspan="1">Name</th>
                                <th rowspan="1" colspan="1">Email</th>
                                <th rowspan="1" colspan="1">Action</th>
                            </tr>
                        </tfoot>
                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                            <?php foreach($users as $i=>$user) { 
                                $row_class = ($i%2==0)?'odd':'even';
                                $full_name = $user->first_name.' '.$user->middle_name.' '.$user->last_name;
                            ?>
                            <tr class="<?php echo $row_class; ?>">
                                <td><?php echo $i+1; ?></td>
                                <td class="name"><?php echo $full_name; ?></td>
                                <td><?php echo $user->email; ?></td>
                                <td>
                                    <a href="#" class="detail" data-detail="<?php echo $user->id; ?>" title="Detail">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="<?php echo base_url('user/edit/'.$user->id); ?>" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" class="change-status" data-id="<?php echo $user->id; ?>" data-status="<?php echo $user->IS_ACTIVE; ?>" title="<?php echo ($user->IS_ACTIVE == 1) ? 'Deactivate':'Activate';?>">
                                        <i class="status-icon fa <?php echo ($user->IS_ACTIVE == 1) ? 'fa-ban':'fa-check-square-o';?>"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.box-body -->
            <?php } ?>
        </div>
    </section><!-- /.content -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">User Detail</h4>
        </div>
        <div class="modal-body" id="detail">
        </div>
        <div class="modal-footer text-left">
        </div>
        </div>
    </div>
    </div>
    <!---->
</aside><!-- /.right-side -->

<script type="text/javascript">
    $(function() {
        /*--------------------------- User Detail ----------------------------*
        $(".detail").on("click",function(){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url('user/detail'); ?>/"+$(this).data('detail'),
                success: function(data) {
                            //called when successful
                            if(data.detail){
                                var detailResult = '<tr><th>Field</th><th>Value</th></tr>';
                                var i =1;
                                $.each( data.detail, function(index,value) {
                                        detailResult += "<tr><td>"+index+"</td><td>"+value+"</td></tr>";
                                        i++;
                                });
                                $("#detail").html(detailResult);
                                $('#myModal').modal({ show:true,backbrop:false });
                                return false;
                            }
                            return false;
                },
                error: function(e) {
                            //called when there is an error
                            //console.log(e.message);
                            return false;
                }
            });
            return false;
        });

        /*--------------------------------------------------------------------*/
    });
</script>
