<?php include('header.php');
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
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'package/package_list'; ?>">Package</a> / <?php echo $reqName; ?></a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $reqName; ?> Package
                    </header>
                    <form role="form" method="post" action="<?php echo base_url().'package/package_add_update'; ?>" name="weight_form" id="weight_form">
                        <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="package_name" class="margin_top_label">Package Name<span class="required" aria-required="true"> * </span></label>
                                        <input type="text" class="form-control margin_top_input" id="package_name" name="package" placeholder="Package name" value="<?php echo $result['package']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <a href="<?=base_url().'package'?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a> 
                               <input type="submit" class="btn btn-info pull-right margin_top_label" value="<?php echo $reqName.' Package'; ?>" name="submit">
                            </div>
                        </div>
                    </form>
                </section>
                    <input type="hidden" id="base_url" value="<?=base_url()?>">
            </div>
            <!--Map Part-->
        </div>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<style> label.error { color: red; font-weight: 500; } </style>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script><script type="text/javascript">
    jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z ]+$/i.test(value);
}, "Please enter valid package name"); 
   
    var url = $('#base_url').val();
    $(document).ready(function(){
         // $('#name').trigger('click');
         $('#name').focus();
    });



    $('#weight_form').validate({
        rules: {
            package: {
                required: true,
                lettersonly: true,
                  remote: {
                    url: url+'package/isPakageAvailable',
                    type: 'post',
                    data: {
                      id: function() {
                        return $("#id").val();
                        }
                    },
                },
            }
        },
        messages: {
            package: {
                required: "Please enter package name",
                lettersonly: "Please enter valid package name",
                remote : "package name already exist"
            }
        },
        error: function(label) {
            $(this).addClass("error");
        },
        submitHandler: function (form) {
            var id =  $('#id').val();
           if(id == ''){
                $('#btnSubmit').attr('disabled','disabled');  
                form.submit();
           }else{
                form.submit();
           }        
        }

    });
</script>
<script type="text/javascript">
	
function testInput(event) {
   var value = String.fromCharCode(event.which);
   var pattern = new RegExp(/[a-zåäö ]/i);
   return pattern.test(value);
}

$('#name').bind('keypress', testInput);

</script>
<?php include('footer.php'); ?>