<?php
include('header.php');
error_reporting(0);
$id = $this->utility->decode($_GET['id']);
// echo $id;exit;


$query_currency = $this->db->query("SELECT value FROM set_default WHERE request_id = '3' ");
$getcurrency = $query_currency->row_array();

// $vendor_id = $this->session->userdata['id'];
if($id != ''){
    $query = $this->db->query("SELECT * FROM vendor WHERE id = '$id' ");
    $result = $query->row_array();

    $store_name = $result['name'];
    $owner_name = $result['owner_name'];


    $subscription_query = $this->db->query("SELECT  * FROM `subscription` 
                                        WHERE vendor_id = '$id' ORDER BY id DESC");
    $subscription_result = $subscription_query->result();
//       print_r($order_result);exit;


//       $profit_query_take = $this->db->query("SELECT sum(profit) as profit FROM `profit_taken` where order_id = '$order_id' AND vendor_id = '$id' ORDER BY id DESC ");
//       $profit_take_result = $profit_query_take->row_array();
// echo $this->db->last_query();exit;

}else{
    header("Location:vendor_accounting");
}
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
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home /</a><a href="<?php echo base_url().'subscription/subscription_list'; ?>"> Vendor Subscription </a> / Detail</a> </li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header  class="panel-heading" style="margin-left: 20%">
                        <?='Owner Name : '. $owner_name."  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Shop Name : ".$store_name;?>
                    </header>


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
                        Subscription Details
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
                                            style="width: 200px;">Start Date
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">End date
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Month
                                        </th>

                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Amount
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Payment Date
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <?php
                                    foreach ($subscription_result  as $result){

                                        ?>
                                        <tr class="gradeX odd">


<!--                                            <td class="hidden-phone">--><?php //echo $result->fname.' '.$result->lname; ?><!--</td>-->
<!--                                            <td class="hidden-phone"><a target="_blank" href="--><?php //echo base_url() . 'order/order_detail?id=' .$this->utility->encode($result->id).'&vendor_id='.$this->utility->encode($id); ?><!--">-->
<!--                                                    --><?php //echo $result->order_no; ?><!-- </a></td>-->
                                            <td class="qty"><?php echo $result->start_date; ?></td>
                                            <!--								            <td class="unit">--><?php //echo $getcurrency['value'].' '.$result->actual_price ?><!--</td>-->
                                            <!--								            <td class="qty">--><?php //echo $getcurrency['value'].' '.$result->discount_price; ?><!--</td>-->
                                            <td class="hidden-phone"><?php echo $result->end_date; ?></td>
                                            <td class="total"><?php echo $result->month; ?></td>
                                            <td class="hidden-phone"><?php echo $getcurrency['value'].' '.$result->total_ammount; ?></td>
                                            <td class="total"><?php echo $result->dt_created; ?></td>

                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-5 col-md-1">
                                <a href="<?php echo base_url().'subscription/subscription_list'; ?>"> <button class="btn btn-primary">Back</button></a>
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
</body>

<?php include('footer.php'); ?>
<script type="text/javascript">
    $('#example1').dataTable();
</script>