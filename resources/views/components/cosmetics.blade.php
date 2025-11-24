@foreach($cosmetics as $cosmetic)

    <div style="display: inline-block; border-style: solid; padding: 0px 10px 10px; margin-top: 20px; margin-right: 10px;">

        <div style="display:flex; float:right; margin-top: 10px; gap:10px;">

            @if (request()->is('shop*')) <!--If on shop page, have option to buy cosmetics-->
            <form action="{{ route('cosmetics.buy', $cosmetic) }}" method="POST">
                @method('PATCH')
                @csrf
                <button type="submit">Buy</button>
            </form>
            @elseif (request()->is('options')) <!--Else if on options page, send form to equip cosmetics-->
                <form action="{{ route('cosmetics.equip', $cosmetic) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <button type="submit">Equip</button>
                </form>
            @endif
        </div>

        <!--Show Cosmetic Values-->
        <p>{{ $cosmetic->name }}<p>
        <p>Type: {{ $cosmetic->type }}</p>
        @isset($cosmetic->description)<p>Description: {{ $cosmetic->description }}</p>@endisset
        <p>Price: {{ $cosmetic->price }} coins</p>

    </div>

    @if ($loop->iteration % 5 == 0) <!--For every 5 items, create a new line (so it's like a grid)-->
        <br>
    @endif

@endforeach