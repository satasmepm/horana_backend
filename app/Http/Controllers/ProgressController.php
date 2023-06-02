<?php

namespace App\Http\Controllers;
use App\Models\Towers;
use App\Models\Floors;
use App\Models\Homes;
use App\Models\Progress;
use Illuminate\Http\Request;
use Validator;
use File;
use Illuminate\Support\Facades\DB;
class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $towers = Towers::whereNotIn( 'status', [ 1 ] )->get();
        $floors = Floors::whereNotIn( 'status', [ 1 ] )->get();
        $homes = Homes::whereNotIn( 'status', [ 1 ] )->get();

        return view( 'Admin.Progress.create_progress', compact( 'towers', 'floors', 'homes' )  );
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
            'tower_id'=>'required',
            'floor_id'=>'required',
            'home_id'=>'required',
            'pr_date'=>'required',
            'pr_remark'=>'required',
            'pr_image'=>'required',

        ], [
            'tower_id.required'=>'Tower name is required',
            'floor_id.required'=>'Floor name is required',
            'home_id.required'=>'Home name is required',
            'pr_date.required'=>'Date is required',
            'pr_remark.required'=>'Remark is required',
            'pr_image.required'=>'Image is required',

        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        } else {
            $data = [
                'pr_date' => $request->pr_date,
                'pr_remark' =>$request->pr_remark,
                'tower_id' => $request->tower_id,
                'floor_id' => $request->floor_id,
                'home_id' => $request->home_id,
                'status' => 0,

            ];
            // $time = time();
            if ( $request->hasFile( 'pr_image' ) ) {
                $file = $request->file( 'pr_image' );
                $filename = $file->getClientOriginalName();
                $path = public_path( '/uploads/progress/' );
                if ( !File::isDirectory( $path ) ) {
                    File::makeDirectory( $path, 0777, true, true );
                }
                $file->move( $path, $filename );
                $data[ 'pr_image' ] = $filename;
            } else {
                $filename = '';
            }

            $progress = Progress::create( $data );
            $request->session()->flash( 'msg', 'insert' );
            return redirect( 'view_progress' );
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
        $progress = Progress::with('tower','floor','home')->find( $id );
        return response()->json( [
            'status' =>'success',
            'data' => $progress,

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
        $towers = Towers::whereNotIn( 'status', [ 1 ] )->get();
        $floors = Floors::whereNotIn( 'status', [ 1 ] )->get();
        $homes = Homes::whereNotIn( 'status', [ 1 ] )->get();

        $progress = Progress::with( 'tower', 'floor', 'home' )->find( $id );
        return view( 'Admin.Progress.update_progress', compact( 'progress', 'towers', 'floors', 'homes' ) );
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
            'tower_id'=>'required',
            'floor_id'=>'required',
            'home_id'=>'required',
            'pr_date'=>'required',
            'pr_remark'=>'required',
            // 'pr_image'=>'required',

        ], [
            'tower_id.required'=>'Tower name is required',
            'floor_id.required'=>'Floor name is required',
            'home_id.required'=>'Home name is required',
            'pr_date.required'=>'Date is required',
            'pr_remark.required'=>'Remark is required',
            // 'pr_image.required'=>'Image is required',

        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        } else {
            $data = [
                'pr_date' => $request->pr_date,
                'pr_remark' =>$request->pr_remark,
                'tower_id' => $request->tower_id,
                'floor_id' => $request->floor_id,
                'home_id' => $request->home_id,
                'status' => 0,

            ];
            // $time = time();
            if ( $request->hasFile( 'pr_image' ) ) {
                $file = $request->file( 'pr_image' );
                $filename = $file->getClientOriginalName();
                $path = public_path( '/uploads/progress/' );
                if ( !File::isDirectory( $path ) ) {
                    File::makeDirectory( $path, 0777, true, true );
                }
                $file->move( $path, $filename );
                $data[ 'pr_image' ] = $filename;
            } else {
                $filename = '';
            }
            DB::table('progress')->where('id', $id)->update($data);
            // $progress = Progress::create( $data );
            $request->session()->flash( 'msg', 'update' );
            return redirect( 'view_progress' );
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
        $response= Progress::where( 'id', '=', $id )->delete();
        if ( $response ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $response,
            ] );
        }
    }
    public function viewProgress() {
        return view( 'Admin.Progress.view_progress' );
    }
    public function getAllProgressData() {
        $asignhomes = Progress::with('tower','floor','home')->get();

        if ( $asignhomes ) {
            return response()->json( [
                'status' =>'success',
                'code'=>200,
                'data' => $asignhomes,
            ] );
        }
    }
}
