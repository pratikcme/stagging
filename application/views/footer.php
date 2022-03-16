<!--footer start-->
<footer class="site-footer">
    <div class="text-center">
        <?php $current_year = date('Y'); ?>
        Copyright - <?php echo $current_year; ?> | Grocery by CMExpertise Infotech Pvt Ltd
    </div>
    <!--  <a href="#" class="go-top">
         <i class="fa fa-angle-up"></i>
     </a> -->
    </div>
    <input type="hidden" name="base_url" id="base_url" value="<?php  echo base_url();?>">
    <input type="hidden" name="url" id="url" value="<?php  echo base_url();?>">

</footer>
<!--footer end-->
</section>
<?php
if (@$myhidejs != 1) { ?>
    <script src="<?php echo base_url(); ?>public/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>

<?php } ?>
<script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>

<script type="text/javascript"
        src="<?php echo base_url(); ?>/public/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript"
        src="<?php echo base_url(); ?>/public/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>/public/js/advanced-form-components.js"></script>

<script class="include" type="text/javascript"
        src="<?php echo base_url(); ?>public/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url(); ?>public/js/fileinput.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.nicescroll.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>public/js/jquery.sparkline.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.easy-pie-chart.js"></script>
<script src="<?php echo base_url(); ?>public/js/owl.carousel.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.customSelect.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/respond.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url(); ?>public/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>public/js/DT_bootstrap.js"></script>

<script src="<?php echo base_url(); ?>public/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/common-scripts.js"></script>

<script src="<?php echo base_url(); ?>public/js/advanced-form-components.js"></script>
<script type="text/javascript"
        src="<?php echo base_url(); ?>public/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript"
        src="<?php echo base_url(); ?>public/assets/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script type="text/javascript"
        src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>

<!--script for this page-->
<script src="<?php echo base_url(); ?>public/js/sparkline-chart.js"></script>
<script src="<?php echo base_url(); ?>public/js/easy-pie-chart.js"></script>
<script src="<?php echo base_url(); ?>public/js/count.js"></script>

<script src="<?php echo base_url(); ?>public/assets/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>public/admin/assets/js/ckeditor/ckeditor.js"></script>

  <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.js" type="text/javascript"></script>
<script type="text/javascript">
  $(document).on('change','.change-vendor',function (){
    var url = $('#url').val();
    var vendor_id  = $(this).val();
    // alert(vendor_id);
    if(vendor_id != ''){
      $.ajax({
        url: url+"admin/AccessVendor",
        type:'post',
        data : {vendor_id : vendor_id},
        success:function(output){
          window.location.href = url+"admin/dashboard";
        }
      })
    }
  })
</script>

<?php
if (!empty($js)) {
    foreach ($js as $value) {
        ?>
        <script src="<?php echo base_url(); ?>public/admin/assets/admins/js/<?php echo $value ?>"
        type="text/javascript"></script>
        <?php
    }
}
?>
<script>
    jQuery(document).ready(function () {
       
<?php
if (!empty($init)) {
    foreach ($init as $value) {
        echo $value . ';';
    }
}
?>
    });
</script>
<?php
if (!empty($table_js)) {
    foreach ($table_js as $value) {
        ?>
        <script src="<?php echo base_url(); ?>public/admin/assets/tablejs/<?php echo $value ?>"
        type="text/javascript"></script>
        <?php
    }
}
?>
<script>
    jQuery(document).ready(function () {
       
<?php
if (!empty($start)) {
    foreach ($start as $value) {
        echo $value . ';';
    }
}
?>
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
      // stock_control/view_stock_control_list
       $('#example_stock').DataTable( {
        order: ['5', 'asc'],
        "oLanguage": {
            "sEmptyTable": "Product Not Available",
            "sZeroRecords": "Product Not Available",
        }
      });

       $('#example_delivery').DataTable( {
        order: ['5', 'asc'],
        "oLanguage": {
            "sEmptyTable": "delivery user Not Available",
            "sZeroRecords": "delivery user Not Available",
        }
      });


        $('#example_order_summary').dataTable({
            order: ['5', 'asc'],
            "oLanguage": {
            "sEmptyTable" : "Order Summary Not Available",
            "sZeroRecords": "Order Summary Not Available",
        }
        });


        $('#example_o').dataTable({
            order: ['5', 'asc'],
            "oLanguage": {
            "sEmptyTable" : "Order list Not Available",
            "sZeroRecords": "Order Not Available",
        }
        });

        $('#example_subscriber').dataTable({
            order: ['4', 'asc'],
            "oLanguage": {
            "sEmptyTable" : "Subscriber Not Available",
            "sZeroRecords": "Subscriber Not Available",
          }
        });

        $('#display-address').click(function () {

            var a;

            var base_url = $('#base_url').val();

            

            if($(this).prop("checked") == true){

                a = 1;

            }
            else if($(this).prop("checked") == false){

                a = 0;

            }

            $.ajax({
              url : base_url+'admin/change_delivery_type',
              type : 'post',
              data : {
                status : a
              },
              success:function () {
              }
            })
          });


    });
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
<script type="text/javascript">
     var bardata = [];
var timeUnit = document.getElementsByClassName('time-unit')[0];
var btn = document.getElementsByTagName('button');
var chart = document.getElementById('chart');

function createSampleData(timeframe){
  for (var i=0; i < timeframe; i++) {
    bardata.push(Math.round(Math.random()*90)+10)
  }
  generateChart();
}
function generateChart(){
  var margin = {
    top:20,
    right:40,
    bottom:20,
    left:40
  }
  var height = 400 - margin.top - margin.bottom,
      width = 825 - margin.right - margin.right,
      barWidth = 50,
      barOffset = 5;

  // var colors = d3.scale.linear()
  // .domain([0, bardata.length*.33, bardata.length*.66, bardata.length])
  // .range(['#B58929','#C61C6F', '#268BD2', '#85992C'])
  var colorScale = d3.scale.linear()
      .domain([d3.min(bardata), d3.max(bardata)])
      // .domain([0, d3.max(bardata)])
      .range(["#2bd3fc", "#2b5cfc"]);
  
  var yScale = d3.scale.linear()
          .domain([0, d3.max(bardata)])
          .range([0, height]);

  var xScale = d3.scale.ordinal()
          .domain(d3.range(0, bardata.length))
          .rangeBands([0, width], 0.06);
  // var xScale = d3.time.scale()
  //            .domain([new Date(2016, 4, 8), new Date(2017, 3, 7)])
  //            .range([0, width]);

  var tooltip = d3.select('body').append('div')
          .style('position', 'absolute')
          .style('padding', '4px 8px')
          .style('background', 'white')
          .style('opacity', 0);

  var myChart = d3.select('#chart').append('svg')
      .style('background', '#ffffff')
      .style('border-radius','3px')
      .attr('width', width + margin.left + margin.right)
      .attr('height', height + margin.top + margin.bottom)
      .append('g')
      .attr('transform', 'translate('+ margin.left+', '+ margin.top +')')
      .selectAll('rect').data(bardata)
      .enter().append('rect')
          .attr('fill', function(d) {
              return colorScale(d);
          })
          // .style('fill', '#002f6c')
          .attr('width', xScale.rangeBand())
          .attr('x', function(d,i) {
              return xScale(i);
          })
          .attr('height', 0)
          .attr('y', height)

      .on('mouseover', function(d) {

          tooltip.transition()
              .style('opacity', .9)

          tooltip.html(d)
              .style('left', (d3.event.pageX - 15) + 'px')
              .style('top',  (d3.event.pageY - 30) + 'px')


          // tempColor = this.style.fill;
          d3.select(this)
              .style('opacity', .5)
              // .style('fill', 'yellow')
      })

      .on('mouseout', function(d) {
          d3.select(this)
              .style('opacity', 1)
        
        tooltip.transition()
          .style('opacity', 0)
              // .style('fill', tempColor)
      })

  myChart.transition()
      .attr('height', function(d) {
          return yScale(d);
      })
      .attr('y', function(d) {
          return height - yScale(d);
      })
      .delay(function(d, i) {
          return i * 20;
      })
      .duration(400)
      .ease('linear')

  var vGuideScale = d3.scale.linear()
      .domain([0, d3.max(bardata)])
      .range([height, 0])

  var vAxis = d3.svg.axis()
      .scale(vGuideScale)
      .orient('left')
      .ticks(10)

  var vGuide = d3.select('svg').append('g');
      vAxis(vGuide);
      vGuide.attr('transform', 'translate(' + margin.left +', ' + margin.top + ')');
      vGuide.selectAll('path')
          .style({ fill: 'none', stroke: "#000"});
      vGuide.selectAll('line')
          .style({ stroke: "#000"});

  var hAxis = d3.svg.axis()
      .scale(xScale)
      .orient('bottom')
      // .tickValues(xScale.domain().filter(function(d, i) {
      //     return !(i % (bardata.length/12));
      // }))
      .tickValues(xScale.domain())
      .tickFormat(function(d){return d+1;});
      // .ticks(d3.time.months)
      // .tickSize(16,0)
      // .tickFormat(d3.time.format('%B'));

  var hGuide = d3.select('svg').append('g')
      hAxis(hGuide)
      hGuide.attr('transform', 'translate(' + margin.left +', ' + (height + margin.top) + ')')
      hGuide.selectAll('path')
          .style({ fill: 'none', stroke: "#000"})
      hGuide.selectAll('line')
          .style({ stroke: "#000"})
  
  for(var i = 0; i < btn.length; i++){
    btn[i].addEventListener('click', getButtonValue);
  }
  
  function getButtonValue(){
    var val = this.value;
    var unit = this.innerHTML;
    reload(val, unit);
  }
  
  function reload(val, unit){
    d3.select('svg').remove();
     // d3.selectAll(tooltip).remove();
    //tooltip.selectAll("*").remove();
    tooltip.remove();
    bardata = [];
    load(val, unit)
  }
}

function load(dataPoints, unit){
  createSampleData(dataPoints);
  timeUnit.innerHTML = unit;
}

window.onload = load(12, 'Yearly');
</script>




<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<script type="text/javascript">
  am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create("chartdivs", am4charts.XYChart);
chart.padding(40, 40, 40, 40);

var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.dataFields.category = "network";
categoryAxis.renderer.minGridDistance = 1;
categoryAxis.renderer.inversed = true;
categoryAxis.renderer.grid.template.disabled = true;

var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
valueAxis.min = 0;

var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.categoryY = "network";
series.dataFields.valueX = "MAU";
series.tooltipText = "{valueX.value}"
series.columns.template.strokeOpacity = 0;
series.columns.template.column.cornerRadiusBottomRight = 5;
series.columns.template.column.cornerRadiusTopRight = 5;

var labelBullet = series.bullets.push(new am4charts.LabelBullet())
labelBullet.label.horizontalCenter = "left";
labelBullet.label.dx = 10;
labelBullet.label.text = "{values.valueX.workingValue.formatNumber('#.0as')}";
labelBullet.locationX = 1;

// as by default columns of the same series are of the same color, we add adapter which takes colors from chart.colors color set
series.columns.template.adapter.add("fill", function(fill, target){
  return chart.colors.getIndex(target.dataItem.index);
});

categoryAxis.sortBySeries = series;
chart.data = [
    {
      "network": "Facebook",
      "MAU": 25
    },
    {
      "network": "Google+",
      "MAU": 10
    },
    {
      "network": "Instagram",
      "MAU": 5
    },
    {
      "network": "Pinterest",
      "MAU": 15
    },
    {
      "network": "Reddit",
      "MAU": 10
    }
    
  ]



}); 
</script>

</body>
</html>