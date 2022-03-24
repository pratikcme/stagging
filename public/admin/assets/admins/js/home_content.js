  var HOME_CONTENT = function(){
		var url = $('#url').val();

     $(document).ready(function(){
                $('.alert').fadeOut(5000);
            });

var HandleSectionTwo = function () {	

        $('#frmAddEdit').validate({
             // ignore: [], // using for ckeditor
              // debug: false,
             // ignore: " :hidden",
            rules: {
                main_title: {required: true},
                sub_title: { required: true },
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
              var dataTable = $('#home_content').DataTable({   
                   "order":[],  
                   "columnDefs":[  
                        {  
                             "targets":[0,1],  
                             "orderable":false,  
                        },  
                   ],  
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

                main_title: {required: true},
                sub_title: { required: true },
            },
            messages: {
                image : {required: 'please select image',
                accept:"Only image type jpg/png/jpeg/gif is allowed"},
                main_title : {required: "Please enter main title"},
                sub_title : {required: "Please enter sub title"},
            }, 
            submitHandler: function (form) {

                $('body').attr('disabled','disabled');
                $('#btnSubmit').attr('disabled','disabled');
                $('#btnSubmit').value('please wait');
                    $(form).submit();
            }
        
        });

    }

     var HandleSectionOne = function () {
    
        $('#frmAdd').validate({
             ignore: [],
              debug: false,
             // ignore: " :hidden",
            rules: {
                main_title1: {required: true},
                number1: { 
                  required: true,
                  number : true,
                },
                image1 : {
                    required: {depends: function (e) {
                            return ($('#hidden_image1').val() === '');
                        },
                    },
                    accept:"jpg,png,jpeg,gif"
              },

               main_title2: {required: true},
                number2: { 
                  required: true,
                  number : true,
                },
                image2 : {
                    required: {depends: function (e) {
                            return ($('#hidden_image2').val() === '');
                        },
                    },
                    accept:"jpg,png,jpeg,gif"
              },

               main_title3: {required: true},
                number3: { 
                  required: true,
                  number : true,
                },
                image3 : {
                    required: {depends: function (e) {
                            return ($('#hidden_image3').val() === '');
                        },
                    },
                    accept:"jpg,png,jpeg,gif"
              },

               main_title4: {required: true},
                number4: { 
                  required: true,
                  number : true,
                },
                image4 : {
                    required: {depends: function (e) {
                            return ($('#hidden_image4').val() === '');
                        },
                    },
                    accept:"jpg,png,jpeg,gif"
              },
        },
            messages: {
                main_title1: {required: "Please enter main title1"},
                number1: {required: "Please enter number1"},
                image1 : {required: 'please select image1',
                accept:"Only image type jpg/png/jpeg/gif is allowed"},

                main_title2: {required: "Please enter main title2"},
                number2: {required: "Please enter number2"},
                image2 : {required: 'please select image2',
                accept:"Only image type jpg/png/jpeg/gif is allowed"},

                main_title3: {required: "Please enter main title3"},
                number3: {required: "Please enter number3"},
                image3 : {required: 'please select image3',
                accept:"Only image type jpg/png/jpeg/gif is allowed"},

                main_title4: {required: "Please enter main title4"},
                number4: {required: "Please enter number4"},
                image4 : {required: 'please select image4',
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


    return {
    	add:function(){
    		HandleSectionTwo();
    	},
    	table:function(){
    		HandleSectionTwoTable();
    	},
    	edit:function(){
    		HandleSectionTwoEdit();
    	},
      content_one:function(){
        HandleSectionOne();
      },
    }

}();