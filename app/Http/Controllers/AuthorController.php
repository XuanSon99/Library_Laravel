<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Validator;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Author::orderBy('created_at', 'DESC')->get();
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
            // 'author_id' => 'required|unique:authors',
            'name' => 'required|string',
            'note' => 'required|string',
        ]);
        if ($validate->fails()) {
            return response()->json(["status" => false, "error" => $validate->errors()], 400);
        }
        Author::create($request->all());
        return response()->json(["status" => true, "data" => $request->all()], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        // return Author::find($author->author_id)->getDoc->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $validate = Validator::make($request->all(), [
            // 'author_id' => 'required',
            'name' => 'required|string',
            'note' => 'required|string',
        ]);
        if ($validate->fails()) {
            return response()->json(["status" => false, "error" => $validate->errors()], 400);
        }
        $author->update($request->all());
        return response()->json(["status" => true, "data" => $request->all()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return response()->json(["status" => true], 200);
    }
}
