<?php
include('header.php');
date_default_timezone_set('Asia/Calcutta');
?>

<style>
    .panel-heading {
        background: #5b6e84;
        font-size: 16px;
        font-weight: 300;
        color: white;
    }
</style>
<section id="main-content">
    <section class="wrapper site-min-height">
            <!-- page start-->
            <div id="msg">
                <?php if($this->session->flashdata('msg') && $this->session->flashdata('msg') != ''){ ?>
                    <div class="alert alert-success fade in">
                        <strong>Success!</strong> <?php echo $this->session->flashdata('msg');; ?>
                    </div>
                <?php } unset($this->session->flashdata); ?>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Register Closures
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">

                                    <div class="panel-body padd_rght_0" style="float: right">
                                        <a href="<?php echo base_url() . 'index.php/register/register_closures_export/'; ?>"
                                           class="btn btn-primary btn-lg">Export List</a>
                                    </div>

                                    <table class="display table table-bordered table-striped dataTable" id="example"
                                           aria-describedby="example_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Register No.</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Time Opened</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Time Closed</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Cash</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Credit Card</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Store Credit</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody role="alert" aria-live="polite" aria-relevant="all">

                                        <?php $c = 1; foreach ($result as $type){ ?>

                                            <tr class="gradeX odd">
                                                <td class=""><?php echo $c++; ?></td>
                                                <td class=""><a href="<?php echo base_url().'index.php/register/closure_summary?id='.$type->id; ?>" ><?php echo date('Y-m-d H:i:s', $type->opening_time); ?></a></td>
                                                <td class=""><?php if($type->closing_time == '0' || $type->closing_time == ''){ echo "Still Open"; } else { echo date('Y-m-d H:i:s', $type->closing_time); } ?></td>
                                                <td class=""><?php echo $type->counted; ?></td>
                                                <td class=""><?php echo $type->credit_card_counted; ?></td>
                                                <td class=""><?php echo $type->store_credit_counted; ?></td>
                                                <td class=""><?php echo number_format($type->counted + $type->credit_card_counted + $type->store_credit_counted, 2); ?></td>

                                            </tr>

                                        <?php } ?>

                                        </tbody>
                                    </table>
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