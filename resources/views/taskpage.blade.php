<x-layout title="Task Page" header="Tasks:">

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
            <p>Difficulty: {{ $task->difficulty }} ({{ $task->coin_value }} coins)</p>

            <!--Show subtasks-->
            @foreach ($task->subtasks as $subtask)
                <div style="display:flex; gap: 10px;>
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
            <form action="{{ route('tasks.subtasks.store', $task) }}" method="POST" style="margin-top: 40px; margin-bottom: -50px">
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
        Repeats: <select name="repeats">
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select>
        <button type="submit">Submit</button>
    </form>

    <!--
    Error handling, addresses a lot of the errors thrown by trying to POST/submit
    -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</x-layout>
