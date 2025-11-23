<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>{{ $title }}</title>
</head>


<body style="background-color: {{ App\Models\Gamestate::find(1)->current_background }}">
    <h2>{{ $header }}</h2>
    <p>{{ App\Models\Gamestate::find(1)->total_coins }} coins</p>

    <!--Navigation Bar-->
    <nav style="display:flex; align-items:center; gap:10px;">
        <a href="{{ route('completed.index') }}">Completed</a>
        <a href="{{ route('shop.index') }}">Shop</a>
        <a href="{{ route('tags.index') }}">Tags</a>
        <a href="{{ route('tasks.index') }}">Tasks</a>
    </nav>

    {{ $slot }}

    <!--Create a div for the coach window-->
    <div style="position: fixed; top: 20px; right: 20px;"> <!--Fix this div in the top right of the screen-->
        <img src="{{ asset('images/goat.jpg') }}" alt="Coach" width="444">
        <div id="coach-bubble" class="hidden" width="444">Hello there! Ready to work?</div>
    </div>

</body>

<style>
  /* Coach fixed top-right */
  #coach {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
  }

  /* Speech bubble under coach */
  #coach-bubble {
    background: #fff;
    border: 2px solid #444;
    border-radius: 12px;
    padding: 10px 14px;
    max-width: 444px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    text-align: center;
    font-family: system-ui, sans-serif;
    font-size: 18px;
    line-height: 1.3;
    position: relative;
  }

  /* Bubble tail */
  #coach-bubble::before {
    content: "";
    position: absolute;
    top: -8px;
    left: 50%;
    transform: translateX(-50%);
    border-width: 0 8px 8px 8px;
    border-style: solid;
    border-color: transparent transparent #444 transparent;
  }

  .hidden { display: none; }
</style>

<script>
    // display a message below the coach for an interval (default 4s)
    function coachMessage(text, ms = 4000) {
        const bubble = document.getElementById('coach-bubble');
        // if (!bubble) return;
        bubble.textContent = text;
        bubble.classList.remove('hidden');
        clearTimeout(window.__coachHideTimer);
        window.__coachHideTimer = setTimeout(() => bubble.classList.add('hidden'), ms);
    }

    // call coachMessage if the page reloaded with a coach msg
    const msg = @json(session('coach'));
    if (msg) coachMessage(msg);

    function idleMessage() {
        console.log("Coach idle msg now");
        const lines = [
            "What are you waiting for?",
            "Seize the day!",
            "I sure hope you're working on those tasks.",
            "Don't put the pro in procrastination.",
            "Task 1. Hurry up!"
        ]
        coachMessage(lines[Math.floor(Math.random() * lines.length)], 5);
    }

    setInterval(() => {
        idleMessage();
    }, 20000);

</script>

</html>
