<?php
include('header.php');
error_reporting(0);
?>
<?php 
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
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'index.php/admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'index.php/admin/discount_list'; ?>">Discount</a> / <?php echo $reqName; ?></a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $reqName; ?> Discount
                    </header>
                    <form role="form" method="post" action="<?php echo base_url().'index.php/admin/discount_add_update'; ?>" name="discount_form" id="discount_form">
                        <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Start Discount(%)<span class="required" aria-required="true"> * </span></label>
                                        <input type="number" class="form-control margin_top_input" id="start_discount" name="start_discount" placeholder="Start discount" min="0" max="99" value="<?php echo $result['start_discount']; ?>">
                                        <span id="err1" style="color: red;"></span>
                                        <label id="start_discount-error" class="error" for="start_discount"></label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">End Discount(%)<span class="required" aria-required="true"> * </span></label>
                                        <?php if($result['end_discount'] == '99'){ ?>
                                            <input type="number" class="form-control margin_top_input" id="end_discount" min="0" max="99" name="end_discount" placeholder="End discount" value="">
                                        <?php } else { ?>
                                            <input type="number" class="form-control margin_top_input" id="end_discount" min="0" max="99" name="end_discount" placeholder="End discount" value="<?php echo $result['end_discount']; ?>">
                                        <?php } ?>
                                        <span id="err" style="color: red;"></span>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                
                                 <a href="discount_list" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>  
                                 <input type="submit" class="btn btn-info pull-right margin_top_label" value="<?php echo $reqName.' Discount'; ?>" name="submit">
                            </div>
                        </div>
                    </form>
                </section>
            </div>
            <!--Map Part-->
        </div>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<style> label.error { color: red; font-weight: 500; } </style>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script type="text/javascript">

$('#end_discount').on('change keyup blur',function(){
    end_validation();
});

$('#start_discount').on('change keyup blur',function(){
    start_validation();
});


function end_validation() {
   $('#err').html("");
    var st = $("#start_discount").val();
    var en = $("#end_discount").val();
    st = parseInt(st);
    en = parseInt(en);
    if(en!=''){
        
        if(st>en && st<=99){

            $('.btn-info').attr('disabled','true');
            $('#err1').html("");
            $('#err').html("Please enter end discount greater than start discount");
        }else{
            $('#err').html("");
            $('.btn-info').removeAttr('disabled');
        }
    }else{
        
            $('#err').html("");
    }
};

function start_validation() {
   $('#err1').html("");
    var st = $("#start_discount").val();
    var en = $("#end_discount").val();
    st = parseInt(st);
    en = parseInt(en);
    if(en!=''){
        
        if(st>en && st<=99){
            $('.btn-info').attr('disabled','true');
            $('#err1').html("Please enter start discount less than end discount");
        }else{
            $('#err').html("");
            $('#err1').html("");
            $('.btn-info').removeAttr('disabled');        
        }
    }else{
        
            $('#err').html("");
    }
};



    $('#discount_form').validate({
        rules: {
            start_discount: {
                required: true,
                number: true
            },
            end_discount: {
                required: true,
                number: true,
                min:1,
               // max:99,
            }
        },
        messages: {
            start_discount: {
                required: "Please enter start discount",
                number: "Please enter only number"
            },
            end_discount: {
                required: "Please enter end discount",
                number: "Please enter only number",
                min: "Please enter a value greater than start discount",
             //   max :"Please enter a value less than or equal to 100.",
            }
        },
        
        submitHandler: function (form) {
            $('.btn').attr('disabled','disabled');
            $(form).submit();
           
        }
    });
</script>
<?php include('footer.php'); ?>