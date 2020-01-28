<!-- layout/appを読み込み -->
@extends('layouts.app')

<!-- タイトル設定 -->
@section('title', '問題作成')

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
<main class="l-makeQuiz">
    <div class="l-site-width l-makeQuiz__wrap">
      <div classs="p-makeQuiz">
        <h2 class="p-makeQuiz__title">タイピング問題登録</h2>

        <!-- <form method="POST" action="{{ route('typing.create') }}" class="p-regist u-pb--3l">
        @csrf -->

          <!-- 共通部分 -->
          <!-- <label class="p-regist__label">
            タイトル
            <input class="c-input p-regist__title" type="text" name="title" value="{{ old('title') }}">
            @error('title')
              <div class="c-msg--error">{{ $message }}</div>
            @enderror
          </label>

          <div class="l-justify-between p-regist__label">
            <label class="l-w50p u-mr--3l">
              カテゴリー
              <select class="c-select p-regist__category" name="category">
              <option value="0" @if(old("category")=="0") selected @endif>未選択</option>
              <option value="1" @if(old("category")=="1") selected @endif>MINNANO NIHONGO</option>
              <option value="2" @if(old("category")=="2") selected @endif>GENKI</option>
              </select>
              @error('category')
              <div class="c-msg--error">{{ $message }}</div>
              @enderror
            </label>

            <label class="l-w50p">
              公開区分
              <select class="c-select p-regist__published-flg" name="published_flg">
                <option value="0" @if(old("published_flg")=="0") selected @endif>公開</option>
                <option value="1" @if(old("published_flg")=="1") selected @endif>非公開</option>
              </select>
              @error('published_flg')
              <div class="c-msg--error">{{ $message }}</div>
              @enderror
            </label>
          </div> -->

          <!-- 問題グループ -->
          @for($i = 0 ; $i < 2; $i ++)
          <!-- <div class="p-makeQuiz__question">
            <span>問題{{$i + 1}}<span>
            <div class="p-questions l-justify-between l-align-end">
              <label class="l-w50p u-mr--3l">
                <input class="p-questions__japanese" type="text" name="japanese[]" value='{{ old("japanese.${i}")}}'>
                <span class="u-ml--m">日本語</span>
                @error('japanese.'.$i)
                  <div class="c-msg--error">{{ $message }}</div>
                @enderror

              </label>

              <label class="l-w50p">
                <input class="p-questions__romaji" type="text" name="romaji[]" value='{{ old("romaji.${i}")}}'>
                <span class="u-ml--m">ローマ字</span>
                @error('romaji.'.$i)
                  <div class="c-msg--error">{{ $message }}</div>
                @enderror

              </label> -->

              <!-- 削除ボタン（ゴミ箱） -->
              <!-- <i class="fas fa-trash-alt p-icon__delete"></i>
            </div>
          </div> -->
          @endfor

          <!-- <register-form
            :old="{{ json_encode(Session::getOldInput()) }}"
            :errors= "{{ $errors }}"
          ></register-form> -->
          <register-form></register-form>


  
                <!-- クリックされたら、フォームを追加 -->
                <!-- <p class="p-makeQuiz__btn--add" v-on:click="addForm">+ 問題の追加</p> -->

          <!-- ボタン -->
          <!-- <div class="l-justify-between">
            <a class="c-btn p-btn__negative l-btn-width--m u-mb--xl" href="/mypage">戻る</a>
            <input class="c-btn p-btn__login l-btn-width--m u-border--none" type="submit" value="登録">
          </div> -->
        <!-- </form> -->

      </div> <!-- p-makeQuiz -->
    </div> <!-- l-site-width -->


  </main>
@endsection


    </body>
</html>
