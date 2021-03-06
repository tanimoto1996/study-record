$(function () {
  let ctx = document.getElementById('myChart');

  $chartLength = $(".chart-length").length;

  // グラフに１週間の日付を設定するため、
  // 本日から１週間前の月日を配列に格納
  let dateArray = [];
  for (let i = 0; i <= $chartLength - 1; i++) {
    let date = new Date();
    date.setDate(date.getDate() - i);
    dateArray[i] = date.toLocaleDateString('ja-JP').slice(5);
  }

  let dayTime = [];
  for (let i = 0; i <= $chartLength - 1; i++) {
    const timeVal = document.querySelector('#studyTime' + i).innerText;
    if (timeVal > 24) {
      // 24時間を超えていた場合、グラフが24時間になるように制御する
      dayTime[i] = "24";
      continue;
    }
    dayTime[i] = timeVal;
  }

  const studyLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      // １週間の日付
      labels: dateArray.reverse(),
      datasets: [
        {
          // 日付ごとの学習時間をdataに入れる
          label: '学習時間',
          data: dayTime.reverse(),
          borderColor: "rgba(255,0,0,1)",
          backgroundColor: "rgba(0,0,0,0)"
        }
      ],
    },
    options: {
      title: {
        display: true,
        text: '期間' + dateArray[0] + '~' + dateArray[6]
      },
      scales: {
        yAxes: [{
          ticks: {
            max: 24,
            min: 0,
            stepSize: 2,
            callback: function (value, index, values) {
              return value + '時間';
            }
          }
        }]
      },
    }
  });
});
