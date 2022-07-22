<?php $this->load->view('header.php')?>
<style type="text/css">
    caption{
    font-size: 25px;
    color: #000;
}
table{
    width: 100%;
    text-align: center;
}
thead{
    text-align: center;
}
table,th,td{
    border-collapse: collapse;
    border: 1px solid;
    padding: 10px;
}

input{
    border: 1px solid #000 !important;
    border-radius: 0 !important;
    outline: 0;
}
input[type="text"]:focus{
    box-shadow: none;
    outline: 0;
}
.last-td{
    text-align: right;
    border: 0;
}
.btn{
    padding: 10px 30px;
    border: none;
}
.modal-header{
    background: transparent !important;
    color: black!important;
}

</style>
<section id="main-content">
   <?php if($this->session->flashdata('myMessage') != '' ){
      echo $this->session->flashdata('myMessage');
      } ?>              
   <section class="wrapper">
      <!-- page start-->
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb">
               <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'offer'; ?>">List</a> /Add </a></li>
            </ul>
            <!--breadcrumbs end -->
         </div>
      </div>
      <div class="row">
         <!--Left Part-->
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <section class="panel">
               <header class="panel-heading">
                  Add
               </header>
               <form id="frmAddEdit" method="post" enctype="multipart/form-data" action="<?=$FormAction?>">
                <input type="hidden" name="branch_id" id="branch_id" value="<?=$this->uri->segment(3)?>">
                  <div class="panel-body">
                     <div class="row">
                         <div class="col-md-6 col-sm-12 col-xs-12 padding-zero">
                            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                               <div class="form-group">
                                  <label for="branch">Branch</label>
                                  <select class="form-control" name="branch" id="branch1" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                      <option value="">Select Branch</option>
                                      <<?php foreach ($branchList as $key => $value): ?>
                                      <!-- <option value="<?=$value->id?>"><?=$value->name?></option> -->
                                      <option value="<?=base_url().'offer/add/'.$value->id?>" <?=($value->id == $this->uri->segment(3)) ? "SELECTED" : "" ?>><?=$value->name?></option>
                                      <?php endforeach ?>
                                  </select>
                               </div>
                               <div class="form-group">
                                  <label for="offer_image" >Image</label>
                                  <input type = "file" name = "offer_image" class="form-control" onchange="app_readUploadedImage(this)" size = "20" id="offer_image" / <?=($this->uri->segment(3) =='' ) ? 'disabled' : '' ?>>
                                  <div id='show1' class="" style="width: 150px;height: 150px; margin-top: 20px; display: none" >
                                     <img id="offer_ContentImage" src="#" height="100%" width="100%">
                                  </div>
                               </div>
                               <label for="image"  style="color: red" class="error"></label>
                            </div>
                         </div>
                         <div class="col-md-6 col-sm-12 col-xs-12 padding-zero">
                            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                               <div class="form-group">
                                  <label for="offer_title">Offer Title</label>
                                  <input type="text" id="offer_title" name="offer_title" class="form-control" <?=($this->uri->segment(3) =='' ) ? 'disabled' : '' ?>>
                                  <label for="offer_title" style="color: red" class="error"><?php echo @form_error('offer_title'); ?></label>
                               </div>
                            </div>
                            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                               <div class="form-group">
                                  <label for="offer_title">Offer Percent</label>
                                  <input type="text" name="offer_percent" class="form-control" <?=($this->uri->segment(3) =='' ) ? 'disabled' : '' ?>>
                                  <label for="offer_percent" class="error"></label>
                               </div>
                            </div>
                         </div>
                          <div class="col-md-6 col-sm-12 col-xs-12 padding-zero">
                            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                               <div class="form-group">
                                  <label for="start_date"> Start date</label>
                                  <input type="text" id="start_date" name="start_date" class="form-control datetime" <?=($this->uri->segment(3) =='' ) ? 'disabled' : '' ?> autocomplete="off" >
                                  <label for="start_date" style="color: red" class="error"><?php echo @form_error('start_date'); ?></label>
                               </div>
                            </div>
                            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                               <div class="form-group">
                                  <label for="end_date">End date</label>
                                  <input type="text" id="end_date" name="end_date" class="form-control datetime_end" <?=($this->uri->segment(3) =='' ) ? 'disabled' : '' ?> autocomplete="off">
                                  <label for="end_date" style="color: red" class="error"><?php echo @form_error('end_date'); ?></label>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-6 col-sm-12 col-xs-12 padding-zero">
                            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                               <div class="form-group">
                                  <label for="start_time">Start time</label>
                                  <input type="time" id="start_time" name="start_time" class="form-control" <?=($this->uri->segment(3) =='' ) ? 'disabled' : '' ?>>
                                  <label for="start_time" style="color: red" class="error"><?php echo @form_error('start_time'); ?></label>
                               </div>
                            </div>
                            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                               <div class="form-group">
                                  <label for="end_time">End time</label>
                                  <input type="time" id="end_time" name="end_time" class="form-control" <?=($this->uri->segment(3) =='' ) ? 'disabled' : '' ?>>
                                  <label for="end_time" style="color: red" class="error"><?php echo @form_error('end_time'); ?></label>
                               </div>
                            </div>
                         </div>
                     </div>
                     <input type="hidden" name="hidden_varient_id" id='hidden_varient_id'>
                      <table class="display table table-bordered table-striped dataTable" id="example_product_offer"
                                       aria-describedby="example_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Rendering engine: activate to sort column ascending"
                                            style="width: 80px;">
                                            Select
                                            <!-- <input type="checkbox" class="checkboxMain"> -->
                                        </th>
                                      
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 180px;">Product Name
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 180px;">price
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 180px;">discount (%)
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 180px;">Unit
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 180px;">weight
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 180px;">Package
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                     <?php foreach ($producList as $result){ ?>
                                        <tr class="gradeX odd">
                                            <td class="hidden-phone">
                                                <?php if ($result->id) { ?>
                                                    <input type="checkbox" name="" id='iId' value="<?php echo $result->id; ?>" class="checkbox_user checked_id" >
                                                <?php } ?>
                                            </td>
                                           
                                            <td class="hidden-phone"><?=$result->product_name; ?></td>
                                            <td class="hidden-phone"><?=$result->price; ?></td>
                                            <td class="hidden-phone"><?=$result->discount_per; ?></td>
                                            <td class="hidden-phone"><?=$result->weight_no; ?></td>
                                            <td class="hidden-phone"><?=$result->weight_name; ?></td>
                                            <td class="hidden-phone"><?=$result->package; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <!-- <span class="panel-body padding-zero" > -->
                        <a href="<?=base_url().'offer'?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>
                        <!-- <input type="submit" class="btn btn-info pull-right margin_top_label" value="Add" id="btnSubmit" name="submit"> -->
                        <input type="button" class="btn btn-info pull-right margin_top_label" id="add" value="Add">
                        <!-- </span> -->
                     </div>
                  </div>
                  <input type="hidden" name="url" id="base_url" value="<?=base_url()?>">
                   <div class="modal-wrapper">
                    <div class="container">
                       <!--  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->
                            <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <table>
                                                <caption>Selected Product</caption>
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Discount</th>
                                                        <th>Price</th>
                                                        <th>Varient</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='append_selected_varient'>
                                                    <tr >
                                                        <td colspan="4" class="last-td"><button type="submit" class="btn ">Add</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
               </form>
            </section>
         </div>
         <!--Map Part-->
      </div>
   </section>
</section>
<script type="text/javascript">
   function app_readUploadedImage(input) {
     if (input.files && input.files[0]) {
         var reader = new FileReader();
         
         reader.onload = function (e) {
   
             $('#offer_ContentImage').attr('src', e.target.result);
             $('#show1').css('display','');
   
         }
         
         reader.readAsDataURL(input.files[0]);
     }
     $("#offer_image").change(function(){
         app_readUploadedImage(this);
     });
   }

   
    $(document).ready(function(){
        $('.checkboxMain').on('click',function(){
            if(this.checked){
                $('.checkbox_user').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkbox_user').each(function(){
                    this.checked = false;
                });
            }
        });

        $('.checkbox_user').on('click',function(){
            if($('.checkbox_user:checked').length == $('.checkbox_user').length){
                $('.checkboxMain').prop('checked',true);
            }else{
                $('.checkboxMain').prop('checked',false);
            }
        });
    });
</script>
<?php $this->load->view('footer.php')?>