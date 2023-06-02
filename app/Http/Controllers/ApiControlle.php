<?php

namespace App\Http\Controllers;

use App\Models\Asign_home;
use App\Models\Customers;
use App\Models\Floors;
use App\Models\Homes;
use App\Models\Notifications;
use App\Models\paymet_details;
use App\Models\Progress;
use App\Models\Rescheddule;
use App\Models\Settings;
use App\Models\Towers;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;

class ApiControlle extends Controller
{
    public function authCheck($userData)
    {
        $customer = Customers::where([
            ['cus_nic', '=', $userData['cus_nic']],
        ])->first();
        if ($customer != null) {
            if ($customer->status == 0) {
                if (!empty($customer) && Hash::check($userData['cus_nic'], $customer->cus_auth_token)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function loginCheck(Request $request)
    {
        $data = array(
            'username' => $request->get('username'),
            'password' => $request->get('password'),
        );
        $customer = Customers::where([
            ['cus_nic', '=', $data['username']],
        ])->first();
        if (!empty($customer) && Hash::check($data['password'], $customer->cus_password)) {
            if ($customer->status == 0) {
                $result = Customers::where('cus_nic', $data['username'])->update([
                    'cus_auth_token' => Hash::make($data['username']),
                ]);
                $customerUpdate = Customers::where([
                    ['cus_nic', '=', $data['username']],

                ])->first();
                return response()->json(['status' => 'success', 'code' => 200, 'data' => $customerUpdate, 'msg' => 'Login success.']);
            } else {
                return response()->json(['status' => 'error', 'code' => 400, 'msg' => 'User loked, Please contact administrator.']);
            }
        } else {
            return response()->json(['status' => 'error', 'code' => 400, 'msg' => 'Invalid username or password.']);
        }

    }
    public function uploadImage(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
        );
        if ($this->authCheck($userData)) {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagename = $userData['cus_nic'] . "cus_imgage" . 'cfimg.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/customers/');
                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true, true);
                }
                $image_resize = \Image::make($image->getRealPath())->save($destinationPath . $imagename);
                $image_resize = \Image::make($image->getRealPath())
                    ->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->save($destinationPath . $imagename, 50);

                Customers::where('cus_nic', $userData['cus_nic'])->update([
                    'cus_image' => $imagename,
                ]);
                $customerUpdate = Customers::where([
                    ['cus_nic', '=', $userData['cus_nic']],

                ])->first();
                return response()->json(['status' => 'success', 'data' => $customerUpdate, 'code' => 200]);
            } else {
                return response()->json(['error' => 'No file uploaded'], 400);
            }
            return response()->json(['status' => 'success', 'data' => $request->hasFile('image'), 'code' => 200]);

        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }
    }
    public function getAllProgress(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
            'home_id' => $request->get('home_id'),
        );
        if ($this->authCheck($userData)) {
            $asignhomes = Progress::with('tower', 'floor', 'home')->where('home_id', $request->get('home_id'))->get();
            return response()->json(['status' => 'success', 'data' => $asignhomes, 'code' => 200]);
        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }
    }

    public function getProgressById(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
            'pr_id' => $request->get('pr_id'),
        );
        if ($this->authCheck($userData)) {
            $asignhomes = Progress::find($request->get('pr_id'));
            // $asignhomes = DB::table( 'progress' )
            // ->where( 'id', $request->get( 'pr_id' ))
            // ->select( 'progress.*' )
            // ->get();
            return response()->json(['status' => 'success', 'data' => $asignhomes, 'code' => 200]);
        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }
    }
    public function getHomeByCustomerId(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
            'cus_id' => $request->get('cus_id'),
        );
        if ($this->authCheck($userData)) {
            $asignhomes = Asign_home::with('tower', 'floor', 'home', 'types', 'customer')->where('cus_id', $request->get('cus_id'))->first();
            return response()->json(['status' => 'success', 'data' => $asignhomes, 'code' => 200]);
        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }
    }
    public function getAllPaymentByHome(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
            'home_id' => $request->get('home_id'),
        );
        if ($this->authCheck($userData)) {
            $asignhomes = paymet_details::with('tower', 'floor', 'home')->where('home_id', $request->get('home_id'))->get();
            return response()->json(['status' => 'success', 'data' => $asignhomes, 'code' => 200]);
        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }
    }
    public function getPaymentById(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
            'pay_id' => $request->get('pay_id'),
        );
        if ($this->authCheck($userData)) {
            $asignhomes = paymet_details::find($request->get('pay_id'));
            // $asignhomes = DB::table( 'progress' )
            // ->where( 'id', $request->get( 'pr_id' ))
            // ->select( 'progress.*' )
            // ->get();
            return response()->json(['status' => 'success', 'data' => $asignhomes, 'code' => 200]);
        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }
    }

    public function installemtByHomeID(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
            'home_id' => $request->get('home_id'),
        );
        if ($this->authCheck($userData)) {
            $resheddule = Rescheddule::where('home_id', $request->home_id)->get();
            $rs_installment_amount = "0";
            $reschedduleData = Rescheddule::where('rs_installment_number', 1)->where('home_id', $request->home_id)->first();
            $myArray = array();
            $myCollection = collect($myArray);

            if ($reschedduleData !== null) {
                $rs_installment_amount = $reschedduleData->rs_installment_amount;
                $NORMAL_MONTHLY_INSTALLMENT_MARGIN = floatval($rs_installment_amount);
                define('SIXTH_MONTHLY_INSTALLMENT_MARGIN', 260000);
                define('TWELFTH_MONTHLY_INSTALLMENT_MARGIN', 115000);
                $paidAmount = 0;
                $payment = 0;
                $employees = paymet_details::where('home_id', $request->home_id)->get();
                $j = 1;
                $fractional = 0;
                $dd = 0;
                $remainingAmount = 0;
                for ($k = 0; $k < count($employees); $k++) {
                    $remainingAmount = $employees[$k]->pd_amount + $fractional;
                    $paidAmount = $remainingAmount - $NORMAL_MONTHLY_INSTALLMENT_MARGIN;
                    $payment = $employees[$k]->pd_amount;
                    $count = 0;
                    if ($NORMAL_MONTHLY_INSTALLMENT_MARGIN !== 0) {
                        $count = ($employees[$k]->pd_amount + $fractional) / $NORMAL_MONTHLY_INSTALLMENT_MARGIN;
                    } else {
                        $count = 0;
                    }
                    // $count = ( $employees[ $k ]->pd_amount + $fractional ) / $NORMAL_MONTHLY_INSTALLMENT_MARGIN;
                    for ($i = 1; $i <= $count + 1; $i++) {

                        if ($j == 6) {
                            $currentInstallmentMargin = (SIXTH_MONTHLY_INSTALLMENT_MARGIN + $NORMAL_MONTHLY_INSTALLMENT_MARGIN);
                        } elseif ($j == 12) {
                            $currentInstallmentMargin = TWELFTH_MONTHLY_INSTALLMENT_MARGIN;
                        } else {
                            $currentInstallmentMargin = $NORMAL_MONTHLY_INSTALLMENT_MARGIN;
                        }
                        if ($remainingAmount >= $currentInstallmentMargin) {
                            for ($x = 0; $x < count($resheddule); $x++) {
                                if (($j + 1) == $resheddule[$x]->rs_installment_number) {
                                    $NORMAL_MONTHLY_INSTALLMENT_MARGIN = floatval($resheddule[$x]->rs_installment_amount);
                                    break; // Exit the loop since the key was found
                                }
                            }
                            $balance = $remainingAmount - $currentInstallmentMargin;
                            $myCollection->push(array($j, 'Installment ' . $j, $currentInstallmentMargin, $remainingAmount, $balance, $employees[$k]->pd_collection_date, $payment));
                            $remainingAmount -= $currentInstallmentMargin;
                        } else if ($remainingAmount < $currentInstallmentMargin) {
                            $fractional = $remainingAmount;
                            $j--;
                        }
                        $payment = 0;
                        $j++;
                    }
                }
            } else {
                // Handle the case when $reschedduleData is null
                $myCollection->push(array('NO DATA'));
            }
            return response()->json(['status' => 'success', 'data' => $myCollection, 'code' => 200]);
        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }

    }

    public function getNotifications(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
        );
        if ($this->authCheck($userData)) {
            $asignhomes = Notifications::all();
            return response()->json(['status' => 'success', 'data' => $asignhomes, 'code' => 200]);
        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }
    }
    public function updateCustomerById(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
        );
        if ($this->authCheck($userData)) {
            $result = Customers::where('id', $request->get('cus_id'))->update([
                'cus_name' => $request->get('cus_name'),
                'cus_email' => $request->get('cus_email'),
            ]);
            if ($result > 0) {
                $customerUpdate = Customers::where([
                    ['id', '=', $request->get('cus_id')],
                ])->first();
                return response()->json(['status' => 'success', 'data' => $customerUpdate, 'code' => 200]);
            } else {
                return response()->json(['status' => 'failed', 'data' => 0, 'code' => 400]);
            }
        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }
    }
    public function getCustomerById(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
        );
        if ($this->authCheck($userData)) {
            $customerUpdate = Customers::where([
                ['id', '=', $request->get('cus_id')],
            ])->first();
            return response()->json(['status' => 'success', 'data' => $customerUpdate, 'code' => 200]);
        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }
    }
    public function getAllCustomers(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
        );
        if ($this->authCheck($userData)) {
            $searchQuery = $request->get('query'); // Get the search query
            $customerUpdate = Customers::where([
                ['status', '=', 0],
                ['role_id', '=', 1],
            ])->when($searchQuery, function ($query) use ($searchQuery) {
                // Apply the "like" query on the email or name field
                return $query->where(function ($query) use ($searchQuery) {
                    $query->where('cus_email', 'like', '%' . $searchQuery . '%')
                        ->orWhere('cus_nic', 'like', '%' . $searchQuery . '%');
                });
            })->get();
            return response()->json(['status' => 'success', 'data' => $customerUpdate, 'code' => 200]);
        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }
    }
    public function getAllFloors(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
        );
        if ($this->authCheck($userData)) {
            $searchQuery = $request->get('query'); // Get the search query
            $towers = Floors::where([
                ['status', '=', 0],
                ['tower_id', '=', $request->get('tower_id')],
            ])->when($searchQuery, function ($query) use ($searchQuery) {
                // Apply the "like" query on the email or name field
                return $query->where(function ($query) use ($searchQuery) {
                    $query->where('floor_number', 'like', '%' . $searchQuery . '%');
                });
            })->get();
            return response()->json(['status' => 'success', 'data' => $towers, 'code' => 200]);
        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }
    }
    public function getAllHomes(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
        );
        if ($this->authCheck($userData)) {
            $searchQuery = $request->get('query'); // Get the search query
            $homes = Homes::where([
                ['status', '=', 0],
                ['floor_id', '=', $request->get('floor_id')],
            ])->when($searchQuery, function ($query) use ($searchQuery) {
                // Apply the "like" query on the email or name field
                return $query->where(function ($query) use ($searchQuery) {
                    $query->where('home_number', 'like', '%' . $searchQuery . '%');
                });
            })->get();
            return response()->json(['status' => 'success', 'data' => $homes, 'code' => 200]);
        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }
    }
    public function getCustomerAsignHomeByHomeId(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
            'home_id' => $request->get('home_id'),
        );
        if ($this->authCheck($userData)) {
            $asignhomes = Asign_home::with('tower', 'floor', 'home', 'types', 'customer')->where('home_id', $request->get('home_id'))->first();
            return response()->json(['status' => 'success', 'data' => $asignhomes, 'code' => 200]);
        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }
    }
    public function isAvailableHome(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
            'home_id' => $request->get('home_id'),
        );
        if ($this->authCheck($userData)) {
            $asignhomes = Asign_home::where('home_id', $request->get('home_id'))->exists();
            return response()->json(['status' => 'success', 'data' => $asignhomes, 'code' => 200]);
        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }
    }
    public function getAllTowers(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
        );
        if ($this->authCheck($userData)) {
            $asignhomes = Towers::get();
            return response()->json(['status' => 'success', 'data' => $asignhomes, 'code' => 200]);
        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }
    }
    public function getHomeScreenCardData(Request $request)
    {
        $userData = array(
            'cus_nic' => $request->get('cus_nic'),
        );
        if ($this->authCheck($userData)) {
            $down_payment = 0;
            $present_val = 0;
            $remaining_payment = 0;
            $sum = 0;
            $asignhomes = Asign_home::where('home_id', $request->home_id)->where('cus_id', $request->cus_id)->first();
            $sum = paymet_details::where('home_id', $request->home_id)->where('cus_id', $request->cus_id)->sum('pd_amount');
            $settingsdata = Settings::where('id', 1)->first();

            if ($asignhomes != null) {
                $down_payment = $asignhomes->ah_down_payment;
            }
            if ($sum != null) {
                $remaining_payment = $settingsdata->set_principle_amount - $sum - $down_payment;
                $present_val = round(($sum / $settingsdata->set_principle_amount) * 100, 0);
            }
            return response()->json(['status' => 'success', 'data' =>
                [
                    "down_payment" => $down_payment,
                    "remaining_payment" => $remaining_payment,
                    "present_val" => $present_val,
                ]
                , 'code' => 200]);

        } else {
            return response()->json(['status' => 'authentication error', 'code' => 400]);
        }
    }

}
