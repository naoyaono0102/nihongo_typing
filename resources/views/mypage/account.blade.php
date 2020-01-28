@extends('layouts.app')

<!-- タイトル設定 -->
@section('title', 'アカウント設定')

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
        <li class="p-menu__list"><a class="p-menu__link" href="/list"><i class="fas fa-users"></i> みんなのタイピング</a></li>
        <li class="p-menu__list"><a class="p-menu__link" href="/mypage"><i class="fas fa-keyboard"></i> 作成したタイピング一覧</a></li>
        <li class="p-menu__list"><a class="p-menu__link" href="/typing/new"><i class="fas fa-broom"></i> 問題作成</a></li>
        <li class="p-menu__list"><a class="p-menu__link" href="/account"><i class="fas fa-user-alt"></i> アカウント設定</a></li>
      </ul>
    </div>
  </div>
@endsection


<!-- 親テンプレートの@yield('content')に埋め込む -->
@section('content')
<main class="l-justify-left l-list">

<!-- サイドバー（左）  -->
<div class="l-side-bar">
  <div class="p-side-bar">

    <!-- メニュー一覧 -->
    <div class="p-side-bar__menu">
      <ul class="p-menu">
        <li class="p-menu__list"><a class="p-menu__link" href="/mypage"><i class="fas fa-keyboard"></i> 作成したタイピング一覧</a></li>
        <li class="p-menu__list"><a class="p-menu__link" href="/typing/new"><i class="fas fa-broom"></i> 問題作成</a></li>
        <li class="p-menu__list"><a class="p-menu__link" href="/account"><i class="fas fa-user-alt"></i> アカウント設定</a></li>
      </ul>
    </div>

    <!-- 広告エリア -->
    <div class="p-ad">
      <div class="p-ad__square">
        広告エリア
      </div>
    </div>

  </div>
</div>

<!-- アカウントエリア -->
<div class="l-accounts">
  <div class="p-accounts">

    <!-- プロフィール -->
    <div class="p-account">
      <div class="p-account__title">
        <i class="fas fa-user-alt p-icon__prof"></i>
        <p>プロフィール編集</p>
      </div>

      <form action="{{route('account.edit')}}"  method="POST" class="p-account__form" enctype="multipart/form-data">
        @csrf

        @error('pic')
                <div class="c-msg--error">{{ $message }}</div>
        @enderror       
        <div class="p-prof u-mb--3l">

          <!-- 画像 -->
          <label class="p-prof__pic">
              <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
              <input type="file" name="pic" class="p-prof__pic--drop"> 
              @if ($user->pic)
                <img src="/{{ $user->pic }}" class="p-prof__pic--img">  
              @else 
                <img src="{{ asset('/img/person.png') }}" class="p-prof__pic--img">  
              @endif
          </label>

          <!-- 名前・アドレス -->
          <div class="p-prof__info">
            <label>
              <input class="c-input l-w100p" type="text" name="name" placeholder="ニックネーム" value="{{ old('name', $user->name) }}" >

              @error('name')
                <div class="c-msg--error">{{ $message }}</div>
              @enderror
            </label>

            <label class="u-mt--3l">
              <input class="c-input l-w100p" type="text" name="email" placeholder="メールアドレス" value="{{ old('email', $user->email) }}" >
              @error('email')
                <div class="c-msg--error">{{ $message }}</div>
              @enderror
            </label>    
          </div> <!-- p-prof__info -->
        </div> <!-- p-pfor -->

        <input class="c-btn p-btn__login l-btn-width--m u-border--none" type="submit" value="変更する">
      </form>
     </div> 

    <!-- パスワード変更 -->          
    <div class="p-account">
      <div class="p-account__title">
        <i class="fas fa-lock p-icon__pass"></i>
        <p>パスワード変更</p>  
      </div>

      <form action="{{route('pass.edit')}}" method="POST" class="p-account__form">
      @csrf
          <!-- 移動させる -->
          @if(session('change_password_error'))
              <div class="c-msg--error u-mb--3l" role="alert">
                  {{session('change_password_error')}}
              </div>
          @endif

        <label class="u-mb--3l">
          <input class="c-input l-w100p" name="password_current" type="password" placeholder="現在のパスワード">
          @error('password_current')
            <div class="c-msg--error">{{ $message }}</div>
          @enderror
        </label>

        <label class="u-mb--3l">
          <input class="c-input l-w100p" name="password_new" type="password" placeholder="新しいパスワード">
          @error('password_new')
            <div class="c-msg--error">{{ $message }}</div>
          @enderror
        </label>

        <label class="u-mb--3l">
          <input class="c-input l-w100p" name="password_new_confirmation" type="password" placeholder="新しいパスワード（再入力）">
          @error('password_confirmation')
            <div class="c-msg--error">{{ $message }}</div>
          @enderror
        </label>
        <input class="c-btn p-btn__login l-btn-width--m u-border--none" type="submit" value="変更する">
      </form>
    </div>

    <!-- 退会手続き -->
    <div class="p-account">
      <div class="p-account__title">
        <i class="fas fa-times-circle p-icon__withdraw"></i>
        <p>退会手続き</p>
      </div>

      <form action="{{route('withdraw')}}" method="POST" class="p-account__form">
      @csrf  
        <input class="c-btn p-btn__login l-btn-width--m u-border--none" type="submit" value="退会する">
      </form>
    </div>

  </div> <!-- p-accounts -->
</div> <!-- l-accounts -->

</main>
@endsection


    </body>
</html>
