<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Supplier;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index(Request $r) {

        if(Auth::user()->level === 'Admin') {
            return Supplier::where('name','LIKE',"%".$r->search."%")->orderBy('id','desc')->paginate(10);
        }
        else {
            return Supplier::where('branch_id',Auth::user()->branch_id)->where('name','LIKE',"%".$r->search."%")->orderBy('id','desc')->paginate(10);

        }
    }

    public function create(Request $req)
    {
        $validated = $req->validate([
            'name'=>'required',
            'email'=>'required|unique:suppliers',
            'mobile'=>'required|integer',
            'photo' => ['required', 'image'],
        ]);
        if(!$validated) {
            return ['message'=>$validated->errors()];
        }

        $image = $req->file('photo');
        $image_name = $image->getClientOriginalName();

        $image->move(public_path('/images/suppliers/'), $image_name);

        $supplier = new Supplier;
        $supplier->name = $req->name;
        $supplier->branch = Auth::user()->branch_id;
        $supplier->email = $req->email;
        $supplier->mobile = $req->mobile;
        $supplier->image_name = $image_name;
    
        $supplier->save();

        return ["Message"=>"Supplier added successfully"];
    }

    public function edit($id) {
        $supplier = Supplier::findOrFail($id);
        return $supplier;
    }

    public function show($id) {
        $supplier = Supplier::findOrFail($id);
        return $supplier;
    }

    public function update($id,Request $req)
    {
        $validated = $req->validate([
            'name'=>'required',
            'email'=>'required',
            'mobile'=>'required|integer',
            'photo'=>'required|image'
        ]);

        if(!$validated) {
            return ['message'=>'validation errors'];
        }

        $photo = $req->file('photo');
        if($photo){
            $image_name = $photo->getClientOriginalName();
            $photo->move(public_path('/images/suppliers/'), $image_name);
        }
        else {
            $supplier = Supplier::find($id,'image_name');
            $image_name = $supplier->image_name;
        }
        $supplier = Supplier::findOrFail($id);
        $supplier->name = $req->name;
        $supplier->email = $req->email;
        $supplier->mobile = $req->mobile;
        $supplier->image_name = $image_name;

        $supplier->save();

        return ['Message'=>'Data updated successfully'];

    }

    public function destroy($id) {
        $supplier = Supplier::findOrFail($id);
        if($supplier->delete()) {
            return ["message"=>"deleted successfully"];
        }


    }
}
