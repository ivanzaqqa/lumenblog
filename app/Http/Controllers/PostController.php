<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
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
        $posts = Post::all();

        return response()->json([
            'success' => true,
            'message' => 'List All Post',
            'data' => $posts
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
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'All Fields Required!',
                'data' => $validator->errors(),
            ], 401);
        } else {
            $posts = Post::create([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
            ]);

            if ($posts) {
                return response()->json([
                    'success' => true,
                    'message' => 'Posts added successfully',
                    'data' => $posts,
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add Posts!',
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
        $posts = Post::find($id);

        if ($posts) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Posts',
                'data' => $posts
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Posts with id ' . $id . ' not found!'
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
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'All Fields Required!',
                'data' => $validator->errors(),
            ], 401);
        } else {
            $posts = Post::whereId($id)->update([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
            ]);

            if ($posts) {
                return response()->json([
                    'success' => true,
                    'message' => 'Posts updated successfully',
                    'data' => $posts,
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update Posts!',
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
        $posts = Post::whereId($id)->delete();

        if ($posts) {
            return response()->json([
                'success' => true,
                'message' => 'Posts deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post failed to delete',
            ], 400);
        }
    }
}
