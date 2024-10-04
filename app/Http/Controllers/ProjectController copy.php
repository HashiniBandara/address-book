<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{

    public function index()
    {
        $projects = Project::with('customers')->paginate(10); // Eager load customers
        return view('admin.project.index', compact('projects'));
    }


    // Show the form for creating a new resource
    public function create()
    {
        return view('admin.project.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Project::create($request->all());

        return redirect()->route('admin.project.index')->with('success', 'Project created successfully.');
    }

    // Display the specified resource
    public function show(Project $project)
    {
        return view('admin.project.show', compact('project'));
    }

    // Show the form for editing the specified resource
    public function edit(Project $project)
    {
        return response()->json(['project' => $project]);
    }



    // Update the specified resource in storage
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $project->update($request->all());

        return response()->json(['success' => true, 'message' => 'Project updated successfully.']);
    }


    // Toggle Project Status (Instead of Deleting)
    public function toggleStatus(Project $project)
    {
        // Toggle the deleted_at field
        $project->deleted_at = $project->deleted_at ? 0 : 1; // Change to 0 for active, 1 for inactive
        $project->save();

        return response()->json(['success' => 'Project status updated']);
    }

// Fetch active customers
public function getActiveCustomers()
{
    $customers = Customer::where('deleted_at', 0)->get();
    return response()->json(['customers' => $customers]);
}


public function addCustomers(Request $request)
{
    $project = Project::find($request->project_id);

    // Attach the selected customers to the project
    $project->customers()->sync($request->customers);

    return response()->json(['success' => true, 'message' => 'Customers added to project successfully']);
}



}
