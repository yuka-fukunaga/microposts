<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\Validator;

class MicropostsController extends Controller
{
    //getでアクセスされた場合の一覧表示処理
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $microposts = $user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
        }
        
        return view('welcome', $data);
    }
    //新規登録処理
     public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);

        $request->user()->microposts()->create([
            'content' => $request->content,
        ]);

        return back();
    }
    //削除処理
    public function destroy($id)
    {
        $micropost = \App\Micropost::find($id);

        if (\Auth::id() === $micropost->user_id) {
            $micropost->delete();
        }

        return back();
    }
    
    //画像アップロード
    public function upload(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required|max:10240|image',
        ]);
        
    //上記のバリデーションがエラーの場合、ビューにバリデーション情報を渡す
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator); 
        }
    //s3に画像を保存。第一引数はs3のディレクトリ。第二引数は保存するファイル。
    //第三引数はファイルの公開設定。
    
        $file = $request->file('file');
        
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);

        $request->user()->microposts()->create([
            'content' => $request->content,
        ]);

        return redirect('/');
    }
    
}    
