<div class="modal-Wrapper">
  <p>予定</p>
  @if(isset($calendar->calendar_body))
  <!-- 編集更新 -->
  <form action="{{ route('calendar.update') }}" method="post">
    @csrf
    <textarea name="calendar_body" id="" cols="30" rows="10">{{ $calendar->calendar_body }}</textarea>
    <input type="hidden" name="calendar_field" value="{{ $id }}">
    <input type="submit" value="送信">
  </form>
  @else
  <!-- 新規作成 -->
  <form action="{{ route('calendar.create') }}" method="post">
    @csrf
    <textarea name="calendar_body" id="" cols="30" rows="10"></textarea>
    <input type="hidden" name="calendar_field" value="{{ $id }}">
    <input type="submit" value="送信">
  </form>
  @endif
</div>
