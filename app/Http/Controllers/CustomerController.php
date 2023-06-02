<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Validator;
use App\Models\Customers;
use PDF;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;



use Kreait\Firebase\Auth;
use Kreait\Firebase\Auth\UserRecord;

// Path to the service account JSON file




// $auth = $factory->createAuth();
class CustomerController extends Controller {
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


        // $auth = $firebase->getAuth();
        // $factory->singleton(Auth::class, function () use ($auth) {
        //     return $auth;
        // });



        // $customToken = '0Vmohy1ASd6c55KFH3vM1';

        // try {
        //     $signInResult = $auth->signInWithCustomToken($customToken);
        //     $userRecord = $auth->getUser($signInResult->idToken());
        //     // User authenticated successfully
        // } catch (Exception $e) {
        //     // Authentication failed
        // }

        return view( 'Admin.Customer.customer' );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        return dd();
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {

        $validator = validator::make( $request->all(), [
            'cus_name'=>'required',
            'cus_nic'=>'required',
            'cus_address'=>'required',
            'cus_phone'=>'required|numeric|digits:10',
        ], [
            'cus_name.required'=>'Customer name is required',
            'cus_nic.required'=>'Customer NIC is required',
            'cus_address.required'=>'Customer address is required',
            'cus_phone.required'=>'Customer Mobile number is required',

        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();

        } else {
            $customer = new Customers;
            $customer->cus_name = $request->get( 'cus_name' );
            $customer->cus_nic = $request->get( 'cus_nic' );
            $customer->cus_address = $request->get( 'cus_address' );
            $customer->cus_phone = $request->get( 'cus_phone' );
            $customer->cus_email = $request->get( 'cus_email' );
            $customer->cus_password = Hash::make($request->get( 'cus_phone' ));
            $customer->role_id = 1;
            $customer->status = 0;
            $result = $customer->save();

            // $path = storage_path('horana-heights-firebase-adminsdk-wffpx-5a7193f22c.json');

            // // Read the contents of the service account JSON file
            // $json = file_get_contents($path);

            // $serviceAccount = ServiceAccount::fromValue($json);
            // $firebase = (new Factory)->withServiceAccount($serviceAccount);
            // $auth = $firebase->createAuth();
            // $signInResult = $auth->createUserWithEmailAndPassword("thilini.pab93@gmail.com", "amerck@2018");

            $request->session()->flash( 'msg', 'insert' );
            return redirect( 'view_customers' );
        }

    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id ) {
        $employee = Customers::find( $id );
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
        $customer = Customers::find( $id );
        return view( 'Admin.Customer.update_customer', compact( 'customer' ) );

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
            'cus_name'=>'required',
            'cus_nic'=>'required',
            'cus_address'=>'required',
            'cus_phone'=>'required|numeric|digits:10',
        ], [
            'cus_name.required'=>'Customer name is required',
            'cus_nic.required'=>'Customer NIC is required',
            'cus_address.required'=>'Customer address is required',
            'cus_phone.required'=>'Customer Mobile number is required',

        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();

        } else {
            $checkbox=$request->get( 'checkbox-data' );
            if($checkbox=="on"){
                $status=0;
            }else{
                $status=1;
            }

            $result = Customers::where( 'id', $id )->update( [
                'cus_name' => $request->cus_name,
                'cus_nic' => $request->cus_nic,
                'cus_address' => $request->cus_address,
                'cus_phone' => $request->cus_phone,
                'cus_email' => $request->cus_email,
                'status' => $status,
            ] );

            $request->session()->flash( 'msg', 'update' );
            return redirect( 'view_customers' );
        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        $response = Customers::where( 'id', $id )->update( [
            'status' => 1,

        ] );
        if ( $response ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $response,
            ] );
        }

    }

    public function viewCustomers() {

        return view( 'Admin.Customer.view_customers' );
    }

    public function getEmployee() {
        $employees = Customers::get();

        if ( $employees ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $employees,
            ] );
        }
    }

    public function viewPdf() {

        $datas = Customers::find( 31 );
        return view( 'Admin.preview', compact( 'datas' ) );

    }


    //////////////////////////////api/////////////////////////////////


    public function loginCheck( Request $request ) {
        $data = array(
            'username'  	=>   $request->get( 'username' ),
            'password' 	=>   $request->get( 'password' ),
        );

        $customer = Customers::where( [
            [ 'cus_nic', '=', $data[ 'username' ] ],

        ] )->first();
    if(!empty( $customer ) && Hash::check($data[ 'password' ], $customer->cus_password)){

            if ( $customer->status == 0 ) {

                    $result = Customers::where( 'cus_nic',  $data[ 'username' ] )->update( [
                        'cus_auth_token'=>Hash::make($data[ 'username' ])
                    ] );
                 $customerUpdate = Customers::where( [
                    [ 'cus_nic', '=', $data[ 'username' ] ],

                ] )->first();
                return response()->json( [ 'status' => 'success','code'=>200, 'data'=>$customerUpdate, 'msg'=>'Login success.' ] );
            } else {
                return response()->json( [ 'status' => 'error','code'=>400, 'msg'=>'User loked, Please contact administrator.' ] );
            }
        } else {
            return response()->json( [ 'status' => 'error','code'=>400, 'msg'=>'Invalid username or password.' ] );
        }

    }
}
