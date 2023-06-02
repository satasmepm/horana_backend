<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Towers;
use App\Models\Floors;
use App\Models\Homes;
use Validator;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        $towers = Towers::whereNotIn( 'status', [ 1 ] )->get();
        $floors = Floors::whereNotIn( 'status', [ 1 ] )->get();
        return view( 'Admin.Home.create_home', compact( 'towers', 'floors' ) );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {

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
            'home_number'=>'required',
        ], [
            'tower_id.required'=>'Tower name is required',
            'floor_id.required'=>'Floor name is required',
            'home_number.required'=>'Home number is required',

        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();

        } else {

            $home = new Homes;
            $home->tower_id = $request->get( 'tower_id' );
            $home->floor_id = $request->get( 'floor_id' );
            $home->home_number = $request->get( 'home_number' );

            $home->status = 0;
            $result = $home->save();

            // $path = storage_path( 'horana-heights-firebase-adminsdk-wffpx-5a7193f22c.json' );

            // // Read the contents of the service account JSON file
            // $json = file_get_contents( $path );

            // $serviceAccount = ServiceAccount::fromValue( $json );
            // $firebase = ( new Factory )->withServiceAccount( $serviceAccount );
            // $auth = $firebase->createAuth();
            // $signInResult = $auth->createUserWithEmailAndPassword( 'thilini.pab93@gmail.com', 'amerck@2018' );

            $request->session()->flash( 'msg', 'insert' );
            return redirect( 'view_homes' );
        }

    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id ) {
        $home = Homes::with( 'tower','floor' )->find( $id );
        return response()->json( [
            'status' =>'success',
            'data' => $home,

        ] );
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit( $id ) {
        $homes = Homes::with('tower','floor')->find( $id );
        $towers = Towers::whereNotIn( 'status', [ 1 ] )->get();
        $floors = Floors::whereNotIn( 'status', [ 1 ] )->get();
        return view( 'Admin.Home.update_home', compact( 'homes','towers','floors'));
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
            'home_number'=>'required',
        ], [
            'tower_id.required'=>'Tower name is required',
            'floor_id.required'=>'Floor name is required',
            'home_number.required'=>'Home number is required',
        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        } else {
            // $home = new Homes;
            // $home->tower_id = $request->get( 'tower_id' );
            // $home->floor_id = $request->get( 'floor_id' );
            // $home->home_number = $request->get( 'home_number' );
            // $home->status = 0;
            // $result = $home->save();

            $result = Homes::where( 'id', $id )->update( [
                'tower_id' => $request->get( 'tower_id' ),
                'floor_id' => $request->get( 'floor_id' ),
                'home_number' =>  $request->get( 'home_number' )
            ] );
            $request->session()->flash( 'msg', 'update' );
            return redirect( 'view_homes' );
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        $response= Homes::where( 'id', '=', $id )->delete();
        if ( $response ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $response,
            ] );
        }
    }

    public function viewHomes() {
        return view( 'Admin.Home.view_homes' );
    }

    public function getFloorByTowerId( Request $request ) {
        $tower_id = $request->id;
        $floors = Floors::where( [
            [ 'tower_id', '=', $tower_id ],
            // [ 'status', '=', 0 ]
        ] )->get();
        if ( $floors ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $floors,
            ] );
        }

    }

    public function getHome () {
        $homes = DB::table( 'homes' )
        ->join( 'towers', 'homes.tower_id', '=', 'towers.id' )
        ->join( 'floors', 'homes.floor_id', '=', 'floors.id' )
        ->select( 'homes.*', 'towers.tower_name', 'floors.floor_number' )
        ->where( [
            [ 'homes.status', '=', 0 ],
        ] )
        ->get();
        // $floors = Floors::with( 'tower' )->get();

        // return $floors;
        if ( $homes ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $homes,
            ] );
        }
    }

    public function installemt() {
        // Define constants
        define( 'PRINCIPLE_AMOUNT', 5000000 );
        define( 'DOWN_PAYMENT_MARGIN', 87000 );
        define( 'MAX_MONTHLY_INSTALLMENT_MARGIN', 16500 );
        define( 'INSTALLMENT_COUNT', 12 );
        define( 'SIX_MONTH_ADDITIONAL_AMOUNT', 260000 );
        define( 'TWELVE_MONTH_ADDITIONAL_AMOUNT', 99000 );
        $total = 0;
        // Input
        $paidAmount = 300000;
        // $array = [ 385000, 20000, 15000 ];
        // Calculate loan amount
        $loanAmount = $paidAmount - DOWN_PAYMENT_MARGIN;
        // Calculate monthly installment amount
        $monthlyInstallment = $loanAmount / INSTALLMENT_COUNT;
        $remainingAmount = $loanAmount;
        for ( $i = 1; $i <= INSTALLMENT_COUNT; $i++ ) {
            if ( $remainingAmount >= MAX_MONTHLY_INSTALLMENT_MARGIN ) {
                if ( $i == 6 ) {
                    if ( $remainingAmount <= ( MAX_MONTHLY_INSTALLMENT_MARGIN+SIX_MONTH_ADDITIONAL_AMOUNT ) ) {
                        $dd = $remainingAmount;
                    } else {
                        $dd =  ( MAX_MONTHLY_INSTALLMENT_MARGIN+SIX_MONTH_ADDITIONAL_AMOUNT );
                    }
                } else {
                    $dd =  MAX_MONTHLY_INSTALLMENT_MARGIN;
                }
            } else if ( $remainingAmount<MAX_MONTHLY_INSTALLMENT_MARGIN && $remainingAmount>0 ) {
                $dd = $remainingAmount;
            } else {
                $dd = 0;
            }
            $message = 'Installment  ' . $i .' : '.$dd. '<br>' . '';
            echo $message;

            if ( $remainingAmount >= MAX_MONTHLY_INSTALLMENT_MARGIN ) {
                if ( $i == 6 ) {
                    $remainingAmount -= ( MAX_MONTHLY_INSTALLMENT_MARGIN+SIX_MONTH_ADDITIONAL_AMOUNT );
                } else {
                    $remainingAmount -= MAX_MONTHLY_INSTALLMENT_MARGIN;
                }
            } else {
                $remainingAmount = 0;
            }
            $total += $dd;
            $available = PRINCIPLE_AMOUNT-( $total+$remainingAmount );
        }
        echo '<br>';
        echo '<br>';
        // echo 'ballance :' . $remainingAmount;
        echo '<br>';
        echo 'available :' . $available;
        // $message = 'Hello' . '<br>' . 'World!';
        // echo $message;
    }

}
