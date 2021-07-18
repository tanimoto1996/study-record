$(function () {

  // １０文字以上（様を合わせた）の名前の場合に省略する
  if ($('#logout-button').length) {
    let userName = $('#navbarSupportedContent #navbarDropdownMenuLink').text().trim();

    if (userName.length > 10) {
      const textTrim = userName.substr(0, 9);
      $('#navbarSupportedContent #navbarDropdownMenuLink').text(textTrim + '...' + '様')
    }
  }

});
