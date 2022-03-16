        
        <!-- Page Header Section Start Here -->
        <section class="page-header bg_img padding-tb">
            <div class="overlay"></div>
            <div class="container">
                <div class="page-header-content-area">
                    <h4 class="ph-title">Fish Mart Faq</h4>
                    <ul class="lab-ul">
                        <li><a href="<?=$home_url?>">Home</a></li>
                        <li><a class="active">Faq</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- Page Header Section Ending Here -->
        
        <!-- Faq Page Section Start Here -->
        <div class="faq-section padding-tb bg-ash">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-12">
                        <div class="faq-tab">
                            <h5>Quick Navigation</h5>
                            <ul class="agri-ul nav" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="active" id="purchas-tab" data-toggle="tab" href="#purchas" role="tab" aria-controls="purchas" aria-selected="true">Customer Support</a>
                                </li>
                                <li class="nav-item">
                                    <a id="returns-tab" data-toggle="tab" href="#returns" role="tab" aria-controls="returns" aria-selected="false">License</a>
                                </li>
                                <li class="nav-item">
                                    <a id="price-tab" data-toggle="tab" href="#price" role="tab" aria-controls="price" aria-selected="false">Pricing & Support</a>
                                </li>
                                <li class="nav-item">
                                    <a id="care-tab" data-toggle="tab" href="#care" role="tab" aria-controls="care" aria-selected="false">Purchasing Online</a>
                                </li>
                                <li class="nav-item">
                                    <a id="return-tab" data-toggle="tab" href="#return" role="tab" aria-controls="return" aria-selected="false">Returns</a>
                                </li>
                                <li class="nav-item">
                                    <a id="Technical-tab" data-toggle="tab" href="#Technical" role="tab" aria-controls="Technical" aria-selected="false">Technical</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-lg-8 col-12">
                        <div class="tab-content faq-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="purchas" role="tabpanel" aria-labelledby="purchas-tab">
                                <h5>Customer Support</h5>
                                <?php 
                                $array = array('collapseOne','collapseTwo','collapseThree','collapsefour','collapseFive','collapseSix');
                                $heading = array('headingOne','headingTwo','headingThree','headingFour','headingFive','headingSix');
                                $i = 0;
                                foreach($faqCustomberSupport as $key => $value) { ?>

                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header" id="<?=$heading[$i]?>">
                                            <button class="<?=($i==0) ? 'faq-item' : 'faq-item collapsed' ?>" data-toggle="collapse" data-target="#<?=$array[$i]?>" aria-expanded="<?=($i==0) ? 'true' : 'false' ?>" aria-controls="<?=$array[$i]?>">
                                                <?=$value->question?>
                                            </button>
                                        </div>

                                        <div id="<?=$array[$i]?>" class="collapse <?=($i==0) ? 'show' : '' ?>" aria-labelledby="<?=$heading[$i]?>" data-parent="#accordion">
                                            <div class="card-body">
                                                <p>
                                                    <?=$value->answer?>
                                                </p> 
                                            </div>
                                        </div>
                                    </div>
                                 <!--    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                                <button class="faq-item collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    Can I cancel or change my order?
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                            <div class="card-body">
                                                <p>Why I say old chap that is spiffing pukka, bamboozled wind up bugger buggered zonked hanky panky a blinding shot the little rotter, bubble and squeak vagabond cheeky bugger at public school pardon you bloke the BBC. Tickety-boo Elizabeth plastered matie.!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h5 class="mb-0">
                                                <button class="faq-item collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    How can I pay for my purchases?
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                            <div class="card-body">
                                                <p>Why I say old chap that is spiffing pukka, bamboozled wind up bugger buggered zonked hanky panky a blinding shot the little rotter, bubble and squeak vagabond cheeky bugger at public school pardon you bloke the BBC. Tickety-boo Elizabeth plastered matie.!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingfour">
                                            <h5 class="mb-0">
                                                <button class="faq-item collapsed" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                                                    How safe is it to order online?
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordion">
                                            <div class="card-body">
                                                Why I say old chap that is spiffing pukka, bamboozled wind up bugger buggered zonked hanky panky a blinding shot the little rotter, bubble and squeak vagabond cheeky bugger at public school pardon you bloke the BBC. Tickety-boo Elizabeth plastered matie.!
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            <?php $i++; }  ?>
                            </div>

                            <div class="tab-pane fade" id="returns" role="tabpanel" aria-labelledby="returns-tab">
                                <h5>License</h5>
                                 <?php 
                                $array1 = array('collapse10','collapse11','collapse12','collapse13','collapse14','collapse15');
                                $heading1 = array('heading10','heading11','heading12','heading13','heading14','heading15');
                                $i = 0; 

                                 foreach($faqLicense as $key => $value) { ?>

                                <div id="accordion3">
                                    <div class="card">
                                        <div class="card-header" id="<?=$heading1[$i]?>">
                                            <button class="<?=($i==0) ? 'faq-item' : 'faq-item collapsed' ?>" data-toggle="collapse" data-target="#<?=$array1[$i]?>" aria-expanded="<?=($i==0) ? 'true' : 'false' ?>" aria-controls="<?=$array1[$i]?>">
                                                 <?=$value->question?>
                                            </button>
                                        </div>

                                        <div id="<?=$array1[$i]?>" class="collapse <?=($i==0) ? 'show' : '' ?>" aria-labelledby="<?=$heading1[$i]?>" data-parent="#accordion3">
                                            <div class="card-body">
                                                <p><?=$value->answer?></p>
                                            </div>
                                        </div>
                                    </div>

                                <!--     <div class="card">
                                        <div class="card-header" id="heading11">
                                            <button class="faq-item collapsed" data-toggle="collapse" data-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                                                Where can I find instructions on how to use my watch?
                                            </button>
                                        </div>
                                        <div id="collapse11" class="collapse" aria-labelledby="heading11" data-parent="#accordion3">
                                            <div class="card-body">
                                                <p>Why I say old chap that is spiffing pukka, bamboozled wind up bugger buggered zonked hanky panky a blinding shot the little rotter, bubble and squeak vagabond cheeky bugger at public school pardon you bloke the BBC. Tickety-boo Elizabeth plastered matie.!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading12">
                                            <button class="faq-item collapsed" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                                                Is there a warranty on my item?
                                            </button>
                                        </div>
                                        <div id="collapse12" class="collapse" aria-labelledby="heading12" data-parent="#accordion3">
                                            <div class="card-body">
                                                <p>Why I say old chap that is spiffing pukka, bamboozled wind up bugger buggered zonked hanky panky a blinding shot the little rotter, bubble and squeak vagabond cheeky bugger at public school pardon you bloke the BBC. Tickety-boo Elizabeth plastered matie.!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading13">
                                            <button class="faq-item collapsed" data-toggle="collapse" data-target="#collapse13" aria-expanded="false" aria-controls="collapse13">
                                                Is there a warranty on my item?
                                            </button>
                                        </div>
                                        <div id="collapse13" class="collapse" aria-labelledby="heading13" data-parent="#accordion3">
                                            <div class="card-body">
                                                <p>Why I say old chap that is spiffing pukka, bamboozled wind up bugger buggered zonked hanky panky a blinding shot the little rotter, bubble and squeak vagabond cheeky bugger at public school pardon you bloke the BBC. Tickety-boo Elizabeth plastered matie.!</p>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                <?php $i++; } ?>
                            </div>

                            <div class="tab-pane fade" id="price" role="tabpanel" aria-labelledby="price-tab">
                                <h5>Pricing & Support</h5>
                                  <?php 
                                $array2 = array('collapse15','collapse16','collapse17','collapse18','collapse19','collapse110');
                                $heading2 = array('heading15','heading16','heading17','heading18','heading19','heading110');
                                $i = 0; 

                                 foreach($faqPricing as $key => $value) { ?>

                                <div id="accordion4">
                                    <div class="card">
                                        <div class="card-header" id="<?=$heading2[$i]?>">
                                            <button class="<?=($i==0) ? 'faq-item' : 'faq-item collapsed' ?>" data-toggle="collapse" data-target="#<?=$array2[$i]?>" aria-expanded="<?=($i==0) ? 'true' : 'false' ?>" aria-controls="<?=$array2[$i]?>">
                                                    <?=$value->question?>
                                            </button>
                                        </div>

                                        <div id="<?=$array2[$i]?>" class="collapse <?php if($i==0){echo 'show' ;}?>" aria-labelledby="<?=$heading2[$i]?>" data-parent="#accordion4">
                                            <div class="card-body">
                                                  <p><?=$value->answer?></p>
                                            </div>
                                        </div>
                                    </div>
                                
                                   <!--  <div class="card">
                                        <div class="card-header" id="heading16">
                                            <button class="faq-item collapsed" data-toggle="collapse" data-target="#collapse16" aria-expanded="false" aria-controls="collapse16">
                                                Where can I find instructions on how to use my watch?
                                            </button>
                                        </div>
                                        <div id="collapse16" class="collapse" aria-labelledby="heading16" data-parent="#accordion4">
                                            <div class="card-body">
                                                <p>Why I say old chap that is spiffing pukka, bamboozled wind up bugger buggered zonked hanky panky a blinding shot the little rotter, bubble and squeak vagabond cheeky bugger at public school pardon you bloke the BBC. Tickety-boo Elizabeth plastered matie.!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading17">
                                            <button class="faq-item collapsed" data-toggle="collapse" data-target="#collapse17" aria-expanded="false" aria-controls="collapse17">
                                                Is there a warranty on my item?
                                            </button>
                                        </div>
                                        <div id="collapse17" class="collapse" aria-labelledby="heading17" data-parent="#accordion4">
                                            <div class="card-body">
                                                <p>Why I say old chap that is spiffing pukka, bamboozled wind up bugger buggered zonked hanky panky a blinding shot the little rotter, bubble and squeak vagabond cheeky bugger at public school pardon you bloke the BBC. Tickety-boo Elizabeth plastered matie.!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading18">
                                            <button class="faq-item collapsed" data-toggle="collapse" data-target="#collapse18" aria-expanded="false" aria-controls="collapse18">
                                                Is there a warranty on my item?
                                            </button>
                                        </div>
                                        <div id="collapse18" class="collapse" aria-labelledby="heading18" data-parent="#accordion4">
                                            <div class="card-body">
                                                <p>Why I say old chap that is spiffing pukka, bamboozled wind up bugger buggered zonked hanky panky a blinding shot the little rotter, bubble and squeak vagabond cheeky bugger at public school pardon you bloke the BBC. Tickety-boo Elizabeth plastered matie.!</p>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                <?php $i++; } ?>
                            </div>

                            <div class="tab-pane fade" id="care" role="tabpanel" aria-labelledby="care-tab">
                                <h5>Purchasing Online</h5>
                                    <?php 
                                $array3 = array('collapse24','collapse25','collapse26','collapse27','collapse28','collapse29');
                                $heading3 = array('heading24','heading25','heading26','heading27','heading28','heading29');
                                $i = 0; 

                                 foreach($faqPurchasing as $key => $value) { ?>


                                <div id="accordion6">
                                    <div class="card">
                                        <div class="card-header" id="<?=$heading3[$i]?>">
                                            <button class="<?=($i==0) ? 'faq-item' : 'faq-item collapsed' ?>" data-toggle="collapse" data-target="#<?=$heading3[$i]?>" aria-expanded="<?=($i==0) ? 'true' : 'false' ?>" aria-controls="<?=$heading3[$i]?>">
                                              <?=$value->question?>
                                            </button>
                                        </div>

                                        <div id="<?=$heading3[$i]?>" class="collapse <?php if($i==0){ echo 'show'; }?>" aria-labelledby="<?=$heading3[$i]?>" data-parent="#accordion6">
                                            <div class="card-body">
                                                 <p><?=$value->answer?></p>
                                            </div>
                                        </div>
                                    </div>
                                  <!--   <div class="card">
                                        <div class="card-header" id="heading25">
                                            <button class="faq-item collapsed" data-toggle="collapse" data-target="#collapse25" aria-expanded="false" aria-controls="collapse25">
                                                Where can I find instructions on how to use my watch?
                                            </button>
                                        </div>
                                        <div id="collapse25" class="collapse" aria-labelledby="heading25" data-parent="#accordion6">
                                            <div class="card-body">
                                                <p>Why I say old chap that is spiffing pukka, bamboozled wind up bugger buggered zonked hanky panky a blinding shot the little rotter, bubble and squeak vagabond cheeky bugger at public school pardon you bloke the BBC. Tickety-boo Elizabeth plastered matie.!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading26">
                                            <button class="faq-item collapsed" data-toggle="collapse" data-target="#collapse26" aria-expanded="false" aria-controls="collapse26">
                                                Is there a warranty on my item?
                                            </button>
                                        </div>
                                        <div id="collapse26" class="collapse" aria-labelledby="heading26" data-parent="#accordion6">
                                            <div class="card-body">
                                                <p>Why I say old chap that is spiffing pukka, bamboozled wind up bugger buggered zonked hanky panky a blinding shot the little rotter, bubble and squeak vagabond cheeky bugger at public school pardon you bloke the BBC. Tickety-boo Elizabeth plastered matie.!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading27">
                                            <button class="faq-item collapsed" data-toggle="collapse" data-target="#collapse27" aria-expanded="false" aria-controls="collapse27">
                                                Is there a warranty on my item?
                                            </button>
                                        </div>
                                        <div id="collapse27" class="collapse" aria-labelledby="heading27" data-parent="#accordion6">
                                            <div class="card-body">
                                                <p>Why I say old chap that is spiffing pukka, bamboozled wind up bugger buggered zonked hanky panky a blinding shot the little rotter, bubble and squeak vagabond cheeky bugger at public school pardon you bloke the BBC. Tickety-boo Elizabeth plastered matie.!</p>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                <?php $i++; } ?>
                            </div>
                            
                            <div class="tab-pane fade" id="return" role="tabpanel" aria-labelledby="return-tab">
                                <h5>Returns</h5>
                            <?php 
                                $array4 = array('collapsesix','collapseseven','collapseeight','collapsenine','collapseten','collapseeleven');
                                $heading4 = array('headingsix','headingseven','headingeight','headingnine','headingten','headingeleven');
                                $i = 0; 

                                 foreach($faqReturn as $key => $value) { ?>

                                <div id="accordion2">
                                    <div class="card">
                                        <div class="card-header" id="<?=$heading4[$i]?>">
                                            <button class="<?=($i==0) ? 'faq-item' : 'faq-item collapsed' ?>" data-toggle="collapse" data-target="#<?=$array4[$i]?>" aria-expanded="<?=($i==0) ? 'true' : 'false' ?>" aria-controls="<?=$array4[$i]?>">
                                              <?=$value->question?>
                                            </button>
                                        </div>
                                        <div id="<?=$array4[$i]?>" class="collapse <?php if($i==0){ echo 'show'; }?>" aria-labelledby="<?=$heading4[$i]?>" data-parent="#accordion2">
                                            <div class="card-body">
                                                  <p><?=$value->answer?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="card">
                                        <div class="card-header" id="headingseven">
                                            <button class="faq-item collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">
                                                Where can I find instructions on how to use my watch?
                                            </button>
                                        </div>
                                        <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion2">
                                            <div class="card-body">
                                                <p>Why I say old chap that is spiffing pukka, bamboozled wind up bugger buggered zonked hanky panky a blinding shot the little rotter, bubble and squeak vagabond cheeky bugger at public school pardon you bloke the BBC. Tickety-boo Elizabeth plastered matie.!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingeight">
                                            <button class="faq-item collapsed" data-toggle="collapse" data-target="#collapseeight" aria-expanded="false" aria-controls="collapseeight">
                                                Is there a warranty on my item?
                                            </button>
                                        </div>
                                        <div id="collapseeight" class="collapse" aria-labelledby="headingeight" data-parent="#accordion2">
                                            <div class="card-body">
                                                <p>Why I say old chap that is spiffing pukka, bamboozled wind up bugger buggered zonked hanky panky a blinding shot the little rotter, bubble and squeak vagabond cheeky bugger at public school pardon you bloke the BBC. Tickety-boo Elizabeth plastered matie.!</p>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                <?php $i++;  } ?>
                            </div>

                            <div class="tab-pane fade" id="Technical" role="tabpanel" aria-labelledby="Technical-tab">
                                <h5>Technical</h5>

                                 <?php 
                                $array5 = array('collapse20','collapse21','collapse22','collapse23','collapse24','collapse25');
                                $heading5 = array('heading20','heading21','heading22','heading23','heading24','heading25');
                                $i = 0; 

                                 foreach($faqTechnical as $key => $value) { ?>

                                <div id="accordion5">
                                    <div class="card">
                                        <div class="card-header" id="<?=$heading5[$i]?>">
                                            <button class="<?=($i==0) ? 'faq-item' : 'faq-item collapsed' ?>" data-toggle="collapse" data-target="#<?=$array5[$i]?>" aria-expanded="<?=($i==0) ? 'true' : 'falseh ' ?>" aria-controls="<?=$array5[$i]?>">
                                                    <?=$value->question?>
                                            </button>
                                        </div>
                                        <div id="<?=$array5[$i]?>" class="collapse <?php if($i==0){ echo 'show'; }?>" aria-labelledby="<?=$heading5[$i]?>" data-parent="#accordion5">
                                            <div class="card-body">
                                                   <p><?=$value->answer?></p>
                                            </div>
                                        </div>
                                    </div>
                                   <!--  <div class="card">
                                        <div class="card-header" id="heading21">
                                            <button class="faq-item collapsed" data-toggle="collapse" data-target="#collapse21" aria-expanded="false" aria-controls="collapse21">
                                                Where can I find instructions on how to use my watch?
                                            </button>
                                        </div>
                                        <div id="collapse21" class="collapse" aria-labelledby="heading21" data-parent="#accordion5">
                                            <div class="card-body">
                                                <p>Why I say old chap that is spiffing pukka, bamboozled wind up bugger buggered zonked hanky panky a blinding shot the little rotter, bubble and squeak vagabond cheeky bugger at public school pardon you bloke the BBC. Tickety-boo Elizabeth plastered matie.!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading22">
                                            <button class="faq-item collapsed" data-toggle="collapse" data-target="#collapse22" aria-expanded="false" aria-controls="collapse22">
                                                Is there a warranty on my item?
                                            </button>
                                        </div>
                                        <div id="collapse22" class="collapse" aria-labelledby="heading22" data-parent="#accordion5">
                                            <div class="card-body">
                                                <p>Why I say old chap that is spiffing pukka, bamboozled wind up bugger buggered zonked hanky panky a blinding shot the little rotter, bubble and squeak vagabond cheeky bugger at public school pardon you bloke the BBC. Tickety-boo Elizabeth plastered matie.!</p>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            <?php $i++; } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Faq Page Section Ending Here -->
