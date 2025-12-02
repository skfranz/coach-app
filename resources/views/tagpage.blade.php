<x-layout title="Tags Page" header="Tags:">

    <!--Displays each tag in its own div/box-->
    @foreach ($tags as $tag)
        <div style="display: inline-block; border-style: solid; padding: 0px 10px 10px; margin-top: 20px">
            
            <div style="display:flex; float:right; margin-top: 10px; gap:10px;">

                <!--Delete Form-->
                <form action="{{ route('tags.delete', $tag) }}" method="POST"> <!--Send delete request to delete route in web.php, which goes to delete function in TagController-->
                    @method('DELETE')   <!--Specify request method is "DELETE"-->
                    @csrf               <!--Form Security token submission-->
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this tag?');">Delete</button>
                </form>

                <!--Complete Form-->
                <form action="{{ route('tags.complete', $tag) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <button type="submit">Complete</button>
                </form>
            </div>
            
            <p style="font-weight: bold;">{{ $tag->name }}</p> <!--Show Tag Name-->
            @isset($tag->description)<p>Description: {{ $tag->description }}</p>@endisset <!--Show Tag Description (if there is one)-->

            <!--Show Associated Tasks-->
            @foreach ($tag->tasks as $task)
                <div style="display: inline-block; border-style: solid; padding: 5px 5px; margin-bottom: 20px">
                    <div style="display:flex; gap: 5px;"> {{ $task->name }}
                        <!--Detach a tag from a task-->
                        <form action="{{ route('tags.detach', [$tag, $task]) }}" method="POST">
                            @method('PATCH')
                            @csrf
                            <button type="submit">X</button>
                        </form>
                    </div>
                </div>
            @endforeach

            <!-- Update Form-->
            <form action="{{ route('tags.update', $tag) }}" method="POST">
                @method('PATCH')
                @csrf
                Name: <input name="name" value="{{ $tag->name }}"></input>
                Description: <input name="description" value="{{ $tag->description}}"></input>
                <button type="submit">Update</button>
            </form>

        </div>
    <br>
    @endforeach

    <br><h4>Create New Tag:</h4>
    <!--Create New Tag form-->
    <form action="{{ route('tags.create') }}" method="POST"> <!--Send create/post request to create route in web.php, which goes to create function in TagController-->
        @csrf
        Name: <input name="name"></input>
        Description: <input name="description"></input>
        <button type="submit">Submit</button>
    </form>

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
                "Get back to the Tasks page!",
                "Seize the day!",
                "I sure hope you're working on those tasks.",
                "Don't put the pro in procrastination.",
                "Task 1. Hurry up!",
                "You can admire your trophies when the work is done!"
            ]
            coachMessage(lines[Math.floor(Math.random() * lines.length)], 5000);
        }

        // give the coach an idle msg every 20s
        setInterval(() => {
            idleMessage();
        }, 10000);
    </script>

</x-layout>