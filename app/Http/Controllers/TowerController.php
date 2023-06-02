<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Towers;
use Session;
use Illuminate\Support\Facades\DB;
class TowerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view( 'Admin.Tower.create_tower' );
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
        $validator = validator::make( $request->all(), [
            'tower_name'=>'required',
            'tower_location'=>'required',

        ], [
            'tower_name.required'=>'Tower name is required',
            'tower_location.required'=>'Tower location is required',

        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();

        } else {
            $tower = new Towers;
            $tower->tower_name = $request->get( 'tower_name' );
            $tower->tower_location = $request->get( 'tower_location' );
            $tower->status = 0;
            $result = $tower->save();

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
    public function show($id)
    {
        $tower = Towers::find( $id );
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
    public function edit($id)
    {
        $tower = Towers::find($id);
        return view( 'Admin.Tower.update_tower',compact('tower') );
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
        $validator = validator::make( $request->all(), [
            'tower_name'=>'required',
            'tower_location'=>'required',

        ], [
            'tower_name.required'=>'Tower name is required',
            'tower_location.required'=>'Tower location is required',

        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();

        } else {
            $tower = new Towers;
            $tower->tower_name = $request->get( 'tower_name' );
            $tower->tower_location = $request->get( 'tower_location' );

            $result = Towers::where( 'id', $id )->update( [
                'tower_name' => $request->tower_name,
                'tower_location' => $request->tower_location,
            ] );

            $request->session()->flash( 'msg', 'update' );
            return redirect( 'view_towers' );
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
        $response= Towers::where( 'id', '=', $id )->delete();
        if ( $response ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $response,
            ] );
        }
    }
    public function viewTowers() {

        return view( 'Admin.Tower.view_towers' );
    }
    public function getTowers() {
        $towers = Towers::get();

        if ( $towers ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $towers,
            ] );
        }
    }



}
