<?php
include('header.php');
$user_id = $this->session->userdata('id');
$branch_id = $this->session->userdata('id');

$order_query = $this->db->query("SELECT po.*, c.customer_name, v.name as vendor_name FROM `parked_order` as po
                                    LEFT JOIN branch as v ON v.id = po.branch_id
                                    LEFT JOIN customer as c ON c.id = po.customer_id
                                    WHERE po.status = '1' AND po.branch_id = '$branch_id' ORDER BY po.id DESC ");
$order_row = $order_query->result();
?>
    <style>

        .panel-heading {
            background:#5b6e84;
            font-size: 16px;
            font-weight: 300;
            color: white;
        }
        .btn-primary {
            background-color: #41cac0 !important;
            border-color: #41cac0 !important;
            color: #FFFFFF !important;
        }
        .btn-info.btn-info:hover, .btn-info:focus, .btn-info:active, .btn-info.active, .open .dropdown-toggle.btn-info {
            background-color: #53bee6 !important;
            border-color: #53BEE6 !important;
            color: #ffffff !important;
        }

        .btn-primary {
            margin-bottom: 3px;
            margin-top: 3px;
        }
    </style>
    <section id="main-content">
        <section class="wrapper site-min-height">
            <!-- page start-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Parked Sell History
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">

                                    <div class="panel-body" style="float: right">
                                    </div>

                                    <table class="display table table-bordered table-striped dataTable" id="example_parked"
                                           aria-describedby="example_info">
                                        <thead>
                                        <tr role="row">

                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Sold By</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Customer</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Sub-Total</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Discount(%)</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Discount Price</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Total</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Date</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody role="alert" aria-live="polite" aria-relevant="all">

                                        <?php foreach ($order_row as $order){ ?>

                                            <tr class="gradeX odd">

                                                <td class=""><?php echo $order->vendor_name; ?></td>
                                                <td class=""><?php echo $order->customer_name; ?></td>
                                                <td class=""><?php echo $order->total; ?></td>
                                                <td class=""><?php echo $order->order_discount; ?></td>
                                                <td class=""><?php echo $order->total_saving;?></td>
                                                <td class=""><?php echo $order->payable_amount; ?></td>
                                                <td class=""><?php echo date('Y-m-d H:i:s', $order->dt_added); ?></td>
                                                <td class="">
                                                    <a href="javascript:;" onclick="single_delete(<?php echo $order->id; ?>)" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                                                    <a href="<?php echo base_url().'parked_sell/sales_history_view?type=park&order_id='.base64_encode($order->id); ?>" class="btn btn-primary btn-xs">view</a>
                                                    <a href="<?php echo base_url().'sell/index?parkedId='.base64_encode($order->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-check-square "></i></a>
                                                </td>
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
    <script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript">
        setTimeout( function(){$('#msg').hide();} , 4000);

        $(document).ready(function() {
            oTable = $('#example_parked').dataTable({
                "aaSorting": [[8,'desc']],
                "oLanguage": {
                  "sEmptyTable":"Parked Sell History Not Available",
                  "sZeroRecords": "Parked Sell History Not Available",
                }
            });
        });
        /*Single Delete Script*/
        function single_delete(value) {

            bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
                if (confirmed == true) {

                    var id = value;

                    $.ajax({
                        url: '<?php echo base_url().'index.php/sell/single_delete_sales_history/'; ?>' ,
                        data: {
                            ids: id.toString(),
                            url: '<?php echo base_url().'index.php/sell/single_delete_sales_history/'; ?>' ,
                        },
                        success: function (data) {

                            if (data.status == 1) {
                                bootbox.alert("Sales history has been deleted successfully.", function() {
                                    window.location.reload(true);
                                });
                            }
                            else {
                                alert('Failed to delete selected sales history.');
                            }
                        },
                        error: function () {
                            alert('Failed to delete selected sales history.');
                        }
                    });
                }
                else
                {
                    window.location.reload(true);
                }
            });
        }
    </script>
<?php include('footer.php'); ?>