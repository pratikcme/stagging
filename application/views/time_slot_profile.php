<?php include('header.php');
error_reporting(0);
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
                    <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'time_slot/time_slot_list'; ?>">Time Slot</a> / <?php echo $reqName; ?></a></li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>
        <div class="row">
            <!--Left Part-->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo $reqName; ?> Time Slot
                    </header>
                    <form role="form" method="post" action="<?php echo base_url().'time_slot/time_slot_add_update'; ?>" name="time_slot_form" id="time_slot_form">
                        <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="date">Start Time<span class="required" aria-required="true"> * </span></label>
                                        <div class="input-group date" id="open_time">
                                            <input type='text' class="form-control" id="start_time" name="start_time" placeholder="Select start time" value="<?php echo $result['start_time']; ?>"/>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                        <span id="ERRstart_time" style="color:red;">   </span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label for="date">End Time<span class="required" aria-required="true"> * </span></label>
                                    <div class="input-group date" id="close_time">
                                        <input type='text' class="form-control" id="end_time" name="end_time" placeholder="Select ending time" value="<?php echo $result['end_time']; ?>"/>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                  
                                    <span id="ERRend_time" style="color:red;"></span>
                                  
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                
                                 <a href="time_slot_list" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a>   
                                 <input type="submit" class="btn btn-info pull-right margin_top_label" value="<?php echo $reqName.' Time Slot'; ?>" name="submit">
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script src="http://cmexpertiseinfotech.in/grocery_multivendor/public/js/moment.min.js"></script>
<script type="text/javascript">
$("#start_time").on('blur',function(){ 
    $('#end_time').trigger('focus');
    $('#ERRstart_time').html('');
 });
$("#end_time").on('blur',function(){ 
    $('#start_time').trigger('focus');
    $('#ERRend_time').html('');
 });
$(".btn").on('change',function(){
   $(".btn").click();
});
    $(function () {
        $('#open_time').datetimepicker({format:'hh:mm A'});
        $('#close_time').datetimepicker({format:'hh:mm A'});
    });


    jQuery.validator.addMethod("greaterThan",
            function(value, element, params) {

                if (!/Invalid|NaN/.test(new Date(value))) {
                    return new Date(value) >= new Date($(params).val());
                }

                return isNaN(value) && isNaN($(params).val())
                    || (Number(value) >= Number($(params).val()));
            });

    $('#time_slot_form').validate({
        rules: {
            start_time: {
                required: true
            },
            end_time: {
                required: true,
                greaterThan : '#start_time'
            }
        },
        messages: {
            start_time: {
                required: "Select start time"
            },
            end_time: {
                required: "Select end time",
                greaterThan : 'end time must be greater than start time'
            }
        },
         errorPlacement: function(error, element) {
            var eid = element.attr('id');
            console.log(element);
            // if(eid!='start_time'){
            //      $('#ERRstart_time').html('');
            // }
            // if(eid!='end_time'){                
            //     $('#ERRstart_time').html('');
            // }
            if(eid=='start_time'){
                $('#ERR'+eid).html('Select start time');
            } if(eid=='end_time'){
                $('#ERR'+eid).html('Select end time');
            }
            console.log(eid);
        },
        submitHandler: function (form) {
                $('.btn').attr('disabled','disabled');
                $(form).submit();
            }
    });
</script>
<?php include('footer.php'); ?>