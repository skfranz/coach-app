<x-layout title="Completed Tasks/Tags Page" header="Completed Tasks/Tags:">

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
            <p>Difficulty: {{ $task->difficulty }} ({{ $task->coin_value }} coins)</p>

            <!--Show subtasks-->
            @foreach ($task->subtasks as $subtask)
                <div style="display:flex; gap: 10px;">
                    <form action="{{ route('tasks.subtasks.update', [$task, $subtask]) }}" method="POST">
                        @csrf <!-- Cross-Site Request Forgery, not sure if necessary -->
                        @method('PATCH')
                        <input type="checkbox" name="complete_status" value="1"
                            onchange="this.form.submit()" {{ $subtask->complete_status ? 'checked' : '' }}>
                        {{ $subtask->description }}
                    </form>
                    <form action="{{ route('tasks.subtasks.destroy', [$task, $subtask]) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">X</button>
                    </form>
                </div>
            @endforeach

            <br>
            
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

            <!-- Add a subtask to your task -->
            <form action="{{ route('tasks.subtasks.store', $task) }}" method="POST">
                @csrf
                <input type="text" name="description" placeholder="New Subtask" required>
                <button type="submit">Add</button>
            </form>

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
                    <option value="Easy" @selected($task->difficulty == "Easy")>Easy</option>
                    <option value="Medium" @selected($task->difficulty == "Medium")>Medium</option> @selected($task->difficulty)
                    <option value="Hard" @selected($task->difficulty == "Hard")>Hard</option> 
                    <option value="Very Hard" @selected($task->difficulty == "Very Hard")>Very Hard</option>
                </select>
                Repeats: <select name="repeats">
                    <option value="0" @selected($task->repeats == 0)>No</option>
                    <option value="1" @selected($task->repeats == 1)>Yes</option>
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
    
</x-layout>