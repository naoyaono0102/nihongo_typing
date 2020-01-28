@extends('layouts.app')

<!-- タイトル設定 -->
@section('title', 'TOP')

<!-- 親テンプレートの@yield('content')に埋め込む -->
@section('content')
<main class="l-result l-site-width">
      <div class="p-result">
        <h2 class="p-result__title">Result</h2>

        <!-- 結果 -->
        <div class="p-result__wrap u-mb--xl">
          <div class="p-score">
            <div class="p-score__correct">
              <p class="u-mb--l">正しく打ったキーの数</p>
              <p class="p-times">256<span class="p-counter">回</span></p>
            </div>
  
            <div class="p-score__speed p-score__border">
              <p class="u-mb--l">平均キータイプ数</p>
              <p class="p-times">2.8<span>回/秒</span></p>
            </div>
  
            <div class="p-score__wrong p-score__border">
              <p class="u-mb--l">ミスタイプ数</p>
              <p class="p-times">100<span>回</span></p>
            </div>            
          </div>
          <!-- シェアボタン -->
          <button class="c-btn p-btn__list l-btn-width--xl"><i class="fab fa-twitter"></i> Twitterでシェア</button>
        </div>

        <!-- 広告 -->
        <div class="p-ad u-mb--xl">
          <div class="p-ad__yokonaga">
            広告エリア
          </div>
        </div>

        <!-- ボタン（again or another） -->
        <div class="l-justify-between p-result__btns">
          <a class="c-btn p-btn__negative l-btn-width--xl" href="">◀︎ Try again</a>
          <div><a class="c-btn p-btn__login l-btn-width--xl" href="">Try another ▶︎</a></div>
        </div>

      </div>
    </main>
@endsection


    </body>
</html>
