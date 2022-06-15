<style>
       .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            /* add padding to account for vertical scrollbar */
            padding-right: 20px;
        } 
        .atlassian-autocomplete .suggestions{
          min-width: 300px;
        }   
</style>
<section class="bottom-footer">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-12">
        <p class="copyright text-center">&#169 Copyright <?=date('Y')?> <?=$this->siteTitle?>. All rights reserved</p>
      </div>
        <div class="scroll-top" style="display: none;" >
          <button id="scrollTop"><i class="fas fa-chevron-up"></i></button>
        </div>
     
    </div>
  </div>
  <?php
  $set = '0'; 
  if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''){
      if(!empty($mycart)){
        $set = '1';
      }
  }else{
    if(isset($_SESSION['My_cart']) AND !empty($_SESSION['My_cart'])){
        $set = '1';
      }
  }


  ?>

  <input type="hidden" name="" id="url" value="<?=base_url()?>">
  <input type="hidden" name="" id="session_my_cart" value="<?=$set?>">
  <input type="hidden" name="session_vendor_id" id="session_vendor_id" value="<?=(isset($_SESSION['branch_id'])) ? $_SESSION["branch_id"] : '' ?>">
</section>

  <!-- BOOTSRAP JS -->
  <script src="<?=base_url()?>public/frontend/assets/js/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script type="text/javascript" src="<?=base_url()?>public/frontend/assets/js/jquery.lazy.min.js"></script>


  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script src="<?=base_url()?>public/frontend/assets/js/popper.min.js"></script>
  <script src="<?=base_url()?>public/frontend/assets/js/bootstrap.min.js"></script>

 <!-- SLICK JS -->
  <script src="<?=base_url()?>public/frontend/assets/js/slick.min.js"></script>
  
 <!-- OWL CAROUSEL JS -->
  <script src="<?=base_url()?>public/frontend/assets/js/owl.carousel.js"></script>
  <script src="<?=base_url()?>public/frontend/assets/js/wow.min.js"></script>
  <script src="<?=base_url()?>public/frontend/assets/js/jquery.rtResponsiveTables.js"></script>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js'></script>
  <script src='https://unpkg.com/xzoom/dist/xzoom.min.js'></script>

  <script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/164071/Drift.min.js'></script>
  
  <!-- SCRIPT AND SLIDER JS -->
  <script src="<?=base_url()?>public/frontend/assets/js/slider.js"></script>
  <script src="<?=base_url()?>public/frontend/assets/js/script.js"></script>
  <script src="<?=base_url()?>public/frontend/assets/js/counter.js"></script>

 

  <script type="text/javascript">
// function onScriptLoad(){
//   alert(1);
//       if(window.Paytm && window.Paytm.CheckoutJS){
//           window.Paytm.CheckoutJS.onLoad(function excecuteAfterCompleteLoad() {
//               // initialze configuration using init method 
//               window.Paytm.CheckoutJS.init(config).then(function onSuccess() {
//                   // after successfully updating configuration, invoke JS Checkout
//                   window.Paytm.CheckoutJS.invoke();
//               }).catch(function onError(error){
//                   console.log("error => ",error);
//               });
//           });
//       }  
//   }   
  </script>

<script type="text/javascript">
 //=======SCROLL TO TOP=======
  $(function() {

        $('.lazy').lazy({
           beforeLoad: function(element) {
            console.log('before');
            console.log(element);
        },
        afterLoad: function(element) {
            console.log('after');
            console.log(element);
        },
        });
    });

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

</script>
 <script>
    function openNav() {
      $("#mySidenav").css("width" , "250px");
      $("#mySidenav").addClass("open-cat");
      $("#backdrop").addClass("backdrop_bg");
     

    }
    
    function closeNav() {
      $("#mySidenav").css("width" , "0px");
      $("#mySidenav").removeClass("open-cat");
      $("#backdrop").removeClass("backdrop_bg");
    }

    $("#backdrop").click(function(){
      closeNav();
      closeSub();
      // $("#mySidenav").css("width" , "0px");
      // $(this).removeClass("backdrop_bg");
      // $("#mySidenav").removeClass("open-cat");


    })


    function openSub() {
      $("#SubSidenav").css("width" , "250px");
      $("#SubSidenav").addClass("open-subcat");
      $("#backdrop").addClass("backdrop_bg");
    }
    
    function closeSub() {
      $("#SubSidenav").css("width" , "0px");
      $("#SubSidenav").removeClass("open-subcat");
      $("#backdrop").removeClass("backdrop_bg");
    }

    $(".side-category ul li").click(function(){
      $(".category-sub-menu").removeClass("open-cat");
       $(".fa-chevron-right").removeClass("rotate")
       $(".side-category ul li").removeClass("active");

      var catMenu = $(this).find(".category-sub-menu");
      if($(this).hasClass("active")){
        alert(0);
        $(this).children().find(".fa-chevron-right").removeClass("rotate")
        $(this).removeClass("active");
        $(catMenu).removeClass("open-cat");
      }else{
        $(this).children().find(".fa-chevron-right").addClass("rotate")
        $(this).addClass("active");
        $(catMenu).addClass("open-cat");
      }
      
    });



    function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
    </script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-nS3x_SS2JjPSrbq772nwf4QEHRSK1y4&v=3.exp&libraries=places"></script>
   	<script type="text/javascript">

      function initAutocomplete(id) {

              var res = id.split("_");
              geo = res[0];
              console.log(res);
              // Create the autocomplete object, restricting the search to geographical
              // location types.
              autocomplete = new google.maps.places.Autocomplete(
                  /** @type {!HTMLInputElement} */(document.getElementById(id)),
                  {types: ['geocode']});
            
              // When the user selects an address from the dropdown, populate the address
              // fields in the form.
              autocomplete.addListener('place_changed', fillInAddress);


          }
      
          function fillInAddress() {
              // Get the place details from the autocomplete object.
              var place = autocomplete.getPlace();
              console.log(place);
              // console.log(place.address_components);
              var url  = window.location.href; 
              var base_url = $('#url').val();

              if(url != base_url+'vendors' && url != base_url){
                  document.getElementById('address').value = place.formatted_address;
                // if($('#address').length){
                // }
                for (var i = 0; i < place.address_components.length; i++) {

                    for (var j = 0; j < place.address_components[i].types.length; j++) {

                        if (place.address_components[i].types[j] == "postal_code") {

                            document.getElementById('pincode').value = place.address_components[i].long_name;
                        }

                        if (place.address_components[i].types[j] == "administrative_area_level_1") {

                        document.getElementById('state').value = place.address_components[i].long_name;
                        $("#state").attr('readonly', 'readonly').focus();
                        }

                        if (place.address_components[i].types[j] == "country") {
                        	 document.getElementById('country').value =place.address_components[i].long_name ;
                            // $(".edittxtCountryCode").val(place.address_components[i].short_name);
                            // $(".edittxtCountry").val(place.address_components[i].long_name);
                            $("#country").attr('readonly', 'readonly').focus();
                        }

                        if (place.address_components[i].types[j] == "locality") {
                        document.getElementById('city').value = place.address_components[i].long_name;
                        }
                    }
                }

              }
              //alert(autocomplete.getPlace().geometry.location);false;
              
              document.getElementById(geo+'_latitude').value = place.geometry.location.lat();
              document.getElementById(geo+'_longitude').value = place.geometry.location.lng();
          }
      
              var map;
              var marker;
              
              var Lat = "<?php echo LATITUDE ; ?>";
              var Long = "<?php echo LONGITUDE; ?>";
                  
              var Lat = parseInt(Lat);
              var Long =  parseInt(Long);
                   
              var myLatlng = new google.maps.LatLng(Lat,Long);
              var geocoder = new google.maps.Geocoder();
              var infowindow = new google.maps.InfoWindow();
              
          function initialize(input){
          	
               $('.myMap').removeClass("abcd");
              //alert(document.getElementById(input+'_address').value);false;
              if(input == 'departure') {
                  if (document.getElementById('departure_latitude').value != 0) {
                      var myLat = document.getElementById('departure_latitude').value;
                  }else{
                      var myLat =  Lat;
                  }
                  if (document.getElementById('departure_latitude').value != 0) {
                      var myLng = document.getElementById('departure_longitude').value;
                  }else{
                      var myLng =  Long;
                  }
                  var myLatlng = new google.maps.LatLng(myLat,myLng);
              }else{
                  var myLatlng = new google.maps.LatLng(Lat,Long);
              }
              
              var mapOptions = {
                  zoom: 8,
                  center: myLatlng,
                  //center: new google.maps.LatLng(myLat,myLng),
                  mapTypeId: google.maps.MapTypeId.ROADMAP
              };
              lat1 = parseFloat(myLat) - 0.01;
              lat2 = parseFloat(myLat) + 0.007;
              lat3 = parseFloat(myLat) + 0.01;
              
              long1 = parseFloat(myLng) + 0.003;
              long2 = parseFloat(myLng) + 0.007;
              long3 = parseFloat(myLng) - 0.01;
             
              map = new google.maps.Map(document.getElementById("myMap"), mapOptions);
              
              var triangleCoords = [
                      new google.maps.LatLng(lat1, long1),
                      new google.maps.LatLng(lat2, long2),
                      new google.maps.LatLng(lat3, long3)
                    ];
              
              marker = new google.maps.Marker({
                  map: map,
                  position: myLatlng,
                  draggable: true 
              });     
              
              geocoder.geocode({'latLng': myLatlng }, function(results, status) {
                  if (status == google.maps.GeocoderStatus.OK) {
                      if (results[0]) {
                         
                      }
                  }
              });

              
                             
              google.maps.event.addListener(marker, 'dragend', function() {
                  geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                      if (status == google.maps.GeocoderStatus.OK) {
                          if (results[0]) {
                              $('#'+input+'_address').val(results[0].formatted_address);
                              $('#'+input+'_latitude').val(marker.getPosition().lat());
                              $('#'+input+'_longitude').val(marker.getPosition().lng());

                              
                              infowindow.setContent(results[0].formatted_address);
                              infowindow.open(map, marker);

                              setTimeout(function(){
                              	$('.myMap').addClass("abcd");
                              },3000)
                              
                              
                              // var center = map.getCenter();
                              // google.maps.event.trigger(map, 'resize');
                              // map.setCenter(center);
                          }
                      }
                  });
              });

              google.maps.event.addListener(map, 'dragend', function () {
				    marker.setPosition(this.getCenter()); // set marker position to map center
				    //updatePosition(this.getCenter().lat(), this.getCenter().lng()); // update position display
			});
          }
             function getPolygonCoords() {
              
              var len = myPolygon.getPath().getLength();
              var htmlStr = "";
              for (var i = 0; i < len; i++) {
                  if (htmlStr == "") {
                      htmlStr += myPolygon.getPath().getAt(i).toUrlValue(5);
                  }else{
                      htmlStr += "|" + myPolygon.getPath().getAt(i).toUrlValue(5);
                  }
              }
      
              document.getElementById('store-service_area').value = htmlStr;
          }
          setTimeout(function () { $('#registered').hide(); }, 6000);
            
      </script>
	
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.js" type="text/javascript"></script> 
<script src="<?=base_url();?>public/frontend/assets/javascript/common.js?v=<?=js_version?>"></script>
 <?php
	if(!empty($js)){
		foreach ($js as $value) { ?>
		<script src="<?=base_url();?>public/frontend/assets/javascript/<?=$value.'?v='.js_version?>"></script>			
		 
	<?php	}
 	}
 ?> 
 <script>
    jQuery(document).ready(function () {
<?php
if (!empty($init)) {
    foreach ($init as $value) {
        echo $value . ';';
    }
}
?>
    });


    //=========== TABLE RESPONSIVE=====
 $("table").rtResponsiveTables({
    containerBreakPoint: 360
    });




 
</script>



