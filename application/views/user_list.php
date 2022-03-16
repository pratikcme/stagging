<?php include('header.php'); ?>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'index.php/admin/dashboard'; ?>">Home</a> / User</a></li>
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
                    <header class="panel-heading"> Users</header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <!-- <div class="panel-body padding-zero" style="float: right">
                                    <a href="#" id="delete_user" class="btn btn-danger">Delete User</a>
                                </div> -->
                                <table class="display table table-bordered table-striped dataTable" id="users_table"
                                       aria-describedby="example_info">
                                    <thead>
                                    <tr role="row">
                                       <!--  <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Rendering engine: activate to sort column ascending"
                                            style="width: 100px;"><input type="checkbox" class="checkboxMain">
                                        </th> -->
                                       
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">First Name
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Last Name
                                        </th>
                                        <th class="hidden-phone sorting" role="columnheader" tabindex="0"
                                            aria-controls="example" rowspan="1" colspan="1"
                                            aria-label="Engine version: activate to sort column ascending"
                                            style="width: 263px;">Email
                                        </th>
                                        <th class="hidden-phone sorting_desc" role="columnheader" tabindex="0"
                                            aria-controls="example" rowspan="1" colspan="1" aria-sort="descending"
                                            aria-label="CSS grade: activate to sort column ascending"
                                            style="width: 190px;">Phone Number
                                        </th>
                                        <th class="hidden-phone sorting_desc" role="columnheader" tabindex="0"
                                            aria-controls="example" rowspan="1" colspan="1" aria-sort="descending"
                                            aria-label="CSS grade: activate to sort column ascending"
                                            style="width: 190px;">Registered date
                                        </th>
                                         <!-- <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Rendering engine: activate to sort column ascending"
                                            style="width: 100px;">Action
                                        </th> -->
                                    </tr>
                                    </thead>
                                    <!-- <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <?php foreach ($user_result as $result){ ?>
                                        <tr class="gradeX odd">
                                            <td class="hidden-phone">
                                                <?php if ($result->id) { ?>
                                                    <input type="checkbox" name="delete[]" id='iId' value="<?php echo $result->id; ?>" class="checkbox_user">
                                                <?php } ?>
                                            </td>
                                            
                                            <td class="hidden-phone"><?php echo $result->fname; ?></td>
                                            <td class="hidden-phone sorting_1"><?php echo $result->lname; ?></td>
                                            <td class="hidden-phone sorting_1"><?php echo $result->email; ?></td>
                                            <td class="hidden-phone sorting_1"><?php echo $result->phone; ?></td>
                                            <td> 
                                                <a href="javascript:;" onclick="single_delete(<?php echo $result->id; ?>)" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                                                 <a href="<?php echo base_url() . 'index.php/admin/user_address_list?user_id=' . $this->utility->encode($result->id); ?>" class="btn btn-primary btn-xs">Address</a> 
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
    function single_delete(value) {

        bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
            if (confirmed == true) {
                var id = value;
                $.ajax({
                    url: '<?php echo base_url().'index.php/admin/single_delete_user'; ?>' ,
                    data: {
                        id: id
                    },
                    success: function (data) {

                        if (data.status == 1) {
                            bootbox.alert("User has been deleted successfully.", function() {
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
                    url: '<?php echo base_url().'index.php/admin/multi_delete_user'; ?>',
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