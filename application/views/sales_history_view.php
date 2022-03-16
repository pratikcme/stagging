<?php
include('header.php');
 $parked_order_id = base64_decode($_GET['order_id']);
@$type = $_GET['type'];
$vendor_id = $this->session->userdata('id');

if($type == 'park'){

    $order_query = $this->db->query("SELECT pod.price as calculation_price, pod.discount, pod.quantity, pod.dt_updated, p.name FROM parked_order_details as pod 
                                  LEFT JOIN product as p ON p.id = pod.product_id WHERE pod.parked_order_id = '$parked_order_id'  AND pod.status != '9'");

    $order_row = $order_query->result();

    $order_query_ = $this->db->query("SELECT total, order_discount, payable_amount FROM `parked_order` WHERE id = '$parked_order_id' AND vendor_id = $vendor_id AND status != '9'");
    $order_row_ = $order_query_->row_array();

}else{

    $order_query = $this->db->query("SELECT pod.calculation_price,pod.discount, pod.quantity, pod.dt_updated, p.name FROM order_details as pod 
                                  LEFT JOIN product as p ON p.id = pod.product_id WHERE pod.order_id = '$parked_order_id'  AND pod.status != '9'");

    $order_row = $order_query->result();

    $order_query_ = $this->db->query("SELECT total,payment_type,order_discount, payable_amount FROM `order` WHERE id = '$parked_order_id' AND vendor_id = $vendor_id AND status != '9'");
    $order_row_ = $order_query_->row_array();

    
}
?>
<style>
    .my_total_amount {
        float: right;
        width: 20%;
    }
    .adv-table .dataTables_filter label input {

        height: auto !important;
    }
    .panel-heading {
        background: #5b6e84;
        font-size: 16px;
        font-weight: 300;
        color: white;
    }
    .no_padd {
        padding: 0;
    }
    .order_data_view {
        float: left;
        width: 100%;
        margin-top: 40px;
    }
    .text-right {
        text-align: right;
    }
    .data_display_list {
        float: right;
        width: 100%;
        border-bottom: 1px solid #ccc;
        padding: 10px 0;
    }
    *, *:before, *:after {
        box-sizing: inherit;
    }
    .data_display_list p {
        margin: 0;
    }
    .data_display_list span {
        float: left;
        font-weight: bold;
        width: 65%;
        text-align: left;
    }
    .btn-danger {
        background-color: #2a3542;
        border-color: #2a3542;
        color: #FFFFFF;
    }
    .btn-danger:hover {
        background-color: #2a3542;
        border-color: #2a3542;
        color: #FFFFFF;
    }

</style>
    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <div class="row" style="">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Order Summary
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">


                                    <table class="display table table-bordered table-striped dataTable" id="example_order_summary"
                                           aria-describedby="example_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 200px;">Product Name</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 200px;">Quantity</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 200px;">Discount(%)</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 200px;">Price($)</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 200px;">Date</th>
                                        </tr>
                                        </thead>
                                        <tbody role="alert" aria-live="polite" aria-relevant="all">

                                        <?php

                                        foreach ($order_row as $order){
//                                            print_r($order);exit;

                                            ?>

                                            <tr class="gradeX odd">
                                                <td class=""><?php echo $order->name; ?></td>
                                                <td class=""><?php echo $order->quantity; ?></td>
                                                <td class=""><?php echo $order->discount.' %'; ?></td>
                                                <td class=""><?php echo $order->calculation_price; ?></td>
                                                <td class=""><?php echo date('Y-m-d H:i:s', $order->dt_updated); ?></td>
                                            </tr>

                                        <?php } ?>

                                        </tbody>
                                    </table>

                                    <div class="panel-body no_padd">

                                        <!--Order Data-->
                                        <div class="order_data_view col-md-3 col-lg-3 col-sm-3 col-xs-3 text-right no_padd">
                                            <div class="my_total_amount">
                                                <div class="data_display_list">
                                                    <span> Subtotal = </span><p><b> <?php echo $order_row_['total']; ?></b></p>
                                                </div>

                                                <div class="data_display_list">
                                                    <span> Discount(%)  = </span><p><?php echo $order_row_['order_discount']; ?></p>
                                                </div>

                                                <div class="data_display_list">
                                                    <span> Discount Price  = </span><p><?php echo ($order_row_['total']-$order_row_['payable_amount']); ?></p>
                                                </div>

                                                <div class="data_display_list">
                                                    <span> Total  = </span><p><b><?php echo $order_row_['payable_amount']; ?></b></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pull-right" style="margin-top: 10px;">
                                    <?php if(@$order_row_['payment_type'] == '2'){ ?>
                                        <a href="<?php echo base_url().'index.php/parked_sell/index?parkedId='.base64_encode($parked_order_id); ?>" class="btn btn-danger" type="button" id="close_register">Back To Sell</a>
                                        <a href="<?php echo base_url().'index.php/sell/parked_sell_list/'; ?>" class="btn btn-danger" type="button" id="close_register">Back</a>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url().'index.php/sell/history/'; ?>" class="btn btn-danger" type="button" id="close_register">Back</a>
                                    <?php } ?>

                                </div>
                                
                            </div>
                        </div>

                    </section>
                </div>
            </div>
            <!-- page end-->
        </section>
    </section>
<?php include('footer.php'); ?>