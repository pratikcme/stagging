<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="">

    <title><?=$this->siteTitle?></title>
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
        .required{
            color: red;
        }
       
        .login-body{
            position: relative;
        }
        .login-body:after{
            content: "";
            width: 100%;
            height: 100%;
            background-color:rgba(0,0,0,0.3);
            position: absolute;
            left: 0px;
            top: 0px;
            z-index: -1;
        }
        
    .pac-container {
    background-color: #FFF;
    z-index: 20;
    position: fixed;
    display: inline-block;
    float: left;
}
.modal{
    z-index: 20;   
}
.modal-backdrop{
    z-index: 10;        
}​
#myMap{
    position: absolute !important;
}
</style>
</head>
<body  class="login-body" style="background: url('<?php echo base_url() . "public/login_back1.jpg"; ?>');background-position:center center;
    background-size: cover;
    background-repeat: no-repeat;height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;">


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
    
    <form class="form-signin" enctype="multipart/form-data" action="<?php echo base_url() . 'admin/check_login/'; ?>" method="post" id="sign_in_form">
        <!-- <div class="fishmart_logo">
        <img src="<?php echo base_url() . "public/images/fishmart_logo.png"; ?>">
        </div> -->
        <h2 class="form-signin-heading">Login</h2>
        <div id="msg">
            <?php if ($this->session->flashdata('msg') && $this->session->flashdata('msg') != '') { ?>
                <div class="alert alert-danger" style="text-align: center">
                    <?php echo $this->session->flashdata('msg');; ?>
                </div>
            <?php }  ?>
        </div>
        <div class="login-wrap">
            <input type="text" name="loginemail" class="form-control" placeholder="Email Address"  value="<?php echo get_cookie('loginemail'); ?>" required autofocus  autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
            <input type="password" name="loginpassword" class="form-control" placeholder="Password" value="<?php echo get_cookie('loginpassword'); ?>" autocomplete="new-password" required >

           <label class="rememberme check">
                <input type="checkbox" name="remember" id="remember" value="1" <?php
                if (get_cookie('loginemail') != '') {
                   echo 'checked="checked"';
               }
                ?> /> Remember</label>



            <!-- <label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me -->
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>
                </span>
            <!-- </label> -->

            <button class="btn btn-lg btn-login btn-block" type="submit">Login</button>
        <!-- <center>            
            <a class="createnew_btn" href="<?php echo base_url() . 'vendor/add_vendor'; ?>"> Create New Vendor?</a>
        </center> -->
            
        </div>
    </form>

    <form class="form-signin" action="<?php echo base_url() . 'admin/forgot_password/'; ?>" method="post" id="forgot_form">
        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Forgot Password ?</h4>
                    </div>
                    <div class="modal-body">
                        <p style="float: left;">Enter your e-mail address below to reset your password.</p>
                        <input type="text" name="email_forgot" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                        <input class="btn btn-success" type="submit" value="Submit" name="submit">
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->
    </form>


     <form class="form-signin" action="<?php echo base_url() . 'admin/new_vendor_register/'; ?>" method="post" id="vendor_form">
        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="vendor_model" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Create Shop Admin</h4>
                    </div>
                    <div class="modal-body">
                        <!-- <p style="float: left;">Enter your e-mail address below to reset your password.</p> -->
                        <label class="control-label col-md-3">Enter Shop Name :<span class="required" aria-required="true"> * </span>
                        </label>                            
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Shop Name" autocomplete="off" class="form-control placeholder-no-fix">
                        </div>
                        <label class="control-label col-md-3">Enter Email Address :<span class="required" aria-required="true"> * </span>
                        </label> 
                         <div class="form-group">                            
                            <input type="email" name="email" placeholder="Email Address" autocomplete="off" class="form-control placeholder-no-fix">
                        </div>
                        <label class="control-label col-md-3">Enter Password :<span class="required" aria-required="true"> * </span>
                        </label> 
                         <div class="form-group">                            
                            <input type="password" name="password" placeholder="Password" autocomplete="off" class="form-control placeholder-no-fix">
                        </div>
                        <label class="control-label col-md-3">Enter Mobile :<span class="required" aria-required="true"> * </span>
                        </label> 
                         <div class="form-group">                            
                            <input type="mobile" name="mobile" placeholder="Mobile" autocomplete="off" class="form-control placeholder-no-fix">
                        </div>
                         <label class="control-label col-md-3">Enter Location :<span class="required" aria-required="true"> * </span>
                        </label> 
                        <div class="form-group">                            
                           <input type="text" id="departure_address" onFocus="initAutocomplete('departure_address')" class="form-control" name="location" maxlength="255">
                            <input type="hidden" id="departure_latitude" name="latitude" placeholder="Latitude"/>
                            <input type="hidden" id="departure_longitude" name="longitude" placeholder="Longitude"/>    
                        </div>
                        <div class="col-md-1">
                        <a class="display_map" href="javascript:;" onclick="initialize('location');" title="Pick from Map"><img src="http://maps.google.com/mapfiles/ms/icons/blue-dot.png"></a> 
                        </div>
                       <div class="col-md-5">
                             <div id="myMap" class="myMap"></div>
                       </div>
                       

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                        <input class="btn btn-success" type="submit" value="Submit" name="submit">
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->
    </form>




<!-- js placed at the end of the document so the pages load faster -->
<style> label.error { color: red; font-weight: 500; width: 100%; } </style>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo base_url(); ?>/public/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/jquery.validate.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeCDbEPFYP5aVlxPzE8ZDE2O3I_pelYOM&v=3.exp&libraries=places"></script>

</body>
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
                    }
                }
            });
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

    $('#sign_in_form').validate({
        rules: {
            loginemail: {
                required: true,
                email: true
            },
            loginpassword: {
                required: true
            }
        },
        messages: {
            loginemail: {
                required: "Please enter email",
                email: "Please enter valid email"
            },
            loginpassword: {
                required: "Please enter password"
            }
        },
        error: function(label) {
            $(this).addClass("error");
        }
    });

    $('#forgot_form').validate({
        rules: {
            email_forgot: {
                required: true,
                email: true
            }
        },
        messages: {
            email_forgot: {
                required: "Please enter email",
                email: "Please enter valid email"
            }
        },
        error: function(label) {
            $(this).addClass("error");
        },
          submitHandler: function (form) {
            $('.btn').attr('disabled','disabled');
             $(form).submit();
                
            }
    }); 


    $('#vendor_form').validate({
        rules: {
            name: {
                required: true,
              
            },email: {
                required: true,
                email: true
            },password: {
                required: true,
                 minlength:6,
            },mobile: {
                required: true,
                number: true,
                minlength:10,
                maxlength:15
            },
        },
        messages: {
            name: {
                required: "Please enter shop name",
               
            },email: {
                required: "Please enter email",
                email: "Please enter valid email"
            },password: {
                required: "Please enter password",
                minlength: "Please enter minimum 6 digit valid password"
            },mobile: {
                required: "Please enter mobile",
                number: "Please enter number only",
                minlength:"Please enter 10 digit valid number",
                maxlength:"Please enter 15 digit valid number"
            },
        },
        error: function(label) {
            $(this).addClass("error");
        }
    });
</script>
</html>
