<!--
Program Name: options.blade.php
Description: Webpage for viewing the options page and choosing which cosmetics to apply
Input: Owned cosmetics and default cosmetics
Output: Application changes based off selected cosmetics
-->

<x-layout title="Options" header="Options/Customization:">
    <x-cosmetics :cosmetics="$cosmetics"></x-cosmetics>
</x-layout>
