<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Material Management
            <small>Material List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Material Management</li>
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
    	<div><a href="<?php echo base_url('material/add'); ?>" class="btn btn-primary btn-lg">Add Material</a>
            <a href="javascript:window.history.back();" class="btn btn-danger btn-lg pull-right">Back</a>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Materials</h3>
            </div><!-- /.box-header -->
            <?php if(count($materials)){ ?>
            <div class="box-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">
                <form action='<?php echo base_url('material/setPositioning'); ?>' method="POST">
                    <table class="table table-bordered table-striped" id="materials_table" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Group Name</th>
                                <th>Sub Group Name</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>UOM</th>
                                <th>STORE_QUANTITY</th>
                                <th class="nosort">Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Group Name</th>
                                <th>Sub Group Name</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>UOM</th>
                                <th>STORE_QUANTITY</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody role="alert" aria-live="polite" aria-relevant="all" id="sortable">
                            <?php foreach($materials as $i=>$material) { ?>
                            <tr>
                                <input type="hidden" name="position[]" value="<?php echo $material->ID; ?>">
                                <td class="sorting_1"><?php echo $i+1; ?></td>
                                <td class="name"><?php echo $material->MATERIAL_GROUP_NAME; ?></td>
                                <td class="category_id"><?php echo $material->MATERIAL_SUB_GROUP_NAME; ?></td>
                                <td class="order"><?php echo $material->ID; ?></td>
                                <td class="order"><?php echo $material->ITEM_NAME; ?></td>
                                <td class="order"><?php echo $material->UOM; ?></td>
                                <td class="order"><?php echo $material->STORE_QUANTITY; ?></td>
                                <td class=" ">
                                    <a href='#' class="detail" data-detail="<?php echo $material->ID; ?>" title="Detail">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="<?php echo base_url('material/edit/'.$material->ID); ?>" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <!--
                                        <a href="#" class="change-status" data-id="<?php echo $material->ID; ?>" data-status="<?php echo $material->IS_ACTIVE; ?>" title="<?php echo ($material->IS_ACTIVE == 1) ? 'Deactivate':'Activate';?>">
                                            <i class="status-icon fa <?php echo ($material->IS_ACTIVE == 1) ? 'fa-ban':'fa-check-square-o';?>"></i>
                                        </a>
                                    -->
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="<?php echo base_url('material'); ?>" class="btn btn-danger">Cancel</a>
                </form>
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
            <h4 class="modal-title" id="myModalLabel">Material Detail</h4>
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
        $(document).ready(function () {
            $('#materials_table').dataTable( {
              "pageLength": 50,
              "iDisplayLength": 50
            } );
            $('.dataTables_length').addClass('bs-select');
        });
    });
</script>


