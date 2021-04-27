<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Http\Resources\CustomerCollection;
use Illuminate\Support\Facades\Auth;
use Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        if(Auth::user()->level === "Admin") {
            return new CustomerCollection(Customer::where('name','LIKE',"%$r->search%")->orderBy('id','DESC')->paginate(10));
        }
        else {
            return new CustomerCollection(Customer::where('branch_id',Auth::user()->branch_id)->where('name','LIKE',"%$r->search%")->orderBy('id','DESC')->paginate(10));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'alamat' => 'required',
            'phone' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'email' => 'required|email',
            'photo' => 'nullable'
        ]);

        $customer = new Customer;
        $customer->name = $request->name;
        $customer->branch_id = Auth::user()->branch_id;
        $customer->alamat = $request->alamat;
        $customer->role = $request->role;
        $customer->phone = $request->phone;
        $customer->kota = $request->kota;
        $customer->provinsi = $request->provinsi;
        $customer->email = $request->email;
        if($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $image_name = $photo->getClientOriginalName();
            $photo->move(public_path('/images/customers'), $image_name);
            $customer->image_name = $image_name;
        }

        $customer->save();

        return response()->json(['status' => true]);
    }

    public function all() {
        return new CustomerCollection(Customer::orderBy('name','asc')->get());
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
        $customer = Customer::findOrFail($id);
        // return $user;
        return $customer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return $customer;
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
            'alamat' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'photo' => 'nullable'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(),403);
        }
        $customer = Customer::find($id);
        
        if($customer) {

            $customer->name = $request->name;
            $customer->alamat = $request->alamat;
            $customer->role = $request->level;
            $customer->phone = $request->phone;
            // $customer->kota = $request->kota;
            $customer->email = $request->email;
            if($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $image_name = $photo->getClientOriginalName();
                $photo->move(public_path('/images/customers'), $image_name);
                $customer->image_name = $image_name;
            }
    
            $customer->save();
    
            return response()->json(['status' => true]);
        }

        else {
            return response()->json(['status' => 'not found'],404);
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
        //
        Customer::find($id)->delete();
        return response(['status'=>true]);
    }
}
