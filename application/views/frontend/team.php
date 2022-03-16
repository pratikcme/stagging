
<!-- Page Header Section Start Here -->
        <section class="page-header bg_img padding-tb">
            <div class="overlay"></div>
            <div class="container">
                <div class="page-header-content-area">
                    <h4 class="ph-title">Fish Mart Team</h4>
                    <ul class="lab-ul">
                        <li><a href="<?=$home_url?>">Home</a></li>
                        <li><a class="active">Team member</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- Page Header Section Ending Here -->

		<!-- team section start here -->
		<section class="team-section padding-tb bg-ash team01">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="section-wrapper">
							<div class="row justify-content-center">
								<?php foreach ($team as $key => $value) { ?>
							
								<div class="col-xl-3 col-lg-4 col-sm-6 col-12">
									<div class="card p-2 mb-4 text-center border-none wow bounceInDown" data-wow-duration="2s" data-wow-delay="0s">
										<img src="<?=base_url()?>public/uploads/team/<?=$value->image?>" class="card-img-top" alt="product">
										<div class="card-body">
											<a href="#"><h6 class="card-title mb-0"><?=$value->name?></h6></a>
											<p class="card-text mb-2"><?=$value->designation?></p>
											<div class="social-share">
												<a href="<?=$value->facebook?>" class="m-1 facebook"><i class="icofont-facebook"></i></a>
												<a href="<?=$value->twitter?>" class="m-1 twitter"><i class="icofont-twitter"></i></a>
												<a href="<?=$value->instagram?>" class="m-1 instagram"><i class="icofont-instagram"></i></a>
												<a href="<?=$value->vemeo?>" class="m-1 vimeo"><i class="icofont-vimeo"></i></a>
												<a href="<?=$value->linkedin?>" class="m-1 linkedin"><i class="icofont-linkedin"></i></a>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
<!-- 								<div class="col-xl-3 col-lg-4 col-sm-6 col-12">
									<div class="card p-2 mb-4 text-center border-none wow bounceInUp" data-wow-duration="2s" data-wow-delay="0s">
										<img src="<?=base_url()?>public/frontend/assets/images/team/02.jpg" class="card-img-top" alt="product">
										<div class="card-body">
											<a href="#"><h6 class="card-title mb-0">Sahjahan Sagor</h6></a>
											<p class="card-text mb-2">Founder & Ceo</p>
											<div class="social-share">
												<a href="#" class="m-1 twitter"><i class="icofont-twitter"></i></a>
												<a href="#" class="m-1 behance"><i class="icofont-behance"></i></a>
												<a href="#" class="m-1 instagram"><i class="icofont-instagram"></i></a>
												<a href="#" class="m-1 vimeo"><i class="icofont-vimeo"></i></a>
												<a href="#" class="m-1 linkedin"><i class="icofont-linkedin"></i></a>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-lg-4 col-sm-6 col-12">
									<div class="card p-2 mb-4 text-center border-none wow bounceInDown" data-wow-duration="2s" data-wow-delay="0s">
										<img src="<?=base_url()?>public/frontend/assets/images/team/03.jpg" class="card-img-top" alt="product">
										<div class="card-body">
											<a href="#"><h6 class="card-title mb-0">Lubna Smith</h6></a>
											<p class="card-text mb-2">Marketer</p>
											<div class="social-share">
												<a href="#" class="m-1 twitter"><i class="icofont-twitter"></i></a>
												<a href="#" class="m-1 behance"><i class="icofont-behance"></i></a>
												<a href="#" class="m-1 instagram"><i class="icofont-instagram"></i></a>
												<a href="#" class="m-1 vimeo"><i class="icofont-vimeo"></i></a>
												<a href="#" class="m-1 linkedin"><i class="icofont-linkedin"></i></a>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-lg-4 col-sm-6 col-12">
									<div class="card p-2 mb-4 text-center border-none wow bounceInUp" data-wow-duration="2s" data-wow-delay="0s">
										<img src="<?=base_url()?>public/frontend/assets/images/team/04.jpg" class="card-img-top" alt="product">
										<div class="card-body">
											<a href="#"><h6 class="card-title mb-0">Jeson Roy</h6></a>
											<p class="card-text mb-2">Manager</p>
											<div class="social-share">
												<a href="#" class="m-1 twitter"><i class="icofont-twitter"></i></a>
												<a href="#" class="m-1 behance"><i class="icofont-behance"></i></a>
												<a href="#" class="m-1 instagram"><i class="icofont-instagram"></i></a>
												<a href="#" class="m-1 vimeo"><i class="icofont-vimeo"></i></a>
												<a href="#" class="m-1 linkedin"><i class="icofont-linkedin"></i></a>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-lg-4 col-sm-6 col-12">
									<div class="card p-2 mb-4 text-center border-none wow bounceInDown" data-wow-duration="2s" data-wow-delay="0s">
										<img src="<?=base_url()?>public/frontend/assets/images/team/01.jpg" class="card-img-top" alt="product">
										<div class="card-body">
											<a href="#"><h6 class="card-title mb-0">anuka Kabir</h6></a>
											<p class="card-text mb-2">Marketer</p>
											<div class="social-share">
												<a href="#" class="m-1 twitter"><i class="icofont-twitter"></i></a>
												<a href="#" class="m-1 behance"><i class="icofont-behance"></i></a>
												<a href="#" class="m-1 instagram"><i class="icofont-instagram"></i></a>
												<a href="#" class="m-1 vimeo"><i class="icofont-vimeo"></i></a>
												<a href="#" class="m-1 linkedin"><i class="icofont-linkedin"></i></a>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-lg-4 col-sm-6 col-12">
									<div class="card p-2 mb-4 text-center border-none wow bounceInUp" data-wow-duration="2s" data-wow-delay="0s">
										<img src="<?=base_url()?>public/frontend/assets/images/team/02.jpg" class="card-img-top" alt="product">
										<div class="card-body">
											<a href="#"><h6 class="card-title mb-0">Jesan Hanri</h6></a>
											<p class="card-text mb-2">Founder & Ceo</p>
											<div class="social-share">
												<a href="#" class="m-1 twitter"><i class="icofont-twitter"></i></a>
												<a href="#" class="m-1 behance"><i class="icofont-behance"></i></a>
												<a href="#" class="m-1 instagram"><i class="icofont-instagram"></i></a>
												<a href="#" class="m-1 vimeo"><i class="icofont-vimeo"></i></a>
												<a href="#" class="m-1 linkedin"><i class="icofont-linkedin"></i></a>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-lg-4 col-sm-6 col-12">
									<div class="card p-2 mb-4 text-center border-none wow bounceInDown" data-wow-duration="2s" data-wow-delay="0s">
										<img src="<?=base_url()?>public/frontend/assets/images/team/03.jpg" class="card-img-top" alt="product">
										<div class="card-body">
											<a href="#"><h6 class="card-title mb-0">Subrina Kabir</h6></a>
											<p class="card-text mb-2">Marketer</p>
											<div class="social-share">
												<a href="#" class="m-1 twitter"><i class="icofont-twitter"></i></a>
												<a href="#" class="m-1 behance"><i class="icofont-behance"></i></a>
												<a href="#" class="m-1 instagram"><i class="icofont-instagram"></i></a>
												<a href="#" class="m-1 vimeo"><i class="icofont-vimeo"></i></a>
												<a href="#" class="m-1 linkedin"><i class="icofont-linkedin"></i></a>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-3 col-lg-4 col-sm-6 col-12">
									<div class="card p-2 mb-4 text-center border-none wow bounceInUp" data-wow-duration="2s" data-wow-delay="0s">
										<img src="<?=base_url()?>public/frontend/assets/images/team/04.jpg" class="card-img-top" alt="product">
										<div class="card-body">
											<a href="#"><h6 class="card-title mb-0">Jeson Joy</h6></a>
											<p class="card-text mb-2">Manager</p>
											<div class="social-share">
												<a href="#" class="m-1 twitter"><i class="icofont-twitter"></i></a>
												<a href="#" class="m-1 behance"><i class="icofont-behance"></i></a>
												<a href="#" class="m-1 instagram"><i class="icofont-instagram"></i></a>
												<a href="#" class="m-1 vimeo"><i class="icofont-vimeo"></i></a>
												<a href="#" class="m-1 linkedin"><i class="icofont-linkedin"></i></a>
											</div>
										</div>
									</div>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- team section ending here -->