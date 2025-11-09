<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>{{ $title }}</title>
</head>


<body>
    <h2>{{ $header }}</h2>

    <!--Navigation Bar-->
    <nav style="display:flex; align-items:center; gap:10px;">
        <a href="{{ route('completed.index') }}">Completed</a>
        <a href="{{ route('tags.index') }}">Tags</a>
        <a href="{{ route('tasks.index') }}">Tasks</a>
    </nav>

    {{ $slot }}

</body>

</html>