<style>
  /* カラーボックス修正 */
  #cboxPrevious,
  #cboxNext,
  #cboxSlideshow,
  #cboxClose {
    top: 0;
  }

  #cboxLoadedContent {
    padding-top: 28px;
  }
</style>

<div class="modal-Wrapper">
  <h5 class="text-muted text-center">予定を入力してください</h5>
  @if(isset($calendar->calendar_body))
  <!-- 編集更新 -->
  <form action="{{ route('calendar.update') }}" method="post">
    @csrf
    <input type="hidden" name="calendar_field" value="{{ $id }}">
    <input type="hidden" name="param_date" value="{{ $paramDate[0] }}">
    <div class="form-group m-0">
      <textarea class="w-100" name="calendar_body" id="calendarSchedule" cols="30" rows="9">{{ $calendar->calendar_body }}</textarea>
    </div>
    <div class="text-right">
      <button type="submit" class="btn btn-primary w-100">送信</button>
    </div>
  </form>
  @else
  <!-- 新規作成 -->
  <form action="{{ route('calendar.create') }}" method="post">
    @csrf
    <input type="hidden" name="calendar_field" value="{{ $id }}">
    <input type="hidden" name="param_date" value="{{ $paramDate[0] }}">
    <div class="form-group m-0">
      <textarea class="w-100" name="calendar_body" id="calendarSchedule" cols="30" rows="9"></textarea>
    </div>
    <div class="text-right">
      <button type="submit" class="btn btn-primary w-100">送信</button>
    </div>
  </form>
  @endif
</div>
