<?php include('header.php');?>
<style type="text/css">
    .order_status{
        width: 100%;
    }
    .otp{
        background: #004e00;
    }
    .otp:hover{
        background: #004e00;

    }
    #order-status .modal-content {
        padding:15px;
    }
    #order-status .modal-dialog {
        top: 50%;
        transform: translateY(-50%);
    }
    #order-status th {
        text-transform: capitalize;
        color: #787878;
    } 
    #order-status table, th, td {
        border:1px solid #ccc;
        padding: 10px;
        text-transform: capitalize;
    }
    #order-status h4 {
        text-transform: capitalize;
        margin-bottom: 20px;
        font-size: 40px;
        color: #000;
    } 
    #order-status table {
        width: 100%;
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
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/index'; ?>">Home</a> / Order</a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>

        <div id="msg">
            <?php if ($this->session->flashdata('msg') && $this->session->flashdata('msg') != '') { ?>
                <div class="alert alert-success fade in">
                    <strong>Success!</strong> <?php echo $this->session->flashdata('msg');; ?>
                </div>
            <?php } ?>
             <?php if ($this->session->flashdata('myMessage') && $this->session->flashdata('myMessage') != '') { 
                echo $this->session->flashdata('myMessage');
             } ?>
           
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading"> Order</header>
                <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="from_date" class="margin_top_label">From Date :<span class="required" aria-required="true"> </span></label>
                                        <input name="from_date" id="from_date" class="form-control form-control-inline input-medium default-date-picker " size="16" type="text" required="" placeholder="Select Date" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="to_date" class="margin_top_label">To Date :<span class="required" aria-required="true"> </span></label>
                                        <input name="to_date" id="to_date" class="form-control form-control-inline input-medium default-date-picker" size="16" type="text" required="" placeholder="Select Date" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="to_date" class="margin_top_label">Order Staus :<span class="required" aria-required="true"></span></label>
                                        <select class="form-control margin_top_input" id="order_status">
                                            <option value="" >Select Order Status</option>
                                            <option value="1">NEW</option>
                                            <option value="2">Pending</option>
                                            <option value="3">Ready</option>
                                            <option value="4">Pickup</option>
                                            <option value="5">On the way</option>
                                            <option value="8">Delevered</option>
                                            <option value="9">cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                  <input type="button" class="btn btn-danger pull-right margin_top_label" id="reload" value="Reset">
                                  &nbsp
                                  <input type="button" class="btn btn-info pull-right margin_top_label" id="Search" value="Search">
                            </div>
                        </div>
                    <div class="panel-body">
                        <div class="adv-table">
                             <button type="button" class="btn btn-warning" id="download">Download Report</button>
                            <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                               <!--  <div class="panel-body padding-zero" style="float: right">
                                    <a href="#" id="delete_user" class="btn btn-danger">Delete Order</a>
                                </div> -->
                                <table class="display table table-bordered table-striped dataTable" id="example_order" aria-describedby="example_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Rendering engine: activate to sort column ascending"
                                            style="width: 100px;">User Address
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                                   rowspan="1" colspan="1"
                                                   aria-label="Rendering engine: activate to sort column ascending"
                                                   style="width: 100px;">Order No
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 180px;">Order Date
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 220px;">Username
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 100px;">Total Amount
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 120px;">Payment Type
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 120px;">Order Status
                                        </th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>
</div>
<!--main content end-->
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<?php include('footer.php'); ?>