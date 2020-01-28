<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Drill;
use App\Question;
use App\User;

class DrillsController extends Controller
{
    ///////////////////////////////////    
    // タイピング問題画面の表示
    ///////////////////////////////////    
    public function index(Request $request){

        $title = $request->input('title');
        $category_id = $request->input('category_id');
        $sort = $request->sort;
    
        // ①タイトル + カテゴリーに入力あり
        if(!empty($title) && !empty($category_id)){
            $drills = Drill::where('title', 'like', '%'.$title.'%')->where('category_id', $category_id)->where('published_flg', false)->orderBy('updated_at','desc')->paginate(10);
        }

        // ②タイトルにのみ入力あり
        elseif(!empty($title) && empty($category_id)) {
            $drills = Drill::where('title', 'like', '%'.$title.'%')->where('published_flg', false)->orderBy('updated_at','desc')->paginate(10);
        }

        // ③カテゴリーにのみ入力あり
        elseif(empty($title) && !empty($category_id)) {
            $drills = Drill::where('category_id', $category_id)->where('published_flg', false)->orderBy('updated_at','desc')->paginate(10);
        }
    
        // 入力なし（全件取得）
        else {
            $drills = Drill::where('published_flg', false)->orderBy('updated_at','desc')->paginate(10);
        }
                
        return view('list', ['drills' => $drills, 'sort' => $sort, 'title'=> $title, 'category_id' => $category_id]); //第二引数の書き方はcompact('drills')という書き方もOK

    }

    ///////////////////////////////////    
    // マイページ画面の表示
    ///////////////////////////////////    
    public function mypage(Request $request){
        $sort = $request->sort;
        $drills = Drill::where('create_user', Auth::id())->orderBy('updated_at','desc')->paginate(10);
        return view('mypage.mypage', ['drills' => $drills, 'sort' => $sort]); 
    }

    ///////////////////////////////////    
    // タイピング　登録画面の表示
    ///////////////////////////////////    
    public function new(){
        return view('typing.makeQuiz');
    }

    ///////////////////////////////////    
    // タイピング　問題画面の表示
    ///////////////////////////////////    
    public function show($id){
        if(!ctype_digit($id)){
            return redirect('/mypage')->with('flash_message', __('Invalid operation was performed'));
        }
        
        // 画面に表示するタイトルや問題を取得
        $drill = Drill::find($id);
        $questions = Question::where('drill_id', $id)->get();

        return view('typing', ['drill'=> $drill ,'questions' => $questions]);
    }

    ///////////////////////////////////    
    // タイピング問題 登録処理
    ///////////////////////////////////    
    public function create(Request $request){
        logger($request);
        // バリデーションチェック
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required',
            'published_flg' => 'required',
            'formList' => 'required|array',
            'formList.*' => 'required|array',
            'formList.question.*' => 'required|string|max:255',
            'formList.answer.*' => 'required|string|max:255',
        ]);

        // 登録処理
        $drill = new Drill;
        $id = Auth::id(); // create_user用

        // 登録方法は２種類
        // ①値を１つずついれる
        //$drill->title = $request->title; 
        //$drill->save();
        // ②fillを使って一気にいれる
        // $drill->fill($request->all())->save();

        //Drillテーブルの登録
        $drill->title = $request->title;
        $drill->category_id = $request->category;
        $drill->published_flg = $request->published_flg;
        $drill->create_user = $id;
        $drill->save();
    
        //Questionテーブルの登録
        $last_insert_id = $drill->id;

        $i=0;
        foreach($request->formList as $formList){
            $question = new Question;
            $question->drill_id = $last_insert_id;
            $question->question = $formList['question'];            
            $question->answer = $formList['answer'];            
            $question->create_user = $id;
            $question->save();                
            $i++;
        }

        $request->session()->flash('flash_message', '登録しました');
        return response('success', 204);

        // マイページへリダイレクト（withメソッドはセッションにセット）
        // return redirect('/mypage')->with('flash_message', '登録しました');
    }

    ///////////////////////////////////    
    // タイピング問題 編集画面の表示
    ///////////////////////////////////    
    public function edit($id){
        //GETパラメータが数字かどうかチェックする
        //事前にチェックすることでDBへの無駄なアクセスが減らせる
        if(!ctype_digit($id)){
            return redirect('/mypage')->with('flash_message', __('Invalid operation was performed'));
        }

        $drill = Drill::find($id);
        $questions = Question::where('drill_id', $id)->get(['id','question','answer']);

        // ドリルIDが自分が作ったものかチェックする。
        if($drill->create_user != Auth::id()){
            return redirect('/mypage')->with('flash_message', __('不正なアクセスです'));
        }        

        return view('typing.editQuiz', ['drill' => $drill, 'questions' 
        => $questions ]); 
    }

    ///////////////////////////////////    
    // タイピング問題 編集処理
    ///////////////////////////////////    
    public function update(Request $request, $id){ 
        if(!ctype_digit($id)){
            return redirect('/mypage')->with('flash_message', __('Invalid operation was performed'));
        }

        // バリデーション
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required',
            'published_flg' => 'required',
            'formList' => 'required|array',
            'formList.*' => 'required|array',
            'formList.question.*' => 'required|string|max:255',
            'formList.answer.*' => 'required|string|max:255',
        ]);
        

        // drillsを更新
        $drill = Drill::find($id);
        $user_id = Auth::id(); // create_user用
        
        $drill->title = $request->title;
        $drill->category_id = $request->category;
        $drill->published_flg = $request->published_flg;
        $drill->create_user = $user_id ;
        $drill->save();


        // questionsを更新
        // 処理が複雑なので、既存データを全削除して、新たにinsertするやり方で対応        
        Question::where('drill_id', $id)->delete();

        // $i=0;
        // foreach($request->japanese as $japanese){
        //     $question = new Question;
        //     $question->drill_id = $id;
        //     $question->question = $japanese;            
        //     $question->answer = $request->romaji[$i];            
        //     $question->create_user = $user_id;
        //     $question->save();                
        //     $i++;
        // }

        $i=0;
        foreach($request->formList as $formList){
            $question = new Question;
            $question->drill_id = $id;
            $question->question = $formList['question'];            
            $question->answer = $formList['answer'];            
            $question->create_user = $user_id;
            $question->save();                
            $i++;
        }

        $request->session()->flash('flash_message', '更新しました');
        return response('success', 204);

        // マイページへリダイレクト（withメソッドはセッションにセット）
        // return redirect('/mypage')->with('flash_message', '更新しました');
    }

    ///////////////////////////////////    
    // タイピング問題 削除処理
    ///////////////////////////////////    
    public function destroy(Request $request){
        
        // Questionsテーブルからの削除
        Question::where('drill_id', $request->drill_id)->delete();

        // Drillsテーブルからの削除
        Drill::find($request->drill_id)->delete();

        // リダイレクト
        return redirect('/mypage')->with('flash_message', '削除しました');
    }    

}
