<?php
    ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	<title>Oregano | responsive bootstrap3 html5 template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	
	<link rel="shortcut icon" href="images/favicon.ico">
    
	<link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/prettyPhoto.css" rel="stylesheet" type="text/css" />
	<link href="css/flexslider.css" rel="stylesheet" type="text/css" />
	<link href="css/animate.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link href="css/colors/" rel="stylesheet" type="text/css" id="colors" />
    
	<!-- Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Lily+Script+One' rel='stylesheet' type='text/css'>
    
	<!-- Scripts -->
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--[if IE]><html class="ie" lang="en"> <![endif]-->
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<script src="js/jquery.prettyPhoto.js" type="text/javascript"></script>
	<script src="js/jquery-ui.min.js" type="text/javascript"></script>
	<script src="js/jquery.twitter.js" type="text/javascript"></script>
	<script src="js/superfish.min.js" type="text/javascript"></script>
	<script src="js/jquery.flexslider-min.js" type="text/javascript"></script>
	<script src="js/animate.js" type="text/javascript"></script>
    <script src="js/handlebars-v3.0.3.js" type="text/javascript"></script>
	<script src="js/myscript.js" type="text/javascript"></script>
	
</head>
<body>

<!-- Preloader -->
<div id="preloader"><div id="status"></div></div>
<!-- //Preloader -->

	<div id="page">
		<!-- Container -->
		<div class="container page_block">
			<div class="wrapper">
				<header class="navbar-wrapper clearfix">
					
					<!-- LOGO -->
					<div class="logo"><a href="index.php" alt=""></a></div>
					<!-- LOGO -->
					
					<!-- Menu -->
					<div class="menu_block clearfix">
						
						<!-- Responsive Button Menu -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="glyphicon glyphicon-align-justify"></span>
							</button>
						</div><!-- //Responsive Button Menu -->
						
						<div class="navbar-collapse collapse">
							<ul class="nav navbar-nav">
								<li class="first active"><a href="index.php" title="">Home</a></li>
								<li class="sub-menu"><a href="javascript:void(0);" title="">Features</a>
									<!-- Mega Menu -->
									<ul class="mega_menu left">
										<h4>Two columns and paragraph</h4>
										<li class="col">
											<h5>Page Layouts</h5>
											<ol>
												<li><a href="typography.html"><span>-</span>Typography</a></li>
												<li><a href="shortcodes.html"><span>-</span>Shortcodes</a></li>
												<li><a href="full-width.html"><span>-</span>Full Width</a></li>
											</ol>
										</li>
										<li class="col">
											<h5>Other Pages</h5>
											<ol>
												<li><a href="404.html"><span>-</span>404 Page</a></li>
												<li><a href="shop.html"><span>-</span>Shop</a></li>
												<li><a href="product-page.html"><span>-</span>Product Page</a></li>
											</ol>
										</li>
										<li class="col">
											<h5>Paragraph</h5>
											<p>This <span class="color_text">Mega Menu</span> can handle everything. Lists, paragraphs, forms...</p>
										</li>
										<div class="clear"></div>
									</ul><!-- //Mega Menu -->
								</li>
								<li class="sub-menu mid_menu"><a href="javascript:void(0);" title="">Pages</a>
									<ul>
										<li><a href="about.html"><span>-</span>About</a></li>
										<li><a href="shop.html"><span>-</span>Shop</a></li>
										<li><a href="product-page.html"><span>-</span>Product Page</a></li>
										<li><a href="full-width.html"><span>-</span>Full Width</a></li>
										<li><a href="404.html"><span>-</span>404 Page</a></li>
									</ul>
								</li>
								<li class="sub-menu"><a href="javascript:void(0);" title="">Portfolio</a>
									<ul>
										<li><a href="portfolio1.html"><span>-</span>1 Column</a></li>
										<li><a href="portfolio2.html"><span>-</span>2 Column</a></li>
										<li><a href="portfolio3.html"><span>-</span>3 Column</a></li>
										<li><a href="portfolio4.html"><span>-</span>4 Column</a></li>
										<li><a href="portfolio-post.html"><span>-</span>Portfolio Post</a></li>
									</ul>
								</li>
								<li class="sub-menu"><a href="javascript:void(0);" title="">Blog</a>
									<ul>
										<li><a href="blog.html"><span>-</span>Blog with sidebar</a></li>
										<li><a href="blog-post.html"><span>-</span>Blog Post</a></li>
									</ul>
								</li>
								<li class="last"><a href="contacts.html" title="">Contacts</a></li>
							</ul>
						</div>
					</div><!-- //Menu -->
				</header>
				
				<!-- Slider -->
				<div class="slider_block full_width">
					<div class="flexslider top_slider">
						<ul class="slides">
							<li class="slide1">
								<img src="./images/slider/slide1.jpg" />
								<div class="flex_caption1 FromLeft"></div>
								<div class="flex_caption2 FromLeft captionDelay3"></div>
								<div class="flex_caption3 FadeIn captionDelay8">The best <span class="color_text">soya beancurd</span> in Saigon</div>
							</li>
							<li class="slide2">
								<img src="./images/slider/slide2.jpg" />
								<div class="flex_caption1 center">
									<span class="left_ribbon"></span>
									<p class="color_bg">High quality ingredients</p>
									<span class="right_ribbon"></span>
								</div>
							</li>
						</ul>
					</div>
				</div><!-- //Slider -->
				
				<!-- Projects -->
				<section class="projects_block" data-animated="fadeIn">
					<h2>Featured Products</h2>
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-6 margbot30">
							<div class="project_item">
								<div class="hover_img">
									<img src="./images/original.jpg" alt="" />
									<a class="zoom" href="./images/original.jpg" rel="prettyPhoto[portfolio1]"></a>
								</div>
								<div class="project_descr center">
									<a href="portfolio-post.html" alt="">Original</a>
									Original beancurd
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 margbot30">
							<div class="project_item">
								<div class="hover_img">
									<img src="./images/almond.jpg" alt="" />
									<a class="zoom" href="./images/almond.jpg" rel="prettyPhoto[portfolio1]"></a>
								</div>
								<div class="project_descr center">
									<a href="portfolio-post.html" alt="">Almond</a>
									Almond beancurd
								</div>
							</div>
						</div>
					</div>
				</section><!-- //Projects -->
				
				<!-- Order -->
				<section class="full_width inform_block padbot40 bg-success">
					<div class="progress" style="margin:0;">
						<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;" id="progress-bar">
							<span>0% Complete</span>
						</div>
					</div>
					<form method="post" action="php/reservation.php" name="reservationform" id="reservation-form" class="form-horizontal">
`                    <div id="order" class="col-md-6">
                        <h3 id="order_header">Order</h3>
                        <hr style="border-top: 3px solid #eee;margin:5px 0;">
                        <div class="form-group" style="margin-bottom: 0">
                            <div class="col-md-6" style="height:30px">
                                <p>
                                    Beancurd charge
                                </p>
                            </div>
                            <div class="col-md-6" style="height:30px">
                                <p id="beancurd_cost" style="text-align:right">
                                    0
                                </p>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0">
                            <div class="col-md-6" style="height:30px">
                                <p>
                                    Delivery fee
                                </p>
                            </div>
                            <div class="col-md-6" style="height:30px">
                                <p id="delivery_cost" style="text-align:right">
                                    0
                                </p>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0">
                            <div class="col-md-6" style="height:30px">
                                <p>
                                    Discount
                                </p>
                            </div>
                            <div class="col-md-6" style="height:30px">
                                <p id="discount_cost" style="text-align:right">
                                    0
                                </p>
                            </div>
                        </div>
                        <hr style="border-top: 3px solid #eee;margin:5px 0;">
                        <div class="form-group">
                            <div class="col-md-6" style="height:30px">
                                <p>
                                    Total
                                </p>
                            </div>
                            <div class="col-md-6" style="height:30px">
                                <p id="total_cost" style="text-align:right">
                                    0
                                </p>
                            </div>
                        </div>
                    </div>
                    <div id="detail" class="col-md-6" style="margin-top:-20px;">
                        <h3>Contact Details</h3>
                        <div class="form-group has-success">
                            <div class="col-xs-8">
                                <input name="name" type="text" id="name" class="form-control" value="" placeholder="Name" required>
                            </div>
                            <div class="col-xs-4">
                                <select id="restime" class="form-control">
                                    <option value="05:00">5:00 am</option>
                                    <option value="05:30">5:30 am</option>
                                    <option value="06:00">6:00 am</option>
                                    <option value="06:30">6:30 am</option>
                                    <option selected="selected" value="07:00">7:00 am</option>
                                    <option value="07:30">7:30 am</option>
                                    <option value="08:00">8:00 am</option>
                                    <option value="08:30">8:30 am</option>
                                    <option value="09:00">9:00 am</option>
                                    <option value="09:30">9:30 am</option>
                                    <option value="10:00">10:00 am</option>
                                    <option value="10:30">10:30 am</option>
                                    <option value="11:00">11:00 am</option>
                                    <option value="11:30">11:30 am</option>
                                    <option value="12:00">12:00 pm</option>
                                    <option value="12:30">12:30 pm</option>
                                    <option value="13:00">1:00 pm</option>
                                    <option value="13:30">1:30 pm</option>
                                    <option value="14:00">2:00 pm</option>
                                    <option value="14:30">2:30 pm</option>
                                    <option value="15:00">3:00 pm</option>
                                    <option value="15:30">3:30 pm</option>
                                    <option value="16:00">4:00 pm</option>
                                    <option value="16:30">4:30 pm</option>
                                    <option value="17:00">5:00 pm</option>
                                    <option value="17:30">5:30 pm</option>
                                    <option value="18:00">6:00 pm</option>
                                    <option value="18:30">6:30 pm</option>
                                    <option value="19:00">7:00 pm</option>
                                    <option value="19:30">7:30 pm</option>
                                    <option value="20:00">8:00 pm</option>
                                    <option value="20:30">8:30 pm</option>
                                    <option value="21:00">9:00 pm</option>
                                    <option value="21:30">9:30 pm</option>
                                    <option value="22:00">10:00 pm</option>
                                    <option value="22:30">10:30 pm</option>
                                    <option value="23:00">11:00 pm</option>
                                    <option value="23:30">11:30 pm</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group has-success">
                            <div class="col-xs-8">
                                <input name="email" type="email" id="email" class="form-control" value="" placeholder="Email" required>
                            </div>
                            <div class="col-xs-4">
                                <input name="phone" type="tel" id="phone" class="form-control" value="" placeholder="Phone" required>
                            </div>
                        </div>
                        <div class="form-group has-success">
                            <div class="col-xs-12">
                                <input name="address" type="text" id="address" class="form-control" placeholder="Address" required>
                            </div>
                        </div>
                        <div class="form-group has-success">
                            <div class="col-xs-12">
                                <textarea name="comments"  id="comments" class="form-control" placeholder="Message" rows="4"></textarea>
                            </div>
                        </div>
                        <button id="submit-res" data-toggle="modal" data-target="#myModal" style="float:right;margin-left:20px;margin-bottom:3px;" class="btn btn-success btn-lg disabled" disabled="true">Place order</button>
                    </div>
					</form>
                    <div class="clearfix"></div>
				</section><!-- Order -->
				
				<!-- Services -->
				<section class="full_width services_block padbot40">
					<div class="row relative_block" data-animated="fadeIn">
						<div class="col-lg-3 col-md-3 col-sm-6 margbot30">
							<a class="service_item center" href="javascript:void(0);">
								<div class="service_item_content">
									<span class="glyphicon glyphicon-leaf" style="
                                        color: white;font-size: 80px;
                                    "></span>
									<p>Good For Health</p>
								</div>
							</a>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 margbot30">
							<a class="service_item center" href="javascript:void(0);">
								<div class="service_item_content">
                                    <span class="glyphicon glyphicon-check" style="
                                        color: white;font-size: 80px;
                                    "></span>
									<p>Best ingredients</p>
								</div>
							</a>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 margbot30">
							<a class="service_item center" href="javascript:void(0);">
								<div class="service_item_content">
                                    <span class="glyphicon glyphicon-cutlery" style="
                                        color: white;font-size: 80px;
                                    "></span>
									<p>Cool dessert</p>
								</div>
							</a>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 margbot30">
							<a class="service_item center" href="javascript:void(0);">
								<div class="service_item_content">
									<span class="glyphicon glyphicon-thumbs-up" style="
                                        color: white;font-size: 80px;
                                    "></span>
									<p>Favored by many</p>
								</div>
							</a>
						</div>
					</div>
					<div class="overlay_white"></div>
				</section><!-- Services -->
				
				<!-- INFORM BLOCK -->
				<section class="inform_block padbot40">
					<div class="row" data-animated="fadeIn">
						<div class="col-lg-7 col-md-7 margbot30 video_block">
							<h2>Video</h2>
							<!-- Video -->
							<iframe src="http://player.vimeo.com/video/29298709?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen ></iframe>
							<!-- //Video -->
						</div>
						<div class="col-lg-5 col-md-5 margbot30 testimonials_block">
							<h2>What Client’s Say</h2>
							<div class="testim_item clearfix">
								<img class="pull-left testim_avatar" src="images/avatar1.jpg" width="55" height="55" alt="" />
								<div class="testim_content">“Duis fringilla nibh at aliquam dignim. Nulla erat nulla, dignissim et volutpat sit amet, placerat placerat tortor. Integer felis orci, ornare non congue ut, iaculis diam. ”</div>
								<div class="testim_author right"><span class="color_text">Jane Doe,</span> Lorem Ipsum</div>
							</div>
							<div class="testim_item clearfix">
								<img class="pull-left testim_avatar" src="images/avatar2.jpg" width="55" height="55" alt="" />
								<div class="testim_content">“Duis fringilla nibh at aliquam dignim. Nulla erat nulla, dignissim et volutpat sit amet, placerat placerat tortor. Integer felis orci, ornare non congue ut, iaculis diam. ”</div>
								<div class="testim_author right"><span class="color_text">Tom Doe,</span> Lorem Ipsum</div>
							</div>
							<div class="testim_item clearfix">
								<img class="pull-left testim_avatar" src="images/avatar3.jpg" width="55" height="55" alt="" />
								<div class="testim_content">“Duis fringilla nibh at aliquam dignissim. Nulla erat nulla, dignissim et volutpat sit amet, placerat placerat tortor. Integer felis orci, ornare non congue ut, iaculis non diam. in elit id iaculis. Nulla tristique mauris sem, id iaculis turpis semper ut. Vivamus at ultrices dolor. ”</div>
								<div class="testim_author right"><span class="color_text">Kate Doe,</span> Lorem Ipsum</div>
							</div>
						</div>
					</div>
				</section><!-- INFORM BLOCK -->

				<!-- Footer -->
				<footer class="full_width footer_block">
					<div class="row" data-animated="fadeIn">
						<div class="col-lg-4 col-sm-4 padbot20">
							<h2>Contact Info</h2>
							<p>Duis fringilla nibh at aliquam dignissim. Nulla erat nulla, dignissim et volutpat sit amet, placerat placerat tortor. Integer felis orci, ornare non congue ut, iaculis non diam. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Mauris molestie in elit id iaculis. Nulla tristique mauris sem, id iaculis</p>
							<ul class="contact_info">
								<li>1 Iron Bridge House 1Bridge Approach London NW1</li>
								<li><span>Email:</span><a href="mailto:useful@sitename.com" alt=""> useful@sitename.com</a></li>
								<li><span>Phone:</span> +1 959 603 6035</li>
							</ul>
						</div>
						<div class="col-lg-4 col-sm-4">
							<h2>News & Events</h2>
							<div class="latest_news_item clearfix">
								<a class="pull-left recent_post" href="blog-post.html" alt=""><img src="images/blog/1.jpg" alt="" /></a>
								<div class="news_content">
									<a class="recent_post_title" href="blog-post.html" alt="">Sed a condimentum eros.</a>
									<ul class="recent_post_inf">
										<li>20/08/13</li>
									</ul>
									<div class="recent_post_txt">Duis fringilla nibh at aliquam dignissim. Nulla erat nulla, dignissim et volutpat</div>
								</div>
							</div>
							<div class="latest_news_item clearfix">
								<a class="pull-left recent_post" href="blog-post.html" alt=""><img src="images/blog/2.jpg" alt="" /></a>
								<div class="news_content">
									<a class="recent_post_title" href="blog-post.html" alt="">Sed a condimentum eros.</a>
									<ul class="recent_post_inf">
										<li>20/08/13</li>
									</ul>
									<div class="recent_post_txt">Duis fringilla nibh at aliquam dignissim. Nulla erat nulla, dignissim et volutpat</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-sm-4">
							<h2>Flickr</h2>
							<!-- Flockr -->
							<div class="flickrs">
								<div class="FlickrImages clearfix">
									<ul></ul>
								</div>
							</div><!-- Flockr -->
						</div>
					</div>
				</footer><!-- //Footer -->
				
				<!-- Copyright -->
				<div class="full_width copyright clearfix">
					<div class="pull-left"><a class="copyright_logo" href="javascript:void(0);">Oregano</a> <span> &copy; Copyright 2020</span></div>
					<!-- Footer Socials -->
					<ul class="pull-right socials">
						<li><a class="soc1" href="javascript:void(0);" alt=""></a></li>
						<li><a class="soc2" href="javascript:void(0);" alt=""></a></li>
						<li><a class="soc3" href="javascript:void(0);" alt=""></a></li>
						<li><a class="soc4" href="javascript:void(0);" alt=""></a></li>
						<li><a class="soc5" href="javascript:void(0);" alt=""></a></li>
						<li><a class="soc6" href="javascript:void(0);" alt=""></a></li>
					</ul><!-- //Footer Socials -->
				</div>
				<!-- //Copyright -->
			
			</div>
		</div><!-- //Container -->
	</div>
<!-- Modal -->
<div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Order Confirmation</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="order_summary" class="row">
                        <div class="col-sm-12">The order of</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">With total cost of</div>
                    </div>
                    <div class="row">
                        <div id="cost_summary" class="col-sm-4 col-sm-offset-8">50,000</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">Will be delivered to customer</div>
                    </div>
                    <div class="row right">
                        <div class="col-sm-3 col-sm-offset-2">Name</div>
                        <div id="name_summary" class="col-sm-7">Tran Doan Khanh Vu</div>
                    </div>
                    <div class="row right">
                        <div class="col-sm-3 col-sm-offset-2">Phone</div>
                        <div id="phone_summary" class="col-sm-7">93905003</div>
                    </div>
                    <div class="row right">
                        <div class="col-sm-3 col-sm-offset-2">Address</div>
                        <div id="address_summary" class="col-sm-7"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script id="product-template" type="text/x-handlebars-template">
    <div class="form-group has-success" style="margin-bottom:5px">
        <div class="col-md-3">
            <img class="img-thumbnail" src="./images/{{image}}">
        </div>
        <div class="col-md-5">
            <p>
                {{name}}
            </p>
        </div>
        <div class="col-md-2">
            <p>
                {{price}}
            </p>
        </div>
        <div class="col-md-2">
            <select id="selection_{{id}}" class="form-control selection" style="padding:0" cost="{{price}}">
                <option selected="selected" value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
        </div>
    </div>
</script>
<script id="product-summary-template" type="text/x-handlebars-template">
    <div class="row right" id="selection_{{id}}_summary">
        <div class="col-sm-2 col-sm-offset-2 quantity"></div>
        <div class="col-sm-8">{{name}}</div>
    </div>
</script>
</body>
</html>