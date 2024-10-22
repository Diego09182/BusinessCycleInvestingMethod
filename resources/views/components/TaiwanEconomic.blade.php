<div class="container mx-auto p-4">
    <h2 class="center-align"><b>台灣經濟數據</b></h2>
    <div class="row">
        <div class="col m12">
            <table class="table-auto w-full text-left">
                <thead>
                    <tr>
                        <th>日期</th>
                        <th>經濟成長率 (%)</th>
                        <th>平均每人國民所得 (美元)</th>
                        <th>儲蓄率 (%)</th>
                        <th>失業率 (%)</th>
                        <th>生產者物價年增率 (%)</th>
                        <th>消費者物價年增率 (%)</th>
                        <th>工業及服務業平均月工時 (小時)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($governmentData['result']['records'] as $row)
                        <tr>
                            <td>{{ $row['日期（月別）'] }}</td>
                            <td>{{ $row['經濟成長率'] }}</td>
                            <td>{{ $row['平均每人國民所得毛額（美元）'] }}</td>
                            <td>{{ $row['儲蓄率'] }}</td>
                            <td>{{ $row['失業率（百分比）'] }}</td>
                            <td>{{ $row['生產者物價-年增率'] }}</td>
                            <td>{{ $row['消費者物價-年增率'] }}</td>
                            <td>{{ $row['工業及服務業平均月工時（小時）'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>