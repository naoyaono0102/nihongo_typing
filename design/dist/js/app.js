import Vue from 'vue'

var app = new Vue({
  el: '#app',
  data: {
      showLogin: false, //ログインモーダル表示
      showSignup: false, //新規登録モーダル表示
      showDelete: false, //削除モーダル表示
      showSearch: false, //検索モーダル表示
      showModalBg: false, //モーダル背景色
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      errors: {},
      duestionsList: []  // タイピング問題の入力フォーム 
  },
  methods: {
      showLoginModal: function(){
        this.showLogin = true
        this.showModalBg = true
      },
      closeModal: function(){
          this.showLogin = false
          this.showSignup = false
          this.showDelete = false
          this.showSearch = false
          this.showModalBg = false
      },
      showSingupModal: function(){
          this.showSignup = true
          this.showModalBg = true
      },
      showDeleteModal: function(){
          this.showDelete = true
          this.showModalBg = true
      },
      showSearchModal: function(){
          this.showSearch = true
          this.showModalBg = true
        },  
      login: function() {
          this.errors = {};

          var self = this;
          var url = '/login';
          var params = {
              email: this.email,
              password: this.password
          };
             
          // Ajax通信
          axios.post(url, params)
          .then(function(response){
              // ログイン成功
              location.href = '/mypage';
  
          })
          .catch(function(error){
              // ログイン失敗    
              var responseErrors = error.response.data.errors;
              var errors = {};        

              for(var key in responseErrors) {
                  errors[key] = responseErrors[key][0];
              }
      
              self.errors = errors;                

          });
      },
      signup: function() {
          this.errors = {};

          var self = this;
          var url = '/register';
          var params = {
              name: this.name,
              email: this.email,
              password: this.password,
              password_confirmation: this.password_confirmation
          };
             
          // Ajax通信
          axios.post(url, params)
          .then(function(response){
              // 新規登録成功
              location.href = '/mypage';
  
          })
          .catch(function(error){
              // 新規登録失敗    
              var responseErrors = error.response.data.errors;
              var errors = {};        

              for(var key in responseErrors) {
                  errors[key] = responseErrors[key][0];
              }
      
              self.errors = errors;                

          });
      }
  }
});
