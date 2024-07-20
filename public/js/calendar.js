$(function(){

});

// モーダル
$(function() {
    $('.modal-open').on('click', function() { //クリックで開く
        $('.cancel-modal').fadeIn();

        // 取得した投稿内容をモーダルの中身へ渡す
        var day = $(this).attr('day');
        var reservePart = $(this).attr('reserve_part');
        var reserveSettingId = $(this).attr('reserve_setting_id');

        //表示
        $('.reserve_day').text('予約日：' + day);
        $('.reserve_part').text('時間：' + reservePart);
        $('.reserve_setting_id').val(reserveSettingId);

        console.log(day, reservePart, reserveSettingId);

        return false;
    });

    $('.modal-close').on('click', function() { //閉じる
        $('.cancel-modal').fadeOut();
        return false;
    });
});
