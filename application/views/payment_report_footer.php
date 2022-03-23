<!--footer start-->
<style>
    .custom-bar-chart-payment .bar2 .value2:hover {
        background: #e8403f;
        color: #fff;
    }
</style>
<footer class="site-footer">
    <?php
    $email_client = $this->session->userdata['email_client'];
    $query = $this->db->query("SELECT * FROM user WHERE email = '$email_client'");
    $result = $query->result();

    $dt_added = date('Y-m-d', $result[0]->dt_added);
    $expire_date_strtotime = date($dt_added, strtotime("+30 days"));
    $expire_date = date('Y-m-d', strtotime($expire_date_strtotime . " +30 days"));
    $today_date = date('Y-m-d');

    $from=date_create("$expire_date");
    $to=date_create("$today_date");
    $diff=date_diff($to, $from);

    $difference = $diff->format('%a');

//    $payment_query = $this->db->query("SELECT payment_status FROM payments WHERE user_id = '$user_id'");
//    $payment_result = $payment_query->result();
//
//    if(!empty($payment_result) && $payment_result[0]->payment_status == '1'){ ?>
<!--        <div class="text-center"> --><?php //echo date('Y'), " &copy; POS"; ?><!-- </div>-->
<!--    --><?php //}else{
//
//        if($today_date <= $expire_date){ ?>
<!--            <div class="text-center">-->
<!--                You have --><?php //echo $difference; ?><!-- days left on your trial. <a href="--><?php //echo base_url().'index.php/setting/activate'; ?><!--" style="color: #ffffff;text-decoration: underline;">Activate your account now.</a>-->
<!--            </div>-->
<!--        --><?php //}else{ ?>
<!--            <div class="text-center">-->
<!---->
<!--            </div>-->
<!--        --><?php //}
//    }?>

    <a href="#" class="go-top">
        <i class="fa fa-angle-up"></i>
    </a>
    </div>
</footer>
<!--footer end-->
</section>

<!-- js placed at the end of the document so the pages load faster -->
<!-- 12-07-2016 -->
<script src="<?php echo base_url(); ?>/public/js/jquery.js"></script>
<!-- 12-07-2016 -->
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>

<!-- Start :  12-07-2016 -->
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/jquery-multi-select/js/jquery.quicksearch.js"></script>
<script src="<?php echo base_url(); ?>/public/js/advanced-form-components.js"></script>
<!-- End : 12-07-2016 -->

<script class="include" type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/forscroll.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>public/js/scroll.js" type="text/javascript"></script>

<!--<script src="--><?php //echo base_url(); ?><!--public/js/jquery.nicescroll.js" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>public/js/jquery.sparkline.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>public/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script src="<?php echo base_url(); ?>public/js/owl.carousel.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.customSelect.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/respond.min.js"></script>
<script class="include" type="text/javascript"
        src="<?php echo base_url(); ?>public/js/jquery.dcjqaccordion.2.7.js"></script>
<!--common script for all pages-->
<script src="<?php echo base_url(); ?>/public/assets/file-input/fileinput.js"></script>
<script src="<?php echo base_url(); ?>public/js/common-scripts.js"></script>

<!--script for this page-->
<script src="<?php echo base_url(); ?>public/js/sparkline-chart.js"></script>
<script src="<?php echo base_url(); ?>public/js/easy-pie-chart.js"></script>
<script src="<?php echo base_url(); ?>public/js/count.js"></script>
<script src="<?php echo base_url(); ?>public/assets/bootbox/bootbox.min.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript"
        src="<?php echo base_url(); ?>public/assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/assets/data-tables/DT_bootstrap.js"></script>
<!--<script src="<?php echo base_url(); ?>public/js/advanced-form-components.js"></script>-->
<!-- END : Data Tables JS  -->

<!-- js for date picker -->

<script type="text/javascript"
        src="<?php echo base_url(); ?>public/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript"
        src="<?php echo base_url(); ?>public/assets/bootstrap-daterangepicker/moment.min.js"></script>

<!-- js for date picker ends here -->

<!-- neel  -->

<script type="text/javascript"
        src="<?php echo base_url(); ?>public/assets/ckeditor/ckeditor.js"></script> <!-- CKEditor  -->
<script type="text/javascript"
        src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script> <!-- Tag Input  -->


<script src="http://cmexpertiseinfotech.in/pos_user/public/js/common-scripts.js"></script>





<script>

    //owl carousel

    $(document).ready(function () {
        $("#owl-demo").owlCarousel({
            navigation: true,
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true,
            autoPlay: true

        });
    });

    //custom select box

    $(function () {
        $('select.styled').customSelect();
    });

    $(document).ready(function () {
        $('#example').dataTable({
            "aaSorting": [[4, "desc"]]
        });
    });

    // neel

    $("#file-1").fileinput({
        uploadUrl: '#', // you must set a valid URL here else you will get an error
        allowedFileExtensions: ['jpg', 'png', 'gif', 'tif',],
        overwriteInitial: false,
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
    });

    // neel

</script>
<SCRIPT type="text/javascript">
    //    window.history.forward();
    //    function noBack() { window.history.forward(); }
</SCRIPT>

</body>
</html>