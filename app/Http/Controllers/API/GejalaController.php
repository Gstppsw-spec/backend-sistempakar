<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Gejala;
use App\Http\Resources\GejalaResource;

class GejalaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Gejala::latest()->get();
        return response()->json([GejalaResource::collection($data), 'Gejalas fetched.']);
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
            'namaGejala' => 'required|string|max:255',
            'kodeGejala' => 'required',
            'kodeKategori' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $Gejala = Gejala::create([
            'namaGejala' => $request->namaGejala,
            'kodeGejala' => $request->kodeGejala,
            'kodeKategori' => $request->kodeKategori
         ]);
        
        return response()->json(['Gejala created successfully.', new GejalaResource($Gejala)]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Gejala = Gejala::find($id);
        if (is_null($Gejala)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new GejalaResource($Gejala)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gejala $Gejala)
    {
        $validator = Validator::make($request->all(),[
            'namaGejala' => 'required|string|max:255',
            'kodeGejala' => 'required',
            'kodeKategori' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $Gejala->namaGejala = $request->namaGejala;
        $Gejala->kodeGejala = $request->kodeGejala;
        $Gejala->kodeKategori = $request->kodeKategori;
        $Gejala->save();
        
        return response()->json(['Gejala updated successfully.', new GejalaResource($Gejala)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gejala $Gejala)
    {
        $Gejala->delete();

        return response()->json('Gejala deleted successfully');
    }
}