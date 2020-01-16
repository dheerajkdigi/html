<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Game Management
            <small>Game List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Game Management</li>
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
	<div><a href="<?php echo base_url('pack/add'); ?>" class="btn btn-primary btn-lg">Add Game</a></div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Games</h3>
            </div><!-- /.box-header -->
            <?php if(count($categories)){ ?>
            <div class="box-body table-responsive">
                <div role="grid" class="dataTables_wrapper form-inline" id="example1_wrapper">
                    
                    <table class="table table-bordered table-striped dataTable" id="example1" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Name</th>
                                <th class="nosort">Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody role="alert" aria-live="polite" aria-relevant="all">
                            <?php foreach($categories as $i=>$category) { ?>
                            <tr>
                                <td class="sorting_1"><?php echo $i+1; ?></td>
                                <td class="name"><a href='<?php echo base_url("game/list/$category->ID");?>'><?php echo $category->NAME; ?></a></td>
                                <td class=" ">
                                    <a href='<?php echo base_url("game/list/$category->ID");?>' class="contentDetail" data-detail="<?php echo $category->ID; ?>" title="Detail">
                                        <i class="fa fa-eye"></i>
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