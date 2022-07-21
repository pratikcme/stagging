<!-- =================PRODUCT LIST SECTION================= -->
<section class="p-100 bg-cream product-list">
  <div class="container">
    <div class="section-title-wrapper">
      <div class="row align-items-center">
      <div class="col-md-6 col-sm-6 col-12">
        <div class="section-title">
          <h1>Offer Product listing</h1>
        </div>
      </div>
    </div>  
    </div> 

    <div class="row" id="ajaxProduct">

    </div>
   </div>
   <input type="hidden" name="" id="cat_id">
   <input type="hidden" name="" id="sub_cat_id">
   <input type="hidden" name="" id="getBycatID" value="<?=(isset($getBycatID) ?  $this->utility->safe_b64decode($getBycatID) : '' )?>">

</section> 