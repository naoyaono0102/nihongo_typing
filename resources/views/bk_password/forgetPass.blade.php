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
            ご登録いただいたメールアドレスを入力してください。
            メールアドレス宛に、パスワード再発行用のURLと認証キーをお送り致します。
            </p>

            <form action="" method="post">
                <label class="c-form__label u-mb--3l">
                  <input class="c-input l-w100p" type="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
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

    </body>
</html>
