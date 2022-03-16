<?php include('header.php');
    $id = $this->utility->decode($_GET['id']); 
    if($result['id']!=''){
        $reqName = "Update";
        }else{
           $reqName ="Add";
    } 
?>
<style type="text/css">
 .required{
         color: red;
         }
</style>
<!--main content start-->

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/multi-select.css">

<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'brand/brand_list'; ?>">Brand</a> / <?php echo $reqName; ?></a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $reqName; ?> Brand
                    </header>
                    <form role="form" method="post" action="<?php echo base_url().'brand/brand_add_update'; ?>" name="brand_form" id="brand_form">
                        <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Brand Name :<span class="required" aria-required="true"> * </span></label>
                                        <input type="text" class="form-control margin_top_input" id="name" name="name" placeholder="Enter brand name" value="<?php echo $result['name']; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Category:<span class="required" aria-required="true"> * </span></label>
                                        <!-- <a href='#' id='select-all'>select all</a> -->
                                        <select  multiple='multiple' class="form-control margin_top_input" id="category_id" name="category_id[]">
                                            <option value="" selected disabled>Selected Category</option>
                                            <?php $i = 0 ; foreach ($category_result as $cat){ ?>
                                                <option value="<?php echo $cat->id; ?>" <?php if(in_array($cat->id,$set_cat_array) ){ ?> selected <?php } ?>><?php echo $cat->name; ?></option>
                                            <?php  $i++; } ?>
                                        </select>
                                        <label id="category_id-error" class="error" for="category_id"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                  <a href="brand_list" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>  
                                  <input type="submit" class="btn btn-info pull-right margin_top_label" value="<?php echo $reqName.' Brand'; ?>" name="submit">
                            </div>
                        </div>
                    </form>
                </section>
            </div>
            <!--Map Part-->
        </div>
        <!-- page end-->
    </section>
    <input type="hidden" id="base_url" value="<?=base_url()?>">
</section>
<!--main content end-->
<style> label.error { color: red; font-weight: 500; } </style>
<script src="<?php echo base_url(); ?>public/js/jquery-3.2.1.min.js"></script>
<!-- <script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.multi-select.js"></script>

<script src="<?php echo base_url(); ?>public/js/search_multivendor.js"></script>

<script type="text/javascript">
$('#category_id').change(function(){

    $('#category_id-error').hide();
});
$('#category_id').multiSelect({
    selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Search in selection'>",
    selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Search in selected'>",
  afterInit: function(ms){
    var that = this,
        $selectableSearch = that.$selectableUl.prev(),
        $selectionSearch = that.$selectionUl.prev(),
        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
    .on('keydown', function(e){
      if (e.which === 40){
        that.$selectableUl.focus();
        return false;
      }
    });

    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
    .on('keydown', function(e){
      if (e.which == 40){
        that.$selectionUl.focus();
        return false;
      }
    });
  },
  afterSelect: function(){
    this.qs1.cache();
    this.qs2.cache();
  },
  afterDeselect: function(){
    this.qs1.cache();
    this.qs2.cache();
  }
});
$('#select-all').click(function(){

    jQuery('#category_id').multiSelect('select_all');
});

    var url = $("#base_url").val();
    $(document).ready(function(){
         $('#name').focus();
    });

    var checkit = false;
    $('#brand_form').validate({
        rules: {
            name: {
                required: true,
                remote: {
                    url: url+'brand/isBrandAvailable',
                    type: 'post',
                    async : false,
                    data: {
                      id: function() {
                        return $("#id").val();
                        }
                    }
                },

            },
            'category_id[]': {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please enter brand name",
                remote : "Brand name already exist"
            },
            'category_id[]': {
                required: "Please select category"
            }
        },
        error: function(label) {
            $(this).addClass("error");
        },
         submitHandler: function (form) {
            $('.btn').attr('disabled','disabled');
            form.submit();    
        }
    });
</script>
<?php include('footer.php'); ?>