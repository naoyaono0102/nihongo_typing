@extends('layouts.app')

<!-- タイトル設定 -->
@section('title', 'マイページ')

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
<main class="l-justify-between l-list">

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

<!-- タイピング一覧 -->
<div class="l-drills">


  <!-- 各問題を出力 -->
  <div class="p-drills">

    <!-- 問題出力 -->
    @foreach($drills as $drill)
    <div class="p-drill">
      <a href="{{route('typing.show', $drill->id)}}">
      <h2 class="p-drill__title">{{ $drill->title }}</h2>

      <div class="p-drill__footer">
        <div class="p-creater">
          @if(empty($drill->user->pic))
          <img class="p-creater__pic" src="{{ asset('/img/person.png') }}">
          @else
          <img class="p-creater__pic" src="{{ $drill->user->pic }}">
          @endif
          <div class="p-creater__username">{{ $drill->user->name }}</div>
        </div>

        <!-- 編集・削除アイコン -->
        <div class="p-icons">
          <a class="p-icons__edit" href="{{ route('typing.edit', $drill->id)}}"><i class="fas fa-broom"></i></a>
          <div class="p-icons__delete" ><i class="fas fa-trash-alt u-ml--m js-get-drill-id" v-on:click='showDeleteModal' data-id="{{ $drill->id }}"></i></div>
        </div>
      </div>
      </a>
    </div> <!-- p-drill -->
    @endforeach

  </div> <!-- p-drills -->

  <!-- ページネーション  -->
  {{ $drills->links() }}

</div> <!-- l-drills -->

<!-- サイドバー（右）：広告エリア  -->
<div class="l-ad">
  <div class="p-ad">
    <div class="p-ad__long">
      広告エリア
    </div>
  </div>
</div>

</main>

<!-- 削除モーダル -->
<transition name="bounce">
<div class="l-modal" v-show="showDelete" v-on:click='closeModal'>
  <div class="p-modal" v-on:click="stopEvent">
    <h2 class="p-modal__title u-mb--3l">削除</h2>
    <p class="u-mb--3l">こちらのタイピング問題を削除してもよろしいでしょうか？</p>
    <form action="{{ route('typing.destroy') }}" method="POST" class="u-mb--3l">

      @csrf
      <input class="js-set-drill-id" type="hidden" name="drill_id" value="">
      <input class="c-btn p-btn__negative l-w100p u-border--none" type="submit" value="削除する">
    </form>

    <!-- 閉じるボタン -->
    <div class="p-modal__close"><span  v-on:click='closeModal' class="p-btn__close">×</span></div>

  </div> <!-- p-modal  -->    
</div>
</transition>

<!-- モーダル用背景 -->
<transition name="fade">
<div class="l-modal__bg"  v-on:click='closeModal' v-show="showModalBg"></div>
</transition>

@endsection


    </body>
</html>
