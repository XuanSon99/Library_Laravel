<?php

namespace App\Http\Controllers;

use App\Models\TypeMark;
use Illuminate\Http\Request;
use Validator;

class TypeMarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TypeMark::orderBy('created_at', 'DESC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "name" => 'required|string',
            "note" => 'required|string'
        ]);
        if ($validate->fails()) {
            return response()->json(["status" => false, "error" => $validate->errors()], 400);
        }
        TypeMark::create($request->all());
        return response()->json(["status" => true, "data" => $request->all()], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeMark  $TypeMark
     * @return \Illuminate\Http\Response
     */
    public function show(TypeMark $TypeMark)
    {
        return $TypeMark;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeMark  $TypeMark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeMark $TypeMark)
    {
        $validate = Validator::make($request->all(), [
            "name" => 'required|string',
            "note" => 'required|string'
        ]);
        if ($validate->fails()) {
            return response()->json(["status" => false, "error" => $validate->errors()], 400);
        }
        $TypeMark->update($request->all());
        return response()->json(["status" => true, "data" => $request->all()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeMark  $TypeMark
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeMark $TypeMark)
    {
        $TypeMark->delete();
        return response()->json(["status" => true], 200);
    }
}
