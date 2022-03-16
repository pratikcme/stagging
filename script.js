


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
$(function() {
$("#datepicker").datepicker();
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
$(".wishlist-icon").click(function(){
    let heart = $(this).children();
    heart.toggleClass("fas .fa-heart");
})

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

$(function() {
  $( "#slider-range" ).slider({
    range: true,
    min: 130,
    max: 500,
    values: [ 130, 250 ],
    slide: function( event, ui ) {
    $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
    }
  });
  $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
    " - $" + $( "#slider-range" ).slider( "values", 1 ) );
});


//=======FILTER HIDE AND SHOW=======
$(".filter-icon").click(function(){
  $(".filter-dropdown").addClass("show");
 addBackDrop();
})

$(document).on("click" , ".closing", function(){
  $(".filter-dropdown").removeClass("show");
  removeBackDrop();

})

$(".filter-wrapper .dropdown button").click(function(){
  $(".filter-dropdown").removeClass("show");
removeBackDrop()
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
    var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }

})


 //=======LOCATION POP ON LOAD=======
   $(window).on('load', function() {
        $('.location-popup').modal('show');
    });


 //=======ADD BODY BACKDROP =======
function addBackDrop(){
  setTimeout(function(){
  $("body").addClass("backdrop");
},1000);
}

 //======= REMOVE BODY BACKDROP =======
function removeBackDrop(){
  $("body").removeClass("backdrop");
}


// =======SHOW PROFILE MENU======= 
$(document).on('click',".user-logged",function(){
addBackDrop();

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


removeBackDrop();
})









// =======SHOW CART======= 
  $(document).on('click','.cart-wrap',function(){
    addBackDrop();
   if ($(".user-profile").hasClass("user-profile-visible")) {
     $(".user-profile").removeClass("user-profile-visible");
     $(".user-profile").removeClass("w3-animate-top");
     $(".down-arrow").removeClass("rotate-open");
     $("body").removeClass("backdrop");

    }
    
    $(".cart-view-wrap").addClass("cart-visible");
    $(".cart-view-wrap").addClass("w3-animate-top");
     
  }) ;

   


  $(".cart-view-header span.closing").click(function(){
     $(".cart-view-wrap").removeClass("cart-visible");
    $(".cart-view-wrap").removeClass("w3-animate-top");
  removeBackDrop()
  })


 //=======SCROLL TO TOP=======
 $(document).ready(function(){ 
    $(window).scroll(function(){ 
        if ($(this).scrollTop() > 100) { 
            $('.scroll-top').fadeIn(); 
        } else { 
            $('.scroll-top').fadeOut(); 
        } 
    }); 
    $('#scrollTop').click(function(){ 
        $("html, body").animate({ scrollTop: 0 }, 600); 
        return false; 
    }); 
});

  
 //=======INITIAL WOW JS=======
new WOW().init();
              

  