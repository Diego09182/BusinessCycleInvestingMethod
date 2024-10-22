<div class="row">
    <div class="col m12">
        <h2 class="center-align"><b>成交資訊</b></h2>
        <table id="stockTable" class="highlight striped">
            <thead>
                <tr>
                    <th>日期</th>
                    <th>成交股數</th>
                    <th>成交金額</th>
                    <th>開盤價</th>
                    <th>最高價</th>
                    <th>最低價</th>
                    <th>收盤價</th>
                    <th>漲跌幅(%)</th>
                    <th>成交數</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['data'] as $row)
                    <tr>
                        @foreach($row as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>