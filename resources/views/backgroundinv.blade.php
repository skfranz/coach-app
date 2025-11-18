<x-cosdisplaylayout title="Background Inventory" subpage="Background" maintype="Inventory">
    <h4>Currently viewing backgrounds page</h4>

    <!--Displays each inventory item in its own div/box-->
    @foreach ($cosmetics as $cosmetic)
        <div style="display: inline-block; border-style: solid; padding: 0px 10px 10px; margin-top: 20px">

            <div style="display:flex; float:right; margin-top: 10px; gap:10px;">
            <p style="font-weight: bold;">{{ $cosmetic->name }}</p>
            @isset($cosmetic->description)<p>Description: {{ $cosmetic->description }}</p>@endisset <!--Show Task Description (if there is one)-->
            <p>Value: {{ $cosmetic->price }} coins</p>
            <br>
        </div>
    <br>
    @endforeach
</x-cosdisplaylayout>