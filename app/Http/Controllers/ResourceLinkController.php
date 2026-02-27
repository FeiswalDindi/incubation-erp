<?php

namespace App\Http\Controllers;

use App\Models\ResourceLink;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ResourceLinkController extends Controller
{
    public function index()
    {
        $resources = ResourceLink::with('creator:id,name')->latest()->get();

        return Inertia::render('Resources/Index', [
            'resources' => $resources
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:500',
            'category' => 'required|string|max:50',
        ]);

        ResourceLink::create([
            'title' => $validated['title'],
            'url' => $validated['url'],
            'category' => $validated['category'],
            'created_by' => Auth::id(),
        ]);

        return redirect()->back()->with('message', 'Resource link added successfully!');
    }

    public function destroy(ResourceLink $resource)
    {
        $resource->delete();
        return redirect()->back()->with('message', 'Resource deleted successfully.');
    }
}