<?php
include('header.php');
?>
    <style>
       label.error{
            color: red;
        }

        .display-records-table {
            background: #fff;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            margin-top: 50px !important;
        }

        .display-records-table-main .row {
            display: flex;
            justify-content: center;
        }
    </style>
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!-- page start-->
            <div id="msg">
                <?php if ($this->session->flashdata('myMessage') != '') { 
                        echo $this->session->flashdata('myMessage') ;
                 } ?>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb">
                        <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> /Import Excel </li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>
            <div class="display-records-table-main">
                <div class="row">
                    <!--Left Part-->
                    <div class="col-lg-6">
                       <table class="display table table-bordered table-striped dataTable no-footer display-records-table">
                           <thead>
                               <tr role="row">
                                   <th>Product name</th>
                                   <th>Weight Number</th>
                                   <th>Weight Name</th>
                                   <th>Package Name</th>
                                   <th>Price</th>
                                   <th>Quantity</th>
                                   <th>Discount per</th>
                                   <th>Discount price</th>
                               </tr>
                           </thead>
                           <tbody>
                            <?php foreach ($tempRecord as $key => $value): ?>
                               <tr role="row"> 
                                   <td><?=$value->name?></td>
                                   <td><?=$value->weight_no?></td>
                                   <td><?=$value->weight_name?></td>
                                   <td><?=$value->package_name?></td>
                                   <td><?=$value->price?></td>
                                   <td><?=$value->quantity?></td>
                                   <td><?=$value->discount_per?></td>
                                   <td><?=$value->discount_price?></td>
                               </tr>
                            <?php endforeach ?>
                           </tbody>
                       </table>
                        <div class="col-lg-6 ">
                            <div class="col-lg-3">
                                <a class="btn btn-danger" href="">Cancel</a>
                            </div>
                            <div class="col-lg-3">
                                 <a class="btn btn-primary" href="">AddRecord</a>
                            </div>
                        </div>
                    </div>
                    <!--Map Part-->
                </div>
            </div>
            
            <!-- page end-->
        </section>
    </section>
<?php include('footer.php'); ?>