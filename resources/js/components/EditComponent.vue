<template>
<div>
    <form method="POST" action="/typing" class="p-regist u-pb--3l" @submit.prevent="onSubmit">

{{errors}}
    <!-- 共通部分 -->
    <label class="p-regist__label">
    タイトル
    <input class="c-input p-regist__title" type="text" v-model="title">
    <div class="c-msg--error" v-text="errors.title" v-if="errors.title"></div>
    </label>

    <div class="l-justify-between p-regist__label">
        <label class="l-w50p u-mr--3l">
            カテゴリー
            <select class="c-select p-regist__category" v-model="category">
            <option value="0">未選択</option>
            <option value="1">MINNANO NIHONGO</option>
            <option value="2">GENKI</option>
            </select>
            <div class="c-msg--error" v-text="errors.category" v-if="errors.category"></div>
        </label>

        <label class="l-w50p">
            公開区分
            <select class="c-select p-regist__published-flg" name="published_flg" v-model="published_flg">
            <option value="0">公開</option>
            <option value="1">非公開</option>
            </select>
            <div class="c-msg--error" v-text="errors.published_flg" v-if="errors.published_flg"></div>
        </label>
    </div>

 
    <!-- 問題グループ -->
    <transition-group name="list" tag="div">
    <div v-for="(form, index) in formList" class="p-makeQuiz__question" :key="form.id">

        <div>問題{{index + 1}}</div>
        <div class="p-questions l-justify-between l-align-end">
            <label class="l-w50p u-mr--3l">
                <input class="p-questions__japanese" type="text" name="japanese[]" v-model="form.question">
                <span class="u-ml--m">日本語</span>
                <div class="c-msg--error" v-text="errors.form" v-if="errors.form"></div>
            </label>

            <label class="l-w50p">
                <input class="p-questions__romaji" type="text" name="romaji[]" v-model="form.answer">
                <span class="u-ml--m">ローマ字</span>
                <div class="c-msg--error" v-text="errors.romaji" v-if="errors.romaji"></div>
            </label>

            <!-- 削除ボタン（ゴミ箱） -->
            <i class="fas fa-trash-alt p-icon__delete" v-on:click="deleteForm(index)"></i>
        </div>
    </div>
    </transition-group>

    <!-- 追加ボタン -->
    <p class="p-makeQuiz__btn--add" v-on:click="addForm">+ 問題の追加</p>

    <!-- ボタン -->
    <div class="l-justify-between">
    <a class="c-btn p-btn__negative l-btn-width--m u-mb--xl" href="/mypage">戻る</a>

    <input class="c-btn p-btn__login l-btn-width--m u-border--none" type="submit" value="登録" v-bind:disabled="isPush">

    </div>
    </form>
</div>
</template>

<script>
    export default {
        props: ['drill', 'questions'], 
        data: function() {
            return {
                errors: {},
                id: this.drill['id'],
                title: this.drill['title'],
                category: this.drill['category_id'],
                published_flg: this.drill['published_flg'],
                formList: this.questions,
                isPush: false
            }
        },
        methods: {
            // 空フォームの追加
            addForm() {        
            let length = this.formList.length
            let nextId = this.formList[length-1]['id']
            
               const additionalForm = {
                   id: ++nextId,
                   question: "",
                   answer: ""
                } 
                this.formList.push(additionalForm)
            },
            // 該当フォームの削除
            deleteForm(id) {
               this.formList.splice(id, 1)
            },
            // フォーム送信ボタンを押した時の処理
            onSubmit: function() {
                this.isPush = true

                this.errors = {}
                var self = this

                // POST送信先
                var url = '/typing/'+ this.id

                //送信するデータを代入
                var params = {
                    id: this.id,
                    title:this.title,
                    category:this.category,                 published_flg:this.published_flg,
                    formList: this.formList
                }

                // CSRF対策
                axios.defaults.headers.common = {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
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
                    self.isPush = false

                });
            }
        }
    }
</script>