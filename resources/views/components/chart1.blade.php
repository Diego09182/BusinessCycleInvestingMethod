<div class="row">
    <div id="console" class="card col m6 right">
        <div class="card-content">
            <form id="stockForm">
                <div class="row">
                    <div class="input-field col m5">
                        <select name="preset_symbol" id="preset_symbol">
                            <option value="" disabled>選擇追蹤指數ETF</option>
                            <option value="006208" {{ $symbol === '006208' ? 'selected' : '' }}>006208(富邦台50)</option>
                            <option value="00646" {{ $symbol === '00646' ? 'selected' : '' }}>00646(元大S&P500)</option>
                            <option value="00662" {{ $symbol === '00662' ? 'selected' : '' }}>00662(富邦NASDAQ)</option>
                            <option value="00668" {{ $symbol === '00668' ? 'selected' : '' }}>00668(國泰美國道瓊)</option>
                            <option value="00830" {{ $symbol === '00830' ? 'selected' : '' }}>00830(國泰費城半導體)</option>
                        </select>
                        <label for="preset_symbol">追蹤指數ETF</label>
                    </div>
                    <div class="input-field col m5">
                        <input type="text" name="custom_symbol" id="custom_symbol" placeholder="股市代號" value="{{ request('custom_symbol', '') }}">
                        <label for="custom_symbol">股市代號查詢</label>
                    </div>
                    <button type="submit" class="btn black waves-effect waves-light right">查詢</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card col m6 left">
        <div class="card-content">
            <div class="row">
                <button @click="showChart1('compositeLeadingIndicator')" class="btn black">訂單擴散指數</button>
                <button @click="showChart1('manufacturersNewOrders')" class="btn black">新訂單</button>
                <button @click="showChart1('inventoriesToSalesRatio')" class="btn black">庫銷比</button>
                <button @click="showChart1('producerPriceIndex')" class="btn black">生產者物價</button>
                <button @click="showChart1('initialClaims')" class="btn black">失業人數</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="card col m6 left">
        <div class="card-content">
            <canvas v-show="Chart1 === 'producerPriceIndex'" id="producerPriceIndexChart"></canvas>
            <canvas v-show="Chart1 === 'manufacturersNewOrders'" id="manufacturersNewOrdersChart"></canvas>
            <canvas v-show="Chart1 === 'inventoriesToSalesRatio'" id="inventoriesToSalesRatioChart"></canvas>
            <canvas v-show="Chart1 === 'compositeLeadingIndicator'" id="compositeLeadingIndicatorChart"></canvas>
            <canvas v-show="Chart1 === 'initialClaims'" id="initialClaimsChart"></canvas>
        </div>
    </div>
    <div class="card col m6 right">
        <div class="card-content">
            <canvas id="stockChart"></canvas>
        </div>
    </div>
</div>
