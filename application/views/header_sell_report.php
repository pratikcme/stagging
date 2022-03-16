<?php
if ($this->session->userdata('email_client') == FALSE) {
    redirect('Home/login');
}
$user_id = $this->session->userdata('id');
$register_query = $this->db->query("SELECT * FROM `register` WHERE user_id = '$user_id' GROUP BY id DESC LIMIT 1");
$register_result = $register_query-> result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Point of Sale</title>

     <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>/public/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/public/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url(); ?>/public/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/public/assets/morris.js-0.4.3/morris.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>/public/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/public/css/style-responsive.css" rel="stylesheet" />

    
    <!-- css for datepicker -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>public/css/bootstrap-datepicker.min.css"/>
    <!--<link rel="stylesheet" type="text/css"
          href="<?php /*echo base_url(); */?>public/assets/bootstrap-datepicker/css/datepicker.css"/>-->

    <!-- css for datepicker ends here -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    
</head>

<body>

<section id="container">
    <!--header start-->
    <header class="header white-bg border_top">
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
        </div>
        <!--logo start-->
        <a href="" class="logo">Point Of<span> Sale</span></a>
        <!--logo end-->
        <div class="top-nav ">
            <!--search & user info start-->
            <ul class="nav pull-right top-menu">
                <li>
                    <input type="text" class="form-control search" placeholder="Search">
                </li>
                <!-- user login dropdown start-->
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <!-- <img alt="" src="img/avatar1_small.jpg"> -->
                        <span class="username"><?php echo $this->session->userdata('email_client'); ?></span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <div class="log-arrow-up"></div>
                        <li><a href="<?php echo base_url().'index.php/setting/generalcustomer_list'; ?>"><i class=" fa fa-suitcase"></i>Profile</a></li>
                        <li><a href="<?php echo base_url().'index.php/setting/account'; ?>"><i class="fa fa-cog"></i> Settings</a></li>
                        <li><a href="<?php echo base_url().'index.php/setting/outlet_list'; ?>"><i class="fa fa-bell-o"></i> Outlet</a></li>
                        <li><a href="<?php echo base_url() . 'index.php/Home/logout/'; ?>"><i class="fa fa-key"></i> Log
                                Out</a></li>
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
                <li>
                    <a class="<?php if($this->uri->segment(1) == 'Home' && $this->uri->segment(2) == 'index'){ ?> active <?php } ?>" href="<?php echo base_url() . 'index.php/Home/index/'; ?>">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;" class="dcjq-parent <?php if($this->uri->segment(1) == 'sell' || $this->uri->segment(1) == 'register') { ?> active <?php } ?>">
                        <i class="fa fa-tags"></i>
                        <span>Sell</span>
                    </a>
                    <ul class="sub">
                        <li <?php echo ($this->uri->segment(2) == 'index') ? 'class="active"' : ''; ?> > <a href="<?php echo base_url() . 'index.php/sell/index/'; ?>">Sell</a></li>
                        <li <?php echo ($this->uri->segment(2) == 'history') ? 'class="active"' : ''; ?> > <a href="<?php echo base_url() . 'index.php/sell/history/'; ?>">Sales History</a></li>
                        <?php if(!empty($register_result)){ ?>

                            <?php if($register_result[0]->type == '1'){ ?>
                                <li <?php if($this->uri->segment(1) == 'register' && $this->uri->segment(2) == 'open_register'){ ?> class="active" <?php } ?> ><a href="<?php echo base_url() . 'index.php/register/open_register/'; ?>"> Open/close</a></li>
                            <?php } else { ?>
                                <li <?php if($this->uri->segment(1) == 'register' && $this->uri->segment(2) == 'close_register'){ ?> class="active" <?php } ?> ><a href="<?php echo base_url() . 'index.php/register/close_register/'; ?>"> Open/close</a></li>
                            <?php } ?>

                        <?php }else { ?>
                            <li <?php if($this->uri->segment(1) == 'register' && $this->uri->segment(2) == 'close_register'){ ?> class="active" <?php } ?> ><a href="<?php echo base_url() . 'index.php/register/close_register/'; ?>"> Open/close</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;" class="dcjq-parent <?php if($this->uri->segment(1) == 'product' || $this->uri->segment(1) == 'product_type' || $this->uri->segment(1) == 'supplier' || $this->uri->segment(1) == 'product_brand'|| $this->uri->segment(1) == 'stock_control' ) { ?> active <?php } ?>">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Product</span>
                    </a>
                    <ul class="sub">
                        <li <?php if($this->uri->segment(1) == 'product' && $this->uri->segment(2) == 'index'){ ?> class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/product/index/'; ?>">Product</a></li>
                        <li <?php if($this->uri->segment(1) == 'stock_control' && $this->uri->segment(2) == 'view_stock_control_list'){ ?> class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/stock_control/view_stock_control_list'; ?>">Stock Control</a></li>
                        <li <?php if($this->uri->segment(1) == 'product_type' && $this->uri->segment(2) == 'index'){ ?> class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/product_type/index/'; ?>">Product Types</a></li>
                        <li <?php if($this->uri->segment(1) == 'supplier' && $this->uri->segment(2) == 'index'){ ?> class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/supplier/index/'; ?>">Suppliers</a></li>
                        <li <?php if($this->uri->segment(1) == 'product_brand' && $this->uri->segment(2) == 'index'){ ?> class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/product_brand/index/'; ?>">Product Brands</a>
                        </li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;" class="dcjq-parent <?php if($this->uri->segment(1) == 'customer') { ?> active <?php } ?>">
                        <i class="fa fa-user"></i>
                        <span>Customer</span>
                    </a>
                    <ul class="sub">
                        <li <?php if($this->uri->segment(1) == 'customer' && $this->uri->segment(2) == 'customer_list'){ ?> class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/customer/customer_list/'; ?>">Customer</a></li>
                        <li <?php if($this->uri->segment(1) == 'customer' && $this->uri->segment(2) == 'customer_group_list'){ ?> class="active" <?php } ?>><a  href="<?php echo base_url() . 'index.php/customer/customer_group_list/'; ?>">Group </a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                      <a href="javascript:;" class="dcjq-parent <?php if($this->uri->segment(1) == 'report' || $this->uri->segment(1) == 'sell_report') { ?> active <?php } ?>">
                        <i class="fa fa-bar-chart-o"></i>
                        <span>Report</span>
                    </a>
                    <ul class="sub">
                        <li <?php if($this->uri->segment(1) == 'sell_report' && $this->uri->segment(2) == 'index'){ ?> class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/sell_report/index/'; ?>">Sales Reports</a></li>
                        <li <?php if($this->uri->segment(1) == 'report' && $this->uri->segment(2) == 'index'){ ?> class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/report/index/'; ?>">Payment Reports</a></li>
                        <li <?php if($this->uri->segment(1) == 'report' && $this->uri->segment(2) == 'register_closures'){ ?> class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/report/register_closures/'; ?>">Register Closures</a></li>
                        <li <?php if($this->uri->segment(1) == 'report' && $this->uri->segment(2) == 'inventory_reports'){ ?> class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/report/inventory_reports/'; ?>">Inventory Reports</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;" class="dcjq-parent <?php if($this->uri->segment(1) == 'setting' || $this->uri->segment(1) == 'sales_tax') { ?> active <?php } ?>">
                        <i class="fa fa-cog"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub">
                        <?php if($this->session->userdata('status_privilege') == '1')
                        {
                            ?>
                            <li <?php if($this->uri->segment(1) == 'setting' && $this->uri->segment(2) == 'generalcustomer_list'){ ?> class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/setting/generalcustomer_list/'; ?>">General</a>
                            </li>
                            <li <?php if($this->uri->segment(1) == 'user' && $this->uri->segment(2) == 'user_list'){ ?> class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/user/user_list/'; ?>">User</a>
                            </li>
                            <li <?php if($this->uri->segment(1) == 'setting' && $this->uri->segment(2) == 'account'){ ?> class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/setting/account/'; ?>">Account details</a></li>
                            <li <?php if($this->uri->segment(1) == 'sales_tax' && $this->uri->segment(2) == 'index'){ ?> class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/sales_tax/index/'; ?>">Sales Taxes</a></li>
                          
                            <li <?php if($this->uri->segment(1) == 'setting' && $this->uri->segment(2) == 'outlet_list'){ ?> class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/setting/outlet_list/'; ?>">Outlets</a></li>
                            <?php
                        }
                        else
                        {
                            ?>
                            <li <?php if($this->uri->segment(1) == 'user' && $this->uri->segment(2) == 'user_particular_graph'){ ?> class="active" <?php } ?>><a href="<?php echo base_url() . 'index.php/user/user_particular_graph/'; ?>">Your Sales</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
            </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->

