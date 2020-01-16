<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Quotation Management
            <small>Quotation List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Quotation Management</li>
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
            <a href="<?php echo base_url('quotation/add'); ?>" class="btn btn-primary btn-lg">Add Quotation</a>
            <a href="javascript:window.history.back();" class="btn btn-danger btn-lg pull-right">Back</a>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Quotations</h3>
            </div><!-- /.box-header -->
            <div>
                <form method="POST">
                    <label class="control-label col-sm-2 text-left" for="DATE_RANGE">DATE_RANGE:</label>
                    <div class="col-sm-4">
                        <input id="DATE_FROM" class="form-control datepicker" type="text" name="DATE_FROM" value="<?php echo (isset($DATE_FROM)) ? $DATE_FROM:'';?>" required/>
                    </div>
                    <div class="col-sm-4">
                        <input id="DATE_TO" class="form-control datepicker" type="text" name="DATE_TO" value="<?php echo (isset($DATE_TO)) ? $DATE_TO:'';?>" required/>
                    </div>
                    <button type="submit" class="btn btn-primary">Show</button>
                </form>
            </div>
            <div>
                <?php //echo "<pre>";print_r($quotation_status); ?>
                <button class="btn btn-primary btn-lg">
                    Booked: <?php echo (isset($quotation_status['0']->STATUS_COUNT)) ? $quotation_status['0']->STATUS_COUNT : 0; ?>
                </button>
                <button class="btn btn-danger btn-lg pull-right">
                    Pending: <?php echo (isset($quotation_status['1']->STATUS_COUNT)) ? $quotation_status['1']->STATUS_COUNT : 0; ?>
                </button>
            </div>
            <?php if(count($quotations)){ ?>
            <div class="box-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">
                    <table class="table table-bordered table-striped" id="quotations_table" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Firm Name</th>
                                <th>Contact Person</th>
                                <th>Address</th>
                                <th>Order Value</th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th class="nosort">Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Firm Name</th>
                                <th>Contact Person</th>
                                <th>Address</th>
                                <th>Order Value</th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody role="alert" aria-live="polite" aria-relevant="all" id="sortable">
                            <?php foreach($quotations as $i=>$quotation) { ?>
                            <tr>
                                <input type="hidden" name="position[]" value="<?php echo $quotation->ID; ?>">
                                <td class="sorting_1"><?php echo $i+1; ?></td>
                                <td class="name"><?php echo $quotation->CUSTOMER_NAME; ?></td>
                                <td class="address"><?php echo $quotation->CONTACT_PERSON; ?></td>
                                <td class="contact_no"><?php echo $quotation->ADDRESS; ?></td>
                                <td class="TOTAL_PRICE"><?php echo $quotation->TOTAL_PRICE; ?></td>
                                <td class="CREATED_ON"><?php echo $quotation->CREATED_ON; ?></td>
                                <td class="status"><?php echo ($quotation->IS_ACTIVE) ? "Pending" : "Booked"; ?></td>
                                <td class=" ">
                                    <a href='#' class="detail" data-detail="<?php echo $quotation->ID; ?>" title="Detail">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="<?php echo base_url('quotation/edit/'.$quotation->ID); ?>" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    
                                    <!--
                                        <a href="#" class="change-status" data-id="<?php echo $quotation->ID; ?>" data-status="<?php echo $quotation->IS_ACTIVE; ?>" title="<?php echo ($quotation->IS_ACTIVE == 1) ? 'Deactivate':'Activate';?>">
                                            <i class="status-icon fa <?php echo ($quotation->IS_ACTIVE == 1) ? 'fa-ban':'fa-check-square-o';?>"></i>
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
            <h4 class="modal-title" id="myModalLabel">Quotation Detail</h4>
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
        /*----------------------- Sortable ------------------------*
        

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
                *
            }
        });
        $( "#sortable" ).on( "sortupdate", function( event, ui ) {
            //console.log(ui);
            updateOrder();
        } );
        /*
        * This helper just prevents the columns from collapsing when
        * dragging the rows.
        *
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


<!--script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script-->
<!--
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
--

<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH; ?>assets/jquery-ui-daterangepicker-0.5.0/jquery.comiseo.daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="<?php echo BASE_PATH; ?>assets/jquery-ui-daterangepicker-0.5.0/jquery.comiseo.daterangepicker.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('#DATE_RANGE').daterangepicker({
            initialText : 'Select period...',
            datepickerOptions : {
                numberOfMonths : 4
            }
        });
    });
</script>
-->