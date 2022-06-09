var BANNERS = function(){
		var url = $('#url').val();
     $(document).ready(function(){
                $('.alert').fadeOut(5000);
            });

         $(document).on('change','#type',function(){
        var type = $(this).val();
        if(type == 1 || type == ''){
            $('#category').parent().css('display','none');
            $('#product').parent().css('display','none');
            $('#product_varient').parent().css('display','none');
        }

        if(type == 2){
            $('#category').parent().css('display','block');
            $('#product').parent().css('display','none');
            $('#product_varient').parent().css('display','none');
        }

        if(type == 3){
            $('#category').parent().css('display','none');
            $('#product').parent().css('display','block');
            $('#product_varient').parent().css('display','block');
        }

    });

     $(document).on('change','#branch',function(){
        var branch_id = $(this).val();
        if(branch_id != ''){
            $.ajax({
                url: url+'banners/get_category_list',
                type:'post',
                dataType:"json",
                data:{branch_id:branch_id},
                success:function(output){
                    console.log(output);
                    $('#category').html(output.category_list);
                    $('#product').html(output.product_list);
                    $('#type').removeAttr('disabled');
                    $('#product_varient').html('');
                    $('#product_varient').html(' <option value="">Select product varient</option>');

                }
            })
        }else{
            $('#category').parent().css('display','none');
            $('#product').parent().css('display','none');
            $('#product_varient').parent().css('display','none'); 
            $('#type').attr("disabled", true);
            $('#type').val("");

        }
     });

     $(document).on('change','#product',function(){
        var product_id = $(this).val();
            $.ajax({
                url: url+'banners/getproductVarient',
                type:'post',
                dataType:"json",
                data:{product_id:product_id},
                success:function(output){
                    console.log(output);
                    $('#product_varient').html(output.varient_list);
                }
            })
     });



	var HandleBannerImage = function () {
    
            $(document).ready(function(){
                $('.alert').fadeOut(5000);
            });
                
        $('#frmAddEditSection').validate({
             ignore: [],
             // ignore: " :hidden",
            rules: {
                image : {
                    required: {depends: function (e) {
                            return ($('#hidden_image').val() === '');
                        },
                    },
                            accept:"jpg,png,jpeg,gif"
            }},
            messages: {
                image : {required: 'please select image',
                accept:"Only image type jpg/png/jpeg/gif is allowed"},
            },
        
        });
    }

 var HandleSectionOne = function () {
    
        $('#frmAdd').validate({
             ignore: [],
              debug: false,
             // ignore: " :hidden",
            rules: {
                main_title: {required: true},
                sub_title: { required: function() 
                        {
                         CKEDITOR.instances.sub_title.updateElement();
                        }},
                image : {
                    required: {depends: function (e) {
                            return ($('#hidden_image').val() === '');
                        },
                    },
                            accept:"jpg,png,jpeg,gif"
            }
        },
            messages: {
                main_title: {required: "Please enter main title"},
                sub_title: {required: "Please enter sub title"},
                image : {required: 'please select image',
                accept:"Only image type jpg/png/jpeg/gif is allowed"},
            }, 
            submitHandler: function (form) {

                $('body').attr('disabled','disabled');
                $('#btnSubmit').attr('disabled','disabled');
                $('#btnSubmit').value('please wait');
                    $(form).submit();
            }
        
        });

    }


var HandleSectionTwo = function () {	


        $('#frmAddEdit').validate({
            rules: {
                main_title: { required: true },
                sub_title:  { required: true },
                branch: 	{ required: true },
                type: 		{ required: true },
                category_id: { required: true },
                product_id: { required: true },
                product_varient_id: { required: true },
                web_banner_image : { 
                	required : true,
                    accept:"jpg,png,jpeg,gif"
                },
               
                app_banner_image : { 
                	required : true,
                    accept:"jpg,png,jpeg,gif"
                },
        },
            messages : {
                main_title : {required: "Please enter main title"},
                sub_title : {required: "Please enter sub title"},
                branch : {required: "Please select branch"},
                type : {required: "Please select type"},
                category_id: { required: 'Please select category'},
                product_id: { required: 'Please select product'},
                product_varient_id: { required: 'Please select product_varient'},
                web_banner_image : {required: 'please select web image',
                accept:"Only image type jpg/png/jpeg/gif is allowed"},
                app_banner_image : {required: 'please select app image',
                accept:"Only image type jpg/png/jpeg/gif is allowed"},

            }, 
            submitHandler: function (form) {

                $('body').attr('disabled','disabled');
                $('#btnSubmit').attr('disabled','disabled');
                $('#btnSubmit').value('please wait');
                    $(form).submit();
            }
        
        });


    }

    var HandleSectionTwoTable = function(){   
         $(document).ready(function(){
            var url = $('#url').val(); 
              var dataTable = $('#section_two').DataTable({  
                   "processing":true,  
                   "serverSide":true,  
                   "order":[],  
                   // "columnDefs":[  
                   //      {  
                   //           "targets":[0,1],  
                   //           "orderable":false,  
                   //      },  
                   // ],  
              });  
         });
     }


    var HandleSectionTwoEdit = function () {

         $('#frmAddEdit').validate({
             ignore: [],
              debug: false,
             ignore: " :hidden",
            rules: {
                web_banner_image : {
                    required: {depends: function (e) {
                            return ($('#hidden_web_banner_image').val() === '');
                        },
                    },
                            accept:"jpg,png,jpeg,gif"
                },
                app_banner_image : {
                    required: {depends: function (e) {
                            return ($('#hidden_app_banner_image').val() === '');
                        },
                    },
                            accept:"jpg,png,jpeg,gif"
                },
                main_title: { required: true },
                sub_title:  { required: true },
                branch:     { required: true },
                type:       { required: true },
                category_id: { required: true },
                product_id: { required: true },
                product_varient_id: { required: true },
            },
            messages: {
                main_title : {required: "Please enter main title"},
                sub_title : {required: "Please enter sub title"},
                branch : {required: "Please select branch"},
                type : {required: "Please select type"},
                category_id: { required: 'Please select category'},
                product_id: { required: 'Please select product'},
                product_varient_id: { required: 'Please select product varient'},
                web_banner_image : {required: 'please select web image',
                accept:"Only image type jpg/png/jpeg/gif is allowed"},
                app_banner_image : {required: 'please select app image',
                accept:"Only image type jpg/png/jpeg/gif is allowed"},
            }, 
            submitHandler: function (form) {

                $('body').attr('disabled','disabled');
                $('#btnSubmit').attr('disabled','disabled');
                $('#btnSubmit').value('please wait');
                    $(form).submit();
            }
        
        });

    }

    
    var HandleRemoveRecord = function(){   
      
      var url = $('#url').val();
        $(document).on('click','.delete',function(){
            var id = $(this).val();
            var that = $(this);
            var x = confirm("Are you sure you want to delete?");
                if(x){    
                    $.ajax({
                        url: url+'admin/about/about_section_two/removeRecord',
                        type:'post',
                        data:{id:id},
                        success:function(output){
                                that.parent().parent().remove();
                        }
                    })
                }
        });
      }

    return {
    	init:function(){
    		HandleBannerImage();
    	},
    	add:function(){
    		HandleSectionTwo();
    	},
    	table:function(){
    		HandleSectionTwoTable();
    	},
    	edit:function(){
    		HandleSectionTwoEdit();
    	},
      delete:function(){
        HandleRemoveRecord();
      }
    }

}();