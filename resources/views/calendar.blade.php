<x-layout title="Calendar" header="Calendar">

<style>
  .calendar { display: grid; grid-template-columns: repeat(7, 1fr); gap: 6px; }
  .day { border: 1px solid #ccc; min-height: 120px; padding: 6px; box-sizing: border-box; }
  .other-month { background:#f8f8f8; color:#888; }
  .date-num { font-weight: bold; }
  .task-item { font-size: 0.9em; margin: 2px 0; }
  .more-link { color: blue; cursor: pointer; font-size: 0.85em; }
  .controls { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
</style>

<div class="controls">
  <div>
    <a href="{{ route('calendar.index', ['year' => $prev->year, 'month' => $prev->month]) }}">&laquo; Prev</a>
    &nbsp;|&nbsp;
    <a href="{{ route('calendar.index', ['year' => $next->year, 'month' => $next->month]) }}">Next &raquo;</a>
  </div>
  <div><strong>{{ $monthStart->format('F Y') }} ({{ $tz }})</strong></div>
</div>

<div class="calendar">
  @foreach (['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $dow)
    <div style="font-weight:bold; text-align:center;">{{ $dow }}</div>
  @endforeach

  @foreach ($weeks as $week)
    @foreach ($week as $day)
      @php
        $isOther = $day['date']->month !== $monthStart->month;
        $tasks = $day['tasks'];
      @endphp
      <div class="day {{ $isOther ? 'other-month' : '' }}">
        <div class="date-num">{{ $day['date']->format('j') }}</div>

        <div class="tasks-list" data-date="{{ $day['date']->format('Y-m-d') }}">
          @php $show = 3; @endphp
          @foreach ($tasks as $i => $task)
            <div class="task-item" @if($i >= $show) style="display:none" class="extra" @endif>
              {{ $task->name }} @isset($task->coin_value) ({{ $task->coin_value }}¢)@endisset
            </div>
          @endforeach

          @if (count($tasks) > $show)
            <div class="more-link" data-date="{{ $day['date']->format('Y-m-d') }}">+{{ count($tasks) - $show }} more</div>
          @endif
        </div>
      </div>
    @endforeach
  @endforeach
</div>

<script>
  document.addEventListener('click', function(e){
    const target = e.target;
    if (target.classList.contains('more-link')) {
      const date = target.getAttribute('data-date');
      const container = document.querySelector('[data-date="'+date+'"]');
      if (!container) return;
      const extras = container.querySelectorAll('.task-item');
      // Reveal all hidden ones (toggle)
      extras.forEach(function(el){ el.style.display = 'block'; });
      target.style.display = 'none';
    }
  });
</script>

</x-layout>
