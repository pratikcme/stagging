<?php
include('header.php');
?>
<?php
$vendor_id = $this->session->userdata('id');


$year = date('Y');

//$date = DATE_FORMAT(FROM_UNIXTIME(1553067739), '%m-%d-%Y');
//echo 1;
//echo $date;exit;


//Yearwise Total Income of Particular Product code starts here
if (isset($_POST['select_year_product'])) {
    $select_year_product = $_POST['select_year_product'];
    @$type = $_POST['type'];

    if ($type == 9 || !isset($type)) {
        $where = "1=1";
    } elseif ($type == 0) {
        $where = "o.order_from ='0'";
    } else {
        $where = "o.order_from ='1'";
    }


    $res_yearwise = $this->db->query("SELECT p.weight_no,w.name as variant , pro.name,p.*,od.*,sum(od.calculation_price) as product_price 
                                        FROM product_weight as p 
                                        INNER JOIN weight as w ON w.id = p.weight_id 
                                        INNER JOIN product as pro ON pro.id = p.product_id 
                                        INNER JOIN order_details as od ON od.product_weight_id = p.id 
                                        INNER JOIN `order`   as o ON o.id = od.order_id
                                        where YEAR(FROM_UNIXTIME(od.dt_added)) = '$select_year_product' AND  p.vendor_id = '$vendor_id' AND $where GROUP BY p.id");

    $row_yearwise = $res_yearwise->result();
    // print_r($row_yearwise);
    // echo $this->db->last_query();exit;
    $res_remaining_quantity = $this->db->query("SELECT p.weight_no,w.name as variant,pro.name,p.*,od.*,sum(od.calculation_price) as product_price,p.quantity as product_quantity 
                                                FROM product_weight as p  
                                                 INNER JOIN weight as w ON w.id = p.weight_id 
                                                INNER JOIN product as pro ON pro.id = p.product_id  
                                                INNER JOIN order_details as od ON od.product_weight_id = p.id 
                                                where YEAR(FROM_UNIXTIME(od.dt_added)) = '$select_year_product' AND  p.vendor_id = '$vendor_id' GROUP BY p.id");
    $row_remaining_quantity = $res_remaining_quantity->result();
} else {
    $year = date('Y');
    $res_yearwise = $this->db->query("SELECT pro.name,p.*,od.*,sum(od.calculation_price) as product_price       
                                        FROM product_weight as p 
                                        INNER JOIN product as pro ON pro.id = p.product_id 
                                    INNER JOIN order_details as od ON od.product_weight_id = p.id where YEAR(FROM_UNIXTIME(od.dt_added)) = '$year' AND  p.vendor_id = '$vendor_id' GROUP BY p.id");
    $row_yearwise = $res_yearwise->result();

    $res_remaining_quantity = $this->db->query("SELECT pro.name,p.*,od.*,sum(od.calculation_price) as product_price,p.quantity as product_quantity FROM product_weight as p  INNER JOIN product as pro ON pro.id = p.product_id  INNER JOIN order_details as od ON od.product_weight_id = p.id where YEAR(FROM_UNIXTIME(od.dt_added)) = '$year' AND  p.vendor_id = '$vendor_id' GROUP BY p.id");
    $row_remaining_quantity = $res_remaining_quantity->result();

}


//Yearwise Total Income of Particular Product code ends here

?>
    <link rel="stylesheet" type="text/css"
          href="http://cmexpertiseinfotech.in/pos_user/public/css/bootstrap-datepicker.min.css"/>
    <link href="<?php echo base_url(); ?>/public/assets/morris.js-0.4.3/morris.css" rel="stylesheet"/>
    <style>

        .mrgn_btm_20 {
            margin-bottom: 20px;
        }

        button.btn.btn-success.btn_date {
            margin-top: 22px;
        }

        .btn_two_date {
            margin-top: 22px;
        }

        .panel-heading {
            background: #5b6e84;
            font-size: 16px;
            font-weight: 300;
            color: white;
        }

        .padd_10 {
            padding: 10px;
        }

        .btn-success {
            background-color: #2a3542;
            border-color: #2a3542;
            color: #FFFFFF;
        }

        .btn-success:hover {
            background-color: #2a3542;
            border-color: #2a3542;
            color: #FFFFFF;
        }

    </style>
    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <center>
                <header class="panel-heading mrgn_btm_20">
                    <h3> Note : Orderwise top 50 Products will be Displayed <h3>
                </header>
            </center>
            <div id="morris">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading panel-heading1">
                                Yearwise Total Income of Particular Product
                                <span style="float: right">
                                    <label id="select_year_cash"> Year:
                                        <?php if (!(isset($_POST['select_year_product']))) {
                                            echo $year;
                                        } else {
                                            echo $select_year_product;
                                        } ?>
                                    </label>
                                  </span>
                            </header>
                            <div class="customer padd_10">
                                <form method="post" action="" id="select_year_dropdown">
                                    <div class="rows">
                                        <div class="form-group">
                                            <label for="name">Select Order Type</label>
                                            <div class="rows">
                                                <input type="radio" class="type" name="type" <?php if(isset($type) && $type == 9){echo "checked";} ?> value="9">Both
                                                <input type="radio" class="type" name="type" <?php if(isset($type) && $type == 1){echo "checked";} ?> value="1">Grocery
                                                <input type="radio" class="type" name="type" <?php if(isset($type) && $type == 0){echo "checked";} ?> value="0">POS
                                            </div>
                                        </div>
                                        <label for="name">Select Year</label>
                                        <select class="form-control select_year_product" name="select_year_product"
                                                required="">
                                            <option value="0" selected="" disabled="">-----Select Year -----</option>
                                            <?php

                                            $j = $year - 10;

                                            for ($i = $year; $i >= $j; $i--) {
                                                ?>
                                                <option <?php if (isset($_POST['select_year_product'])) {
                                                    if ($i == $select_year_product) {
                                                        echo "selected";
                                                    }
                                                } ?> value="<?php echo $i; ?>"><?php echo $i; ?> </option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </form>

                                <!--                              <form method="post" action="" id="select_year_dropdown">-->
                                <!--		                      	  		<div class="form-group">-->
                                <!--		                        					<label for="name">Select Year</label>-->
                                <!--		                        					<select class="form-control select_year_product" name="select_year_product" required="">-->
                                <!--					                            				<option value="" selected="" disabled="">-----Select Year -----</option>-->
                                <!--					                                            <option value="2016"> 2016 </option>-->
                                <!--					                                            <option value="2017"> 2017 </option>-->
                                <!--					                                            <option value="2018"> 2018 </option>-->
                                <!--					                                            <option value="2019"> 2019 </option>-->
                                <!--					                                            <option value="2020"> 2020 </option>-->
                                <!--					                                            <option value="2021"> 2021 </option>-->
                                <!--					                                            <option value="2022"> 2022 </option>-->
                                <!--					                                            <option value="2023"> 2023 </option>-->
                                <!--					                                            <option value="2024"> 2024 </option>-->
                                <!--					                                            <option value="2025"> 2025 </option>-->
                                <!--					                                            <option value="2026"> 2026 </option>-->
                                <!--					                                            <option value="2027"> 2027 </option>-->
                                <!---->
                                <!--		                                            </select>-->
                                <!--		                    			   </div>-->
                                <!--                              </form>-->
                            </div>
                            <div class="panel-body">
                                <div id="hero-bar" class="graph"></div>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Productwise Remaining Quantity
                            </header>
                            <div class="customer">
                            </div>
                            <div class="panel-body">
                                <div id="hero-bar1" class="graph"></div>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                Check your Sales (Filter)
                            </header>
                            <div class="panel-body sell_repot_padd">
                                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12 padd_lft_0">
                                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 padd_lft_0">
                                        <div class="form-group">
                                            <div class="rows">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Select Order Type</label>
                                                        <div class="rows">
                                                            <input type="radio" class="type1"  name="types" value="9">Both
                                                            <input type="radio" class="type1"  name="types" value="1">Grocery
                                                            <input type="radio" class="type1"  name="types" value="0">POS
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="panel terques-chart">

                                                        <div class="chart-tittle">
                                                            <span class="title">Total Earning</span>
                                                            <span class="value total_earning">

                                                        </span>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <label for="name">Select Year</label>
                                            <select class="form-control select_year" name="" required="">
                                                <option value="0" selected="" disabled="">Select Year</option>
                                                <?php

                                                $j = $year - 10;

                                                for ($i = $year; $i >= $j; $i--) {
                                                    ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?> </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 padd_rght_0">
                                      <button class="btn btn-success"> Calculate </button>
                                    </div> -->
                                    <div class="frm_dats">
                                        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 padd_lft_0">
                                            <div class="form-group">
                                                <label class="">From Date</label>
                                                <div class="">
                                                    <input name="txtFromDate"
                                                           class="from_date form-control form-control-inline input-medium default-date-picker"
                                                           size="16" type="text" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 padd_lft_0">
                                            <div class="form-group">
                                                <label class="">To Date</label>
                                                <div class="">
                                                    <input name="txtToDate"
                                                           class="to_date form-control form-control-inline input-medium default-date-picker"
                                                           size="16" type="text" value="" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padd_rght_0 mrgn_tp_24 res_no_padd_lft padding_left_media mrgn_tp_24_media">
                                            <button type="button" class="btn btn-success btn_two_date "> Calculate
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 padd_lft_0 margin_top_media">
                                        <div class="form-group">
                                            <label class="">Specific Date</label>
                                            <div class="">
                                                <input name="txtDate"
                                                       class="date12 form-control form-control-inline input-medium default-date-picker"
                                                       size="16" type="text" value="" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 padd_rght_0 mrgn_tp_24 padding_left_media mrgn_tp_24_media">
                                        <button type="button" class="btn btn-success btn_date"> Calculate</button>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 padd_rght_0 padding_left_media margin_top_media">


                                </div>


                            </div>
                        </section>

                    </div>
                </div>
                <div class="row" id="extra_graph_hide">
                    <div class="col-lg-6">
                        <section class="panel">
                            <header class="panel-heading">
                                Quarterly Apple iOS device unit sales
                            </header>
                            <div class="panel-body">
                                <div id="hero-area" class="graph"></div>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-6">
                        <section class="panel">
                            <header class="panel-heading">
                                Donut flavours
                            </header>
                            <div class="panel-body">
                                <div id="hero-donut" class="graph"></div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>

            <!-- page end-->
        </section>
    </section>

    <style>
        #extra_graph_hide {
            display: none;
        }
    </style>

    <script type="text/javascript">

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.js"></script>
    <script type="text/javascript">


        $('.type').click(function () {
            $('.select_year_product').val("0");
            // alert(0);
        });
        $('.type1').click(function () {
            $('.select_year').val("0");
            $('.total_earning').text("");
            // alert(0);
        });

        $('.select_year').on('change', function () {
            var select_year = $('.select_year').val();
            var type = $("input[name='types']:checked"). val();
            // var = $('.type1').val();
            if(typeof(type) == 'undefined'){
                alert('please select type');
                return false;
            }
            $.ajax({
                method: "POST",
                url: '<?php echo site_url('sell_report/select_yearwise_earning'); ?>',
                data: {select_year: select_year, type: type},
                success: function (data) {
                    $('.total_earning').text('$' + data);
                }
            });
        });
    </script>
    <script type="text/javascript">

        $('.btn_date').on('click', function () {

            $('.from_date').val("");
            $('.to_date').val("");
            var type = $("input[name='types']:checked"). val();

            var date = $('.date12').val();
            var user = "<?php echo $vendor_id; ?>";

            $.ajax({
                method: "POST",
                url: '<?php  echo site_url('sell_report/select_date_earning'); ?>',
                data: {date: date, user: user, type: type},
                success: function (data) {
                    $('.total_earning').text('$' + data);
                }
            });
        });
    </script>
    <script type="text/javascript">
        $('.btn_two_date').on('click', function () {
            var type = $("input[name='types']:checked"). val();

            $('.date12').val("");
            var from_date = $('.from_date').val();
            var to_date = $('.to_date').val();
            var user = "<?php echo $vendor_id; ?>";
            $.ajax({
                method: "POST",
                url: '<?php  echo site_url('sell_report/select_two_date_earning'); ?>',
                data: {from_date: from_date, type: type, to_date: to_date, user: user},
                success: function (data) {
                    $('.total_earning').text('$' + data);
                }
            });
        });
    </script>
    <script type="text/javascript">
        $('.select_year_product').on('change', function () {
            document.getElementById('select_year_dropdown').submit();

        });
    </script>


<?php include('footer_sell_report.php'); ?>