@extends('layouts.app')

@section('content')
    <div class="container">

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
                        <button @click="showChart1('compositeLeadingIndicator')" class="btn black">領先指標</button>
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
                    <canvas v-show="currentChart1 === 'producerPriceIndex'" id="producerPriceIndexChart"></canvas>
                    <canvas v-show="currentChart1 === 'manufacturersNewOrders'" id="manufacturersNewOrdersChart"></canvas>
                    <canvas v-show="currentChart1 === 'inventoriesToSalesRatio'" id="inventoriesToSalesRatioChart"></canvas>
                    <canvas v-show="currentChart1 === 'compositeLeadingIndicator'" id="compositeLeadingIndicatorChart"></canvas>
                    <canvas v-show="currentChart1 === 'initialClaims'" id="initialClaimsChart"></canvas>
                </div>
            </div>
            <div class="card col m6 right">
                <div class="card-content">
                    <canvas id="stockChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card col m6 left">
                <div class="card-content">
                    <div class="row">
                        <button @click="showChart2('gdp')" class="btn black left">GDP年增率</button>
                        <button @click="showChart2('inflation')" class="btn black left">消費者物價</button>
                        <button @click="showChart2('unemployment')" class="btn black left">失業率</button>
                        <button @click="showChart2('corporateProfits')" class="btn black left">企業利潤</button>
                        <button @click="showChart2('realImports')" class="btn black left">進口貨物</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card col m6 left">
                <div class="card-content">
                    <canvas v-show="currentChart2 === 'unemployment'" id="unemploymentChart"></canvas>
                    <canvas v-show="currentChart2 === 'inflation'" id="inflationChart"></canvas>
                    <canvas v-show="currentChart2 === 'gdp'" id="gdpChart"></canvas>
                    <canvas v-show="currentChart2 === 'corporateProfits'" id="corporateProfitsChart"></canvas>
                    <canvas v-show="currentChart2 === 'realImports'" id="realImportsChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col m12">
                <h4><b>成交資訊</b></h4>
                <table class="highlight striped">
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

        <div class="row">
            <h2 class="center-align"><b>經濟新聞</b></h2>
            <div class="row">
                @foreach($newsData['articles'] as $article)
                    <div class="col m4">
                        <div class="card">
                            <div class="card-image">
                                <img src="{{ $article['urlToImage'] }}" alt="News Image">
                            </div>
                            <div class="card-content">
                                <b><h5>{{ $article['title'] }}</h5></b>
                                <p>{{ $article['description'] }}</p>
                            </div>
                            <div class="card-action">
                                <a href="{{ $article['url'] }}" target="_blank">閱讀原文</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {

    fetchData('0050');

    $('#stockForm').on('submit', function(e) {
        e.preventDefault();
        const symbol = $(this).find('select[name="preset_symbol"]').val() || $(this).find('input[name="custom_symbol"]').val();
        fetchData(symbol);
    });
    
});

function fetchData(symbol) {
    $.ajax({
        url: '{{ route('stock.request') }}',
        type: 'GET',
        data: { preset_symbol: symbol },
        success: function(response) {
            if (response.data && Array.isArray(response.data.data)) {
                const stockData = response.data.data;
                drawChart(stockData);
                stockTable(stockData);
                M.AutoInit();
            } else {
                console.error('錯誤請求格式:', response);
            }
            drawUnemploymentChart(response.unemploymentData);
            drawInflationChart(response.inflationData);
            drawGDPChart(response.gdpGrowthData.observations);
            drawProducerPriceIndexChart(response.producerPriceIndexData);
            drawManufacturersNewOrdersChart(response.manufacturersNewOrdersData);
            drawInventoriesToSalesRatioChart(response.inventoriesToSalesRatioData);
            drawCompositeLeadingIndicatorChart(response.compositeLeadingIndicatorData);
            drawInitialClaimsChart(response.initialClaimsData);
            drawCorporateProfitsChart(response.corporateProfitsData);
            drawRealImportsChart(response.realImportsData);
        }
    });
}

function stockTable(stockData) {
    const tbody = $('table tbody');
    tbody.empty();
    stockData.forEach(row => {
        let tr = '<tr>';
        row.forEach(value => {
            tr += `<td>${value}</td>`;
        });
        tr += '</tr>';
        tbody.append(tr);
    });
}

function drawChart(stockData) {
    if (window.chart) {
        window.chart.destroy();
    }
    const labels = stockData.map(row => row[0]);
    const prices = stockData.map(row => row[6]);
    const stockChart = document.getElementById('stockChart').getContext('2d');
    window.chart = new Chart(stockChart, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: '收盤價',
                data: prices,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: '日期'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: '價格(新台幣)'
                    },
                    beginAtZero: false
                }
            }
        }
    });
}

function drawUnemploymentChart(unemploymentData) {
    const labels = unemploymentData['observations'].map(observation => {
        const date = new Date(observation['date']);
        return date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0');
    });
    const unemploymentRates = unemploymentData['observations'].map(observation => observation['value']);
    const unemploymentChart = document.getElementById('unemploymentChart').getContext('2d');
    window.unemploymentChart = new Chart(unemploymentChart, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: '失業率 (%)',
                data: unemploymentRates,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderWidth: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: '日期'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: '失業率 (%)'
                    },
                    beginAtZero: false
                }
            }
        }
    });
}

function drawInflationChart(inflationData) {
    const labels = inflationData['observations'].map(observation => {
        const date = new Date(observation['date']);
        return date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0');
    });
    const inflationRates = inflationData['observations'].map(observation => observation['value']);
    const inflationChart = document.getElementById('inflationChart').getContext('2d');
    window.inflationChart = new Chart(inflationChart, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: '消費者物價指數 (%)',
                data: inflationRates,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: '日期'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: '物價指數 (%)'
                    },
                    beginAtZero: false
                }
            }
        }
    });
}

function drawGDPChart(gdpGrowthData) {
    const labels = gdpGrowthData.map(observation => {
        const date = new Date(observation['date']);
        return date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0');
    });
    const gdpGrowthRates = gdpGrowthData.map(observation => observation['value']);
    const gdpChart = document.getElementById('gdpChart').getContext('2d');
    window.gdpChart = new Chart(gdpChart, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'GDP年增率 (%)',
                data: gdpGrowthRates,
                borderColor: 'rgba(255, 206, 86, 1)',
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderWidth: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: '日期'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'GDP年增率 (%)'
                    },
                    beginAtZero: false
                }
            }
        }
    });
}

function drawProducerPriceIndexChart(producerPriceIndexData) {
    const observations = producerPriceIndexData['observations'] || [];
    const labels = observations.map(observation => {
        const date = new Date(observation['date']);
        return date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0');
    });
    const producerPriceIndex = observations.map(observation => parseFloat(observation['value']));
    const producerPriceIndexChart = document.getElementById('producerPriceIndexChart').getContext('2d');
    window.producerPriceIndexChart = new Chart(producerPriceIndexChart, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: '生產者物價指數',
                data: producerPriceIndex,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderWidth: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: '日期'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: '指數'
                    },
                    beginAtZero: false
                }
            }
        }
    });
}

function drawManufacturersNewOrdersChart(manufacturersNewOrdersData) {
    const observations = manufacturersNewOrdersData['observations'] || [];
    const labels = observations.map(observation => {
        const date = new Date(observation['date']);
        return date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0');
    });
    const manufacturersNewOrders = observations.map(observation => parseFloat(observation['value']));
    const manufacturersNewOrdersChart = document.getElementById('manufacturersNewOrdersChart').getContext('2d');
    window.manufacturersNewOrdersChart = new Chart(manufacturersNewOrdersChart, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: '製造業新訂單',
                data: manufacturersNewOrders,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: '日期'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: '訂單數'
                    },
                    beginAtZero: false
                }
            }
        }
    });
}

function drawInventoriesToSalesRatioChart(inventoriesToSalesRatioData) {
    const observations = inventoriesToSalesRatioData['observations'] || [];
    const labels = observations.map(observation => {
        const date = new Date(observation['date']);
        return date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0');
    });
    const inventoriesToSalesRatio = observations.map(observation => parseFloat(observation['value']));
    const inventoriesToSalesRatioChart = document.getElementById('inventoriesToSalesRatioChart').getContext('2d');
    window.inventoriesToSalesRatioChart = new Chart(inventoriesToSalesRatioChart, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: '庫存銷售比率',
                data: inventoriesToSalesRatio,
                borderColor: 'rgba(153, 102, 255, 1)',
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderWidth: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: '日期'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: '比率'
                    },
                    beginAtZero: false
                }
            }
        }
    });
}

function drawCompositeLeadingIndicatorChart(compositeLeadingIndicatorData) {
    const observations = compositeLeadingIndicatorData['observations'] || [];
    const labels = observations.map(observation => {
        const date = new Date(observation['date']);
        return date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0');
    });
    const compositeLeadingIndicator = observations.map(observation => parseFloat(observation['value']));
    const compositeLeadingIndicatorChart = document.getElementById('compositeLeadingIndicatorChart').getContext('2d');
    window.compositeLeadingIndicatorChart = new Chart(compositeLeadingIndicatorChart, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: '綜合領先指標',
                data: compositeLeadingIndicator,
                borderColor: 'rgba(255, 159, 64, 1)',
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderWidth: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: '日期'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: '指標值'
                    },
                    beginAtZero: false
                }
            }
        }
    });
}

function drawInitialClaimsChart(initialClaimsData) {
    const observations = initialClaimsData['observations'] || [];
    const labels = observations.map(observation => {
        const date = new Date(observation['date']);
        return date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0') + '-' + date.getDate().toString().padStart(2, '0');
    });
    const initialClaims = observations.map(observation => parseFloat(observation['value']));
    
    const initialClaimsChart = document.getElementById('initialClaimsChart').getContext('2d');
    window.initialClaimsChart = new Chart(initialClaimsChart, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: '初次申請失業救濟金',
                data: initialClaims,
                borderColor: 'rgba(153, 102, 255, 1)',
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderWidth: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: '日期'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: '申請數量'
                    },
                    beginAtZero: false
                }
            }
        }
    });
}

function drawCorporateProfitsChart(corporateProfitsData) {
    const observations = corporateProfitsData['observations'] || [];
    const labels = observations.map(observation => {
        const date = new Date(observation['date']);
        return date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0');
    });
    const corporateProfits = observations.map(observation => parseFloat(observation['value']));
    const corporateProfitsChart = document.getElementById('corporateProfitsChart').getContext('2d');
    window.corporateProfitsChart = new Chart(corporateProfitsChart, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: '企業稅後利潤',
                data: corporateProfits,
                borderColor: 'rgba(255, 159, 64, 1)',
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderWidth: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: '日期'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: '利潤(十億美元)'
                    },
                    beginAtZero: false
                }
            }
        }
    });
}

function drawRealImportsChart(realImportsData) {
    const observations = realImportsData['observations'] || [];
    const labels = observations.map(observation => {
        const date = new Date(observation['date']);
        return date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0');
    });
    const realImports = observations.map(observation => parseFloat(observation['value']));
    const realImportsChart = document.getElementById('realImportsChart').getContext('2d');
    window.realImportsChart = new Chart(realImportsChart, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: '實際進口額',
                data: realImports,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: '日期'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: '金額(十億美元)'
                    },
                    beginAtZero: false
                }
            }
        }
    });
}

const { createApp } = Vue;

createApp({
    data() {
        return {
            currentChart1: 'compositeLeadingIndicator',
            currentChart2: 'unemployment'
        };
    },
    methods: {
        showChart1(chart) {
            this.currentChart1 = chart;
        },
        showChart2(chart) {
            this.currentChart2 = chart;
        }
    }
}).mount('#app');

</script>
@endsection
