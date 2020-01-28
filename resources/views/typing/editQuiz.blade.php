<!-- layout/appを読み込み -->
@extends('layouts.app')

<!-- タイトル設定 -->
@section('title', '編集')

<!-- ヘッダー読み込み -->
@section('header')
  @parent

  <!-- ハンバーガーメニュー -->
  <div id="nav-drawer">
    <input id="nav-input" type="checkbox" class="nav-unshown">
    <label id="nav-open" for="nav-input"><span></span></label>
    <label class="nav-unshown" id="nav-close" for="nav-input"></label>
    <div id="nav-content">
      <ul class="p-menu">
        <li class="p-menu__list"><a class="p-menu__link" href=""><i class="fas fa-keyboard"></i> 作成したタイピング一覧</a></li>
        <li class="p-menu__list"><a class="p-menu__link" href=""><i class="fas fa-broom"></i> 問題作成</a></li>
        <li class="p-menu__list"><a class="p-menu__link" href=""><i class="fas fa-user-alt"></i> アカウント設定</a></li>
      </ul>
    </div>
  </div>
@endsection

<!-- 親テンプレートの@yield('content')に埋め込む -->
@section('content')
<main class="l-makeQuiz">
    <div class="l-site-width l-makeQuiz__wrap">
      <div classs="p-makeQuiz">
        <h2 class="p-makeQuiz__title">タイピング問題編集</h2>

          <!-- 問題グループ -->
        <edit-form
          :drill = "{{$drill}}"
          :questions = "{{$questions}}"
        ></edit-form>

      </div> <!-- p-makeQuiz -->
    </div> <!-- l-site-width -->
  </main>
@endsection


    </body>
</html>
