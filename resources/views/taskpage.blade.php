<x-layout title="Task Page" header="Tasks:">
    <br>
    <h4> <!--Two drop downs that will change the request whenever they are changed for sorting purposes-->
        <form id="sortForm" method="GET" action="{{ route('tasks.index') }}" class="inline-form">
            <label for="sort">Sort By: </label>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="default" {{ request('sort', 'default') === 'default' ? 'selected' : '' }}>Default</option>
                <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                <option value="difficulty" {{ request('sort') === 'difficulty' ? 'selected' : '' }}>Difficulty</option>
                <option value="tags" {{ request('sort') === 'tags' ? 'selected' : '' }}>Tags</option>
            </select>

            <select name="direction" id="direction" onchange="this.form.submit()">
                <option value="asc" {{ request('direction', 'asc') === 'asc' ? 'selected' : '' }}>Asc</option>
                <option value="desc" {{ request('direction') === 'desc' ? 'selected' : '' }}>Desc</option>
            </select>
        </form>
    </h4>
    <x-tasks :tasks="$tasks" :tags="$tags"></x-tasks>
</x-layout>
