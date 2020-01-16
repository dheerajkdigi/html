<style>
    .action{width:50px;}
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Purchase Management
            <small>Purchase List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Purchase Management</li>
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
            <a href="<?php echo base_url('purchase/add'); ?>" class="btn btn-primary btn-lg">Add Purchase</a>
            <a href="javascript:window.history.back();" class="btn btn-danger btn-lg pull-right">Back</a>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Purchases</h3>
            </div><!-- /.box-header -->
            <?php if(count($purchases)){ ?>
            <div class="box-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">
                    <table class="table table-bpurchaseed table-striped" id="example1" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Purchase No.</th>
                                <th>Vendor Name</th>
                                <th>Vendor Address</th>
                                <th>Total Price</th>
                                <th class="action">Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Purchase No.</th>
                                <th>Vendor Name</th>
                                <th>Vendor Address</th>
                                <th>Total Price</th>
                                <th class="action">Action</th>
                            </tr>
                        </tfoot>
                        <tbody role="alert" aria-live="polite" aria-relevant="all" id="sortable">
                            <?php foreach($purchases as $i=>$purchase) { ?>
                            <tr>
                                <input type="hidden" name="position[]" value="<?php echo $purchase->ID; ?>">
                                <td class="sorting_1"><?php echo $i+1; ?></td>
                                <td class="purchase_id">PO-<?php echo str_pad($purchase->ID,6,"0",STR_PAD_LEFT); ?>
                                <td class="name"><?php echo $purchase->VENDOR_NAME; ?></td>
                                <td class="address"><?php echo $purchase->VENDOR_ADDRESS; ?></td>
                                <td class="contact_no"><?php echo $purchase->TOTAL_PRICE; ?></td>
                                <td class=" ">
                                    <a href="<?php echo base_url('purchase/detail/'.$purchase->ID); ?>" title="Detail">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="<?php echo base_url('purchase/edit/'.$purchase->ID); ?>" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <?php if($purchase->IS_ACTIVE) { ?>
                                    <a href="#" class="change-status" data-id="<?php echo $purchase->ID; ?>" data-status="<?php echo $purchase->IS_ACTIVE; ?>" title="<?php echo ($purchase->IS_ACTIVE == 1) ? 'Deactivate':'Activate';?>">
                                        <i class="status-icon fa <?php echo ($purchase->IS_ACTIVE == 1) ? 'fa-ban':'fa-check-square-o';?>"></i>
                                    </a>
                                    <?php } ?>
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
</aside><!-- /.right-side -->

<script type="text/javascript">
    $(function() {
        /*----------------------- Sortable ------------------------*/
        

        $("#sortable").sortable({
            cursor: "move", 
            axis: "y", 
            cancel: ".unsortable", 
            forceHelperSize: true,
            helper: fixHelper, 
            dropOnEmpty: true,
            beforeStop: function(ev, ui) {
                /*
                if ($(ui.item).index() == 0 ) {
                    $(this).sortable('cancel');
                    //return false;
                }
                */
            }
        });
        $( "#sortable" ).on( "sortupdate", function( event, ui ) {
            //console.log(ui);
            updatePurchase();
        } );
        /*
        * This helper just prevents the columns from collapsing when
        * dragging the rows.
        */
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).style("color:red");
            });
            return ui;
        };
        function updatePurchase(){
            $.map($("#sortable").find('tr'), function(el) {
                // el.id + ' = ' + $(el).index();
                console.log($(el).html());
                $(el).find('.purchase').html($(el).index()+1);
                    //console.log($(el).index())
            });
        }
        /*--------------------------------------------------------------------*/
    });
</script>


