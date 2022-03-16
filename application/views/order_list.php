<?php include('header.php');?>
<style type="text/css">
    .order_status{
        width: 100%;
    }
    .otp{
        background: #004e00;
    }
    .otp:hover{
        background: #004e00;

    }
    #order-status .modal-content {
        padding:15px;
    }
    #order-status .modal-dialog {
        top: 50%;
        transform: translateY(-50%);
    }
    #order-status th {
        text-transform: capitalize;
        color: #787878;
    } 
    #order-status table, th, td {
        border:1px solid #ccc;
        padding: 10px;
        text-transform: capitalize;
    }
    #order-status h4 {
        text-transform: capitalize;
        margin-bottom: 20px;
        font-size: 40px;
        color: #000;
    } 
    #order-status table {
        width: 100%;
    }
</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/index'; ?>">Home</a> / Order</a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>

        <div id="msg">
            <?php if ($this->session->flashdata('msg') && $this->session->flashdata('msg') != '') { ?>
                <div class="alert alert-success fade in">
                    <strong>Success!</strong> <?php echo $this->session->flashdata('msg');; ?>
                </div>
            <?php } ?>
             <?php if ($this->session->flashdata('myMessage') && $this->session->flashdata('myMessage') != '') { 
                echo $this->session->flashdata('myMessage');
             } ?>
           
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading"> Order</header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                               <!--  <div class="panel-body padding-zero" style="float: right">
                                    <a href="#" id="delete_user" class="btn btn-danger">Delete Order</a>
                                </div> -->
                                <table class="display table table-bordered table-striped dataTable" id="example_order" aria-describedby="example_info">
                                    <thead>
                                    <tr role="row">
                                        <!-- <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Rendering engine: activate to sort column ascending"
                                            style="width: 100px;"><input type="checkbox" class="checkboxMain">
                                        </th> -->
                                      <!--   <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Rendering engine: activate to sort column ascending"
                                            style="width: 100px;">Order From
                                        </th> -->
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Rendering engine: activate to sort column ascending"
                                            style="width: 100px;">isSelfPickup
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                                   rowspan="1" colspan="1"
                                                   aria-label="Rendering engine: activate to sort column ascending"
                                                   style="width: 100px;">Order No
                                        </th>


                                        <!--                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"-->
<!--                                            rowspan="1" colspan="1"-->
<!--                                            aria-label="Platform(s): activate to sort column ascending"-->
<!--                                            style="width: 180px;">Order No-->
<!--                                        </th>-->
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 180px;">Order Date
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 220px;">Username
                                        </th>
                                      <!--  <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 180px;">Total Savings
                                        </th>
                                         <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 100px;">Total Items
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 100px;">Subtotal
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 100px;">Delivery Charge
                                        </th> -->
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 100px;">Total Amount
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 120px;">Payment Type
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 120px;">Order Status
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 120px;">Otp Verify
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 120px;">Order log
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 120px;">Refund
                                        </th>


                                        <!--  <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Rendering engine: activate to sort column ascending"
                                            style="width: 100px;">Action
                                        </th> -->
                                    </tr>
                                    </thead>
                                    <!-- <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <?php foreach ($order_result as $result){ ?>
                                    <?php if($result->order_status=='1'){
                                                $rowcolor = "style='background-color: #014da2 !important; color: white; font-weight:bold;'";
                                            }elseif($result->order_status=='2'){
                                                $rowcolor = "style='background-color:#440e00 !important; color: white; font-weight:bold;'";

                                            }elseif($result->order_status=='3'){
                                            $rowcolor = "style='background-color:#2ac8ac !important; color: white; font-weight:bold;'";

                                        }elseif($result->order_status=='4'){
                                            $rowcolor = "style='background-color:#ff9626 !important; color: white; font-weight:bold;'";

                                        }elseif($result->order_status=='5'){
                                            $rowcolor = "style='background-color:#8f4ede !important; color: white; font-weight:bold;'";

                                        }elseif($result->order_status=='8'){
                                            $rowcolor = "style='background-color:#3da449 !important; color: white; font-weight:bold;'";

                                        }else{
                                                $rowcolor = "style='background-color:#fe4552 !important; color: white; font-weight:bold;'";

                                            } 

                                    ?>
                                        <tr class="gradeX odd" > -->

                                            <!-- <td class="hidden-phone">
                                                <?php if ($result->id) { ?>
                                                    <input type="checkbox" name="delete[]" id='iId' value="<?php echo $result->id; ?>" class="checkbox_user">
                                                <?php } ?>
                                            </td> -->

                                          <!--   <td class="hidden-phone"><?php if($result->order_from == 0){ echo "POS";}else{ echo "Grocery";} ?></td> -->

                                            <!--  <td class="hidden-phone"><a href="<?php // echo base_url() . 'order/order_detail_list?id=' .$this->utility->encode($result->id); ?>">
                                            </a></td> -->

                                           <!-- <td> <?php echo $result->order_no; ?> </td> -->

                                          <!--     <td class="hidden-phone"><a target="_blank" href="<?php echo base_url() . 'order/order_detail?id=' .$this->utility->encode($result->id); ?>">
                                            <?php echo $result->order_no; ?> </a></td>
 -->
<!--                                             <td class="hidden-phone"><a target="_blank" href="--><?php //echo base_url() . 'order/order_detail?id=' .$this->utility->encode($result->id); ?><!--">-->
<!--                                            --><?php //echo $result->order_no; ?><!-- </a></td>-->
                                            <!-- <td class="hidden-phone"><?php echo date('Y-m-d h:i - a',$result->dt_added); ?></td> -->

                                            
<!-- 
                                             <td class="hidden-phone"><?php if($result->order_from == 0){ echo $result->customer_name;}else{ echo $result->fname.' '.$result->lname;} ?></td> -->
                                           <!--  <td class="hidden-phone"><?php // echo 'Rs '.$result->total_saving; ?></td>
                                            <td class="hidden-phone"><?php // echo $result->total_item; ?></td>
                                            <td class="hidden-phone"><?php // echo 'Rs '.$result->sub_total; ?></td>
                                            <td class="hidden-phone"><?php // echo 'Rs '.$result->delivery_charge; ?></td>
                                            <td class="hidden-phone"><?php // echo 'Rs '.$result->total; ?></td> -->
                                           <!--  <td class="hidden-phone"><?php echo $result->payable_amount; ?></td>
                                            <td class="hidden-phone">
                                                <?php
                                                    if($result->payment_type == '0'){
                                                        echo 'COD';
                                                    }else{
                                                        echo 'Credit-card';
                                                    }
                                                ?>
                                            </td> -->
                                            <!-- <td>
                                                <a href="javascript:;" onclick="single_delete(<?php //  echo $result->id; ?>)" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                                                 <a href="<?php //  echo base_url() . 'order/order_detail_list?id=' .$this->utility->encode($result->id); ?>" class="btn btn-primary btn-xs"><i class="fa fa-check-square "></i></a> 
                                            </td> -->
                                         <!--    <td>
                                            <select  <?php if($result->order_status=='9' || $result->order_status=='8'|| $result->order_status=='4'){echo "disabled";}  ?> <?php echo $rowcolor; ?> class="form-group order_status" data-id="<?php echo $result->id;?>">
                                                <?php if($result->order_status!='3'){ ?>

                                                <option <?php if($result->order_status=='1'){echo "SELECTED";} ?> value="1">New Order</option>
                                                <option <?php if($result->order_status=='2'){echo "SELECTED";} ?> value="2">Pending</option>
                                            <?php } ?>
                                                <option <?php if($result->order_status=='3'){echo "SELECTED";} ?> value="3">Ready</option>
                                                <option <?php if($result->order_status=='4'){echo "SELECTED";} ?> value="4">Pick up</option>
                                                <option <?php if($result->order_status=='5'){echo "SELECTED";} ?> value="5">On the way</option>
                                                <option <?php if($result->order_status=='8'){echo "SELECTED";} ?> value="8">Delivered</option>
                                                <option disabled <?php if($result->order_status=='9'){echo "SELECTED";}  ?> value="9">Cancelled</option>
                                            </select>
                                            </td>
                                            <td>
                                <input type="button" <?php if($result->order_status=='5'){echo "disabled";}?> value="<?php if($result->order_status=='5'){echo "verified";}else{echo "Verify Otp";} ?>" data-id="<?php echo $result->id; ?>" class="otp btn btn-info">
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody> -->
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>

      <div class="modal" id="order-status">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="order-status-title">
                 <h4 class="text-center">Order log</h4>  
            </div>        
            <table>
                <thead>  
                  <tr>
                    <th>s.no</th>
                    <th>order status</th>
                    <th>created on</th>
                  </tr>
                </thead>
                <tbody id="tr">  
                    
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div style="background: #0f3c4a" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4  class="modal-title" align="center">Otp Verification</h4>
                </div>
                <?php if($_SERVER['SERVER_NAME']=='magnus.launchestore.com'){?>
                    <p align="center" style="color: #2ae0bb">Please ask to delivery for OTP..!</p>
                <?php }?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Otp</label>
                        <input type="text" name="otp" id="otp" class="form-control" value="" required placeholder="4-PIN OTP">
                        <input type="hidden" value="" id="project_id" name="project_id">
                    </div>
                    <span style="color: red" id="error"></span>
                </div>
                <div class="modal-footer">
                    <input type="submit"  id="submitotp" style="color:white;background: #0f3c4a" class="btn  btn-circle submitBtn" value="Submit" name="submit"/>
                </div>
            </div>
        </div>
    </div>

<!--main content end-->
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        $(document).on('click','.otp',function () {
            $('#myModal').modal('show');
            var id = $(this).data('id');
            var isSelfPickup = $(this).data('is_self_pickup');
            $('#submitotp').attr('data-isselfpickup',isSelfPickup);
            $('#submitotp').attr('data-id',id);
        });

        $('#submitotp').click(function () {

            var id = $(this).data('id');
            var otp = $('#otp').val();
              var isSelfPickup = $(this).data('isselfpickup');

            $.ajax({
                url: '<?php echo base_url() . 'order/verify_otp'; ?>',
                data: {
                    id: id, otp: otp,isSelfPickup:isSelfPickup
                },
                type: 'POST',
                success: function (data) {

                    if(data != 1){
                        $('#error').html("Wrong otp please recheck..!");
                    }
                    else{
                        location.reload();
                    }

                }
            });
        });
    });

    setTimeout(function () { $('#msg').hide(); }, 4000);
    $(document).on('change','.order_status',function(){
       $('.order_status').removeAttr('id');
       $(this).attr('id','myselect');
       var orderstatus = $(this);
        var order_id = $(this).attr('data-id');
        var status = $(this).val();
        var style; 

        if(status==1){
            style = "background-color:#014da2  !important; color: white; font-weight:bold;";
        }else if(status==2){
            style = "background-color:#440e00 !important; color: white; font-weight:bold;";
        }else if(status==3){
            style = "background-color:#2ac8ac !important; color: white; font-weight:bold;";
        }
        else if(status==4){
            style ="background-color:#ff9626 !important; color: white; font-weight:bold;";
        }
        else if(status==5){
            style ="background-color:#8f4ede !important; color: white; font-weight:bold;";
        }
        else if(status==8){
            style ="background-color:#3da449 !important; color: white; font-weight:bold;";
        }
        else{
            style ="background-color:#fe4552  !important; color: white; font-weight:bold;";
        }

        if(status == '9'){
            var X = confirm('Are you sure..? You want to cancel and Refund');
            if(!X){
                return false;
            }
        }
         $.ajax({
                    url: '<?php echo base_url().'order/change_order_status'; ?>' ,
                    data: {
                        order_id: order_id,status:status
                    },
                    type: 'POST',
                    success: function (data) {

                         if(data.status == 9){
                           orderstatus.val('9');
                           orderstatus.attr('disabled','disabled');
                           style ="background-color:#f92e2e !important; color: white; font-weight:bold;";
                    }
                    
                        $(this).removeAttr('style');
                        $('#myselect').attr('style',style);

                    },
                    error: function () {
                        alert('Failed to change order status.');
                    }
                });

    });
    /*Single Delete Script*/
    function single_delete(value) {

        bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
            if (confirmed == true) {
                var id = value;
                $.ajax({
                    url: '<?php echo base_url().'order/single_delete_order'; ?>' ,
                    data: {
                        id: id
                    },
                    success: function (data) {

                        if (data.status == 1) {
                            bootbox.alert("Order has been deleted successfully.", function() {
                                window.location.reload(true);
                            });
                        }
                        else {
                            alert('Failed to delete selected order.');
                        }
                    },
                    error: function () {
                        alert('Failed to delete selected order.');
                    }
                });
            }
            else
            {
                window.location.reload(true);
            }
        });
    }

    $('#delete_user').click(function() {

        if($('.checkbox_user:checked').length == 0) {
            //alert("Select one record"); return false;
            bootbox.alert('Please select at least one record to delete');
            return;
        }
        bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
            if (confirmed == true) {

                var ids = [];
                $('.checkbox_user:checked').each(function() {
                    ids.push($(this).val());
                });
                $.ajax({
                    url: '<?php echo base_url().'order/multi_delete_order'; ?>',
                    data: { ids: ids.toString() },
                    success: function(data) {
                        if(data.status == 1) {

                            bootbox.alert("Order(s) has been deleted successfully.", function() {
                                window.location.reload(true);
                            });
                        }
                        else {
                            bootbox.alert('Failed to delete the selected records.');
                        }
                    },
                    error: function() {
                        bootbox.alert('Failed to delete the selected records.');
                    }
                });
            }
            else
            {
                window.location.reload(true);
            }
        });
    });

    $(document).ready(function(){
        $('.checkboxMain').on('click',function(){
            if(this.checked){
                $('.checkbox_user').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkbox_user').each(function(){
                    this.checked = false;
                });
            }
        });

        $('.checkbox_user').on('click',function(){
            if($('.checkbox_user:checked').length == $('.checkbox_user').length){
                $('.checkboxMain').prop('checked',true);
            }else{
                $('.checkboxMain').prop('checked',false);
            }
        });
    });

</script>
<?php include('footer.php'); ?>