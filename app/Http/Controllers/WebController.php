<?php

namespace App\Http\Controllers;

use App\Models\Careers;
use App\Models\Contents;
use App\Models\EventImages;
use App\Models\Events;
use App\Models\HomeGallery;
use App\Models\Managements;
use App\Models\News;
use App\Models\Products;
use App\Models\Settings;
use App\Models\Sliders;
use App\Models\Subscribers;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WebController extends Controller
{   
    
    public function index(){
        $this->data['news']=News::where('status',1)->orderBy('date','desc')->limit(3)->get();
        $this->data['sliders'] = Sliders::where('status',1)->orderBy('order','asc')->get();
        return view('frontend/home',$this->data);
    }
    public function subscribe(Request $request){
        if (request()->ajax()) {
            try {
                if(Subscribers::where('email',$request->email)->exists()){
                    return (['success' => false,'msg' => 'Already Subscribed']);
                }
                $subscribe = new Subscribers();
                $subscribe->email = $request->email;
                $subscribe->status = 1;
                $subscribe->save();
                return (['success' => true,'msg' => 'Success']);
            } catch (\Exception $e) {
                return (['success' => false,'msg' => 'Something went wrong']);
            }
        }
    }
    public function our_company(){
        return view('frontend/our_company',$this->data);
    }
    public function management(){
        $this->data['management'] = Managements::where('status',1)->orderBy('order','asc')->get();
        return view('frontend/management',$this->data);
    }
    public function quality_policy(){
        return view('frontend/quality_policy',$this->data);
    }
    public function safety(){
        return view('frontend/safety',$this->data);
    }
    public function quality_assurance(){
        return view('frontend/quality_assurance',$this->data);
    }
    public function regulatory_and_compliance(){
        return view('frontend/regulatory_and_compliance',$this->data);
    }
    public function products(Request $request){
        $this->data['slider']=Products::select('name','image')->inRandomOrder()->limit(5)->get();
        if($request->ajax())
        {
            $products = Products::inRandomOrder()->where('status',1);
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('details', function($row){
                    return '<a href="'.route('products-view',['id' => $row->id]).'" class="btn btn-xs btn-block btn-primary"><i class="fa fa-eye"></i> VIEW</a>';
                 })
                 ->addColumn('guide', function($row){
                    return '<i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp;View';
                 })
                 ->addColumn('leaflet', function($row){
                    return '<i class="fa fa-eye" aria-hidden="true"></i>&nbsp;&nbsp;View';
                 })
                 ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search')))
                    {
                        $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->where('name', 'LIKE', "%$search%");
                            $w->orWhere('dosage_form', 'LIKE', "%$search%");
                            $w->orWhere('te_code', 'LIKE', "%$search%");
                            $w->orWhere('brand_reference', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['details','leaflet','guide'])
                ->make(true);
        }
        return view('frontend/products',$this->data);
    }
    public function products_view($id){
        $this->data['product']=Products::where('id',$id)->first();
        return view('frontend/products_view',$this->data);
    }
    public function overview(){
        return view('frontend/overview',$this->data);
    }
    public function generics(){
        return view('frontend/generics',$this->data);
    }
    public function biosimilars(){
        return view('frontend/biosimilars',$this->data);
    }
    public function novel_biologics(){
        return view('frontend/novel_biologics',$this->data);
    }
    public function research_services(){
        return view('frontend/research_services',$this->data);
    }
    public function manufacturing(){
        return view('frontend/manufacturing',$this->data);
    }
    public function lab(){
        return view('frontend/lab',$this->data);
    }
    public function rd_facility(){
        return view('frontend/rd_facility',$this->data);
    }
    public function analytical_development(){
        return view('frontend/analytical_development',$this->data);
    }
    public function open_positions(){
        $this->data['careers'] = Careers::select('careers.id','careers.name','careers.status','qualifications.name as qualification','job_types.name as job_type')
        ->leftjoin('qualifications','qualifications.id','=','careers.qualification_id')
        ->leftjoin('job_types','job_types.id','=','careers.job_type_id')
        ->orderBy('careers.id','desc')->get();
        return view('frontend/open_positions',$this->data);
    }
    public function news(){
        $this->data['news']=News::where('status',1)->orderBy('date','desc')->simplepaginate(10);
        return view('frontend/news',$this->data);
    }
    public function contacts(){
        return view('frontend/contacts',$this->data);
    }

    

    

}
