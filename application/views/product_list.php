<?php
include('header.php');
$branch_id = $this->session->userdata['id'];
$product_query = $this->db->query("SELECT p.*, c.name as category_name,sc.name as subcategory_name, b.name as brand_name FROM `product` as p 
  LEFT JOIN category as c ON c.id = p.category_id
  LEFT JOIN subcategory as sc ON sc.id = p.subcategory_id
  LEFT JOIN brand as b ON b.id = p.brand_id
  WHERE p.status != '9' AND p.branch_id = '$branch_id' ORDER BY p.id DESC");


if(isset($_GET['supplier_id'])){
    $sup_id = base64_decode($_GET['supplier_id']); 
    $product_query = $this->db->query("SELECT p.*, c.name as category_name,sc.name as subcategory_name, b.name as brand_name FROM `product` as p 
  LEFT JOIN category as c ON c.id = p.category_id
  LEFT JOIN subcategory as sc ON sc.id = p.subcategory_id
  LEFT JOIN brand as b ON b.id = p.brand_id
  WHERE p.status != '9' AND p.supplier_id = '$sup_id' AND p.branch_id = '$branch_id' ORDER BY p.id DESC");

}

$product_result = $product_query->result();



?>

<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/index'; ?>">Home</a> / Product</a></li>
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
                    <header class="panel-heading"> Product </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div id="example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <div class="panel-body padding-zero" >
                                  <div style="display: flex;justify-content: space-between;">
                                      <div>
                                        <a href="javascript:" class="btn btn-primary status_deleted"  data-status='1'>Activate</a>
                                        <a href="javascript:" class="btn btn-danger status_deleted"  data-status='9'>Disabled</a>
                                    </div>
                                    <div>
                                        <a href="<?php echo base_url() . 'product/product_profile'; ?>" class="btn btn-primary">Add Product</a>
                                        <a href="#" id="delete_user" class="btn btn-danger">Delete Product</a>
                                    </div>
                                </div>
                                </div>
                                <table class="display table table-bordered table-striped dataTable" id="example_product"
                                       aria-describedby="example_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Rendering engine: activate to sort column ascending"
                                            style="width: 80px;"><input type="checkbox" class="checkboxMain">
                                        </th>
                                      
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 180px;">Product Name
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 180px;">Category Name
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 180px;">Subcategory Name
                                        </th>
                                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending"
                                            style="width: 180px;">Brand Name
                                        </th>
                                          <th class="sorting" role="columnheader" tabindex="0" aria-controls="example"
                                            rowspan="1" colspan="1"
                                            aria-label="Rendering engine: activate to sort column ascending"
                                            style="width: 100px;">Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                   <!--  <?php foreach ($product_result as $result){ ?>
                                        <tr class="gradeX odd">
                                            <td class="hidden-phone">
                                                <?php if ($result->id) { ?>
                                                    <input type="checkbox" name="delete[]" id='iId' value="<?php echo $result->id; ?>" class="checkbox_user">
                                                <?php } ?>
                                            </td>
                                           
                                            <td class="hidden-phone"><?php echo $result->name; ?></td>
                                            <td class="hidden-phone"><?php echo $result->category_name; ?></td>
                                            <td class="hidden-phone"><?php echo $result->subcategory_name; ?></td>
                                            <td class="hidden-phone"><?php echo $result->brand_name; ?></td>
                                            <td>
                                             <a style="margin: 10px;" href="<?php echo base_url() . 'product/product_weight_list?product_id=' . $this->utility->encode($result->id); ?>" class="btn btn-success btn-xs">Variants</a>
                                             <a href="<?php echo base_url() . 'product/product_image_list?product_id=' . $this->utility->encode($result->id); ?>" class="btn btn-info btn-xs">Images</a>
                                             <a href="<?php echo base_url() . 'product/product_profile?id='.$this->utility->encode($result->id); ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                             <a href="javascript:;" onclick="single_delete(<?php echo $result->id; ?>)" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                                         </td>   
                                        </tr>
                                    <?php } ?> -->
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
<!--main content end-->
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
    setTimeout(function () { $('#msg').hide(); }, 4000);
    
    /*Single Delete Script*/    
     function single_hard_delete(value) {

            bootbox.confirm("Are you sure Do you want to delete..? Product is not recoverd" , function (confirmed) {
            if (confirmed == true) { 

                var id = value;
                $.ajax({
                    url: '<?php echo base_url().'product/check_for_hard_delete'; ?>' ,
                    dataType:'json',
                    data: {
                        id: id
                    },
                    success: function (data) {
                       if (data.status == 1) {
                            single_delete_hard(id);

                        }else if(data.status == 2){
                            bootbox.alert(data.msg, function() {
                                // window.location.reload(true);
                            });
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
        })
           
    }

    function single_delete_hard(value) {
            // bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
            // if (confirmed == true) {   
                var id = value;
                $.ajax({
                    url: '<?php echo base_url().'product/parmanentDeleteProduct'; ?>' ,
                    dataType:'json',
                    data: {
                        id: id
                    },
                    success: function (data) {

                       if (data.status == 1) {
                             bootbox.alert("Product has been deleted successfully.", function() {
                                window.location.reload(true);
                            });

                        }else if(data.status == 2){
                            bootbox.alert(data.msg, function() {
                                // window.location.reload(true);
                            });
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
            // }
        // })
           
    }


    /*Single Delete Script*/
    function single_delete_check(value) {

       
                var id = value;
                $.ajax({
                    url: '<?php echo base_url().'product/check_product_varient'; ?>' ,
                    dataType:'json',
                    data: {
                        id: id
                    },
                    success: function (data) {

                       if (data.status == 1) {
                            single_delete(id);

                        }else if(data.status == 2){
                            bootbox.alert(data.msg, function() {
                                // window.location.reload(true);
                            });
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

        bootbox.confirm("Are you sure you want to disable  ?" , function (confirmed) {
            if (confirmed == true) {
                var id = value;
                $.ajax({
                    url: '<?php echo base_url().'product/single_delete_product'; ?>' ,
                    data: {
                        id: id
                    },
                    success: function (data) {

                        if (data.status == 1) {
                            bootbox.alert("Product has been disabled successfully.", function() {
                                window.location.reload(true);
                            });
                        }
                        else {
                            alert('Failed to delete selected product.');
                        }
                    },
                    error: function () {
                        alert('Failed to delete selected product.');
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
                    url: '<?php echo base_url().'product/multi_delete_product'; ?>',
                    data: { ids: ids.toString() },
                    success: function(data) {
                          var a = data.names;
                        if(data.status == 1) {
                            bootbox.alert("Product(s) has been deleted successfully.", function() {
                                window.location.reload(true);
                            });
                        }else if(data.status == 2){
                             bootbox.alert("The product '"+a+"', is maped with varient. Please deselect it and try again.", function() {
                            });
                        }else if(data.status == 5){
                            //  bootbox.alert("The product '"+a+"', is maped with order. Please deselect it and try again.", function() {
                            // });
                            bootbox.alert(data.msg, function() {
                            });
                        }
                        else {
                            bootbox.alert('Failed to delete the selected records.');
                            // bootbox.alert(data.msg);
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
    })

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