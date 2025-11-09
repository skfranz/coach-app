<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Task;

class TagController extends Controller
{
    // Creates a new Tag
    public function create(Request $request)
    {
        // Takes data from "Create Tag Form" request and checks it - if failed, don't create new Tag
        $data = $request->validate([
                'name' => ['required'],         // Name (from form) is required
                'description' => ['nullable'],  // Description is optional
            ]);

        Tag::create($data);    // If successful, create new item with form data
        return redirect()->route('tags.index'); // Return to Tags page
    }

    // Delete a Tag (Delete form submits $tag object)
    public function delete(Tag $tag) {
        $tag->delete();
        return back();
    }

    // Update an existing Tag with new data
    public function update(Request $request, Tag $tag) {

        // Validation for update form
        $data = $request->validate([
                'name' => ['required'],         // Name is required
                'description' => ['nullable'],  // Description is optional
            ]);

        $tag->update($data); // If form has all required components, update data
        return back();  // Refresh/return back to page
    }

    // Changes the Tag's 'complete_status' - Used to complete a Tag or "undo" a completed Tag
    public function complete(Tag $tag) {
        $tag->update(['complete_status' => !$tag->complete_status]); // Update complete_status to the opposite of what it was
        return back();
    }

    // Detach a specific task from a tag
    public function detach(Tag $tag, Task $task) {
        $tag->tasks()->detach($task);
        return back();
    }
}
