<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Aturan;
use App\Http\Resources\AturanResource;

class AturanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Aturan::latest()->get();
        return response()->json([AturanResource::collection($data), 'Aturans fetched.']);
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
            'nilaiKepastian' => 'required',
            'namaGejala' => 'required',
            'namaPenyakit' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $Aturan = Aturan::create([
            'nilaiKepastian' => $request->nilaiKepastian,
            'namaGejala' => $request->namaGejala,
            'namaPenyakit' => $request->namaPenyakit,
         ]);
        
        return response()->json(['Aturan created successfully.', new AturanResource($Aturan)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Aturan = Aturan::find($id);
        if (is_null($Aturan)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new AturanResource($Aturan)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aturan $Aturan)
    {
        $validator = Validator::make($request->all(),[
            'nilaiKepastian' => 'required',
            'namaGejala' => 'required',
            'namaPenyakit' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $Aturan->nilaiKepastian = $request->nilaiKepastian;
        $Aturan->namaGejala = $request->namaGejala;
        $Aturan->namaPenyakit = $request->namaPenyakit;
        $Aturan->save();
        
        return response()->json(['Aturan updated successfully.', new AturanResource($Aturan)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aturan $Aturan)
    {
        $Aturan->delete();

        return response()->json('Aturan deleted successfully');
    }
}
