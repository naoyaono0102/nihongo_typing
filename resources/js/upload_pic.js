// プロフィール写真のアップロード
$(function() {
    //画像のライブプレビュー
    var $dropArea = $('.p-prof__pic'); //label
    var $fileInput = $('.p-prof__pic--drop'); //file

    //ドラッグしてきて、上に乗ったとき枠線を表示
    $dropArea.on('dragover', function(e){
        e.stopPropagation();
        e.preventDefault();
        $(this).css('border', '3px #ccc dashed');
    });

    //枠から離れたとき枠線消す
    $dropArea.on('dragleave', function(e){
        e.stopPropagation();
        e.preventDefault();
        $(this).css('border', 'none');
    });

    //内容が変更されたら（画像を置いたら）
    $fileInput.on('change', function(e){
        //1. 枠線を消す
        $dropArea.css('border', 'none');

        // 2. files配列にファイルが入ってくる
        var file = this.files[0],   
            $img = $(this).siblings('.p-prof__pic--img'), // 3. DOM取得
            fileReader = new FileReader(); // 4. ファイルを読み込むFileReaderオブジェクト

        // 5. 読み込みが完了した際のイベントハンドラ。imgのsrcにデータをセット
        fileReader.onload = function(event) {
        // 読み込んだデータをimgに設定
        $img.attr('src', event.target.result).show();
        };

        // 6. 画像読み込み
        fileReader.readAsDataURL(file);

    });    
});