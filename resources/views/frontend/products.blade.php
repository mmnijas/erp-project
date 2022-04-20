@include('frontend.layouts.header')
<section class="service-top-area" style="background-image: url('img/overviewbanner.jpg'); background-repeat: no-repeat; text-align: center;  padding: 221px 0px 69px 0px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ec-mini-title">
                    <h1>Products</h1>
                </div>
                <div class="ec-breadcrumb">
                    <ul>
                        <li><a href="index.html">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right" style="color:#ffffff"></i></li>
                        <li>Products</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
    
<section class="aboutsec" id="features" >
    <div class="container">
        <div class="row">
            <h2>Products </h2><img src="img/line.png" id="linecnt">
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type.</p>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div class="client-slider mt50 wow fadeIn">
                        @foreach ($slider as $item)
                            <div class="single-client">
                                <img src="{{asset($item->image)}}" alt="{{$item->name}}">
                            </div>
                        @endforeach
                    </div>
                </div>
            
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">  
                        <table id="products" class="table table-bordered data-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>PRODUCT NAME</th>
                                    <th>FORM</th>
                                    <th>TE CODE</th>
                                    <th>BRAND REFERENCE</th>
                                    <th>PRESCRIBING INFORMATION LEAFLET</th>
                                    <th>MEDICATION GUIDE/ PATIENT INFORMATION</th>
                                    <th>DETAILS</th> 
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>	
                </div>
                		
            </div> 
        </div>
    </div>
</section>
@include('frontend.layouts.footer')
<script>
    $(function () {
     var table = $('.data-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: {
           url: "{{ route('products-list') }}",
           data: function (d) {
                 d.search = $('input[type="search"]').val();
             }
         },
         columns: [
           {data: 'name', name: 'name'},
           {data: 'dosage_form', name: 'dosage_form'},
           {data: 'te_code', name: 'te_code'},
           {data: 'brand_reference', name: 'brand_reference'},
           {data: 'leaflet', name: 'leaflet'},
           {data: 'guide', name:'guide'},
           {data: 'details', name:'details'}
         ]
     });
   });
</script>