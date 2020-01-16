<style>
.chosen-container{width: 100% !important}
input.default{width: 100% !important}
input[type=checkbox]{
    width: auto;
    box-shadow: none;
}
hr{margin:0;}
</style>
<link rel="stylesheet" href="<?php echo BASE_PATH; ?>assets/chosen/chosen.css">
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Order Management
            <small><?php echo ucfirst($this->router->fetch_method()); ?> Order</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="<?php echo base_url('order'); ?>"><i class="fa fa-role"></i> Order Management</a></li>
            <li class="active"> <?php echo ucfirst($this->router->fetch_method()); ?> Order</li>
        </ol>
    </section>
    <form role="form" id="orderForm" class="form-horizontal" name="orderForm" action="<?php echo $form_action;?>" method="post" enctype="multipart/form-data">
    <!-- Main content -->
    <section class="content">
        <div><a href="javascript:window.history.back();" class="btn btn-danger btn-lg">Back</a></div>
        <div class="box">
            <div class="box-body">
                <fieldset>
                    <legend>Orders Detail</legend>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ORDER_ID">Order<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <select id="ORDER_ID" class="form-control chosen-select" name="ORDER_ID" required>
                                <option value="">Select Order</option>
                                <?php foreach ($orders as $order) { ?>
                                <option value='<?php echo $order->ID; ?>' <?php echo (isset($order->ORDER_ID) && $order->ID == $order->ORDER_ID) ? "selected=selected":"";?> data-order_json='<?php echo json_encode($order); ?>'>
                                    <?php echo $order->ID." - ".$order->CUSTOMER_NAME; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ITEM_NAME">ITEM_NAME<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="ITEM_NAME" class="form-control" type="text" name="ITEM_NAME" value="" required maxlength="200" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="QUANTITY">QUANTITY<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="QUANTITY" class="form-control" type="text" name="QUANTITY" value="" required readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CUSTOMER_NAME">CUSTOMER_NAME<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="CUSTOMER_NAME" class="form-control" type="text" name="CUSTOMER_NAME" value="" required maxlength="100" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="CUSTOMER_ADDRESS">CUSTOMER_ADDRESS<span class="required">*</span>:</label>
                        <div class="col-sm-10">
                            <input id="CUSTOMER_ADDRESS" class="form-control" type="text" name="CUSTOMER_ADDRESS" value="" required readonly/>
                        </div>
                    </div>
                </fieldset>
                <fieldset id="BOM">
                    <legend>BOM</legend>
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
                                <tbody id="BOM_BODY" role="alert" aria-live="polite" aria-relevant="all">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </fieldset>
                <!--fieldset id="Material Received">
                    <legend>Material Received</legend>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="MATERIAL_RECEIVED">Material Received:</label>
                        <div class="col-sm-1">
                            <input id="stage_0" class="form-control stage" type="checkbox" name="MATERIAL_RECEIVED" value="1" <?php echo (isset($order->MATERIAL_RECEIVED)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="MATERIAL_RECEIVED"/>
                        </div>
                    </div>
                </fieldset-->
                <fieldset id="PRODUCTION_STAGES">
                    <legend>Production Stages</legend>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="MATERIAL_RECEIVED">Material Received:</label>
                        <div class="col-sm-1">
                            <input id="stage_0" class="form-control stage" type="checkbox" name="MATERIAL_RECEIVED" value="1" <?php echo (isset($order->MATERIAL_RECEIVED)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="MATERIAL_RECEIVED"/>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="PIPE_CUTTING">Pipe Cutting:</label>
                        <div class="col-sm-1">
                            <input id="stage_1" class="form-control stage" type="checkbox" name="PIPE_CUTTING" value="1" <?php echo (isset($order->PIPE_CUTTING)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="PIPE_CUTTING"/>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="COILING">Coiling:</label>
                        <div class="col-sm-1">
                            <input id="stage_2" class="form-control stage" type="checkbox" name="COILING" value="1" <?php echo (isset($order->COILING)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="COILING"/>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="FILLING">Filling:</label>
                        <div class="col-sm-1">
                            <input id="stage_3" class="form-control stage" type="checkbox" name="FILLING" value="1" <?php echo (isset($order->FILLING)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="FILLING"/>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ELECRICAL_TESTING_1">Elecrical Testing:</label>
                        <div class="col-sm-1">
                            <input id="stage_4" class="form-control stage" type="checkbox" name="ELECRICAL_TESTING_1" value="1" <?php echo (isset($order->ELECRICAL_TESTING_1)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="ELECRICAL_TESTING_1"/>
                        </div>
                        <label class="control-label col-sm-2 text-left" for="ELECRICAL_TESTING_1_QC">Quality Yes:</label>
                        <div class="col-sm-1">
                            <input id="elecrical_testing_1_qc" class="form-control qc" type="checkbox" name="ELECRICAL_TESTING_1_QC" value="1" <?php echo (isset($order->ELECRICAL_TESTING_1_QC)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="ELECRICAL_TESTING_1_QC"/>
                        </div>
                        <label class="control-label col-sm-2 text-left" for="ELECRICAL_TESTING_1_QC_FAIL">Quality No:</label>
                        <div class="col-sm-1">
                            <input id="elecrical_testing_1_qc_fail" class="form-control qc fail" type="checkbox" name="ELECRICAL_TESTING_1_QC_FAIL" value="1" <?php echo (isset($order->ELECRICAL_TESTING_1_QC_FAIL)) ? 'disabled="disabled"':'';?>/>
                            <!--input type="hidden" name="FILLING_QUALITY_CHECK_FAIL"/-->
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ROLLING">Rolling:</label>
                        <div class="col-sm-1">
                            <input id="stage_5" class="form-control stage" type="checkbox" name="ROLLING" value="1" <?php echo (isset($order->ROLLING)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="ROLLING"/>
                        </div>
                        <!--
                        <label class="control-label col-sm-2 text-left" for="ROLLING_QUALITY_CHECK">Quality Check:</label>
                        <div class="col-sm-1">
                            <input id="rolling_quality_check" class="form-control" type="checkbox" name="ROLLING_QUALITY_CHECK" value="1" <?php echo (isset($order->ROLLING_QUALITY_CHECK)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="ROLLING_QUALITY_CHECK"/>
                        </div>
                        -->
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ANNEALING">Annealing:</label>
                        <div class="col-sm-1">
                            <input id="stage_6" class="form-control stage" type="checkbox" name="ANNEALING" value="1" <?php echo (isset($order->ANNEALING)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="ANNEALING"/>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="BENDING">Bending:</label>
                        <div class="col-sm-1">
                            <input id="stage_7" class="form-control stage" type="checkbox" name="BENDING" value="1" <?php echo (isset($order->BENDING)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="BENDING"/>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="FINNING">Finning:</label>
                        <div class="col-sm-1">
                            <input class="form-control " type="checkbox" name="FINNING" value="1" <?php echo (isset($order->FINNING)) ? 'disabled="disabled"':'';?>/>
                            <!--input type="hidden" name="FINNING"/-->
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="BRAZING">Brazing:</label>
                        <div class="col-sm-1">
                            <input id="stage_8" class="form-control stage" type="checkbox" name="BRAZING" value="1" <?php echo (isset($order->BRAZING)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="BRAZING"/>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ELECRICAL_TESTING_2">Elecrical Testing:</label>
                        <div class="col-sm-1">
                            <input id="stage_9" class="form-control stage" type="checkbox" name="ELECRICAL_TESTING_2" value="1" <?php echo (isset($order->ELECRICAL_TESTING_2)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="ELECRICAL_TESTING_2"/>
                        </div>
                        <label class="control-label col-sm-2 text-left" for="ELECRICAL_TESTING_2_QC">Quality Yes:</label>
                        <div class="col-sm-1">
                            <input id="elecrical_testing_2_qc" class="form-control qc" type="checkbox" name="ELECRICAL_TESTING_2_QC" value="1" <?php echo (isset($order->ELECRICAL_TESTING_2_QC)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="ELECRICAL_TESTING_2_QC"/>
                        </div>
                        <label class="control-label col-sm-2 text-left" for="ELECRICAL_TESTING_2_QC_FAIL">Quality No:</label>
                        <div class="col-sm-1">
                            <input id="elecrical_testing_2_qc_fail" class="form-control qc fail" type="checkbox" name="ELECRICAL_TESTING_2_QC_FAIL" value="1" <?php echo (isset($order->ELECRICAL_TESTING_2_QC_FAIL)) ? 'disabled="disabled"':'';?>/>
                            <!--input type="hidden" name="FILLING_QUALITY_CHECK_FAIL"/-->
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="SEALING">Sealing:</label>
                        <div class="col-sm-1">
                            <input id="stage_10" class="form-control stage" type="checkbox" name="SEALING" value="1" <?php echo (isset($order->SEALING)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="SEALING"/>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="MOUNTING">Nut/Washer Mounting:</label>
                        <div class="col-sm-1">
                            <input id="stage_11" class="form-control stage" type="checkbox" name="MOUNTING" value="1" <?php echo (isset($order->MOUNTING)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="MOUNTING"/>
                        </div>
                    </div>
                    <!--
                    <hr/>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ASSEMBLY">Assembly:</label>
                        <div class="col-sm-1">
                            <input id="stage_7" class="form-control stage" type="checkbox" name="ASSEMBLY" value="1" <?php echo (isset($order->ASSEMBLY)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="ASSEMBLY"/>
                        </div>
                    </div>
                    -->
                    <hr/>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="FINAL_TESTING">Final Testing:</label>
                        <div class="col-sm-1">
                            <input id="stage_12" class="form-control stage" type="checkbox" name="FINAL_TESTING" value="1" <?php echo (isset($order->FINAL_TESTING)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="FINAL_TESTING"/>
                        </div>
                        <label class="control-label col-sm-2 text-left" for="FINAL_TESTING_QC">Quality Yes:</label>
                        <div class="col-sm-1">
                            <input id="final_testing_qc" class="form-control qc" type="checkbox" name="FINAL_TESTING_QC" value="1" <?php echo (isset($order->FINAL_TESTING_QC)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="FINAL_TESTING_QC"/>
                        </div>
                        <label class="control-label col-sm-2 text-left" for="FINAL_TESTING_QC_FAIL">Quality No:</label>
                        <div class="col-sm-1">
                            <input id="final_testing_qc_fail" class="form-control qc fail" type="checkbox" name="FINAL_TESTING_QC_FAIL" value="1" <?php echo (isset($order->FINAL_TESTING_QC_FAIL)) ? 'disabled="disabled"':'';?>/>
                            <!--input type="hidden" name="FILLING_QUALITY_CHECK_FAIL"/-->
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="ELECTRICAL_CONNECTION">Electrical Connection:</label>
                        <div class="col-sm-1">
                            <input id="stage_13" class="form-control stage" type="checkbox" name="ELECTRICAL_CONNECTION" value="1" <?php echo (isset($order->ELECTRICAL_CONNECTION)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="ELECTRICAL_CONNECTION"/>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label class="control-label col-sm-2 text-left" for="FINAL_INSPECTION">FINAL_INSPECTION:</label>
                        <div class="col-sm-1">
                            <input id="stage_14" class="form-control stage" type="checkbox" name="FINAL_INSPECTION" value="1" <?php echo (isset($order->FINAL_INSPECTION)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="FINAL_INSPECTION"/>
                        </div>
                        <label class="control-label col-sm-2 text-left" for="FINAL_INSPECTION_QC">Quality Yes:</label>
                        <div class="col-sm-1">
                            <input id="final_inspection_qc" class="form-control qc" type="checkbox" name="FINAL_INSPECTION_QC" value="1" <?php echo (isset($order->FINAL_INSPECTION_QC)) ? 'disabled="disabled"':'';?>/>
                            <input type="hidden" name="FINAL_INSPECTION_QC"/>
                        </div>
                        <label class="control-label col-sm-2 text-left" for="FINAL_INSPECTION_QC_FAIL">Quality No:</label>
                        <div class="col-sm-1">
                            <input id="final_inspection_qc_fail" class="form-control qc fail" type="checkbox" name="FINAL_INSPECTION_QC_FAIL" value="1" <?php echo (isset($order->FINAL_INSPECTION_QC_FAIL)) ? 'disabled="disabled"':'';?>/>
                            <!--input type="hidden" name="FILLING_QUALITY_CHECK_FAIL"/-->
                        </div>
                    </div>
                    <hr/>
                </fieldset>
            </div>
        </div>
        <div class="box-footer">
            <button id="btnSubmit" type="submit" class="btn btn-primary">Save</button>
            <a href="<?php echo base_url('order'); ?>" class="btn btn-danger">Cancel</a>
        </div>
        <div id='line-example'></div>
    </section>
    <!-- /.content -->
    </form>
</aside><!-- /.right-side -->
<hr/>
<?php $user_role = $this->session->userdata('user')->role ?>; ?>
<script src="<?php echo BASE_PATH; ?>assets/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    $('document').ready(function() {
        /*-------------------------- Form Validation -------------------------*
        $.validator.addMethod('contentIds', function(value) {
            var contents = /^[0-9,]*$/;    
            return value.match(contents);
        }, 'Invalid Content Ids');
	
        $("#orderForm").validate({
            rules: {
                    contentId: {
                        contentIds: true
                    }
            },
            invalidHandler: function(event, validator) {
                // 'this' refers to the form
                var errors = validator.numberOfInvalids();
                if (errors) {
                var message = errors == 1
                    $('#myModal').modal('hide');
                } else {
                //$("div.error").hide();
                }
            }
        });
        /*--------------------------------------------------------------------*/
    });
    
     $( "#sortable" ).on( "sortupdate", function( event, ui ) {
        //console.log(ui);
        //updateOrder();
    } );
   
    
    /*-------------------- Chose plugin for searchable dropdown --------------*/
    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
        '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    /*------------------------------------------------------------------------*/

    $("document").ready(function() {
        var user_role = <?php echo $user_role; ?>;
        console.log(user_role);
        /*
        $('.inventory').on('change', function () {
            var selectVal = $("option:selected", this).data('unit');
            //console.log($(this).siblings(".inventory-unit"));
            $(this).parent().siblings(".inventory-unit").html(selectVal);
        });
        */
        /*
        $('#ORDER_ID').on('change', function() {
            var order = JSON.parse($(this).children("option:selected").attr('data-order_json'));
            $("#CUSTOMER_NAME").val(order.CUSTOMER_NAME);
            $("#CUSTOMER_ADDRESS").val(order.CUSTOMER_ADDRESS);
        });
        $("#orderForm").submit(function(e) {
            //e.preventDefault();
            alert("Test");return false;
        });
        */

        $('input:checkbox#stage_5').on("change",function(){
            var checked = $("#elecrical_testing_1_qc:checked").length;
            if(!checked){
                alert("elecrical_testing_1_qc required");
                $(this).prop('checked', false);
            }
        });
        $('input:checkbox#stage_10').on("change",function(){
            var checked = $("#elecrical_testing_2_qc:checked").length;
            if(!checked){
                alert("elecrical_testing_2_qc required");
                $(this).prop('checked', false);
            }
        });
        $('input:checkbox#stage_13').on("change",function(){
            var checked = $("#final_testing_qc:checked").length;
            if(!checked){
                alert("final_testing_qc required");
                $(this).prop('checked', false);
            }
        });
        $('input:checkbox.qc').on("change",function() {
            var formGroup = $(this).closest('div.form-group');
            var prevStage = $(formGroup).find('input.stage');

            //.attr("id");
            //.prop('checked', true);
            //console.log(formGroup);return;
            if(authForAction(this)){
                var isPrevChecked = prevChecked($(prevStage).attr("id"));
                if(!isPrevChecked){
                    alert("Check Previous Stages First");
                    $(this).prop('checked', false);
                }
                else{
                    if($(this).hasClass('fail')){
                        $(formGroup).find('input:hidden').val(0);
                        $(prevStage).next().val(0);
                        $(prevStage).prop('checked', false);
                        $(prevStage).prop('disabled', false);
                    }
                    else{
                        //alert("QC success");
                    }
                    $(this).next().val(1);
                    $(formGroup).find('input.qc').prop('disabled', true);
                    //$(this).prop('disabled', true);
                }
            }
        });
        /*
        $('input:checkbox#filling_quality_check').on("change",function(){
            var isPrevChecked = prevChecked("stage_3");
            if(jQuery.inArray(user_role,[1,4]) === -1) {
                alert("You are not authorised for this action");
                $(this).prop('checked', false);
            }
            else if(!isPrevChecked){
                alert("Check Previous Stages First");
                $(this).prop('checked', false);
            }
            else{
                $(this).next().val(1);
                $(this).prop('disabled', true);
            }
        });
        $('input:checkbox#rolling_quality_check').on("change",function(){
            var isPrevChecked = prevChecked("stage_4");
            if(jQuery.inArray(user_role,[1,4]) === -1) {
                alert("You are not authorised for this action");
                $(this).prop('checked', false);
            }
            else if(!isPrevChecked){
                alert("Check Previous Stages First");
                $(this).prop('checked', false);
            }
            else{
                //$(this).prop('checked', false);
                $(this).next().val(1);
                $(this).prop('disabled', true);
            }
        });
        $('input:checkbox#brazing_qc').on("change",function(){
            //console.log($(this).closest('div'));return;
            //.find('input:not(:first-child)')
            if(authForAction(this)){
                var isPrevChecked = prevChecked("stage_7");
                if(!isPrevChecked){
                    alert("Check Previous Stages First");
                    $(this).prop('checked', false);
                }
                else{
                    $(this).next().val(1);
                    $(this).prop('disabled', true);
                }
            }
        });
        $('input:checkbox#mounting_qc').on("change",function(){
            //console.log($(this).closest('div'));return;
            //.find('input:not(:first-child)')
            if(authForAction(this)){
                var isPrevChecked = prevChecked("stage_9");
                if(!isPrevChecked){
                    alert("Check Previous Stages First");
                    $(this).prop('checked', false);
                }
                else{
                    $(this).next().val(1);
                    $(this).prop('disabled', true);
                }
            }
        });
        */
        $('input:checkbox.stage').on("change",function() {
            /*
            var prevFormGroup = $(this).closest('div.form-group').prev();
            var prevQc = $(prevFormGroup).html();
            //.find('input.qc').length;
            console.table(prevQc);return;
            */
            /*
            if(jQuery.inArray(user_role,[1,5]) === -1) {
                alert("You are not authorised for this action");
                $(this).prop('checked', false);
            }*/
            if(authForAction(this)) {

                var isPrevChecked = prevChecked($(this).prop('id'));
                if(!isPrevChecked){
                    alert("Check Previous Stages First");
                    $(this).prop('checked', false);
                }
                else {
                    $(this).next().val(1);
                    $(this).prop('disabled', true);
                    //$(this).setAttribute("disabled");
                }
            }
            
        });
        function authForAction(param) {
            console.log(param);
            console.log(user_role);
            if($(param).hasClass("stage")) {
                var authRoles = [1,5];
            }
            else if($(param).hasClass("qc")){
                var authRoles = [1,4];
            }
            else {
                return false;
            }
            //console.log(authRoles);
            if(jQuery.inArray(user_role,authRoles) === -1) {
                alert("You are not authorised for this action");
                $(param).prop('checked', false);
                return false;
            }
            return true;
        }
        function prevChecked(id) {
            var idArr = id.split("_");
            console.log(idArr);
            isPrevChecked = true;
            for(i = idArr[1]; i>=0; i--){
                var checked = $("#"+idArr[0]+"_"+i+":checked").length;
                if(!checked){
                    isPrevChecked = false;
                    break;
                }
            }
            return isPrevChecked;
        }
        /*
            $("#PRODUCTION_STAGES").on("click",function(){
                alert("stages");
            });
            var selected = [];
            $('input:checked').each(function() {
                selected.push($(this).attr('name'));
            });
            console.log(selected);
        */
        /*
            $('input').on('ifChecked', function(event){
                // alert(event.type + ' callback');
                // console.log(event);
                // $(this).prop("checked", false);
                // $('input').iCheck('uncheck');
                var selected = [];
                $('input:checked').each(function() {
                    selected.push($(this).attr('name'));
                });
                console.log(selected.length);
                console.log($(this).prop('id'));
                var id = $(this).prop('id');
                $("#"+id).iCheck("uncheck",function(){
                    alert("uncheck");
                });
            });
        */
        // $("#test").on("click",function(){
        //     alert("click");
        // });

        $('#ORDER_ID').on('change', function() {
            var orderId = $(this).val();
            //alert(orderId);return;
            $("#btnSubmit").attr("disabled", true);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('order/detail/'); ?>/"+orderId,
                data: { 'ajax': true },
                dataType: "json",
                success: function(data) {
                        //called when successful
                        //console.log(data);
                        //console.log(data.orderMaterials);
                        var bom_body = "";
                        $.each(data.materials, function(i,material) {
                            bom_body += '<tr><td class="sorting_1">'+ (i+1) +'</td><td class="name">'+material.ITEM_NAME +'</td><td class="uom">'+ material.UOM +'</td><td class="quantity">' +material.QUANTITY +'</td></tr>';
                        });

                        $("#CUSTOMER_NAME").val(data.order.CUSTOMER_NAME);
                        $("#CUSTOMER_ADDRESS").val(data.order.CUSTOMER_ADDRESS);
                        $("#ITEM_NAME").val(data.items[0].ITEM_NAME);
                        $("#QUANTITY").val(data.items[0].QUANTITY);
                        $("#BOM_BODY").html(bom_body);
                        var productionStages = ["MATERIAL_RECEIVED", "PIPE_CUTTING", "COILING", "FILLING", "ELECRICAL_TESTING_1", "ELECRICAL_TESTING_1_QC", "ROLLING", "ANNEALING", "BENDING", "FINNING", "BRAZING", "ELECRICAL_TESTING_2", "ELECRICAL_TESTING_2_QC", "SEALING", "MOUNTING", "FINAL_TESTING", "FINAL_TESTING_QC", "ELECTRICAL_CONNECTION", "FINAL_INSPECTION", "FINAL_INSPECTION_QC"];
                        if(typeof data.productionStages.PIPE_CUTTING_DATE !== 'undefined') {
                            productionStages.forEach(function(stage){
                                var stage_date = stage+"_DATE";
                                //console.log(stage_date);
                                //console.log(data.productionStages[stage_date]);
                                if(data.productionStages[stage_date] != "0000-00-00 00:00:00" ) {
                                    console.log(stage);
                                    $("input[type='checkbox'][name='"+stage+"']").attr('checked', true);
                                    $("input[type='checkbox'][name='"+stage+"']").attr('disabled', true);
                                    $("input[type='checkbox'][name='"+stage+"_FAIL']").attr('disabled', true);
                                }
                            });
                        }
                        $('#btnSubmit').removeAttr("disabled");
                },
                error: function(e) {
                        //called when there is an error
                        console.log(e.message);
                        return false;
                }
            });

        });
    });
</script>