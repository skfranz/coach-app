<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Task Page</title>
</head>

<body>
    <h3>Tasks:</h3>
    @foreach ($tasks as $task)
    <div style="display: inline-block; border-style: solid; padding: 0px 10px 10px; margin-bottom: 20px">
        
        <p style="font-weight: bold;">{{ $task->name }}</p>
        <p>Description: {{ $task->description }}</p>

        <form action="{{ route('tasks.delete', $task) }}" method="POST">
            @method('DELETE')
            @csrf
            <button type="submit">Delete</button>
        </form>
    </div>
    <br>
    @endforeach

    <h4>Create New Task:</h4>
     <form action="{{ route('tasks.create') }}" method="POST">
        @csrf
        Name: <input name="name"></input>
        Description: <input name="description"></input>
        <button type="submit">Submit</button>
    </form>

</body>

</html>