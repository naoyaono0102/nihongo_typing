@extends('layouts.app')

<!-- タイトル設定 -->
@section('title', 'タイピング一覧')

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

<!-- 検索アイコン -->
<div id="nav-search">
  <i class="fas fa-search p-icon__search" v-on:click='showSearchModal'></i>
</div>    
@endsection

<!-- 親テンプレートの@yield('content')に埋め込む -->
@section('content')
  <main class="l-justify-between l-list">

    <!-- サイドバー（左）  -->
    <div class="l-side-bar">

      <div class="p-side-bar">
        <!-- 検索項目 -->
        <div class="p-side-bar__search">
  
          <form action="{{ route('list') }}" method="GET" class="p-search u-mt--5l">
            <label class="u-mb--xxl">
              <span class="u-ml--xxl">Title</span>
              <input class="c-input p-search__title" type="text" name="title" value="{{ $title }}">
            </label>

            <label class="u-mb--5l">
              <span class="u-ml--xxl">Category</span>
              <select class="c-select p-search__category" name="category_id">
                <option value="0" @if( $category_id == "0") selected @endif >All</option>
                <option value="1" @if( $category_id == "1") selected @endif >Minnano Nihongo</option>
                <option value="2" @if( $category_id == "2") selected @endif>Genki</option>
                <option value="3" @if( $category_id == "3") selected @endif>Dekiru Nihongo</option>
                <option value="4" @if( $category_id == "4") selected @endif>Marugoto</option>
              </select>
            </label>

            <input class="p-search__submit c-btn p-btn__list u-mb--3l u-border--none" type="submit" value="SEARCH">
          </form>
          
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
            <!-- <p class="p-drill__description">ミラーさん / マイケルさん / 田中さん / 池内さん ミラーさん / マイケルさん / 田中さん /ミラーさん / マイケルさん / 田中さん
              /ミラーさん / マイケルさん / 田中さん /ミラーさん / マイケルさん / 田中さん</p> -->

            <div class="p-creater">
            @if(empty($drill->user->pic))
            <img class="p-creater__pic" src="{{ asset('/img/person.png') }}">
            @else
              <img class="p-creater__pic" src="{{ $drill->user->pic }}">
            @endif
              <div class="p-creater__username">{{ $drill->user->name }}</div>
            </div>
            </a>
          </div> <!-- p-drill -->
          @endforeach

      </div> <!-- p-drills -->

      <!-- ページネーション  -->
      <!-- {{ $drills->links() }} -->
      {{ $drills->appends(['title'=>$title, 'category_id' => $category_id, 'sort' => $sort])->links() }}
      

    </div> <!-- l-drills -->

    <!-- サイドバー（右）：広告エリア  -->
    <div class="l-ad">
      <div class="p-ad">
        <div class="p-ad__long">
          広告エリア
        </div>
      </div>
    </div>

    <!-- 検索モーダル -->
    <div class="l-modal" v-show="showSearch">
      <div class="p-modal">
      <form action="{{ route('list') }}" method="GET">
          <label class="u-mb--xxl">
            <span>Title</span>
            <input class="c-input l-w100p" type="text" name="title">
          </label>
  
          <label class="u-mb--xxl">
            <span>Category</span>
            <select class="c-select u-h--50 l-w100p" name="category_id">
              <option value="0">All</option>
              <option value="1">Minnano Nihongo</option>
              <option value="2">Genki</option>
              <option value="3">Dekiru Nihongo</option>
              <option value="4">Marugoto</option>
            </select>
          </label>

          <input class="p-search__submit c-btn p-btn__list u-border--none" type="submit" value="SEARCH">
  
        </form>  

        <!-- 閉じるボタン -->
        <div class="p-modal__close" v-on:click='closeModal'><span class="p-btn__close">×</span></div>

      </div> <!-- p-modal  -->
    </div>

  </main>
@endsection


    </body>
</html>
