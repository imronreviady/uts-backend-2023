<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Helpers\ResponseFormatter;

use App\Models\Category;

use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        request()->headers->set("Accept", "application/json");
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all category
        $category = Category::all();

        // return success response
        return ResponseFormatter::success($category, 'Data category berhasil diambil');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate input
        $rules = [
            'name' => 'required',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        // check validation
        if ($validator->fails()) {
            $message = $validator->getMessageBag()->first();

            return ResponseFormatter::error(null, $message, 500);
        }

        // create slug
        $slug = Str::slug($request->name);
        
        // create category
        $category = Category::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        // return success response
        return ResponseFormatter::success($category, 'Data category berhasil ditambahkan', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // show category detail
        $category = Category::find($id);

        // check if category not found
        if (!$category) {
            return ResponseFormatter::error(null, 'Data category tidak ditemukan', 404);
        }

        // return success response
        return ResponseFormatter::success($category, 'Data category berhasil diambil');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // show category detail
        $category = Category::find($id);

        // check if category not found
        if (!$category) {
            return ResponseFormatter::error(null, 'Data category tidak ditemukan', 404);
        }

        // validate input
        $rules = [
            'name' => 'required',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        // check validation
        if ($validator->fails()) {
            $message = $validator->getMessageBag()->first();

            return ResponseFormatter::error(null, $message, 500);
        }

        // create slug
        $slug = Str::slug($request->name);

        // update category
        $category->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        // return success response
        return ResponseFormatter::success($category, 'Data category berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // show category detail
        $category = Category::find($id);

        // check if category not found
        if (!$category) {
            return ResponseFormatter::error(null, 'Data category tidak ditemukan', 404);
        }

        // delete category
        $category->delete();

        // return success response
        return ResponseFormatter::success(null, 'Data category berhasil dihapus');
    }

    /**
     * Search by keyword.
     */
    public function search(string $keyword)
    {
        // search category by keyword
        $category = Category::where('name', 'like', '%' . $keyword . '%')->get();

        // return success response
        return ResponseFormatter::success($category, 'Data category berhasil dicari');
    }

    /**
     * Get news by category.
     */
    public function news(string $category)
    {
        // get category
        $category = Category::where('slug', $category)->first();

        // check if category not found
        if (!$category) {
            return ResponseFormatter::error(null, 'Data category tidak ditemukan', 404);
        }

        // get news by category
        $news = $category->news()->get();

        // return success response
        return ResponseFormatter::success($news, 'Data news berhasil diambil');
    }
}
