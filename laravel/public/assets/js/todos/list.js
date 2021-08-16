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

    const url = location.href;
    let urlText = 'todo/' + taskId + '/statusUpdate/'
    if (url.match(/sort/)) {
      //urlにsortを含む場合, 「todo/」をなくして変数に代入する
      urlText = taskId + '/statusUpdate/'
    }

    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });
    $.ajax({
      //POST通信
      type: "post",
      url: urlText,
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
        const editInput = $(this).parent().next().children();
        // チェックがついている時
        // （タスクを薄くする・desabledをつける・取り消し線をつける）
        taskStatus.parents('.task-item').toggleClass('item-row active');
        editInput.prop('disabled', isCheckd);
        editInput.toggleClass('showLineCancel');
      })
      //通信が失敗したとき
      .fail((error) => {
        console.log('通信失敗');
      });
  });

  // タスクの文章編集終わった後、フォーカスを外した時に発火
  $('.task-update input').on('blur', function () {
    const taskUpdate = $(this);
    const taskId = taskUpdate.data('id');
    const taskBody = taskUpdate.val();

    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });
    $.ajax({
      //POST通信
      type: "post",
      url: 'todo/' + taskId + '/bodyUpdate/',
      data: {
        task_id: taskId,
        task_body: taskBody,
        _token: $('meta[name="csrf-token"]').attr('content')
      },

    })
      //通信が成功したとき
      .then((data) => {
        console.log('通信成功');
      })
      //通信が失敗したとき
      .fail((error) => {
        console.log('通信失敗');
      });
  });

  // エンターを押すと削除ボタンが発火されるためenterキーを無効にする
  $("input").keydown(function (e) {
    if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
      return false;
    } else {
      return true;
    }
  });


});
