<div class="container">
    <div class="row">
      <div class="col-md-6">
        <ul class="toll-free-num">
          <li><span><i class="fas fa-phone-alt"></i></span><?=(!empty($appLinks) && $appLinks[0]->contact_number != '' ) ? @$appLinks[0]->contact_number : "1800-121-000" ?></li>
          <li><span><i class="fas fa-envelope"></i></span><?=(!empty($appLinks) && @$appLinks[0]->contact_email != '' ) ? @$appLinks[0]->contact_email : "info@grocermart.com" ?></li>
        </ul>
      </div>
      <div class="col-md-6">
        <ul class="social-icon">
          <li style="display: <?=(@$appLinks[0]->facebook_link == '') ? 'none' : '' ?>"><a href="<?=(@$appLinks[0]->facebook_link != '') ? @$appLinks[0]->facebook_link : 'javascript:' ?>"><i class="fab fa-facebook-f"></i></a></li>
          <li style="display: <?=(@$appLinks[0]->twitter_link == '') ? 'none' : '' ?>"><a href="<?=(@$appLinks[0]->twitter_link != '') ? @$appLinks[0]->twitter_link : 'javascript:' ?>"><i class="fab fa-twitter"></i></a></li>
          <!-- <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li> -->
          <li style="display: <?=(@$appLinks[0]->google_plus_link == '') ? 'none' : '' ?>"><a href="<?=(@$appLinks[0]->google_plus_link != '') ? @$appLinks[0]->google_plus_link : 'javascript:' ?>"><i class="fab fa-google-plus-g"></i></a></li>
          <li style="display: <?=(@$appLinks[0]->instagram_link == '') ? 'none' : '' ?>"><a href="<?=(@$appLinks[0]->instagram_link != '') ? @$appLinks[0]->instagram_link : 'javascript:' ?>"><i class="fab fa-instagram"></i></a></li>
        </ul>
      </div>
    </div>
  </div>