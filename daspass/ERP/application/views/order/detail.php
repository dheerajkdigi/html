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
            <?php if(count($items)){ ?>
            <div class="box-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">
                    <table class="table table-bordered table-striped" id="orders_table" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Order No.</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                
                                <th>Rate</th>
                                <th>Price</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Order No.</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                
                                <th>Rate</th>
                                <th>Price</th>
                            </tr>
                        </tfoot>
                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                            <?php foreach($items as $i=>$item) { ?>
                            <tr>
                                <input type="hidden" name="position[]" value="<?php echo $item->ID; ?>">
                                <td class="sorting_1"><?php echo $i+1; ?></td>
                                <td class="order_id"><?php echo $order->ID; ?>
                                <td class="name"><?php echo $item->ITEM_NAME; ?></td>
                                <td class="address"><?php echo $item->QUANTITY; ?></td>
                                
                                <td class="address"><?php echo $item->RATE; ?></td>
                                <td class="address"><?php echo $item->PRICE; ?></td>
                                
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- /.box-body -->
            <?php } ?>
            <div class="box-header">
                <h3 class="box-title">BOM</h3>
            </div><!-- /.box-header -->
            <?php if(count($materials)){ ?>
            <div class="box-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">
                    <table class="table table-bordered table-striped" id="orders_table" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Meterial Name</th>
                                <th>UOM</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Meterial Name</th>
                                <th>UOM</th>
                                <th>Quantity</th>
                            </tr>
                        </tfoot>
                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                            <?php foreach($materials as $i=>$material) { ?>
                            <tr>
                                <input type="hidden" name="position[]" value="<?php echo $material->ID; ?>">
                                <td class="sorting_1"><?php echo $i+1; ?></td>
                                <td class="name"><?php echo $material->ITEM_NAME; ?></td>
                                <td class="name"><?php echo $material->UOM; ?></td>
                                <td class="address"><?php echo $material->QUANTITY; ?></td>
                                
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


