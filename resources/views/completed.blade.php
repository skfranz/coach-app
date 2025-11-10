<x-layout title="Completed Tasks/Tags Page" header="Completed Tasks/Tags:">

<style>
  /* Coach fixed top-right */
  #coach {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
  }

  /* Speech bubble under coach */
  #coach-bubble {
    background: #fff;
    border: 2px solid #444;
    border-radius: 12px;
    padding: 10px 14px;
    max-width: 444px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    text-align: center;
    font-family: system-ui, sans-serif;
    font-size: 18px;
    line-height: 1.3;
    position: relative;
  }

  /* Little tail pointing upward to coach */
  #coach-bubble::before {
    content: "";
    position: absolute;
    top: -8px;
    left: 50%;
    transform: translateX(-50%);
    border-width: 0 8px 8px 8px;
    border-style: solid;
    border-color: transparent transparent #444 transparent;
  }

  .hidden { display: none; }
</style>

    <h4>Past Tasks:</h4>
    <!--Displays each task in its own div/box-->
    @foreach ($tasks as $task)
        <div style="display: inline-block; border-style: solid; padding: 0px 10px 10px; margin-bottom: 20px">

            <div style="display:flex; float:right; margin-top: 10px; gap:10px;">

                <form action="{{ route('tasks.delete', $task) }}" method="POST"> <!--Send delete request to delete route in web.php, which goes to delete function in TaskController-->
                    @method('DELETE')   <!--Specify request method is "DELETE"-->
                    @csrf               <!--Form Security token submission-->
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this task?');">Delete</button>
                </form>

                <!--Complete Form-->
                <form action="{{ route('tasks.complete', $task) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <button type="submit">Undo Complete</button>
                </form>
            </div>
            
            <p style="font-weight: bold;">{{ $task->name }}</p>
            @isset($task->description)<p>Description: {{ $task->description }}</p>@endisset <!--Show Task Description (if there is one)-->

            <!--Show Associated Tags-->
            @foreach ($task->tags as $tag)
                <div style="display: inline-block; border-style: solid; padding: 5px 5px; margin-bottom: 20px">
                    <div style="display:flex; gap: 5px;"> {{ $tag->name }}
                        <form action="{{ route('tasks.detach', [$task, $tag]) }}" method="POST">
                            @method('PATCH')
                            @csrf
                            <button type="submit">X</button>
                        </form>
                    </div>
                </div>
            @endforeach

            <!--Update Form-->
            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @method('PATCH')
                @csrf
                Name: <input name="name" value="{{ $task->name }}"></input>
                Description: <input name="description" value="{{ $task->description}}"></input>
                <select name="tags[]" multiple> <!--Multi-select input needs [] in form name-->
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" @selected($task->tags->find($tag))>{{ $tag->name }}</option> <!--If tag already exists, select it in box-->
                    @endforeach
                </select>
                <button type="submit">Update</button>
            </form>

        </div>
        <br>
    @endforeach

    <h4>Past Tags:</h4>
    <!--Displays each tag in its own div/box-->
    @foreach ($tags as $tag)
        @if ($tag->complete_status == 1)
        <div style="display: inline-block; border-style: solid; padding: 0px 10px 10px; margin-bottom: 20px">
            
            <div style="display:flex; float:right; margin-top: 10px; gap:10px;">
        
                <p style="font-weight: bold;">{{ $task->name }}</p> <!--Show Task Name-->
                <p>Description: {{ $task->description }}</p>        <!--Show Task Description-->
                <p>Difficulty: {{ $task->difficulty }}</p>          <!--Show Task Difficulty-->
                <p>Reward: {{ $task->coin_value }} Coins</p>        <!--Show Task Coin Value-->

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
                    <button type="submit">Undo Complete</button>
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
        @endif
    @endforeach

    <!--Create a div for the coach window-->
    <div style="position: fixed; top: 20px; right: 20px;"> <!--Fix this div in the top right of the screen-->
        <img src="{{ asset('images/goat.jpg') }}" alt="Coach" width="444">
        <div id="coach-bubble" class="hidden">Hello there! Ready to work?</div>
    </div>

    <script> 
        // display a message below the coach for an interval (default 4s)
        function coachMessage(text, ms = 4000) {
            const bubble = document.getElementById('coach-bubble');
            // if (!bubble) return;
            bubble.textContent = text;
            bubble.classList.remove('hidden');
            // clearTimeout(window.__coachHideTimer);
            // window.__coachHideTimer = setTimeout(() => bubble.classList.add('hidden'), ms);
        }

        // call coachMessage if the page reloaded with a coach msg
        const msg = @json(session('coach'));
        if (msg) coachMessage(msg);

        function idleMessage() {
            console.log("Coach idle msg now");
            const lines = [
                "What are you waiting for?",
                "Seize the day!",
                "I sure hope you're working on those tasks.",
                "Don't put the pro in procrastination.",
                "Task 1. Hurry up!"
            ]
            coachMessage(lines[Math.floor(Math.random() * lines.length)]);
        }

        setInterval(() => {
            idleMessage();
        }, 20000);
    </script>
    
</x-layout>