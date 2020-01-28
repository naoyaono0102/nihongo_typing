$(function() {
    // メッセージ表示処理
    var $jsShowMsg = $('.js-flash-msg');
    if($jsShowMsg.length){
        $jsShowMsg.fadeIn('slow');
        setTimeout(function(){ $jsShowMsg.fadeOut('slow'); }, 3000);
    }   
});