
<?php
include('header.php');
$vendor_id = $this->session->userdata['id'];
$email = $this->session->userdata('email');

$app_query = $this->db->query("SELECT * FROM admin WHERE type = '2'"); 
    
    $app_result = $app_query->row_array();


?>
<style>
.img_preview {
    width: 300px;
    margin-top:25px; 
    position: relative;
    display: none;
}
img#img_preview {
    width: 100%;
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
.abcd{
            opacity: 0;
         }
</style>
<style type="text/css">
    .required{
         color: red;
         }
</style>
 <style type="text/css">
       #myMap{
            height: 300px;
            width: 86%;
            /*top: -4em !important;*/
            left: 4% !important;
     }
    .but{
        float: right;
        margin-right: 10px;
    }
.btns {
    background-color: #58c9f3;
    border-color:#58c9f3;
  }
 .btns:hover {
    background-color: #58c9f3;
    border-color:#58c9f3;
  }
    </style>
<!--main content start-->
<section id="main-content">
    <form role="form" method="post" action="<?php echo base_url().'delivery/update_delivery/';  ?>" name="service_form" id="service_form" enctype="multipart/form-data">
        <input type="hidden" name="app_id" id="app_id" value="<?php echo $app_result['id']; ?>">
        <section class="wrapper site-min-height">

            <!-- page start-->
            <div id="msg">
                <?php if($this->session->flashdata('msg_error') && $this->session->flashdata('msg_error') != ''){ ?>
                    <div class="alert alert-danger fade in">
                        <strong>Error!</strong> <?php echo $this->session->flashdata('msg_error');; ?>
                    </div>
                <?php } unset($this->session->flashdata); ?>

                <?php if($this->session->flashdata('msg') && $this->session->flashdata('msg') != ''){ ?>
                    <div class="alert alert-success fade in">
                        <strong>Success!</strong> <?php echo $this->session->flashdata('msg');; ?>
                    </div>
                <?php } unset($this->session->flashdata); ?>
            </div>
          
            <div class="row">
                <div class="col-lg-12"> <?php // print_r($app_result); exit(); ?>
                    <section class="panel">
                        <header class="panel-heading"> Update Delivery </header>
                        <p class="sub_title"></p>
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                            <div class="customer">
                                <div class="form-group">
                                    <label for="">Name<span class="required" aria-required="true"> * </span></label>
                                    <input type="text" name="fname" class="form-control" id="fname" placeholder="Name" value="<?php if(isset($app_result['owner_name'])){ echo $app_result['owner_name']; }else{ echo $app_result['name']; } ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">Email<span class="required" aria-required="true"> * </span></label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php echo $app_result['email']; ?>" readonly>
                                </div>
                                 <div class="form-group">
                                    <label for="">Phone Number<span class="required" aria-required="true"> * </span></label>
                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number" value="<?php echo $app_result['phone_no']; ?>" maxlength="15" onkeypress="validate(event)">
                                </div>
                                <?php

                                 if($vendor_id == 0){ ?>
                                 <a href="<?php echo base_url().'index.php/admin/dashboard'; ?>" data-toggle='modal' class="but btn btn-danger btn-s-xs" nam e="cancel">Cancel</a>
                                  <input type="submit" name="submit" id="sbtFrm" value="Update" class="but btn btn-success btn-s-xs"> 
                                <?php  } ?>
                                <?php 
                         if($vendor_id != 0){ ?>
                                 <div class="form-group row ">
                              <div class="col-md-11">
                              <label class="margin_top_label">Enter Location :<span class="required" aria-required="true"> * </span>
                              </label>
                                 <input type="text"  id="departure_address" onFocus="initAutocomplete('departure_address')" class="dis form-control" name="location" maxlength="255" value="<?php if(isset($app_result['location'])){ echo $app_result['location']; }else{ echo set_value('location'); } ?>" placeholder="Location">
                                  <span style="color: red;"><?php echo form_error('location'); ?></span>
                              </div>
                              <div class="col-md-1">        
                                 <a class="display_map" href="javascript:;" onclick="initialize('departure');" title="Pick from Map"><img src="http://maps.google.com/mapfiles/ms/icons/blue-dot.png"></a> 
                              </div>
                              <input type="hidden" id="departure_latitude" name="latitude" placeholder="Latitude" value="<?php if(isset($app_result['latitude'])){ echo $app_result['latitude']; }else{ echo set_value('latitude'); } ?>"/>
                              <input type="hidden" id="departure_longitude" name="longitude" placeholder="Longitude" value="<?php if(isset($app_result['longitude'])){ echo $app_result['longitude']; }else{ echo set_value('longitude'); } ?>"/>                            
                           </div>
                            <?php 
                         }  ?>
                            </div>
                            <div id="myMap" class="myMap"> </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <?php 
                         if($vendor_id != 0){ ?>
                            <div class="customer padding_dropdown margin_btm">
                                <div class="form-group">
                                    <label for="">Shop Name :<span class="required" aria-required="true"> * </span></label>
                                    <input type="text" name="ownername" class="form-control" id="ownername" placeholder="Shop Name" value="<?php echo $app_result['name']; ?>" >
                                </div>
                            <div class="form-group">                            
                                <label class="margin_top_label">Enter Address :<span class="required" aria-required="true"> * </span></label> 
                                  <textarea rows="4" cols="50" name="address" placeholder="Address" class="dis form-control margin_top_input" value=""><?php if(isset($app_result['address'])){ echo $app_result['address']; }else{ echo set_value('address'); } ?></textarea>
                                   <span style="color: red;"><?php echo form_error('address'); ?></span>
                            </div>
                               <div class="form-group">
                                    <label class="margin_top_label">Image :<span class="required" aria-required="true"> * </span></label>
                                    <input type="hidden" id="old_file" name ="old_file" value="<?php echo $app_result['image']; ?>">
                                    <input type="file" accept="image/x-png,image/gif,image/jpeg" class="form-control img margin_top_input" id="image" name="vendorimage" placeholder="Select image" >
                                    <span id="imgerr" style="color: red;"></span>
                                    <label id="image-error" class="error" for="image" style="display: inline-block;"></label>
                                     <div class="img_preview">
                                           
                                            <img src="" id="img_preview" width="200" height="150">
                                        </div>
                                        <div class="All_images"></div>
                                   
                               </div>

                              <?php $vendorimg = $app_result['image']; ?>
                              <div class="img img_show" id="image_<?php echo $value->id; ?>"  style="float: left; margin-right: 10px; margin-bottom: 20px;">
                                   <?php if($vendorimg!='' && file_exists('public/images/vendor_shop/'.$vendorimg)){ ?>
                                    <img src="<?php echo base_url().'public/images/vendor_shop/'.$vendorimg; ?>" style="height: 180px; width: 200px;">
                                   <?php } ?>
                               </div>  
                            </div>
                            <?php } ?>
                        </div>
                        
                        <?php
                        if($vendor_id != 0){ ?>

                      <a href="<?php echo base_url().'index.php/admin/dashboard'; ?>" data-toggle='modal' class="but btn btn-danger btn-s-xs" nam e="cancel">Cancel</a>
                      <input type="submit" name="submit" id="sbtFrm" value="Update" class="but btn btn-info btn-s-xs">
                      <?php  } ?>
                    </section>
                </div>
            </div>
            <!-- page end-->
      
       
        </section>
    </form>


</section>
<!--main content end-->
<style> label.error { color: red; font-weight: 500; } </style>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
$('#image').change(function(){
    var imgpreview=DisplayImagePreview(this);
        $(".img_preview").show();
    setTimeout(function(){
        $('#phone').focus();
    },500);
})

    function DisplayImagePreview(input){
    
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img_preview').attr('src', e.target.result);
            }
            // $("#name").trigger("focus");
             $('#image-error').remove();
             $('#loaded').show();
             $('.img_show').hide();
            reader.readAsDataURL(input.files[0]);
        }
 
validateFileType();
}

function validateFileType(){

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



    // $('#sbtFrm').attr('disabled', 'disabled');





    setTimeout(function () { $('#msg').hide(); }, 6000);
    $('#service_form').validate({
        rules: {
            ownername: {
                required: true,
            },
            location: {
                required: true,
            },
            latitude: {
                required: true,
            },
            longitude: {
                required: true,
            }, 
            address: {
                required: true,
            },
            fname: {
                required: true,
            },
            phone: {
                required: true,
                digits: true,
                minlength:10,
                maxlength:15
            },
           vendorimage: {
             required: {depends: function (e) {
                            return ($('#old_file').val() === '');
                    }},
                accept: "image/jpg,image/jpeg,image/png,image/gif"
            },
        },
        messages: {
            ownername: {
                required: "Please enter name"
            },
            location: {
                required: "Please enter location"
            },
            latitude: {
                required: "Please enter latitude"
            },
            longitude: {
                required: "Please enter longitude"
            },
            address: {
                required: "Please enter address"
            },
            fname: {
                required: "Please enter name"
            },
            phone: {
                required: "Please enter phone number",
                digits: "Please enter valid phone number",
                minlength:"Please enter valid phone number",
                maxlength:"Please enter valid phone number"
            },
            vendorimage: {
                required: "Select Image",
                accept: "Only image type jpg/png/jpeg/gif is allowed"
            },
           
        },
        error: function(label) {
            $(this).addClass("error");
        }
        
    });

    // $('#service_form input').on('keyup blur',function(){
    //     // alert('hello');
    //     if ($('#service_form').validate()) {
    //         $('#sbtFrm').removeAttr('disabled');
    //     } else {
    //         $('#sbtFrm').attr('disabled', 'disabled');
    //     }
    // });
   
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

</script>

<?php include('footer.php'); ?> 