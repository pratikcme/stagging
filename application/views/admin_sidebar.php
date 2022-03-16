<li>
    <a class="<?php if ($this->uri->segment(1) == 'admin' && $this->uri->segment(2) == 'dashboard') { ?> active <?php } ?>" href="<?php echo base_url() . 'admin/dashboard/'; ?>">
        <i class="fa fa-dashboard"></i>
        <span>Dashboard</span>
    </a>
</li>
<li>
    <a class="<?php if ($this->uri->segment(1) == 'vendor' ) { ?> active <?php } ?>" href="<?php echo base_url() . 'vendor/vendor_list'; ?>">
        <i class="fa fa-tree"></i>
        <span>Branch Setting</span>
    </a>
</li>
<li>
    <a class="<?php if ($this->uri->segment(1) == 'admin' && $this->uri->segment(2) == 'user_list') { ?> active <?php } ?>" href="<?php echo base_url() . 'admin/user_list/'; ?>">
        <i class="fa fa-user"></i>
        <span>User List</span>
    </a>
</li>
<li>
    <a class="<?php if ($this->uri->segment(1) == 'admins' && ($this->uri->segment(2) == 'privacy_policy' || $this->uri->segment(2) == 'return_refund' || $this->uri->segment(2) == 'term' )) { ?> active <?php } ?>" href="#">
        <i class="fa fa-users"></i>
        <span>Terms</span>
        <i class="fas fa-chevron-right <?=($this->uri->segment(1) == 'admins' && ($this->uri->segment(2) == 'privacy_policy' || $this->uri->segment(2) == 'return_refund' || $this->uri->segment(2) == 'term' )) ? 'rotate' : ''?>"></i>
    </a>
    <ul>
        <li>
            <a class="<?php if ($this->uri->segment(2) == 'privacy_policy') { ?> active <?php } ?>" href="<?php echo base_url() . 'admins/privacy_policy'; ?>">
                <i class="fa fa-product-hunt"></i>
                <span>privacy policy</span>
            </a>
        </li>
        <li>
            <a class="<?php if ($this->uri->segment(2) == 'return_refund') { ?> active <?php } ?>" href="<?php echo base_url() . 'admins/return_refund'; ?>">
                <i class="fa fa-envelope"></i>
                <span>Return & Refund</span>
            </a>
        </li>
        <li>
            <a class="<?php if ($this->uri->segment(2) == 'term') { ?> active <?php } ?>" href="<?php echo base_url() . 'admins/term'; ?>">
                <i class="fa fa-file"></i>
                <span>Term & condition</span>
            </a>
        </li>
    </ul>
</li>
<li style="display: none;">
    <a class="<?php if ($this->uri->segment(2) == 'faq') { ?> active <?php } ?>" href="<?php echo base_url() . 'admins/faq'; ?>">
        <i class="fa fa-file"></i>
        <span>FAQ</span>
    </a>
</li>
<li>
    <a class="<?php if ($this->uri->segment(2) == 'about') { ?> active <?php } ?>" href="#">
        <i class="fa fa-users"></i>
        <span>About</span>
        <i class="fas fa-chevron-right <?=($this->uri->segment(2) == 'about') ? 'rotate' : ''?>"></i>
    </a>
    <ul>
        <li>
            <a class="<?php if ($this->uri->segment(2) == 'about' && $this->uri->segment(3) == 'about_section_one') { ?> active <?php } ?>" href="<?php echo base_url() . 'admins/about/about_section_one'; ?>">
                <i class="fa fa-users"></i>
                <span>About section one</span>
            </a>
        </li>
        <li>
            <a
                class="<?php if ($this->uri->segment(2) == 'about' && $this->uri->segment(3) == 'about_section_two' || $this->uri->segment(2) == 'add') { ?> active <?php } ?>"
                href="<?php echo base_url() . 'admins/about/about_section_two'; ?>"
            >
                <i class="fa fa-university"></i>
                <span>About section two</span>
            </a>
        </li>
        <li>
            <a class="<?php if ($this->uri->segment(2) == 'about' && $this->uri->segment(3) == 'banner' || $this->uri->segment(2) == 'set_profit') { ?> active <?php } ?>" href="<?php echo base_url() . 'admins/about/banner'; ?>">
                <i class="fa fa-university"></i>
                <span>About Banner</span>
            </a>
        </li>
        <li>
            <a class="<?php if ($this->uri->segment(2) == 'about' && $this->uri->segment(3) == 'about_app') { ?> active <?php } ?>" href="<?php echo base_url() . 'admins/about/about_app'; ?>">
                <i class="fa fa-university"></i>
                <span>About App</span>
            </a>
        </li>
    </ul>
</li>
<li>
    <a class="<?php if ($this->uri->segment(2) == 'messagelist' || $this->uri->segment(2) == 'contactinfo') { ?> active <?php } ?>" href="#">
        <i class="fa fa-phone"></i>
        <span>Contact</span>
        <i class="fas fa-chevron-right <?=($this->uri->segment(2) == 'messagelist' || $this->uri->segment(2) == 'contactinfo') ? 'rotate' : ''?>"></i>
    </a>
    <ul>
        <li style="display: none;">
            <a class="<?php if ($this->uri->segment(2) == 'contactinfo') { ?> active <?php } ?>" href="<?php echo base_url() . 'admins/contactinfo'; ?>">
                <i class="fa fa-"></i>
                <span>Contact info</span>
            </a>
        </li>
        <li>
            <a class="<?php if ($this->uri->segment(2) == 'messagelist' || $this->uri->segment(2) == 'add') { ?> active <?php } ?>" href="<?php echo base_url() . 'admins/messagelist'; ?>">
                <i class="fa fa-message"></i>
                <span>User Message List</span>
            </a>
        </li>
    </ul>
</li>
<li>
    <a class="<?php if ($this->uri->segment(1) == 'city' && $this->uri->segment(2) == 'city_list' || $this->uri->segment(2) == 'city_profile') { ?> active <?php } ?>" href="<?php echo base_url() . 'city/city_list/'; ?>">
        <i class="fa fa-building"></i>
        <span>City</span>
    </a>
</li>
<li>
    <a
        class="<?php if ($this->uri->segment(1) == 'price_list' || $this->uri->segment(1) == 'package' || $this->uri->segment(1) == 'weight' || ($this->uri->segment(1) == 'admin' && $this->uri->segment(2) != 'dashboard' && $this->uri->segment(2) != 'user_list' ) ) { ?> active <?php } ?>"
        href="#"
    >
        <i class="fa fa-users"></i>
        <span>Product Setting</span>
        <i
            class="fas fa-chevron-right <?=($this->uri->segment(1) == 'price_list' || $this->uri->segment(1) == 'package' || $this->uri->segment(1) == 'weight' || ($this->uri->segment(1) == 'admin' && $this->uri->segment(2) != 'dashboard' && $this->uri->segment(2) != 'user_list' )) ? 'rotate' : ''?>"
        ></i>
    </a>
    <ul>
        <li>
            <a
                class="<?php if ($this->uri->segment(1) == 'price_list' && $this->uri->segment(2) == 'price' || $this->uri->segment(2) == 'price_list' || $this->uri->segment(2) == 'price_profile') { ?> active <?php } ?>"
                href="<?php echo base_url() . 'price_list/price/'; ?>"
            >
                <i class="fa fa-money"></i>
                <span>Filter Price</span>
            </a>
        </li>
        <li>
            <a class="<?php if ($this->uri->segment(1) == 'package' || $this->uri->segment(2) == 'package_list' || $this->uri->segment(2) == 'package_profile') { ?> active <?php } ?>" href="<?php echo base_url() . 'package'; ?>">
                <i class="fa fa-cubes"></i>
                <span>Package</span>
            </a>
        </li>
        <li>
            <a
                class="<?php if ($this->uri->segment(1) == 'admin' && $this->uri->segment(2) == 'discount_list' || $this->uri->segment(2) == 'discount_profile') { ?> active <?php } ?>"
                href="<?php echo base_url() . 'admin/discount_list/'; ?>"
            >
                <i class="fa fa-tags"></i>
                <span>Filter Discount</span>
            </a>
        </li>
        <li>
            <a class="<?php if ($this->uri->segment(1) == 'weight' && $this->uri->segment(2) == 'weight_list' || $this->uri->segment(2) == 'weight_profile') { ?> active <?php } ?>" href="<?php echo base_url() . 'weight/weight_list/'; ?>">
                <i class="fa fa-balance-scale"></i>
                <span>Unit</span>
            </a>
        </li>
    </ul>
</li>

<li>
    <a class="<?php if ($this->uri->segment(1) == 'firebase' ) { ?> active <?php } ?>" href="<?php echo base_url() . 'firebase'; ?>">
        <i class="fa fa-credit-card" aria-hidden="true"></i>
        <span>Common keys</span>
    </a>
</li>
<li style="display: none">
    <a class="<?php if ($this->uri->segment(1) == 'subscription' ) { ?> active <?php } ?>" href="<?php echo base_url() . 'subscription'; ?>">
        <i class="fa fa-envelope"></i>
        <span>Subcription</span>
    </a>
</li>
<li>
    <a
        class="<?php if ($this->uri->segment(1) == 'setting' || $this->uri->segment(1) == 'delivery_charge' || $this->uri->segment(1) == 'time_slot' || $this->uri->segment(1) == 'setting' || $this->uri->segment(1) == 'setting') { ?> active <?php } ?>"
        href="#"
    >
        <i class="fa fa-cog"></i>
        <span>Settings</span>
        <i
            class="fas fa-chevron-right <?=($this->uri->segment(1) == 'setting' || $this->uri->segment(1) == 'delivery_charge' || $this->uri->segment(1) == 'time_slot' || $this->uri->segment(1) == 'setting' || $this->uri->segment(1) == 'setting') ? 'rotate' : '' ?>"
        ></i>
    </a>
    <ul>
        <li>
            <a class="<?php if ($this->uri->segment(1) == 'setting' && $this->uri->segment(2) == 'cart_value') { ?> active <?php } ?>" href="<?php echo base_url() . 'setting/cart_value/'; ?>">
                <i class="fa fa-cog"></i>
                <span>Minimum Cart Value</span>
            </a>
        </li>
        <li>
            <a class="<?php if ($this->uri->segment(1) == 'setting' && $this->uri->segment(2) == 'profit_percent') { ?> active <?php } ?>" href="<?php echo base_url() . 'setting/profit_percent/'; ?>">
                <i class="fa fa-cog"></i>
                <span>Profit Percentage</span>
            </a>
        </li>
        <li style="display: none;">
            <a class="<?php if ($this->uri->segment(1) == 'setting' && $this->uri->segment(2) == 'subscription') { ?> active <?php } ?>" href="<?php echo base_url() . 'setting/subscription/'; ?>">
                <i class="fa fa-cog"></i>
                <span>Set Subscription Plan</span>
            </a>
        </li>
        <li>
            <a class="<?php if ($this->uri->segment(1) == 'setting' && $this->uri->segment(2) == 'currency') { ?> active <?php } ?>" href="<?php echo base_url() . 'setting/currency/'; ?>">
                <i class="fa fa-cog"></i>
                <span>Currency</span>
            </a>
        </li>
        <li>
            <a class="<?php if ($this->uri->segment(1) == 'delivery_charge') { ?>< active ><?php } ?><" href="<?php echo base_url() . 'delivery_charge/'; ?>">
                <i class="fa fa-cog"></i>
                <span>Delivery Charge</span>
            </a>
        </li>
        <li>
            <a
                class="<?php if ($this->uri->segment(1) == 'time_slot' && $this->uri->segment(2) == 'time_slot_list' || $this->uri->segment(2) == 'time_slot_profile') { ?> active <?php } ?>"
                href="<?php echo base_url() . 'time_slot/time_slot_list/'; ?>"
            >
                <i class="fa fa-clock-o"></i>
                <span>Time Slot</span>
            </a>
        </li>
    </ul>
</li>
<li>
    <a class="<?php if ($this->uri->segment(1) == 'banner_promotion' || $this->uri->segment(2) == 'web_banners') { ?> active <?php } ?>" href="#">
        <i class="fa fa-picture-o"></i>
        <span>Banner</span>
        <i class="fas fa-chevron-right <?=($this->uri->segment(1) == 'banner_promotion' || $this->uri->segment(2) == 'web_banners') ? 'rotate' : '' ?>"></i>
    </a>
    <ul>
        <li>
            <a class="<?php if ($this->uri->segment(2) == 'banner_promotion_list') { ?> active <?php } ?>" href="<?php echo base_url() . 'banner_promotion/banner_promotion_list/'; ?>">
                <i class="fa fa-picture-o"></i>
                <span>Banner Promotion</span>
            </a>
        </li>
    </ul>
</li>
