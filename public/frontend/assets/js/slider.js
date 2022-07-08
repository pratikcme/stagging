// ========= PRODUCT DETAIL ===========
 $('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
  slidesToShow: 4,
  slidesToScroll: 1,
  asNavFor: '.slider-for',
  dots: true,
  // infinite:true,
  centerMode: false,
  // margin:25,
  focusOnSelect: true,
  responsive:[
  {
      breakpoint: 425,
      settings:{
        slidesToShow:2
      }
  },
  {
      breakpoint: 575,
      settings:{
        slidesToShow:3
      }
  },
  {
      breakpoint: 768,
      settings:{
        slidesToShow:3
      }
  }
  ]
});

// ======= CLIENT SLIDER======

var owl = $('.client-owl-slider');
owl.owlCarousel({
    items:3,
    // loop:true,
    margin:30,
    autoplay:true,
    autoplayTimeout:2000,
    autoplayHoverPause:true,
    navigation:false,
    dotData: true,
    dotsEach: true,
    responsive: {
      280:{
        items:1,
      },
      575:{
        items:2
      },
      768:{
        items:2
      },
      1200:{
        items:3
      }
    }

});

    // ======= BANNER SLIDER======
 $('#carousel').carousel({
  interval: 3000,

  });


  // ======= CATEGORY SLIDER======

 jQuery(document).ready(function($) {
                "use strict";
                $('#category_slider').owlCarousel({
                    // loop: true,
                    center: false,
                    items: 5,
                    margin: 0,
                    navigation:true,
                    autoplay: true,
                    dots:false,
                    arrow:true,
                    stagePadding:0,
                    autoplayTimeout: 8500,
                    smartSpeed: 450,

                    // navText: ['<span class="far fa-arrow-alt-circle-left"></span>',
                    //         '<span class="far fa-arrow-alt-circle-right"></span>'],
                    responsive: {
                            0: {
                              items: 1
                            },

                            424: {
                              items: 1
                            },

                            460: {
                              items: 2
                            },
                           
                             768: {
                              items: 3
                            },


                            1008: {
                              items: 4
                            },

                            1366: {
                              items:5
                            }
                            }
                   });
              });

 // ======= TOP FEATURE SLIDER======

  jQuery(document).ready(function($) {
                "use strict";
                $('#top_feat_slider').owlCarousel({
                    // loop: true,
                    center: false,
                    items: 4,
                    margin: 0,
                    navigation:true,
                    autoplay: true,
                    dots:false,
                    arrow:true,
                    stagePadding:0,
                    autoplayTimeout: 8500,
                    smartSpeed: 450,
                    rewindNav:false,

                    // navText: ['<span class="far fa-arrow-alt-circle-left"></span>',
                    //         '<span class="far fa-arrow-alt-circle-right"></span>'],
                    responsive: {
                            0: {
                              items: 1
                            },

                            424: {
                              items: 1
                            },

                            460: {
                              items: 2
                            },
                           
                             768: {
                              items: 3
                            },


                            1008: {
                              items: 4
                            },

                            1366: {
                              items:4
                            }
                            }
                   });
              });

 // ======= NEW PRODUCT 1 SLIDER======

  jQuery(document).ready(function($) {
                "use strict";
                $('#new_product_1').owlCarousel({
                    // loop: true,
                    center: false,
                    items: 4,
                    margin: 0,
                    navigation:true,
                    autoplay: true,
                    dots:false,
                    arrow:true,
                    stagePadding:0,
                    autoplayTimeout: 8500,
                    smartSpeed: 450,
                    rewindNav:false,

                    // navText: ['<span class="far fa-arrow-alt-circle-left"></span>',
                    //         '<span class="far fa-arrow-alt-circle-right"></span>'],
                    responsive: {
                            0: {
                              items: 1
                            },

                            424: {
                              items: 1
                            },

                            460: {
                              items: 2
                            },
                           
                             768: {
                              items: 3
                            },


                            1008: {
                              items: 4
                            },

                            1366: {
                              items:4
                            }
                            }
                   });
              });


 // ======= NEW PRODUCT 2 SLIDER======
  
  jQuery(document).ready(function($) {
                "use strict";
                $('#new_product_2').owlCarousel({
                    // loop: true,
                    center: false,
                    items: 4,
                    margin: 0,
                    navigation:true,
                    autoplay: true,
                    dots:false,
                    arrow:true,
                    stagePadding:0,
                    autoplayTimeout: 8500,
                    smartSpeed: 450,

                    // navText: ['<span class="far fa-arrow-alt-circle-left"></span>',
                    //         '<span class="far fa-arrow-alt-circle-right"></span>'],
                    responsive: {
                            0: {
                              items: 1
                            },

                            424: {
                              items: 1
                            },

                            460: {
                              items: 2
                            },
                           
                             768: {
                              items: 3
                            },


                            1008: {
                              items: 4
                            },

                            1366: {
                              items:4
                            }
                            }
                   });
              });
