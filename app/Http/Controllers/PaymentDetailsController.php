<?php

namespace App\Http\Controllers;
use App\Models\paymet_details;
use Validator;
use App\Models\Towers;
use App\Models\Floors;
use App\Models\Homes;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PaymentDetailsController extends Controller {
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
        return view( 'Admin.Payments.create_payments', compact( 'towers', 'floors', 'homes' ) );
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
            'cus_email'=>'required|email',
            'pay_date'=>'required',
            'pay_amount'=>'required',

        ], [
            'tower_id.required'=>'Tower name is required',
            'floor_id.required'=>'Floor name is required',
            'home_id.required'=>'Home name is required',
            'cus_nic.required'=>'Customer NIC number is required',
            'cus_name.required'=>'Customer name is required',
            'cus_email.required'=>'Custome email is required',
            'pay_date.required'=>'Pay date is required',
            'pay_amount.required'=>'Payment amount is required',
        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        } else {
            $data = [
                'pd_collection_date' => $request->pay_date,
                'pd_amount' =>$request->pd_amount,
                'tower_id' => $request->tower_id,
                'floor_id' => $request->floor_id,
                'home_id' => $request->home_id,
                'cus_id' => $request->cus_id,
                'pd_amount' => $request->pay_amount,
                'status' => 0,

            ];
            // $time = time();
            if ( $request->hasFile( 'pay_slip' ) ) {
                $file = $request->file( 'pay_slip' );
                $filename = $file->getClientOriginalName();
                $path = public_path( '/uploads/payments/' );
                if ( !File::isDirectory( $path ) ) {
                    File::makeDirectory( $path, 0777, true, true );
                }
                $file->move( $path, $filename );
                $data[ 'pd_recipt' ] = $filename;
            } else {
                $filename = '';
            }

            $paymentDetail = paymet_details::create( $data );
            $request->session()->flash( 'msg', 'insert' );
            return redirect( 'view_payments' );
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id ) {
        $employee = paymet_details::with( 'tower', 'floor', 'home', 'customer' )->find( $id );
        return response()->json( [
            'status' =>'success',
            'data' => $employee,

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
        $floors = Floors::whereNotIn( 'status', [ 1 ] )->get();
        $homes = Homes::whereNotIn( 'status', [ 1 ] )->get();

        $payments = paymet_details::with( 'tower', 'floor', 'home', 'customer' )->find( $id );
        return view( 'Admin.Payments.update_payments', compact( 'payments', 'towers', 'floors', 'homes' ) );
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
            'cus_email'=>'required|email',
            'pay_date'=>'required',
            'pay_amount'=>'required',

        ], [
            'tower_id.required'=>'Tower name is required',
            'floor_id.required'=>'Floor name is required',
            'home_id.required'=>'Home name is required',
            'cus_nic.required'=>'Customer NIC number is required',
            'cus_name.required'=>'Customer name is required',
            'cus_email.required'=>'Custome email is required',
            'pay_date.required'=>'Pay date is required',
            'pay_amount.required'=>'Payment amount is required',
        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        } else {
            $data = [
                'pd_collection_date' => $request->pay_date,
                'pd_amount' =>$request->pd_amount,
                'tower_id' => $request->tower_id,
                'floor_id' => $request->floor_id,
                'home_id' => $request->home_id,
                'cus_id' => $request->cus_id,
                'pd_amount' => $request->pay_amount,
                'status' => 0,
            ];
            if ( $request->hasFile( 'pay_slip' ) ) {
                $file = $request->file( 'pay_slip' );
                $filename = $file->getClientOriginalName();
                $path = public_path( '/uploads/payments/' );
                if ( !File::isDirectory( $path ) ) {
                    File::makeDirectory( $path, 0777, true, true );
                }
                $file->move( $path, $filename );
                $data[ 'pd_recipt' ] = $filename;
            }

            DB::table('paymet_details')->where('id', $id)->update($data);

            $request->session()->flash( 'msg', 'update' );
            return redirect( 'view_payments' );
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        $response= paymet_details::where( 'id', '=', $id )->delete();
        if ( $response ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $response,
            ] );
        }
    }

    public function installemt() {
        $myArray = array();
        $myCollection = collect( $myArray );
        define( 'NORMAL_MONTHLY_INSTALLMENT_MARGIN', 16500 );
        define( 'SIXTH_MONTHLY_INSTALLMENT_MARGIN', 260000 );
        define( 'TWELFTH_MONTHLY_INSTALLMENT_MARGIN', 115000 );
        $paidAmount = 0;
        $payment = 0;
        $employees = paymet_details::get();
        $j = 1;
        $fractional = 0;
        $dd = 0;
        $remainingAmount = 0;
        for ( $k = 0; $k < count( $employees );$k++ ) {
            $remainingAmount = $employees[ $k ]->pd_amount + $fractional;
            $paidAmount = $remainingAmount - NORMAL_MONTHLY_INSTALLMENT_MARGIN;
            $payment = $employees[ $k ]->pd_amount;
            $count = ( $employees[ $k ]->pd_amount + $fractional ) / NORMAL_MONTHLY_INSTALLMENT_MARGIN;
            for ( $i = 1; $i <= $count + 1; $i++ ) {
                if ( $j == 6 ) {
                    $currentInstallmentMargin = ( SIXTH_MONTHLY_INSTALLMENT_MARGIN+NORMAL_MONTHLY_INSTALLMENT_MARGIN );
                } elseif ( $j == 12 ) {
                    $currentInstallmentMargin = TWELFTH_MONTHLY_INSTALLMENT_MARGIN;
                } else {
                    $currentInstallmentMargin = NORMAL_MONTHLY_INSTALLMENT_MARGIN;
                }
                if ( $remainingAmount >= $currentInstallmentMargin ) {
                    $balance = $remainingAmount-$currentInstallmentMargin;
                    $myCollection->push( array( $j, 'Installment '.$j, $currentInstallmentMargin, $remainingAmount, $balance, $employees[ $k ]->pd_collection_date, $payment ) );
                    $remainingAmount -= $currentInstallmentMargin;
                } else if ( $remainingAmount < $currentInstallmentMargin ) {
                    $fractional = $remainingAmount;
                    $j--;
                }
                $payment = 0;
                $j++;
            }
        }

        // return response()->json( $myCollection );
        $towers = Towers::whereNotIn( 'status', [ 1 ] )->get();
        $floors = Floors::whereNotIn( 'status', [ 1 ] )->get();
        $homes = Homes::whereNotIn( 'status', [ 1 ] )->get();

        return  view( 'Admin.Installment.installment', compact( 'myCollection', 'towers', 'floors', 'homes' ) );
    }
    public function installemtByHome(Request $request) {
        $myArray = array();
        $myCollection = collect( $myArray );
        define( 'NORMAL_MONTHLY_INSTALLMENT_MARGIN', 16500 );
        define( 'SIXTH_MONTHLY_INSTALLMENT_MARGIN', 260000 );
        define( 'TWELFTH_MONTHLY_INSTALLMENT_MARGIN', 115000 );
        $paidAmount = 0;
        $payment = 0;
        $employees = paymet_details::where('home_id', $request->home_id)->get();
        $j = 1;
        $fractional = 0;
        $dd = 0;
        $remainingAmount = 0;
        for ( $k = 0; $k < count( $employees );$k++ ) {
            $remainingAmount = $employees[ $k ]->pd_amount + $fractional;
            $paidAmount = $remainingAmount - NORMAL_MONTHLY_INSTALLMENT_MARGIN;
            $payment = $employees[ $k ]->pd_amount;
            $count = ( $employees[ $k ]->pd_amount + $fractional ) / NORMAL_MONTHLY_INSTALLMENT_MARGIN;
            for ( $i = 1; $i <= $count + 1; $i++ ) {
                if ( $j == 6 ) {
                    $currentInstallmentMargin = ( SIXTH_MONTHLY_INSTALLMENT_MARGIN+NORMAL_MONTHLY_INSTALLMENT_MARGIN );
                } elseif ( $j == 12 ) {
                    $currentInstallmentMargin = TWELFTH_MONTHLY_INSTALLMENT_MARGIN;
                } else {
                    $currentInstallmentMargin = NORMAL_MONTHLY_INSTALLMENT_MARGIN;
                }
                if ( $remainingAmount >= $currentInstallmentMargin ) {
                    $balance = $remainingAmount-$currentInstallmentMargin;
                    $myCollection->push( array( $j, 'Installment '.$j, $currentInstallmentMargin, $remainingAmount, $balance, $employees[ $k ]->pd_collection_date, $payment ) );
                    $remainingAmount -= $currentInstallmentMargin;
                } else if ( $remainingAmount < $currentInstallmentMargin ) {
                    $fractional = $remainingAmount;
                    $j--;
                }
                $payment = 0;
                $j++;
            }
        }

        // return response()->json( $myCollection );
        $towers = Towers::whereNotIn( 'status', [ 1 ] )->get();
        $floors = Floors::whereNotIn( 'status', [ 1 ] )->get();
        $homes = Homes::whereNotIn( 'status', [ 1 ] )->get();

        return  view( 'Admin.Installment.installment', compact( 'myCollection', 'towers', 'floors', 'homes' ) );

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

    public function getCustomerByHomeId( Request $request ) {
        $floor_id = $request->id;
        $customers =  DB::table( 'asign_homes' )
        ->join( 'homes', 'asign_homes.home_id', '=', 'homes.id' )
        ->join( 'customers', 'asign_homes.cus_id', '=', 'customers.id' )
        ->where( 'asign_homes.home_id', $floor_id )
        ->select( 'asign_homes.*', 'homes.id as home_id', 'homes.home_number', 'customers.id as cus_id', 'customers.cus_name', 'customers.cus_nic', 'customers.cus_email' )
        ->get()->all();

        if ( $customers ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $customers,
            ] );
        } else {
            return response()->json( [
                'status' =>'error',
                'code'=>200,
                'data' =>-1,
            ] );
        }

    }

    public function getPaymentsData () {
        $homes = DB::table( 'paymet_details' )
        ->join( 'towers', 'paymet_details.tower_id', '=', 'towers.id' )
        ->join( 'floors', 'paymet_details.floor_id', '=', 'floors.id' )
        ->join( 'homes', 'paymet_details.home_id', '=', 'homes.id' )
        ->join( 'customers', 'paymet_details.cus_id', '=', 'customers.id' )
        ->select( 'paymet_details.*', 'towers.tower_name', 'floors.floor_number', 'homes.home_number', 'customers.cus_name' )
        ->where( [
            [ 'paymet_details.status', '=', 0 ],
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

    public function viewPayments() {
        return view( 'Admin.Payments.view_payments' );
    }
    public function resheddule() {
        $towers = Towers::whereNotIn( 'status', [ 1 ] )->get();
        $floors = Floors::whereNotIn( 'status', [ 1 ] )->get();
        $homes = Homes::whereNotIn( 'status', [ 1 ] )->get();

        return  view( 'Admin.Installment.rescheddule', compact( 'towers', 'floors', 'homes' ) );
    }

    public function reshedduleByHome(Request $request) {

        $resheddule = Rescheddule::where('home_id', $request->home_id)->get();

        $towers = Towers::whereNotIn( 'status', [ 1 ] )->get();
        $floors = Floors::whereNotIn( 'status', [ 1 ] )->get();
        $homes = Homes::whereNotIn( 'status', [ 1 ] )->get();

        return $resheddule;
        return  view( 'Admin.Installment.installment', compact( 'myCollection', 'towers', 'floors', 'homes' ) );

    }
}
