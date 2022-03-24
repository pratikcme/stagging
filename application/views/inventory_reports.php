<?php include('header.php'); ?>
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
                            Inventory Reports
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">

                                    <!-- <div class="panel-body padd_rght_0" style="float: right">
                                        <a href="<?php echo base_url() . 'index.php/register/inventory_reports_export/'; ?>"
                                           class="btn btn-primary btn-lg">Export List</a>
                                    </div> -->

                                    <table class="display table table-bordered table-striped dataTable" id="example_inventory"
                                           aria-describedby="example_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Sr. No</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Product</th> 
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Product Variant</th>
                                           
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Current Stock</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Stock Value</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Item Value</th>
                                        </tr>
                                        </thead>
                                        <tbody role="alert" aria-live="polite" aria-relevant="all">

                                        <?php $c = 1; foreach ($result as $pro){ ?>

                                            <tr class="gradeX odd">
                                                <td class=""><?php echo $c++; ?></td>
                                                <td class=""><?php echo $pro->name; ?></td>
                                                <td class=""><?php echo $pro->weight_no.' '.$pro->weight; ?></td>
                                           
                                                <td class=""><?php echo $pro->quantity; ?></td>
                                                <td class=""><?php echo ($pro->quantity * $pro->discount_price); ?></td>
                                                <td class=""><?php echo $pro->discount_price; ?></td>
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