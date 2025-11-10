<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Shop Page</title>
</head>
<body>
    <h3>Shop:</h3>

    <!--Navigation Bar-->
    <nav style="display:flex; align-items:center; gap:10px;">
        <a href="{{ route('tasks.index') }}">Tasks</a>
        <a href="{{ route('completed.index') }}">Completed Tasks</a>
    </nav>

    <br>

    <h1>Welcome to the shop!</h1>
    <h3>Select the type of items you would like to browse</h3>
    <nav style="display:flex; align-items:center; gap:10px;">
        <a href="{{ route('fontshop.index') }}">Fonts</a>
        <a href="{{ route('textcolorshop.index') }}">Text Colors</a>
        <a href="{{ route('backgroundshop.index') }}">Background Colors</a>
        <a href="{{ route('coachshop.index') }}">Coaches</a>
    </nav>

    {{ $slot }}
</body>

</html>