<?php
include('header.php');
?>
    <style>
       label.error{
            color: red;
        }
        #excl-modal .modal-dialog{
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%,-50%);
                box-shadow: 0px 0px 21px -5px rgba(0,0,0,0.75);
                width: 100%;
               max-width: 920px;

        }
        #excl-modal .modal-body{
            height: 350px;
            overflow: auto;
            overflow-x: hidden;
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
            <div class="row">
                <!--Left Part-->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <section class="panel">

                        <form role="form" method="post" action="<?php echo base_url().'import/importExcelFile'; ?>" id="import_excel" enctype="multipart/form-data">

                            <div class="panel-body">
                                <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="margin_top_label">Select Type<span class="required" > * </span></label>
                                            <select name="type" class="form-control margin_top_input type">
                                                <option value="">Select For</option>
                                                    <option value="1">Insert Product</option>
                                                    <option value="2">Update Product Quantity</option>
                                            </select>
                                            <!-- <span id="err1" style="color: red;"></span> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label for="name" class="margin_top_label">Select Category<span class="required"> * </span></label>
                                        <select name="catgeory" class="form-control margin_top_input catgorySelct">
                                            <option value="">Select Category</option>
                                            <<?php foreach ($category as $key => $value): ?>
                                                <option value="<?=$value->id?>"><?=$value->name?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 padding-zero" style="margin-top: 25px">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="margin_top_label">Select File<span class="required" aria-required="true"> * </span></label>
                                            <input type="file" name="file" id="file" required/>
                                            <span id="err1" style="color: red;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
<!--                                    <a href="price_list" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>-->
                                    <input type="submit" id="submit" class="btn btn-info pull-right margin_top_label" value="Import Excel" name="submit">
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
                <!--Map Part-->
            </div>
            <!-- page end-->
        </section>
    </section>
      <!-- The Modal -->
     <?php $nu = $this->utility->safe_b64decode($this->uri->segment(3)); 
      $ar = range(10,100);

     ?>
  <div class=" modal <?=(in_array($nu,$ar)) ? 'show' : '' ?> " id="excl-modal">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Click Add Record To Save Uploaded Excel</h4>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <div class="row">
                    <!--Left Part-->
                    <div class="col-lg-12">
                       <table class="table table-bordered table-striped import_excel">
                           <thead>
                               <tr role="row">
                                   <th>S.no</th>
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
                                   <td><?=$key+1?></td>
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
                    </div>
                    <!--Map Part-->
                </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            <a class="btn btn-danger" href="<?=base_url().'import/import_excel/'?>">Cancel</a>
            <a class="btn btn-success" href="<?=base_url().'import/insertExcelRecordParmanent'?>">Add Record</a>
          <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        </div>
        
      </div>
    </div>
  </div>
    <!--main content end-->
    <script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.js"></script>

    <script>

        $('#file').change(function () {
            var filename = $(this).val();
            var ext = /^.+\.([^.]+)$/.exec(filename);
            var extension = ext == null ? "" : ext[1];

            $('#file-error').hide();

            if(extension != "xls" && extension != "xlsx"){
                $('#err1').html("Please select excel file");
                $('#submit').attr('disabled','disabled')
            }
            else{
                $('#err1').html("");
                $('#submit').removeAttr('disabled');
            }


        });

        $('#import_excel').validate({
            rules: {
                file: {
                    required: true,
                },
                type : {
                    required : true,
                },
                catgeory : {
                    required : true,
                }
            },
            messages: {
                file: {
                    required: "Please select file",
                },
                type : {
                    required : "Please select type",
                },
                catgeory : {
                    required : "Please select category",
                }
            },
        });
    </script>
<?php include('footer.php'); ?>