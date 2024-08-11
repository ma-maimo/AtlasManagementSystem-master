$(function () {
  // 投稿画面のスライドメニュー
  $('.main_categories').click(function () {
    var category_id = $(this).attr('category_id');
    $('.category_num' + category_id).slideToggle();
    $(this).find('.category_search_list_btn').toggleClass('is-open');
  });
  // ユーザー検索のスライドメニュー
$('.search_conditions_form').click(function () {
    $(this).find('.search_conditions_inner').slideToggle(); // 内部のスライドメニューを表示/非表示
    $(this).find('.search_list_btn').toggleClass('is-open'); // ボタンの状態を切り替え
  });
  // ユーザー詳細のスライドメニュー
  // $('.select_subject_list').click(function () {
  //   $(this).find('.subject_inner').slideToggle();
  //   $(this).find('.select_subject_list_btn').toggleClass('is-open');
  // });

$('.select_subject_list_btn, .optional_subject_register').click(function(e) {
    e.stopPropagation(); // クリックイベントの伝播を防ぐ
    $(this).closest('.select_subject_list').find('.subject_inner').slideToggle();

    // ボタンを回転
    $('.select_subject_list_btn').toggleClass('is-open');
});

// チェックボックスのクリック時にメニューを閉じないようにする
$(document).on('click', '.subject_form_list input[type="checkbox"]', function (e) {
    e.stopPropagation(); // チェックボックスクリック時のイベント伝播を防ぐ
});








  $(document).on('click', '.like_btn', function (e) {
    e.preventDefault();
    $(this).addClass('un_like_btn');
    $(this).removeClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);

    // いいねボタンの状態を変更
    changeImg(post_id, 'like');

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/like/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      console.log(res);
      $('.like_counts' + post_id).text(countInt + 1);
    }).fail(function (res) {
      console.log('fail');
    });
  });

  $(document).on('click', '.un_like_btn', function (e) {
    e.preventDefault();
    $(this).removeClass('un_like_btn');
    $(this).addClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);

    // 取り消しボタンの状態を変更
    changeImg(post_id, 'unlike');

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/unlike/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      $('.like_counts' + post_id).text(countInt - 1);
    }).fail(function () {

    });
  });

  // 画像やアイコンを変更する関数
  function changeImg(post_id, action) {
    var icon = $('.like_btn, .un_like_btn'); // アイコンのクラスを指定
    if (action === 'like') {
      icon.filter('[post_id="' + post_id + '"]').removeClass('far fa-heart').addClass('fas fa-heart');
    } else if (action === 'unlike') {
      icon.filter('[post_id="' + post_id + '"]').removeClass('fas fa-heart').addClass('far fa-heart');
    }
  }

  $('.edit-modal-open').on('click',function(){
    $('.js-modal').fadeIn();
    var post_title = $(this).attr('post_title');
    var post_body = $(this).attr('post_body');
    var post_id = $(this).attr('post_id');
    $('.modal-inner-title input').val(post_title);
    $('.modal-inner-body textarea').text(post_body);
    $('.edit-modal-hidden').val(post_id);
    return false;
  });
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });

});
