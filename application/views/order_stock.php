<?php include('header.php');

$vendor_id = $this->session->userdata('id');
$res_order_id = $this->db->query("select * from new_stock where order_id='" . $_GET['order_id'] . "'");
$row_order_id = $res_order_id->result();

$orderid = $_GET['order_id'];
?>

    <section id="main-content">


        <section class="wrapper">

            <header class="panel-heading">Current Order Details</header>

            <p class="sub_title"></p>

            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">

                <div class="customer">
                    <div class="form-group">
                        <input type="hidden" name="OrderId" value="<?php echo $row_order_id['0']->order_id; ?>"/>
                        <label for="">Order Name :- </label>
                        <label><?php echo $row_order_id['0']->order_name; ?></label>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="OrderId" value="<?php echo $row_order_id['0']->order_id; ?>"/>
                        <label for="">Order Number :- </label>
                        <label><?php echo $row_order_id['0']->order_no; ?></label>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="OrderId" value="<?php echo $row_order_id['0']->order_id; ?>"/>
                        <label for="">Order Date :- </label>
                        <label><?php echo $row_order_id['0']->current_date; ?></label>
                    </div>
                </div>

            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">

                <div class="customer">


                    <div class="form-group">
                        <input type="hidden" name="OrderId" value="<?php echo $row_order_id['0']->order_id; ?>"/>
                        <label for="">Delivery Date :- </label>
                        <label><?php echo $row_order_id['0']->deliver_date; ?></label>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="OrderId" value="<?php echo $row_order_id['0']->order_id; ?>"/>
                        <label for="">Supplier Invoice Number :- </label>
                        <label><?php echo $row_order_id['0']->supplier_invoice; ?></label>
                    </div>


                </div>

            </div>
        </section>

        <section class="wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Search Product
                        </header>
                        <div class="form-group">
                            <div class="input-group search_1">
                                <!-- <span class="input-group-addon"> Search </span> -->
                                <input type="text" name="search_text" id="search_text"
                                       placeholder="Search By Product Name" class="form-group search_2"/>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="adv-table">
                                <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">

                                    <table class="display table table-bordered table-striped dataTable" id="example"
                                           aria-describedby="example_info">
                                        <thead>
                                        <tr role="row">

                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1"
                                                aria-label="Rendering engine: activate to sort column ascending"
                                                style="width: 305px;">Number
                                            </th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1"
                                                aria-label="Rendering engine: activate to sort column ascending"
                                                style="width: 305px;">Produt Name
                                            </th>

                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1"
                                                aria-label="Rendering engine: activate to sort column ascending"
                                                style="width: 305px;">Product Price
                                            </th>

                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1"
                                                aria-label="Rendering engine: activate to sort column ascending"
                                                style="width: 305px;">Cost
                                            </th>


                                        </tr>
                                        </thead>
                                        <tbody id="result" role="alert" aria-live="polite" class="order_sotck_data"
                                               aria-relevant="all">

                                        </tbody>


                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
        </section>

        <section class="wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Added Order
                        </header>

                        <div class="panel-body">
                            <div class="adv-table">
                                <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">

                                    <table class="display table table-bordered table-striped dataTable" id="example"
                                           aria-describedby="example_info">
                                        <thead>
                                        <tr role="row">

                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1"
                                                aria-label="Rendering engine: activate to sort column ascending"
                                                style="width: 305px;">Number
                                            </th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1"
                                                aria-label="Rendering engine: activate to sort column ascending"
                                                style="width: 305px;">Produt Name
                                            </th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1"
                                                aria-label="Rendering engine: activate to sort column ascending"
                                                style="width: 305px;">Product Quantity
                                            </th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1"
                                                aria-label="Rendering engine: activate to sort column ascending"
                                                style="width: 305px;">Product Price
                                            </th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                                rowspan="1" colspan="1"
                                                aria-label="Rendering engine: activate to sort column ascending"
                                                style="width: 305px;">Cost
                                            </th>

                                        </tr>
                                        </thead>
                                        <tbody id="" role="alert" aria-live="polite" class="order_sotck_data"
                                               aria-relevant="all">
                                        <?php
                                        $userid = $this->session->userdata('id');
                                        $res_added_order = $this->db->query("select * from add_stock_order where order_id='$orderid' and vendor_id='$vendor_id'");
                                        $row_added_order = $res_added_order->result();
                                        $i = '1';
                                        foreach ($row_added_order as $order_each) { ?>
                                            <input type="hidden" name="product_id" value="<?php echo $order_each->id; ?>">
                                            <tr class="gradeX odd ajax_search">
                                                <td class=""><?php echo $i++; ?></td>
                                                <td class=""><?php echo $order_each->product_name; ?></td>
                                                <td class=""><input type="text"
                                                                    value="<?php echo $order_each->product_quantity; ?>"
                                                                    class="quantity<?php echo $order_each->id; ?>"
                                                                    onkeyup="showId('<?php echo $order_each->id; ?>', '<?php echo $order_each->product_supply_price; ?>', '<?php echo $order_each->product_id; ?>')">
                                                </td>
                                                <td class=""><?php echo $order_each->product_supply_price; ?></td>
                                                <td class=""><label
                                                        class="event_rupee_total cost<?php echo $order_each->id; ?>"><?php echo $order_each->cost; ?></label>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                        </tbody>

                                    </table>
                                </div>

                                Total: <span class="total" id="total"></span>
                            </div>
                        </div>
                    </section>
        </section>


        <script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
        <style type="text/css">
            #example_filter {
                display: none;
            }
        </style>
        <script>

            var sum = 0;
            $('.event_rupee_total').each(function () {
                sum += +$(this).text() || 0;
            });
            var total_price = $("#total").text(parseFloat(sum).toFixed(2));

            function showId(obj, price, pro_id) {

                var id = obj; //id
                var qty = $(".quantity" + id).val(); //Qnty
                var final_price = qty * price; //final price
                var product_id = pro_id;

                $(".cost" + id).text(parseFloat(final_price).toFixed(2));

                var sum = 0;
                $('.event_rupee_total').each(function () {
                    sum += +$(this).text() || 0;
                });
                var total_price = $("#total").text(parseFloat(sum).toFixed(2));
                var fetch_total_price = $("#total").text();


                //On change update order tamp
                $.ajax({
                    url: '<?php echo base_url().'index.php/stock_control/edit_total_price/'; ?>',
                    data: {
                        id: id,
                        quantity: qty,
                        price: final_price,
                        product_id: product_id,
                        total_price: fetch_total_price,
                        order_id: '<?php echo $orderid; ?>',
                        url: '<?php echo base_url().'index.php/stock_control/edit_total_price/'; ?>'
                    },
                    success: function (data) {
                    }
                });
            }
        </script>
        <script type="text/javascript">

            function clickme(a, b, c) {

                var product_id = a;
                var product_name = b;
                var retail_price = c;
                $.ajax({
                    method: "post",
                    url: '<?php echo site_url('stock_control/add_stock_order'); ?>',
                    data: {
                        product_id: product_id,
                        product_name: product_name,
                        retail_price: retail_price,
                        order_id: '<?php echo $orderid; ?>'
                    },
                    success: function (data) {
                        $('#result').html(data);
                        location.reload();
                    }
                });

            }


        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#search_text').keyup(function () {
                    var txt = $(this).val();
                    if (txt != '') {
                        $.ajax({
                            method: "post",
                            url: '<?php echo site_url('stock_control/ajax_search_product'); ?>',
                            data: {search: txt},
                            success: function (data) {
                                $('#result').html(data);
                            }
                        });
                    }
                    else {
                        $('#result').html('');

                    }

                });
            });

        </script>
        </div>
        </div>

    </section>
    </section>
<?php include('footer.php'); ?>