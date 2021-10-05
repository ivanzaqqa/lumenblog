<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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
        $categories = Category::all();

        $response = ['categories' => $categories];

        return response()->json([
            'success' => true,
            'message' => 'List All Categories',
            'data' => $categories
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
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'All Fields Required!',
                'data' => $validator->errors(),
            ], 401);
        } else {
            $categories = Category::create([
                'name' => $request->input('name'),
            ]);

            if ($categories) {
                return response()->json([
                    'success' => true,
                    'message' => 'Categories added successfully',
                    'data' => $categories,
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add Categories!',
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
        $categories = Category::find($id);

        if ($categories) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Categories',
                'data' => $categories
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Categories with id ' . $id . ' not found!'
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
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'All Fields Required!',
                'data' => $validator->errors(),
            ], 401);
        } else {
            $categories = Category::whereId($id)->update([
                'name' => $request->input('name'),
            ]);

            if ($categories) {
                return response()->json([
                    'success' => true,
                    'message' => 'Categories updated successfully',
                    'data' => $categories,
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update Categories!',
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
        $categories = Category::whereId($id)->delete();

        if ($categories) {
            return response()->json([
                'success' => true,
                'message' => 'Categories deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Categories failed to delete',
            ], 400);
        }
    }
}
