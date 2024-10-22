<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{

    // 資產列表
    public function index()
    {
        // 取得所有資產
        $assets = Asset::all();

        return view('asset.index', ['assets' => $assets]);
    }
    
    // 新增資產
    public function store(Request $request)
    {
        // 驗證輸入
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'value' => 'required|integer'
        ]);

        // 建立資產
        $asset = Asset::create($validated);

        return redirect()->back()->with('message', '資產已新增')->with('data', $asset);
    }

    // 更新資產
    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        // 驗證輸入
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'value' => 'required|integer'
        ]);

        // 更新資產
        $asset->update($validated);

        return redirect()->back()->with('message', '資產已更新')->with('data', $asset);
    }

    // 刪除資產
    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return redirect()->back()->with('message', '資產已刪除');
    }
}
