<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $src = $request->get('src');
        $promotions = Promotion::whereUserId(Auth::id())
            ->with(['product'])
            ->when($src !== null, function (Builder $builder) use($src){
                $builder->where('code', 'LIKE', '%'.$src.'%')
                    ->orWhereHas('product', function (Builder $builder) use($src){
                        $builder->where('name', 'LIKE', '%'.$src.'%');
                    });
            })
            ->latest()
            ->paginate(10);

        return view('user.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $products = Product::whereUserId(Auth::id())->pluck('name', 'id');

        return view('user.promotions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => ['required', 'array'],
            'products.*' => ['exists:products,id'],
            'discount' => ['required', 'numeric'],
            'code' => ['required', 'string', 'min:6'],
            'max_limit' => ['required', 'integer']
        ]);

        if (!Product::whereUserId(Auth::id())->whereIn('id', $request->input('products'))->exists()){
            throw new ModelNotFoundException(__('Product Not Found!'));
        }

        foreach ($request->input('products') as $productId){
            Promotion::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'is_percent' => true,
                'discount' => $request->input('discount'),
                'code' => $request->input('code'),
                'max_limit' => $request->input('max_limit'),
            ]);
        }

        return response()->json([
            'message' => __('Promotion Created Successfully'),
            'redirect' => route('user.promotions.index')
        ]);
    }

    public function edit(Promotion $promotion)
    {
        abort_if($promotion->user_id !== Auth::id(), 404);
        $products = Product::whereUserId(Auth::id())->pluck('name', 'id');

        return view('user.promotions.edit', compact('promotion', 'products'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        abort_if($promotion->user_id !== Auth::id(), 404);
        $request->validate([
            'product' => ['required', 'exists:products,id'],
            'discount' => ['required', 'numeric'],
            'code' => ['required', 'string', 'min:6'],
            'max_limit' => ['required', 'integer']
        ]);

        if (!Product::whereUserId(Auth::id())->whereId($request->input('product'))->exists()){
            throw new ModelNotFoundException(__('Product Not Found!'));
        }

        $promotion->update([
            'product_id' => $request->input('product'),
            'discount' => $request->input('discount'),
            'code' => $request->input('code'),
            'max_limit' => $request->input('max_limit'),
        ]);

        return response()->json([
            'message' => __('Promotion Updated Successfully'),
            'redirect' => route('user.promotions.index')
        ]);
    }

    public function destroy(Promotion $promotion)
    {
        abort_if($promotion->user_id !== Auth::id(), 404);
        $promotion->delete();

        return response()->json([
            'message' => __('Promotion Deleted Successfully'),
            'redirect' => route('user.promotions.index')
        ]);
    }

    public function destroyMass(Request $request)
    {
        $request->validate([
            'id' => ['required', 'array']
        ]);

        Promotion::whereUserId(Auth::id())
            ->whereIn('id', $request->input('id'))
            ->delete();

        return response()->json([
            'message' => __('Selected Promotions Deleted Successfully'),
            'redirect' => route('user.promotions.index')
        ]);
    }
}
