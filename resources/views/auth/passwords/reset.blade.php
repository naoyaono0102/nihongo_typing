@extends('layouts.app')

<!-- 親テンプレートの@yield('title')に埋め込む -->
@section('title', 'パスワード再設定')

<!-- 親テンプレートの@yield('content')に埋め込む -->
@section('content')
<main class="l-main l-site-width">
      <div class="p-main">
        <div class="p-main__passRemindSend">
            <h2 class="p-passRemindSend__title">パスワード再設定</h2>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf              
                <input type="hidden" name="token" value="{{ $token }}">

                <label class="c-form__label  u-mb--3l">
                  メールアドレス
                  <input class="c-input l-w100p" type="email" name="email" placeholder="メールアドレス"value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
 
                  @error('email')
                    <div class="c-msg--error">{{ $message }}</div>
                  @enderror
                </label>

                <label class="c-form__label  u-mb--3l">
                  新しいパスワード
                  <input class="c-input l-w100p" type="password" name="password" placeholder="パスワード" required autocomplete="new-password">
 
                  @error('password')
                    <div class="c-msg--error">{{ $message }}</div>
                  @enderror
                </label>

                <label class="c-form__label  u-mb--3l">
                  新しいパスワード（再入力）
                  <input class="c-input l-w100p" type="password" name="password_confirmation" placeholder="パスワード（再入力）" required autocomplete="new-password">
                </label>

                <input type="submit" value="送信する" class="c-btn p-btn__login l-btn-width--m u-border--none u-ma">
          </form>
        </div>
    </div> <!-- p-main -->

    </main>
@endsection
    </body>
</html>
