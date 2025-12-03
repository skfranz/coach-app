<!--
Program Name: layout.blade.php
Description: Creates a basic layout for webpages, used by all non-component view files
Input: Title and header for the selected page
Output: Display of Webpage with navigation bar containing the links to the other webpages and a window for the coach on the right half of the screen
-->

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
        <a href="{{ route('options.index') }}">Options</a>
        <a href="{{ route('shop.index') }}">Shop</a>
        <a href="{{ route('calendar.index') }}">Calendar</a>
        <a href="{{ route('tags.index') }}">Tags</a>
        <a href="{{ route('tasks.index') }}">Tasks</a>
    </nav>

    {{ $slot }}

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


</html>
