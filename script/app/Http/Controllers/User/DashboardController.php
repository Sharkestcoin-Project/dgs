<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use App\Models\Wallet;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $warnings = $this->getWarnings();
        $user = Auth::user();
        $user->loadCount('products', 'subscriptions');

        return view('user.dashboard', compact('warnings', 'user'));
    }

    private function getWarnings(){
        $warnings = [];
        if(Auth::user()->will_expire < today()){
            $warnings[] = [
                'type' => 'warning',
                'message' => __('Your subscription has been expired! Please subscribe to a new plan.'),
                'button_name' => __('Subscribe Now'),
                'button_url' => route('user.settings.subscriptions.index')
            ];
        }

        return $warnings;
    }

    public function statistics(Request $request) {
        $revenue = ProductOrder::whereUserId(Auth::id())->sum('amount');
        $totalSales = ProductOrder::whereUserId(Auth::id())->count('id');
        $averageSales = $totalSales == 0 ? $revenue : ($revenue / $totalSales);
        $wallets = Wallet::where('user_id', auth()->id())->with('currency')->groupBy('currency_id')->get();
        $averageMonthlySales = $revenue / 12;

        $year = date_parse_from_format('Y', 2022)['year'];
        $statistics = ProductOrder::whereUserId(Auth::id())
            ->whereYear('created_at', '=', $year)
            ->selectRaw('month(created_at) month, sum(amount) total, currency_id')
            ->groupBy('month')
            ->get()
            ->map(function ($q) {
                $data['month'] = date('F', mktime(0, 0, 0, $q->month, 10));
                $data['total'] = number_format(max($q->total, 0), 2);
                $data['currency_id'] = $q->currency_id;
                return $data;
            });

        return response()->json([
            'wallets' => $wallets,
            'revenue' => currency_format($revenue),
            'totalSales' => $totalSales,
            'averageSales' => currency_format($averageSales),
            'averageMonthlySales' => currency_format($averageMonthlySales),
            'statistics' => $statistics
        ]);
    }
}
