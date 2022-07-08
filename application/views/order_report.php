<?php include('header.php');?>
<style type="text/css">
 .required{
         color: red;
         }
</style>
<!--main content start-->

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/multi-select.css">

<section id="main-content">
    <section class="wrapper">
        
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                        Order Report Date
                    </header>
                    <form id="brand_form" role="form" method="post" action="<?php echo base_url().'order/order_report'; ?>">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Select Date :<span class="required" aria-required="true"> * </span></label>
                                        <input name="orderReportDate" class="form-control form-control-inline input-medium default-date-picker valid" size="16" type="text" value="<?=($date != '') ? $date : date('m/d/Y')?>" required="" placeholder="Order Report Date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                  <a href="<?=base_url().'admin/dashboard'?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>  
                                  <input type="submit" class="btn btn-info pull-right margin_top_label" value="submit" name="submit">
                            </div>
                        </div>
                    </form>
                    <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">Order Report</header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <table class="display table table-bordered table-striped dataTable" id="example_order_report"
                                       aria-describedby="example_info">
                                    <?php foreach ($report as $value){ ?>
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting text-center" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="3"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;"><?=$value->name?>
                                        </th>
                                        <!-- <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Weight and quantity
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Total
                                        </th> -->
                                    </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                        <td class="sorting text-center" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;" >Varient
                                        </td>
                                        <td class="sorting text-center" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Quantity
                                        </td>
                                        <td class="sorting text-center" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Total
                                        </td>
                                    <?php foreach ($value->productDetails as $result){ ?>
                                        <tr class="gradeX odd">                      
                                            <td class="hidden-phone text-center"><?=$result->weight_no.' '.$result->weight_name; ?> </td>
                                            <td class="hidden-phone text-center"><?=$result->quantity?></td>
                                            <td class="hidden-phone text-center"><?=$result->weight_no*$result->quantity.' '.$result->weight_name?> </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
                </section>
            </div>
            <!--Map Part-->
        </div>
        <!-- page end-->
    </section>
    <input type="hidden" id="base_url" value="<?=base_url()?>">
</section>
<!--main content end-->
<style> label.error { color: red; font-weight: 500; } </style>
<script src="<?php echo base_url(); ?>public/js/jquery-3.2.1.min.js"></script>

<script type="text/javascript">
$('#category_id').change(function(){

    $('#category_id-error').hide();
});
 $('.date').datepicker({
    format: 'dd/mm/yyyy'
 });
</script>
<?php include('footer.php'); ?>