<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Towers;
use App\Models\Floors;
use Session;
use Illuminate\Support\Facades\DB;

class FloorController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index() {
        $towers = Towers::whereNotIn( 'status', [ 1 ] )->get();
        return view( 'Admin.Floor.create_floor', compact( 'towers' ) );
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
        $validator = validator::make( $request->all(), [
            'tower_id'=>'required',
            'floor_number'=>'required',

        ], [
            'tower_id.required'=>'Tower name is required',
            'floor_number.required'=>'floor number is required',

        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();

        } else {
            $floor = new Floors;
            $floor->tower_id = $request->get( 'tower_id' );
            $floor->floor_number = $request->get( 'floor_number' );
            $floor->status = 0;
            $result = $floor->save();

            $request->session()->flash( 'msg', 'insert' );
            return redirect( 'view_towers' );
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id ) {
        $tower = Floors::with( 'tower' )->find( $id );
        return response()->json( [
            'status' =>'success',
            'data' => $tower,

        ] );
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit( $id ) {
        $towers = Towers::whereNotIn( 'status', [ 1 ] )->get();
        $floor = Floors::find( $id );
        return view( 'Admin.Floor.update_floor', compact( 'floor', 'towers' ) );
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
            'tower_id'=>'required',
            'floor_number'=>'required',

        ], [
            'tower_id.required'=>'Tower name is required',
            'floor_number.required'=>'floor number is required',

        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();

        } else {
            $result = Floors::where( 'id', $id )->update( [
                'tower_id' => $request->get( 'tower_id' ),
                'floor_number' =>  $request->get( 'floor_number' )
            ] );
            $request->session()->flash( 'msg', 'update' );
            return redirect( 'view_floors' );
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        $response = Floors::where( 'id', '=', $id )->delete();
        if ( $response ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $response,
            ] );
        }
    }

    public function viewfloors() {

        return view( 'Admin.Floor.view_floors' );
    }

    public function getFloor() {
        $floors = Floors::with( 'tower' )->get();

        // return $floors;
        if ( $floors ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $floors,
            ] );
        }
    }

}
