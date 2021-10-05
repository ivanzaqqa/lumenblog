<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tags::all();

        $response = ['tags' => $tags];

        return response()->json([
            'success' => true,
            'message' => 'List All Categories',
            'data' => $tags
        ], 200);
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
        $validator = Validator::make($request->all(), [
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'All Fields Required!',
                'data' => $validator->errors(),
            ], 401);
        } else {
            $tags = Tags::create([
                'type' => $request->input('type'),
            ]);

            if ($tags) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tags added successfully',
                    'data' => $tags,
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add Tags!',
                ], 400);
            }
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
        $tags = Tags::find($id);

        if ($tags) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Tags',
                'data' => $tags
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tags with id ' . $id . ' not found!'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validator = Validator::make($request->all(), [
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'All Fields Required!',
                'data' => $validator->errors(),
            ], 401);
        } else {
            $tags = Tags::whereId($id)->update([
                'type' => $request->input('type'),
            ]);

            if ($tags) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tags updated successfully',
                    'data' => $tags,
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update Tags!',
                ], 400);
            }
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
        $tags = Tags::whereId($id)->delete();

        if ($tags) {
            return response()->json([
                'success' => true,
                'message' => 'Tags deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tags failed to delete',
            ], 400);
        }
    }
}
