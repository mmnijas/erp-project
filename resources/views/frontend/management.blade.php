@include('frontend.layouts.header')
<section class="service-top-area" style="background-image: url('img/managementbanner.jpg'); background-repeat: no-repeat; text-align: center;  padding: 221px 0px 69px 0px;">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="ec-mini-title">
<h1>Management</h1>
</div>
<div class="ec-breadcrumb">
<ul>
<li><a href="index.html">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right" style="color:#ffffff"></i></li>
<li>About Us</li>
</ul>
</div>
</div>
</div>
</div>
</section>
    <!--TEAM AREA-->
    <section class="aboutsec" id="team" style="">
        <div class="container">
            <div class="row">
                           <h2>Key <b style="color:#0066cc">Management</b></h2><img src="img/line.png" id="linecnt">
                        <p>An organisation is as dynamic and effective as its people. At Biocon, the vast experience and the strategic focus of the Key Management Team steer us towards our goals. The Key Management Team focuses on driving innovative work practices and higher process maturity across the organisation. It executes its role in corporate governance through regular reviews of our financial performance and critical business issues. The Key Management Team is amply supported by a strong team of exemplary bioscientists, engineers and business managers.</p>
                    
                
            </div>
            <div class="row team-slider">
                @foreach ($management as $item)
                <div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
                <div class="single-team center white wow fadeIn">
                    <div class="member-top-details relative">
                        <div class="member-thumb">
                            <img src="{{$item->image}}" alt="{{$item->name}}">
                        </div>
                        <div class="member-details v-center">
                            <h4>{{$item->name}}<span>{{$item->designation}}</span></h4>
                            <p>{{$item->description}}</p>
                        </div>
                    </div>
                    <div class="member-bottom-details">
                        <div class="member-name-and-designation">
                            <h4>{{$item->name}}<span>{{$item->designation}}</span></h4>
                        </div>
                        <ul class="social-bookmark">
                            <li><a href="{{$item->facebook}}"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="{{$item->twitter}}"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="{{$item->linkedin}}"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
                @endforeach
            </div>
                
        </div>
    </div>
</section>
    <!--TEAM AREA END-->
@include('frontend.layouts.footer')