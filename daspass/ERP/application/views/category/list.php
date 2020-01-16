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
	<div><a href="<?php echo base_url('category/add'); ?>" class="btn btn-primary btn-lg">Add Category</a></div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Categories</h3>
            </div><!-- /.box-header -->
            <?php if(count($categories)){ ?>
            <div class="box-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">
                <form action='<?php echo base_url('category/setPositioning'); ?>' method="POST">
                    <table class="table table-bordered table-striped" id="category_table" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th class="nosort">Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody role="alert" aria-live="polite" aria-relevant="all" id="sortable">
                            <?php foreach($categories as $i=>$category) { ?>
                            <tr>
                                <input type="hidden" name="position[]" value="<?php echo $category->ID; ?>">
                                <td class="sorting_1"><?php echo $i+1; ?></td>
                                <td class="name"><?php echo $category->NAME; ?></td>
                                <td class="order"><?php echo $category->POSITION; ?></td>
                                <td class=" ">
                                    <a href="<?php echo base_url('category/edit/'.$category->ID); ?>" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" class="change-status" data-id="<?php echo $category->ID; ?>" data-status="<?php echo $category->IS_ACTIVE; ?>" title="<?php echo ($category->IS_ACTIVE == 1) ? 'Deactivate':'Activate';?>">
                                        <i class="status-icon fa <?php echo ($category->IS_ACTIVE == 1) ? 'fa-ban':'fa-check-square-o';?>"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="<?php echo base_url('category'); ?>" class="btn btn-danger">Cancel</a>
                </form>
                </div>
            </div><!-- /.box-body -->
            <?php } ?>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->