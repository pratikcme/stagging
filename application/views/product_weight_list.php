<?php include('header.php'); ?>
<style type="text/css">
    #as{
        margin: 0 15px 0 0;
    }
</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/index'; ?>">Home</a> / <a href="<?php echo base_url().'product/product_list' ?>">Product </a> / Product Variants</a></li>
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
                    <header class="panel-heading">Variants Of <?=ucfirst($getNameOfProduct[0]->name)?></header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <div class="panel-body padding-zero" style="float: right">
                                    <a href="<?php echo base_url() . 'product/product_weight_profile?product_id='.$this->utility->encode($product_id); ?>" class="btn btn-primary">Add Product Variant</a>
                                    <a href="#" id="delete_user" class="btn btn-danger">Delete Product Variant</a>
                                </div>
                                <table class="display table table-bordered table-striped dataTable" id="example_product_weight_id"
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
                                            style="width: 200px;">Product Name
                                        </th>
                                         <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Variants
                                        </th>
                                        
                                       <!--  <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Unit
                                        </th> -->
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Purchase Price
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Maximum Retail Price (MRP)
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Discount(In %)
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 200px;">Quantity
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Rendering engine: activate to sort column ascending"
                                            style="width: 100px;">Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="asd  text-center col-lg-12"> <a href="<?php echo base_url() . 'product/product_list'; ?>" class="btn btn-primary" style="margin-top: 0px;" id="as">Back</a></div>
                    </div>
                </section>
            </div>
        </div>
    </section>
    <input type="hidden" name="" id="product_id" value="<?=$_GET['product_id']?>">
</section>
<!--main content end-->
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
    setTimeout(function () { $('#msg').hide(); }, 4000);

     function single_delete_check(value) {
        
                var id = value;
                $.ajax({
                    url: '<?php echo base_url().'product/check_product_varient_in_order'; ?>' ,
                    dataType:'json',
                    data: {
                        id: id
                    },
                    success: function (data) {

                       if (data.status == 1) {
                            single_delete(id);

                        }else if(data.status == 5){
                            bootbox.alert(data.msg, function() {
                                // window.location.reload(true);
                            });
                        }
                        else {
                            alert('Failed to delete selected sote.');
                        }
                    },
                    error: function () {
                        alert('Failed to delete selected brand.');
                    }
                });
           
    }

    /*Single Delete Script*/
    function single_delete(value) {

        bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
            if (confirmed == true) {
                var id = value;
                $.ajax({
                    url: '<?php echo base_url().'product/single_delete_product_weight'; ?>' ,
                    data: {
                        id: id
                    },
                    success: function (data) {

                        if (data.status == 1) {
                            bootbox.alert("Product variant has been deleted successfully.", function() {
                                window.location.reload(true);
                            });
                        }else if(data.status ==5){
                             bootbox.alert(data.msg, function() {
                            });
                        }
                        else {
                            alert('Failed to delete selected product_weight.');
                        }
                    },
                    error: function () {
                        alert('Failed to delete selected product_weight.');
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
                    url: '<?php echo base_url().'product/multi_delete_product_weight'; ?>',
                    data: { ids: ids.toString() },
                    success: function(data) {
                        var a = data.names;
                        if(data.status == 1) {
                            bootbox.alert("Product variant has been deleted successfully.", function() {
                                window.location.reload(true);
                            });
                        }else if(data.status ==5){
                            bootbox.alert("The product '"+a+"', is maped with order. Please deselect it and try again.", function() {
                            });
                        }else {
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