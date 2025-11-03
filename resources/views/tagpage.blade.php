<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Tag Page</title>
</head>


<body>
    <h3>Tags:</h3>

    <!--Navigation Bar-->
    <nav style="display:flex; align-items:center; gap:10px;">
        <a href="{{ route('tasks.index') }}">Tasks</a>
        <a href="{{ route('completed.index') }}">Completed Tasks</a>
    </nav>

    <br>

    <!--Displays each tag in its own div/box-->
    @foreach ($tags as $tag)
        <div style="display: inline-block; border-style: solid; padding: 0px 10px 10px; margin-bottom: 20px">
            
            <p style="font-weight: bold;">{{ $tag->name }}</p> <!--Show Tag Name-->
            <p>Description: {{ $tag->description }}</p>        <!--Show Tag Description-->

            <div style="display:flex; align-items:center; gap:10px;">

                <!--Delete Form-->
                <form action="{{ route('tags.delete', $tag) }}" method="POST"> <!--Send delete request to delete route in web.php, which goes to delete function in TagController-->
                    @method('DELETE')   <!--Specify request method is "DELETE"-->
                    @csrf               <!--Form Security token submission-->
                    <button type="submit">Delete</button>
                </form>

                <!--Complete Form-->
                <form action="{{ route('tags.complete', $tag) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <button type="submit">Complete</button>
                </form>

            </div><br>

            <!-- Update Form-->
            <form action="{{ route('tags.update', $tag) }}" method="POST">
                @method('PATCH')
                @csrf
                Name: <input name="name" placeholder="{{ $tag->name }}"></input>
                Description: <input name="description" placeholder="{{ $tag->description}}"></input>
                <button type="submit">Update</button>
            </form>

        </div>
    <br>
    @endforeach

    <h4>Create New Tag:</h4>
    
    <!--Create New tag form-->
    <form action="{{ route('tags.create') }}" method="POST"> <!--Send create/post request to create route in web.php, which goes to create function in TagController-->
        @csrf
        Name: <input name="name"></input>
        Description: <input name="description"></input>
        <button type="submit">Submit</button>
    </form>

</body>

</html>