<section class="breadcrumb-menu breadcrumb-vendor">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">vendor</li>
      </ol>
    </nav>
  </div>
</section>



<section class="p-100 bg-cream">
  <div class="container">
    <div class="vendor-card">
      <div class="vendor-heading">
        <!-- <h6>Maninagar, Ahmedabad</h6> -->
      </div>
      <div class="row" id=vendorByajax>
        <?php foreach ($branch as $key => $value) { ?>
          
        <div class="col-md-6">
          <div class="vendor-loc">
            <div class="vendor-header">
              <!-- <div class="address-chk-box checked"> -->
              <div class="address-chk-box <?=(isset($_SESSION['branch_id']) && $value->id == $_SESSION['branch_id']) ? 'checked' : '' ?>">
               <label> Defualt
                  <input class="vendor-chk" type="checkbox" <?=(isset($_SESSION['branch_id']) && $value->id == $_SESSION['branch_id']) ? 'checked' : '' ?> >
                  <span class="blue"></span>
                </label>
              </div>
            </div>

            <div class="vendor-1">
              <div class="vendor-img">
                <img src="<?=base_url().'public/images/'.$this->folder.'vendor_shop/'.$value->image ?>">
              </div>
              <div class="vendor-detail">
                <a href="javascript:" class="vendor" data-ven_id="<?=$value->id?>"><h5><?=$value->name?></h5></a>
                <p><?=$value->location?></p>
                <p>+91-<?=$value->phone_no?></p>
                
              </div>
            </div>

          </div>
        </div>
        <?php } ?>
      </div>
    </div>

  </div>
  <input type="hidden"  id="is_set" value="<?=$is_set?>">
</section>


