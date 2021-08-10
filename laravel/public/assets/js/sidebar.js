$(function () {

  // ウィンドウサイズが変更した時にサイドバーの文字を消す
  $(window).on('resize', function () {
    // 横幅取得
    const width = $(this).innerWidth();

    if (width <= 1050) {
      // 横幅が１０５０以下なら文字を消す（クラス追加）
      $('.side-bar ul li span').addClass("none");
      $('.main-container').addClass("large");
    } else {
      // 横幅が１０５０以上なら文字を出す
      $('.side-bar ul li span').removeClass("none");
      $('.main-container').removeClass("large");
    }

  });

});
