<div class="row">
    <div class="card col m6 left">
        <div class="card-content">
            <div class="row">
                <button @click="showChart2('gdp')" class="btn black left">GDP年增率</button>
                <button @click="showChart2('inflation')" class="btn black left">消費者物價</button>
                <button @click="showChart2('unemployment')" class="btn black left">失業率</button>
                <button @click="showChart2('corporateProfits')" class="btn black left">企業利潤</button>
                <button @click="showChart2('realImports')" class="btn black left">進口貨物</button>
                <button @click="showChart2('consumerSentiment')" class="btn black left">消費者信心</button> <!-- 新增按鈕 -->
            </div>
        </div>
    </div>
    <div class="card col m6 right">
        <div class="card-content">
            <div class="row">
                <button @click="showChart3('federalFundsRate')" class="btn black left">聯邦基準利率</button>
                <button @click="showChart3('m2')" class="btn black left">貨幣供應量</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="card col m6 left">
        <div class="card-content">
            <canvas v-show="Chart2 === 'unemployment'" id="unemploymentChart"></canvas>
            <canvas v-show="Chart2 === 'inflation'" id="inflationChart"></canvas>
            <canvas v-show="Chart2 === 'gdp'" id="gdpChart"></canvas>
            <canvas v-show="Chart2 === 'corporateProfits'" id="corporateProfitsChart"></canvas>
            <canvas v-show="Chart2 === 'realImports'" id="realImportsChart"></canvas>
            <canvas v-show="Chart2 === 'consumerSentiment'" id="consumerSentimentChart"></canvas>
        </div>
    </div>
    <div class="card col m6 right">
        <div class="card-content">
            <canvas v-show="Chart3 === 'federalFundsRate'" id="federalFundsRateChart"></canvas>
            <canvas v-show="Chart3 === 'm2'" id="m2Chart"></canvas>
        </div>
    </div>
</div>
