<template>
<div>
    <!-- ログインモーダル -->
    <div class="l-modal" v-show="showLogin">
      <div class="p-modal">
        <h2 class="p-modal__title u-mb--3l">ログイン</h2>
        <form action="">
          <label>
            <input class="c-input u-mb--3l l-w100p u-color--input" type="email" placeholder="メールアドレス">
          </label>
          <label>
            <input class="c-input u-mb--3l l-w100p u-color--input" type="password" placeholder="パスワード">
          </label>
          <input class="c-btn p-btn__login l-w100p u-border--none" type="submit" value="ログイン">
        </form>  

        <!-- 閉じるボタン -->
        <div class="p-modal__close"><span class="p-btn__close">×</span></div>

      </div> <!-- p-modal  -->
      <div class="u-border--bottom u-mb--3l"></div>
      <div class="p-link"><a class="p-link__signup" href="">会員登録はこちら</a></div>

    </div>

    <!-- モーダル用背景 -->
    <div class="l-modal__bg"  v-show="showModalBg"></div>
 </div>
</template>

<script>
    export default {
        data: function() {
          return {
            showLogin: false, 
            showModalBg: false //モーダル背景色
          }
        },
        methods: {
          showLoginModal: function(){
            this.showLogin = true
            this.showModalBg = true
        },
          closeModal: function(){
              this.showLogin = false
              this.showModalBg = false
          }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
