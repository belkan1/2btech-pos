<?php

namespace App\Http\Controllers\API;

use App\branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        $user = branch::where('name','LIKE',"%".$r->search."%")->orderBy('id','desc')->paginate(10);
        return response()->json($user,200);
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
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|numeric',
            'address'=> 'required|string',
            'email' => 'required|string|unique:branches',
        ]);

        if(!$validated)
        {
            return response()->json(['Validation Errors'=>$validated->errors]);
        }

        $branch = new branch;
        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->phone = $request->phone;
        $branch->email = $request->email;

        $branch->save();

        return response()->json(['status'=>'successfully created!'],200);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $branch = Branch::findOrFail($id);

        return $branch;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch = Branch::findOrFail($id);

        return $branch;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|numeric',
            'address'=> 'required|string',
            'email' => 'required|string',
        ]);

        if(!$validated)
        {
            return response()->json(['Validation Errors'=>$validated->errors]);
        }

        $branch = Branch::findOrFail($id);
        $branch->name = $request->name;
        $branch->email = $request->email;
        $branch->address = $request->address;
        $branch->phone = $request->phone;
        
        $branch->save();

        return response()->json(['status'=>'successfully updated!'],200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return ['status'=>'200','Message'=>'Branch Successfully Deleted!'];
    }
}
