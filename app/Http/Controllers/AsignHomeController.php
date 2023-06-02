<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Towers;
use App\Models\Floors;
use App\Models\Homes;
use App\Models\Asign_home;
use Validator;
use Illuminate\Support\Facades\DB;
use File;
class AsignHomeController extends Controller {
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
        $floors = Floors::whereNotIn( 'status', [ 1 ] )->get();
        $homes = Homes::whereNotIn( 'status', [ 1 ] )->get();

        return view( 'Admin.AsignHomes.asign_homes', compact( 'towers', 'floors', 'homes' )  );
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
            'floor_id'=>'required',
            'home_id'=>'required',
            'cus_nic'=>'required',
            'cus_name'=>'required',
            'ah_reserve_date'=>'required',
            'ah_down_payment'=>'required',

        ], [
            'tower_id.required'=>'Tower name is required',
            'floor_id.required'=>'Floor name is required',
            'home_id.required'=>'Home name is required',
            'cus_nic.required'=>'Customer NIC number is required',
            'cus_name.required'=>'Customer name is required',
            'ah_reserve_date.required'=>'Reserve date is required',
            'ah_down_payment.required'=>'Down payment is required',
        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        } else {
            // $time = time();
            if ( $request->hasFile( 'ah_reserve_recipt' ) ) {
                $file = $request->file('ah_reserve_recipt');
                $filename = $file->getClientOriginalName();
                $path = public_path('/uploads/asign_homes/');
                    if ( !File::isDirectory( $path ) ) {
                        File::makeDirectory( $path, 0777, true, true );
                    }
                $file->move($path, $filename);
            }else{
                $filename='';
            }
            if ( $request->hasFile( 'ah_agreement' ) ) {
                $file_agreement = $request->file('ah_agreement');
                $filename_agree = $file_agreement->getClientOriginalName();
                $path_agree = public_path('/uploads/asign_homes/');
                    if ( !File::isDirectory( $path_agree ) ) {
                        File::makeDirectory( $path_agree, 0777, true, true );
                    }
                $file_agreement->move($path_agree, $filename_agree);
            }else{
                $filename_agree="";
            }
            $asignHome = new Asign_home;
            $asignHome->ah_reserve_date = $request->get( 'ah_reserve_date' );
            $asignHome->ah_remark = $request->get( 'ah_remark' );
            $asignHome->ah_down_payment = $request->get( 'ah_down_payment' );
            $asignHome->tower_id = $request->get( 'tower_id' );
            $asignHome->floor_id = $request->get( 'floor_id' );
            $asignHome->home_id = $request->get( 'home_id' );
            $asignHome->cus_id = $request->get( 'cus_id' );
            $asignHome->ah_reserve_recipt=$filename;
            $asignHome->ah_agreement=$filename_agree;
            $asignHome->ah_type = 1;
            $asignHome->status = 0;
            $result = $asignHome->save();
            $request->session()->flash( 'msg', 'insert' );
            return redirect( 'view_asign_homes' );
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id ) {
        $asignhome = Asign_home::with('tower','floor','home','customer')->find( $id );
        return response()->json( [
            'status' =>'success',
            'data' => $asignhome,

        ] );
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit( $id ) {
        $asign_homes = Asign_home::with('tower','floor','home','customer')->find( $id );


        $towers = Towers::whereNotIn( 'status', [ 1 ] )->get();
        $floors = Floors::whereNotIn( 'status', [ 1 ] )->get();
        $homes = Homes::whereNotIn( 'status', [ 1 ] )->get();

        return view( 'Admin.AsignHomes.update_asign_homes', compact( 'asign_homes','towers','floors','homes' ) );
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
            'floor_id'=>'required',
            'home_id'=>'required',
            'cus_nic'=>'required',
            'cus_name'=>'required',
            'ah_reserve_date'=>'required',
            'ah_down_payment'=>'required',

        ], [
            'tower_id.required'=>'Tower name is required',
            'floor_id.required'=>'Floor name is required',
            'home_id.required'=>'Home name is required',
            'cus_nic.required'=>'Customer NIC number is required',
            'cus_name.required'=>'Customer name is required',
            'ah_reserve_date.required'=>'Reserve date is required',
            'ah_down_payment.required'=>'Down payment is required',
        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        } else {
            $data = [
                'ah_reserve_date' => $request->ah_reserve_date,
                'ah_remark' =>$request->ah_remark,
                'ah_down_payment' => $request->ah_down_payment,
                'tower_id' => $request->tower_id,
                'floor_id' => $request->floor_id,
                'home_id' => $request->home_id,
                'cus_id' => $request->cus_id,
                'ah_type' => $request->ah_type,

            ];
            if ( $request->hasFile( 'ah_reserve_recipt' ) ) {
                $file = $request->file('ah_reserve_recipt');
                $filename = $file->getClientOriginalName();
                $path = public_path('/uploads/asign_homes/');
                    if ( !File::isDirectory( $path ) ) {
                        File::makeDirectory( $path, 0777, true, true );
                    }
                $file->move($path, $filename);
                $data['ah_reserve_recipt'] = $filename;
            }
            if ( $request->hasFile( 'ah_agreement' ) ) {
                $file_agreement = $request->file('ah_agreement');
                $filename_agree = $file_agreement->getClientOriginalName();
                $path_agree = public_path('/uploads/asign_homes/');
                    if ( !File::isDirectory( $path_agree ) ) {
                        File::makeDirectory( $path_agree, 0777, true, true );
                    }
                $file_agreement->move($path_agree, $filename_agree);
                $data['ah_agreement'] = $filename_agree;
            }

            DB::table('asign_homes')->where('id', $id)->update($data);

            $request->session()->flash( 'msg', 'update' );
            return redirect( 'view_asign_homes' );
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {


        $response= Asign_home::where( 'id', '=', $id )->delete();
        if ( $response ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $response,
            ] );
        }
    }
    public function getHomeByFloorId( Request $request ) {
        $floor_id = $request->id;
        $homes = Homes::where( [
            [ 'floor_id', '=', $floor_id ],
            // [ 'status', '=', 0 ]
        ] )->get();
        if ( $homes ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $homes,
            ] );
        }

    }
    public function searchCustomer( Request $request ) {
        $search = $request->term;
        $students = DB::table( 'customers' )
        ->select( 'customers.*')
        ->where( [
            [ 'cus_nic', 'LIKE', '%' . $search . '%' ],
            [ 'customers.status', '=', 0 ],
            [ 'customers.role_id', '=', 1 ],
        ] )
        ->get();
        $data = [];
        foreach ( $students as $key => $value ) {
            $data[] = [ 'id' => $value->id, 'value' => $value->cus_nic,
            'cus_name'=>$value->cus_name,'cus_email'=>$value->cus_email,

        ];
        }
        return response( $data );
    }
    public function viewAsignHomes() {
        return view( 'Admin.AsignHomes.view_asign_homes' );
    }
    public function getAllAsignHomesData() {
        $asignhomes = Asign_home::with('tower','floor','home','customer','types')->get();

        if ( $asignhomes ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $asignhomes,
            ] );
        }
    }


}
