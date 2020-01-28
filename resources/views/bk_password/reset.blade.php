@extends('layouts.app')

<!-- 親テンプレートの@yield('title')に埋め込む -->
@section('title', 'パスワード再設定')

<!-- 親テンプレートの@yield('content')に埋め込む -->
@section('content')
<main class="l-main l-site-width">
      <div class="p-main">
        <div class="p-main__passRemindSend">
            <h2 class="p-passRemindSend__title">パスワード再設定</h2>
            <p class="p-passRemindSend__description">
            お送りした【パスワード再発行認証メール】内にある「認証キー」をご入力ください。
            </p>

            <form action="" method="post">
              <label class="c-form__label  u-mb--3l">
                  <input class="c-input l-w100p" type="text" name="auth_key" placeholder="認証キー" value="old('auth')">                  
                  @error('name')
                    <div class="c-msg--error">{{ $message }}</div>
                  @enderror
                </label>

                <input type="submit" value="送信する" class="c-btn p-btn__login l-btn-width--m u-border--none u-ma">
          </form>
        </div>
    </div> <!-- p-main -->

    </main>
@endsection

    <!-- 既存のコード -->
        <!-- <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

        </div> -->
    </body>
</html>
