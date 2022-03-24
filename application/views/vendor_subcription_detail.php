<?php include('header.php'); ?>

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
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home /</a> Subscription Detail</a> </li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>

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
                                            style="width: 200px;">Sr No.
                                        </th>
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
                                    <?php $i=1;
                                    foreach ($subscription_result  as $result){

                                        ?>
                                        <tr class="gradeX odd">
                                            <td class="dsad"><?php echo $i;$i++; ?></td>
                                            <td class="qty"><?php echo $result->start_date; ?></td>
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