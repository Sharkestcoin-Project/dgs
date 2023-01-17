(function ($) {
    "use strict";
    var period = $('#days').val();
    $('#days').on('change', () => {
        period = $('#days').val();
        loadData();
    })

    var base_url = $("#base_url").val();
    var site_url = $("#site_url").val();
    var dashboard_static_url = $("#dashboard_static").val();

    loadStaticData();
    load_performance(7);
    // load_deposit_performance(7);
    loadData();
    dashboard_order_statics($('#month').val());

    $('#performance').on('change', function () {
        var period = $('#performance').val();
        load_performance(period);
    });

    $('#deposit_performance').on('change', function () {
        var period = $('#deposit_performance').val();
        load_deposit_performance(period);
    });

    $('.month').on('click', function (e) {
        $('.month').removeClass('active');
        $(this).addClass("active");
        var month = e.currentTarget.dataset.month;

        $('#orders-month').html(month);
        dashboard_order_statics(month);
    });

    function dashboard_order_statics(month) {
        var url = $('#dashboard_order_statics').val();
        var gif_url = $('#gif_url').val();
        var html = "<img src=" + gif_url + ">";
        $('#pending_order').html(html);
        $('#completed_order').html(html);
        $('#shipping_order').html(html);
        $('#total_order').html(html);
        $.ajax({
            type: 'get', url: url + '/' + month, dataType: 'json', success: function (response) {
                $('#pending_order').html(response.total_pending);
                $('#completed_order').html(response.total_completed);
                $('#shipping_order').html(response.total_processing);
                $('#total_order').html(response.total_orders);
            }
        })
    }

    function loadStaticData() {
        var url = dashboard_static_url;
        $.ajax({
            type: 'get',
            url: url,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $('#total_customers').html(response.total_customers);
                $('#active_plan_users').html(response.active_plan_users);
                $('#total_earnings').html(response.total_earnings);
                $('#sales_of_earnings').html(response.total_earnings_this_year);
                $('#total_sales').html(response.total_order_this_year);

                var dates = [];
                var totals = [];

                $.each(response.earnings, function (index, value) {
                    var date = value.month + ' ' + value.year;
                    var total = value.total;

                    dates.push(date);
                    totals.push(total);
                });
                sales_of_earnings_chart(dates, totals);

                var dates = [];
                var sales = [];

                $.each(response.sales, function (index, value) {
                    var date = value.month + ' ' + value.year;
                    var sale = value.sales;

                    dates.push(date);
                    sales.push(sale);
                });

                sales_chart(dates, sales);
            }
        })
    }

    function load_performance(period) {
        $('#earning_performance').show();
        var url = $('#dashboard_performance').val();
        $.ajax({
            type: 'get', url: url + '/' + period, dataType: 'json',

            success: function (response) {
                $('#earning_performance').hide();
                var month_year = [];
                var dates = [];
                var totals = [];


                if (period != 365) {
                    $.each(response, function (index, value) {
                        var total = value.total;
                        var date = value.date;
                        totals.push(total);
                        dates.push(date);
                    });

                    load_performance_chart(dates, totals);
                } else {
                    $.each(response, function (index, value) {
                        var month = value.month;
                        var total = value.total;

                        month_year.push(month);
                        totals.push(total);
                    });
                    load_performance_chart(month_year, totals);
                }
            }
        })
    }

    // Deposit Performance Chart
    function load_deposit_performance(period) {
        $('#deposit_performance_loader').show();
        var url = $('#deposit_performance').val();
        $.ajax({
            type: 'get', url: url + '/' + period, dataType: 'json', success: function (response) {
                $('#deposit_performance_loader').hide();
                var month_year = [];
                var dates = [];
                var totals = [];

                if (period != 365) {
                    $.each(response, function (index, value) {
                        var total = value.total;
                        var dte = value.date;
                        totals.push(total);
                        dates.push(dte);
                    });
                    load_performance_chart(dates, totals, "depositChart");
                } else {
                    $.each(response, function (index, value) {
                        var month = value.month;
                        var total = value.total;

                        month_year.push(month);
                        totals.push(total);
                    });
                    load_performance_chart(month_year, totals, "depositChart");
                }

            }
        })
    }

    function loadData() {

        $.ajax({
            type: 'get',
            url: base_url + '/admin/dashboard/visitors/' + period,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                analytics_report(response.TotalVisitorsAndPageViews);
                top_browsers(response.TopBrowsers);
                Referrers(response.Referrers);
                TopPages(response.MostVisitedPages);
                $('#new_vistors').html(number_format(response.fetchUserTypes[0].sessions))
                $('#returning_visitor').html(number_format(response.fetchUserTypes[1].sessions))
            }
        })

    }

    function analytics_report(data) {
        var statistics_chart = document.getElementById("google_analytics").getContext('2d');
        var labels = [];
        var visitors = [];
        var pageViews = [];
        var total_visitors = 0;
        var total_page_views = 0;
        $.each(data, function (index, value) {
            labels.push(value.date);
            visitors.push(value.visitors);
            pageViews.push(value.pageViews);
            var total_visitor = total_visitors + value.visitors;
            total_visitors = total_visitor;
            var total_page_view = total_page_views + value.pageViews;
            total_page_views = total_page_view;
        });

        $('#total_visitors').html(number_format(total_visitors));
        $('#total_page_views').html(number_format(total_page_views));

        var myChart = new Chart(statistics_chart, {
            type: 'line', data: {
                labels: labels, datasets: [{
                    label: 'Visitors',
                    data: visitors,
                    borderWidth: 5,
                    borderColor: '#6777ef',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6777ef',
                    pointRadius: 4
                }, {
                    label: 'PageViews',
                    data: pageViews,
                    borderWidth: 5,
                    borderColor: '#6777ef',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6777ef',
                    pointRadius: 4
                }]
            }, options: {
                legend: {
                    display: false
                }, scales: {
                    yAxes: [{
                        gridLines: {
                            display: false, drawBorder: false,
                        }, ticks: {
                            stepSize: 150
                        }
                    }], xAxes: [{
                        gridLines: {
                            color: '#fbfbfb', lineWidth: 2
                        }
                    }]
                },
            }
        });

    }

    function Referrers(data) {
        $('#refs').html('');
        $.each(data, function (index, value) {
            var html = '<div class="mb-4"> <div class="text-small float-right font-weight-bold text-muted">' + number_format(value.pageViews) + '</div><div class="font-weight-bold mb-1">' + value.url + '</div></div><hr>';

            $('#refs').append(html);
        });
    }

    function top_browsers(data) {
        $('#browsers').html('');
        $.each(data, function (index, value) {
            var browser_name = value.browser;
            if (browser_name == 'Edge') {
                var browser_name = 'internet-explorer';
            }
            var html = ' <div class="col text-center"> <div class="browser browser-' + lower(browser_name) + '"></div><div class="mt-2 font-weight-bold">' + value.browser + '</div><div class="text-muted text-small"><span class="text-primary"></span> ' + number_format(value.sessions) + '</div></div>';
            $('#browsers').append(html);
            if (index == 4) {
                return false;
            }
        });
    }

    function TopPages(data) {
        $('#table-body').html('');
        $.each(data, function (index, value) {
            var index = index + 1;


            var html = '<div class="mb-4"> <div class="text-small float-right font-weight-bold text-muted">' + number_format(value.pageViews) + ' (Views)</div><div class="font-weight-bold mb-1"><a href="' + site_url + value.url + '" target="_blank" draggable="false">' + value.pageTitle + '</a></div></div>';
            $('#table-body').append(html);

        });
    }

    function lower(str) {
        var str = str.toLowerCase();
        var str = str.replace(' ', str);
        return str;
    }

    function number_format(number) {
        var num = new Intl.NumberFormat({maximumSignificantDigits: 3}).format(number);
        return num;
    }

    // Earning Performance Chart
    function load_performance_chart(dates, totals, id = "myChart") {
        var ctx = document.getElementById(id).getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line', data: {
                labels: dates, datasets: [{
                    label: 'Total Amount',
                    data: totals,
                    borderWidth: 2,
                    backgroundColor: 'rgba(63,82,227,.8)',
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'rgba(23,44,215,0.8)',
                    pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
                }]
            }, options: {
                scales: {
                   xAxes: [{
                        gridLines: {
                            display: true,
                            tickMarkLength: 15,
                        }
                    }]
                },
            }
        });
    }

    // Total Sales of Earning Chart
    var earning_chat = document.getElementById("sales_of_earnings_chart").getContext('2d');
    var earning_chat_bg_color = earning_chat.createLinearGradient(0, 0, 0, 70);
    earning_chat_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
    earning_chat_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

    function sales_of_earnings_chart(dates, totals) {
        var earningChart = new Chart(earning_chat, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Total Amount',
                    data: totals,
                    backgroundColor: earning_chat_bg_color,
                    borderWidth: 3,
                    borderColor: 'rgba(63,82,227,1)',
                    pointBorderWidth: 0,
                    pointBorderColor: 'transparent',
                    pointRadius: 3,
                    pointBackgroundColor: 'rgb(9,23,133)',
                    pointHoverBackgroundColor: 'rgba(63,82,227,1)',
                }]
            }, options: {
                layout: {
                    padding: {
                        bottom: -1, left: -1
                    }
                }, legend: {
                    display: false
                }, scales: {
                    yAxes: [{
                        gridLines: {
                            display: false, drawBorder: false,
                        }, ticks: {
                            beginAtZero: true, display: false
                        }
                    }], xAxes: [{
                        gridLines: {
                            drawBorder: false, display: false,
                        }, ticks: {
                            display: false
                        }
                    }]
                },
            }
        });

    }

    // Total Sales Chart
    var sales_chart_obj = document.getElementById("total_sales_chart").getContext('2d');
    var sales_chart_bg_color = sales_chart_obj.createLinearGradient(0, 0, 0, 80);
    sales_chart_bg_color.addColorStop(0, 'rgba(63,82,227,.2)');
    sales_chart_bg_color.addColorStop(1, 'rgba(63,82,227,0)');

    function sales_chart(dates, sales) {
        var salesChart = new Chart(sales_chart_obj, {
            type: 'line', data: {
                labels: dates, datasets: [{
                    label: 'Orders',
                    data: sales,
                    borderWidth: 2,
                    backgroundColor: sales_chart_bg_color,
                    borderColor: 'rgba(63,82,227,1)',
                    pointBorderWidth: 0,
                    pointBorderColor: 'transparent',
                    pointRadius: 3,
                    pointBackgroundColor: 'rgb(9,23,133)',
                    pointHoverBackgroundColor: 'rgba(63,82,227,1)',
                }]
            }, options: {
                layout: {
                    padding: {
                        bottom: -1, left: -1
                    }
                }, legend: {
                    display: false
                }, scales: {
                    yAxes: [{
                        gridLines: {
                            display: false, drawBorder: false,
                        }, ticks: {
                            beginAtZero: true, display: false
                        }
                    }], xAxes: [{
                        gridLines: {
                            drawBorder: false, display: false,
                        }, ticks: {
                            display: false
                        }
                    }]
                },
            }
        });
    }

})(jQuery);
