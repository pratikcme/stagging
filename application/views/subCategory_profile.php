<?php include('header.php');
error_reporting(0);
@$id = $this->utility->decode($_GET['id']);
if ($result['id'] != '') {
    $reqName = "Update";
} else {
    $reqName = "Add";
}
?>
<style type="text/css">
    .required {
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
                        <li class="active "><a href=""><i class="fa fa-home"></i> <a
                                        href="<?php echo base_url() . 'admin/dashboard'; ?>">Home</a> / <a
                                        href="<?php echo base_url() . 'subCategory'; ?>">Subcategory</a>
                                / <?php echo $reqName; ?></a></li>
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>
            <div class="row">
                <!--Left Part-->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo $reqName; ?> Subcategory
                        </header>
                        <form role="form" method="post"
                              action="<?php echo base_url() . 'subCategory/subCategory_add_update'; ?>"
                              name="subcategory_form" id="subcategory_form">
                            <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                            <input type="hidden" id="cat_id" value="<?php echo $cat_result['id']; ?>">
                            <div class="panel-body">
                                <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="margin_top_label">Category
                                            <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <select class="form-control margin_top_input" id="category_id"
                                                    name="category_id">
                                                <option value="" selected >Select Category</option>
                                                <?php foreach ($category_result as $cat) { ?>
                                                    <option value="<?php echo $cat->id; ?>" <?php if ($cat_result['id'] == $cat->id) { ?> selected <?php } ?>><?php echo $cat->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>


                                <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                    <div class="rows">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="margin_top_label">Subcategory Name<span
                                                        class="required" aria-required="true"> * </span></label>
                                            <input type="text" class="form-control subcat margin_top_input" id="name" name="name[]" placeholder="Enter subcategory name" value="<?php echo $result['name']; ?>">
                                        <span class="errr" style="color: red"></span>
                                        </div>
                                    </div>
                                    </div>

                                </div>
                                <div class="hide" style="display: none;">
                                    <div class="rows h">
                                        <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="name" class="margin_top_label">Subcategory Name<span
                                                        class="required" aria-required="true"> * </span></label>
                                            <input type="text" class="form-control subcat margin_top_input"
                                                   name="name[]" placeholder="Enter subcategory name"
                                                   value="">
                                            <span class="errr" style="color: red"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                            <a href="#"
                                               id="delete" class="btn btn-danger" style="margin: 23px -29px;"><i
                                                        class="fa fa-trash"></i></a></label>
                                    </div>
                                        </div>
                                </div>
                                </div>
                                <div class="add_subcate">

                                </div>




                                <?php
                                if ($id == '') { ?>
                                    <div class="row col-md-12">
                                        <input type="button" id="add" style="margin-left:44%;" class="btn btn-danger" value="Add More">
                                    </div>
                                <?php } ?>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <a href="<?=base_url().'subCategory'?>" style="float: right; margin-right: 10px;" id="delete_user"
                                       class="btn btn-danger">Cancel</a>
                                    <input type="submit" class="btn btn-info pull-right margin_top_label submit"
                                           value="<?php echo $reqName . ' Subcategory'; ?>" name="submit">

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
    <style> label.error {
            color: red;
            font-weight: 500;
        } </style>
    <script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script> -->
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {

            $('#add').click(function () {

                var a = $('.hide').html();
                $('.add_subcate').append(a);

            });
        })

        $(document).on('click', '#delete', function () {

            $(this).closest('.h').remove();

        });


        $('#subcategory_form').validate({
            rules: {
            //     'name[]': {
            //         required: true
            // }
            //     },
                category_id: {
                    required: true
                }
            },
            messages: {
                // 'name[]': {
                //     required: "Please enter subcategory name"
                // },
                category_id: {
                    required: "Please select category"
                }
            },
            error: function (label) {
                $(this).addClass("error");
            },
            submitHandler: function (form) {

                error = getSkillError();
                if (error == 0) {

                    $('.btn').attr('disabled', 'disabled');
                    $(form).submit();

                }
            }
        });



        function getSkillError() {

            var arr_name = [];
            var error = 0;
            $('.subcat').each(function () {
                var abc = $(this);
                if ($(this).is(':visible')) {

                    if ($(this).val() == '' ) {

                        error++;
                        $(this).next().html("Please enter subcategory name");
                    } else {
                        var name = $(this).val();

                        if ($.inArray(name,arr_name) !== -1 ) {

                            abc.next().html("Please remove  same subcategory ");
                            error++;
                        }
                        else {
                            $(this).next().html('');
                        }

                        arr_name.push(name);
                        console.log(arr_name);
                        // error = 0;
                        // $(this).next().html('');
                    }





                }
            });

            return error;
        }

    var  id = '';
    $(document).on('change','#category_id',function(){
            id = $(this).val();
    })

     $(document).on('blur','.subcat',function () {

            var name = $(this).val();
            var abc = $(this);
            var subcatId = $('#id').val();
            var catId = '';
            if(subcatId == ''){
                var catId = id;
            }
            // alert(subcatId);
            $.ajax({
                url: "<?php echo base_url().'subCategory/get_valid_subcate'?>",
                type: "post",
                data:{ name:name,subcatId:subcatId,catId:catId},
                async : false,
                success:function (data) {

                    var data =parseInt(data);
                    if(data == 1){
                        abc.next().html("This subcategory already exist");
                        $('.submit').attr('disabled', 'disabled');
                    }
                    else{
                        $('.submit').removeAttr('disabled');
                        abc.next().html("");

                    }
                }

            })
        })


    </script>

<?php include('footer.php'); ?>