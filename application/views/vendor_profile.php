<?php include('header.php');
error_reporting(0);
@$id = $this->utility->decode($_GET['id']);
   ?>
<?php 
   if($result['id']!=''){
       $reqName = "Update";
       }else{
          $reqName ="Add";
   } 
   ?>
    <style type="text/css">
       #myMap{
            height: 300px;
    width: 100%;
    max-width:700px; 
    top: -9em !important;
    left: 3% !important;
     }

    </style>
    <style>
       .btn.btn-info.pull-right {
        margin-right: 10px;
         }
         .panel-body .form-group {
              margin-bottom: 26px;
          }
        .img_preview {
            width: 300px;
            display: none;
        }
        img#img_preview {
            width: 300px;
        }
        .overlay{
            position: absolute;
            width: 100%;
            height: 100%;   
        }
        .im_progress {
            position: absolute;
            width: 100%;
            opacity: 0.5;
        }
        .loader_img{
            position: absolute;
            top: 50%;
            left: 50%;  
        }
        .required{
         color: red;
         }
         .abcd{
            opacity: 0;
         }
         .myMap{
            margin: 0 !important;
         }
         .map_container{
          position: relative;
          top: 150px;
         }
    </style>
<!--main content start-->
<section id="main-content">
   <section class="wrapper">
      <!-- page start-->
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb">
               <li class="active"><a href=""><i class="fa fa-home"></i> <a href="<?php echo base_url().'admin/dashboard'; ?>">Home</a> / <a href="<?php echo base_url().'vendor/vendor_list'; ?>">Vendor</a> / <?php echo $reqName; ?></a></li>
            </ul>
            <!--breadcrumbs end -->
         </div>
      </div>
      <div class="row">
         <!--Left Part-->
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <section class="panel">
               <header class="panel-heading">
                  <?php echo $reqName; ?> Vendor
               </header>
               <form  enctype="multipart/form-data"  role="form" method="post" action="<?php echo base_url().'vendor/new_vendor_register'; ?>" name="vendor_form" id="vendor_form">
                  <input type="hidden" id="id" name="id" value="<?php echo $result['id']; ?>">
                  <input type="hidden" id="web" name="web" value="1">
                  <div class="panel-body">
                   <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label for="" class="margin_top_label">Enter Domain Name :<span class="required" aria-required="true"> * </span>
                        </label>                            
                        <input type="text"  name="domain_name" placeholder="Domain Name" autocomplete="off" class="dis form-control margin_top_input" value="<?php if(isset($result['domain_name'])){ echo $result['domain_name']; }else{ echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/'; } ?>">
                        <span style="color: red;"><?php echo form_error('domain_name'); ?></span>
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group row ">
                            <div class="col-md-12">
                              <label class="margin_top_label">Store Type :<span class="required" aria-required="true"> * </span>
                              </label>
                              <select class="form-control" name="store_type">
                                <option value="" >Select Store Type</option>
                                <option value="grocery" <?=($result['store_type'] == 'grocery') ? "SELECTED" : "";?>>Grocery</option>
                                <option value="apparels&garments" <?=($result['store_type'] == 'apparels&garments') ? "SELECTED" : ""?>>Apparels&Garments</option>
                                <option value="furniture" <?=($result['store_type'] == 'furniture') ? "SELECTED" : "" ?>>Furniture</option>
                                <option value="gift" <?=($result['store_type'] == 'gift') ? "SELECTED" : ""?>>Gift</option>
                                <option value="cake&bakery" <?=($result['store_type'] == 'cake&bakery') ? "SELECTED" : ""?>>Cake&Bakery</option>
                                <option value="kitchen" <?=($result['store_type'] == 'kitchen') ? "SELECTED" : ""?>>Kitchen</option>
                                <option value="jewellery" <?=($result['store_type'] == 'jewellery') ? "SELECTED" : ""?>>Jewellery</option>
                              </select>
                            </div>
                          </div>  
                    </div>
                  </div>
                     <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                           <div class="form-group">
                              <label for="" class="margin_top_label">Enter Shop Name :<span class="required" aria-required="true"> * </span>
                              </label>                            
                              <input type="text"  name="name" placeholder="Shop Name" autocomplete="off" class="dis form-control margin_top_input" value="<?php if(isset($result['name'])){ echo $result['name']; }else{ echo set_value('name'); } ?>">
                               <span style="color: red;"><?php echo form_error('name'); ?></span>
                           </div>


                           <div class="form-group">
                              <label for="" class="margin_top_label">Enter Shop Owner Name :<span class="required" aria-required="true"> * </span>
                              </label>                            
                              <input type="text" id="shop" name="ownername" placeholder="Shop Owner Name" autocomplete="off" class="dis form-control margin_top_input" value="<?php if(isset($result['owner_name'])){ echo $result['owner_name']; }else{ echo set_value('owner_name'); } ?>">
                               <span style="color: red;"><?php echo form_error('owner_name'); ?></span>
                           </div>
                            
                           <div class="form-group">                            
                              <label class="margin_top_label">Enter Email Address :<span class="required" aria-required="true"> * </span>
                              </label> 
                              <input type="hidden" name="hidden_email" value="<?php if(isset($result['email'])){ echo $result['email']; }?>">
                              <input type="email" id="email"  <?php if(!empty($id)){echo "disabled";} ?>  name="email" placeholder="Email Address" autocomplete="off" class="dis form-control margin_top_input" value="<?php if(isset($result['email'])){ echo $result['email']; }else{ echo set_value('email'); } ?>">
                              <span style="color: red;"><?php echo form_error('email'); ?></span>
                           </div>

                            <div class="form-group row ">
                                <div class="col-md-12">
                                    <label class="margin_top_label">Subscription Plan :<span class="required" aria-required="true"> * </span>
                                    </label>
                                    <input type="text" class="form-control" name="subscription_plan" readonly value="<?php echo $subs_charge[0]->value; ?> ">
                                </div>
                            </div>

                           <div class="form-group row ">
                              <div class="col-md-11">
                              <label class="margin_top_label">Enter Location :<span class="required" aria-required="true"> * </span>
                              </label>
                                 <input type="text"  id="departure_address" onFocus="initAutocomplete('departure_address')" class="dis form-control" name="location" maxlength="255" value="<?php if(isset($result['location'])){ echo $result['location']; }else{ echo set_value('location'); } ?>" placeholder="Location">
                                  <span style="color: red;"><?php echo form_error('location'); ?></span>
                              </div>
                              <div class="col-md-1">        
                                 <a class="display_map" href="javascript:;" onclick="initialize('departure');" title="Pick from Map"><img src="http://maps.google.com/mapfiles/ms/icons/blue-dot.png"></a> 
                              </div>
                              <input type="hidden" id="departure_latitude" name="latitude" placeholder="Latitude" value="<?php if(isset($result['latitude'])){ echo $result['latitude']; }else{ echo set_value('latitude'); } ?>"/>
                              <input type="hidden" id="departure_longitude" name="longitude" placeholder="Longitude" value="<?php if(isset($result['longitude'])){ echo $result['longitude']; }else{ echo set_value('longitude'); } ?>"/>       

                              <div class="map_container" style="position: relative;">
                                <div id="myMap" class="myMap"> </div>
                              </div>                     
                           </div>
                            
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                         
                           <div class="form-group">                            
                              <label class="margin_top_label">Enter Mobile :<span class="required" aria-required="true"> * </span>
                              </label> 
                              <input type="hidden"  name="hidden_m" id="mb" value="<?php if(isset($result['id'])){ echo $result['id']; } ?>" >
                              <input type="hidden"  name="hidden_mobile"  value="<?php if(isset($result['phone_no'])){ echo $result['phone_no']; } ?>" >
                              <input type="text"   name="mobile" placeholder="Mobile" autocomplete="off" class="dis form-control margin_top_input" value="<?php if(isset($result['phone_no'])){ echo $result['phone_no']; }else{ echo set_value('mobile'); } ?>" maxlength="15"  onkeypress="validate(event)" >
                           </div>

                           <div class="form-group">                            
                              <label class="margin_top_label">Enter Password :<span class="required" aria-required="true"> * </span>
                              </label> 
                              <input type="password"  <?php if(!empty($id)){echo "disabled";} ?> name="password" placeholder="Password" autocomplete="new-password" class="dis form-control margin_top_input" value="<?php if(isset($result['password'])){ echo $result['password']; }else{ echo set_value('password'); } ?>">
                               <span style="color: red;"><?php echo form_error('password'); ?></span>
                           </div>
                             <div class="form-group">                            
                            <label class="margin_top_label">Enter Address :<span class="required" aria-required="true"> * </span></label> 
                                  <textarea rows="4" cols="50" name="address" placeholder="Address" class="dis form-control margin_top_input" value=""><?php if(isset($result['address'])){ echo $result['address']; }else{ echo set_value('address'); } ?></textarea>
                                   <span style="color: red;"><?php echo form_error('address'); ?></span>
                            </div>
                            <div class="form-group">
                              <label for="name" class="margin_top_label">Image<span class="required" aria-required="true"> * </span></label>
                              <?php if($result['id'] != ''){ ?>
                                <input accept='image/*'  type="file" class="check form-control name margin_top_input" id="image" name="image_edit" placeholder="Select Image" value="">
                                <img id="loaded" src="<?php echo base_url().'public/images/'.$this->folder.'vendor_shop/'.$result['image']; ?>" width="200" height="150" style="margin-top: 10px;position: absolute;">
                              <?php }else{ ?>
                                <input accept='image/*' type="file" class="check form-control margin_top_input" id="image" name="image" placeholder="Select Image" value="">
                              <?php } ?>
                              <label id="image-error" class="error" for="image"></label>
                              <div class="img_preview">
                               <br>
                               <img src="" id="img_preview"  width="200" height="150">
                             </div>
                             <div class="All_images" id="click"></div>
                           </div>
                           <div class="form-group" style="display: none">
                              <label for="name" class="margin_top_label">Logo<span class="required" aria-required="true"> * </span></label>
                              <?php if($result['id'] != ''){ ?>
                                <input accept='image/*'  type="file" class="check form-control name margin_top_input" id="logo_image" name="logo_image_edit" placeholder="Select logo " value="">
                                <img id="loaded" src="<?php echo base_url().'public/images/vendor_logo_image/'.$result['logo_image']; ?>" width="200" height="150" style="margin-top: 10px;position: absolute;">
                              <?php }else{ ?>
                                <input accept='image/*' type="file" class="check form-control margin_top_input" id="logo_image" name="logo_image" placeholder="Select Image" value="">
                              <?php } ?>
                              <label id="logo_image-error" class="error" for="logo_image"></label>

                              <div class="logo_img_preview" style="display: none">
                               <br>
                               <img src="" id="logo_img_preview"  width="200" height="150">
                             </div>
                             <div class="All_images" id="click"></div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <!-- <span class="panel-body padding-zero" > -->
                        <a href="<?php echo base_url().'vendor/vendor_list/'; ?>" style="float: right; margin-right: 10px;" id="delete_user" class="btn btn-danger">Cancel</a> 
                        <input type="submit" class="btn btn-info pull-right margin_top_label" value="<?php echo $reqName.' Branch'; ?>" name="submit1">
                        <!-- </span> -->
                     </div>
                  </div>
               </form>
                 
            </section>
         </div>
         <!--Map Part-->
      </div>
      <!-- page end-->
   </section>
</section>
<!--main content end-->
<style> label.error { color: red; font-weight: 500; } </style>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
 <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeCDbEPFYP5aVlxPzE8ZDE2O3I_pelYOM&v=3.exp&libraries=places"></script> -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-nS3x_SS2JjPSrbq772nwf4QEHRSK1y4&v=3.exp&libraries=places"></script>
 
   </body>
<script type="text/javascript">
// setTimeout(function(){
//   $('.dis').removeAttr('disabled');
// },700);
  
$.validator.addMethod("dobValid", function (value, element, options)
{
    //we need the validation error to appear on the correct element
    var day = $('input[name="dob-day"]'),
        month = $('input[name="dob-month"]'),
        year = $('input[name="dob-year"]'),
        anyEmpty = ( day.val() == '' || month.val() == '' || year.val() == '' );

    if (anyEmpty) {
        day.add(month).add(year).addClass('error');
    }
    else {
        day.add(month).add(year).removeClass('error');
    }

    return !anyEmpty;
},
    "Please enter your date of birth."
);



    $('#vendor_form').validate({

              rules: {
                  domain_name : {
                    required : true
                  },
                  name: {
                      required: true,
                    },
                  store_type : {
                      required: true,
                    },
                  ownername:{
                    	required: true,
                    },
                    email: {
                      required: true,
                      email: true,
                      remote: {
                          url: "<?php echo base_url().'vendor/get_valid_email' ?>",
                          type: "post",                         
                       }
                    },password: {
                        required: true,
                         minlength:6,
                    },mobile: {
                        required: true,
                        digits: true,
                        minlength:10,
                        maxlength:15,
                        remote: {
                          url: "<?php echo base_url().'vendor/get_valid_mobile' ?>",
                          type: "post",
                          data: {
                             hidden_m: function() {
                             return $("#mb").val();
                          }                         
                       }
                     }
                    },
                    address:{
                      required : true,
                      maxlength : 500
                    },
                    location: {
                      required: true,
                    },
                    image:{
                      required: true,
                      accept: "image/jpg,image/jpeg,image/png,image/gif"
                    }, 
                    image_edit:{
                      accept: "image/jpg,image/jpeg,image/png,image/gif"
                    },
                    logo_image : {
                      required: true,
                      accept: "image/jpg,image/jpeg,image/png,image/gif"
                    },
                    logo_image_edit:{
                      accept: "image/jpg,image/jpeg,image/png,image/gif"
                    }
              },
              messages: {
                  domain_name:{
                    required : "Please enter domain name",
                  },
                  name: {
                      required: "Please enter shop name",
                  },
                  store_type: {
                      required: "Please enter  type of store",
                  },
                  ownername:{
                  	  required: "Please enter shop owner name",
                  },
                  email: {
                      required: "Please enter email",
                      email: "Please enter valid email",
                      remote : "This email is already exist"
                  },password: {
                      required: "Please enter password",
                      minlength: "Please enter minimum 6 digit valid password"
                  },mobile: {
                      required: "Please enter mobile number",
                      digits: "Please enter valid mobile number",
                      minlength:"Please enter valid mobile number",
                      maxlength:"Please enter 15 digit valid number",
                      remote:"This mobile is already exist"
                  },
                   address:{
                    required : "Please enter address",
                    maxlength : "Please enter address less than 500 characters"
                  },
                  location: {
                      required: "Please Select location",
                  },
                  image:{
                      required: "Please select image",
                      accept: "Only image type jpg/png/jpeg/gif is allowed"
                  },
                  image_edit:{                      
                      accept: "Only image type jpg/png/jpeg/gif is allowed"
                  },
                  logo_image : {
                      required: "Please select Logo",
                      accept: "Only image type jpg/png/jpeg/gif is allowed"
                  },
                  logo_image_edit:{                      
                      accept: "Only image type jpg/png/jpeg/gif is allowed"
                  }
              },
             
          });


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

                                  // $('.myMap').addClass("abcd");
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
       
    $(document).on('change','#image',function(){

        var imgpreview=DisplayImagePreview(this,'#img_preview');
        $(".img_preview").css("display","block");
        
        setTimeout(function () {
                      $('#shop').focus();
                      $('#image').focus();
        
        },500);

     
    });

    $(document).on('change','#logo_image',function(){

        var imgpreview=DisplayImagePreview(this,'#logo_img_preview');
        $(".logo_img_preview").css("display","block");
        
        setTimeout(function () {
            $('#shop').focus();
            $('#logo_image').focus();
        },500);

     
    });
    function DisplayImagePreview(input,display_location){
    
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(display_location).attr('src', e.target.result);
            }
            // $("#name").trigger("focus");
             $('#image-error').remove();
             $('#loaded').hide();
            reader.readAsDataURL(input.files[0]);
        }
        if(display_location=='img_preview'){
          validateFileType();
        }else{
          validateFileType_logo();
        }

}

function validateFileType(){
  // alert();
    var fileName = $("#image").val();
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
        $('#img_preview').show();
      
    }else{

     $('#image-error').html('Only image type jpg/png/jpeg/gif is allowed');
      
        $('#img_preview').attr("style","display: none;");   
       
    }   
}

function validateFileType_logo(){
  
    var fileName = $("#logo_image").val();
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
        $('#logo_img_preview').show();
      
    }else{

     $('#image-error').html('Only image type jpg/png/jpeg/gif is allowed');
      
        $('#logo_img_preview').attr("style","display: none;");   
       
    }   
}

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
<?php include('footer.php'); ?>