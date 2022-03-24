<?php $this->load->view('header.php'); ?>
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/index'; ?>">Home</a> / list</a></li>
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
                    <header class="panel-heading"> List</header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <div class="panel-body padding-zero" style="float: right">
                                    <a href="<?=base_url().'home_content/add'?>" class="btn btn-primary">Add </a>
                                    <a href="#" id="delete_user" class="btn btn-danger">Delete </a>
                                </div>
                                <table class="display table table-bordered table-striped dataTable" id="home_content" aria-describedby="example_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Rendering engine: activate to sort column ascending"
                                            style="width: 100px;"><input type="checkbox" class="checkboxMain">
                                        </th>
                                        
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Image
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">
                                            Main Title
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">
                                            Sub Title
                                        </th>                                        
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Rendering engine: activate to sort column ascending"
                                            style="width: 100px;">Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                      <?php foreach ($section_two_data as $key => $value) { ?>
                                          <tr>
                                            <td> 
                                              <?php if ($value->id) { ?>
                                                    <input type="checkbox" name="delete[]" id='iId' value="<?php echo $value->id; ?>" class="checkbox_user">
                                                <?php } ?>
                                            </td>
                                            <td><div id="" class="" style="width: 150px;height: 150px; margin-top: 20px; "><img id="ContentImage" src="<?=base_url().'public/uploads/home_content/'.$value->image ?>" height="100%" width="100%"></div></td>
                                            <td><?=$value->main_title?></td>
                                            <td><?=$value->sub_title?></td>
                                            <td> <a href="<?php echo base_url() . 'home_content/edit/'.$this->utility->safe_b64encode($value->id); ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <a href="javascript:;" onclick="single_delete(<?php echo $value->id; ?>)" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a></td>
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
    </section>
</section>  
 <?php $this->load->view('footer.php'); ?>  
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script type="text/javascript">

    function single_delete(value) {

        bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
            if (confirmed == true) {
                var id = value;
                $.ajax({
                    url: '<?php echo base_url().'home_content/removeRecord'; ?>' ,
                    type:'post',
                    dataType:'json',
                    data: {
                        id: id
                    },
                    success: function (data) {

                        if (data.status == 1) {
                            bootbox.alert("Record deleted successfully.", function() {
                                window.location.reload(true);
                            });
                        }
                        else {
                            alert('Failed to delete selected sote.');
                        }
                    },
                    error: function () {
                        alert('Failed to delete selected record.');
                    }
                });
            }
            else
            {
                window.location.reload(true);
            }
        });
    }
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
                    url: '<?php echo base_url().'home_content/multipleDelete'; ?>',
                    dataType:'Json',
                    data: { ids: ids},
                    success: function(data) {
                        if(data.status == 1) {

                            bootbox.alert("Record has been deleted successfully.", function() {
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
        $('body').on('click','.checkboxMain',function(){
        
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


<script type="text/javascript">

      function readUploadedImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#ContentImage').attr('src', e.target.result);
                $('#show1').css('display','');

            }
            
            reader.readAsDataURL(input.files[0]);
        }
        $("#uploadimage").change(function(){
            readUploadedImage(this);
        });
    }
    
</script>
   
