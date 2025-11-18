<x-layout title="Shop Page" header="Shop:">

    @foreach($cosmetics as $cosmetic)
        <div style="display: inline-block; border-style: solid; padding: 0px 10px 10px; margin-top: 20px">

            <div style="display:flex; float:right; margin-top: 10px; gap:10px;">
                <button>Buy</button>
            </div>

            <p>{{ $cosmetic->name }}<p>
            <p>Type: {{ $cosmetic->type }}</p>
            @isset($cosmetic->description)<p>Description: {{ $cosmetic->description }}</p>@endisset
            <p>Price: {{ $cosmetic->price }}</p>
        <div>
    @endforeach
</x-layout>