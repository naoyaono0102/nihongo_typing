<template>
    <div>
        <div class="p-typing" v-if="!isEnd">
            <!-- ヘッダー -->
            <div class="p-typing__header">
                <span class="p-typing__title">{{ title }}</span>  
                <div v-if="isStarted && !isCountDown && !isEnd" class="p-time-limit">{{ timerNum }}</div>  
            </div>

            <!-- 問題 -->
            <div class="p-typing__question">
                <!-- スタートボタン -->
                <button class="c-btn p-btn__list l-btn-width--xl" style =
                "margin-top: 60px;" v-on:click="doDrill" v-if="!isStarted">START</button>

                <!-- カウントダウン -->
                <p v-if="isCountDown" style="font-size: 100px; text-align: center">{{countDownNum}}</p>

                <template v-if="isStarted && !isCountDown && !isEnd">

                    <!-- 日本語 -->
                    <p class="p-question__japanese">{{ questionmWords }}</p>

                    <!-- ローマ字（文字１つ１つ分けて） -->
                    <p class="p-question__romaji">
                    <span v-for="(word, index) in typingmWords" :class="{'u-color--typing': index < currentWordNum}">{{word}}</span>
                    </p>
                </template>
            </div>

            <!-- 画像 -->
            <img class="p-typing__image" src="/img/typing-icon.svg" alt="タイピング画像">
                    
        </div>


    <div class="l-result" v-if="isEnd">
        <div class="p-result">
            <h2 class="p-result__title">Result</h2>

            <!-- 結果 -->
            <div class="p-result__wrap u-mb--xl">
            <div class="p-score">
                <div class="p-score__correct">
                <p class="p-score__title u-mb--l">Hit count</p>
                <p class="p-times">{{ wpm }}<span class="p-counter">x</span></p>
                </div>
    
                <div class="p-score__speed p-score__border">
                <p class="p-score__title u-mb--l">Average typing speed</p>
                <p class="p-times">{{typingScore}}<span class="p-counter">x/sec</span></p>
                </div>
    
                <div class="p-score__wrong p-score__border">
                <p class="p-score__title u-mb--l">Miss count</p>
                <p class="p-times">{{ missNum }}<span class="p-counter">x</span></p>
                </div>            
            </div>
            <!-- シェアボタン -->
            <button type="button" class="c-btn p-btn__list l-btn-width--xl" v-on:click="shareTwitter()"><i class="fab fa-twitter"></i> Share On Twitter</button>
            
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
            <div><a class="c-btn p-btn__login l-btn-width--xl" href="/list">Try another ▶︎</a></div>
            </div>

            </div>
        </div>
    </div>
</template>

<script>
    import keyCodeMap from '../master/keymap'
        export default {
        props: ['title', 'questions'], 
        data: function() {
            return {
                countDownNum: 3, // カウントダウン用
                timerNum: 60, // タイマー
                missNum: 0, // ミス数
                wpm: 0, // WPM（正しく打ったキーの数）
                totalQuestionNum: this.questions.length,  //クイズ数
                isStarted: false,
                isEnd: false,
                isCountDown: false,
                currentWordNum: 0, // 現在回答中の文字数目
                currentQuestionNum: 0, // 現在の問題番号
            }
        },
        computed: {
            // 出題する問題テキスト（表示用）
            questionmWords: function() {
                return this.questions[this.currentQuestionNum].question
            },

            // 画面に出題する問題テキスト（配列形式）
            typingmWords: function() {
                return Array.from(this.questions[this.currentQuestionNum].answer)
                
            },
            // 問題の解答キーコード配列
            questionKeyCodes: function(){
                // 全て入力されたらnullを返す
                if(!Array.from(this.questions[this.currentQuestionNum].answer).length){
                    return null
                }

                // テキストから問題のキーコード配列を生成
                let questionKeyCodes = []
                console.log(Array.from(this.questions[this.currentQuestionNum].answer))

                Array.from(this.questions[this.currentQuestionNum].answer).forEach((text) => {
                    $.each(keyCodeMap, (keyText, keyCode) => {
                        if(text === keyText){
                            questionKeyCodes.push(keyCode);
                        }
                    })
                })

                console.log(questionKeyCodes)
                return questionKeyCodes

            },
            //問題の文字数
            totalWordNum: function(){
                return this.questionKeyCodes.length
            },
            // タイピングスコア
            typingScore: function(){
                // １秒あたりのキータイプ数（正解したものだけ）
                // return Math.round((this.wpm / 60) * 10) / 10; //平均キータイプ数（回数/秒）・小数点第１位まで表示
                
                // スコア（WPM * 正解率の３乗）
                return Math.round((this.wpm) * (this.wpm / (this.wpm + this.missNum)) * (this.wpm / (this.wpm + this.missNum)) * (this.wpm / (this.wpm + this.missNum)) * 10) / 10
            }
        },
        methods: {
            // 問題開始前のカウントダウン
            doDrill: function(){
                this.isStarted = true
                this.countDown()
            },
            // カウントダウン（音付き）
            countDown: function() {
                // 音声読み込み
                const countSound = new Audio('../../sounds/Countdown06-5.mp3')
                const startSound = new Audio('../../sounds/Countdown06-6.mp3')

                // カウントダウン開始 
                this.isCountDown = true
                this.soundPlay(countSound)

                // ３秒ループ
                let timer = window.setInterval(() => {
                    this.countDownNum -= 1

                    // カウントダウンが終わったら、カウントダウンを停止し、始まりの音声を鳴らして、ゲームを開始する（showFirstQuestion）
                    if(this.countDownNum <= 0){
                        this.isCountDown = false
                        this.soundPlay(startSound)

                        window.clearInterval(timer)
                        this.countTimer()
                        this.showFirstQuestion()

                        return
                    }

                    // カウントダウンが終わっていなかったら
                    this.soundPlay(countSound)
                }, 1000)

            },
            // 問題を表示し、入力されるキーコードが正しいかチェックする
            showFirstQuestion: function() {
                // 効果音の読み込み
                const okSound = new Audio('../../sounds/punch-middle2.mp3')
                const ngSound = new Audio('../../sounds/sword-clash4.mp3')
                const nextSound = new Audio('../../sounds/punch-high2.mp3')

                // 入力イベント時にキーと解答キーをチェック
               $(window).on('keypress', e => {
                    console.log(e.which) //キー番号を表示

                    // 正しいキーを入力したら
                    if(e.which === this.questionKeyCodes[this.currentWordNum]){
                        console.log('正解!')
                        this.soundPlay(okSound)

                        ++this.currentWordNum
                        ++this.wpm
                        console.log('現在回答の文字数目:' + this.currentWordNum)
                        console.log('正しいキーの入力数:' + this.wpm)

                        // 現在表示している問題が全文字正解したら
                        if(this.totalWordNum === this.currentWordNum){
                            // 次の問題があるか判定
                            if(this.totalQuestionNum - 1 === this.currentQuestionNum){
                                console.log('次の問題がないので終了!')
                                this.isEnd = true
                            }else{
                            console.log('次の問題へ!')
                            ++this.currentQuestionNum //問題番号
                            this.currentWordNum = 0
                            this.soundPlay(nextSound)
                            }
                        }

                    }else{
                        // キー入力が間違っていたら
                        console.log('不正解です')
                        this.soundPlay(ngSound)
                        ++this.missNum
                        console.log('現在回答の文字数目：' + this.currentWordNum)
                        console.log('ミスタイプの合計:' + this.missNum)
                    }
                })
            },
            // 効果音を鳴らす関数
            soundPlay: function(sound){
                sound.currentTime = 0
                sound.play()
            },
            // 制限時間のカウント処理
            countTimer: function(){
                const endSound = new Audio('../../sounds/gong-played2.mp3');

                let timer = window.setInterval(() => {
                    this.timerNum -= 1

                    // タイムリミットがきたら
                    if(this.timerNum <= 0){
                        this.isEnd = true
                        window.clearInterval(timer)
                        endSound.play()
                    }
                    // 先に全問終了したら
                    else if(this.isEnd){
                        window.clearInterval(timer)
                        endSound.play()
                    }
                }, 1000)
            },
            shareTwitter: function() {
                let url = "http://twitter.com/intent/tweet?original_referer=https://nihongokyoshi-net.com/nihongo-typing/list&url=https://nihongokyoshi-net.com/nihongo-typing&text=Hit count：" + this.wpm + "x | Average typing speed：" + this.typingScore + "x/sec | Miss count："+ this.missNum + "x"

                location.href = encodeURI(url)
            }
        }
    }
</script>
