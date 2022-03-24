<?php include('header.php'); ?>

<section id="main-content">
    <section class="wrapper site-min-height">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/index'; ?>">Home</a> / Customer Group</a></li>
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
                        <header class="panel-heading">
                            Customer Group
                        </header>
                        <div class="panel-body">
                            <div class="adv-table">
                                <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">

                                    <div class="panel-body" style="float: right">
                                        <a href="#myModal" class="btn btn-primary btn-lg" data-toggle="modal">Add Customer Group</a>
                                    </div>

                                    <table class="display table table-bordered table-striped dataTable" id="example_group_list"
                                           aria-describedby="example_info">
                                        <thead>
                                        <tr role="row">
                                            
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Name</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Date</th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;"></th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending" style="width: 305px;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody role="alert" aria-live="polite" aria-relevant="all">

                                        <?php foreach ($result as $group){ ?>

                                            <tr class="gradeX odd">
                                                
                                                <td class=""><?php echo $group->name; ?></td>
                                                <td class=""><?php echo date('Y-m-d H:i:s', $group->dt_updated); ?></td>
                                                <td class=""><a href="<?php echo base_url().'customer/group_customer_view?id='.$group->id; ?>" class="btn btn-primary btn-xs">View Customers</a>
                                                </td>
                                                <td class="">
                                                    <a href="javascript:;" onclick="type_update(<?php echo $group->id; ?>)" data-toggle="modal" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                    <a href="javascript:;" onclick="single_delete(<?php echo $group->id; ?>)" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                                                </td>
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
            <!-- page end-->
    </section>
</section>

<!-- Add Type : Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">New Customer Group</h4>
            </div>
            <form method="post" action="<?php echo base_url() . 'customer/add_group'; ?>" id="add_customer_form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Group Name</label>
                        <input type="text" name="name" class="form-control" value="" required placeholder="Group Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary submitBtn" value="Add Customer Group" name="submit"/>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Type : Modal -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Update Customer Group</h4>
            </div>
            <form method="post" action="<?php echo base_url() . 'customer/update_group'; ?>" id="update_customer_form">
                <input type="hidden" id="id" name="id" value="">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Group Name</label>
                        <input type="text" name="name" class="form-control" value="" id="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary submitBtn" value="Update Customer Group" name="submit"/>
                </div>
            </form>
        </div>
    </div>
</div>
<style> label.error { color: red; font-weight: 500; } </style>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script>
<script type="text/javascript">

    setTimeout( function(){$('#msg').hide();} , 4000);

    $('#add_customer_form').validate({
        rules: {
            name: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please enter group name"
            }
        },
        error: function(label) {
            $(this).addClass("error");
        }
    });

    $('#update_customer_form').validate({
        rules: {
            name: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please enter group name"
            }
        },
        error: function(label) {
            $(this).addClass("error");
        }
    });

    /*Type Update*/
    function type_update(value) {

        var id = value;
        $('#id').val(id);
        $('#myModal1').modal('show');

        $.ajax({
            url: '<?php echo base_url().'customer/select_type/'; ?>' ,
            data: {
                ids: id.toString(),
                url: '<?php echo base_url().'customer/select_type/'; ?>' ,
            },
            success: function(data) {
                var res = $.parseJSON(data);
                $('#name').val(res.name);
            }
        });
    }

    /*Single Delete Script*/
    function single_delete(value) {


        bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
            if (confirmed == true) {
                var id = value;

                $.ajax({
                    url: '<?php echo base_url().'customer/single_delete_group/'; ?>' ,
                    data: {
                        ids: id.toString(),
                        url: '<?php echo base_url().'customer/single_delete_group/'; ?>' ,
                    },
                    success: function (data) {

                        if (data.status == 1) {
                            bootbox.alert("Customer group has been deleted successfully.", function() {
                                window.location.reload(true);
                            });
                        }
                        else {
                            alert('Failed to delete selected Customer group.');
                        }
                    },
                    error: function () {
                        alert('Failed to delete selected Customer group.');
                    }
                });
            }
            else
            {
                window.location.reload(true);
            }
        });
    }
    
    $(document).on('click','#add_customer_form',function(){
    
        $("#submitBtn").attr('disabled',true);
    })
</script>

<?php include('footer.php'); ?>