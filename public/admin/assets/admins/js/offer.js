var OFFER = function(){
		var url = $('#url').val();
     $(document).ready(function(){
        $('.alert').fadeOut(5000);
     });


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
            console.log(checked);
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
            console.log(checked);
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


        $('#frmAddEdit').validate({
            rules: {
                offer_title: { required: true },
                branch: 	{ required: true },
                offer_image : { 
                	required : true,
                    accept:"jpg,png,jpeg,gif"
                },
        },
            messages : {
                offer_title : {required: "Please enter offer title"},
                branch : {required: "Please select branch"},
                offer_image : {required: 'please select offer image',
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

        var inString = $('#hidden_varient_id').val();
        checked = inString.split(',');
      console.log(checked);
        $('#hidden_varient_id').val(checked);
        $('#Edit').validate({
            rules: {
                offer_title: { required: true },
                branch:     { required: true },
                offer_image : { 
                    required : {
                        depends : function (e){
                            return ($('#hidden_offer_image').val() === '');
                        }
                    },
                    accept:"jpg,png,jpeg,gif"
                },
        },
            messages : {
                offer_title : {required: "Please enter offer title"},
                branch : {required: "Please select branch"},
                offer_image : {required: 'please select offer image',
                accept:"Only image type jpg/png/jpeg/gif is allowed"},

            }, 
            submitHandler: function (form) {

                $('body').attr('disabled','disabled');
                $('#btnSubmit').attr('disabled','disabled');
                $('#btnSubmit').value('please wait');
                $(form).submit();
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