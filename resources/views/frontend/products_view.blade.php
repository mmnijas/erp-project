@include('frontend.layouts.header')
<section class="service-top-area" style="background-image: url('{{asset('img/overviewbanner.jpg')}}'); background-repeat: no-repeat; text-align: center;  padding: 221px 0px 69px 0px;">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="ec-mini-title">
        <h1>{{$product->name}}</h1>
        <div class="ec-breadcrumb">
          <ul>
            <li><a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right" style="color:#ffffff"></i></li>
            <li>Products</li>
          </ul>
        </div>
        </div>
      </div>
    </div>
  </div>
</section>
           <!--INFO AREA-->
<section class="aboutsec" style=" background: #fff;">
  <div class="container">
    <div class="row">
      <h2>Product <b style="color:#0066cc">{{$product->name}}</b></h2><img src="{{asset('img/line.png')}}" id="linecnt">
      <p>An organisation is as dynamic and effective as its people. At Biocon, the vast experience and the strategic focus of the Key Management Team steer us towards our goals. The Key Management Team focuses on driving innovative work practices and higher process maturity across the organisation. It executes its role in corporate governance through regular reviews of our financial performance and critical business issues. The Key Management Team is amply supported by a strong team of exemplary bioscientists, engineers and business managers.</p>
    </div>
    <div class="row">
      <div class="col-lg-5 col-md-8 col-sm-12">
        <main class="content-area">
          <div class="strength-sizes">
            <h2 class="info-title">Strengths &amp; Sizes</h2>
            <div class="strength-sizes-list">
              <div class="single_size_strength">
                <button class="accordion">{{$product->strength_and_size}}</button>
                <div class="panel" style="">
                  <div class="images">
                    <div class="single_image">
                      <figure class="media">
                        <a class="image-popup-no-margins" href="{{asset($product->image)}}" data-lightbox="image-1">
                          <img src="{{asset($product->image)}}" alt="{{$product->name}}"></a>                                  
                      </figure>
                    </div>
                  </div>
                  <div class="image-size-note">
                    <p>Note: product and packaging images are not actual size</p>
                  </div>
                  <div class="product-info">
                    <ul>
                      <li> <b>NDC# :  </b>{{$product->ndc}}</li>
                      <li> <b>UPC Code :</b>{{$product->upc_code}}</li>
                      <li> <b>Imprint :</b>{{$product->imprint}}</li>
                      <li> <b>GPI Code :</b>{{$product->gpi_code}}  </li>
                    </ul>    
                  </div> 
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
      <div class="col-lg-7 col-md-8 col-sm-12">
        <h2 class="info-title">Product Info</h2>  
        <h3 style="line-height: 0.6em;font-size: 14px" >Dosage Form : </h3><p>{{$product->dosage_form}}</p><br>
        <h3 style="line-height: 0.6em;font-size: 14px">TE Code : </h3><p>{{$product->te_code}}</p><br>
        <h3 style="line-height: 0.6em;font-size: 14px">Brand Reference :</h3><p>{{$product->brand_reference}}</p><br>
        <h3 style="line-height: 0.6em;font-size: 14px">Therapeutic Category :</h3><p>{{$product->therapeutic_category}}</p><br>
        <h3 style="line-height: 0.6em;font-size: 14px">Pronunciation :</h3><p>{{$product->pronunciation}}</p><br>
        <h3 style="line-height: 0.6em;font-size: 14px">Inactive Ingredients :</h3><p>{{$product->inactive_ingredients}}</p>
      </div>
    </div>
  </div>
</section>
        <!--INFO AREA END-->
@include('frontend.layouts.footer')