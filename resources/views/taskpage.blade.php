<x-layout title="Task Page" header="Tasks:">

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

  /* Bubble tail */
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

    <!--Displays each task in its own div/box-->
    @foreach ($tasks as $task)
        <div style="display: inline-block; border-style: solid; padding: 0px 10px 10px; margin-top: 20px">
        
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
                    <button type="submit">Complete</button>
                </form>
            </div>
            
            <p style="font-weight: bold;">{{ $task->name }}</p>
            @isset($task->description)<p>Description: {{ $task->description }}</p>@endisset <!--Show Task Description (if there is one)-->

            <!--Show Associated Tags-->
            @foreach ($task->tags as $tag)
                <div style="display: inline-block; border-style: solid; padding: 5px 5px; margin-bottom: 20px">
                    <div style="display:flex; gap: 5px;"> {{ $tag->name }}
                        <!--Detach a tag from a task-->
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
                Difficulty: <select name="difficulty">
                    <option value="Easy">Easy</option>
                    <option value="Medium">Medium</option>
                    <option value="Hard">Hard</option>
                    <option value="Very Hard">Very Hard</option>
                </select>
                <button type="submit">Update</button>
            </form>

        </div>
    <br>
    @endforeach

    <br><h4>Create New Task:</h4> <!--Create Form-->
    <form action="{{ route('tasks.create') }}" method="POST"> <!--Send create/post request to create route in web.php, which goes to create function in TaskController-->
        @csrf
        Name: <input name="name"></input>
        Description: <input name="description"></input>

        <select name="tags[]" multiple> <!--Multi-select input needs [] in form name-->
            @foreach ($tags as $tag)
                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endforeach
        </select>
        Difficulty: <select name="difficulty">
            <option value="Easy">Easy</option>
            <option value="Medium">Medium</option>
            <option value="Hard">Hard</option>
            <option value="Very Hard">Very Hard</option>
        </select>
        <button type="submit">Submit</button>
    </form>

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
    </script>
    
</x-layout>