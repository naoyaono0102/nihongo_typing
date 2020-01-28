@extends('layouts.app')

<!-- タイトル設定 -->
@section('title', 'タイピング')

<!-- ヘッダー読み込み -->
@section('header')
  @parent

  <!-- みんなのタイピング→マイページへ書き換え -->
  @section('auth-menu')
  <li class="p-list"><a class="p-list__link" href="/mypage">マイページ</a></li>
  @endsection

  <!-- ハンバーガーメニュー -->
  <div id="nav-drawer">
  <input id="nav-input" type="checkbox" class="nav-unshown">
  <label id="nav-open" for="nav-input"><span></span></label>
  <label class="nav-unshown" id="nav-close" for="nav-input"></label>
  <div id="nav-content">
    <ul class="p-menu">
    @guest
      <li class="p-menu__list"><a v-on:click='showLoginModal' class="p-menu__link" href="#"><i class="fas fa-home"></i> ログイン</a></li>
      <li class="p-menu__list"><a v-on:click='showSingupModal' class="p-menu__link" href="#"><i class="fas fa-keyboard"></i> 新規登録</a></li>
    @endguest

    @auth
      <li class="p-menu__list"><a class="p-menu__link" href="/mypage"><i class="fas fa-user-circle"></i> マイページ</a></li>
      <li class="p-menu__list"><a class="p-menu__link" href="{{ route('logout')}} " onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> ログアウト</a></li>
   @endauth
    </ul>
  </div>
</div>
@endsection

<!-- 親テンプレートの@yield('content')に埋め込む -->
@section('content')
<main class="l-typing l-site-width">

  <typing-area
    title = "{{ $drill->title }}"
    :questions = "{{ $questions }}"
  >
  </typing-area>
</main>
@endsection


    </body>
</html>
