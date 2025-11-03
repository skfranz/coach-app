<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>{{ $title }}</title>
</head>


<body>
    <h3>{{ $header }}</h3>

    <!--Navigation Bar-->
    <nav style="display:flex; align-items:center; gap:10px;">
        <a href="{{ route('tasks.index') }}">Tasks</a>
        <a href="{{ route('completed.index') }}">Completed Tasks</a>
        <a href="{{ route('tags.index') }}">Tags</a>
    </nav>

    <br>

    {{ $slot }}

</body>

</html>