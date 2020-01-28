@extends('layouts.app')

<!-- 親テンプレートの@yield('title')に埋め込む -->
@section('title', 'TOP')

<!-- 親テンプレートの@yield('content')に埋め込む -->
@section('content')
<main class="l-main l-site-width">
      <div class="p-main l-justify-align-center">
        <img class="p-main__image" src="{{ asset('/img/typing-icon.svg') }}" alt="トップ画像">

        <div class="p-main__title">
          <h2 class="p-title">Enjoy a typing game for free.</h2>

          <div class="p-btn">
            <a class="c-btn p-btn__list l-btn-width--l u-mb--xl" href="/list">Play a typing game</a>

            @if( Auth::check() )
                <a class="c-btn p-btn__login l-btn-width--l" href="/mypage">Make a typing quiz</a>
            @else
                <a class="c-btn p-btn__login l-btn-width--l" href="#" v-on:click="showLoginModal">Make a typing quiz</a>
            @endif
          </div>
        </div>
      </div>
    </main>
@endsection

    </body>
</html>
