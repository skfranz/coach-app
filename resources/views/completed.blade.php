<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Completed Tasks Page</title>
</head>


<body>
    <h3>Completed Tasks:</h3>

    <!--Navigation Bar-->
    <nav style="display:flex; align-items:center; gap:10px;">
        <a href="{{ route('tasks.index') }}">Tasks</a>
        <a href="{{ route('completed.index') }}">Completed Tasks</a>
    </nav>

    <br>

    <!--Displays each task in its own div/box-->
    @foreach ($tasks as $task)
        <div style="display: inline-block; border-style: solid; padding: 0px 10px 10px; margin-bottom: 20px">
            
            <p style="font-weight: bold;">{{ $task->name }}</p> <!--Show Task Name-->
            <p>Description: {{ $task->description }}</p>        <!--Show Task Description-->

            <div style="display:flex; align-items:center; gap:10px;">

                <!--Delete Form-->
                <form action="{{ route('tasks.delete', $task) }}" method="POST"> <!--Send delete request to delete route in web.php, which goes to delete function in TaskController-->
                    @method('DELETE')   <!--Specify request method is "DELETE"-->
                    @csrf               <!--Form Security token submission-->
                    <button type="submit">Delete</button>
                </form>

                <!--Undo Complete Form-->
                <form action="{{ route('tasks.complete', $task) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <button type="submit">Undo Complete</button>
                </form>

            </div><br>

            <!-- Update Form-->
            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @method('PATCH')
                @csrf
                Name: <input name="name" placeholder="{{ $task->name }}"></input>
                Description: <input name="description" placeholder="{{ $task->description}}"></input>
                <button type="submit">Update</button>
            </form>

        </div>
    <br>
    @endforeach

</body>

</html>