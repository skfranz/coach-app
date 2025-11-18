<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>{{ $title }}</title>
</head>
<body>
    <h2>{{ $maintype }}:</h2>
    <p>{{ App\Models\User::find(1)->total_coins }} coins</p>
    
    <!--Navigation Bar-->
    <nav style="display:flex; align-items:center; gap:10px;">
        <a href="{{ route('completed.index') }}">Completed</a>
        <a href="{{ route('tags.index') }}">Tags</a>
        <a href="{{ route('tasks.index') }}">Tasks</a>
        <a href="{{ route('shoppage.index') }}">Shop</a>
        <a href="{{ route('inventorypage.index') }}">Inventory</a>
    </nav>

    <br>

    <h1>Welcome to the {{ $subpage }} {{ $maintype }} Page!</h1>
    <h3>Select the type of items you would like to browse</h3>

    @if($maintype == "Shop")
        <nav style="display:flex; align-items:center; gap:10px;">
            <a href="{{ route('fontshop.index') }}">Fonts</a>
            <a href="{{ route('textcolorshop.index') }}">Text Colors</a>
            <a href="{{ route('backgroundshop.index') }}">Backgrounds</a>
            <a href="{{ route('coachshop.index') }}">Coaches</a>
        </nav>
    @elseif ($maintype == "Inventory")
        <nav style="display:flex; align-items:center; gap:10px;">
            <a href="{{ route('fontinv.index') }}">Fonts</a>
            <a href="{{ route('textcolorinv.index') }}">Text Colors</a>
            <a href="{{ route('backgroundinv.index') }}">Backgrounds</a>
            <a href="{{ route('coachinv.index') }}">Coaches</a>
        </nav>
    @endif
    {{ $slot }}
</body>

</html>