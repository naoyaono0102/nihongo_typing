<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //追加
use App\User; //追加
use App\Drill; //追加
use App\Question; //追加
use Hash; //追加

class AccountsController extends Controller
{
    ///////////////////////////////////    
    // アカウント設定画面の表示
    ///////////////////////////////////    
    public function index(){
        // ユーザー情報を取得（pic、name、email）
        $user = Auth::user();
        return view('mypage/account', ['user' => $user]);
    }

    ///////////////////////////////////    
    // アカウント情報の編集
    ///////////////////////////////////    
    public function prof(Request $request){

        $user = Auth::user();

        // 画像アップロード
        // ① フォームからのパスを格納
        // ② POST無しの場合、DBパスを格納

        $request->validate([
            'pic' => 'file|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // 中身が変わっていればバリデーションチェック
        if($request->get('name') != $user->name){
            $request->validate([
                'name' => 'required|string|max:255|unique:users,name',
            ]);
        }

        if($request->get('email') != $user->email){
            $request->validate([
                'email' => 'required|string|max:255|email|unique:users,email',
                ]);
        }

        // 更新処理
        // ポスト送信があれば
		if ($request->pic) {
            $img_url = $request->pic->storeAs('public/upload', Auth::id() . '.jpg'); 
            $user->pic =  str_replace('public/', 'storage/', $img_url);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // マイページへリダイレクト
        return redirect('/mypage')->with('flash_message', 'プロフィールを更新しました');
    }


    ///////////////////////////////////    
    // パスワードの変更
    ///////////////////////////////////    
    public function pass(Request $request){

        // 現在のパスワードが正しいかチェック
        if(!(Hash::check($request->get('password_current'), Auth::user()->password))) {
            return redirect()->back()->with('change_password_error', '現在のパスワードが間違っています。');
        }

        //現在のパスワードと新しいパスワードが違っているかを調べる
        if(strcmp($request->get('password_current'), $request->get('password_new')) == 0) {
            return redirect()->back()->with('change_password_error', '新しいパスワードが現在のパスワードと同じです。違うパスワードを設定してください。');
        }

        // バリデーションチェック
        $request->validate([
            'password_current' => 'required',
            'password_new' => 'required|string|min:6|max:255|confirmed',
            'password_new_confirmation' => 'required|string|min:6|max:255',
        ]);
        

        //パスワードを変更処理
        $user = Auth::user();
        // $user->password = bcrypt($request->get('password_new'));
        $user->password = bcrypt($request->password_new);
        $user->save();

        // マイページへリダイレクト
        return redirect('/mypage')->with('flash_message', 'パスワードを変更しました');
            
    }

    ///////////////////////////////////    
    // 退会処理
    ///////////////////////////////////    
    public function withdraw(){

        // ユーザー論理削除
        $user = Auth::user();
        $user->delete_flg = true;
        $user->save();

        // クイズの論理削除
        $drills = Drill::where('create_user', $user->id)->get();
        foreach ($drills as $drill) {
            $drill->delete_flg = true;
            $drill->save();
        }

        $questions = Question::where('create_user', $user->id)->get();
        foreach ($questions as $question) {
            $question->delete_flg = true;
            $question->save();
        }

        // セッションunset??
        

        // マイページへリダイレクト
        return redirect('/')->with('flash_message', '退会手続きが完了しました。');

    }

}
