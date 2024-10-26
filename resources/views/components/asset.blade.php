<div class="row">
    <div class="card col m6">
        <div class="card-content">
            <h4 class="left"><b>填寫資產資訊</b></h4>
            <br><br><br>
            <form action="{{ route('assets.store') }}" method="POST">
                @csrf 
                <div class="input-field">
                    <input type="text" id="name" name="name" required>
                    <label for="name">資產名稱</label>
                </div>
                <div class="input-field">
                    <input type="text" id="type" name="type" required>
                    <label for="type">資產類型</label>
                </div>
                <div class="input-field">
                    <input type="number" id="value" name="value" required>
                    <label for="value">資產價值</label>
                </div>
                <button type="submit" class="btn black right">新增資產</button>
            </form>
            <br><br>
        </div>
    </div>
    <div class="card col m6">
        <div class="card-content">
            <h5><b>資產總額：{{ $totalValue }}</b></h5>
            <table>
                <thead>
                    <tr>
                        <th>資產名稱</th>
                        <th>資產類型</th>
                        <th>資產價值</th>
                        <th>百分比</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assets as $asset)
                        <tr>
                            <td>{{ $asset->name }}</td>
                            <td>{{ $asset->type }}</td>
                            <td>{{ $asset->value }}</td>
                            <td>{{ number_format($asset->percentage, 2) }}%</td>
                            <td>
                                <form action="{{ route('assets.destroy', $asset->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn black right">刪除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <canvas id="assetsChart"></canvas>
        </div>
    </div>
</div>