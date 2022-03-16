<!DOCTYPE html>
<html lang="en">
<?php
$vendor_id = $this->session->userdata['id'];
$vendor_id = $this->utility->decode($_GET['vendor_id']);


$order_id = $this->utility->decode($_GET['id']);
$order_detail_query = $this->db->query("SELECT od.*,u.id as user_id, u.fname,u.email, u.lname, w.name as weight_name, p.name as product_name FROM `order_details` as od 
LEFT JOIN user as u ON u.id = od.user_id
LEFT JOIN weight as w ON w.id = od.weight_id
LEFT JOIN product as p ON p.id = od.product_id
WHERE  od.status != '9' AND od.vendor_id = '$vendor_id' AND od.order_id = '$order_id' ORDER BY od.id DESC");
$order_detail_result = $order_detail_query->result();

$user_id =$order_detail_result[0]->user_id;
$user_detail = $this->db->query("SELECT ua.address,ua.city,ua.state,ua.country,ua.phone FROM user_address as ua WHERE ua.user_id= '$user_id'")->row();
$vendor_detail = $this->db->query("SELECT * FROM vendor  WHERE id= '$vendor_id'")->row();// error_reporting(1);
$order_detail = $this->db->query("SELECT `order_status` FROM `order`  WHERE id= '$order_id'")->row();// error_reporting(1);
?>


  <head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <link rel="stylesheet" href="<?php echo base_url().'public/css/invoice_style.css'; ?>" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="<?php echo base_url().'public/css/logo.png'; ?>">
      </div>
      <h1>INVOICE </h1>
      <div id="company" class="clearfix">
      	<div><b>SOLD BY :</b></div>
        <div><?php echo $vendor_detail->name; ?></div>

        <div><?php $location = explode(',',$vendor_detail->location); echo $location[0];  ?><br/><?php  echo $location['1']; ?>,</br><?php $location = array_reverse($location); echo $location[1]; ?>,</br><?php  echo $location[0]; ?></div>
        <div><?php echo $vendor_detail->phone_no; ?></div>
        <div><a href="mailto:<?php echo $vendor_detail->email; ?>"><?php echo $vendor_detail->email; ?></a></div>
      </div>
      <div id="project">
        <div><span >Name</span> <?php echo $order_detail_result[0]->fname.' '.$order_detail_result[0]->lname; ?></div>
        <div><span>Contact Number:</span>  <?php echo $user_detail->phone;   ?></div>
        <div><span>Shipping Address</span>  <?php echo $user_detail->address;   ?></div>
        <div><span></span>  <?php echo $user_detail->city;   ?></div>
        <div><span></span>  <?php echo $user_detail->state;   ?></div>
        <div><span></span>  <?php echo $user_detail->country;   ?></div>
        <div><span >Order Number</span><?php  echo md5($order_detail_result[0]->id);?>	</div>
        <!-- <div><span >INVOICE NUMBER</span>TG-5-45682</div> -->
        <div><span >Email</span> <a href="mailto:john@example.com"><?php echo $order_detail_result[0]->email; ?></a></div>
        <div><span >Date</span><?php echo date('M-d-Y', $order_detail_result[0]->dt_added); ?></div>
        <div><span >Order Status</span><?php if($order_detail->order_status=='1'){ echo "New Order"; }else if($order_detail->order_status=='2'){ echo "Ready"; }else{ echo "Delevered"; } ?></div>
       
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">PRODUCT NAME</th>
            <th class="desc">QUANTITY</th>
            <th>PRICE</th>
            <th>DISCOUNT</th>
            <th>FINAL PRICE</th>
          </tr>
        </thead>
        <tbody>
        <?php
         foreach ($order_detail_result as $result){
        $total= $result->calculation_price;

                    $weight_query = $this->db->query("SELECT weight_no FROM product_weight WHERE product_id = '$result->product_id' AND weight_id = '$result->weight_id'");
                    $weight_result = $weight_query->row_array();
            ?>
          <tr>
            <td class="service"><?php echo $result->product_name; ?></td>
            <td class="qty"><?php echo $result->quantity; ?></td>
            <td class="unit"><?php echo '₹ '.$result->actual_price ?></td>
            <td class="qty"><?php echo '₹ '.$result->discount_price; ?></td>
            <td class="total"><?php echo '₹ '.$result->calculation_price; ?></td>
          </tr>
           <?php
            $gtotal = $total+$gtotal;

            } ?>
         
          <tr>
            <td class="grand" colspan="4">GRAND TOTAL</td>
            <td class="grand total" style="text-align: center;"><?php
            echo '₹ '.$gtotal;
            ?> </td>
          </tr>
         <!--  <tr>
            <td class="grand" colspan="4">TAX 25%</td>
            <td class="grand total">$1,300.00</td>
          </tr> -->
         <!-- <tr>
            <td colspan="4" class="grand total" style="margin-left: 32px;">GRAND TOTAL</td>
            <td class="grand total" style="padding-left: 0;width: 15%;">$6,500.00</td>
          </tr> -->
        </tbody>
      </table>
     
    </main>
    <footer>
      <!-- Invoice was created on a computer and is valid without the signature and seal. -->
    </footer>
  </body>
</html>