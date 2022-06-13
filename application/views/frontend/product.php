<!--=================BREADCRUMB SECTION=================  -->
  <section class="category-menu">
    <div class="container">
      <div class="category-menu-wrapper desktop-menu">
        <div class="dropdown">
          <button type="button" class="btn btn-primary dropdown-toggle" id="dropDownBtn" data-toggle="dropdown">  Categories <span><i class="fas fa-angle-down"></i></span> </button>
          <div class="dropdown-menu ">
            <div class="cat-hover">
              <a class="dropdown-item" href="javascript:">
                <div class="category_id" data-cat_id="All"> 
                  <i class="fas fa-birthday-cake" style="display: none"></i>All Categories</div> 
              </a>
            </div>
          <?php foreach ($category as $key => $value): ?>    
            <div class="cat-hover">
              <a class="dropdown-item" href="javascript:">
                <div class="category_id" data-cat_id="<?=$value->id?>"> 
                  <i class="fas fa-birthday-cake" style="display: none"></i> <?=$value->name?> </div> 
              </a>
              <div class="category-sub-menu"> 
              <?php foreach ($value->subcategory as $key => $val): ?>  
                <a class="dropdown-item sucategory_id" href="javascript:" data-sub_id="<?=$val->id?>"><?=$val->name?></a> 
                <?php endforeach ?>
              </div>
            </div>
            <?php endforeach ?>
      
          </div>
        </div>
        <ul class="cat_selected">
        <?php foreach ($getCategoryHighrstProduct as $key => $cate): ?>
          <li><a href="javascript:" class="cate_id" data-cate_id=<?=$cate->id?>><?=$cate->name?></a></li>
          <?php endforeach ?>
        </ul>
      </div>
      <button class="btn mobile-category" onclick="openNav()"> all Categories </button>
      <div id="mySidenav" class="sidenav"> <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="side-category">
          <ul >
            <?php foreach ($category as $key => $value): ?>  
              <li>
                <div class="mobiel-cat">
                  <?php if($key == 0){ ?>
                    <!-- <div class="" data-cat_id="<?=$value->id?>"> 
                      <i class="fas fa-birthday-cake"></i> Gift &amp;
                    </div>  -->
                  <?php } ?>
                  <div class="" data-cat_id="<?=$value->id?>"> 
                    <i class="fas fa-birthday-cake"></i> Gift &amp;
                    <?=$value->name?> 
                  </div> 
               <!--  <span class="new">New</span> 
                <span><i class="fas fa-chevron-right"></i></span> </div> -->

                <div class="category-sub-menu"> 
                  <?php foreach ($subcategory as $k => $val): ?>
                    <a class="sucategory_id" href="javascript:" data-sub_id="<?=$val->id?>"><?=$val->name?></a> 
                  <?php endforeach ?>
                  
                </div>
              </li>
            <?php endforeach ?>
          </ul>
        </div>
  </section>
  <section class="category-menu sub-cat-wrapper">
    <div class="container">
      <div class="category-menu-wrapper sub-cat-menu" style="display:none" id="sd">
            
        <ul class="sub-cat-main" id="short">
          <?php 
            $endKey = 0;
          foreach ($available_subcat as $key => $value){ 
              if($key == 6){
                $endKey++;
                break;
              }
            ?>
          <li><a href="javascript:" class="sucategory_id sub_cat_link" data-sub_id="<?=$value['id']?>"><?=$value['name']?></a></li>
          <?php } ?>
            <div class="dropdown-subcategories" style="display : <?=($endKey < 6) ? '' : 'none'?> ">
              <div class="dropdown">
                <button id="drp-btn" onclick="myFunction()" class="dropbtn">All</button>
                
              </div>
            </div> 
        </ul>
          <div id="myDropdown" class="dropdown-content">
            <ul class="" id="long">
              <?php foreach ($available_subcat as $key => $value): ?>
            <li> 
              <a href="javascript:" class="sucategory_id" data-sub_id="<?=$value['id']?>"><?=$value['name']?></a>
            </li>
              <?php endforeach ?>
            </ul>
          </div>
    </div>  
  </div>
</section>

<!-- <section class="breadcrumb-menu p-100">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">products</li>
      </ol>
    </nav>
  </div>
</section>
 -->
<!-- =================PRODUCT LIST SECTION================= -->
<section class="p-100 bg-cream product-list">
  <div class="container">
    <div class="section-title-wrapper">
      <div class="row align-items-center">
      <div class="col-md-6 col-sm-6 col-12">
        <div class="section-title">
          <h1>Product listing</h1>
        </div>
      </div>
      <div class="col-md-6 col-sm-6 col-12">
        <div class="filter-wrapper">

          <div class="dropdown filter_drop">
            <button type="button" class="dropdown-toggle" id="selected" data-toggle="dropdown" data-sorting="">
            All
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item sorting" data-value="all" href="javascript:">All</a>
              <a class="dropdown-item sorting" data-value="alphabetically" href="javascript:">alphabetical</a>
              <a class="dropdown-item sorting" data-value="high_low" href="javascript:">Price - High to Low</a>
              <a class="dropdown-item sorting" data-value="low_high" href="javascript:">Price - Low to High </a>
              <a class="dropdown-item sorting" data-value="discount_high_low" href="javascript:">% off - High to Low</a>
              <a class="dropdown-item sorting" data-value="discount_low_high" href="javascript:">% off - low to high</a>
            </div>
          </div> 
          <div class="filter-icon">
            <i class="fas fa-filter"></i>

            <div class="filter-dropdown w3-animate-top">
              <div class="filter-dropdown-header">
                 <h6><span class="title-cart"><i class="fas fa-filter"></i></span>Filter</h6>
                   <span class="closing"><i class="fas fa-times-circle"></i></span>
              </div>
                <div class="faq-accordion">
              <ul class="accordion">
                <li class="accordion-item " data-wow-delay="0.5s">
                  <a class="accordion-title" href="javascript:void(0)">
                   <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    Brands
                  </a>
  
                  <div class="accordion-content">
                  <div class="brand-filter">
                    <div class="brand-search">
                      <input type="text" name="" id="search_brand" placeholder="Search Brand...">
                      <span><!-- <i class="fas fa-search"></i> --></span>
                    </div>

                    <ul class="brand-list" id="brand_list">
                      <?php foreach ($brand as $key => $brandRecord): ?>
                      <li>
                        <input type="checkbox" class="brand" name="brand" value="<?=$brandRecord->id?>" >
                        <label><?=$brandRecord->name?><span><?=$brandRecord->totalProduct?></span></label><br>
                      </li>
                      <?php endforeach ?>
                    </ul>
                  </div>
                  </div>
                </li>

                <li class="accordion-item " data-wow-delay="0.7s">
                  <a class="accordion-title" href="javascript:void(0)">
                   <i class="fa fa-plus-circle" aria-hidden="true"></i>
                   price Range
                  </a>
  
                  <div class="accordion-content">
                   <div class="price-range-slider">
                    <p class="range-value">
                      <span id="siteCurr"><?=$this->siteCurrency?></span>
                      <input type="text" class="range" id="amount" readonly>
                      <!-- <input type="hidden"  id="start_range" value="0" readonly>
                      <input type="hidden"  id="end_range" value="150" readonly> -->
                    </p>
                    <div id="slider-range" class="range-bar"></div>
                    
                  </div>
                  </div>
                </li>

                <li class="accordion-item " data-wow-delay="1s">
                  <a class="accordion-title" href="javascript:void(0)">
                   <i class="fa fa-plus-circle" aria-hidden="true"></i>
                   Discount
                  </a>
  
                  <div class="accordion-content">
                       <ul class="brand-list">
                      <li>
                        <input type="checkbox" name="filter_discount"  value="0" class="discount">
                        <label> 0-5% <span><?=$countDiscoutWise[0]?></span></label><br>
                      </li>
                      <li>
                        <input type="checkbox" name="filter_discount"  value="1" class="discount">
                        <label> 5-10% <span><?=$countDiscoutWise[1]?></span></label><br>
                      </li>
                      <li>
                        <input type="checkbox" name="filter_discount"  value="2" class="discount">
                        <label> 10-15% <span><?=$countDiscoutWise[2]?></span> </label><br>
                      </li>
                      <li>
                        <input type="checkbox" name="filter_discount"  value="3" class="discount">
                        <label>15-20% <span><?=$countDiscoutWise[3]?></span> </label><br>
                      </li>
                      <li>
                        <input type="checkbox" name="filter_discount"  value="4" class="discount">
                        <label> 20-25%  <span><?=$countDiscoutWise[4]?></span> </label><br>
                      </li>

                       <li>
                        <input type="checkbox" name="filter_discount"  value="5" class="discount">
                        <label> 25-30%<span><?=$countDiscoutWise[5]?></span> </label><br>
                      </li>

                       <li>
                        <input type="checkbox" name="filter_discount"  value="6" class="discount">
                        <label> 30-35% <span><?=$countDiscoutWise[6]?></span> </label><br>
                      </li>

                       <li>
                        <input type="checkbox" name="filter_discount"  value="7" class="discount">
                        <label>more than 35% <span><?=$countDiscoutWise[7]?></span> </label><br>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
           </div>
            </div>
          </div>
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