<?php include('header.php');?>
<section id="main-content">
   <section class="wrapper">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb">
               <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/index'; ?>">Home</a> / Customer</a></li>
            </ul>
            <!--breadcrumbs end -->
         </div>
      </div>
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
               <header class="panel-heading font_increase">
                  Customer
               </header>
               <div class="panel-body">
                  <div class="adv-table">
                     <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <div class="panel-body padd_rght_0" style="float: right">
                           <a href="<?php echo base_url() . 'customer/customer1/'; ?>"
                              class="btn btn-primary btn-lg">Add Customer</a>
                           <!--                                        <a href="#myModal" class="btn btn-primary btn-lg" data-toggle="modal">Import</a>
                              <a href="<?php echo base_url() . 'customer/fetchDataFromTable_customer/'; ?>"
                                 class="btn btn-primary btn-lg">Export List</a>-->
                        </div>
                        <table class="display table table-bordered table-striped dataTable tab_res_errr no_dpl_blck_cls" id="example_customer"
                           aria-describedby="example_info">
                           <thead>
                              <tr role="row">
                                 <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                    rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending"
                                    style="width: 372px;">Customer Name
                                 </th>
                                 <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                    rowspan="1" colspan="1"
                                    aria-label="Rendering engine: activate to sort column ascending"
                                    style="width: 305px;">Company Name
                                 </th>
                                 <!--<th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                    rowspan="1" colspan="1"
                                    
                                    aria-label="Browser: activate to sort column ascending"
                                    
                                    style="width: 409px;">Date of Birth
                                    
                                    </th>-->
                                 <th class=" sorting" role="columnheader" tabindex="0"
                                    aria-controls="example" rowspan="1" colspan="1"
                                    aria-label="Engine version: activate to sort column ascending"
                                    style="width: 263px;">Gender
                                 </th>
                                 <th class=" sorting_desc" role="columnheader" tabindex="0"
                                    aria-controls="example" rowspan="1" colspan="1" aria-sort="descending"
                                    aria-label="CSS grade: activate to sort column ascending"
                                    style="width: 190px;">Phone Number
                                 </th>
                                 <!--                                            <th class=" sorting_desc" role="columnheader" tabindex="0"
                                    aria-controls="example" rowspan="1" colspan="1" aria-sort="descending"
                                    
                                    aria-label="CSS grade: activate to sort column ascending"
                                    
                                    style="width: 190px;">Mobile Number
                                    
                                    </th>-->
                                 <th class=" sorting_desc" role="columnheader" tabindex="0"
                                    aria-controls="example" rowspan="1" colspan="1" aria-sort="descending"
                                    aria-label="CSS grade: activate to sort column ascending"
                                    style="width: 190px;">Email Address
                                 </th>
                                 <!--                                            <th class=" sorting_desc" role="columnheader" tabindex="0"
                                    aria-controls="example" rowspan="1" colspan="1" aria-sort="descending"
                                    
                                    aria-label="CSS grade: activate to sort column ascending"
                                    
                                    style="width: 190px;">Street1
                                    
                                    </th>
                                    
                                    <th class=" sorting_desc" role="columnheader" tabindex="0"
                                    
                                    aria-controls="example" rowspan="1" colspan="1" aria-sort="descending"
                                    
                                    aria-label="CSS grade: activate to sort column ascending"
                                    
                                    style="width: 190px;">Street2
                                    
                                    </th>-->
                                 <th class=" sorting_desc" role="columnheader" tabindex="0"
                                    aria-controls="example" rowspan="1" colspan="1" aria-sort="descending"
                                    aria-label="CSS grade: activate to sort column ascending"
                                    style="width: 190px;">City
                                 </th>
                                 <th class=" sorting_desc" role="columnheader" tabindex="0"
                                    aria-controls="example" rowspan="1" colspan="1" aria-sort="descending"
                                    aria-label="CSS grade: activate to sort column ascending"
                                    style="width: 190px;">State
                                 </th>
                                 <th class=" sorting_desc" role="columnheader" tabindex="0"
                                    aria-controls="example" rowspan="1" colspan="1" aria-sort="descending"
                                    aria-label="CSS grade: activate to sort column ascending"
                                    style="width: 190px;">country
                                 </th>
                                 <th class=" sorting_desc" role="columnheader" tabindex="0"
                                    aria-controls="example" rowspan="1" colspan="1" aria-sort="descending"
                                    aria-label="CSS grade: activate to sort column ascending"
                                    style="width: 190px;">Post Code
                                 </th>
                                 <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                    rowspan="1" colspan="1"
                                    aria-label="Platform(s): activate to sort column ascending"
                                    style="width: 372px;">Action
                                 </th>
                              </tr>
                           </thead>
                          <!--  <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <?php
                                 foreach ($row_client as $row) {
                                 
                                     ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?php echo $row->customer_name; ?></td>
                                 <td class=" "><?php echo $row->company; ?></td>
                                 <td class="center  sorting_1">
                                <?php
                                if ($row->gender == 1) {
                                    echo "Male";
                                }else{
                                 echo "Female";
                                } ?>
                                 </td>
                                 <td class="center   sorting_1"><?php echo $row->phone; ?></td>
                                 <td class="center  "><?php echo $row->email; ?></td>
                                 <td class="center  "><?php echo $row->city; ?></td>
                                 <td class="center  "><?php echo $row->state; ?></td>
                                 <td class="center  "><?php echo $row->country; ?></td>
                                 <td class="center  "><?php echo $row->postcode; ?></td>
                                 <td class="">
                                    <a href="<?php echo base_url() . 'customer/edit_customer/?customerid=' .$this->utility->encode($row->id);  ?>"
                                       class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                    <a href="javascript:;"
                                       onclick="single_delete(<?php echo $row->id; ?>)"
                                       class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                                 </td>
                              </tr>
                              <?php } ?>
                           </tbody> -->
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
<!-- Add : Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Import Customer</h4>
         </div>
         <form method="post" action="<?php echo base_url() . 'customer/import'; ?>" enctype="multipart/form-data" id = "importFile">
            <div class="modal-body">
               <div class="form-group">
                  <label for="name">Download File</label>
                  <a href = "<?php echo base_url() . 'customer/downloadCSV'; ?>" class="btn btn-primary">Download</a>
               </div>
               <div class="form-group">
                  <div class="inpt_fle">
                     <label for="name">Import File</label>
                     <input type="file" name="import_file" class="form-control">
                     <label for="import_file" class="error" style = "color:red;"></label>
                  </div>
                  <input type="submit" class="btn btn-primary mrgn_tp_24" value="Import Customer" name="submit"/>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script type="text/javascript">
   setTimeout( function(){$('#msg').hide();} , 4000);
   /*Single Delete Script*/
   function single_delete(value) {
   
   
       bootbox.confirm("Are you sure you want to delete ?", function (confirmed) {
           if (confirmed == true) {
               var id = value;
   
               $.ajax({
                   url: '<?php echo base_url() . 'customer/single_delete_customer/'; ?>',
                   data: {
                       id: id.toString(),
                       url: '<?php echo base_url() . 'customer/single_delete_customer/'; ?>',
                   },
                   success: function (data) {
   
                       if (data.status == 1) {
                           bootbox.alert("Customer has been deleted successfully.", function () {
                               window.location.reload(true);
                           });
                       }
                       else {
                           alert('Failed to delete selected customer.');
                       }
                   },
                   error: function () {
                       alert('Failed to delete selected customer.');
                   }
               });
           }
           else {
               window.location.reload(true);
           }
       });
   }
   
   
   
   
   $('#importFile').validate({
   rules: {
       import_file: {
       required: true,
       extension:"csv"
       }
   },
   messages: {
        import_file: {
        required: "Please upload file  to import customer list",
        accept:"Please upload only CSV format file"
       }
   },
   error: function(label) {
     $(this).addClass("error");
    }
   });
   
   
</script>
<?php include('footer.php'); ?>