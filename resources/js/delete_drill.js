$(function() {

    // 削除対象のドリルIDを取得
    $('.js-get-drill-id').on('click',function(){
        let $drill_id = $(this).data('id');
        console.log($drill_id)

        // ドリルIDをFormのvalueにセット
        $('.js-set-drill-id').val($drill_id);
    });

    
});