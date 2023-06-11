<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Models\Blog;

class AdminBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ブログ一覧画面を表示
        $blogs = Blog::all();
        // resources/views/admin/blogs/index.blade.phpを描画
        return view('admin.blogs.index', ['blogs' => $blogs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ブログ登録画面を表示
        // resources/views/admin/blogs/create.blade.phpを描画
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        // ①fillとsaveメソッドを使用して保存する場合
        // インスタンスを作成してから、fillメソッドで値を代入する
        // $saveImagePath = $request->file('image')->store('blogs', 'public'); // 画像を保存
        // $blogs = new Blog($request->validated());
        // $blogs->image = $saveImagePath;
        // $blogs->save();

        // ②createメソッドを使用して保存する場合
        // createメソッドは、インスタンスを作成して保存する処理を一括で行う
        $validated = $request->validated();
        $validated['image'] = $request->file('image')->store('blogs', 'public');
        Blog::create($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'ブログを登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
