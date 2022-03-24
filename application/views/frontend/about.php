<!--=================BREADCRUMB SECTION=================  -->
<section class="breadcrumb-menu breadcrumb-about">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">About us</li>
      </ol>
    </nav>
  </div>
</section>

<!--=================ABOUT SECTION=================  -->
<section class="p-100 bg-cream">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="about-detail">
          <h5><?=$about_section_one[0]->main_title?></h5>
          <p><?=$about_section_one[0]->content?></p>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="about-img">
          <img src="<?=base_url().'public/uploads/about/'.$about_section_one[0]->image ?>">
        </div>
      </div>
    </div>  
  </div>
</section>

<!--=================CLIENT SECTION=================  -->
<section class="p-100 bg-blue">
        <div class="container"> 
            <div class="row">
                <div class="col-12">
                    <div class="client-title">
                        <h6>What Our Clients Say</h6>
                    </div>
                </div>
            </div>               
        </div>
        <div class="owl-carousel client-owl-slider owl-theme mt-5">
         <?php foreach ($about_section_two as $key => $value): ?> 
            <div class="item" >
                <div class="client-wrapper">
                    <p><?=$value->content?></p>
                    <div class="client-name">
                        <h4><?=$value->name?></h4>
                        <h5><?=$value->designation?></h5>
            
                        <div class="client-img">
                            <img src="<?=base_url().'public/uploads/about/'.$value->image?>">
                        </div>
                    </div>
                </div>                  
            </div>
            <?php endforeach ?> 
            <!-- <div class="item">
                <div class="client-wrapper">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap.</p>
                    <div class="client-name">
                        <h4>Job Way</h4>
                        <h5>CEO & Founder</h5>
            
                        <div class="client-img">
                            <img src="<?=base_url().'public/frontend/'?>assets/images/about/client-1.png">
                        </div>
                    </div>
                </div>                  
            </div>
             <div class="item">
                <div class="client-wrapper">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap.</p>
                    <div class="client-name">
                        <h4>Job Way</h4>
                        <h5>CEO & Founder</h5>
            
                        <div class="client-img">
                            <img src="<?=base_url().'public/frontend/'?>assets/images/about/client-1.png">
                        </div>
                    </div>
                </div>                  
            </div>
             <div class="item">
                <div class="client-wrapper">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap.</p>
                    <div class="client-name">
                        <h4>Job Way</h4>
                        <h5>CEO & Founder</h5>
            
                        <div class="client-img">
                            <img src="<?=base_url().'public/frontend/'?>assets/images/about/client-1.png">
                        </div>
                    </div>
                </div>                  
            </div>
             <div class="item">
                <div class="client-wrapper">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap.</p>
                    <div class="client-name">
                        <h4>Job Way</h4>
                        <h5>CEO & Founder</h5>
            
                        <div class="client-img">
                            <img src="<?=base_url().'public/frontend/'?>assets/images/about/client-1.png">
                        </div>
                    </div>
                </div>                  
            </div>
             <div class="item">
                <div class="client-wrapper">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap.</p>
                    <div class="client-name">
                        <h4>Job Way</h4>
                        <h5>CEO & Founder</h5>
            
                        <div class="client-img">
                            <img src="<?=base_url().'public/frontend/'?>assets/images/about/client-1.png">
                        </div>
                    </div>
                </div>                  
            </div> -->        
        </div>
</section>


<!--=================COUNTRT SECTION=================  -->
<section class="bg-cream p-100" id="counter" style="display: none">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-md-6">
        <div class="counter-wrapper">
          <div class="counter-img">
            <img src="<?=base_url().'public/frontend/'?>assets/images/about/counter-1.png">
          </div>
          <div class="counter-detail">
            <h6 class="count" data-count="15">0</h6><span>+</span>
            <p>Cities Covered</p>
          </div>
        </div>
      </div>

         <div class="col-lg-4 col-md-6">
        <div class="counter-wrapper">
          <div class="counter-img">
            <img src="<?=base_url().'public/frontend/'?>assets/images/about/counter-2.png">
          </div>
          <div class="counter-detail">
            <h6  class="count" data-count="<?=$totalVendor?>">0</h6><span>+</span>
            <p>vendor store</p>
          </div>
        </div>
      </div>

         <div class="col-lg-4 col-md-6">
        <div class="counter-wrapper">
          <div class="counter-img">
            <img src="<?=base_url().'public/frontend/'?>assets/images/about/counter-3.png">
          </div>
          <div class="counter-detail">
            <h6  class="count" data-count="<?=$totalCustomber?>">0 </h6><span>+</span>
            <p>happy customers</p> 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>