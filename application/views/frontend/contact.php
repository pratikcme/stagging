<!--=================BREADCRUMB SECTION=================  -->
<section class="breadcrumb-menu breadcrumb-contact">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url()?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Contact us</li>
      </ol>
    </nav>
  </div>
</section>

<!--=================CONTACT US SECTION=================  -->
<section class="p-100 bg-cream contact-us">
  <!-- <img src="<?=base_url().'public/frontend/'?>assets/images/spices.png" class="spices"> -->
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-md-12">
        <h1>get in touch</h1>
    
       <form id="form" method="post" action="<?=base_url().'contact'?>">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
              <div class="input-wrapper">
                <span><i class="fas fa-user-circle"></i></span>
                <input type="text" name="fname" placeholder="First Name" value="<?=($this->session->userdata('user_name') != '' ) ? $this->session->userdata('user_name') : '' ?>" <?=($this->session->userdata('user_name') != '' ) ?'readonly':'';?> >
              </div>
              <label for="fname" class="error"><?=form_error('fname')?></label>
            </div>
            <!-- <div class="col-lg-6 col-md-12 col-sm-6">
              <div class="input-wrapper">
                <span><i class="fas fa-user-circle"></i></span>
                <input type="text" name="lname" placeholder="Last Name" value="<?=($this->session->userdata('user_lname') != '' ) ? $this->session->userdata('user_lname') : '' ?>" <?=($this->session->userdata('user_lname') != '' ) ?'readonly':'';?> >
              </div>
              <label for="lname" class="error"><?=form_error('lname')?></label>
            </div> -->
            <div class="col-md-12">
              <div class="input-wrapper">
                <span><i class="fas fa-envelope"></i></span>
                <input type="text" name="email" placeholder="Email" value="<?=($this->session->userdata('user_email') != '' ) ? $this->session->userdata('user_email') : '' ?>" <?=($this->session->userdata('user_email') != '' ) ?'readonly':'';?> >
              </div>
              <label for="email" class="error"><?=form_error('email')?></label>
            </div>
            <div class="col-md-12">
              <div class="input-wrapper">
                <span><i class="fas fa-phone-alt"></i></span>
                <input type="text" name="mobile_no" placeholder="Phone" value="<?=($this->session->userdata('user_phone') != '' ) ? $this->session->userdata('user_phone') : '' ?>" <?=($this->session->userdata('user_phone') != '' ) ?'readonly':'';?> >
              </div>
              <label for="mobile_no" class="error"><?=form_error('mobile_no')?></label>
            </div>
            <div class="col-md-12">
              <div class="input-wrapper message">
                <span><i class="fas fa-paper-plane"></i></span>
                <textarea class=" " name="message" placeholder="Message"></textarea>
              </div>
              <label for="message" class="error"><?=form_error('message')?></label>
            </div>
            <div class="col-md-12">
            <button type="submit" class="btn" name="submit" id="btnSubmit">send</button>
            </div>
          </div>
        </form>
      </div>

      <div class="col-lg-5">
      <div class="contact-address-wrap">
        <div class="row">
          <div class="col-md-12">
            <div class="location loc-1">
            <span><i class="fas fa-map-marker-alt"></i></span>
            <div class="d-flex flex-column ml-3">
              <h6>location</h6>
              <!-- <p>Office-902, Parshva Tower,
              Nr. Pakvan Dining Hall, Sarkhej - Gandhinagar Highway,
              Bodakdev, Ahmedabad, Gujarat-380058, INDIA.</p> -->
              <!-- <p><?=$contact_us[0]->location?></p> -->
              <p><?=$appLinks[0]->contact_us_address?></p>
            </div>
          </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-6">
            <div class="location loc-1">
            <span><i class="fas fa-envelope"></i></span>
            <div class="d-flex flex-column ml-3">
            <h6>email</h6>
            <!-- <p>support@grocermart.com</p>
             <p>info@grocermart.com</p> -->
             <!-- <?=$contact_us[0]->email?> -->
             <p> <?=$appLinks[0]->contact_email?></p>
           </div>
          </div>
          </div>

          <div class="col-lg-12 col-md-12 col-sm-6">
            <div class="location">
            <span><i class="fas fa-phone-square-alt"></i></span>
            <div class="d-flex flex-column ml-3">
            <h6>Phone</h6>
            <!-- <?=$contact_us[0]->phone_no?> -->
            <p> <?=$appLinks[0]->contact_number?></p>
            <!-- <p>+91 98989 0000</p>
             <p>079 2222 0000</p> -->
           </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  
      </div>
  </div>
</section>
