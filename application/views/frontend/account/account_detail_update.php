  <style type="text/css">
    .border-r-5 {
      border-radius: 5px !important;
      margin: 0px 5px;
    }
  </style>      
        <!-- Page Header Section Start Here -->
        <section class="page-header bg_img padding-tb">
            <div class="overlay"></div>
            <div class="container">
                <div class="page-header-content-area">
                    <h4 class="ph-title">Account Details</h4>
                    <ul class="lab-ul">
                        <li><a href="<?=$home_url?>">Home</a></li>
                        <li><a class="active">Account Details</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- Page Header Section Ending Here -->
        
        <!-- Faq Page Section Start Here -->
        <div class="faq-section padding-tb bg-ash">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="order-detail-box">

                <div class="order-summary addnewaddress-area" href="#">
                    <form  id ="accountDetail" method="post" action="<?=base_url().'users_account/users/accountdetails'?>">
                       <div class="form-group">
                          <label>full name</label>
                          <input type="text" class="form-control name" name="fname" id="" placeholder="Enter name" value="<?=$user[0]->fname?>" >
                        </div>
                        <div class="form-group">
                          <label>email id</label>
                          <input type="email" class="form-control" name="email" id="" placeholder="Your Email" value="<?=$user[0]->email?>" readonly>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">mobile number</label>
                          <input type="text" class="form-control mob_no" name="phone" id="" placeholder="enter mobile number" value="<?=$user[0]->phone?>">
                        </div>
                        <div class="address-btn">
                           <button type="submit"  id="btnSubmit" class="lab-btn border-r-5 hvr-shutter-in-horizontal"><span>Update</span></button>
                        <!--    <a href="<?=base_url().'frontend/home'?>" class="btn btn-primary">Cancel</a> -->
                        <a href="<?=base_url().'frontend/home'?>" class="lab-btn border-r-5 hvr-shutter-in-horizontal"><span>Cancel</span></a>
                        </div>
                    </form>
                 </div>
               </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Faq Page Section Ending Here -->