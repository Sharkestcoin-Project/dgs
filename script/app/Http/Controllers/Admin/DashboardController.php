<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Analytics;
use Spatie\Analytics\Period;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dashboard-read');
    }

    public function staticData()
    {
        $total_customers = User::whereRole('user')->count();
        $active_plan_users = User::whereRole('user')->where('will_expire', '>=', today())->count();
        $total_earnings = Order::where('status', '!=', 0)->sum('price');

        $year = Carbon::parse(date('Y'))->year;

        $earnings = Order::whereYear('created_at', '=', $year)
            ->where('status', '!=', 0)
            ->orderBy('created_at')
            ->selectRaw('year(created_at) year, monthname(created_at) month, sum(price) total')
            ->groupBy('year', 'month')
            ->get()
            ->map(function ($q) {
                $data['year'] = $q->year;
                $data['month'] = $q->month;
                $data['total'] = number_format(max($q->total, 0), 2);

                return $data;
            });


        $total_earnings_this_year = Order::where('status', '!=', 0)
            ->whereYear('created_at', '=', $year)
            ->sum('price');


        $sales = Order::whereYear('created_at', '=', $year)
            ->orderBy('created_at')
            ->selectRaw('year(created_at) year, monthname(created_at) month, count(*) sales')
            ->groupBy('year', 'month')
            ->get();

        $total_order_this_year = Order::where('status', '!=', 0)->whereYear('created_at', '=', $year)->count();

        $data['total_customers'] = $total_customers;
        $data['active_plan_users'] = $active_plan_users;
        $data['total_earnings'] = number_format(max($total_earnings, 0), 2);
        $data['earnings'] = $earnings;
        $data['total_earnings_this_year'] = number_format(max($total_earnings_this_year, 0), 2);
        $data['sales'] = $sales;
        $data['total_order_this_year'] = $total_order_this_year;

        return response()->json($data);

    }

    public function performance($period)
    {
        if ($period != 365) {
            $earnings = Order::whereDate('created_at', '>', Carbon::now()->subDays($period))
                ->where('status', '!=', 0)
                ->orderBy('created_at')
                ->selectRaw('year(created_at) year, date(created_at) date, sum(price) total')
                ->groupBy('year', 'date')
                ->get();
        } else {
            $earnings = Order::whereDate('created_at', '>', Carbon::now()->subDays($period))
                ->where('status', '!=', 0)
                ->orderBy('created_at')
                ->selectRaw('year(created_at) year, monthname(created_at) month, sum(price) total')
                ->groupBy('year', 'month')
                ->get();
        }

        return response()->json($earnings);
    }

    public function depositPerformance($period)
    {
        if ($period != 365) {
            $earnings = Deposit::whereDate('created_at', '>', Carbon::now()->subDays($period))->where('payment_status', '!=', 0)->orderBy('id', 'asc')->selectRaw('year(created_at) year, date(created_at) date, sum(amount) total')->groupBy('year', 'date')->get();

        } else {
            $earnings = Deposit::whereDate('created_at', '>', Carbon::now()->subDays($period))->where('payment_status', '!=', 0)->orderBy('id', 'asc')->selectRaw('year(created_at) year, monthname(created_at) month, sum(amount) total')->groupBy('year', 'month')->get();
        }


        return response()->json($earnings);
    }

    public function order_statics($month)
    {
        $month = Carbon::parse($month)->month;
        $year = Carbon::parse(date('Y'))->year;

        $total_orders = Order::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();

        $total_pending = Order::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->where('status', 2)->count();

        $total_completed = Order::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->where('status', 1)->count();

        $total_expired = Order::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->where('status', 3)->count();

        $data['total_orders'] = number_format($total_orders);
        $data['total_pending'] = number_format($total_pending);
        $data['total_completed'] = number_format($total_completed);
        $data['total_processing'] = number_format($total_expired);

        return response()->json($data);
    }


    public function google_analytics($days)
    {
        if (file_exists('uploads/service-account-credentials.json')) {
            $data['TotalVisitorsAndPageViews'] = $this->fetchTotalVisitorsAndPageViews($days);
            $data['MostVisitedPages'] = $this->fetchMostVisitedPages($days);
            $data['Referrers'] = $this->fetchTopReferrers($days);
            $data['fetchUserTypes'] = $this->fetchUserTypes($days);
            $data['TopBrowsers'] = $this->fetchTopBrowsers($days);
        } else {
            $data['TotalVisitorsAndPageViews'] = [];
            $data['MostVisitedPages'] = [];
            $data['Referrers'] = [];
            $data['fetchUserTypes'] = [];
            $data['TopBrowsers'] = [];
        }

        return response()->json($data);
    }

    public function fetchTotalVisitorsAndPageViews($period)
    {

        return Analytics::fetchTotalVisitorsAndPageViews(Period::days($period))->map(function ($data) {
            $row['date'] = $data['date']->format('Y-m-d');
            $row['visitors'] = $data['visitors'];
            $row['pageViews'] = $data['pageViews'];
            return $row;
        });

    }

    public function fetchMostVisitedPages($period)
    {
        return Analytics::fetchMostVisitedPages(Period::days($period));

    }

    public function fetchTopReferrers($period)
    {
        return Analytics::fetchTopReferrers(Period::days($period));

    }

    public function fetchUserTypes($period)
    {
        return Analytics::fetchUserTypes(Period::days($period));

    }

    public function fetchTopBrowsers($period)
    {
        return Analytics::fetchTopBrowsers(Period::days($period));

    }

    public function pageanalytics(Request $request)
    {

        $analyticsData = Analytics::performQuery(
            Period::days(14),
            'ga:pageviews',
            [
                'metrics' => 'ga:pageviews',
                'dimensions' => 'ga:date',
                'filters' => 'ga:pagePath==/' . $request->path
            ]

        );

        return $result = collect($analyticsData['rows'] ?? [])->map(function (array $dateRow) {
            return [
                'date' => Carbon::createFromFormat('Ymd', $dateRow[0])->format('m-d-Y'),
                'views' => (int)$dateRow[1],
            ];
        });
    }

    public function fetchVisitorsAndPageViews($period)
    {
        return Analytics::fetchVisitorsAndPageViews(Period::days($period));
    }
}
