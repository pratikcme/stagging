<?php
include('header.php');
error_reporting(0);
?>
    <style>
        .panel.terques-chart .chart-tittle {
            font-size: 20px;
            padding: 10px;
        }
        .sl_pymnt_pge .panel-heading {
            float: left;
            width: 100%;
        }

        .mrgn_btm_20 {
            margin-bottom: 20px;
        }
        .panel-heading {
            background: #5b6e84;
            font-size: 16px;
            font-weight: 300;
            color: white;
        }
        .padd_lft_0 {
            padding-left: 0;
        }
        .paymnt_rpt_srch label {
            float: left;
            width: 100%;
        }
        .paymnt_rpt_srch {
            float: left;
        }

        .paymnt_rpt_srch input {
            border: 1px solid #ccc;
            padding: 8px;
            width: 100%;
        }
        .text-right {
            text-align: right;
        }

        .mrgn_tp_24 {
            margin-top: 24px;
        }
        .no_padd {
            padding: 0;
        }

        element.style {
        }
        button, html input[type=button], input[type=reset], input[type=submit] {
            -webkit-appearance: button;
            cursor: pointer;
        }
        .btn-default {
            background-color: #2a3542;
            border-color: #2a3542;
            color: #fff;
        }
        .chart_max_hght_dhbrd.custom-bar-chart-payment {
            float: left;
            width: 100%;
        }

        .custom-bar-chart-payment {
            height: 350px;
            margin-top: 20px;
            margin-left: 10px;
            position: relative;
            border-bottom: 1px solid #c9cdd7;
            margin-bottom: 30px;
        }
        .custom-bar-chart-payment .bar2 {
            height: 100%;
            position: relative;
            width: 4.3%;
            margin: 0px 2%;
            float: left;
            text-align: center;
            -webkit-border-radius: 5px 5px 0 0;
            -moz-border-radius: 5px 5px 0 0;
            border-radius: 5px 5px 0 0;
            z-index: 10;
        }
        .chart_max_hght_dhbrd.custom-bar-chart-payment .bar2 .value2 {
            max-height: 350px;
        }

        .custom-bar-chart-payment .bar2 .value2 {
            position: absolute;
            bottom: 0;
            background: #bfc2cd;
            color: #bfc2cd;
            width: 100%;
            border-radius: 5px 5px 0 0;
            transition: all .3s ease;
        }
        .custom-bar-chart-payment {
            height: 350px;
            margin-top: 20px;
            margin-left: 10px;
            position: relative;
            border-bottom: 1px solid #c9cdd7;
            margin-bottom: 30px;
        }
    </style>
    <!--main content start-->
    <div class="col-md-12 col-sm-12 col-xs-12">
    <section id="main-content">
        <section class="wrapper ">

            <div class="row">

                <div class="col-lg-12 sl_pymnt_pge padding_zero">
                <div class="wrapper2 panel">
					<header class="panel-heading mrgn_btm_20">
                        <span style="float: left">Payment Report </span>
                    </header>

                    <div class="panel-body">
					
                    <form method="post" action="" id="select_year_dropdown">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no_padd">
                            <div class="payment_strt">
                                <div class="form-group">
                                    <label for="name">Select Order Type</label>
                                    <div class="rows">
                                        <input type="radio" class="type" name="type" <?php if(isset($type) && $type == 9){echo "checked";} ?> value="9">Both
                                        <input type="radio" class="type" name="type" <?php if(isset($type) && $type == 1){echo "checked";} ?> value="1">Grocery
                                        <input type="radio" class="type" name="type" <?php if(isset($type) && $type == 0){echo "checked";} ?> value="0">POS
                                    </div>
                                </div>
                                <div class="form-group col-lg-5 col-md-4 col-sm-12 col-xs-12 padd_lft_0 padding_right_media1">
                                    <label for="name">Select Year</label>
                                    <select class="form-control select_year_product" name="select_year_product" >
                                        <option value="0" selected="" disabled="">-----Select Year -----</option>
                                        <?php
                                            $year = date('Y');
                                            $j = $year-10;


                                        for($i=$year;$i>=$j;$i--){ ?>
                                            <option <?php if(isset($_POST['select_year_product'])){if($select_year_product== $i){echo "selected";} }  ?>   value="<?php echo $i; ?>"> <?php echo $i; ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12 paymnt_rpt_srch padd_lft_0 padding_right_media">

                                    <label for="name">Start Date</label>
                                    <input type="text" class="form-control-inline input-medium default-date-picker" name="from_date" id="from_date" value="<?php echo $from_var; ?>">

                                </div>
                                <div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12 paymnt_rpt_srch padd_lft_0 padding_right_media">

                                    <label for="name">End Date</label>
                                    <input type="text" class="form-control-inline input-medium default-date-picker" name="end_date" id="end_date" value="<?php echo $var; ?>">

                                </div>
                                <div class="form-group col-lg-1 col-md-2 col-sm-4 col-xs-12 paymnt_rpt_srch_btn no_padd text-right mrgn_tp_24  ">

                                    <input type="submit" class="btn btn-default" name="btn_date" id="btn_date" value="Search">

                                </div>
                            </div>
                        </div>

                    </form>
                    </div>
                </div>

                <div class="wrapper2 panel">
                    <header class="panel-heading">
                        <span style="float: left">Payment Report: By Cash </span>
                        <span style="float: right">
                            <label id="select_year_cash"> Year:
                                <?php if(!(isset($_POST['select_year_product']))) { echo ''; }else{ echo $select_year_product; } ?>
                            </label>
                        </span>
                    </header>
                    <div class="panel-body">
                    <!--custom chart start-->
                    <div class="border-head"></div>



                    <?php if(isset($_POST['select_year_product'])) { ?>

                        <div class="chart_max_hght_dhbrd custom-bar-chart-payment">

                            <?php
                            $month_array = array('JAN','FEB','MAR','APR','MAY','JUN','JULY','AUG','SEP','OCT','NOV','DEC');

                            $number = array(
                                $row_first_month['0']->total_monthwise,
                                $row_second_month['0']->total_monthwise,
                                $row_third_month['0']->total_monthwise,
                                $row_fourth_month['0']->total_monthwise,
                                $row_fifth_month['0']->total_monthwise,
                                $row_six_month['0']->total_monthwise,
                                $row_seven_month['0']->total_monthwise,
                                $row_eight_month['0']->total_monthwise,
                                $row_nine_month['0']->total_monthwise,
                                $row_ten_month['0']->total_monthwise,
                                $row_eleven_month['0']->total_monthwise,
                                $row_twelve_month['0']->total_monthwise);

                            $combined_array = array_combine($month_array, $number);

                            foreach($combined_array as $item => $item_value)
                            { ?>
                                <div class="bar2">
                                    <div class="title"><?php echo $item; ?></div>
                                    <div class="value2 tooltips" data-original-title="<?php echo $item_value; ?>" data-toggle="tooltip" data-placement="top"><?php echo $item_value; ?></div>
                                </div>
                            <?php } ?>
                        </div>

                    <?php } elseif(isset($_POST['btn_date']) && $_POST['btn_date'] == 'Search') { ?>

                        <div class="chart_max_hght_dhbrd custom-bar-chart-payment">
                            <?php
                            $month_array = array('JAN','FEB','MAR','APR','MAY','JUN','JULY','AUG','SEP','OCT','NOV','DEC');

                            $number = array(
                                $row_first_month_date['0']->total_monthwise,
                                $row_second_month_date['0']->total_monthwise,
                                $row_third_month_date['0']->total_monthwise,
                                $row_fourth_month_date['0']->total_monthwise,
                                $row_fifth_month_date['0']->total_monthwise,
                                $row_six_month_date['0']->total_monthwise,
                                $row_seven_month_date['0']->total_monthwise,
                                $row_eight_month_date['0']->total_monthwise,
                                $row_nine_month_date['0']->total_monthwise,
                                $row_ten_month_date['0']->total_monthwise,
                                $row_eleven_month_date['0']->total_monthwise,
                                $row_twelve_month_date['0']->total_monthwise);

                            $combined_array = array_combine($month_array, $number);

                            foreach($combined_array as $item => $item_value)
                            { ?>
                                <div class="bar2">
                                    <div class="title"><?php echo $item; ?></div>
                                    <div class="value2 tooltips" data-original-title="<?php echo $item_value; ?>" data-toggle="tooltip" data-placement="top"><?php echo $item_value; ?></div>
                                </div>
                            <?php } ?>
                        </div>

                    <?php } else { ?>

                        <div class="chart_max_hght_dhbrd custom-bar-chart-payment">
                            <?php
                            $month_array = array('JAN','FEB','MAR','APR','MAY','JUN','JULY','AUG','SEP','OCT','NOV','DEC');

                            $number = array(
                                $row_first_month['0']->total_monthwise,
                                $row_second_month['0']->total_monthwise,
                                $row_third_month['0']->total_monthwise,
                                $row_fourth_month['0']->total_monthwise,
                                $row_fifth_month['0']->total_monthwise,
                                $row_six_month['0']->total_monthwise,
                                $row_seven_month['0']->total_monthwise,
                                $row_eight_month['0']->total_monthwise,
                                $row_nine_month['0']->total_monthwise,
                                $row_ten_month['0']->total_monthwise,
                                $row_eleven_month['0']->total_monthwise,
                                $row_twelve_month['0']->total_monthwise);

                            $combined_array = array_combine($month_array, $number);

                            foreach($combined_array as $item => $item_value)
                            { ?>
                                <div class="bar2">
                                    <div class="title"><?php echo $item; ?></div>
                                    <div class="value2 tooltips" data-original-title="<?php echo $item_value; ?>" data-toggle="tooltip" data-placement="top"><?php echo $item_value; ?></div>
                                </div>
                            <?php } ?>
                        </div>

                    <?php } ?>

                </div>
                </div>
                </div>

                <div class="col-lg-12 ">
                <div class="wrapper2 panel">
                    <header class="panel-heading" style="height: 45px;"> <span style="float: left">Payment Report : Online </span> <span style="float: right"> <label id="select_year_cash"> Year: <?php if(!(isset($_POST['select_year_product']))) { echo ''; }else{ echo $select_year_product; } ?> </label></span> </header>

                    <div class="panel-body">
                    <!--custom chart start-->
                    <div class="border-head">
                    </div>

                    <?php if(isset($_POST['select_year_product'])) { ?>

                        <div class="custom-bar-chart-payment">
                            <?php
                            $month_array = array('JAN','FEB','MAR','APR','MAY','JUN','JULY','AUG','SEP','OCT','NOV','DEC');

                            $number = array(
                                $row_first_month1['0']->total_monthwise,
                                $row_second_month1['0']->total_monthwise,
                                $row_third_month1['0']->total_monthwise,
                                $row_fourth_month1['0']->total_monthwise,
                                $row_fifth_month1['0']->total_monthwise,
                                $row_six_month1['0']->total_monthwise,
                                $row_seven_month1['0']->total_monthwise,
                                $row_eight_month1['0']->total_monthwise,
                                $row_nine_month1['0']->total_monthwise,
                                $row_ten_month1['0']->total_monthwise,
                                $row_eleven_month1['0']->total_monthwise,
                                $row_twelve_month1['0']->total_monthwise);

                            $combined_array1 = array_combine($month_array, $number);

                            foreach($combined_array1 as $item => $item_value)
                            { ?>
                                <div class="bar2">
                                    <div class="title"><?php echo $item; ?></div>
                                    <div class="value2 tooltips" data-original-title="<?php echo $item_value; ?>" data-toggle="tooltip" data-placement="top"><?php echo $item_value; ?></div>
                                </div>
                            <?php } ?>
                        </div>

                    <?php } elseif(isset($_POST['btn_date']) && $_POST['btn_date'] == 'Search') { ?>

                        <div class="custom-bar-chart-payment">
                            <?php
                            $month_array = array('JAN','FEB','MAR','APR','MAY','JUN','JULY','AUG','SEP','OCT','NOV','DEC');

                            $number = array(
                                $row_first_month1_date['0']->total_monthwise,
                                $row_second_month1_date['0']->total_monthwise,
                                $row_third_month1_date['0']->total_monthwise,
                                $row_fourth_month1_date['0']->total_monthwise,
                                $row_fifth_month1_date['0']->total_monthwise,
                                $row_six_month1_date['0']->total_monthwise,
                                $row_seven_month1_date['0']->total_monthwise,
                                $row_eight_month1_date['0']->total_monthwise,
                                $row_nine_month1_date['0']->total_monthwise,
                                $row_ten_month1_date['0']->total_monthwise,
                                $row_eleven_month1_date['0']->total_monthwise,
                                $row_twelve_month1_date['0']->total_monthwise);

                            $combined_array = array_combine($month_array, $number);

                            foreach($combined_array as $item => $item_value)
                            { ?>
                                <div class="bar2">
                                    <div class="title"><?php echo $item; ?></div>
                                    <div class="value2 tooltips" data-original-title="<?php echo $item_value; ?>" data-toggle="tooltip" data-placement="top"><?php echo $item_value; ?></div>
                                </div>
                            <?php } ?>
                        </div>

                    <?php } else { ?>

                        <div class="custom-bar-chart-payment">
                            <?php
                            $month_array = array('JAN','FEB','MAR','APR','MAY','JUN','JULY','AUG','SEP','OCT','NOV','DEC');

                            $number = array(
                                $row_first_month1['0']->total_monthwise,
                                $row_second_month1['0']->total_monthwise,
                                $row_third_month1['0']->total_monthwise,
                                $row_fourth_month1['0']->total_monthwise,
                                $row_fifth_month1['0']->total_monthwise,
                                $row_six_month1['0']->total_monthwise,
                                $row_seven_month1['0']->total_monthwise,
                                $row_eight_month1['0']->total_monthwise,
                                $row_nine_month1['0']->total_monthwise,
                                $row_ten_month1['0']->total_monthwise,
                                $row_eleven_month1['0']->total_monthwise,
                                $row_twelve_month1['0']->total_monthwise);

                            $combined_array1 = array_combine($month_array, $number);

                            foreach($combined_array1 as $item => $item_value)
                            { ?>
                                <div class="bar2">
                                    <div class="title"><?php echo $item; ?></div>
                                    <div class="value2 tooltips" data-original-title="<?php echo $item_value; ?>" data-toggle="tooltip" data-placement="top"><?php echo $item_value; ?></div>
                                </div>
                            <?php } ?>
                        </div>

                    <?php } ?>

                </div>
                </div>
                </div>
            </div>
        </section>
    </section>
    <!--main content end-->
    <script src="<?php echo base_url().'public/js/jquery-1.8.3.min.js' ?>"></script>
    <script type="text/javascript">


        $('.type').click(function () {
            $('.select_year_product').val("0");
            // alert(0);
        });
        $('.select_year_product').on('change', function () {
            var year = this.value;
            document.getElementById("select_year_dropdown").submit();
        });
    </script>
<?php include('payment_report_footer.php'); ?>