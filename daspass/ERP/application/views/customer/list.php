<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Customer Management
            <small>Customer List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Customer Management</li>
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
    	<div>
            <a href="<?php echo base_url('customer/add'); ?>" class="btn btn-primary btn-lg">Add Customer</a>
            <a href="javascript:window.history.back();" class="btn btn-danger btn-lg pull-right">Back</a>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Customers</h3>
            </div><!-- /.box-header -->
            <?php if(count($customers)){ ?>
            <div class="box-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">
                    <table class="table table-bordered table-striped" id="customers_table" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Name of Customer</th>
                                <th>Address</th>
                                
                                <th class="nosort">Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name of Customer</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody role="alert" aria-live="polite" aria-relevant="all" id="sortable">
                            <?php foreach($customers as $i=>$customer) { ?>
                            <tr>
                                <input type="hidden" name="position[]" value="<?php echo $customer->ID; ?>">
                                <td class="sorting_1"><?php echo $i+1; ?></td>
                                <td class="name"><?php echo $customer->NAME; ?></td>
                                <td class="address"><?php echo $customer->ADDRESS_1; ?></td>
                                <td class="contact_no"><?php echo $customer->MOBILE; ?></td>
                                <td class=" ">
                                    <a href='#' class="detail" data-detail="<?php echo $customer->ID; ?>" title="Detail">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="<?php echo base_url('customer/edit/'.$customer->ID); ?>" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    
                                    <!--
                                        <a href="#" class="change-status" data-id="<?php echo $customer->ID; ?>" data-status="<?php echo $customer->IS_ACTIVE; ?>" title="<?php echo ($customer->IS_ACTIVE == 1) ? 'Deactivate':'Activate';?>">
                                            <i class="status-icon fa <?php echo ($customer->IS_ACTIVE == 1) ? 'fa-ban':'fa-check-square-o';?>"></i>
                                        </a>
                                    -->
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
            <h4 class="modal-title" id="myModalLabel">Customer Detail</h4>
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
