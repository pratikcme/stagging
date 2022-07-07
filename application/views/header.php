<?php if ($this->session->userdata('email') == FALSE) { ?>

    <script type="text/javascript">
        window.location.href = "<?php echo base_url(); ?>";
    </script>

<?php }
$myhidejs = 0;
$vendor_id = $this->session->userdata('id');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript">
        window.addEventListener("pageshow", function (event) {
            var historyTraversal = event.persisted ||
                (typeof window.performance != "undefined" &&
                    window.performance.navigation.type === 2);
            if (historyTraversal) {

                window.location.reload();
            }
        });
    </script>
    <style type="text/css">
        .alert {
            position: absolute;
            z-index: 10;
            /*margin-left: 64%;*/
            width: 84%;
        }
        .tgl {
            display: none;
        }
        .tgl, .tgl:after, .tgl:before, .tgl *, .tgl *:after, .tgl *:before, .tgl + .tgl-btn {
            box-sizing: border-box;
        }
        .tgl::-moz-selection, .tgl:after::-moz-selection, .tgl:before::-moz-selection, .tgl *::-moz-selection, .tgl *:after::-moz-selection, .tgl *:before::-moz-selection, .tgl + .tgl-btn::-moz-selection {
            background: none;
        }
        .tgl::selection, .tgl:after::selection, .tgl:before::selection, .tgl *::selection, .tgl *:after::selection, .tgl *:before::selection, .tgl + .tgl-btn::selection {
            background: none;
        }
        .tgl + .tgl-btn {
            outline: 0;
            display: block;
            width: 4em;
            height: 1.9em;
            position: relative;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .sidebar-menu{ height:auto !important}
        button.btn.btn-default {
    margin-top: 0px !important;
}
        .tgl + .tgl-btn:after, .tgl + .tgl-btn:before {
            position: relative;
            display: block;
            content: "";
            width: 50%;
            height: 100%;
        }
        .tgl + .tgl-btn:after {
            left: 0;
        }
        .tgl + .tgl-btn:before {
            display: none;
        }
        .tgl:checked + .tgl-btn:after {
            left: 50%;
        }

        .tgl-light + .tgl-btn {
            margin-left: 11em;
            background: #ef6a60;
            border-radius: 2em;
            padding: 2px;
            -webkit-transition: all .4s ease;
            transition: all .4s ease;
            margin-top: -1.5em;
        }
        .tgl-light + .tgl-btn:after {
            border-radius: 50%;
            background: #fff;
            -webkit-transition: all .2s ease;
            transition: all .2s ease;
        }
        .tgl-light:checked + .tgl-btn {
            background: #7fc01e;
        }
        .error{
            color:red;
        }

        .form-control.change-vendor{
            position: relative;
            top: 1px;
        }

/* ======= NOTIFICATION ======== */


        /* ======= NOTIFICATION ======== */

        .top-nav{
            display:flex;
        }
.notif{
     padding:10px;
     position: relative;
     cursor: pointer;
   }
   .notif ul.dropdown {
  display: none;
  position: absolute;
  top: 110%;
  right:0px;
  min-width: 374px;
  padding: 0;
  border-radius: 5px;
  box-shadow: 0px 14px 16px -11px rgba(0,0,0,0.75);
  background:#fff;
  z-index: 22;
  height: 300px;
  overflow:auto !important;
   
}
.notif .fa-bell {
  color:#63CDF5;
  font-size:18px;
}
.notif .dropdown-toggle::after {
  display:none;
}

.notif ul.dropdown::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #fff;
}

.notif ul.dropdown::-webkit-scrollbar
{
    width: 6px;
    background-color: #fff !important;
}

.notif ul.dropdown::-webkit-scrollbar-thumb
{
    background-color: #63CDF5;
    border-radius: 10px;
}

.notif .dropdown.notify-drop.ishave{
    height:45px !important;
}
 
.notif ul.dropdown li {
  padding: 10px;
  list-style-type: none;
  border-top: 1px solid lightgrey;
  cursor: pointer;
}   
 
.notif ul.dropdown li:hover{
  background-color: #eee;
}
    
.notif ul.dropdown li:first-child {
  list-style-type: none;
  border-top: none;    
  
}
    
.notif ul.dropdown .fa-circle{
    font-size: 15px;
    color: rgba(115, 187, 22, 1);
} 
    

/*View All Notification*/
.notif ul.dropdown .fa-list{
    font-size: 15px;
    padding:5px;
    color: rgba(115, 187, 22, 1); 
    border: 2px solid rgba(115, 187, 22, 1);
    border-radius: 100%;
}
    
.notif ul.dropdown li:last-child{
    text-align: center;
    padding: 10px;
    background:#fff;
    position: sticky;
    bottom:0;
    color:#63CDF5;
    font-weight:bold;
}   


@media only screen and (max-width:768px)  {
    .notif ul.dropdown{
        min-width: 320px;
        right: -100px;
    }
}
.btn__badge {
    background: #FF5D5D;
    color: white;
    font-size: 12px;
    position: absolute;
    top: 8px;
    right: 4px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}


    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="<?=($this->siteFevicon != '') ? $this->siteFevicon : $this->siteLogo;?>" type="image/gif" sizes="8x8">
    <title><?=$this->siteTitle?></title>

    <link href="<?php echo base_url(); ?>public/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>public/css/bootstrap-reset.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>public/css/multi-select.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>public/css/fileinput.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"/>

    <link href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css"
          rel="stylesheet">

    <link href="<?php echo base_url(); ?>public/css/demo_page.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>public/css/demo_table.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>public/css/DT_bootstrap.css" rel="stylesheet"/>

    <link href="<?php echo base_url(); ?>public/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet"
          type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/css/owl.carousel.css" type="text/css">

    <link href="<?php echo base_url(); ?>public/css/datetimepicker.css">

    <link href="<?php echo base_url(); ?>public/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>public/css/style-responsive.css" rel="stylesheet"/>

    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyB-nS3x_SS2JjPSrbq772nwf4QEHRSK1y4"
            type="text/javascript"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
</head>
<body>
<?php $vendor_id = $this->session->userdata['id']; ?>
<?php if (isset($this->session->userdata['staff_id'])) {
    $staff_id = $this->session->userdata['staff_id'];
} ?>
<?php if (isset($this->session->userdata['delivery_admin'])) {
    $delivery_admin = $this->session->userdata['delivery_admin'];
} ?>
<section id="container">
    <!--header start-->
    <header class="header white-bg border_top">
    	<div class="hdr_logo_sidebar">
	    	 <div class="sidebar-toggle-box">
	            <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
	        </div>
	        <!--logo start-->
	        <a href="<?=base_url().'admin/dashboard/'?>" class="logo"><?=$this->siteTitle?></a>
	        <!--logo end-->	
    	</div>
       
        <div class="top-nav ">
            <?php if(isset($_SESSION['id']) && $_SESSION['id'] > '0' ){ ?> 
            <div class="notif">
               <div class="<?=(count($this->adminNotification) > 0) ? "btn__badge" : ""?> pulse-button"  id="notify-dot"></div>
               <i class="fas fa-bell dropdown-toggle notify-dropdown"></i>   
               <ul class="dropdown notify-drop <?=(count($this->adminNotification) == "0") ? 'ishave' : ''   ?>"  id="admin_notification">
                    <?php foreach ($this->adminNotification as $key => $value): ?>
                       <li><?=$value->message?></li>
                   <?php endforeach ?>
                   <?php if(count($this->adminNotification) == "0"){ ?> 
                      <li>No Notification</li>
                  <?php }else{ ?> 
                     <li id="clear_all">Clear All</li>
                 <?php } ?>
                </ul>
            </div> 
            <?php } ?>
            <!--search & user info start-->
            <ul class="nav pull-right top-menu">
                <!-- user login dropdown start-->
                <?php 
                if($this->session->userdata('flag') !== '' && $this->session->userdata('type') == '1'){ ?>
                    <li>
                     <select class="form-control change-vendor">
                          <option value="vendor_admin" <?=($this->session->userdata('vendor_admin')=='1') ? "SELECTED" : "" ?>>Vendor Admin</option>
                        <?php foreach ($AllVendor = getAllBranch() as $key => $value) { ?>
                          <option value="<?=$value->id?>" <?=($this->session->userdata('id') == $value->id) ? "SELECTED" : "" ?> ><?=$value->name?></option>
                        <?php } ?>
                      </select>   
                    </li>
                <?php } ?>
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="username"><?php echo $this->session->userdata('name'); ?></span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <div class="log-arrow-up"></div>
                        <?php if (!isset($staff_id)) { ?>
                            <li><a href="<?php echo base_url() . 'admin/profile'; ?>"><i class=" fa fa-suitcase"></i>Profile</a>
                            </li>
                            <li><a href="<?php echo base_url() . 'admin/update_password'; ?>"><i class="fa fa-lock"></i>Change </br> Password</a></li>
                            <?php if ($vendor_id != 0) { ?>
                                <li><a href="<?php echo base_url() . 'order'; ?>"><i class="fa fa-first-order"></i>Order</a>
                                </li>
                            <?php }else{ ?>
                              <!--   
                                <li><a href="<?php echo base_url() . 'delivery/delivery_admin'; ?>"><i class="fa fa-motorcycle"></i>Delivery <br> Management </a>
                                </li> -->
                            <?php  } ?>
                        <?php } ?>
                        <li>
                            <a href="javascript:;" class="btn btn-success btn-xs" onclick="logoutvendor();">
                                <i class="fa fa-key"></i> LogOut</a></li>
                    </ul>
                </li>
                <!-- user login dropdown end -->
            </ul>
            
            <!--search & user info end-->
        </div>
    </header>
    <!--header end-->
    <!--sidebar start-->
    <aside>
         <div id="sidebar" class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">
               <?php if ($vendor_id != 0 && !isset($staff_id)) { 
                  $get = $this->db->query("SELECT delivery_by FROM `branch` WHERE id = '$vendor_id'");
                   $getdata = $get-> result(); 
                   // print_r( $getdata['0']);
                   ?>
               <li style="display: none;">
                  <a href="#">
                     <i class="fa fa-product-hunt"></i>
                     <span>Online Delivery</span>
                     <div class="tgl-group">
                        <input class='tgl tgl-light' id='display-address' type='checkbox' <?php if($getdata['0']->delivery_by=='1'){ echo "checked=checked";} ?>>
                        <label class='tgl-btn' for='display-address'></label>
                     </div>
                  </a>
               </li>
               <?php } ?>
               <?php if (isset($delivery_admin)) { ?>
               <li>
                  <a class="<?php if ($this->uri->segment(1) == 'delivery') { ?> active <?php } ?>" href="#">
                  <i class="fa fa-users"></i>
                  <span>Delivery</span>
                  </a>
                  <ul>
                     <li>
                        <a class="<?php if ($this->uri->segment(1) == 'delivery' && $this->uri->segment(2) == 'delivery_list') { ?> active <?php } ?>"
                           href="<?php echo base_url() . 'delivery/delivery_list/'; ?>">
                        <i class="fa fa-users"></i>
                        <span>Delivery List</span>
                        </a>
                     </li>
                  </ul>
               </li>
               <?php }else { 
                  if ($vendor_id == 0 && !isset($staff_id)) { ?>
                    <?php $this->load->view('admin_sidebar'); ?>

               <?php } else {
                  if (!isset($staff_id)) { ?>
                    <?php $this->load->view('branch_sidebar'); ?> 
             
               <?php } } } ?>
            </ul>
            <!-- sidebar menu end-->
         </div>
      </aside>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--sidebar end-->
    <script>
        
        
        function logoutvendor() {
            bootbox.confirm("Are you sure you want to logout?", function (confirmed) {
                if (confirmed == true) {
                    $.ajax({
                        url: '<?php echo base_url() . 'admin/logout'; ?>',
                        success: function (data) {
                            window.location.reload(true);
                        },

                    });
                }
                else {
                    window.location.reload(true);
                }
            });
        }
    </script>

<script>

      $(document).ready(function(){
        $('ul.sidebar-menu li a').click(function(){
          $('.fa-chevron-right').removeClass('rotate');
          if ($(this).hasClass('active')) {
          $(this).children('.fa-chevron-right').addClass('rotate');
          }
        });
      });
      
  </script>