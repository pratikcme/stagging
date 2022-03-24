<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="Mosaddek">
      <meta name="keyword" content="">
      <title>Grocery</title>
      <link href="<?php echo base_url(); ?>/public/css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>/public/css/bootstrap-reset.css" rel="stylesheet">
      <!--external css-->
      <link href="<?php echo base_url(); ?>/public/assets/font-awesome/css/font-awesome.css" rel="stylesheet"/>
      <!-- Custom styles for this template -->
      <link href="<?php echo base_url(); ?>/public/css/style.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>/public/css/style-responsive.css" rel="stylesheet"/>
      <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
      <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <![endif]-->
      <style type="text/css">
         .control-label{
         font-weight: 700;
         width: 100% !important; 
         }
         textarea.form-control {
    -webkit-border-radius: 5px;
    border: 1px solid #eaeaea;
    box-shadow: none;
    font-size: 12px!important;
  }
         .required{
         color: red;
         }
         .btn{
         }
         #myMap{
         /*margin-top: 10px;*/
         height: 300px;
         width: 300px;
         /*float: right;*/
         top: -24em !important;
         left: 70% !important;
         }
         .display_map{
         position: absolute;
         top: 63%;
         right: 35.6%;
         }
         .form-signin {
         max-width: 425px;
         }
         .form-signin p {
         color: #f50000;
         font-size: 12px;
         text-align: left;
         }
         .login-wrap {
         padding: 2em 20px 3em 20px;
         }
         .login-wrap input {
         margin-bottom: 0!important;
         }
         .login-wrap label.error {
         margin-top: 10px;
         margin-left: 5px;
         margin-bottom: 0;
         }
         .login-wrap label {
         padding-left: 0;
         }

         .abcd{
            opacity: 0;
         }

         /*.login-wrap{
         height: 600px !important;
         }*/
      </style>
   </head>
   <?php
   $subs_query = $this->db->query("SELECT value FROM set_default WHERE request_id = '4'");
   $subs_charge = $subs_query->result();
   ?>
   <body  class="login-body" style="background: url('<?php echo base_url() . "public/images/back_img.jpg"; ?>')">
      <div class="container">
         <div id="registered">
            <?php if ($this->session->flashdata('registered') && $this->session->flashdata('registered') != '') { ?>
            <div class="alert alert-success" style="text-align: center">
               <?php echo $this->session->flashdata('registered');; ?>
            </div>
            <?php } ?>
            <?php if ($this->session->flashdata('not_registered') && $this->session->flashdata('not_registered') != '') { ?>
            <div class="alert alert-danger" style="text-align: center">
               <?php echo $this->session->flashdata('not_registered');; ?>
            </div>
            <?php } ?>
         </div>
         <form class="form-signin" enctype="multipart/form-data" action="<?php echo base_url() . 'vendor/new_vendor_register/'; ?>" method="post" id="vendor_form">
            <h2 class="form-signin-heading">Create Shop Admin</h2>
            <div id="msg">
               <?php if ($this->session->flashdata('msg') && $this->session->flashdata('msg') != '') { ?>
               <div class="alert alert-danger" style="text-align: center">
                  <?php echo $this->session->flashdata('msg');; ?>
               </div>
               <?php }  ?>
            </div>
            <div class="login-wrap" style="">
               <div class="form-group">
                  <label for="" class="control-label col-md-3">Domain Name :<span class="required" aria-required="true"> * </span>
                  </label>                            
                  <input type="text" name="domain_name"   id="domain_name" placeholder="Enter domain url" autocomplete="off" class="form-control placeholder-no-fix" value="<?php echo set_value('domain_name'); ?>">
                   <?php echo form_error('domain_name'); ?>
               </div>
               <div class="form-group">
                  <label for="" class="control-label col-md-3">Enter Shop Name :<span class="required" aria-required="true"> * </span>
                  </label>                            
                  <input type="text" name="name"   id="name" placeholder="Shop Name" autocomplete="off" class="form-control placeholder-no-fix" value="<?php echo set_value('name'); ?>">
                   <?php echo form_error('name'); ?>
               </div>

               <div class="form-group">
                  <label for="" class="control-label col-md-3">Enter Shop Owner Name :<span class="required" aria-required="true"> * </span>
                  </label>                            
                  <input type="text" name="ownername"   id="ownername" placeholder="Shop Owner Name" autocomplete="off" class="form-control placeholder-no-fix" value="<?php echo set_value('ownername'); ?>">
                   <?php echo form_error('ownername'); ?>
               </div>
               <div class="form-group">
                  <label for="" class="control-label col-md-3">Store Type :<span class="required" aria-required="true"> * </span>
                  </label>
                  <select class="form-control" name="store_type">
                    <option value = "" >Select Store Type</option>
                    <option value="grocery">Grocery</option>
                    <option value="apparels&garments">Apparels&Garments</option>
                    <option value="furniture" >Furniture</option>
                    <option value="gift" >Gift</option>
                    <option value="cake&bakery">Cake&Bakery</option>
                    <option value="kitchen" >Kitchen</option>
                    <option value="jewellery" >Jewellery</option>
                  </select>                            
               </div>


               <div class="form-group">
                  <label for="" class="control-label col-md-3">Shop Image :<span class="required" aria-required="true"> * </span>
                  </label>                            
                  <input type="file" name="image" placeholder="Shop Image" id="img" value="<?php echo set_value('image'); ?>">
                   <?php echo form_error('file'); ?>

               </div>
               <div class="form-group">                            
                  <label class="control-label col-md-3">Enter Email Address :<span class="required" aria-required="true"> * </span>
                  </label> 
                  <input type="text" id="email"   name="email" placeholder="Email Address" autocomplete="off" class="form-control placeholder-no-fix" value="<?php echo set_value('email'); ?>">
                  <?php echo form_error('email'); ?>

               </div>
               <div class="form-group">                            
                  <label class="control-label col-md-3">Enter Password :<span class="required" aria-required="true"> * </span>
                  </label> 
                  <input type="password"  id="password" name="password" placeholder="Password" autocomplete="new-password" class="form-control placeholder-no-fix" value="<?php echo set_value('password'); ?>">
               </div>
               <div class="form-group">                            
                  <label class="control-label col-md-3">Confirm Password :<span class="required" aria-required="true"> * </span>
                  </label> 
                  <input type="password" name="cpassword" id="cpassword"   placeholder="Confirm Password" autocomplete="off" class="form-control placeholder-no-fix" value="<?php echo set_value('password'); ?>">
               </div>
               <div class="form-group">                            
                  <label class="control-label col-md-3">Enter Mobile :<span class="required" aria-required="true"> * </span>
                  </label> 
                  <input type="text" name="mobile" placeholder="Mobile" autocomplete="off" class="form-control placeholder-no-fix" value="<?php echo set_value('mobile'); ?>" maxlength="15" onkeypress="validate(event)">
                  <?php echo form_error('mobile'); ?>
               </div>
                <div class="form-group">
                <label class="control-label col-md-3">Subscription Plan :<span class="required" aria-required="true"> * </span>
                        </label>
                        <input type="text" class="form-control" name="subscription_plan" readonly value="<?php echo $subs_charge[0]->value; ?> ">
                    <?php echo form_error('subscription_plan'); ?>
                </div>


                <div class="form-group">
                  <label class="control-label col-md-3">Enter Address :<span class="required" aria-required="true"> * </span></label> 
                  <textarea rows="4" cols="50" name="address" placeholder="Address" class="form-control placeholder-no-fix"></textarea>
               </div>

               <div class="form-group row ">
                  <div class="col-md-11">
                  <label class="control-label col-md-3">Enter Location :<span class="required" aria-required="true"> * </span>
                  </label>
                     <input type="text" id="departure_address" onFocus="initAutocomplete('departure_address')" class="form-control" placeholder="Location" name="location" maxlength="255" value="<?php echo set_value('location'); ?>">
                      <?php echo form_error('location'); ?>
                  </div>
                  <div class="col-md-1">
                     <a class="display_map" href="javascript:;" onclick="initialize('departure');" title="Pick from Map"><img src="http://maps.google.com/mapfiles/ms/icons/blue-dot.png"></a> 
                  </div>
                  <input type="hidden" id="departure_latitude" name="latitude" placeholder="Latitude" value="<?php echo set_value('latitude'); ?>"/>
                  <input type="hidden" id="departure_longitude" name="longitude" placeholder="Longitude" value="<?php echo set_value('longitude'); ?>"/>                            
               </div>
               <div style="height: 20px;"> 
                  <a href="<?php echo base_url() . 'admin/login'; ?>" style="float: right; margin-right: 10px; color: white;" id="delete_user" class="btn btn-danger">Cancel</a>  
                  <input class="btn btn-success"  style="float: right; margin-right: 30px;" type="submit" value="Submit" name="submit1">
               </div>
            </div>
         </form>
         <div id="myMap" class="myMap"> </div>
      </div>
      <!-- js placed at the end of the document so the pages load faster -->
      <style> label.error { color: red; font-weight: 500; } </style>
      <script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
      <script src="<?php echo base_url(); ?>/public/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-nS3x_SS2JjPSrbq772nwf4QEHRSK1y4&v=3.exp&libraries=places"></script>
   </body>
   <script type="text/javascript">
   // setTimeout(function(){
   //  $('#email').removeAttr('disabled'); 
   //  $('#ownername').removeAttr('disabled'); 
   //  $('#password').removeAttr('disabled');
   //  $('#name').removeAttr('disabled');
   //  $('#cpassword').removeAttr('disabled');
   // },500);





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
      
       
      
      
      
      
          $('#vendor_form').validate({
              rules: {
                  domain_name: {
                      required: true,
                      url : true,                   
                  },
                  name: {
                      required: true,
                      maxlength : 50,                   
                  },
                  store_type: {
                      required: true,                     
                  },
                  ownername:{
                      required: true,
                      maxlength : 25,                    
                  },
                  image: {
                      required: true,
                      accept: "image/jpg,image/jpeg,image/png,image/gif",                    
                  },
                  email: {
                      required: true,
                      email: true,
                      remote: {
                          url: "<?php echo base_url().'vendor/get_valid_email' ?>",
                          type: "post",                         
                       }
                  },
                  password: {
                      required: true,
                       minlength:6,
                  },
                  cpassword: {
                      required: true,
                       equalTo:'#password'
                  },
                  mobile: {
                      required: true,
                      digits: true,
                      minlength:10,
                      maxlength:15,
                      remote: {
                          url: "<?php echo base_url().'vendor/get_valid_mobile' ?>",
                          type: "post",                         
                       }
                  },
                  address: {
                      required: true,                     
                  },
                  location: {
                      required: true,                     
                  },
              },
              messages: {
                  domain_name: {
                      required: "please enter your domain url",
                      url : "Please enter valid url",                   
                  },
                  name: {
                      required: "Please enter shop name",                     
                  },
                  store_type: {
                      required: "Please enter type of store",                     
                  },
                  ownername:{
                      required: "Please enter shop owner name",                    
                  },
                  image: {
                      required: "Please select image", 
                      accept: "Only image type jpg/png/jpeg/gif is allowed",                    
                  },
                  email: {
                      required: "Please enter email",
                      email: "Please enter valid email",
                      remote : "This email is already exist"
                  },
                  password: {
                      required: "Please enter password",
                      minlength: "Please enter minimum 6 digit valid password"
                  },
                  cpassword: {
                      required: "Please enter confrim password",
                      equalTo: "Password and confirm password does not match"
                  },
                  mobile: {
                      required: "Please enter phone number",
                      digits: "Please enter valid phone number",
                      minlength:"Please enter valid phone number",
                      maxlength:"Please enter 15 digit valid number",
                      remote:"This mobile number is already exist"
                  },
                  address: {
                      required:  "Please enter address",
                      maxlength : "Please enter address less than 500 characters"                   
                  },
                  location: {
                      required: "Please Select location",                     
                  },
              },
             
          });
   </script>

   <script type="text/javascript">
     function validate(evt) {
          var theEvent = evt || window.event;
          var key = theEvent.keyCode || theEvent.which;
          key = String.fromCharCode( key );
          var regex = /[0-9]|\./;
          if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
          }
        }
</script>

<script>
    $('#img').on('change',function(){
      setTimeout(function(){
            $('#email').trigger('focus'); 
        },200);
    });
</script>
</html>