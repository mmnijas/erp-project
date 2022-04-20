@include('frontend.layouts.header')
    {{-- Paste your page code here --}}
    <section class="service-top-area" style="background-image: url('img/careerbanner.jpg'); background-repeat: no-repeat; text-align: center;  padding: 221px 0px 69px 0px;">
        <div class="container">
        <div class="row">
        <div class="col-md-12">
        <div class="ec-mini-title">
        <h1> Open Positions</h1>
        </div>
        <div class="ec-breadcrumb">
        <ul>
        <li><a href="index.html">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right" style="color:#ffffff"></i></li>
        <li>Careers</li>
        </ul>
        </div>
        </div>
        </div>
        </div>
        </section>
               <!--INFO AREA-->
            <section class="info-area gray-bg" style=" background: #fff;padding: 35px 0px 69px 0px;">
                <div class="container">
                    <div class="row">
        
            <div class="col-md-8">
             
                                <h2>Current <b style="color:#0066cc">Openings</b></h2><img src="img/line.png" id="linecnt">
              <p> Innogenix is a fast growing research and development generic manufacturer. We are a leader in delivering the highest quality products, and what makes us so successful is our people. We are always looking for driven and talented professionals to join our diverse team. Please submit your resume</p>
        
              <p>Vacancies may vary from time to time. Available vacancies will be listed in our Career page. According to the requirement send your updated CV to &nbsp;<a href="mailto:">info@.com</a> or Feel free to contact us on &nbsp;+91 123456778</p>
              
              <p>The current vacancies are:</p></div> <div class="col-md-4"><img src="img/open-position.jpg" class="img-responsive"></div></div>
              <div class="row">
              
            <div class="col-md-10">
                    <ul>
                        @foreach ($careers as $item)
                              <li id="openp">
                                    <h3>{{$item->name}}</h3>
                                    <span class="label label-success">{{$item->qualification}}</span>
                                    <span class="label label-info">{{$item->job_type}}</span>
                                    <p>{{$item->description}}Kindly forward your CV to <a href="mailto:info@.com" target="_blank"> info@.com</a> | <a href="mailto:ddsfdsf@gmail.com" target="_blank"> fdgf@gmail.com</a></p>
                              </li>
                        @endforeach
                    </ul> </div></div>
                
        </div>
                </div>
            </section>
            <!--INFO AREA END-->
@include('frontend.layouts.footer')