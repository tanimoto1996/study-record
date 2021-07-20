$(function () {
  // タスクは最大５個に制限する
  const MAX_COUNT = 5;
  const now_count = $('.taskStatus').length;

  if (MAX_COUNT <= now_count) {
    $('#taskAdd').prop('disabled', true);
  } else {
    $('#taskAdd').prop('disabled', false);

  }

  // タスクのステータス（チェックボックス）変更時に発火
  $('.taskStatus').on('change', function () {
    const taskStatus = $(this);
    const taskId = taskStatus.data('id');
    const checkd = taskStatus.prop("checked") ? 1 : 0;

    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });
    $.ajax({
      //POST通信
      type: "post",
      url: 'todo/' + taskId + '/statusUpdate/',
      data: {
        task_id: taskId,
        task_checkd: checkd,
        _token: $('meta[name="csrf-token"]').attr('content')
      },

    })
      //通信が成功したとき
      .then((data) => {
        console.log('通信成功');

        const isCheckd = taskStatus.prop("checked");
        // チェックがついている時、タスクを薄くする
        taskStatus.parent().toggleClass('item-row active');
        // チェックがついている時、desabledをつける
        $(this).next().children().prop('disabled', isCheckd);
      })
      //通信が失敗したとき
      .fail((error) => {
        console.log('通信成功');
      });
  });
});
