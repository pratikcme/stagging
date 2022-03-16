<section class="p-100 bg-cream">
  <div class="container">
  <?php if($status == 1){ ?>
  <!-- The Modal -->
    <div class="modal" id="order_success">
      <div class="modal-dialog">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body text-center">
              <div>
                  <h3>thanks for shopping</h3>
              </div>
              <div class="my-3">
                  <i class="fa fa-shopping-bag" aria-hidden="true"></i>
              </div>
              <!-- <div class="my-3">
                  <img src="assets/images/bag.png" class="bag" alt="">
              </div> -->
              <div>
                  <h5>order placed successfully</h5>
                  <p id="orderId">Your Order No : <?=$order_number?></p>
              </div>
              <div>
                  <a href="<?=base_url().'home'?>" class="shopping_btn">continue shopping</a>
              </div>
          </div>
          
        </div>
      </div>
    </div>
  <?php } ?>
  <?php if($status == '0'){ ?>
    <!-- The Modal -->
    <div class="modal" id="payment_fail">
      <div class="modal-dialog">
        <div class="modal-content">
        
          <!-- Modal body -->
          <div class="modal-body text-center">
              <div>
                  <h3>payment failed</h3>
              </div>
              <div class="my-3">
                  <i class="fas fa-ban"></i>
              </div>
              <div>
                  <p><?=$message?></p>
              </div>
              <div>
                  <a href="<?=base_url().'home'?>" class="retry_btn">continue shopping</a>
              </div>
          </div>
          
        </div>
      </div>
    </div>    
   <?php } ?>
    
    </div>
</section>

 <input type="hidden" id="base_url" value="<?=base_url()?>">

 