<?php

namespace App\Http\Controllers;
use App\Models\user;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller {
    public function __construct() {
        $this->middleware( 'auth' );
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        //
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {
        //
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id ) {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit( $id ) {
        $user = User::find( $id );
        return view( 'Admin.User.update_user', compact( 'user' ) );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id ) {
        $validator = validator::make( $request->all(), [
            'name'=>'required',
            'email'=>'required',
        ], [
            'name.required'=>'User name is required',
            'email.required'=>'User email is required',

        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();

        } else {

            $result = user::where( 'id', $id )->update( [
                'name' => $request->name,
                'email' => $request->email,
                'status' => 0,
            ] );

            $request->session()->flash( 'msg', 'update' );
            return redirect( 'view_users' );
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        $response = User::where( 'id', '=', $id )->delete();
        if ( $response ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $response,
            ] );
        }
    }

    public function viewUsers() {

        return view( 'Admin.User.view_users' );
    }

    public function getUsers() {
        $users = User::get();

        if ( $users ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $users,
            ] );
        }
    }

}
