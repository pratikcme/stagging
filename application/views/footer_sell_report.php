<!--footer start-->

<footer class="site-footer">
    <div class="text-center">

                <div class="text-center">
                    <?php echo date('Y')." &copy; POS"; ?>
                </div>

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
<script type="text/javascript" src="<?php echo base_url(); ?>/public/js/bootstrap-datepicker.min.js"></script>
<!--<script type="text/javascript" src="<?php /*echo base_url(); */?>/public/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/public/assets/jquery-multi-select/js/jquery.quicksearch.js"></script>
<script src="<?php echo base_url(); ?>/public/js/advanced-form-components.js"></script>
<!-- End : 12-07-2016 -->
<script class="include" type="text/javascript" src="<?php echo base_url(); ?>public/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/morris.js-0.4.3/morris.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>/public/assets/morris.js-0.4.3/raphael-min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.sparkline.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>public/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script src="<?php echo base_url(); ?>public/js/owl.carousel.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.customSelect.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/respond.min.js"></script>

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
<script src="<?php echo base_url(); ?>public/js/advanced-form-components.js"></script>
<!-- END : Data Tables JS  -->

<!-- js for date picker -->

<!--<script type="text/javascript"
        src="<?php /*echo base_url(); */?>public/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>-->
<script type="text/javascript"
        src="<?php echo base_url(); ?>public/assets/bootstrap-daterangepicker/moment.min.js"></script>

<!-- js for date picker ends here -->



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

    <script type="text/javascript">
    <!-- script for this page only-->
    var Script = function () {

    //morris chart

    $(function () {
      // data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type
      var tax_data = [
           {"period": "2011 Q3", "licensed": 3407, "sorned": 660},
           {"period": "2011 Q2", "licensed": 3351, "sorned": 629},
           {"period": "2011 Q1", "licensed": 3269, "sorned": 618},
           {"period": "2010 Q4", "licensed": 3246, "sorned": 661},
           {"period": "2009 Q4", "licensed": 3171, "sorned": 676},
           {"period": "2008 Q4", "licensed": 3155, "sorned": 681},
           {"period": "2007 Q4", "licensed": 3226, "sorned": 620},
           {"period": "2006 Q4", "licensed": 3245, "sorned": null},
           {"period": "2005 Q4", "licensed": 3289, "sorned": null}
      ];
      // Morris.Line({
      //   element: 'hero-graph',
      //   data: tax_data,
      //   xkey: 'period',
      //   ykeys: ['licensed', 'sorned'],
      //   labels: ['Licensed', 'Off the road'],
      //   lineColors:['#8075c4','#6883a3']
      // });

      Morris.Donut({
        element: 'hero-donut',
        data: [
          {label: 'Jam', value: 25 },
          {label: 'Frosted', value: 40 },
          {label: 'Custard', value: 25 },
          {label: 'Sugar', value: 10 }
        ],
          colors: ['#41cac0', '#49e2d7', '#34a39b'],
        formatter: function (y) { return y + "%" }
      });

      Morris.Area({
        element: 'hero-area',
        data: [
          {period: '2010 Q1', iphone: 2666, ipad: null, itouch: 2647},
          {period: '2010 Q2', iphone: 2778, ipad: 2294, itouch: 2441},
          {period: '2010 Q3', iphone: 4912, ipad: 1969, itouch: 2501},
          {period: '2010 Q4', iphone: 3767, ipad: 3597, itouch: 5689},
          {period: '2011 Q1', iphone: 6810, ipad: 1914, itouch: 2293},
          {period: '2011 Q2', iphone: 5670, ipad: 4293, itouch: 1881},
          {period: '2011 Q3', iphone: 4820, ipad: 3795, itouch: 1588},
          {period: '2011 Q4', iphone: 15073, ipad: 5967, itouch: 5175},
          {period: '2012 Q1', iphone: 10687, ipad: 4460, itouch: 2028},
          {period: '2012 Q2', iphone: 8432, ipad: 5713, itouch: 1791}
        ],

          xkey: 'period',
          ykeys: ['iphone', 'ipad', 'itouch'],
          labels: ['iPhone', 'iPad', 'iPod Touch'],
          hideHover: 'auto',
          lineWidth: 1,
          pointSize: 5,
          lineColors: ['#4a8bc2', '#ff6c60', '#a9d86e'],
          fillOpacity: 0.5,
          smooth: true
      });

      Morris.Bar({
        element: 'hero-bar',
                       data: [
                            <?php         
                                   foreach($row_yearwise as $row)
                                  {
                            ?>
                                  {device: '<?php echo $row->name.' '.$row->weight_no.' '.$row->variant ;?>', Product:<?php echo $row->product_price; ?>},
                            <?php
                                  }
                            ?>
                          ],
                 
        xkey: 'device',
        ykeys: ['Product'],
        labels: ['Total Price'],
        barRatio: 0.4,
        xLabelAngle: 35,
        hideHover: 'auto',
        barColors: ['#6883a3']
      });

      Morris.Bar({
        element: 'hero-bar1',
                       data: [
                            <?php         
                                   foreach($row_remaining_quantity  as $row)
                                  {
                            ?>
                                  {device: '<?php echo $row->name.' '.$row->weight_no.' '.$row->variant ;?>', Product:<?php echo $row->product_quantity; ?>},
                            <?php
                                  }
                            ?>
                          ],
                 
        xkey: 'device',
        ykeys: ['Product'],
        labels: ['Qunatity'],
        barRatio: 0.4,
        xLabelAngle: 35,
        hideHover: 'auto',
        barColors: ['#39b7ac']
      });


      new Morris.Line({
        element: 'examplefirst',
        xkey: 'year',
        ykeys: ['value'],
        labels: ['Value'],
        data: [
          {year: '2008', value: 20},
          {year: '2009', value: 10},
          {year: '2010', value: 5},
          {year: '2011', value: 5},
          {year: '2012', value: 20}
        ]
      });

      $('.code-example').each(function (index, el) {
        eval($(el).text());
      });
    });

}();



</script>


</body>
</html>