$(function () {
  let ctx = document.getElementById('myChart');


  // グラフに１週間の日付を設定するため、
  // 本日から１週間前の月日を配列に格納
  let dateArray = [];
  for (let i = 0; i <= 6; i++) {
    let date = new Date();
    date.setDate(date.getDate() - i);
    dateArray[i] = date.toLocaleDateString('ja-JP').slice(5);
  }

  let dayTime = [];
  for (let i = 0; i <= 6; i++) {
    const timeVal = document.querySelector('#studyTime' + i).innerText;
    dayTime[i] = timeVal;
  }

  console.log(dayTime.reverse);

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
            suggestedMax: 24,
            suggestedMin: 0,
            stepSize: 2,
            callback: function (value, index, values) {
              return value + '時間'
            }
          }
        }]
      },
    }
  });
});
