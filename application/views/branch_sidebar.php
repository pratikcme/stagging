
<li class="sub-menu" style="display: none" >
    <a href="javascript:;" class="dcjq-parent <?php if($this->uri->segment(1) == 'sell' || $this->uri->segment(1) == 'register') { ?> active <?php } ?>">
        <i class="fa fa-tags"></i>
        <span>Sell</span>
    </a>
    <ul class="sub">
        <li <?php echo ($this->uri->segment(2) == 'index') ? 'class="active"' : ''; ?> > <a href="<?php echo base_url() . 'sell/index/'; ?>">Sell</a></li>
        <li <?php echo ($this->uri->segment(2) == 'index') ? 'class="active"' : ''; ?> > <a href="<?php echo base_url() . 'sell_development/index/'; ?>">Sell development</a></li>
        <li <?php echo ($this->uri->segment(2) == 'history') ? 'class="active"' : ''; ?> > <a href="<?php echo base_url() . 'sell_development/history/'; ?>">Sell History</a></li>
        <li <?php echo ($this->uri->segment(2) == 'parked_sell_list') ? 'class="active"' : ''; ?> > <a href="<?php echo base_url() . 'sell/parked_sell_list/'; ?>">Parked Sell</a></li>
        <?php if(!empty($register_result)){ ?>
        <?php if($register_result[0]->type == '1'){ ?>
        <li <?php if($this->
            uri->segment(1) == 'register' && $this->uri->segment(2) == 'open_register'){ ?> class="active"
            <?php } ?>
            ><a href="<?php echo base_url() . 'register/open_register/'; ?>"> Open/Close</a>
        </li>
        <?php } else { ?>
        <li <?php if($this->
            uri->segment(1) == 'register' && $this->uri->segment(2) == 'close_register'){ ?> class="active"
            <?php } ?>
            ><a href="<?php echo base_url() . 'register/close_register/'; ?>"> Open/Close</a>
        </li>
        <?php } ?>
        <?php }else { ?>
        <li <?php if($this->
            uri->segment(1) == 'register' && $this->uri->segment(2) == 'close_register'){ ?> class="active"
            <?php } ?>
            ><a href="<?php echo base_url() . 'register/close_register/'; ?>"> Open/Close</a>
        </li>
        <?php } ?>
    </ul>
</li>
<li class="sub-menu" style="display: none;">
    <a href="javascript:;" class="dcjq-parent <?php if($this->uri->segment(1) == 'stock_control' || $this->uri->segment(1) == 'supplier') { ?> active <?php } ?>">
        <i class="fa fa-tags"></i>
        <span>Product Management</span>
    </a>
    <ul class="sub">
        <li <?php if($this->
            uri->segment(1) == 'stock_control' || $this->uri->segment(2) == 'view_stock_control_list'){ ?> class="active"
            <?php } ?>><a href="<?php echo base_url() . 'stock_control/view_stock_control_list'; ?>">Stock Control</a>
        </li>
        <li <?php if($this->
            uri->segment(1) == 'supplier' || $this->uri->segment(2) == 'index'){ ?> class="active"
            <?php } ?>><a href="<?php echo base_url() . 'supplier/index/'; ?>">Suppliers</a>
        </li>
    </ul>
</li>
<li class="sub-menu" style="display: none;">
    <a href="javascript:;" class="dcjq-parent <?php if($this->uri->segment(1) == 'report' || $this->uri->segment(1) == 'sell_report') { ?> active <?php } ?>">
        <i class="fa fa-bar-chart-o"></i>
        <span>Report</span>
    </a>
    <ul class="sub">
        <li <?php if($this->
            uri->segment(1) == 'sell_report' && $this->uri->segment(2) == 'index'){ ?> class="active"
            <?php } ?>><a href="<?php echo base_url() . 'sell_report/index/'; ?>">Sell Reports</a>
        </li>
        <li <?php if($this->
            uri->segment(1) == 'report' && $this->uri->segment(2) == 'index'){ ?> class="active"
            <?php } ?>><a href="<?php echo base_url() . 'report/index/'; ?>">Payment Reports</a>
        </li>
        <li <?php if($this->
            uri->segment(1) == 'report' && $this->uri->segment(2) == 'register_closures'){ ?> class="active"
            <?php } ?>><a href="<?php echo base_url() . 'report/register_closures/'; ?>">Register Closures</a>
        </li>
        <li <?php if($this->
            uri->segment(1) == 'report' && $this->uri->segment(2) == 'inventory_reports'){ ?> class="active"
            <?php } ?>><a href="<?php echo base_url() . 'report/inventory_reports/'; ?>">Inventory Reports</a>
        </li>
    </ul>
</li>
<li class="sub-menu" style="display: none;">
    <a href="javascript:;" class="dcjq-parent <?php if($this->uri->segment(1) == 'customer') { ?> active <?php } ?>">
        <i class="fa fa-user"></i>
        <span>Customer</span>
    </a>
    <ul class="sub">
        <li <?php if($this->
            uri->segment(1) == 'customer' && $this->uri->segment(2) == 'customer_list'){ ?> class="active"
            <?php } ?>><a href="<?php echo base_url() . 'customer/customer_list/'; ?>">Customer</a>
        </li>
        <li <?php if($this->
            uri->segment(1) == 'customer' && $this->uri->segment(2) == 'customer_group_list'){ ?> class="active"
            <?php } ?>><a href="<?php echo base_url() . 'customer/customer_group_list/'; ?>">Group </a>
        </li>
    </ul>
</li>
<li>
    <a class="<?php if ($this->uri->segment(1) == 'delivery') { ?> active <?php } ?>" href="#">
        <i class="fa fa-users"></i>
        <span>Delivery</span>
    </a>
    <ul>
        <li>
            <a class="<?php if ($this->uri->segment(1) == 'delivery' && $this->uri->segment(2) == 'delivery_list') { ?> active <?php } ?>" href="<?php echo base_url() . 'delivery/delivery_list/'; ?>">
                <i class="fa fa-users"></i>
                <span>Delivery List</span>
            </a>
        </li>
    </ul>
</li>
<?php if($this->countCategory == 1){ ?>
<li >
    <a class="<?php if ($this->uri->segment(1) == 'home_content') { ?> active <?php } ?>" href="#">
        <i class="fa fa-home"></i>
        <span>Home</span>
    </a>
    <ul>
        <li>
            <a class="<?php if ($this->uri->segment(1) == 'home_content') { ?> active <?php } ?>" href="<?php echo base_url() . 'home_content'; ?>">
                <i class="fa fa-user"></i>
                <span>Home content</span>
            </a>
        </li>
        <li>
            <a class="<?php if ($this->uri->segment(2) == 'home_section_one' || $this->uri->segment(3) == 'add') { ?> active <?php } ?>" href="<?php echo base_url() . 'home_content/home_section_one'; ?>">
                <i class="fa fa-user"></i>
                <span>Home section one</span>
            </a>
        </li>
    </ul>
</li>
<?php } ?>
<li>
    <a class="<?php if ($this->uri->segment(1) == 'staff') { ?> active <?php } ?>" href="<?php echo base_url() . 'staff'; ?>">
        <i class="fa fa-user"></i>
        <span>Staff</span>
    </a>
</li>
<li>
    <a class="<?php if ($this->uri->segment(1) == 'category') { ?> active <?php } ?>" href="<?php echo base_url() . 'category/category_list/'; ?>">
        <i class="fa fa-list"></i>
        <span>Category</span>
    </a>
</li>
<li>
    <a class="<?php if ($this->uri->segment(1) == 'subCategory') { ?> active <?php } ?>" href="<?php echo base_url() . 'subCategory/'; ?>">
        <i class="fa fa-list"></i>
        <span>Sub Category</span>
    </a>
</li>
<li>
    <a class="<?php if ($this->uri->segment(1) == 'brand' && $this->uri->segment(2) == 'brand_list' || $this->uri->segment(2) == 'brand_profile') { ?> active <?php } ?>" href="<?php echo base_url() . 'brand/brand_list/'; ?>">
        <i class="fa fa-shield"></i>
        <span>Brand</span>
    </a>
</li>
<li>
    <a
        class="<?php if ($this->uri->segment(1) == 'product' && $this->uri->segment(2) == 'product_list' || $this->uri->segment(2) == 'product_profile' || $this->uri->segment(2) == 'product_weight_list' || $this->uri->segment(2) == 'product_weight_profile' || $this->uri->segment(2) == 'product_image_list') { ?> active <?php } ?>"
        href="<?php echo base_url() . 'product/product_list/'; ?>"
    >
        <i class="fa fa-product-hunt"></i>
        <span>Product</span>
    </a>
</li>
<li class="sub-menu">
    <a href="javascript:;" class="dcjq-parent <?php if($this->uri->segment(1) == 'import') { ?> active <?php } ?>">
        <i class="fa fa-bar-chart-o"></i>
        <span>Excel</span>
        <i class="fas fa-chevron-right"></i>
    </a>
    <ul class="sub">
        <li <?php if($this->
            uri->segment(1) == 'import' && $this->uri->segment(2) == ''){ ?> class="active"
            <?php } ?>><a href="<?php echo base_url() . 'import/'; ?>">Make Excel</a>
        </li>
        <li <?php if($this->
            uri->segment(1) == 'import' && $this->uri->segment(2) == 'import_excel'){ ?> class="active"
            <?php } ?>><a href="<?php echo base_url() . 'import/import_excel'; ?>">Import Excel</a>
        </li>
    </ul>
</li>
<li>
    <a class="<?php if ($this->uri->segment(1) == 'order') { ?> active <?php } ?>" href="<?php echo base_url() . 'order'; ?>">
        <i class="fa fa-first-order"></i>
        <span>Order</span>
    </a>
</li>
<li>
    <a class="<?php if ($this->uri->segment(1) == 'order' && $this->uri->segment(2) == 'order_report' ) { ?> active <?php } ?>" href="<?php echo base_url() . 'order/order_report'; ?>">
        <i class="fa fa-file"></i>
        <span>Order Report</span>
    </a>
</li>
<li>
    <a class="<?php if ($this->uri->segment(2) == 'order_summary' ) { ?> active <?php } ?>" href="<?php echo base_url() . 'order/order_summary'; ?>">
        <i class="fa fa-file"></i>
        <span>Order summary</span>
    </a>
</li>
<li style="display: none;">
    <a class="<?php if ($this->uri->segment(1) == 'subscription' ) { ?> active <?php } ?>" href="<?php echo base_url() . 'subscription/vendor_detail'; ?>">
        <i class="fa fa-envelope"></i>
        <span>Subcription</span>
    </a>
</li>
<li>
    <a class="<?php if ($this->uri->segment(1) == 'payment_method' ) { ?> active <?php } ?>" href="<?php echo base_url() . 'payment_method'; ?>">
        <i class="fa fa-credit-card" aria-hidden="true"></i>
        <span>Payment Method</span>
    </a>
</li>
<li style="display:none">
    <a class="<?php if ($this->uri->segment(1) == 'banner_promotion' || $this->uri->segment(2) == 'web_banners') { ?> active <?php } ?>" href="#">
        <i class="fa fa-picture-o"></i>
        <span>Banner</span>
        <i class="fas fa-chevron-right <?=($this->uri->segment(1) == 'banner_promotion' || $this->uri->segment(2) == 'web_banners') ? 'rotate' : '' ?>"></i>
    </a>
    <ul>
        
        <li>
            <a class="<?php if ($this->uri->segment(2) == 'web_banners' || $this->uri->segment(2) == 'add') { ?> active <?php } ?>" href="<?php echo base_url() . 'admins/web_banners'; ?>">
                <i class="fa fa-picture-o"></i>
                <span>Web Banner </span>
            </a>
        </li>
    </ul>
</li>
<li>
    <a class="<?php if ($this->uri->segment(1) == 'promocode_manage' ) { ?> active <?php } ?>" href="<?php echo base_url() . 'promocode_manage'; ?>">
        <i class="fa fa-credit-card" aria-hidden="true"></i>
        <span>Manage Promocode</span>
    </a>
</li>
