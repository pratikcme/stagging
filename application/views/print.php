<?php
include('header.php');

$order_id = base64_decode($_GET['ZqRl']);
$vendor_id = $this->session->userdata('id');

$order_query = $this->db->query("SELECT od.calculation_price, od.total_discount, od.quantity, od.dt_updated, p.name, pw.discount_price FROM pos_order_detail as od 
                                  LEFT JOIN product as p ON p.id = od.product_id 
                                  LEFT JOIN product_weight as pw ON pw.product_id = od.product_id WHERE od.pos_order_id = '$order_id' AND p.vendor_id = $vendor_id AND od.status != '9'");
$order_row = $order_query->result();

$order_query_ = $this->db->query("SELECT o.order_number AS order_no, o.id ,o.total_price AS subtotal, o.total_discount AS discount_per, o.total_discount, o.calculation_price AS total, c.id, c.email as customer_email, c.customer_name, c.customercode, u.owner_name as user_name, u.name, u.phone_no AS phone FROM `pos_order` as o
                                    LEFT JOIN customer as c ON c.id = o.user_id
                                    LEFT JOIN vendor as u ON u.id = o.vendor_id
                                    WHERE o.id = '$order_id' AND o.vendor_id = $vendor_id AND o.status != '9'");
$order_row_ = $order_query_->row_array();

$discount_price = ($order_row_['subtotal'] * $order_row_['discount_per']) / 100;
$sub_vat = $order_row_['subtotal'] - $discount_price;
$vat = ($sub_vat * 10) / 100;

?>
<style>




    html {
        height: 100%;
        box-sizing: border-box;
    }


    /* INVOICE START */
    .invc_cmpny_name {float: left;width: 100%;text-align: center;}
    .cm_name {float: left;width: 100%;}
    .reciept {float: left;width: 100%;margin: 15px 0 10px;}
    .invoice_sub_tile {float: left;width: 100%;}
    .invoice_sub_tile ul {padding: 0;float: left;width: 100%;}
    .invoice_sub_tile ul li{font-size: 14px;line-height: 20px;font-weight: 600;}
    .soccer_ball {float: left;width: 100%;border: 1px solid #ccc;}
    .soccer_ball ul{float: left;width: 100%;padding: 0;margin:0;}
    .soccer_ball ul li{float: left;width: 100%;border-bottom: 1px solid #ccc;margin-bottom: 5px;}
    .soccer_ball ul li:last-child {border-bottom: medium none;margin: 0;}
    .product_details{float: left;width: 100%;}
    .product_details h5{float: left;width: 100%;font-weight: bold;}
    .invoice_quantity{float: left;width: 100%;}
    .invoice_quantity span {float: left;width: auto;}
    .total_quantity_prc{float: left;width: 100%;}
    .total_quantity_prc p{float: right;margin-top: 20px;}
    .invoice_total_dsn {text-align: right;width: 100%;float: right;margin-top: 15px;}
    .tax_subtotal {float: left;width: 100%;}
    .sub_ttl_invocie {float: left;width: 100%;text-align: left;margin-bottom: 10px;}
    .sub_ttl_invocie span {float: left;width: 100%;font-weight: bold;}
    .total_amount {float: right;margin-bottom: 10px;}
    .main_total_invoice {float: left;width: 100%;padding: 10px 0 0;border-top: 1px solid;border-bottom: 1px solid;}
    .total_invoice_detail {float: left;width: auto;}
    .total_invoice_detail span {font-weight: bold;font-size: 20px;}
    .total_amount span {margin: 5px 0 0;float: left;width: 100%;}
    .cash_invoice {    float: left;width: 100%;padding: 10px 0;}


    .file-actions .file-footer-buttons .kv-file-upload.btn.btn-xs.btn-default {display: none;}
    .input-group-btn .btn.btn-default.fileinput-upload.fileinput-upload-button{display:none;}

    .order_data_view {float: left;width: 100%; margin-top: 40px;}
    .my_total_amount {float: right;width: 20%;}
    .data_display_list {float: right;width: 100%; border-bottom: 1px solid #ccc;padding: 10px 0;}
    .data_display_list span {float: left;font-weight: bold;width:65%;text-align: left;}
    .data_display_list p {margin: 0;}
    .checkout_closed_register {float: left;position: relative;text-align: center;top: 190px;width: 100%;}
    .checkout_closed_register img {width: 15%;}
    .checkout_closed_register h3 {float: left;font-size: 30px;font-weight: bold;width: 100%;}
    .checkout_closed_register > p {font-weight: 600;width: 100%;}
    .checkout_closed_register .btn.btn-warning {background:#FF8D84 none repeat scroll 0 0;border:#FF8D84;font-weight: bold;padding: 12px 30px;text-transform: uppercase;}
    .payment_strt {float: left;margin-bottom: 10px;width: 100%;}
    .paymnt_rpt_srch {float: left;}
    .paymnt_rpt_srch label {float: left;width: 100%;}
    .paymnt_rpt_srch input {border:1px solid #ccc;padding:8px;width: 100%;}
    .sl_pymnt_pge .panel-heading {float: left;width: 100%;}
    .chart_max_hght_dhbrd.custom-bar-chart-payment{float:left;width:100%;}
    .paymnt_rpt_srch_btn .btn.btn-default{background: #303030 none repeat scroll 0 0;font-weight: bold;padding:9px 40px;text-transform: uppercase;}
    .paymnt_rpt_srch_btn .btn.btn-default:hover{background:#FF8D84;transition:all 0.5s ease 0s;}
    .paymnet_cmplt {background: white none repeat scroll 0 0;float: left;padding: 15px;width: 100%;}
    /* .receiept_cmplt_frm {float: left;width: 40%;margin-top: 35px;} */
    .receiept_cmplt_frm h2 {float: left;font-size: 36px;width: 100%;margin-bottom: 15px;}
    .receiept_cmplt_frm input.form-control {height: auto;padding: 10px;width:74%;float:left;}
    .prnt_sbmt {background:#303030 none repeat scroll 0 0;border: 1px solid #303030;color:white;font-size: 16px;font-weight: bold;margin-left:1%;padding:8px 18px;text-transform: uppercase;}
    .prnt_sbmt:hover{background:#FF8D84;transition:all 0.5s ease 0s;border: 1px solid #FF8D84;}
    .prnt_receipt {background:#303030 none repeat scroll 0 0;border: medium none;color:#fff;margin-left: 1%;padding:9px 8px;font-size: 16px;font-weight: bold;text-transform: uppercase;}
    .prnt_receipt:hover{background:#FF8D84;transition:all 0.5s ease 0s;border: none;}
    .pnt_sb_totl .tl_lft_prnt.pull-right {float: left !important;}
    .prnt_rght_center {margin: 0 auto;width: 80%;}
    .msg_dply_prnt .form-group {float: none;margin: 20px auto;width:65%;}
    .prnt_sbmt_done {margin: 0;padding: 10px;background: #50BE5A none repeat scroll 0 0;border: 1px solid #50BE5A;color: white;font-size: 16px;font-weight: bold;padding: 8px 145px;   text-transform: uppercase;}
    .prnt_sbmt_done:hover{background:#FF8D84;transition:all 0.5s ease 0s;border-color: #FF8D84;}

    @media only screen and (min-width: 1500px) and (max-width:1599px) {

        .receiept_cmplt_frm{padding-right:0;}
        .prnt_rght_center{width:100%;}
        .receiept_cmplt_frm h2{margin-top:0;}
        .receiept_cmplt_frm input.form-control{width:70%;}

        .res_tab_prfl_prdt table.table {display: block;float: left;overflow-x: scroll;width: 100%;background:white;}
        #example_wrapper table.table.display.dataTable.tab_res_errr.no_dpl_blck_cls{display:inline-table;}

        .ruppers_txt{width:20%;}

        .paymnt_rpt_srch_btn .btn.btn-default{padding:9px;}

        .catg_list{width:19%;}

    }

    @media only screen and (min-width: 1600px) and (max-width:1699px) {

        .receiept_cmplt_frm{padding-right:0;}
        .prnt_rght_center{width:100%;}
        .receiept_cmplt_frm h2{margin-top:0;}
        .receiept_cmplt_frm input.form-control{width:70%;}

        .res_tab_prfl_prdt table.table {display: block;float: left;overflow-x: scroll;width: 100%;background:white;}

        .ruppers_txt{width:20%;}

        .paymnt_rpt_srch_btn .btn.btn-default{padding:9px;}

        .catg_list{width:19%;}

    }

    @media only screen and (min-width: 1700px) and (max-width:1799px) {

        .receiept_cmplt_frm{padding-right:0;}
        .prnt_rght_center{width:100%;}
        .receiept_cmplt_frm h2{margin-top:0;}

        .ruppers_txt{width:20%;}

    }

    @media only screen and (min-width: 1800px) and (max-width:1900px) {

        .receiept_cmplt_frm{padding-right:0;}
        .prnt_rght_center{width:100%;}
        .receiept_cmplt_frm h2{margin-top:0;}
        .msg_dply_prnt .form-group{width:55%;}

        .ruppers_txt{width:20%;}

    }

    @media only screen and (max-width: 767px){
        .padding_left_media{
            padding-left: 0px;
        }
        .receiept_cmplt_frm {
            width: 100%;
            padding: 0;
            margin-bottom: 60px;
        }
        .padding_right_media{
            padding-right: 0px;
        }
        .padding_right_media1{
            padding-right: 0px;
        }
        .margin_top_media{
            margin-top: 40px;
        }
        .mrgn_tp_24_media {
            margin-top: 10px;
        }
        .custom-bar-chart-month {
            margin-bottom: 50px;
        }
        /*.btn {
            margin-bottom: 50px !important;
        }*/
        .btn-success{
            margin-bottom: 50px !important;
        }
    }




    html{height:100%;box-sizing:border-box}.invc_cmpny_name{float:left;width:100%;text-align:center}.cm_name{float:left;width:100%}.reciept{float:left;width:100%;margin:15px 0 10px}.invoice_sub_tile{float:left;width:100%}.invoice_sub_tile ul{padding:0;float:left;width:100%}.invoice_sub_tile ul li{font-size:14px;line-height:20px;font-weight:600}.soccer_ball{float:left;width:100%;border:1px solid #ccc}.soccer_ball ul{float:left;width:100%;padding:0;margin:0}.soccer_ball ul li{float:left;width:100%;border-bottom:1px solid #ccc;margin-bottom:5px}.soccer_ball ul li:last-child{border-bottom:medium none;margin:0}.product_details{float:left;width:100%}.product_details h5{float:left;width:100%;font-weight:700}.invoice_quantity{float:left;width:100%}.invoice_quantity span{float:left;width:auto}.total_quantity_prc{float:left;width:100%}.total_quantity_prc p{float:right;margin-top:20px}.invoice_total_dsn{text-align:right;width:100%;float:right;margin-top:15px}.tax_subtotal{float:left;width:100%}.sub_ttl_invocie{float:left;width:100%;text-align:left;margin-bottom:10px}.sub_ttl_invocie span{float:left;width:100%;font-weight:700}.total_amount{float:right;margin-bottom:10px}.main_total_invoice{float:left;width:100%;padding:10px 0 0;border-top:1px solid;border-bottom:1px solid}.total_invoice_detail{float:left;width:auto}.total_invoice_detail span{font-weight:700;font-size:20px}.total_amount span{margin:5px 0 0;float:left;width:100%}.cash_invoice{float:left;width:100%;padding:10px 0}.file-actions .file-footer-buttons .kv-file-upload.btn.btn-xs.btn-default{display:none}.input-group-btn .btn.btn-default.fileinput-upload.fileinput-upload-button{display:none}.order_data_view{float:left;width:100%;margin-top:40px}.my_total_amount{float:right;width:20%}.data_display_list{float:right;width:100%;border-bottom:1px solid #ccc;padding:10px 0}.data_display_list span{float:left;font-weight:700;width:65%;text-align:left}.data_display_list p{margin:0}.checkout_closed_register{float:left;position:relative;text-align:center;top:190px;width:100%}.checkout_closed_register img{width:15%}.checkout_closed_register h3{float:left;font-size:30px;font-weight:700;width:100%}.checkout_closed_register>p{font-weight:600;width:100%}.checkout_closed_register .btn.btn-warning{background:#ff8d84 none repeat scroll 0 0;border:#ff8d84;font-weight:700;padding:12px 30px;text-transform:uppercase}.payment_strt{float:left;margin-bottom:10px;width:100%}.paymnt_rpt_srch{float:left}.paymnt_rpt_srch label{float:left;width:100%}.paymnt_rpt_srch input{border:1px solid #ccc;padding:8px;width:100%}.sl_pymnt_pge .panel-heading{float:left;width:100%}.chart_max_hght_dhbrd.custom-bar-chart-payment{float:left;width:100%}.paymnt_rpt_srch_btn .btn.btn-default{background:#303030 none repeat scroll 0 0;font-weight:700;padding:9px 40px;text-transform:uppercase}.paymnt_rpt_srch_btn .btn.btn-default:hover{background:#ff8d84;transition:all .5s ease 0s}.paymnet_cmplt{background:#fff none repeat scroll 0 0;float:left;padding:15px;width:100%}.receiept_cmplt_frm h2{float:left;font-size:36px;width:100%;margin-bottom:15px}.receiept_cmplt_frm input.form-control{height:auto;padding:10px;width:74%;float:left}.prnt_sbmt{background:#303030 none repeat scroll 0 0;border:1px solid #303030;color:#fff;font-size:16px;font-weight:700;margin-left:1%;padding:8px 18px;text-transform:uppercase}.prnt_sbmt:hover{background:#ff8d84;transition:all .5s ease 0s;border:1px solid #ff8d84}.prnt_receipt{background:#303030 none repeat scroll 0 0;border:medium none;color:#fff;margin-left:1%;padding:9px 8px;font-size:16px;font-weight:700;text-transform:uppercase}.prnt_receipt:hover{background:#ff8d84;transition:all .5s ease 0s;border:none}.pnt_sb_totl .tl_lft_prnt.pull-right{float:left!important}.prnt_rght_center{margin:0 auto;width:80%}.msg_dply_prnt .form-group{float:none;margin:20px auto;width:80%}.prnt_sbmt_done{margin:0;padding:10px;background:#50be5a none repeat scroll 0 0;border:1px solid #50be5a;color:#fff;font-size:16px;font-weight:700;padding:8px 145px;text-transform:uppercase}.prnt_sbmt_done:hover{background:#ff8d84;transition:all .5s ease 0s;border-color:#ff8d84}@media only screen and (min-width:1500px) and (max-width:1599px){.receiept_cmplt_frm{padding-right:0}.prnt_rght_center{width:100%}.receiept_cmplt_frm h2{margin-top:0}.receiept_cmplt_frm input.form-control{width:70%}.res_tab_prfl_prdt table.table{display:block;float:left;overflow-x:scroll;width:100%;background:#fff}#example_wrapper table.table.display.dataTable.tab_res_errr.no_dpl_blck_cls{display:inline-table}.ruppers_txt{width:20%}.paymnt_rpt_srch_btn .btn.btn-default{padding:9px}.catg_list{width:19%}}@media only screen and (min-width:1600px) and (max-width:1699px){.receiept_cmplt_frm{padding-right:0}.prnt_rght_center{width:100%}.receiept_cmplt_frm h2{margin-top:0}.receiept_cmplt_frm input.form-control{width:70%}.res_tab_prfl_prdt table.table{display:block;float:left;overflow-x:scroll;width:100%;background:#fff}.ruppers_txt{width:20%}.paymnt_rpt_srch_btn .btn.btn-default{padding:9px}.catg_list{width:19%}}@media only screen and (min-width:1700px) and (max-width:1799px){.receiept_cmplt_frm{padding-right:0}.prnt_rght_center{width:100%}.receiept_cmplt_frm h2{margin-top:0}.ruppers_txt{width:20%}}@media only screen and (min-width:1800px) and (max-width:1900px){.receiept_cmplt_frm{padding-right:0}.prnt_rght_center{width:100%}.receiept_cmplt_frm h2{margin-top:0}.msg_dply_prnt .form-group{width:55%}.ruppers_txt{width:20%}}@media only screen and (max-width:767px){.padding_left_media{padding-left:0}.receiept_cmplt_frm{width:100%;padding:0;margin-bottom:60px}.padding_right_media{padding-right:0}.padding_right_media1{padding-right:0}.margin_top_media{margin-top:40px}.mrgn_tp_24_media{margin-top:10px}.custom-bar-chart-month{margin-bottom:50px}.btn-success{margin-bottom:50px!important}}
    .panel-heading {
        background: #5b6e84;
        font-size: 16px;
        font-weight: 300;
        color: white;
    }

    .paymnet_cmplt {
        background: white none repeat scroll 0 0;
        float: left;
        padding: 15px;
        width: 100%;
    }

    .product_details h5 {
        float: left;
        width: 100%;
        font-weight: bold;
    }

    .product_details {
        float: left;
        width: 100%;
    }

    .invoice_quantity span {
        float: left;
        width: auto;
    }

    .soccer_ball ul li:last-child {
        border-bottom: medium none;
        margin: 0;
    }

    .soccer_ball ul li {
        float: left;
        width: 100%;
        border-bottom: 1px solid #ccc;
        margin-bottom: 5px;
    }

    ul li {
        list-style: none;
    }

    .total_quantity_prc {
        float: left;
        width: 100%;
    }

    .total_quantity_prc p {
        float: right;
        margin-top: 20px;
    }

    .invoice_total_dsn {
        text-align: right;
        width: 100%;
        float: right;
        margin-top: 15px;
    }

    .tax_subtotal {
        float: left;
        width: 100%;
    }

    .sub_ttl_invocie {
        float: left;
        width: 100%;
        text-align: left;
        margin-bottom: 10px;
    }

    .sub_ttl_invocie span {
        float: left;
        width: 100%;
        font-weight: bold;
    }

    .total_amount {
        float: right;
        margin-bottom: 10px;
    }

    .total_amount span {
        margin: 5px 0 0;
        float: left;
        width: 100%;
    }



    *, *:before, *:after {
        box-sizing: inherit;
    }

    .main_total_invoice {
        float: left;
        width: 100%;
        padding: 10px 0 0;
        border-top: 1px solid;
        border-bottom: 1px solid;
    }

    .total_invoice_detail {
        float: left;
        width: auto;
    }

    .total_invoice_detail span {
        font-weight: bold;
        font-size: 20px;
    }

    .cash_invoice {
        float: left;
        width: 100%;
        padding: 10px 0;
    }

    @media only screen and (max-width: 1599px) and (min-width: 1500px)
        .receiept_cmplt_frm {
            padding-right: 0;
        }

        @media only screen and (max-width: 1599px) and (min-width: 1500px)
            .prnt_rght_center {
                width: 100%;
            }

            .prnt_rght_center {
                margin: 0 auto;
                width: 80%;
            }
            .receiept_cmplt_frm h2 {
                float: left;
                font-size: 36px;
                width: 100%;
                margin-bottom: 15px;
            }
            
            .prnt_sbmt {
                background: #303030 none repeat scroll 0 0;
                border: 1px solid #303030;
                color: white;
                font-size: 16px;
                font-weight: bold;
                margin-left: 1%;
                padding: 8px 18px;
                text-transform: uppercase;
            }
            .prnt_sbmt_done {
                margin: 0;
                padding: 10px;
                background: #50BE5A none repeat scroll 0 0;
                border: 1px solid #50BE5A;
                color: white;
                font-size: 16px;
                font-weight: bold;
                padding: 8px 145px;
                text-transform: uppercase;
            }
            a, a:hover, a:focus {
                text-decoration: none;
                outline: none;
            }
            .soccer_ball ul li:last-child {
                border-bottom: medium none;
                margin: 0;
            }

            .soccer_ball ul li {
                float: left;
                width: 100%;
                border-bottom: 1px solid #ccc;
                margin-bottom: 5px;
            }
            ul li {
                list-style: none;
            }
            .pnt_sb_totl .tl_lft_prnt.pull-right {
                float: left !important;
            }

            .no_padd {
                padding: 0;
            }

</style>

<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <div id="msg" class="">
            <?php if ($this->session->flashdata('msg') && $this->session->flashdata('msg') != '') { ?>
                <div class="alert alert-success fade in">
                    <strong>Success!</strong> <?php echo $this->session->flashdata('msg');; ?>
                </div>
            <?php }
            unset($this->session->flashdata); ?>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Summary
                    </header>
                    <div id="printableArea" style="display:none;">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="container">
                                <div class="col-md-12 col-sm-12 col-xs-12 border">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <p class="pull-left p_font_size"><?php echo $order_row_['store_name']; ?></p>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-8">
                                            <div class="pull-right">
                                                <p class="text-right p_font_size">
                                                    Org.nr.:<?php echo $order_row_['org_no']; ?></p>
                                                <p class="text-right p_font_size">
                                                    Tel.nr.:<?php echo $order_row_['phone']; ?></p>

                                                <!--<p class="text-right p_font_size">ECC Elgiganten</p>-->
                                                <p class="text-right p_font_size">Unik
                                                    ID: <?php echo $order_row_['id']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="pull-left">
                                                <p class="p_font_size"><?php echo $order_row_['street1']; ?></p>
                                                <p class="p_font_size"><?php echo $order_row_['city'] . ' ,' . $order_row_['state'] . ' ,' . $order_row_['country']; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-8">
                                            <div class="pull-right">
                                                <p class="para"><?php echo ($order_row_['customer_name'] == '') ? 'Guest' : $order_row_['customer_name']; ?></p>
                                                <p class="p_font_size">
                                                    Ordernr: <?php echo $order_row_['order_no']; ?></p>
                                                <p class="p_font_size">
                                                    Saljare.: <?php echo $order_row_['user_name']; ?></p>
                                                <p class="p_font_size">
                                                    Telephone: <?php echo $order_row_['phone']; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="p_font_size">
                                                Kundnr.:<?php echo ($order_row_['customer_id'] == '') ? '1' : $order_row_['customer_id']; ?></p>
                                            <p class="p_font_size">
                                                Org.nr.:<?php echo ($order_row_['customercode'] == '') ? 'CC12345' : $order_row_['customercode']; ?></p>
                                            <p class="p_font_size">
                                                Mail.:<?php echo ($order_row_['customer_email'] == '') ? 'pos-guest@gmail.com' : $order_row_['customer_email']; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 print margin_top_ul div_width">
                                        <div class="col-md-3 col-sm-3 col-xs-3 padding_zero ">
                                            <p class="border_p p_font_size div_p">Item Name</p>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-3 padding_zero">
                                            <p class="border_p p_font_size div_p">Quantity</p>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-3 padding_zero">
                                            <p class="border_p p_font_size div_p">Discount(%)</p>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-3 padding_zero">
                                            <p class="border_p p_font_size div_p">Total</p>
                                        </div>
                                        <?php foreach ($order_row as $detail) { ?>
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
                                            <p class="text-right p_font_size"
                                               style=" margin-top: 130px;"><?php echo $order_row_['default_currency']; ?></p>
                                            <p class="text-center p_font_size">Netto</p>
                                            <p class="text-center p_font_size"><?php echo number_format($sub_vat, 2, '.', ''); ?></p>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-3 padding_zero">
                                            <p class="text-right p_font_size"><?php echo $order_row_['subtotal']; ?></p>
                                            <p class="text-right p_font_size"><?php echo '-' . number_format($discount_price, 2, '.', ''); ?></p>
                                            <p class="text-right p_font_size"><?php echo number_format($sub_vat, 2, '.', ''); ?></p>
                                            <p class="text-right p_font_size"><?php echo number_format($vat, 2, '.', ''); ?></p>
                                            <p class="text-right p_font_size"><?php $total = $vat + $sub_vat;
                                                echo number_format($total, 2, '.', ''); ?></p>
                                            <p class="text-center p_font_size">Moms</p>
                                            <p class="text-center p_font_size"><?php echo number_format($vat, 2, '.', ''); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <p class="p1_font_size">Elgiganten goods will remain the properly untill full
                                            payment is made</p>
                                        <p class="p1_font_size">Customer
                                            name: <?php echo ($order_row_['customer_name'] == '') ? 'Guest' : $order_row_['customer_name']; ?></p>
                                        <p class="p1_font_size">Deposite is anticipated to Elgiganten AB under the
                                            account belo Bank account: 310-6887 Firewood deposite from abroad: IBAN:
                                            SE42919000000091953639099 and SWIFT BIC: DNBASESX Momsregnr / VAT no: SE
                                            556471447401 Apporved for tax</p>

                                        <p class="p1_font_size">For Privatpersoner galler foljand:Vid hemleverans eller
                                            uthamtning av produkt(er) skall full betalning vara bokford minst 2 dagar
                                            innan avtalat leveransdatum.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="divHeader"></div>
                        <div class="divLeft"></div>
                        <div class="divRight"></div>
                        <div class="divFooter"></div>

                    </div>
                </section>
                <div class="paymnet_cmplt">
                    <div class="pnt_sb_totl">
                        <div class="col-md-7 col-lg-7 col-sm-8 col-xs-8 pull-right no_padd tl_lft_prnt">
                            <div class="soccer_ball">
                                <ul>
                                    <?php foreach ($order_row as $detail) { ?>
                                        <li>
                                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                                <div class="product_details">
                                                    <h5><?php echo $detail->name; ?></h5>
                                                    <div class="invoice_quantity">
                                                        <span><?php echo $detail->quantity; ?>.</span>
                                                        <p>$<?php echo $detail->final_price; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6 pull-right">
                                                <div class="total_quantity_prc">
                                                    <p> $<?php echo $detail->price; ?></p>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="invoice_total_dsn">
                                <div class="tax_subtotal">
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                        <div class="sub_ttl_invocie">
                                            <span>Subtotal</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                        <div class="total_amount">
                                            <span>$<?php echo $order_row_['subtotal']; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                        <div class="sub_ttl_invocie">
                                            <span>Discount(%)</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                        <div class="total_amount">
                                            <span>$<?php echo $order_row_['discount_per']; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                        <div class="sub_ttl_invocie">
                                            <span>Discount Price</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                        <div class="total_amount">
                                            <span>$<?php echo $order_row_['total_discount']; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="main_total_invoice">
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                        <div class="total_invoice_detail">
                                            <span>TOTAL</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                        <div class="total_amount">
                                            <span>$<?php echo $order_row_['total']; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="cash_invoice">
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                        <div class="sub_ttl_invocie">
                                            <span>Cash</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                        <div class="total_amount">
                                            <span>$<?php echo $order_row_['total']; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                        <div class="sub_ttl_invocie">
                                            <span>To Pay</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                        <div class="total_amount">
                                            <span>$<?php echo $order_row_['total']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="receiept_cmplt_frm col-md-5 col-lg-5 col-sm-5 col-xs-5">
                        <div class="text-center prnt_rght_center">
                            <h2>Payment complete! </h2>
                            <input type="button" onclick="printDiv('printableArea')" value="Print Receipt"
                                   class="prnt_receipt" style="width: 65%;"/>
                            <form method="post" action="<?php echo base_url() . 'index.php/sell/send_email/'; ?>"
                                  name="send_email" style="margin-top: 50px;">
                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                <input type="hidden" name="sub_total" value="<?php echo $order_row_['subtotal']; ?>">
                                <input type="hidden" name="discount_per"
                                       value="<?php echo $order_row_['discount_per']; ?>">
                                <input type="hidden" name="discount_price"
                                       value="<?php echo $order_row_['total_discount']; ?>">
                                <input type="hidden" name="total" value="<?php echo $order_row_['total']; ?>">
                                <div class="msg_dply_prnt">
                                    <div class="form-group">
                                        <!-- <label for="email">Email</label> -->
                                        <input type="text" name="rec_email" class="form-control"
                                               value="<?php echo ($order_row_['customer_email'] == '') ? '' : $order_row_['customer_email']; ?>"
                                               placeholder="Email" required>
                                        <input type="submit" name="email_send" value="Send" class="prnt_sbmt">
                                    </div>
                                </div>
                            </form>
                            <a href="<?php echo base_url() . 'index.php/sell/index'; ?>" class="prnt_sbmt_done"
                               style="width: ">Done</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- page end-->
    </section>
    <!-- Add Brand : Modal -->
</section>
<style>
    #printableArea {
        /*display: none;*/
    }
</style>

<script type="text/javascript"> setTimeout(function () {
        $('#msg').hide();
    }, 30000); </script>

<?php include('footer.php'); ?>

