<?php
if ($this->session->userdata('email') == FALSE) { redirect('admin/login'); }?>
<?php
include('header.php');
$userid = $this->session->userdata('id');
$vendor_id = $this->session->userdata['id'];
?>

<script src = "https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/none.js"></script>

<style type="text/css">
    .page-content{background: #c7c7c7;}
    #chartdiv {
        height: 500px;
        width: 100% !important;
        display: block !important;
        margin: 0 auto !important;
    }
    .footerdashboard {
        margin-top: 141px;
    }
    #chartdivs {
  width: 100%;
  height: 500px;
      background: #fff;
    border-radius: 3px;
}
.query-form{
  background: white;
  padding: 10px 25px;
}
.query-form h3{
  font-weight: bold;
  color: #2e2e2e;
}

.query-form p{
  font-size: 16px;
  color: black;
  margin-bottom: 21px;
}
.query-form .form-group{
  margin-bottom: 10px;
}
.query-form .form-group textarea{
  height: 100px !important;
}


.query-form input::placeholder{
  color: #000;
}
.query-form .form-group textarea::placeholder{
 color: #000; 
}

.query-form input[type="submit"] {
    width: 150px;
    height: 40px;
    background: #1185e1;
    color: white;
    font-size: 16px;
    text-transform: capitalize;
    border: 0px;
    margin-top: 25px;
    margin-bottom: 10px;
}

</style>

<!--main content start-->
<section id="main-content">

    <section class="wrapper">
        <div class="row state-overview">
            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol terques"><i class="fa fa-first-order"></i></div>
                    <a href="<?php echo base_url() . 'admin/user_list'; ?>">
                        <div class="value"><h1 class="dashboard_color"><?php echo $total_registered_user['total_registered_user']; ?></h1><p>Register user</p></div>
                    </a>
                </section>
            </div>
            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol red"><i class="fa fa-truck"></i></div>
                    <a href="<?php echo base_url() . 'order'; ?>">
                        <div class="value"><h1 class="dashboard_color"><?php echo $total_order_delt['total']; ?></h1><p>Total Order</p></div>
                    </a>
                </section>
            </div>
            <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol yellow"><i class="fa fa-flag"></i></div>
                    <a href="<?php echo base_url() . 'order'; ?>">
                        <div class="value"><h1 class="dashboard_color"><?php echo $total_delivered['total_delivered']; ?></h1><p>Total Delivered</p></div>
                    </a>
                </section>
            </div>
         <div class="col-lg-3 col-sm-6">
                <section class="panel">
                    <div class="symbol blue"><i class="fa fa-shield"></i></div>
                    <a href="javascript:">
                        <div class="value"><h1 class="dashboard_color"><?php echo number_format($total_sales['sales'],2,'.',''); ?></h1><p>Total sales</p></div>
                    </a>
                </section>
            </div> 
        </div>
        <div class="row" >
        <!-- 	<div class="col-md-6" style="display: none">
            
        	 <h2 class="chart_title"><span class="time-unit"></span> Orders</h2>
          
  			  <section id="chart"></section>
  			  <div class="button-field">
  			    <button value="24">Daily</button>
  			    <button value="7">Weekly</button>
  			    <button value="30">Monthly</button>
  			    <button value="12">Yearly</button>
  			  </div>
	    </div> -->
      
        <div class="col-md-6">
            <!-- <h2 class="chart_title hidden-text">dsadsadsds</h2> -->
            <div class="row state-overview box-group-area">
              <div class="col-md-6">  
                <div class="box-small-area">
                    
                <section class="panel">
                    <div class="symbol terques1"><!-- <i class="fa fa-first-order"></i> -->
                        <img src="<?=base_url()?>public/images/box.png" alt="images">
                    </div>
                    <a href="#">
                        <div class="value"><h1 class="dashboard_color"><?php echo $total_pending_order['total']?></h1><p>pending orders</p></div>
                    </a>
                </section>
                </div>
              </div>
              <div class="col-md-6">  
                <div class="box-small-area">
                    
                <section class="panel">
                    <div class="symbol terques2"><!-- <i class="fa fa-first-order"></i> -->
                        <img src="<?=base_url()?>public/images/dollar.png" alt="images">
                    </div>
                    <a href="#">
                        <div class="value"><h1 class="dashboard_color"><?php echo  number_format($total_pending_payment['pending_payment'],2, '. ', '') ?></h1><p>pending payment</p></div>
                    </a>
                </section>
                </div>
              </div>
            </div>
            <div class="row state-overview box-group-area">
              <div class="col-md-6">  
                <div class="box-small-area">
                    
                <section class="panel">
                    <div class="symbol terques3"><!-- <i class="fa fa-first-order"></i> -->
                        <img src="<?=base_url()?>public/images/box.png" alt="images">
                    </div>
                    <a href="#">
                        <div class="value"><h1 class="dashboard_color"><?php echo $total_return_order['total'];?></h1><p>Cancel orders</p></div>
                    </a>
                </section>
                </div>
              </div>
              <div class="col-md-6">  
                <div class="box-small-area">
                    
                <section class="panel">
                    <div class="symbol terques4"><!-- <i class="fa fa-first-order"></i> -->
                        <img src="<?=base_url()?>public/images/dollar.png" alt="images">
                    </div>
                    <a href="#">
                        <div class="value"><h1 class="dashboard_color"><?php if(isset($total_return_payment['return_payment']) && $total_return_payment['return_payment'] > 0){ echo number_format((float)$total_return_payment['return_payment'],2,'.','') ;}else{ echo 0;}?></h1><p>return payment</p></div>
                    </a>
                </section>
                </div>
              </div>
            </div>
        </div>

        <div class="col-md-6">
        <form id="queryForm" method="post" action="<?=base_url().'admin/QueryMesageToSuperAdmin'?>" class="query-form">
          <h3 style="">Contact Us</h3>
          <p>If you have any kind of query , Please leave your message here</p>
          <div class="form-group">
            <input type="text" name="subject" placeholder="Enter Subject" class="form-control" required="">
          </div>
          <div class="form-group">
            <textarea placeholder="Enter Your Message" name="message" class="form-control" required=""></textarea>
          </div>
          <input type="submit" name="submit" id="btnSubmit" class="sub-btn" value="Send">
        </form>
      </div>
	</div>
        <!--state overview end-->

     <div class="row" style="display: none">
     	 <div class="col-md-12">
            <h2 class="chart_title monthly-sales"><span class="time-unit">Monthly Sales</span></h2>  
     	 	 <div id="chartdivs"></div>
     	 </div>
     </div>
     <div class="row">
          <div class="col-md-12">
               <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Order Status Today</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Name </th>
                            <th> Order id </th>
                            <th> Payment type </th>
                            <th> Order status </th>
                          </tr>
                        </thead>
                        <tbody>
                             <?php
                              foreach ($daily_order_Status as $result){
                                $user_id = $result->user_id;
$daily_order_Status_user_name_query = $this->db->query("SELECT CONCAT(fname,lname) as name FROM user WHERE id = '$user_id'");
$daily_order_Status_user_name = $daily_order_Status_user_name_query->result();
                             // echo $this->db->last_query();die;
                             ?>
                          <tr>
                            <td><?php echo $daily_order_Status_user_name[0]->name; ?></td>
                            <td><?php echo $result->order_no;?> </td>
                            <td><?php if($result->order_Status == 0) {echo "Cash On Delivery";}else{ echo "Credit"; }?></td>
                            <td>

                              <?php 
                              if($result->order_status == '1'){
                                echo "<label class='badge badge-gradient-info'>New</label>";
                              }elseif($result->order_status == '2'){
                                echo "<label class='badge badge-gradient-warning'>pending</label>";
                              }elseif($result->order_status == '3'){
                                echo "<label class='badge badge-gradient-primary'>Ready</label>";
                              }elseif($result->order_status == '4'){ echo "<label class='badge badge-gradient-default'>Pickup</label>";
                              }elseif($result->order_status == '8'){
                                echo "<label class='badge badge-gradient-success'>Delivered</label>";
                              }
                              elseif($result->order_status == '9'){
                                echo "<label class='badge badge-gradient-danger'>Cancel</label>";
                              }
                                  
                                  ?>

                             </td>
                             </tr>
                              <?php
                            }
                              ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
          </div>
     </div>
    </section>
</section>
<!--main content end-->
<div class="footerdashboard">
    <?php include('footer.php'); ?>
</div>

<script>
        var chart = AmCharts.makeChart("chartdiv", {
            "hideCredits": true,
            "type": "serial",
            "theme": "none",
            "marginRight": 70,
            "dataProvider": <?php echo $grap; ?>,
            "startDuration": 1,
            "graphs": [{
                    "balloonText": "<b>[[category]]: [[value]]</b>",
                    "fillColorsField": "color",
                    "fillAlphas": 0.9,
                    "lineAlpha": 0.2,
                    "type": "column",
                    "valueField": "value"
                }],
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": true
            },
            "categoryField": "name",
            "categoryAxis": {
                "gridPosition": "start",
                "labelRotation": 0
            },
            "export": {
                "enabled": true
            }

        });
    </script>      