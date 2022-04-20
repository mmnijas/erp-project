<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Products::select('*');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $button = '<a href="'.route('products.edit',$row->id).'" class="btn btn-xs btn-success" ><i class="fa fa-edit"></i> MANAGE</a>';
                        $button .= ' <button class="btn btn-xs btn-danger delete_button" onclick="remove(' . $row->id . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i> DELETE</button>';
                        return $button;
                    })
                    ->addColumn('status',function($row){
                        if($row->status==1){
                            $status = 'ACTIVE';
                        }else{
                            $status = 'INACTIVE';
                        }
                        return $status;
                    })
                    ->addColumn('image',function($row){
                        return '<img src="'.asset($row->image).'" style="width:50px"></img>';
                    })
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->Where('name', 'LIKE', "%$search%");
                            });
                        }

                    })
                    ->rawColumns(['status','action','image'])
                    ->make(true);
        }
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,gif',
            'strength_and_size'=>'required',
            'ndc'=>'required',
            'upc_code'=>'required',
            'imprint'=>'required',
            'gpi_code'=>'required',
            'dosage_form'=>'required',
            'te_code'=>'required',
            'brand_reference'=>'required',
            'therapeutic_category'=>'required',
            'pronunciation'=>'required',
            'inactive_ingredients'=>'required',
            'status'=>'required',
        ], [
            'name.required' => 'Name is required!',
            'image.required' => 'Image is required!',
            'image.mimes' => 'Please insert image only'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['status' => 'danger', 'message' => $validator->errors()->first()])->withInput();
        }
        try{
            if ($request->hasFile('image')) {
                $path = public_path('/products');
                if (!file_exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }
                $imageName =  uniqid().'.'.$request->image->extension();
                $request->image->move(public_path('/products'),$imageName);
                $image = '/products/'.$imageName;
            }
            $products = new Products();
            $products->name = $request->name;
            $products->image = $image;
            $products->strength_and_size = $request->strength_and_size;
            $products->ndc = $request->ndc;
            $products->upc_code = $request->upc_code;
            $products->imprint = $request->imprint;
            $products->gpi_code = $request->gpi_code;
            $products->dosage_form = $request->dosage_form;
            $products->te_code = $request->te_code;
            $products->brand_reference = $request->brand_reference;
            $products->therapeutic_category = $request->therapeutic_category;
            $products->pronunciation = $request->pronunciation;
            $products->inactive_ingredients = $request->inactive_ingredients;
            $products->status = $request->status;
            $products->save();
            return redirect('admin/products')->with(array('message' => 'Product Added!', 'status' => 'success'));
        } catch (\Throwable $th) {
            return response(['status'=>'danger','message'=>'Something went wrong']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['products']=Products::where('id',$id)->first();
        return view('admin.products.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'mimes:jpg,jpeg,png,gif',
            'strength_and_size'=>'required',
            'ndc'=>'required',
            'upc_code'=>'required',
            'imprint'=>'required',
            'gpi_code'=>'required',
            'dosage_form'=>'required',
            'te_code'=>'required',
            'brand_reference'=>'required',
            'therapeutic_category'=>'required',
            'pronunciation'=>'required',
            'inactive_ingredients'=>'required',
            'status'=>'required',
        ], [
            'name.required' => 'Name is required!',
            'image.required' => 'Image is required!',
            'image.mimes' => 'Please insert image only'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(['status' => 'danger', 'message' => $validator->errors()->first()])->withInput();
        }
        try{
            $data = [
                'name'=>$request->name,
                'strength_and_size'=>$request->strength_and_size,
                'ndc'=>$request->ndc,
                'upc_code'=>$request->upc_code,
                'imprint'=>$request->imprint,
                'gpi_code'=>$request->gpi_code,
                'dosage_form'=>$request->dosage_form,
                'te_code'=>$request->te_code,
                'brand_reference'=>$request->brand_reference,
                'therapeutic_category'=>$request->therapeutic_category,
                'pronunciation'=>$request->pronunciation,
                'inactive_ingredients'=>$request->inactive_ingredients,
                'status'=>$request->status
            ];
            Products::where('id',$id)->update($data);
            if ($request->hasFile('image')) {
                $products = Products::findOrFail($id);
                $path = public_path(). $products->image;
                if(file_exists($path)){
                    unlink($path);
                }
                $path = public_path('/products');
                $imageName =  uniqid().'.'.$request->image->extension();
                $request->image->move(public_path('/products'),$imageName);
                $data = ['image'=> '/products/'.$imageName];
                Products::where('id',$id)->update($data);
            }
            return redirect()->back()->with(array('message' => 'Products Updated!', 'status' => 'success'));
        } catch (\Throwable $th) {
            return response(['status'=>'warning','message'=>'Something went wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->ajax()) {
            try {
                $products = Products::findOrFail($id);
                $path = public_path(). $products->image;
                $products->delete();
                if(file_exists($path)){
                    unlink($path);
                }
                return (['status' => true,'msg' =>'successfully deleted']);
            } catch (\Exception $e) {
                return (['status' => false,'msg' => 'something went wrong']);
            }
        }
    }
}
