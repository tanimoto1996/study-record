$(function () {

  // 日付をクリックした時
  $('.day-field').on('click', function () {
    // 年月日を取得（フィールドが一意にするため）
    const date = $(this).find('input').val()

    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });
    $.ajax({
      //POST通信
      type: "get",
      url: 'calendar/edit',
      data: {
        calendar_id: date,
      },
    })
      //通信が成功したとき
      .then((data) => {
        console.log(data);



      })
      //通信が失敗したとき
      .fail((error) => {
        console.log('通信失敗');
      });

  });

});
