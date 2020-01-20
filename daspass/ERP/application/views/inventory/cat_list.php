<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Category Management
            <small>Game List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Category Management</li>
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
	<div><a href="<?php echo base_url('inventory/catAdd'); ?>" class="btn btn-primary btn-lg">Add Category</a></div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Categories</h3>
            </div><!-- /.box-header -->
            <?php if(count($categories)){ ?>
            <div class="box-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">
                    <table class="table table-bordered table-striped" id="category_table" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th class="nosort">Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody role="alert" aria-live="polite" aria-relevant="all" id="">
                            <?php foreach($categories as $i=>$category) { ?>
                            <tr>
                                <input type="hidden" name="position[]" value="<?php echo $category->ID; ?>">
                                <td class="sorting_1"><?php echo $i+1; ?></td>
                                <td class="name"><?php echo $category->NAME; ?></td>
                                <td class="order"><?php echo $category->UNIT; ?></td>
                                <td class=" ">
                                    <a href="<?php echo base_url('inventory/catEdit/'.$category->ID); ?>" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href='<?php echo base_url("inventory/listing/$category->ID");?>' class="contentDetail" data-detail="<?php echo $category->ID; ?>" title="Detail">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="#" class="change-status" data-id="<?php echo $category->ID; ?>" data-status="<?php echo $category->IS_ACTIVE; ?>" title="<?php echo ($category->IS_ACTIVE == 1) ? 'Deactivate':'Activate';?>">
                                        <i class="status-icon fa <?php echo ($category->IS_ACTIVE == 1) ? 'fa-ban':'fa-check-square-o';?>"></i>
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


