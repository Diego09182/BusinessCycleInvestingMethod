<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::all();

        $totalValue = $assets->sum('value');

        foreach ($assets as $asset) {

            if ($totalValue > 0) {
                $asset->percentage = ($asset->value / $totalValue) * 100;
            } else {
                $asset->percentage = 0;
            }

        }

        return view('asset.index', ['assets' => $assets, 'totalValue' => $totalValue]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'value' => 'required|integer',
        ]);

        $asset = Asset::create($validated);

        return redirect()->back()->with('data', $asset);
    }

    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'value' => 'required|integer',
        ]);

        $asset->update($validated);

        return redirect()->back()->with('data', $asset);
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return redirect()->back();
    }
}
