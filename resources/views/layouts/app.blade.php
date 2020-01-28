<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>日本語タイピング | @yield('title', 'Top')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('/img/typing-icon.ico') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/62be1f71ac.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://twitter.com/intent/tweet?http://platform.twitter.com/widgets.js"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">        

    <!-- Styles -->
    <link href="{{ asset('/dist/css/app.css') }}" rel="stylesheet" type="text/css">   
</head>
<body>
<div id="app">
  <div class="l-h100vh">

    <!-- ヘッダー -->
      @section('header')
      <header class="l-header">
        <div class="p-header l-site-width">
          <!-- ヘッダーロゴ -->
          <h1 class="p-header__logo">
            <a class="p-logo" href="/list">Nihongo Typing</a>
          </h1>

          <div class="p-header__nav">
            <nav class="p-nav">
              <ul class="p-nav__list">
              @guest
                <li class="p-list"><a v-on:click='showLoginModal' class="p-list__link" href="#">ログイン</a></li>
                <li class="p-list u-ml--4l"><a v-on:click='showSingupModal' class="p-list__link" href="#">新規登録</a></li>
              @endguest

              @auth
              @section('auth-menu')
                <li class="p-list"><a class="p-list__link" href="/list">みんなのタイピング</a></li>
              @show
                <li class="p-list u-ml--4l"><a class="p-list__link"  href="{{ route('logout')}} " onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >ログアウト</a></li>

                <!-- ログアウト処理 -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              @endauth
              </ul>
            </nav>
          </div>
        </div> <!-- p-header -->
    </header> 

      <!-- ログインモーダル -->
      <transition name="bounce">
      <div class="l-modal" v-show="showLogin" v-on:click='closeModal'>
        <div class="p-modal" v-on:click="stopEvent">
          <h2 class="p-modal__title u-mb--3l">ログイン</h2>
          
          <form method="POST" action="/login" @submit.prevent="login" class="u-mb--3l">
            @csrf
            <label class="u-mb--3l">
              <input class="c-input l-w100p u-color--input" type="email" placeholder="メールアドレス" name="email" v-model="email">
              <div class="c-msg--error" v-text="errors.email" v-if="errors.email"></div>
            </label>

            <label class="u-mb--3l">
              <input class="c-input l-w100p u-color--input" name="password" type="password" placeholder="パスワード" v-model="password">
              <div class="c-msg--error" v-text="errors.password" v-if="errors.password"></div>
            </label>

            <input type="submit" value="ログイン" class="c-btn p-btn__login l-w100p u-border--none">
          </form>  

          <div class="p-link">パスワードを忘れた方は<a class="p-link__signup" href="/password/reset" style="text-decoration:underline">こちら</a></div>

          <!-- 閉じるボタン -->
          <div class="p-modal__close"><span  v-on:click='closeModal' class="p-btn__close">×</span></div>
        </div> <!-- p-modal  -->
        </div> <!-- l-modal -->
        </transition>                  


      <!-- 新規登録モーダル -->
      <transition name="bounce">
      <div class="l-modal" v-show="showSignup" v-on:click='closeModal'>
        <div class="p-modal" v-on:click="stopEvent">
          <h2 class="p-modal__title u-mb--3l">新規登録</h2>

          <form method="POST" action="/signup" @submit.prevent="signup" class="u-mb--3l">
            @csrf
            <label class="u-mb--3l">
              <input class="c-input l-w100p u-color--input" type="text" placeholder="ニックネーム" name="name" v-model="name">
              <div class="c-msg--error" v-text="errors.name" v-if="errors.name"></div>
            </label>
            
            <label class="u-mb--3l">
              <input class="c-input l-w100p u-color--input" type="email" name="email" 
              placeholder="メールアドレス" v-model="email">
              <div class="c-msg--error" v-text="errors.email" v-if="errors.email"></div>
            </label>

            <label class="u-mb--3l">
              <input class="c-input l-w100p u-color--input" type="password" placeholder="パスワード" name="password" v-model="password">
              <div class="c-msg--error" v-text="errors.password" v-if="errors.password"></div>
            </label>

            <label class="u-mb--3l">
              <input class="c-input l-w100p u-color--input" type="password" name="password_confirmation" placeholder="パスワード（再入力）" v-model="password_confirmation">
              <div class="c-msg--error" v-text="errors.password_confirmation" v-if="errors.password_confirmation"></div>
            </label>
            <input type="submit" value="アカウント作成（無料）" class="c-btn p-btn__login l-w100p u-border--none">
          </form>  

          <!-- 閉じるボタン -->
          <div class="p-modal__close"><span  v-on:click='closeModal' class="p-btn__close">×</span></div>

        </div> <!-- p-modal  -->
        <!-- <div class="u-border--bottom u-mb--3l"></div>
        <div class="p-link"><a class="p-link__signup" href="">会員登録はこちら</a></div> -->
      </div>
      </transition>                  

      <!-- モーダル用背景 -->
      <transition name="fade">
      <div class="l-modal__bg"  v-on:click='closeModal' v-show="showModalBg"></div>
      </transition>
    @show   

    <!-- フラッシュメッセージ -->
    @if(session('flash_message'))
        <div class="c-msg--success js-flash-msg" role="alert">
            {{session('flash_message')}}
        </div>
    @endif

    <!-- パスワードリセットメッセージ -->
        @if(session('status'))
        <div class="c-msg--success js-flash-msg" role="alert">
            {{session('status')}}
        </div>
    @endif


    <!-- メイン -->
    @yield('content')

    <!-- フッター -->
    <footer class="l-footer">
      <span class="p-footer__title">©Nihongo Typing All Rights Reserved.</span>
    </footer>

  </div>
</div>
</body>
</html>
