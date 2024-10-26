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

        // 計算資產總額
        $totalValue = $assets->sum('value');

        // 計算每個資產的百分比
        foreach ($assets as $asset) {

            if ($totalValue > 0) {
                $asset->percentage = ($asset->value / $totalValue) * 100;
            } else {
                $asset->percentage = 0;
            }

        }

        return view('asset.index', ['assets' => $assets, 'totalValue' => $totalValue]);
    }

    // 新增資產
    public function store(Request $request)
    {
        // 驗證輸入
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'value' => 'required|integer',
        ]);

        // 建立資產
        $asset = Asset::create($validated);

        return redirect()->back()->with('data', $asset);
    }

    // 更新資產
    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        // 驗證輸入
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'value' => 'required|integer',
        ]);

        // 更新資產
        $asset->update($validated);

        return redirect()->back()->with('data', $asset);
    }

    // 刪除資產
    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return redirect()->back();
    }
}
