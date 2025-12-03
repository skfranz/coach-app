<!--
Program Name: shop.blade.php
Description: Webpage for viewing and purchasing cosmetic items
Input: Cosmetics table from database, user input: clicking on buttons
Output: Display of all cosmetic items in the database and their purchased status, updates to purchased states of entries in cosmetics database
-->

<x-layout title="Shop Page" header="Shop:">
    @error('cost')
        <p style="color: red;">{{ $message }}</p>
    @enderror
    <x-cosmetics :cosmetics="$cosmetics"></x-cosmetics>
</x-layout>
