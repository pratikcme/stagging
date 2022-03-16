<?php include('header.php'); ?>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'vendor/vendor_list'; ?>">Vendor </a>/ Vendor accounting</a></li>
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
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading"> Vendor Accounting</header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                               
                                <table class="display table table-bordered table-striped dataTable" id="example_accounting"
                                       aria-describedby="example_info">
                                    <thead>
                                    <tr role="row">
                                         <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 20px;"> Sr.No
                                        </th>
                                       
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Shop Name
                                        </th>

                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Shop Owner Name
                                        </th>

                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 100px;">Total Profit
                                        </th>
                                        <th class="hidden-phone sorting" role="columnheader" tabindex="0"
                                            aria-controls="example" rowspan="1" colspan="1"
                                            aria-label="Engine version: activate to sort column ascending"
                                            style="width: 100px;">Total Received
                                        </th>
                                        <th class="hidden-phone sorting_desc" role="columnheader" tabindex="0"
                                            aria-controls="example" rowspan="1" colspan="1" aria-sort="descending"
                                            aria-label="CSS grade: activate to sort column ascending"
                                            style="width: 100px;">Total Pending
                                        </th>
                                        <th class="hidden-phone sorting_desc" role="columnheader" tabindex="0"
                                            aria-controls="example" rowspan="1" colspan="1" aria-sort="descending"
                                            aria-label="CSS grade: activate to sort column ascending"
                                            style="width: 100px;">Action
                                        </th>
                                         <!-- <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Rendering engine: activate to sort column ascending"
                                            style="width: 100px;">Action
                                        </th> -->
                                    </tr>
                                    </thead>
                                    <!-- <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <?php $i = 1; foreach ($user_result as $result){ ?>
                                        <tr class="gradeX odd">
                                            <td class="hidden-phone">
                                               <?php echo $i; $i++; ?>
                                            </td>
                                            
                                            <td class="hidden-phone"><?php echo $result->name; ?></td>
                                            <td class="hidden-phone"><?php echo $result->owner_name; ?></td>
                                            <td class="hidden-phone sorting_1"><?php if(isset($get_vendor[$result->id])){echo $get_vendor[$result->id];}else{echo 0;} ?></td>
                                            <td class="hidden-phone sorting_1"><?php if(isset($get_vendor_profit[$result->id])){echo $get_vendor_profit[$result->id];}else{ echo 0;} ?></td>
                                            
                                           <td class="hidden-phone sorting_1"><?php echo @$get_vendor[$result->id] - @$get_vendor_profit[$result->id]; ?>
                                           </td>
                                                <td>

                                               

                                                <a href="<?php echo base_url().'vendor/set_profit?id='.$this->utility->encode($result->id); ?>" class="btn btn-primary btn-xs"><i class="fa fa-credit-card"></i></a>


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
    </section>
</section>
<!--main content end-->
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
    setTimeout(function () { $('#msg').hide(); }, 4000);

    /*Single Delete Script*/
    $('.vendor_status').click(function(){

                var id = $(this).attr('data-val');
               

                $.ajax({
                    type:"POST",
                    url: '<?php echo base_url().'vendor/vendor_status_change'; ?>',
                    data: {id: id},
                    
                    success: function (data) {
                        if (data.status == 1) {
                            bootbox.alert("Status Changed successfully.", function() {
                                window.location.reload(true);
                            });
                        }
                        else {
                            alert('Failed to delete selected user.');
                        }
                    },

                    error: function () {
                        alert('Failed to delete selected user.');
                    }
                });
            });
           
    

    $('#delete_user').click(function() {

        if($('.checkbox_user:checked').length == 0) {
            //alert("Select one record"); return false;
            bootbox.alert('Please select at least one record to delete');
            return;
        }
        bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
            if (confirmed == true) {

                var ids = [];
                $('.checkbox_user:checked').each(function() {
                    ids.push($(this).val());
                });
                $.ajax({
                    url: '<?php echo base_url().'admin/multi_delete_user'; ?>',
                    data: { ids: ids.toString() },
                    success: function(data) {
                        if(data.status == 1) {

                            bootbox.alert("User(s) has been deleted successfully.", function() {
                                window.location.reload(true);
                            });
                        }
                        else {
                            bootbox.alert('Failed to delete the selected records.');
                        }
                    },
                    error: function() {
                        bootbox.alert('Failed to delete the selected records.');
                    }
                });
            }
            else
            {
                window.location.reload(true);
            }
        });
    });

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
<?php include('footer.php'); ?>