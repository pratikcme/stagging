var OFFER = function(){
		var url = $('#url').val();
     $(document).ready(function(){
        $('.alert').fadeOut(5000);
     });

  function isNotEmptyValidation(){
            var val = 0; 
            var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
            $('.discount_per').each(function () {
                var ni = $(this).val();
                if(ni == ''){
                    $(this).next('div').find('label').html('Please enter correct value');
                    val = 1; 
                }else 
                if((numberRegex.test(ni) == false) || ni.length > 2){
                    $(this).next('div').find('label').html('Only 2 digits number is allowed');
                    val = 1;
                }else{
                     $(this).next('div').find('label').html(' ');
                }

            })
            return val;
        }


    var HandleTable = function(){

    $(document).on('change','#branch',function () {
        // alert();
            var url = $('#url').val();
            var branch_id = $(this).val();
               $('#example_product_offer').DataTable({ 
                   "destroy": true, 
                   "processing":true,  
                   "serverSide":true,  
                   "order":[],  
                   "ajax":{  
                        url: url+"offer/showProduct",  
                        type:"POST",
                        data : { branch_id : branch_id }
                   },  
                   createdRow: function ( tr ) {
                        $(tr).addClass('gradeX');
                        },
                       "columnDefs":[  
                            {
                                'targets':[0],
                                "orderable" : false, 
                            },
                            {  className:"hidden-phone", "targets":[0,1,2,3,4,5]},
                       ],
                        "oLanguage": {
                        "sEmptyTable" : "Product list Not Available",
                        "sZeroRecords": "Product Not Available",
                        }  
                   // bFilter: false,  
              });
            
        });
         
            var url = $('#url').val();
              var dataTable = $('#example_product_offer').DataTable({
                       // "processing":true,  
                       // "serverSide":true,  
                       "order":[],  
                       // "ajax":{  
                       //      url: url+"offer/showProduct",  
                       //      type:"POST",
                       // },
                       createdRow: function ( tr ) {
                        $(tr).addClass('gradeX');
                        },
                       "columnDefs":[  
                            {
                                'targets':[0],
                                "orderable" : false,
                                'checkboxes': {'selectRow': true
            }  
                            },
                            {  className:"hidden-phone", "targets":[0,1,2,3,4,5]},
                       ],
                        'select': {
                                'style': 'multi'
                        },
                        "oLanguage": {
                        "sEmptyTable" : "Product list Not Available",
                        "sZeroRecords": "Product Not Available",
                        }  
              });

        checked = [];
        $(document).on('click','.checked_id',function () {
            var id =  $(this).val();
            if( $(this).is(':checked') ){
                checked.push(id);
            }else{
                checked = jQuery.grep(checked, function(value) {
                    return value != id;
                });
                // checked.push(id);
                // checked.splice( $.inArray(id, checked),id);
            }
            // console.log(checked);
            $('#hidden_varient_id').val(checked);
        })
     }




	var HandleImage = function () {
    
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
      var varient_id = [];
      $(document).on('click','.checkbox_user',function(){
        $(this).each(function(){
            var id = $(this).val();

            if( $(this).is(':checked') ){
                varient_id.push(id);
            }else{
                varient_id = jQuery.grep(varient_id, function(value) {
                    return value != id;
                });
            } 
        })
        console.log(varient_id);
    })  

      $(document).on('click','#add',function (){
            // $('.checked_id').
            var branch_id = $('#branch_id').val();
            var checkedNum = $('input[type=checkbox]:checked').length;
            if(checkedNum == 0 && varient_id.length === 0){
                alert('please select varient');
                return false;
            }else{
                console.log(varient_id);
                $.ajax({
                    url: url+'offer/getselectedVarient',
                    type:'post',
                    data:{branch_id:branch_id,varient_ids:varient_id},
                    dataType : "Json",
                    success:function(output){
                        $('#append_selected_varient').html(output.html);
                        $('#myModal').modal('show');
                    }
                })
            }


        })

        $('#frmAddEdit').validate({
            rules: {
                offer_title: { 
                    required: true,
                },
                branch: 	{ required: true },
                offer_image : { 
                	required : true,
                    accept:"jpg,png,jpeg,gif"
                },
                offer_percent : { 
                    required : true,
                    digits : true,
                    maxlength : 2
                },
                start_date: {
                    required : true,
                    date : true
                },
                end_date: {
                    required : true,
                    date : true
                },
                start_time: {
                    required : true,
                },
                end_time: {
                    required : true,
                }
        },
            messages : {
                offer_title : {required: "Please enter offer title"},
                branch : {required: "Please select branch"},
                offer_image : { required: 'please select offer image',
                                accept:"Only image type jpg/png/jpeg/gif is allowed"
                            },
                offer_percent : { required: "Please enter offer percent" },
                start_date : { required : "Please select start date" },
                end_date : { required : "Please select end date" },
                start_time : { required : "Please select start time" },
                end_time : { required : "Please select end time" },

            }, 
            submitHandler: function (form) {
            // bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
            //      if (confirmed == true) {
                var check = isNotEmptyValidation();
                if(check == '0'){
                    $('body').attr('disabled','disabled');
                    $('#btnSubmit').attr('disabled','disabled');
                    $('#btnSubmit').value('please wait');
                    $(form).submit();
                }
            //     }
            // });
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
        var varient_ids = [];
        var ids = $('#hidden_varient_id').val();
            varient_ids = ids.split(',');
        console.log(varient_ids);
        $('.checkbox_user').each(function(){
            if( $(this).is(':checked') ){
                varient_ids.push($(this).val());
            }
        })
        console.log(varient_ids);
      $(document).on('click','.checkbox_user',function(){
        $(this).each(function(){
            var id = $(this).val();

            if( $(this).is(':checked') ){
                varient_ids.push(id);
                $('#hidden_varient_id').val(varient_ids);
            }else{
                varient_ids = jQuery.grep(varient_ids, function(value) {
                    return value != id;
                });
            } 
        })
        console.log(varient_ids);
    })  
        $(document).on('click','#add',function (){
            var branch_id = $('#branch_id').val();
            // var varient_id = [];
            var checkedNum = $('input[type=checkbox]:checked').length;
            if(checkedNum == 0 && varient_ids.length === 0){
                alert('please select varient');
                return false;
            }else{
                $.ajax({
                    url: url+'offer/getselectedVarient',
                    type:'post',
                    data:{branch_id:branch_id,varient_ids:varient_ids},
                    dataType : "Json",
                    success:function(output){
                        $('#append_selected_varient').html(output.html);
                        $('#myModal').modal('show');
                    }
                })
            }


        })


        $('#Edit').validate({
            rules: {
                offer_title: { required: true },
                offer_percent: { required: true,  digits : true, maxlength : 2 },
                branch:     { required: true },
                offer_image : { 
                    required : {
                        depends : function (e){
                            return ($('#hidden_offer_image').val() === '');
                        }
                    },
                    accept:"jpg,png,jpeg,gif"
                },
                start_date: {
                    required : true,
                    date : true
                },
                end_date: {
                    required : true,
                    date : true
                },
                start_time: {
                    required : true,
                },
                end_time: {
                    required : true,
                }
        },
            messages : {
                offer_title : {required: "Please enter offer title"},
                offer_percent : {required: "Please enter offer percent"},
                branch : {required: "Please select branch"},
                offer_image : {required: 'please select offer image',
                accept:"Only image type jpg/png/jpeg/gif is allowed"},
                start_date : { required : "Please select start date" },
                end_date : { required : "Please select end date" },
                start_time : { required : "Please select start time" },
                end_time : { required : "Please select end time" },

            }, 
            submitHandler: function (form) {
                var check = isNotEmptyValidation();
                if(check=='0'){
                $('body').attr('disabled','disabled');
                $('#btnSubmit').attr('disabled','disabled');
                $('#btnSubmit').value('please wait');
                $(form).submit();
                }
            }
        
        });



        //  $('#frmAddEdit').validate({
        //      ignore: [],
        //       debug: false,
        //      ignore: " :hidden",
        //     rules: {
        //         web_banner_image : {
        //             required: {depends: function (e) {
        //                     return ($('#hidden_web_banner_image').val() === '');
        //                 },
        //             },
        //                     accept:"jpg,png,jpeg,gif"
        //         },
        //         app_banner_image : {
        //             required: {depends: function (e) {
        //                     return ($('#hidden_app_banner_image').val() === '');
        //                 },
        //             },
        //                     accept:"jpg,png,jpeg,gif"
        //         },
        //         main_title: { required: true },
        //         sub_title:  { required: true },
        //         branch:     { required: true },
        //         type:       { required: true },
        //         category_id: { required: true },
        //         product_id: { required: true },
        //         product_varient_id: { required: true },
        //     },
        //     messages: {
        //         main_title : {required: "Please enter main title"},
        //         sub_title : {required: "Please enter sub title"},
        //         branch : {required: "Please select branch"},
        //         type : {required: "Please select type"},
        //         category_id: { required: 'Please select category'},
        //         product_id: { required: 'Please select product'},
        //         product_varient_id: { required: 'Please select product varient'},
        //         web_banner_image : {required: 'please select web image',
        //         accept:"Only image type jpg/png/jpeg/gif is allowed"},
        //         app_banner_image : {required: 'please select app image',
        //         accept:"Only image type jpg/png/jpeg/gif is allowed"},
        //     }, 
        //     submitHandler: function (form) {
        //         $('body').attr('disabled','disabled');
        //         $('#btnSubmit').attr('disabled','disabled');
        //         $('#btnSubmit').value('please wait');
        //             $(form).submit();
        //     }
        
        // });

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
    		HandleImage();
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
      },
      table: function () {
        HandleTable();
      }
    }

}();