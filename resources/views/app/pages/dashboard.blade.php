@extends('app/components/main')
@section('title', 'Dashboard')

@section('content')
<div class="d-sm-flex align-items-center justify-content-end mb-3">
    <h6 class="text-gray-800" id="date-time"></h6>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                            Pemasukan Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.
                            {{ number_format($income, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-money-check-dollar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                            Pengeluaran Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.
                            {{ number_format($expense, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-money-check-dollar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                            Total Kas Bulan Ini</div>
                        <div class="h5 mb-0 font-weight-bold {{ $color }}">
                            Rp. {{ number_format($cash_per_month, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <!-- Area Chart -->
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Pemasukan Bulan Ini</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
                <div class="pt-2">
                    <h5 id="month-year" class="text-center"></h5>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Pie Chart -->
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Paket Jasa Paling Diminati</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="text-center small">
                    {{-- @foreach ($package_best_selling as $pbs)
                    <span class="mr-2">
                        {{ $loop->iteration }}. {{ $pbs->package->name }}
                    </span>
                    @endforeach
                    <hr> --}}
                    <div class="chart-pie pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    // REALTIME DATETIME
    // Function to format 1 in 01
    const zeroFill = n => {
        return ('0' + n).slice(-2);
    }

    // Creates interval
    const interval = setInterval(() => {
        // Month list in array
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        // Get current time
        const now = new Date();

        // Format date as in mm/dd/aaaa hh:ii:ss
        const dateTime = zeroFill(now.getUTCDate()) + ' ' + monthNames[now.getMonth()] + ' ' + now
            .getFullYear() + ' | ' + zeroFill(now.getHours()) + ':' + zeroFill(now.getMinutes()) + ':' +
            zeroFill(
                now.getSeconds());

        const monthAndYear = monthNames[now.getMonth()] + ' ' + now.getFullYear();

        // const monthYear = monthNames[now.getMonth() + 1] + ' ' + now.getFullYear();

        // Display the date and time on the screen using div#date-time
        document.getElementById('date-time').innerHTML = dateTime;
        document.getElementById('month-year').innerHTML = monthAndYear;
        // document.getElementById('month-year').innerHTML = monthYear;
    }, 1000);
    // END OF REALTIME DATETIME

    // AREA CHART
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = 'Nunito',
        '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';

    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? ',' : dec_point,
            s = '',
                toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    // Area Chart
    var areaChart = document.getElementById("myAreaChart");
    var myLineChart = new Chart(areaChart, {
        type: 'line',
        data: {
            labels: [
                    @foreach ($date_per_month as $data)
                        {{ $data->date }},
                @endforeach
            ],
            datasets: [{
                label: "Pemasukan",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [
                        @foreach ($income_per_day as $data)
                            {{ $data->total }},
                    @endforeach
                ],
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        // Include a dollar rupiah in the ticks
                            callback: function(value, index, values) {
                            return 'Rp. ' + number_format(value);
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                        label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': Rp. ' + number_format(tooltipItem.yLabel);
                    }
                }
            }
        }
    });
    // END OF AREA CHART

    // PIE CHART

    var pieChart = document.getElementById("myPieChart");
    var myPieChart = new Chart(pieChart, {
        type: 'bar',
        data: {
            labels: [
                    @foreach ($packages as $package)
                '{{ $package->package->name }}',
                @endforeach
                // 'tes','tesss','tes','tesss','tes','tesss'
            ],
            datasets: [{
                data: [
                    @foreach ($package_best_selling as $pbs)
                            {{ $pbs->qty }},
                    @endforeach
                ],
                backgroundColor: ['rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: ['rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        // Include a dollar rupiah in the ticks
                            callback: function(value, index, values) {
                            return 'Rp. ' + number_format(value);
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                displayColors:false,
                callbacks: {
                        label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + 'Jumlah transaksi : ' + number_format(tooltipItem.yLabel);
                    }
                }
            },
            legend: {
                display: false
            },
            scales:{
                beginAtZero: true
            }
        },
    });

    // END OF PIE CHART

</script>
@endsection
