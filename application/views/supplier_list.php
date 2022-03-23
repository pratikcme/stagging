<?php include('header.php');?>
<section id="main-content">
    <section class="wrapper site-min-height">
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
                        <header class="panel-heading">
                            Supplier
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">

                                    <div class="panel-body padd_rght_0" style="float: right">
                                        <a href="<?php echo base_url().'supplier/profile'; ?>" class="btn btn-primary btn-lg" >Add Supplier</a>
                                    </div>

                                    <table class="display table table-bordered table-striped dataTable tab_res_errr" id="example_supplier"
                                           aria-describedby="example_info">
                                        <thead>
                                        <tr role="row">
                                            
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Name</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Default Markup</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">First Name</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Last Name</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Company</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Email</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Phone</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Mobile</th>
                                            <!--<th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Fax</th>-->
                                           
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">State</th>
                                            <!--<th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;"></th>-->
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Action</th>
                                        </tr>
                                        </thead>
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

<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">

    setTimeout( function(){$('#msg').hide();} , 4000);

    /*Single Delete Script*/
    function single_delete(value) {
        bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
            if (confirmed == true) {
                var id = value;

                $.ajax({
                    url: '<?php echo base_url().'supplier/single_delete_supplier/'; ?>' ,
                    data: {
                        ids: id.toString(),
                        url: '<?php echo base_url().'supplier/single_delete_supplier/'; ?>' ,
                    },
                    success: function (data) {

                        if (data.status == 1) {
                            bootbox.alert("Supplier has been deleted successfully.", function() {
                                window.location.reload(true);
                            });
                        }
                        else {
                            alert('Failed to delete selected supplier.');
                        }
                    },
                    error: function () {
                        alert('Failed to delete selected supplier.');
                    }
                });
            }
            else
            {
                window.location.reload(true);
            }
        });
    }
</script>
<?php include('footer.php'); ?>