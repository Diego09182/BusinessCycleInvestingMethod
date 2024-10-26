@extends('layouts.app')

@section('content')
<div class="container">

    @include('components.chart1')

    @include('components.chart2')

    @include('components.stock')

    @include('components.news')

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

$('#stockForm').on('submit', function(e) {
    e.preventDefault();
    const symbol = $('#custom_symbol').val() || $('#preset_symbol').val();
    fetchStockData(symbol);
});

function fetchData(symbol) {
    $.ajax({
        url: '{{ route('main.request') }}',
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
            drawfederalFundsEffectiveRateChart(response.federalFundsEffectiveRateData);
            drawM2Chart(response.m2Data);
        }
    });
}

function fetchStockData(symbol) {
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
        }
    });
}

function stockTable(stockData) {
    const tbody = $('#stockTable tbody');
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
                label: '未來新訂單;紐約的擴散指數',
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

function drawfederalFundsEffectiveRateChart(federalFundsEffectiveRateData) {
    const observations = federalFundsEffectiveRateData['observations'] || [];
    const labels = observations.map(observation => {
        const date = new Date(observation['date']);
        return date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0');
    });
    const federalFundsRates = observations.map(observation => parseFloat(observation['value']));
    const federalFundsRateChart = document.getElementById('federalFundsRateChart').getContext('2d');
    window.federalFundsRateChart = new Chart(federalFundsRateChart, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: '聯邦基金有效利率',
                data: federalFundsRates,
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
                        text: '利率 (%)'
                    },
                    beginAtZero: false
                }
            }
        }
    });
}

function drawM2Chart(m2Data) {
    const observations = m2Data['observations'] || [];
    const labels = observations.map(observation => {
        const date = new Date(observation['date']);
        return date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0');
    });
    const m2Values = observations.map(observation => parseFloat(observation['value']));
    const m2Chart = document.getElementById('m2Chart').getContext('2d');
    window.m2Chart = new Chart(m2Chart, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'M2 貨幣供應量',
                data: m2Values,
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
                        text: '金額 (十億美元)'
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
            Chart1: 'compositeLeadingIndicator',
            Chart2: 'unemployment',
            Chart3: 'federalFundsRate'
        };
    },
    methods: {
        showChart1(chart) {
            this.Chart1 = chart;
        },
        showChart2(chart) {
            this.Chart2 = chart;
        },
        showChart3(chart) {
            this.Chart3 = chart;
        }
    }
}).mount('#app');

</script>
@endsection
