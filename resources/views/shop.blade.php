<x-layout title="Shop Page" header="Shop:">
    @error('cost')
        <p style="color: red;">{{ $message }}</p>
    @enderror
    <x-cosmetics :cosmetics="$cosmetics"></x-cosmetics>
</x-layout>