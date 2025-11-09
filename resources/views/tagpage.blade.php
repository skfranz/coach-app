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
        <select name="tasks[]" multiple> <!--Multi-select input needs [] in form name-->
            @foreach ($tasks as $tag)
                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endforeach
        </select>
        <button type="submit">Submit</button>
    </form>

</x-layout>