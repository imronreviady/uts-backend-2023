<?php

namespace App\Http\Controllers\Api;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Helpers\ResponseFormatter;

use App\Http\Controllers\Controller;

class NewsController extends Controller
{
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
}
