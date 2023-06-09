<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Cat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AdminBlogController extends Controller
{
    # コンストラクタ
    public function __construct()
    {
        // ミドルウェアを使用して、コントローラーのアクションを実行する前に、ユーザーが認証されているかどうかを確認する。
        // $requestと$nextパラメータを持つ無名ミドルウェア関数を定義する
        $this->middleware(function ($request, $next) {
        // 認証されたユーザーオブジェクトを$this->userプロパティーにセットする
            $this->user = Auth::user();
            // 更新された$requestインスタンスを使用して、パイプライン内の次のミドルウェアを呼び出す。
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ブログ一覧画面を表示
        $blogs = Blog::latest('updated_at')->paginate(10);
        // resources/views/admin/blogs/index.blade.phpを描画
        return view('admin.blogs.index', ['blogs' => $blogs, 'user' => $this->user]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ブログ登録画面を表示
        // resources/views/admin/blogs/create.blade.phpを描画
        return view('admin.blogs.create', ['user' => $this->user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        // ブログ作成処理

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
    // public function edit(int $id)
    public function edit(Blog $blog) // ルートモデルバインディングを使用する場合は、引数にモデルを指定する
    {
        // ブログ編集画面を表示
        // $blog = Blog::findorFail($id); // ルートモデルバインディングを使用する場合は、findorFailメソッドは不要

        $categories = Category::all();
        $cats = Cat::all();
        return view('admin.blogs.edit', ['blog' => $blog, 'categories' => $categories, 'cats' => $cats, 'user' => $this->user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, int $id)
    {
        // ブログ更新処理
        $blog = Blog::findorFail($id);
        $updateData = $request->validated();

        // 画像を変更する場合の処理
        if ($request->has('image')) {
            // 変更前の画像を削除
            Storage::disk('public')->delete($blog->image);
            // 変更後の画像をアップロード
            $updateData['image'] = $request->file('image')->store('blogs', 'public'); // storeメソッドで画像を保存し、保存した画像のパスが返ってくるので、それを$updateData['image']に代入
        }

        $blog->category()->associate($updateData['category_id']); // associateメソッドで、$updateData['category_id']の値をcategory_idカラムに保存
        // $blog->cats()->attach($updateData['cats']); // attachメソッドだと、同じ値を複数回保存できないので、syncメソッドを使用しなければならない
        $blog->cats()->sync($updateData['cats'] ?? []) ; // syncメソッドは、同じ値を複数回保存できる。また、null合体演算子によって、値がない場合は、空の配列を代入する
        $blog->update($updateData);
        return redirect()->route('admin.blogs.index')->with('success', 'ブログを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // ブログ削除処理
        $blog = Blog::findorFail($id);
        $blog->delete();
        Storage::disk('public')->delete($blog->image);

        return to_route('admin.blogs.index')->with('success', 'ブログを削除しました');
    }
}
