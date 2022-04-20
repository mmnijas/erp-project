@include('admin.layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>PRODUCTS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{url('admin')}}">HOME</a></li>
                <li class="breadcrumb-item"><a href="{{route('products.index')}}">PRODUCTS</a></li>
                <li class="breadcrumb-item active">UPDATE</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div class="container-fluid">
            <div class="row">
            <div class="col-12">
                @if (Session::has('message'))
                    <div class="alert alert-{{ Session::get('status') }}" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ Session::get('message') }}
                    </div>
                @endif
                    <!-- general form elements -->
                <div class="card card-primary">
                <form method="post" action="{{route('products.update',$products->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="name">NAME</label>
                                <input type="text" class="form-control" placeholder="NAME" name="name" value="{{old('name',$products->name)}}" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <img src="{{$products->image}}" alt="{{$products->name}}" style="width: 75px">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                <label for="name">IMAGE</label>
                                <input type="file" class="form-control" placeholder="IMAGE" name="image" value="{{old('image')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">STRENGTH AND SIZE</label>
                                    <input type="text" class="form-control" placeholder="STRENGTH & SIZE" name="strength_and_size" value="{{old('strength_and_size',$products->strength_and_size)}}" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">NDC</label>
                                    <input type="text" class="form-control" placeholder="NDC" name="ndc" value="{{old('ndc',$products->ndc)}}" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">UPC CODE</label>
                                    <input type="text" class="form-control" placeholder="UPC CODE" name="upc_code" value="{{old('upc_code',$products->upc_code)}}" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">IMPRINT</label>
                                    <input type="text" class="form-control" placeholder="IMPRINT" name="imprint" value="{{old('imprint',$products->imprint)}}" required autocomplete="off">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">GPI CODE</label>
                                    <input type="text" class="form-control" placeholder="GPI CODE" name="gpi_code" value="{{old('gpi_code',$products->gpi_code)}}" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">DOSAGE FORM</label>
                                    <input type="text" class="form-control" placeholder="DOSAGE FORM" name="dosage_form" value="{{old('dosage_form',$products->dosage_form)}}" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">TE CODE</label>
                                    <input type="text" class="form-control" placeholder="TE CODE" name="te_code" value="{{old('te_code',$products->te_code)}}" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">BRAND REFERENCE</label>
                                    <input type="text" class="form-control" placeholder="BRAND REFERENCE" name="brand_reference" value="{{old('brand_reference',$products->brand_reference)}}" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">THERAPEUTIC CATEGORY</label>
                                    <input type="text" class="form-control" placeholder="THERAPEUTIC CATEGORY" name="therapeutic_category" value="{{old('therapeutic_category',$products->therapeutic_category)}}" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">PRONUNCIATION</label>
                                    <input type="text" class="form-control" placeholder="PRONUNCIATION" name="pronunciation" value="{{old('pronunciation',$products->pronunciation)}}" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">INACTIVE INGREDIENTS</label>
                                    <input type="text" class="form-control" placeholder="INACTIVE INGREDIENTS" name="inactive_ingredients" value="{{old('inactive_ingredients',$products->inactive_ingredients)}}" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                            <label for="name" class="">STATUS</label>
                                <select class="form-control" name="status" required>
                                    <option value="1" @if (old('status',$products->status) == '1') selected @endif>ACTIVE</option>
                                    <option value="2" @if (old('status',$products->status) == '2') selected @endif>INACTIVE</option>
                                </select>  
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"> UPDATE PRODUCT</button>
                    </div>
                </form>
                
                
                </div>
            </div>
            </div>
        </div>
    </section>
</div>
@include('admin.layouts.footer')
<script>
    $("#productsNav").addClass('active');
</script>