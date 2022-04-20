@include('frontend.layouts.header')
<!--WELCOME SLIDER AREA-->
<section class="service-top-area" style="background-image: url('img/news.jpg'); background-repeat: no-repeat; text-align: center;  padding: 221px 0px 69px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ec-mini-title">
                    <h1> News</h1>
                </div>
                <div class="ec-breadcrumb">
                    <ul>
                        <li><a href="index.html">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right" style="color:#ffffff"></i></li>
                        <li>News</li>
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
            <h2>News <b style="color:#0066cc"></b></h2><img src="img/line.png" id="linecnt">
            <div class="col-lg-12" style="border: 1px solid #f1f0f0">
            @foreach ($news as $item)
                <div class="row" style="padding-top: 30px">
                    <div class="col-lg-8"> 
                        <h3 style="text-transform:uppercase">{{$item->heading}}</h3>  
                        <p><?=$item->description?></p>
                        <span class="entry-date">{{date('F d, Y', strtotime($item->date))}}</span>
                        <br>
                    </div>
                    <div class="col-lg-4">
                        <br>
                        <img style="width:100%" src="{{$item->image}}" title="{{$item->heading}}" alt="{{$item->heading}}">
                        <br>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>


        </div>


        </div>
        <div class="row">
            {{ $news->withQueryString()->links() }}
        </div>
    </div>
</section>
                
@include('frontend.layouts.footer')