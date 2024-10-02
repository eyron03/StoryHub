<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\GradeLevel;
use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ChildrenController extends Controller
{
    //      
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'childFirstName' => 'required|string|max:255',
            'childLastName' => 'required|string|max:255',
            'childDob' => 'required|date',
            'childAddress' => 'required|string|max:255',
            'childGender' => 'required|in:male,female',
        ]);
    
        // Parse the date of birth and compute the age
        $dob = Carbon::parse($validatedData['childDob']);
        $age = $dob->diffInYears(Carbon::now());
    
        // Get parent ID from the session
        $parentId = $request->session()->get('logged_in_parent_id');
    
        // Find parent information
        $parent = Parents::find($parentId);
        $parentName = $parent ? $parent->pFname . ' ' . $parent->pLname : 'Unknown Parent';
    
        // Generate custom ID
        $customId = $this->generateCustomId();
    
        // Create new child record, including age
        $child = Children::create(array_merge($validatedData, [
            'parent_id' => $parentId,
            'custom_id' => $customId,
            'childAge' => $age
        ]));
    
        // Log child creation
        Log::info('New child created:', [
            'ChildFirstName' => $child->childFirstName,
            'ChildLastName' => $child->childLastName,
            'ParentName' => $parentName,
        ]);
    
        // Prepare parents and child data for response
        $parents = $parent ? ['id' => $parent->id, 'name' => $parentName] : [];
    
        // Redirect back with parents and child data
        return redirect()->back()->with(['parents' => $parents, 'child' => $child])->with('success', 'Child added successfully!');
    }


    private function generateCustomId()
    {
        // Example logic for custom ID generation (adjust as needed)
        $lastChild = Children::orderBy('id', 'desc')->first();
        $lastId = $lastChild ? $lastChild->id + 1 : 1;
        return '24-CD-' . str_pad($lastId, 2, '0', STR_PAD_LEFT);
    }
        public function edit($childId)
    {
        $child = Children::findOrFail($childId); // Adjust model name as per your actual implementation
    
        return response()->json($child);
    }
    

    public function updateChild(Request $request)
{
    
    $child = Children::findOrFail($request->id);
    
    
    $oldValues = $child->getAttributes();
    
    
    if ($request->has('childDob')) {
        $dob = Carbon::parse($request->input('childDob'));
        $age = $dob->diffInYears(Carbon::now());
        $request->merge(['childAge' => $age]);
    }
    
  
    $child->update($request->except('id')); // Exclude the ID from the update

    // Log the update operation
    Log::info('Child updated:', [
        'child_id' => $child->id,
        'old_values' => $oldValues,
        'updated_values' => $request->except(['id']), // Exclude the token and ID from the logged values
    ]);

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Updated successfully!');
}
    
    public function destroy($id)
{
    // Find the child by ID or fail if not found
    $child = Children::findOrFail($id);

    // Log the deletion operation
    Log::info('Child deleted:', [
        'ChildID' => $child->custom_id,
        'ChildFirstName' => $child->childFirstName, // Assuming you have a 'name' attribute; adjust as needed
        'deleted_at' => now()->toDateTimeString(),
    ]);

    // Delete the child
    $child->delete();

    // Return JSON response
    return response()->json(['message' => 'Children deleted successfully']);
}

}
        