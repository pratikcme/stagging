
// ========== NOTIFICATION ========
$(function() {

  // Dropdown toggle
  $('.notify-dropdown').click(function() {
    $(this).next('.dropdown').toggle( 400 );
  });

  $(document).click(function(e) {
    var target = e.target;
    if (!$(target).is('.notify-dropdown') && !$(target).parents().is('.notify-dropdown')) {
      $('.notify-drop').hide() ;
    }
  });

});

$(document).ready(function() {
  $(".notification-drop .item").on('click',function() {
    // $(this).find('ul').toggle();
    
    $(this).find('ul').removeClass('d-none');
    $(this).find('ul').addClass('d-block');
    setTimeout(() => {
      $(".notification-list").addClass("open")
    }, 500);

  });
});

$('body').click(function(){
  if($('.notification-list').hasClass('open')){
  
     $('.notification-list').addClass('d-none');
    $('.notification-list').removeClass('d-block');
    $(".notification-list").removeClass("open")
  }
 
});




// check out payment option of self
$(document).ready(function() {
  $(".self-group-main .option-1").click(function() {
    if ($(this).find(".groupChk").is(":checked")){
      $(".group-name-select-wrap").removeClass("d-none");
      $(".billing-btns.payment-option.active").next().css("minHeight","450px");  
      
    }else{
      $(".group-name-select-wrap").addClass("d-none");
      $(".billing-btns.payment-option.active").next().css("minHeight","375px");  
    }
  });
});


// ======== VENDOR DEFAULT CHECKBOX CSS===

$(".vendor-chk").click(function() {
      
  $('.vendor-chk').prop('checked', false);
  $(this).prop('checked', true);
  $(".address-chk-box").removeClass("checked");
   if($(this).is(':checked'))
    { 
      $(this).parent().parent().addClass("checked");
    }
});

st_price = '';
en_price = '';

// var incrementPlus;
// var incrementMinus;

// var buttonPlus  = $(".cart-qty-plus");
// var buttonMinus = $(".cart-qty-minus");
// var incrementPlus = buttonPlus.click(function() {

// quantityField = $(this).prev();

// quantityField.val(parseInt(quantityField.val()) + 1);

// });

// var incrementMinus = buttonMinus.click(function() {
//  quantityField = $(this).next();
//   if (quantityField.val() > 0 ) {
//         quantityField.val(parseInt(quantityField.val()) - 1);
//   }else{
//     return;
//   }
// });


// var incrementPlus;
// var incrementMinus;

// var buttonPlus  = $(".cart-qty-plus_c");
// var buttonMinus = $(".cart-qty-minus_c");

// var incrementPlus = buttonPlus.click(function() {
// quantityField = $(this).prev();

// quantityField.val(parseInt(quantityField.val()) + 1);

// });

// var incrementMinus = buttonMinus.click(function() {
//  quantityField = $(this).next();
//   if (quantityField.val() == 0 ) {
//         quantityField.val(parseInt(quantityField.val()) - 1);
//   }else{
//     return;
//   }
// });


$(document).on("click",".cart-qty-plus",function(){
  console.log("buttonPlus");
})

//=========== PAYMENT DISPLAY OPTION ===========
// $('.pay-chk').click(function() {
//    let val;
//    if($(this).is(':checked'))
//     { 
//      val = $(this).val();
//       if(val == "credit"){
//         $(".netbanking-wrapper").hide();
//           $(".cod-wrapper").hide();
//         $(".debit-wrapper").show();
//       }
//       else if(val == "netbanking"){
//          $(".cod-wrapper").hide();
//         $(".debit-wrapper").hide();
//         $(".netbanking-wrapper").show();
//       }else if (val == "cod"){
//          $(".debit-wrapper").hide();
//         $(".netbanking-wrapper").hide();
//         $(".cod-wrapper").show();
//       }
//     }
// });

//=========== HOVER EFFECT OF CSS ===========
$(".cvv-info").mouseover(function(){
 $(".css-detail").show();
});
$(".cvv-info").mouseout(function(){
 $(".css-detail").hide();
});

//===========DATEPICKER CHECKOUT=====
var is_self_pickup = $('#CheckisSelfPickup').val();

if(is_self_pickup == 0){
  var minDate = 2;
  var maxDate = "2d";
}else{
  var minDate = 0; 
  var maxDate = "6d";
}

$(function() {
   if($("#datepicker").length){
    $("#datepicker").datepicker(
        {
          minDate: minDate,
          maxDate : maxDate,
          dateFormat: 'D,dd-mm-yy'
        }
      );
  }
});


//=========== ACCORDION IN CHECKOUT=====
var acc = document.getElementsByClassName("billing-btns");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    $(".panel").removeClass("full_height");
      this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}


//=========== ADD NEW ADDRESS FORM HIDE AND SHOW IN CHECKOUT=====
$(".add-new-address").click(function(){
  $("#billing-new-add").fadeIn();
  $("#billing-add").fadeOut();
})

$(document).on("click",".cancel-btn",function(e){
  e.preventDefault();
   $("#billing-new-add").fadeOut();
  $("#billing-add").fadeIn();
})

// //=========== TABLE RESPONSIVE=====
//  $("table").rtResponsiveTables({
//     // containerBreakPoint: 360
//     });


//=========== ADD TO WHISLIST ACTIVE =====
// $(".wishlist-icon").click(function(){
//     let heart = $(this).children();
//     heart.toggleClass("fas .fa-heart");
// })

//=========== PRODUCT VARIANT ACTIVE =====
$(".variant").click(function(){
  $(".variant").removeClass("active");
  $(this).addClass("active");
})

//=========== ADD NEW ADDRESS FORM HIDE AND SHOW =====
$(".add-new-address").click(function(){
  $("#new-address-wrap").fadeIn();
  $("#address-header").fadeOut();
})


$(document).on("click",".cancel-btn",function(e){
  e.preventDefault();
   $("#new-address-wrap").fadeOut();
  $("#address-header").fadeIn();
})

//======= YOUR ORDER DETAILS HIDE AND SHOW ======= 
$(".details").click(function(){
    $(".your-order-wrapper").removeClass("open-detail");  
    $(".arrow-down").removeClass("rotate-open"); 

     let yourOrderWrapper = $(this).parent().parent();
     let arrow =  $(this).children(); 

   if((yourOrderWrapper).hasClass(".open-detail")){
    alert(0);
     yourOrderWrapper.removeClass("open-detail");
     arrow.removeClass("rotate-open");
   }
   else{
    arrow.addClass("rotate-open");
    yourOrderWrapper.addClass("open-detail");
   }
})

$(document).on('click','.accordion ',function(){
    if($(this).hasClass('active')){
      $(this).removeClass('active');
      $(this).next('div').removeAttr('style');
    }else{
      $(this).addClass('active');
      $(this).next('div').css('max-height','100%');
    }
})

//======= ACCORDION FOR FILTER MENU ======= 
  $('.accordion').find('.accordion-title').on('click', function(){
    // Adds Active Class
    $(this).toggleClass('active');
    // Expand or Collapse This Panel
    $(this).next().slideToggle('fast');
    // Hide The Other Panels
    $('.accordion-content').not($(this).next()).slideUp('fast');
    // Removes Active Class From Other Titles
    $('.accordion-title').not($(this)).removeClass('active');   
  });


//=====PRICE RANGRE SLIDER====

var siteCurrency = $('#siteCurrency').val();
$(function() {
  $("#slider-range").slider({
    range: true,
    min: 0,
    max: 10000,
    values: [ 0, 0 ],
    slide: function( event, ui ) {
      $('#siteCurr').remove();
    $( "#amount" ).val( siteCurrency+' '+ ui.values[ 0 ] +"-"+ siteCurrency  + ui.values[ 1 ] );
      var cat_id = $('#cat_id').val();
      var sub_id = $('#sub_cat_id').val();  
      st_price = ui.values[ 0 ];
      en_price = ui.values[ 1 ];
      onload(1,sub_id,cat_id,sort = '',search='',st_price,en_price);
    }
  });
  
  $( "#amount" ).val($( "#slider-range" ).slider( "values", 0 ) +
    "-" + $( "#slider-range" ).slider( "values", 1 ) );
});

  function onload(page,sub_id='',cat_id='',sort = '',search='',start_price,end_price){

            var search =  $('#search_product').val();
            var url = $('#url').val();
            var rangeArray = [];
            var getCatByURL = $('#getBycatID').val();
            // var rangeArray = get_filter('range');
            // var rangeArray = $('#start_range').val();
            // alert(rangeArray);
            var discountArray = get_filter('discount');
            var brandArray = get_filter('brand');
            var slider = '1';
            $.ajax({  
                url : url+'products/subcategory/'+page,
                data:{
                  search:search,sort:sort,
                  sub_id:sub_id,cat_id:cat_id,
                  brandArray:brandArray,
                  start_price:start_price,
                  end_price : end_price,
                  discountArray:discountArray,
                  page:page,getCatByURL:getCatByURL,
                  slider : slider
                },
                method:'post',
                dataType:'json',
               success:function(output){
                    // console.log(output);
                    $('#ajaxProduct').html(output.result);

                    
                    if(cat_id != ''){
                      $('#sd').css('display','block');
                      $('#short').html(output.short_li);
                      $('#long').html(output.long_li);
                    }else{
                      $('#sd').css('display','none');
                    }
                    $('.cate_id').each(function(){
                         var value = $(this).data('cate_id');
                          if(cat_id == value){
                              $(this).addClass('active');
                          }else{
                              $(this).removeClass('active');
                          }
                    });
                    $('.sub_cat_link').removeClass('active_sub');
                    $('.sub_cat_link').each(function(){
                         var val = $(this).data('sub_id');
                          if(sub_id == val){
                              $(this).addClass('active_sub');
                          }
                    });
                }
             })
        }

//=======FILTER HIDE AND SHOW=======
$(".filter-icon").click(function(){
  $(".filter-dropdown").addClass("show");
  if($(".cart-view-wrap").hasClass("cart-visible")){
  	 $('.cart-view-wrap').removeClass('cart-visible w3-animate-top');
    $("body").removeClass("backdrop");
  }

})

$(document).on("click" , ".closing", function(){
  $(".filter-dropdown").removeClass("show");


})

$(".filter-wrapper .dropdown button").click(function(){
  $(".filter-dropdown").removeClass("show");

})



//=======CATEGORY SUBCATEGORY FILTER=======
$(".sub-cat-main").click(function(){
 if ($(this).hasClass("show")) {
        $(this).removeClass("show");
    }else{
      $(".sub-cat-main").removeClass("show");
      $(this).addClass("show");
      $(".subcategory-wrap").addClass("animate-left");
    }
});



//=======PASSWORD HIDE & SHOW=======
$("#eye").click(function(e){
   var child =$(this).children();
   child.toggleClass("fa-eye fa-eye-slash");
    //$(this).toggleClass("fa-eye fa-eye-slash");
    var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }

})

$("#ceye").click(function(e){
   var child =$(this).children();
   child.toggleClass("fa-eye fa-eye-slash");
    //$(this).toggleClass("fa-eye fa-eye-slash");
    var x = document.getElementById("confirm_password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }

})


 //=======LOCATION POP ON LOAD=======
   $(window).on('load', function() {
    var location_set = $('#is_set').val();
      if(location_set == '0'){
          $('.location-popup').modal('show');
      }
    });


 //=======ADD BODY BACKDROP =======
function addBackDrop(){
  setTimeout(function(){
  $("body").addClass("backdrop");
},500);
}

 //======= REMOVE BODY BACKDROP =======
function removeBackDrop(){
  $("body").removeClass("backdrop");
}


// =======SHOW PROFILE MENU======= 
$(".user-logged").click(function(){
  if($("body").hasClass("backdrop")){
      $("body").removeClass("backdrop");
    }
addBackDrop();

	if($(".filter-dropdown").hasClass("show")){
		$(".filter-dropdown").removeClass("show");
	}

if($(".cart-view-wrap").hasClass("cart-visible"))
{
  $(".cart-view-wrap").removeClass("cart-visible");
  $(".cart-view-wrap").removeClass("w3-animate-top"); 
}

$(".user-profile").toggleClass("user-profile-visible");
$(".down-arrow").toggleClass("rotate-open");
$(".user-profile").addClass("w3-animate-top");
});



// =======SHOW PROFILE MENU IN MOBILE MENU======= 
$(document).on("click",".mobile-login-user", function(){
  if($("body").hasClass("backdrop")){
      $("body").removeClass("backdrop");
    }
addBackDrop();
  if($(".cart-view-wrap").hasClass("cart-visible"))
  {
    $(".cart-view-wrap").removeClass("cart-visible");
    $(".cart-view-wrap").removeClass("w3-animate-top"); 
  }
  $(".user-profile").addClass("user-profile-visible");
  $(".down-arrow").addClass("rotate-open");
  $(".user-profile").addClass("w3-animate-top");
});



// =================  CLOSING MODAL USING BODY  ==================
$(document).on("click" , ".backdrop", function(){
removeBackDrop();

// =====CLOSING PROFILE MODAL
$(".user-profile").removeClass("user-profile-visible");
$(".down-arrow").removeClass("rotate-open");
$(".user-profile").removeClass("w3-animate-top");

  // =====CLOSING CART MODAL
$(".cart-view-wrap").removeClass("cart-visible");
$(".cart-view-wrap").removeClass("w3-animate-top");

  
 // =====CLOSING FILTER MODAL
$(".filter-dropdown").removeClass("show");
// $(".cart-view-wrap").removeClass("w3-animate-top");


})









// =======SHOW CART======= 
  $(".cart-wrap").click(function(){
    if($("body").hasClass("backdrop")){
      $("body").removeClass("backdrop");
    }
    	if($(".filter-dropdown").hasClass("show")){
		$(".filter-dropdown").removeClass("show");
	}
    addBackDrop();
   if ($(".user-profile").hasClass("user-profile-visible")) {
     $(".user-profile ").removeClass("user-profile-visible");
     $(".user-profile ").removeClass("w3-animate-top");
     $(".down-arrow").removeClass("rotate-open");
     $("body").removeClass("backdrop");

    }
    
    $(".cart-view-wrap").addClass("cart-visible");
    $(".cart-view-wrap").addClass("w3-animate-top");
     
  }) ;

   


  $(".cart-view-header span.closing").click(function(){
     $(".cart-view-wrap").removeClass("cart-visible");
    $(".cart-view-wrap").removeClass("w3-animate-top");
  removeBackDrop();
  })


//  //=======SCROLL TO TOP=======
//  $(document).ready(function(){ 
//     $(window).scroll(function(){ 
//         if ($(this).scrollTop() > 100) { 
//             $('.scroll-top').fadeIn(); 
//         } else { 
//             $('.scroll-top').fadeOut(); 
//         } 
//     }); 
//     $('#scrollTop').click(function(){ 
//         $("html, body").animate({ scrollTop: 0 }, 600); 
//         return false; 
//     }); 
// });

  
 //=======INITIAL WOW JS=======
new WOW().init();
              

  


$(".minus-btn").click(function(){
  var val = $(this).children().val();
  console.log(val);
  val =  val+1;
  console.log(val);
}) 


$(".plus-btn").click(function(){
  alert(0);
})  




//  header searchbar auto suggest

$(document).on("click","body",function(){
  $('#ui-id-1').detach().appendTo('.searchBar'); 
});
 

//======= YOUR ORDER DETAILS HIDE AND SHOW ======= 
$(".details").click(function(){
    

    let yourOrderWrapper = $(this).parent().parent();
    let arrow =  $(this).children(); 

    // $(".your-order-wrapper").removeClass("open-detail");  
    // $(".arrow-down").removeClass("rotate-open");    
    // $(".details").removeClass("abc");
    

   if($(this).hasClass("abc")){
     yourOrderWrapper.removeClass("open-detail");
     arrow.removeClass("rotate-open");
     $(this).removeClass("abc");
   } 
   else{

  
  $(".your-order-wrapper").removeClass("open-detail");  
  $(".arrow-down").removeClass("rotate-open");    
  $(".details").removeClass("abc");

    $(this).addClass("abc");
    arrow.addClass("rotate-open");
    yourOrderWrapper.addClass("open-detail"); 
   } 

})


$(".add-new-address").click(function(){
    setTimeout(function(){
      $(".address_panel").addClass("full_height");
      $(".address_panel").css("maxHeight","auto !important");
    },100)  
})


$(".edit_address").click(function(){
    setTimeout(function(){
      $(".address_panel").addClass("full_height");
      $(".address_panel").css("maxHeight","auto !important");
    },100)  
})



// $(document).on("click",".backdrop", function(){
$(".dropdown-toggle").click(function(){
  if($('.cart-view-wrap').hasClass('cart-visible')){
    $('.cart-view-wrap').removeClass('cart-visible w3-animate-top');
    $("body").removeClass("backdrop");
  }

  if($('.user-profile').hasClass('user-profile-visible')){
    $('.user-profile').removeClass('user-profile-visible w3-animate-top');
    $("body").removeClass("backdrop");
  }
})



//   if($(".user-profile").hasClass("user-profile-visible")){
//     $(".user-profile").removeClass("user-profile-visible w3-animate-top");
//     $("body").removeClass("backdrop");
//   }


$(".option-1").click(function(){
  var input = $(this).find("input");
  input.prop('checked', true);
})


$(document).ready(function() {
    
  var readURL = function(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('.profile-pic').attr('src', e.target.result);
          }
  
          reader.readAsDataURL(input.files[0]);
      }
  }
  

  $(".file-upload").on('change', function(){
      readURL(this);
  });
  
  $(".upload-button").on('click', function() {
     $(".file-upload").click();
  });

})



//  number scroll

// var counted = 0;
// $(window).scroll(function() {

//   var oTop = $('#counter').offset().top - window.innerHeight;
//   if (counted == 0 && $(window).scrollTop() > oTop) {
//     $('.count').each(function() {
//       var $this = $(this),
//         countTo = $this.attr('data-count');
//       $({
//         countNum: $this.text()
//       }).animate({
//           countNum: countTo
//         },

//         {

//           duration: 2000,
//           easing: 'swing',
//           step: function() {
//             $this.text(Math.floor(this.countNum));
//           },
//           complete: function() {
//             $this.text(this.countNum);
//             //alert('finished');
//           }

//         });
//     });
//     counted = 1;
//   }

// });



// 


// if($(window).width() < 1400) {
//   $('.xzoom-preview').css('left','1600px !important'); 
//   // change functionality for smaller screens
// } 



// if($(window).width() < 1800) {
//   $('.xzoom-preview').css('left','1600px !important'); 
//   // change functionality for smaller screens
// } 


// else {
//   $('.xzoom-preview').css('left','0 !important');
//    // change functionality for larger screens
// }




// auto suggestion



// function autocomplete(inp, arr) {
//   /*the autocomplete function takes two arguments,
//   the text field element and an array of possible autocompleted values:*/
//   var currentFocus;
//   /*execute a function when someone writes in the text field:*/
//   inp.addEventListener("input", function(e) {
//       var a, b, i, val = this.value;
//       /*close any already open lists of autocompleted values*/
//       closeAllLists();
//       if (!val) { return false;}
//       currentFocus = -1;
//       /*create a DIV element that will contain the items (values):*/
//       a = document.createElement("DIV");
//       a.setAttribute("id", this.id + "autocomplete-list");
//       a.setAttribute("class", "autocomplete-items");
//       /*append the DIV element as a child of the autocomplete container:*/
//       this.parentNode.appendChild(a);
//       /*for each item in the array...*/
//       for (i = 0; i < arr.length; i++) {
//         /*check if the item starts with the same letters as the text field value:*/
//         if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
//           /*create a DIV element for each matching element:*/
//           b = document.createElement("DIV");
//           /*make the matching letters bold:*/
//           b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
//           b.innerHTML += arr[i].substr(val.length);
//           /*insert a input field that will hold the current array item's value:*/
//           b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
//           /*execute a function when someone clicks on the item value (DIV element):*/
//           b.addEventListener("click", function(e) {
//               /*insert the value for the autocomplete text field:*/
//               inp.value = this.getElementsByTagName("input")[0].value;
//               /*close the list of autocompleted values,
//               (or any other open lists of autocompleted values:*/
//               closeAllLists();
//           });
//           a.appendChild(b);
//         }
//       }
//   });
//   /*execute a function presses a key on the keyboard:*/
//   inp.addEventListener("keydown", function(e) {
//       var x = document.getElementById(this.id + "autocomplete-list");
//       if (x) x = x.getElementsByTagName("div");
//       if (e.keyCode == 40) {
//         /*If the arrow DOWN key is pressed,
//         increase the currentFocus variable:*/
//         currentFocus++;
//         /*and and make the current item more visible:*/
//         addActive(x);
//       } else if (e.keyCode == 38) { //up
//         /*If the arrow UP key is pressed,
//         decrease the currentFocus variable:*/
//         currentFocus--;
//         /*and and make the current item more visible:*/
//         addActive(x);
//       } else if (e.keyCode == 13) {
//         /*If the ENTER key is pressed, prevent the form from being submitted,*/
//         e.preventDefault();
//         if (currentFocus > -1) {
//           /*and simulate a click on the "active" item:*/
//           if (x) x[currentFocus].click();
//         }
//       }
//   });
  
//   function addActive(x) {
//     /*a function to classify an item as "active":*/
//     if (!x) return false;
//     /*start by removing the "active" class on all items:*/
//     removeActive(x);
//     if (currentFocus >= x.length) currentFocus = 0;
//     if (currentFocus < 0) currentFocus = (x.length - 1);
//     /*add class "autocomplete-active":*/
//     x[currentFocus].classList.add("autocomplete-active");
//   }
//   function removeActive(x) {
//     /*a function to remove the "active" class from all autocomplete items:*/
//     for (var i = 0; i < x.length; i++) {
//       x[i].classList.remove("autocomplete-active");
//     }
//   }
//   function closeAllLists(elmnt) {
//     /*close all autocomplete lists in the document,
//     except the one passed as an argument:*/
//     var x = document.getElementsByClassName("autocomplete-items");
//     for (var i = 0; i < x.length; i++) {
//       if (elmnt != x[i] && elmnt != inp) {
//         x[i].parentNode.removeChild(x[i]);
//       }
//     }
//   }
//   /*execute a function when someone clicks in the document:*/
//   document.addEventListener("click", function (e) {
//       closeAllLists(e.target);
//   });
// }

// /*An array containing all the country names in the world:*/
// var countries = ["Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India"];
// /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
// autocomplete(document.getElementById("myInput"), countries);






//  product slider code - zoom product


// (function ($) {
//     $(document).ready(function() {
//         $('.xzoom, .xzoom-gallery').xzoom({zoomWidth: 200,zoomHeight:200, title: true, tint: '#333'});
//         $('.xzoom1, .xzoom-gallery').xzoom({zoomWidth: 200,zoomHeight:200, title: true, tint: '#333'});
//         $('.xzoom2, .xzoom-gallery').xzoom({zoomWidth: 200,zoomHeight:200, title: true, tint: '#333'});
//         $('.xzoom3, .xzoom-gallery').xzoom({zoomWidth: 200,zoomHeight:200, title: true, tint: '#333'}); 
//         $('.xzoom4, .xzoom-gallery').xzoom({zoomWidth: 200,zoomHeight:200, title: true, tint: '#333'});
//         $('.xzoom5, .xzoom-gallery').xzoom({zoomWidth: 200,zoomHeight:200, title: true, tint: '#333'}); 
//     });
// })
// (jQuery);




