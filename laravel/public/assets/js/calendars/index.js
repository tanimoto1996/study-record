$(function () {

  // 日付をクリックした時
  $('.day-field').on('click', function () {
    // 年月日を取得（フィールドが一意にするため）
    const date = $(this).find('input').val();

    //PC
    var cbW = '520px';
    var cbH = '405px';

    $.colorbox({
      fixed: true,
      href: "#modalBox",
      width: cbW,
      height: cbH,
      overlayClose: true,
      escKey: false,
      transition: 'none',
      inline: true,
      onOpen: function () {
        var ycoord = $(window).scrollTop();
        $('#colorbox').data('ycoord', ycoord);
        ycoord = ycoord * -1;
        $('body').css('position', 'fixed').css('left', '0px').css('right', '0px').css('top', ycoord + 'px');
      },
      onComplete: function () {
        $('#cboxTitle').on({
          mousedown: function (e) {
            var os = $('#colorbox').offset(),
              dx = e.pageX - os.left,
              dy = e.pageY - os.top;
            $(document).on('mousemove.drag', function (e) {
              $('#colorbox').offset({
                top: e.pageY - dy,
                left: e.pageX - dx
              });
            });
          },
          mouseup: function () {
            $(document).unbind('mousemove.drag');
          }
        });
        $('#cboxTitle').css('cursor', 'move');
      },
      onLoad: function () {
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
        }).done(function (data) {
          //通信が成功したとき
          $('#modalBox').html(data);

        }).fail((error) => {
          //通信が失敗したとき
          console.log('通信失敗');

        });
      },
      onClosed: function () {
        $('body').css('position', '').css('left', 'auto').css('right', 'auto').css('top', 'auto');
        $(window).scrollTop($('#colorbox').data('ycoord'));
        $('#modalBox').html('');
      },
    });
  });
});
