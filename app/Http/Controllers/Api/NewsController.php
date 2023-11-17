<?php

namespace App\Http\Controllers\Api;

use App\Models\News;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Helpers\ResponseFormatter;

use App\Http\Controllers\Controller;

class NewsController extends Controller
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
        // get all news
        $news = News::all();

        // return success response
        return ResponseFormatter::success($news, 'Data news berhasil diambil');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate input
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'image_url' => 'required',
            'category' => 'required',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        // check validation
        if ($validator->fails()) {
            $message = $validator->getMessageBag()->first();

            return ResponseFormatter::error(null, $message, 500);
        }

        // create news
        $news = News::create($data);

        // return success response
        return ResponseFormatter::success($news, 'Data news berhasil ditambahkan', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // show news detail
        $news = News::find($id);

        // check news
        if (!$news) {
            return ResponseFormatter::error(null, 'Data news tidak ditemukan', 404);
        }

        // get category
        $news->category = $news->category()->first();

        // return success response
        return ResponseFormatter::success($news, 'Data news berhasil diambil');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validate input
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'image_url' => 'required',
            'category' => 'required',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        // check validation
        if ($validator->fails()) {
            $message = $validator->getMessageBag()->first();

            return ResponseFormatter::error(null, $message, 500);
        }

        $news = News::find($id);

        // check news
        if (!$news) {
            return ResponseFormatter::error(null, 'Data news tidak ditemukan', 404);
        }

        // update news
        $news->update($data);

        // return success response
        return ResponseFormatter::success($news, 'Data news berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // delete news
        $news = News::find($id);

        // check news
        if (!$news) {
            return ResponseFormatter::error(null, 'Data news tidak ditemukan', 404);
        }

        // delete news
        $news->delete();

        // return success response
        return ResponseFormatter::success(null, 'Data news berhasil dihapus');
    }

    /**
     * Search by keyword.
     */
    public function search(Request $request)
    {
        // get keyword
        $keyword = $request->keyword;

        // search news
        $news = News::where('title', 'like', "%$keyword%")
            ->orWhere('description', 'like', "%$keyword%")
            ->orWhere('content', 'like', "%$keyword%")
            ->orWhere('category', 'like', "%$keyword%")
            ->get();

        // return success response
        return ResponseFormatter::success($news, 'Data news berhasil dicari');
    }

    /**
     * Get news by category.
     */
    public function category(string $category)
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
        return ResponseFormatter::success($news, 'Data news berhasil dicari');
    }
}
