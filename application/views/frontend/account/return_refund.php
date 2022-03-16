<!--=================BREADCRUMB SECTION=================  -->
<section class="breadcrumb-menu breadcrumb-contact">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url().'home'?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Return & Refund</li>
      </ol>
    </nav>
  </div>
</section>


<section class="p-100 bg-cream">
  <div class="container">
    <div class="row">
      <?php  foreach ($return_refund as $key => $value) { ?>
      <div class="col-md-12">
        <div class="policy-wrapper">
          <h5><?=$value->title?></h5>
          <p><?=$value->sub_title?></p>
          <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s.</p> -->
        </div>
      </div>
      <?php }  ?>

<!--        <div class="col-md-12">
          <div class="policy-wrapper">
            <h5>Lorem Ipsum</h5>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s.
            </p>
          </div>
      </div>

      <div class="col-md-12">
          <div class="policy-wrapper">
            <h5>Lorem Ipsum</h5>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s.
            </p>
          </div>
      </div>

      <div class="col-md-12">
          <div class="policy-wrapper">
            <h5>Lorem Ipsum</h5>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s.
            </p>
          </div>
      </div>


      <div class="col-md-12">
          <div class="policy-wrapper">
            <h5>Lorem Ipsum</h5>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s.
            </p>
          </div>
      </div>

      <div class="col-md-12">
          <div class="policy-wrapper">
            <h5>Lorem Ipsum</h5>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s.
            </p>
          </div>
      </div> -->
    </div>
  </div>
</section>
