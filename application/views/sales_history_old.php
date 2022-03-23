<?php
   include('header.php');
   $branch_id = $this->session->userdata('id');
   ?>
<style>
   .panel-heading {
   background: #5b6e84;
   font-size: 16px;
   font-weight: 300;
   color: white;
   }
   .btn-primary {
   margin-bottom: 3px;
   margin-top: 3px;
   }
   .btn-primary {
   background-color: #41cac0;
   border-color: #41cac0;
   color: #FFFFFF;
   }
</style>
<section id="main-content">
   <section class="wrapper site-min-height">
      <!-- page start-->
      <div class="row">
         <div class="col-lg-12">
            <section class="panel">
               <header class="panel-heading">
                  Sell History
               </header>
               <div class="panel-body">
                  <div class="adv-table">
                     <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <div class="panel-body" style="float: right">
                        </div>
                        <table class="display table table-bordered table-striped dataTable" id="example_sales"
                           aria-describedby="example_info">
                           <thead>
                              <tr role="row">
                                 <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Sold By</th>
                                 <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Customer</th>
                                 <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Sub-Total</th>
                                 <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Discount(%)</th>
                                 <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Discount Price</th>
                                 <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Total</th>
                                 <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Payment Type</th>
                                 <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Date</th>
                                 <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Action</th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
<?php foreach ($order_row as $order){ ?>
    <?php
        $order_id = $order->id;                         
        $order_query1 = $this->db->query("SELECT od.calculation_price AS price, od.discount AS discount, od.quantity, od.dt_updated, p.name, pw.discount_price AS final_price FROM order_details as od LEFT JOIN product as p ON p.id = od.product_id LEFT JOIN product_weight as pw ON pw.id = od.product_weight_id WHERE od.order_id = '".$order_id."'  AND od.status != '9'");
        
        $order_row1 = $order_query1->result();
                                 
    $order_query_ = $this->db->query("SELECT o.order_no AS order_no, o.id ,o.sub_total AS subtotal, o.order_discount AS discount_per, o.order_discount, o.total AS total, c.id AS customer_id, c.email as customer_email, c.customer_name, c.customercode, u.name as user_name, u.name AS store_name, u.phone_no phone,c.street1,c.city,c.country,c.state FROM `order` as o
        LEFT JOIN customer as c ON c.id = o.user_id
        LEFT JOIN branch as u ON u.id = o.branch_id
        WHERE o.id = '".$order_id."' AND o.branch_id = '".$branch_id."' AND o.status != '9'");
    $order_row_ = $order_query_->result();
 // echo $this->db->last_query();die;
 // print_r($order_row_);
                                                                         ?>
                              <script type="text/javascript">
                                 function printDiv(divName) {
                                     var printContents = document.getElementById(divName).innerHTML;
                                     var originalContents = document.body.innerHTML;
                                     document.body.innerHTML = printContents;
                                     window.print();
                                     document.body.innerHTML = originalContents;
                                 }
                              </script>
                              <div id="printableArea<?php echo $order_id; ?>" style="display:none;">
                                 <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="container border">
                                       <div class="col-md-12 col-sm-12 col-xs-12">
                                          <div class="col-md-4 col-sm-4 col-xs-4">
                                             <p class="pull-left p_font_size"><?php echo $order_row_['store_name']; ?></p>
                                          </div>
                                          <div class="col-md-8 col-sm-8 col-xs-8">
                                             <div class="pull-right">
                                                <p class="text-right p_font_size">Org.nr.:556471-4474</p>
                                                <p class="text-right p_font_size">Tel.nr.:<?php echo $order_row_['phone']; ?></p>
                                                <p class="text-right p_font_size">ECC Elgiganten</p>
                                                <p class="text-right p_font_size">Unik ID: <?php echo $order_row_['id']; ?></p>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-12 col-sm-12 col-xs-12">
                                          <div class="col-md-4 col-sm-4 col-xs-4">
                                             <div class="pull-left">
                                                <p class="p_font_size"><?php echo @$order_row_['street1']; ?></p>
                                                <p class="p_font_size"><?php echo @$order_row_['city'].' ,'.@$order_row_['state'].' ,'.@$order_row_['country']; ?></p>
                                             </div>
                                          </div>
                                          <div class="col-md-8 col-sm-8 col-xs-8">
                                             <div class="pull-right">
<p class="para"><?php echo ($order_row_['customer_name'] == '') ? 'Guest' : $order_row_['customer_name']; ?></p>
                                                <p class="p_font_size">Ordernr: <?php echo $order_row_['order_no']; ?></p>
                                                <p class="p_font_size">Saljare.: <?php echo $order_row_['user_name']; ?></p>
                                                <p class="p_font_size">Telephone: <?php echo $order_row_['phone']; ?></p>
                                             </div>
                                          </div>
                                          <div class="col-md-12">
                                             <p class="p_font_size">Kundnr.:<?php echo ($order_row_['customer_id'] == '')?'CID01':$order_row_['customer_id'];;  ?></p>
                                             <p class="p_font_size">Org.nr.:<?php echo ($order_row_['customercode'] == '')?'CC12345':$order_row_['customercode']; ?></p>
                                             <p class="p_font_size">Mail.:<?php echo ($order_row_['customer_email'] == '')?'pos-guest@gmail.com':$order_row_['customer_email']; ?></p>
                                          </div>
                                       </div>
                                       <div class="col-md-12 col-sm-12 col-xs-12 print margin_top_ul div_width">
                                          <?php foreach ($order_row1 as $detail){ ?>
                                          <div class="col-md-3 col-sm-3 col-xs-3 padding_zero ">
                                             <p class="border_p p_font_size div_p"><?php echo $detail->name; ?></p>
                                          </div>
                                          <div class="col-md-3 col-sm-3 col-xs-3 padding_zero">
                                             <p class="border_p p_font_size div_p"><?php echo $detail->quantity; ?></p>
                                          </div>
                                          <div class="col-md-3 col-sm-3 col-xs-3 padding_zero">
                                             <p class="border_p p_font_size div_p"><?php echo $detail->discount; ?></p>
                                          </div>
                                          <div class="col-md-3 col-sm-3 col-xs-3 padding_zero">
                                             <p class="border_p p_font_size div_p"><?php echo $detail->price; ?></p>
                                          </div>
                                          <?php } ?>
                                          <div class="col-md-3 col-sm-3 col-xs-3 padding_zero">
                                             <p class="p_font_size"></p>
                                             <p class="p_font_size"></p>
                                          </div>
                                          <div class="col-md-3 col-sm-3 col-xs-3 padding_zero">
                                             <p class="p_font_size">Transfer to page 2</p>
                                             <p class="p_font_size">Discount</p>
                                             <p class="p_font_size">sum excluding VAt</p>
                                             <p class="p_font_size">Vat</p>
                                             <p class="p_font_size">Total</p>
                                             <p class="p_font_size" style="margin-top:35px;">10% moms</p>
                                          </div>
                                          <div class="col-md-3 col-sm-3 col-xs-3 padding_zero">
                                             <p class="text-right p_font_size" style=" margin-top: 130px;"><?php echo @$order_row_['default_currency']; ?></p>
                                             <p class="text-center p_font_size">Netto</p>
                                             <p class="text-center p_font_size"><?php echo number_format($sub_vat,2,'.',''); ?></p>
                                          </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 padding_zero">
<p class="text-right p_font_size"><?php echo $order_row_['subtotal']; ?></p>
<p class="text-right p_font_size"><?php echo '-'.number_format($discount_price,2,'.',''); ?></p>
                                             
<p class="text-right p_font_size"><?php echo number_format($sub_vat,2,'.',''); ?></p>

<p class="text-right p_font_size"><?php echo number_format($vat,2,'.',''); ?></p>
                                             
<p class="text-right p_font_size"><?php $total =  $vat + $sub_vat;  echo number_format($total,2,'.',''); ?></p>
                                             
<p class="text-center p_font_size">Moms</p>
<p class="text-center p_font_size"><?php echo number_format($vat,2,'.',''); ?></p>
                                          </div>
                                       </div>
                                       <div class="col-md-12 col-sm-12 col-xs-12">
<p class="p1_font_size">Elgiganten goods will remain the properly untill full payment is made</p>

<p class="p1_font_size">Customer name: <?php echo $order_row_['customer_name']; ?></p>

<p class="p1_font_size">Deposite is anticipated to Elgiganten AB under the account belo Bank account: 310-6887 Firewood deposite from abroad: IBAN: SE42919000000091953639099 and SWIFT BIC: DNBASESX Momsregnr / VAT no: SE 556471447401 Apporved for tax</p>

<p class="p1_font_size">For Privatpersoner galler foljand:Vid hemleverans eller uthamtning av produkt(er) skall full betalning vara bokford minst 2 dagar innan avtalat leveransdatum.</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <tr class="gradeX odd">
                                 <td class=""><?php  echo $order->vendor_name; ?></td>
                                 <td class=""><?php echo $order->customer_name; ?></td>
                                 <td class=""><?php echo $order->sub_total; ?></td>
                                 <td class=""><?php echo @$order->order_discount; ?></td>
                                 <td class=""><?php echo @($order->sub_total- $order->payable_amount);?></td>
                                 <td class=""><?php echo $order->payable_amount; ?></td>
                                 <td class=""><?php if($order->payment_type == '0'){ echo 'Cash'; } elseif($order->payment_type == '1'){ echo 'Credit Card'; } elseif($order->payment_type == '2'){ echo 'Parked'; }; ?></td>
                                 <td class=""><?php echo date('Y-m-d H:i:s', $order->dt_updated); ?></td>
                                 <td class="">
                                    <a href="javascript:;" onclick="single_delete(<?php echo $order->id; ?>)" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                                    <a href="<?php echo base_url().'index.php/parked_sell/sales_history_view?order_id='.base64_encode($order->id); ?>" class="btn btn-primary btn-xs">view</a>
                                    <?php if($order->payment_type == '2'){ ?>
                                    <a href="<?php echo base_url().'index.php/parked_sell/index?parkedId='.base64_encode($order->id); ?>" class="label label-primary"><i class="fa fa-check-square "></i></a>
                                    <?php } ?>
                                    <a href="" onclick="printDiv('printableArea'+<?php echo $order_id; ?>)" class="btn btn-success btn-xs">Print Receipt</a>
                                 </td>
                              </tr>
                              <?php } ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </section>
         </div>
      </div>
      <!-- page end-->
   </section>
</section>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
   setTimeout( function(){$('#msg').hide();} , 4000);
   
   $(document).ready(function() {
       oTable = $('#example_sales').dataTable({
           "aaSorting": [[8,'desc']],
           "oLanguage": {
               "sEmptyTable" : "Sell History Not Available",
               "sZeroRecords": "Sell History Not Available",
        }
       });
   });
   
   /*Single Delete Script*/
   function single_delete(value) {
   
       bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
           if (confirmed == true) {
   
               var id = value;
   
               $.ajax({
                   url: '<?php echo base_url().'index.php/sell/single_delete_sell_sales_history/'; ?>' ,
                   data: {
                       ids: id.toString(),
                   },
                   success: function (data) {
   
   
   
                       if (data.status == 1) {
                           bootbox.alert("Sales history has been deleted successfully.", function() {
                               window.location.reload(true);
                           });
                       }
                       else {
                           alert('Failed to delete selected sales history.');
                       }
                   },
                   error: function () {
                       alert('Failed to delete selected sales history.');
                   }
               });
           }
           else
           {
               window.location.reload(true);
           }
       });
   }
</script>
<?php include('footer.php'); ?>