<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Penyakit;
use App\Http\Resources\PenyakitResource;

class PenyakitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Penyakit::latest()->get();
        return response()->json([PenyakitResource::collection($data), 'Penyakit fetched.']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'code' => 'required|string|max:255',
            'namaPenyakit' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $penyakit = Penyakit::create([
            'code' => $request->code,
            'namaPenyakit' => $request->namaPenyakit
         ]);
        
        return response()->json(['Penyakit created successfully.', new PenyakitResource($penyakit)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penyakit = Penyakit::find($id);
        if (is_null($penyakit)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new PenyakitResource($penyakit)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penyakit $penyakit)
    {
        $validator = Validator::make($request->all(),[
            'code' => 'required|string|max:255',
            'namaPenyakit' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $penyakit->code = $request->code;
        $penyakit->namaPenyakit = $request->namaPenyakit;
        $penyakit->save();
        
        return response()->json(['Penyakit updated successfully.', new PenyakitResource($penyakit)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penyakit $penyakit)
    {
        $penyakit->delete();

        return response()->json('Program deleted successfully');
    }
}