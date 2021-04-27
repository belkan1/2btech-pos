<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\User;
use Hash;
use Illuminate\Support\Facades\Auth;
use Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        if(Auth::user()->level === 'Admin')
        return new UserCollection(User::where('name','LIKE',"%".$r->search."%")->orderBy('id','desc')->paginate(10));
        else {
            return new UserCollection(User::where('name','LIKE',"%".$r->search."%")->where('branch_id',Auth::user()->branch_id)->orderBy('id','desc')->paginate(10));
        }
        // return User::all();
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
            'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email' => ['required', 'string','max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'photo' => ['required', 'image'],
            'username' => ['required','min:6', 'unique:users'],
            'level' => ['required','in:Admin,Kasir,stockmanager'],
            'address' => 'required',
            'phone' => 'required|numeric',
        ]);
        // return $request;

        if($validator->fails()) {
            return response($validator->errors(), 403);
        }

        $image = $request->file('photo');
        $image_name = $image->getClientOriginalName();

        $image->move(public_path('/images/users/'), $image_name);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'branch_id' => Auth::user()->branch_id,
            'username' => $request->username,
            'phone' => $request->phone,
            'address' => $request->address,
            'level' => $request->level,
            'image_name' => $image_name,
            'password' => Hash::make($request->password),
        ]);

        if($user)
        {
            return "Successss!";
        }
        else
        {
            return "Failed";
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
        $user = User::findOrFail($id);
        // return $user;
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return $user;
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string|email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'photo' => ['required', 'image'],
            'username' => ['required','min:6', 'unique:users'],
            'level' => ['required','in:Admin,Kasir'],
            'address' => 'required',
            'phone' => 'required|numeric',
        ]);
        
        $photo = $request->file('photo');
        if($photo){
            $image_name = $photo->getClientOriginalName();
            $photo->move(public_path('/images/users/'), $image_name);
        }
        else {
            $user = User::find($id,'image_name');
            $image_name = $user->image_name;
        }

        if($request->password)
        {
            User::find($id)->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'level' => $request->level,
                'image_name' => $image_name,
            ]);
        }

        else
        {
            User::find($id)->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                // 'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'level' => $request->level,
                'image_name' => $image_name,
            ]);
        }
        
        return response()->json(['status'=>'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return response(['status'=>true]);
    }
}
