<?php include('header.php'); error_reporting(0);?>
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
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'price_list/price'; ?>"> Price </a> / <?php echo $reqName; ?></a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                         <?php echo $reqName; ?> Price
                    </header>
                    <form role="form" method="post" action="<?php echo base_url().'price_list/price_add_update'; ?>" name="price_form" id="price_form">
                        <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">Start Price<span class="required" aria-required="true"> * </span></label>
                                        <input type="text" class="form-control margin_top_input" id="start_price" name="start_price" placeholder="Start price" value="<?php echo $result['start_price']; ?>">
                                         <span id="err1" style="color: red;"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="name" class="margin_top_label">End Price<span class="required" aria-required="true"> * </span></label>
                                        <?php if($result['end_price'] == '9999999999'){ ?>
                                            <input type="text" class="form-control margin_top_input" id="end_price" name="end_price" placeholder="End price" value="">
                                        <?php } else { ?>
                                            <input type="text" class="form-control margin_top_input" id="end_price" name="end_price" placeholder="End price" value="<?php echo $result['end_price']; ?>">
                                        <?php } ?>
                                         <span id="err" style="color: red;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                            <a href="<?=base_url().'price_list/price'?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>   
                                 <input type="submit" class="btn btn-info pull-right margin_top_label" value="<?php echo $reqName.' Price'; ?>" name="submit">
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

$('#end_price').keyup(function(){
    $('#err').html("");
});
$('#start_price').keyup(function(){
    $('#err1').html("");
});
$('#end_price').blur(function(){
    // alert(0);
    var en = $(this).val();
    console.log(en);
    if(en.length > 0){
        var st = $("#start_price").val();
        st = parseInt(st);
        en = parseInt(en);
        if(st>=en){
            $('.btn-info').attr('disabled','true');
            $('#err').html("Please enter end price greater than start price");
        }else{
            $('#err').html("");
             $('#err1').html("");
            $('.btn-info').removeAttr('disabled');        
        }
    }else{
        $('#err').html("");
    }
});


$('#start_price').blur(function(){
    // alert(0);
    var en = $(this).val();
    console.log(en);
    if(en.length > 0){
        var st = $("#end_price").val();
        st = parseInt(st);
        en = parseInt(en);
        if(st<=en){
            $('.btn-info').attr('disabled','true');
            $('#err1').html("Please enter start price less than end price");
        }else{
            $('#err').html("");
             $('#err1').html("");
            $('.btn-info').removeAttr('disabled');        
        }
    }else{
        $('#err1').html("");
    }
});
    $('#price_form').validate({
        rules: {
            start_price: {
                required: true,
                number: true,
                
            },
            end_price: {
                required: true,
                number: true,
                
            }
        },
        messages: {
            start_price: {
                required: "Please enter start price",
                number: "Please enter only number"
            },
            end_price: {
                required: "Please enter end price",
                number: "Please enter only number"
            }
        },
        error: function(label) {
            $(this).addClass("error");
        },
        submitHandler: function (form) {
                $('.btn').attr('disabled','disabled');  
                $(form).submit();
                
            }
    });
</script>
<?php include('footer.php'); ?>