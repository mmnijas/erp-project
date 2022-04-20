<?php

namespace App\Http\Controllers;

use App\Models\Subscribers;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = Subscribers::select('email','status');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        return '<button class="btn btn-xs btn-danger delete_button" onclick="remove(' . $row->id . ')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
                    })
                    ->addColumn('status',function($row){
                        if($row->status==1){
                            $status = 'ACTIVE';
                        }else{
                            $status = 'INACTIVE';
                        }
                        return $status;
                    })
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->Where('email', 'LIKE', "%$search%");
                            });
                        }

                    })
                    ->rawColumns(['status','action'])
                    ->make(true);
        }
        return view('admin.subscriptions.index');
    }

    public function destroy($id)
    {
        if (request()->ajax()) {
            try {
                $subscribers = Subscribers::findOrFail($id);
                $subscribers->delete();
                return (['status' => true,'msg' =>'successfully deleted']);
            } catch (\Exception $e) {
                return (['status' => false,'msg' => 'something went wrong']);
            }
        }
    }
       
}
