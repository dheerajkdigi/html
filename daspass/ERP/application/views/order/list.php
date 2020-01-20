<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Order Management
            <small>Order List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Order Management</li>
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
            <a href="<?php echo base_url('order/add'); ?>" class="btn btn-primary btn-lg">Add Order</a>
            <a href="javascript:window.history.back();" class="btn btn-danger btn-lg pull-right">Back</a>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Orders</h3>
            </div><!-- /.box-header -->
            <?php if(count($orders)){ ?>
            <div class="box-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">
                    <table class="table table-bordered table-striped" id="orders_table" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Order No.</th>
                                <th>Customer Name</th>
                                <th>Order Value</th>
                                <th>PO No.</th>
                                <th>PO Date</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                                <th>Aging</th>
                                <th class="nosort">Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Order No.</th>
                                <th>Customer Name</th>
                                <th>Order Value</th>
                                <th>PO No.</th>
                                <th>PO Date</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                                <th>Aging</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody role="alert" aria-live="polite" aria-relevant="all" id="sortable">
                            <?php foreach($orders as $i=>$order) { ?>
                            <tr>
                                <input type="hidden" name="position[]" value="<?php echo $order->ID; ?>">
                                <td class="sorting_1"><?php echo $i+1; ?></td>
                                <td class="order_id"><?php echo $order->ID; ?>
                                <td class="name"><?php echo $order->CUSTOMER_NAME; ?></td>
                                <td class="TOTAL_PRICE"><?php echo $order->TOTAL_PRICE; ?></td>
                                <td class="contact_no"><?php echo $order->PO_NO; ?></td>
                                <td class="PO_DATE"><?php echo $order->PO_DATE; ?></td>
                                <td class="DELIVERY_DATE"><?php echo $order->DELIVERY_DATE; ?></td>
                                <td class="STATUS"><?php echo $order->STATUS; ?></td>
                                <td class="Aging"><?php echo round((time() - strtotime($order->CREATED_ON)) / (60 * 60 * 24)) ." Days"; ?></td>
                                <td class=" ">
                                    <a href="<?php echo base_url('order/detail/'.$order->ID); ?>" title="Edit">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <!--
                                        <a href="#" class="change-status" data-id="<?php echo $order->ID; ?>" data-status="<?php echo $order->IS_ACTIVE; ?>" title="<?php echo ($order->IS_ACTIVE == 1) ? 'Deactivate':'Activate';?>">
                                            <i class="status-icon fa <?php echo ($order->IS_ACTIVE == 1) ? 'fa-ban':'fa-check-square-o';?>"></i>
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
            updateOrder();
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
        function updateOrder(){
            $.map($("#sortable").find('tr'), function(el) {
                // el.id + ' = ' + $(el).index();
                console.log($(el).html());
                $(el).find('.order').html($(el).index()+1);
                    //console.log($(el).index())
            });
        }
        /*--------------------------------------------------------------------*/
    });
</script>


