<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::all();

        return view('admin.currencies.index', compact('currencies'));
    }

    public function create()
    {
        return view('admin.currencies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'unique:currencies,name'],
            'code' => ['required', 'string', 'unique:currencies,code'],
            'rate' => ['required', 'numeric'],
            'symbol' => ['required', 'string'],
            'position' => ['required', 'string'],
            'status' => ['required', 'bool'],
        ]);

        Currency::create($validated);

        return response()->json([
            'message' => __('Currency Created Successfully'),
            'redirect' => route('admin.currencies.index')
        ]);
    }

    public function edit(Currency $currency)
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', Rule::unique('currencies')->ignore($currency->id)],
            'code' => ['required', 'string',  Rule::unique('currencies')->ignore($currency->id)],
            'rate' => ['required', 'numeric'],
            'symbol' => ['required', 'string'],
            'position' => ['required', 'string'],
            'status' => ['required', 'bool'],
        ]);

        $currency->update($validated);

        return response()->json([
            'message' => __('Currency Updated Successfully'),
            'redirect' => route('admin.currencies.index')
        ]);
    }

    public function destroy(Currency $currency)
    {
        if($currency->is_default){
            return response()->json(__('Default currency is not deletable'), 422);
        }

        if ($currency->gateways){
            return response()->json(__('You are not allowed to delete :type because it has :number :child .', ['type' => $currency->name, 'number' => $currency->gateways->count(), 'child' => $currency->gateways->count() == 1 ? 'Gateway': 'Gateways']), 422);
        }

        $currency->delete();

        return response()->json([
            'message' => __('Currency Deleted Successfully'),
            'redirect' => route('admin.currencies.index')
        ]);
    }

    public function makeDefault(Currency $currency)
    {
        if($currency->is_default){
            return response()->json(__('Currency is already default'), 422);
        }

        Currency::whereIsDefault(1)->update(['is_default' => 0]);

        $currency->update(['is_default' => 1]);

        return response()->json([
            'message' => __(':name Set As Default Currency', ['name' => $currency->name]),
            'redirect' => route('admin.currencies.index')
        ]);
    }
}
