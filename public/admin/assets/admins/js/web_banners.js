var WEBBANNERS = function(){
		var url = $('#url').val();

     $(document).ready(function(){
                $('.alert').fadeOut(5000);
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

    var HandleAboutApp = function () {
    
        $('#frmAdd').validate({

            rules: {
                about: {required: true},
                website: { required: true,
                            url : true
                          },
                contact_number: { required: true,
                                  number : true
                                },
                email: { required: true,
                          email:true
                    },
          },
            messages: {
                about: {required: "Please enter about"},
                website: {
                  required: "Please enter website",
                  url : "Please enter website url"
              },
                contact_number: {required: "Please enter contact number",
                                 number : "Please enter number only"               
              },
                email : {required: "Please enter email",
                          email : "Please enter valid email"
              },
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
             // ignore: [], // using for ckeditor
              // debug: false,
             // ignore: " :hidden",
            rules: {
                main_title: {required: true},
                sub_title: {required: true},
                image : { required : true,
                            accept:"jpg,png,jpeg,gif"
                },
        },
            messages : {
                main_title : {required: "Please enter main title"},
                sub_title : {required: "Please enter sub title"},
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
             // ignore: " :hidden",
            rules: {
                    image : {
                    required: {depends: function (e) {
                            return ($('#hidden_image').val() === '');
                        },
                    },
                            accept:"jpg,png,jpeg,gif"
                },

                name: {required: true},
                designation: {required: true},
                content: { required: true },
            },
            messages: {
                image : {required: 'please select image',
                accept:"Only image type jpg/png/jpeg/gif is allowed"},
                name: { required: "Please enter name"},
                designation : {required: "Please enter designation"},
                content : {required: "Please enter content"},
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
      },
      appUpdate:function(){
        HandleAboutApp();
      }
    }

}();