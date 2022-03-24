<?php
   include('header.php');
   // error_reporting(0);
   $id = $this->utility->decode($_GET['id']);
   $vendor_id = $this->session->userdata['id'];
   ?>
<?php 
  
   ?>
<style type="text/css">
	 .fl-mr-20{
    margin-top: 20px;
    float:left !important;
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
               <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home /</a><a href="<?php echo base_url().'vendor/vendor_accounting'; ?>"> Vendor accounting </a> / Set Profit</a> </li>
            </ul>
            <!--breadcrumbs end -->
         </div>
      </div>
      <div class="row">
         <!--Left Part-->
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <section class="panel">
               <header class="panel-heading">
                  Set Profit
               </header>
                <header  class="panel-heading" style="margin-left: 20%">
                    <?='Owner Name : '. $owner_name."  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Shop Name : ".$store_name;?>
                </header>
               <form  enctype="multipart/form-data"  role="form" method="post" action="<?php echo base_url().'vendor/set_profit'; ?>" name="vendor_form" id="vendor_form">
                  <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                  <input type="hidden" id="web" name="web" value="1">
                  <div class="panel-body">
                     <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                           <div class="form-group">
                              <label for="" class="margin_top_label">Total Revenue :<span class="required" aria-required="true"> * </span>
                              </label>                            
                              <input type="text" disabled=""  name="total_revenue" placeholder="Total Revenue" autocomplete="off" class="dis form-control margin_top_input" value="<?php if(isset($profit_result['profit'])){ echo $profit_result['profit']; }else{ echo 0; } ?>">
                               <span style="color: red;"><?php echo form_error('total_revenue'); ?></span>
                           </div>

                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                           <div class="form-group">
                              <label for="" class="margin_top_label">Total Received :<span class="required" aria-required="true"> * </span>
                              </label>
                              <input type="text" disabled="" id="recive" name="recive" placeholder="Total Recive" autocomplete="off" class="dis form-control margin_top_input" value="<?php if(isset($profit_take_result['profit'])){ echo $profit_take_result['profit']; }else{ echo 0; } ?>">
                               <span style="color: red;"><?php echo form_error('recive'); ?></span>
                           </div>
                       </div>
                       <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                           <div class="form-group">
                              <label for="" class="margin_top_label">Pending Payment :<span class="required" aria-required="true"> * </span>
                              </label>                            
                              <input type="text" disabled="" id="pending" name="pending" placeholder="Total Recive" autocomplete="off" class="dis form-control margin_top_input" value="<?php if(isset($profit_result['profit'])){ echo $profit_result['profit']-$profit_take_result['profit']; }else{ echo 0; } ?>">
                               <span style="color: red;"><?php echo form_error('pending'); ?></span>
                           </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                           <div class="form-group">
                              <label for="" class="margin_top_label">Accept Money :<span class="required" aria-required="true"> * </span>
                              </label>                            
                              <input type="text" onkeyup="validate()" id="accept_money" name="accept_money" placeholder="Accept Money" autocomplete="off" class="dis form-control margin_top_input" value="">
                               <span id="err" style="color: red;"><?php echo form_error('accept_money'); ?></span>
                           
                           </div>
                     </div>
                    <div class="col-lg-3 col-md-6 col-sm-2 col-xs-12">
                        <!-- <span class="panel-body padding-zero" > -->
                       
                        <input type="submit" class="btn btn-info pull-right fl-mr-20" value="Accept Money" name="submit1">
                           <a href="<?php echo base_url().'vendor/vendor_accounting/'; ?>" id="delete_user" class="btn btn-danger fl-mr-20">Cancel</a> 
                        <!-- </span> -->
                        </div>
                  </div>
               </form>
                
            </section>
         </div>
         <!--Map Part-->
      </div>
      <!-- page end-->

          <div class="row">
         <!--Left Part-->
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <section class="panel">
               <header class="panel-heading">
                 Payment Details
               </header>
               <div class="panel-body">
                        <div class="adv-table">
                            <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                               
                                <table class="display table table-bordered table-striped dataTable" id="example"
                                       aria-describedby="example_info">
                                    <thead>
                                    <tr role="row">
                                       
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Received Payment
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Received Date
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <?php
                                        foreach ($profit_result_detail as $result){
                                           
                                    ?>
                                        <tr class="gradeX odd">

                                           
                                            <td class="hidden-phone"><?php echo $getcurrency['value'].' '.$result->profit; ?></td>
                                             <td class="service"><?php echo date('d-M-Y',strtotime($result->dt_created)); ?></td>
								           
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                
            </section>
         </div>
         <!--Map Part-->
      </div>

      <div class="row">
         <!--Left Part-->
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <section class="panel">
               <header class="panel-heading">
                 Order Details
               </header>
               <div class="panel-body">
                        <div class="adv-table">
                            <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                               
                                <table class="display table table-bordered table-striped dataTable" id="example1"
                                       aria-describedby="example_info">
                                    <thead>
                                    <tr role="row">
                                       
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Customer Name
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Order No
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Order Date
                                        </th>
<!--                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"-->
<!--                                            rowspan="1" colspan="1"-->
<!--                                            aria-label="Platform(s): activate to sort column ascending"-->
<!--                                            style="width: 200px;">Actual Price-->
<!--                                        </th>-->
<!--                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"-->
<!--                                            rowspan="1" colspan="1"-->
<!--                                            aria-label="Platform(s): activate to sort column ascending"-->
<!--                                            style="width: 200px;">Discount Price-->
<!--                                        </th>-->
<!--                                        -->
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Order Ammount
                                        </th>                                        
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Profit
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <?php
                                        foreach ($order_result as $result){

                                            $weight_query = $this->db->query("SELECT weight_no FROM product_weight WHERE product_id = '$result->product_id' AND weight_id = '$result->weight_id'");
                                            $weight_result = $weight_query->row_array();


                                            $profit_query = $this->db->query("SELECT sum(total_profit) as `profit` FROM profit WHERE vendor_id='$result->vendor_id' AND order_id = '$result->id'");
                                            $profit = $profit_query->row_array();

//                                            print_r($profit);
//                                            exit;

                                    ?>
                                        <tr class="gradeX odd">

                                           
                                            <td class="hidden-phone"><?php echo $result->fname.' '.$result->lname; ?></td>
                                            <td class="hidden-phone"><a target="_blank" href="<?php echo base_url() . 'order/order_detail?id=' .$this->utility->encode($result->id).'&vendor_id='.$this->utility->encode($id); ?>">
                                                    <?php echo $result->order_no; ?> </a></td>
								            <td class="qty"><?php echo $result->dt_added; ?></td>
<!--								            <td class="unit">--><?php //echo $getcurrency['value'].' '.$result->actual_price ?><!--</td>-->
<!--								            <td class="qty">--><?php //echo $getcurrency['value'].' '.$result->discount_price; ?><!--</td>-->
								            <td class="total"><?php echo $getcurrency['value'].' '.$result->total; ?></td>
                                            <td class="hidden-phone"><?php echo $getcurrency['value'].' '.$profit['profit']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                
            </section>
         </div>
         <!--Map Part-->
      </div>


  



   </section>
</section>
<!--main content end-->
<style> label.error { color: red; font-weight: 500; } </style>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
 <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeCDbEPFYP5aVlxPzE8ZDE2O3I_pelYOM&v=3.exp&libraries=places"></script> -->
   </body>
<script type="text/javascript">
// setTimeout(function(){
//   $('.dis').removeAttr('disabled');
// },700);
  $('#accept_money').keydown(function(){
    $('#err').html("");
  });
 $('#accept_money').change(function(){
   $('#err').html("");
    var st = $("#pending").val();
    var en = $(this).val();
    st = parseInt(st);
    en = parseInt(en);
    console.log(st);
    console.log(en);
    if(en!=''){
        
        if(en>st){
            $('.btn-info').attr('disabled','true');
            $('#err').html("You can't accept more than pending payment");
        }else{
            $('#err').html("");
            $('#err1').html("");
            $('.btn-info').removeAttr('disabled');        
        }
    }else{
        
            $('#err').html("");
    }
});


    $('#vendor_form').validate({

              rules: {
                total_revenue: {
                      required: true,
                    },
                recive:{
                  required : true,
                 
                },
                accept_money: {
                    required: true,
                    minlength: 1,
                    digits:true
                }
                
              },
              messages: {
                total_revenue: {
                    required: "Please enter shop name",
                     
                },
                paid:{
                    required: "Please enter shop owner name",
                },
                accept_money: {
                  required: "Please enter accept money",
                  minlength: "Please accept minimum money",
                  digits:"Please enter valid accept money"
                }
              },
             
          });


     
</script>

<script type="text/javascript">
     function validate(evt) {
          var theEvent = evt || window.event;
          var key = theEvent.keyCode || theEvent.which;
          key = String.fromCharCode( key );
          var regex = /[0-9]|\./;
          if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
          }
        }
        $('#paid').keyup(function(){
            window.location.href = window.location.href ;
        });
</script>
<?php include('footer.php'); ?>
<script type="text/javascript">
	$('#example1').dataTable();
</script>