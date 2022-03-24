<?php $this->load->view('header');?>
  <section id="main-content">
    <section class="wrapper">
        <!-- page start-->
               <?php if($this->session->flashdata('myMessage') != '' ){
        echo $this->session->flashdata('myMessage');
 } ?> 
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
                                    <a href="<?=base_url().'admins/privacy_policy/add'?>" class="btn btn-primary">Add </a>
                                    <a href="#" id="delete_user" class="btn btn-danger">Delete</a>
                                </div>
                                <table class="display table table-bordered table-striped dataTable" id="faq_customer_support"
                                       aria-describedby="example_info">
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
                                            style="width: 200px;">Title
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Sub Title
                                        </th>                                      
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Rendering engine: activate to sort column ascending"
                                            style="width: 100px;">Action
                                        </th>
                                    </tr>
                                    </thead>
                                     <tbody role="alert" aria-live="polite" aria-relevant="all">
                                      <?php foreach ($getPrivacy as $key => $value) { ?>
                                          <tr>
                                            <td> 
                                              <?php if ($value->id) { ?>
                                                    <input type="checkbox" name="delete[]" id='iId' value="<?php echo $value->id; ?>" class="checkbox_user">
                                                <?php } ?>
                                            </td>
                                            <td><?=$value->title?></td>
                                            <td><?=$value->sub_title?></td>
                                            <td> <a href="<?php echo base_url() . 'admins//privacy_policy/edit/'.$this->utility->safe_b64encode($value->id); ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
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
<?php $this->load->view('footer');?>
<script type="text/javascript">

    function single_delete(value) {

        bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
            if (confirmed == true) {
                var id = value;
                $.ajax({
                    url: '<?php echo base_url().'admins/privacy_policy/removeRecord'; ?>' ,
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
                    url: '<?php echo base_url().'admins/privacy_policy/multi_delete'; ?>',
                    data: { ids: ids },
                    dataType:'json',
                    success: function(data) {
                        if(data.status == 1) {

                            bootbox.alert(" Record has been deleted successfully.", function() {
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
