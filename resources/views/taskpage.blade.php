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

    <!--Create a div for the coach window-->
    <div style="position: fixed; top: 20px; right: 20px; display: none;" id="coach"> <!--Fix this div in the top right of the screen-->
        <img src="{{ asset('images/goat.jpg') }}" alt="Coach" width="444" id="coach_image">
        <div id="coach-bubble" class="hidden" width="444">Hello there! Ready to work?</div>
    </div>

    <script>
        // attempt to load the coach when ready
        const coach = document.getElementById('coach');
        coach.style.display = 'inline';

        // display a message below the coach for an interval (default 4s)
        function coachMessage(text, ms = 4000) {
            const bubble = document.getElementById('coach-bubble');
            // if (!bubble) return;
            bubble.textContent = text;
            bubble.classList.remove('hidden');
            clearTimeout(window.__coachHideTimer);
            window.__coachHideTimer = setTimeout(() => bubble.classList.add('hidden'), ms);
        }

        // call coachMessage if the page reloaded with a coach msg
        const msg = @json(session('coach'));
        if (msg) coachMessage(msg);

        // pick and display an idle message for the coach to say
        function idleMessage() {
            const lines = [
                "What are you waiting for?",
                "Seize the day!",
                "I sure hope you're working on those tasks.",
                "Don't put the pro in procrastination.",
                "Task 1. Hurry up!"
            ]
            coachMessage(lines[Math.floor(Math.random() * lines.length)], 5000);
        }

        // give the coach an idle msg every 20s
        setInterval(() => {
            idleMessage();
        }, 10000);

    </script>

</x-layout>
