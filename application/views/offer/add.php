<?php $this->load->view('header.php')?>
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
                <input type="hidden" name="branch_id" value="<?=$this->uri->segment(3)?>">
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
                                                    <input type="checkbox" name="" id='iId' value="<?php echo $result->id; ?>" class="checkbox_user checked_id">
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
                        <input type="submit" class="btn btn-info pull-right margin_top_label" value="<?php echo @$getData[0]->created_at != '' ? 'Update' : 'Add'; ?>" id="btnSubmit" name="submit">
                        <!-- </span> -->
                     </div>
                  </div>
                  <input type="hidden" name="url" id="base_url" value="<?=base_url()?>">
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