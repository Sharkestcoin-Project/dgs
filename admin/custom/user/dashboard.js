(function ($) {
    "use strict";

    var defaultCurrencySymbol = $("#defaultCurrencySymbol").val();
    var defaultCurrencyPosition = $("#defaultCurrencyPosition").val();
    var my_statistics_chart;

    $(document).ready(function () {
        var month = $("#month").find("option:selected").val();
        getStatistics(month);
    });

    $("#month").on("change", function () {
        var month = $(this).find("option:selected").val();
        getStatistics(month);
        my_statistics_chart.destroy();
    });

    function getStatistics(month) {
        $.ajax({
            type: "get",
            url: "/user/dashboard/statistics",
            dataType: "json",
            beforeSend: function () {
                $("#revenueByMonthLoader").show();
            },
            success: function (res) {
                $("#revenue").html(res.revenue);
                $("#totalSales").html(res.totalSales);
                $("#averageSales").html(res.averageSales);
                $("#averageMonthlySales").html(res.averageMonthlySales);
                $("#revenueByMonthLoader").hide();
                wallets(res.wallets);

                var datasets = [];
                var bg = ['rgba(63,82,227,.8)', 'rgba(254,86,83,.7)', 'rgba(50, 168, 82, .6)', 'rgba(50, 168, 129, .6)', 'rgba(50, 164, 168, .6)', 'rgba(50, 127, 168, .6)','rgba(50, 52, 168, .6)', 'rgba(99, 73, 140, .6)', 'rgba(150, 42, 150, .6)', 'rgba(150, 42, 100, .6)','rgba(179, 2, 58, .6)'];
                $.each(res.wallets, function(index, wallet){
                    var totals = [];
                    $.each(res.statistics, function (index, value) {
                        if (value.currency_id == wallet.currency_id) {
                            totals.push(value.total);
                        } else {
                            totals.push(0);
                        }
                    });
                    datasets.push({
                        label: wallet.currency.name,
                        data: totals,
                        borderWidth: 2,
                        backgroundColor: bg[index] ?? 'rgba(63,82,227,.8)',
                        borderWidth: 0,
                        borderColor: 'transparent',
                        pointBorderWidth: 0,
                        pointRadius: 3.5,
                        pointBackgroundColor: 'transparent',
                        pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
                    })
                    totals = [];
                })

                var months = [];
                $.each(res.statistics, function (index, value) {
                    months.push(value.month);
                });
                myChart(months, datasets);
            },
            error: function (xhr) {
                Sweet("error", xhr.responseJSON.message);
            },
        });
    }

    function wallets(wallets) {
        console.log(wallets)
        var card = "";
        $.each(wallets, function (key, wallet) {
            card += `<div class="col-lg-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-money-bill"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Balance (${wallet.currency.code})</h4>
                        </div>
                        <div class="card-body">
                            <span>${
                                wallet.currency.symbol + wallet.wallet
                            }</span>
                        </div>
                    </div>
                </div>
            </div>
            `;
        });

        $(".statistic-card").append(card);
    }

    ("use strict");

    function myChart(months, datasets) {
        var ctx = document.getElementById("myChart").getContext("2d");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: months,
                datasets: datasets
            },
            options: {
                legend: {
                    display: false,
                },
                scales: {
                    yAxes: [
                        {
                            gridLines: {
                                // display: false,
                                drawBorder: false,
                                color: "#f2f2f2",
                            },
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1500,
                                callback: function (value, index, values) {
                                    return value;
                                },
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                display: false,
                                tickMarkLength: 15,
                            },
                        },
                    ],
                },
            },
        });
    }
})(jQuery);
