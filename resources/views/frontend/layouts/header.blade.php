
@include('frontend.layouts.head')
<body data-spy="scroll" data-target=".mainmenu-area" data-offset="90">
    <a href="#home" class="scrolltotop"><i class="fa fa-long-arrow-up"></i></a>

    <!--START TOP AREA-->
    <header class="top-area" id="home">
        <div class="top-bar-area gray-bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="call-to-action">
                            <p><i class="fa fa-map-marker" style ="color:#ffffff"></i> <a >{{App\Models\Settings::first()['address']}}</a></p>
                           
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="header-social-bookmark">
                           <p style="    float: right;"><i class="fa fa-phone" style ="color:#ffffff"></i> <a style ="color:#ffffff" href="">{{App\Models\Settings::first()['phone']}}</a></p> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-top-area">
            <!--MAINMENU AREA-->
            <div class="mainmenu-area" id="mainmenu-area">
                <div class="mainmenu-area-bg"></div>
                <nav class="navbar">
                    <div class="container">
                        <div class="navbar-header">
                            <a href="{{url('/')}}" class="navbar-brand"><img src="{{asset('img/logo.png')}}" alt="logo" style="margin-top: -5%;"></a>
                        </div>
                        <div id="main-nav" class="stellarnav">
                              <ul id="nav" class="nav navbar-nav">
                                <li class="active" ><a href="{{url('/')}}">home</a></li>
                                <li ><a href="#">about</a>
								    <ul class="dropdown-menu"> 
                                    <li ><a href="{{route('our-company')}}" style="font-weight: 500;">Our Company</a></li>
                                    <li><a href="{{route('management')}}" style="font-weight: 500;">Management</a></li>
                                    <li><a href="{{route('quality-policy')}}" style="font-weight: 500;">Quality Policy</a></li>
                                    <li><a href="{{route('safety')}}" style="font-weight: 500;"> Safety</a></li>
                                    <li><a href="{{route('quality-assurance')}}" style="font-weight: 500;">Quality Assurance</a></li>
                                    <li><a href="{{route('regulatory-and-compliance')}}" style="font-weight: 500;white-space: normal;">Regulatory & Compliance</a></li>
					                </ul>
                                </li>
                                <li><a href="{{route('products-list')}}">Products</a></li>
                                    <li><a href="#">Businesses</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{route('overview')}}" style="font-weight: 500;"> overview</a></li>
                                            <li><a href="{{route('generics')}}" style="font-weight: 500;"> generics</a></li>
                                            <li><a href="{{route('biosimilars')}}" style="font-weight: 500;">  Biosimilars </a></li>
                                            <li><a href="{{route('novel-biologics')}}" style="font-weight: 500;"> Novel Biologics</a></li>
                                            <li><a href="{{route('research-services')}}" style="font-weight: 500;"> Research Services</a></li>
                                        </ul>
                                    </li>
                                <li ><a href="#">Facilities</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('manufacturing')}}" style="font-weight: 500;"> Manufacturing</a></li>
                                        <li><a href="{{route('lab')}}" style="font-weight: 500;"> Lab</a></li>
                                        <li><a href="{{route('rd-facility')}}" style="font-weight: 500;">  R & D Facility </a></li>
                                        <li><a href="{{route('analytical-development')}}" style="font-weight: 500;"> Analytical Development</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">careers</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('open-positions')}}"  style="font-weight: 500;">Open Positions</a></li>
                                    </ul>
                                </li>
                                <li class=""><a href="{{route('frontend.news')}}">News</a></li>
                                
                                <li><a href="{{route('contacts')}}">Contact</a></li>
                            </ul>
                        </div>
                    </div> 
                </nav>
            </div>
            <!--END MAINMENU AREA END-->
        </div>
    </header>
    <!--END TOP AREA-->