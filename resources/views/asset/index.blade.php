@extends('layouts.app')

@section('content')
<div class="container">

    @include('components.asset')

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        var assetsChart = document.getElementById('assetsChart').getContext('2d');
        var assetLabels = @json($assets->pluck('name'));
        var assetValues = @json($assets->pluck('value'));
        var assetPercentages = @json($assets->pluck('percentage'));

        var chart = new Chart(assetsChart, {
            type: 'pie',
            data: {
                labels: assetLabels,
                datasets: [{
                    label: '資產配置',
                    data: assetValues,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return assetLabels[tooltipItem.dataIndex] + ': ' + assetPercentages[tooltipItem.dataIndex] + '%';
                            }
                        }
                    }
                }
            }
        });
    });
    
</script>
@endsection