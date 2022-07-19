<?php error_reporting(0);?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <link rel="stylesheet" href="<?php echo base_url().'public/invoice_css/style.css'; ?>" media="all" />
    <link rel="stylesheet" href="<?php echo base_url().'public/invoice_css/bootstrap.css'; ?>" media="all" />
    <style type="text/css">
    @media print {
      .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6,
      .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
           float: left;               
      }

      .col-sm-12 {
           width: 100%;
      }

      .col-sm-11 {
           width: 91.66666666666666%;
      }

      .col-sm-10 {
           width: 83.33333333333334%;
      }

      .col-sm-9 {
            width: 75%;
      }

      .col-sm-8 {
            width: 66.66666666666666%;
      }

       .col-sm-7 {
            width: 58.333333333333336%;
       }

       .col-sm-6 {
            width: 50%;
       }

       .col-sm-5 {
            width: 41.66666666666667%;
       }

       .col-sm-4 {
            width: 33.33333333333333%;
       }

       .col-sm-3 {
            width: 25%;
       }

       .col-sm-2 {
              width: 16.666666666666664%;
       }

       .col-sm-1 {
              width: 8.333333333333332%;
        }  
      .btn {
        display: none;
      }          
}
</style>
  </head>
  <body>
    <div class="container">
      <header class="clearfix">
        <div id="logo">
          <img src="<?=$this->siteLogo?>">
        </div>
         <div class="invoice float-right text-right">
            <h1><strong>Order Detail</strong></h1>
            <div class="date">Date of Invoice: <?php echo date('d-M-Y'); ?></div>
            <div class="date">

                 <?php if($order_detail->order_status=='1'){echo "New Order";} 
                      if($order_detail->order_status=='2'){echo "Ready";} 
                      if($order_detail->order_status=='3'){echo "Delivered";} 
                      ?> 


            </div>
         
          </div>
      </header>

      <main>
        <div class="row">
          <div class="col-sm-6">
              <div id="client">

                <div class="row">
                  <div class="col-sm-6"><b >Name : </b> </div>
                  <div class="col-sm-6"><span><?=($user_detail->name != '') ? $user_detail->name : $user->fname ?></span></div>
                </div>

                <div class="row">
                  <div class="col-sm-6"><b >Shipping Address : </b> </div>
                   <div class="col-sm-6"><span><?=($user_detail->address != '') ? $user_detail->address : "Self Pickup"  ;?></span></div>
                </div>

                <div class="row">
                  <div class="col-sm-6"><b >Mobile Number : </b> </div>
                  <div class="col-sm-6"><span><?=($user_detail->phone != '' ) ? $user_detail->phone : $user->phone ?></span></div>
                </div>

                <div class="row">
                  <div class="col-sm-6"><b >Order Number : </b> </div>
                  <div class="col-sm-6"><span><?php echo $order_detail->order_no; ?></span></div>
                </div>

                <div class="row">
                  <div class="col-sm-6"><b>Email : </b> </div>
                  <div class="col-sm-6 email"><span><a href="mailto:john@example.com"><?php echo $order_detail_result[0]->email; ?></a></span></div>
                </div>

                <div class="row">
                  <div class="col-sm-6"><b >Date : </b> </div>
                  <div class="col-sm-6"><span><?php echo date('d-M-Y', $order_detail_result[0]->dt_added); ?></span></div>
                </div>
               <div class="row">
                  <div class="col-sm-6"><b >Delivery Date : </b> </div>
                  <div class="col-sm-6"><span><?php echo  date('l d-M-Y',strtotime($order_detail_result[0]->delivery_date));
                  if($order_detail_result[0]->start_time!=''){
                    echo ' Between ('.$order_detail_result[0]->start_time.' - '.$order_detail_result[0]->end_time.')';
                          }; ?></span></div>
                </div>
                <div class="row">
                  <div class="col-sm-6"><b>Gst Number : </b> </div>
                  <div class="col-sm-6 email"><span><?php echo $user->user_gst_number; ?></span></div>
                </div>
              </div>
          </div>
          <div class="col-sm-6">
              <div id="company">
                  <div><strong>Sold By : </strong></div>
                  <div><?php echo $vendor_detail->name; ?></div>
                  <div><?php $location = explode(',',$vendor_detail->location); echo $location[0];  ?><br/><?php  echo $location['1']; ?></div>
                  <div><?php echo $vendor_detail->phone_no; ?></div>
                  <div ><a href="mailto:<?php echo $vendor_detail->email; ?>"><?php echo $vendor_detail->email; ?></a></div>
              </div>
          </div>
        </div>

        <div class="table-responsive-sm mb-5">
          <table border="0" cellspacing="0" cellpadding="0">
            <thead>
              <tr>
                <th class="unit">PRODUCT NAME</th>
                <th class="desc">QUANTITY</th>
                <th class="qty">PRICE</th>
                <th class="qty">DISCOUNT</th>
                <th class="total">FINAL PRICE</th>
              </tr>
            </thead>
            <tbody>
            <?php

            foreach ($order_detail_result as $result){
         
            ?>
          <tr>
            <td class="service"><?php echo $result->product_name.' ('.$result->weight_no.' '.$result->weight_name.' '.$result->package.')'; ?></td>
            <td class="qty"><?php echo $result->quantity; ?></td>
            <td class="qty"><?php echo $getcurrency['value'].' '.round($result->actual_price); ?></td>
            <td class="qty"><?php $get = ($result->actual_price*$result->quantity)-$result->calculation_price; echo $getcurrency['value'].' '.$get; ?></td>
            <td class="total"><?php echo $getcurrency['value'].' '.$result->calculation_price; ?></td>
          </tr>
           <?php @$gtotal = $total+$gtotal; 
         }  ?>
              
             
            </tbody>
           <tfoot>
             <!--  <tr>
                <td colspan="3"></td>
                <td colspan="1"><strong>Sub Total</strong></td>
                <td><strong>$5,200.00</strong></td>
              </tr>
              <tr>
                <td colspan="3"></td>
                <td colspan="1"><strong>Tax 25%</strong></td>
                <td><strong>$1,300.00</strong></td>
              </tr> -->
               <tr>
                <td colspan="3"></td>
                <td colspan="1"><strong>Sub Total</strong></td>
                <td><strong><?=$getcurrency['value'].' '.$order_detail->sub_total;
            ?> </strong></td>
              </tr>
                 <tr>
                <td colspan="3"></td>
                <td colspan="1"><strong>Promocode Amount : <?=($order_detail->percentage!='')?$order_detail->percentage.' %':''; ?></strong></td>
                <td><strong><?php
              echo ($order_detail->promocodeAmount!='')?$getcurrency['value'].' '.$order_detail->promocodeAmount:$getcurrency['value'].''.'0';
            ?> </strong></td>
              </tr>

             

              <tr>
                <td colspan="3"></td>
                <td colspan="1"><strong>Total Tax Amount :</strong></td>
                <td><strong><?php
                echo $getcurrency['value'].' '.$total_gst;
                ?> </strong></td>
              </tr>
              <tr>
                <td colspan="3"></td>
                <td colspan="1"><strong>Delivery Charge</strong></td>
                <td><strong><?php
           echo $getcurrency['value'].' '.$order_detail->delivery_charge;
            ?> </strong></td>
              </tr>
           
              <tr>
                <td colspan="3"></td>
                <td colspan="1"><strong>Grand Total</strong></td>
                <td><strong><?php
            echo $getcurrency['value'].' '.$order_detail->payable_amount;
            ?> </strong></td>
              </tr>
            </tfoot>
          </table>
        </div>
        
        <div class="row">
          <div class="col-12">
            <div id="notices">
              <!-- <div>Action:</div> -->
              <div class="notice"> 
                <button class="btn btn-primary " onclick="window.print();"> Print </button>
                <button class="btn btn-danger " onclick="window.close();"> Close </button></div>
            </div>
          </div>
        </div>

      </main>
    </div>

  </body>
</html>