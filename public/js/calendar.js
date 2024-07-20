$(function(){

});

// モーダル
$(function() {
    $('.modal-open').on('click', function() { //クリックで開く
        $('.cancel-modal').fadeIn();

        // 取得した投稿内容をモーダルの中身へ渡す
        var day = $(this).attr('day');
        var reservePart = $(this).attr('reservePart');
        var id = $(this).attr('id');

        //表示
        $('.reserve_day').text('予約日：' + day);
        $('.reserve_part').text('時間：' + reservePart);
        $('.id').val(id);

        console.log(day, reservePart, id);

        return false;
    });

    $('.modal-close').on('click', function() { //閉じる
        $('.cancel-modal').fadeOut();
        return false;
    });
});
