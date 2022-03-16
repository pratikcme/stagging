<?php
// session_start();
include('header.php');
$user_id = $this->session->userdata('id');

?>

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
                            Products
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">

                                    <div class="panel-body padd_rght_0" style="float: right">

                                            <a href="<?php echo base_url() .'stock_control/order_stock_add'?>" class="btn btn-primary btn-lg">Order Stock </a>
                                            <a href="" class="btn btn-primary btn-lg">Return Stock</a>
                                    </div>

            <table class="display table table-bordered table-striped dataTable" id="example_stock"
                   aria-describedby="example_info">
                <thead>
                <tr role="row">
                    
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Order Name</th>
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Date</th>
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Delivery Due Date</th>
                    
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">OutLet</th>
                     <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Total Price of Order</th>
                 <!--    <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Source</th>
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;"> Items </th> -->
                    <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Action</th>
                </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                <?php
                
                            $res = $this->db->query("select * from new_stock where status != '9' AND vendor_id='$vendor_id'");
                            $product_row = $res ->result();
                ?>
                <?php foreach ($product_row as $product){ ?>

                    <tr class="gradeX odd">
                                
                                <td class=""><?php echo $product->order_name; ?></td>
                                <td class=""><?php echo $product->current_date; ?></td>
                                <td class=""><?php echo $product->deliver_date; ?></td>
                                <td class="">Main OutLet</td>
                                <td class=""><?php echo $product->total_price; ?></td>
                                <td class="">
                                    <a href="<?php echo base_url().'stock_control/order_stock?order_id='.$product->order_id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                                    <a href="javascript:;" onclick="single_delete_stock_order(<?php echo $product->order_id; ?>)" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                                </td>
             <!--   <td class="">8</td>
                <td class="">Rs.     2000</td> -->
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

    /*Single Delete Script*/
    function single_delete_stock_order(value) {

        bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
            if (confirmed == true) {
                var id = value;

                $.ajax({
                    method : "POST",
                    url: '<?php echo base_url().'stock_control/single_delete_stock_order/'; ?>',
                    data: {
                                ids: id.toString(),
                                url: '<?php echo base_url().'stock_control/single_delete_stock_order/'; ?>' 
                          },
                    success: function (data) {

                        if (data.status == 1) {
                            bootbox.alert("Stock Order has been deleted successfully.", function() {
                                window.location.reload(true);
                            });
                        }
                        else {
                            alert('Failed to delete selected Stock Order.');
                        }
                    },
                    error: function () {
                        alert('Failed to delete selected Stock Order.');
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