@include('frontend.layouts.header')
        <!--WELCOME SLIDER AREA-->
        <div class="welcome-slider-area white">
            @foreach ($sliders as $item)
                <div class="welcome-single-slide">
                    <div class="slide-bg-one slide-bg-overlay" style="   background: rgba(0, 0, 0, 0) url({{asset($item->image)}}) no-repeat scroll center center / cover;"></div>
                    <div class="welcome-area">
                        <div class="container">
                            <div class="row flex-v-center">
                                <div class="col-md-7 col-lg-6 col-sm-12 col-xs-12">
                                    <div class="welcome-text" >
                                        <h4 style="color:{{$item->small_title_color}}">{{$item->small_title}}</h4>
                                        <h1 style="color:{{$item->big_title_color}}">{{$item->big_title}}</h1>
                                        <p style="color:{{$item->description_color}}"><b><?=$item->description?></b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
            <!--WELCOME SLIDER AREA END-->
        <p style="    background: #0d4b89;
            padding: 1%;
            border: 1px solid #0d4b89;font-size: 16px;"  id="mrid"  class="banct"> <a style="color:white;margin-left: 7%;"> For expert opinion and personalized solutions, get in touch with us on <b style="color:black">1844-466-6469</b></a><b style="float:right;color:white;    margin-right: 8%;">&nbsp;&nbsp;Follow as on &nbsp;&nbsp;&nbsp;<a class="facebook" href="#"><i class="fa fa-facebook" style="color:white"></i></a>&nbsp;&nbsp;&nbsp;<a class="twitter" href="#"><i class="fa fa-twitter"  style="color:white"></i></a>&nbsp;&nbsp;&nbsp;<a class="linkedin" href="#"><i class="fa fa-linkedin"  style="color:white"></i></a> </b></p>
           <p style="    background: #0d4b89;
            padding: 1%;
            border: 1px solid #0d4b89;font-size: 14px;display:none"  id="mrid"  class="banct1"> <b style="color:white;    margin-right: 8%;">Follow as on &nbsp;&nbsp;&nbsp;
            <a class="facebook" href="#"><i class="fa fa-facebook" style="color:white"></i></a>&nbsp;&nbsp;&nbsp;
            <a class="twitter" href="#"><i class="fa fa-twitter"  style="color:white"></i></a>&nbsp;&nbsp;&nbsp;
            <a class="linkedin" href="#"><i class="fa fa-linkedin"  style="color:white"></i></a>&nbsp;&nbsp;&nbsp; </b></p>
          <p style="    background: #0d4b89;
            padding: 1%;
            border: 1px solid #0d4b89;font-size: 14px;display:none"  id="mrid"  class="banct2"><a style="color:white;margin-left: 7%;"> Get in touch with us on <b style="color:black">1844-466-6469</b></a> <b style="color:white;    margin-right: 8%;">Follow as on &nbsp;&nbsp;&nbsp;<a class="facebook" href="#"><i class="fa fa-facebook" style="color:white"></i></a>&nbsp;&nbsp;&nbsp;<a class="twitter" href="#"><i class="fa fa-twitter"  style="color:white"></i></a>&nbsp;&nbsp;&nbsp;<a class="linkedin" href="#"><i class="fa fa-linkedin"  style="color:white"></i></a> </b></p>
             <section class="info-area gray-bg" style="background: #ffff;    padding: 35px 0;">
                <div class="container">
                    <div class="row flex-v-center" >
                    
                     
                        
                        
                          
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                            <div class="intro-content wow fadeInRight" style="visibility: visible; animation-name: fadeInRight;">
                      <div class="area-title wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                                <h2>About  <b style="color:#0066cc">Innogenix</b></h2><img src="img/line3.png">
                            </div> 
           <p style="">
        Innogenix aims to develop, manufacture and commercialize niche, specialty and hard to manufacture Generic Drugs. Located on Long Island, Innogenix is an emerging generic and specialty pharmaceutical company that identifies, develops, manufactures and markets complex and difficult-to-manufacture generic prescription pharmaceutical products.      <br><br>Our goal is to create a portfolio of limited source branded and generic pharmaceutical products that will provide competitively price and affordable medicines of the highest quality and standards to physicians and patients in the United States.  </p>						<a href="our-company.html" class="read-moree">Read More&nbsp;<i style=" font-weight: 900;" class="fa fa-angle-right" id="angl"></i></a><br>
                    </div>
                        </div> <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                            <div class="intro-image wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                                <img src="img/about-innogenix.jpg" alt="" style="width: 100%;" id="abtimg">
                            </div>
                        </div>
                    </div>
                </div>
            </section>	
            <br>
               <!--SERVICE TOP AREA-->
            <section class="service-top-area padding-100-50" id="features" style="    background: #ffffff;">
               
                    <div class="row" style="margin-right: 0px;
            margin-left: 0px;">
                       
                      
                      
                    <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12" style="background:#FFA500; text-align: center">
        <br><i class="fa fa-slideshare" data-animation="fadeInUp" data-delay="100" style="font-size: xxx-large;
            color: white;"></i><h3 style="color:#fff;text-transform: capitalize;text-align:center">Easily Explained</h3>
             <a href="#" class="read-moreorange" style="">Read More&nbsp;<i style=" " class="fa fa-angle-right" id="angl"></i></a><br>
                          <br>  </div>
                     <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12" style="background:#0ebbbf;  text-align: center">
                                   <br><i class="fa fa-child" data-animation="fadeInUp" data-delay="100" style="font-size: xxx-large;
            color: white;"></i><h3 style="color:#fff;text-transform: capitalize;text-align:center">Counselor  </h3>
              <a href="#" class="read-moreblue" style="">Read More&nbsp;<i style=" " class="fa fa-angle-right" id="angl"></i></a><br>
                          <br>
                                  
                        </div>
                 <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12" style="background:#FFA500;  text-align: center">
                                 <br><i class="fa fa-bed" data-animation="fadeInUp" data-delay="100" style="font-size: xxx-large;
            color: white;"></i><h3 style="color:#fff;text-transform: capitalize;text-align:center">Health Issues</h3>
             <a href="#" class="read-moreorange" style="">Read More&nbsp;<i style=" " class="fa fa-angle-right" id="angl"></i></a><br>
                          <br>
                                  
                        </div>
                  <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12" style="background:#0ebbbf;  text-align: center">
                                <br><i class="fa fa-gears" data-animation="fadeInUp" data-delay="100" style="font-size: xxx-large;
            color: white;"></i><h3 style="color:#fff;text-transform: capitalize;text-align:center">Other Service Items</h3>
             <a href="#" class="read-moreblue" style="">Read More&nbsp;<i style=" " class="fa fa-angle-right" id="angl"></i></a><br>
                          <br>
                                  
                        </div>
                            
                    </div>
                    </div>
            </section>
            <br>
            <section class="service-top-areaa padding-100-50" id="features" style="padding-bottom:50px  ">
            <div class="container"><div class="row">  <div class="area-title wow fadeIn" style="visibility: visible; animation-name: fadeIn;    text-align: center;">
                                <h2>Global  <b style="color:#0066cc">Presence</b></h2><img src="img/line3.png">
                            </div> </div> <div class="row"> <div class="col-md-1 col-lg-1 col-sm-6 col-xs-12">   </div>
                  <div class="col-md-2 col-lg-2 col-sm-6 col-xs-12">
                    <a href="#" class="popular-category h-100">
                    <i class="fa fa-level-up" aria-hidden="true" style="    font-size: xx-large;color:#044675"></i>
                      <span class="caption mb-2 d-block">Experience</span>
                      <span class="number">5+</span>
                    </a>
                  </div>
                  <div class="col-md-2 col-lg-2 col-sm-6 col-xs-12">
                    <a href="#" class="popular-category h-100">
                   <i class="fa fa-industry" aria-hidden="true" style="    font-size: xx-large;color:#044675"></i>
                      <span class="caption mb-2 d-block">Manufacturing</span>
                      <span class="number">15+</span>
                    </a>
                  </div>
                    <div class="col-md-2 col-lg-2 col-sm-6 col-xs-12">  <a href="#" class="popular-category h-100">
                       <i class="fa fa-product-hunt" aria-hidden="true" style="    font-size: xx-large;color:#044675"></i>
                      <span class="caption mb-2 d-block">Products</span>
                      <span class="number">10+</span>
                    </a>
                  </div>
                    <div class="col-md-2 col-lg-2 col-sm-6 col-xs-12">   <a href="#" class="popular-category h-100">
                      <i class="fa fa-shopping-cart" aria-hidden="true" style="    font-size: xx-large;color:#044675"></i>
                      <span class="caption mb-2 d-block">Markets</span>
                      <span class="number">50+</span>
                    </a>
                  </div>
                     <div class="col-md-2 col-lg-2 col-sm-6 col-xs-12">   <a href="#" class="popular-category h-100">
                        <i class="fa fa-users" aria-hidden="true" style="    font-size: xx-large;color:#044675"></i>
                      <span class="caption mb-2 d-block">Employees</span>
                      <span class="number">50+</span>
                    </a>
                  </div> <div class="col-md-1 col-lg-1 col-sm-6 col-xs-12">   </div>
                </div>
                </div></section>
        <!--<section class="service-top-area padding-100-50" id="features" style="padding-bottom:50px  ">
                <div class="container">
                    <div class="row">
        <div class="area-title text-center wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                                <h2>Products</h2><img src="img/line3.png">
                            </div>               
                           <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <div class="client-slider mt50 wow fadeIn">
                                <div class="single-client">
                                    <img src="img/pd1.jpg" alt=>
                                </div>
                                <div class="single-client">
                                    <img src="img/pd2.jpg" alt="">
                                </div>
                                <div class="single-client">
                                    <img src="img/pd3.jpg" alt="">
                                </div>
                                <div class="single-client">
                                    <img src="img/pd4.jpg" alt="">
                                </div>
                                <div class="single-client">
                                    <img src="img/pd5.jpg" alt="">
                                </div>
          <div class="single-client">
                                    <img src="img/pd1.jpg" alt=>
                                </div>
                                <div class="single-client">
                                    <img src="img/pd2.jpg" alt="">
                                </div>
                                <div class="single-client">
                                    <img src="img/pd3.jpg" alt="">
                                </div>
                                <div class="single-client">
                                    <img src="img/pd4.jpg" alt="">
                                </div>
                                <div class="single-client">
                                    <img src="img/pd5.jpg" alt="">
                                </div>
                            </div>
                        </div><a href="#" class="read-more" style="background:#0ebbbf;    margin-left: 44%;">View More&nbsp;<i style=" font-weight: 900;" class="fa fa-angle-right" id="angl"></i></a>
                        
                    </div>
                                   
             </div>
                    </div>
                
            </section>-->
        
            <div class="container-fluid">
                <div class="row1">
                    <div class="col-md-6 nopadding">
                        <div class="features-content">
                            <h2 style="color: #fff;">Focus on Quality</h3>
                                <p>The best team and advanced technology is critical to our vision but a 
                                    culture of quality is necessary to reach those goals. Quality is embedded 
                                    in our quality systems and pharmacovigilance. We are constantly learning 
                                    and growing to adapt to the evolving standards in this highly regulated 
                                    industry.  Our products will be manufactured in America and developed 
                                    with the highest standards and accountability. 
                                </p>
                                <p><a href="#" style="color:#fff;">Read more</a></p>
                        </div>
                    </div>
                    <div class="col-md-6 nopadding features-intro-img">
                        <div class="features-bg" style="position: relative;
                        min-height: 400px;
                        background: url(img/middle-img.png) center center no-repeat;
                        background-size: cover;">
                            <div class="features-img"></div>
                        </div>
                    </div>
                </div>
            </div>
        
                <section class="promo-area section-padding relative">
                <div class="area-bg" data-stellar-background-ratio="0.6" style="background-position: 50% -78.1688px; background-color: #e2e2e2;"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <div class="promo-content text-center white wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                                <h2 style="text-transform: none;">News / Announcements</h2>
                            </div>
                            <div class="row">
                                @foreach ($news as $item)
                                <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                                    <div class="feed-widget twitter-feed mb50 wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                                        <img src="{{asset($item->image)}}">
                                        <br> 
                                        <p style="font-size: 12px;  color: black; text-align: center; margin:0px;">
                                            <span style="font-weight: bold;">{{$item->heading}}</span>
                                            <br>{{$item->date}}</p>
                                    </div>
                                 </div>
                                @endforeach
                             
                             
                             <div class="newsbut">
                                <a style="display:block" href="{{route('frontend.news')}}">
                                 <div class="newsbutarea">
                                    <p style="margin-top: 5px; color: #fff; font-weight: bold;">Go to news section</p>
                                 </div> 
                                 </a> 
                             </div>
                             <br>
                            </div>
                        <hr style="display:none" id="hd1">
                        <br>
                        <section class="home-newsletter">
                            <div class="container">
                                <form action="{{route('subscribe')}}" method="post" id="subscribe">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="single">
                                                <h4 class="text-center">Subscribe to the Newsletter</h4>
                                            <div class="input-group">
                                                <input type="email" class="form-control" autocomplete="off" required name="email" placeholder="Enter your email">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary" type="submit">Subscribe</button>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section><br>
                    </div>
                </div>
            </section>
        
            <!--SERVICE TOP AREA END-->
        <!--<section class="promo-area section-padding relative">
                <div class="area-bg" data-stellar-background-ratio="0.6" style="background-position: 50% -126.056px;"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                          <div class="area-title wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                                
                                <h3 style="text-transform: capitalize;    color: #ffff;">Careers</h3>
                                <p style=" color: #ffff;">Would You like to be the part of our business? <br>Submit your details and we'll be in touch you shortly.<br>You can also email us if you would prefer.</p>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-8 col-sm-6 col-xs-12">
                            <div class="promo-content white wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                                <h5 style="text-transform: initial;    color: #ffff;">I would like to discuss : </h5>
                               <form action="process.php" id="contact-form" method="post">
                               <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                        <div class="form-group" id="name-field">
                                            <div class="form-group">
          
          <select class="form-control" id="sel1">
            <option>Business Ideation & Execution
        </option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
          </select>
        </div>
                                        </div> </div>  <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                        <div class="form-group" id="email-field">
                                            <div class="form-input">
                                                <input type="email" class="form-control" id="form-email" name="form-email" placeholder="Your Name" required="">
                                            </div>
                                        </div>  </div>  </div>
                                          <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                        <div class="form-group" id="name-field">
                                            <div class="form-input">
                                                <input type="text" class="form-control" id="form-name" name="form-name" placeholder="Phone Number" required="">
                                            </div>
                                        </div> </div>  <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                                        <div class="form-group" id="email-field">
                                            <div class="form-input">
                                                <input type="email" class="form-control" id="form-email" name="form-email" placeholder="Your Name" required="">
                                            </div>
                                        </div>  </div>  </div>
                                        <div class="form-group">
                                            <button type="submit" style="background:#0066cc" class="read-more">Submit&nbsp;&nbsp;<i style=" font-weight: 900;" class="fa fa-angle-right" id="angl"></i></button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>-->
            <!--ABOUT AREA-->
        
@include('frontend.layouts.footer')
<script src="{{asset('adminlte/toastr.min.js')}}"></script>
<script>
$(document).unbind('submit').on('submit', '#subscribe', function(e){
    e.preventDefault();
    $(this).find('button[type="submit"]').attr('disabled', true);
    var data = $(this).serialize();
    $.ajax({
        method: "post",
        url: $(this).attr("action"),
        dataType: "json",
        data: data,
        success:function(result){
            if(result.success == true){
                toastr.success(result.msg);
            }else{
                toastr.error(result.msg);
            }
        }
    });
});
</script>