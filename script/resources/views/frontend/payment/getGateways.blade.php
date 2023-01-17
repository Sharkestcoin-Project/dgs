<div class="single-product-area">
    <div class="product-img border rounded bg-white shadow">
        <ul class="nav nav-pills" id="myTab3" role="tablist">
            @foreach($gateways as $key => $gateway)
                <li class="nav-item">
                    <a
                        @class(['nav-link', 'active' => $loop->first])
                        id="tab_{{ $key }}"
                        data-bs-toggle="tab"
                        href="#tab_{{ $key }}_content"
                        role="tab"
                        aria-controls="{{ $key }}"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                        class="p-0"
                    >
                        <img
                            src="{{ asset($gateway->logo) }}"
                            alt="{{ str($gateway->name)->upper() }}"
                            class="border rounded p-1"
                            height="50"
                            width="70"
                        >
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="product-details-area">
        <div class="product-desc mt-3">
            <div class="tab-content" id="myTabContent2">
                @foreach($gateways as $key => $gateway)
                    @php
                        $convertedPrice = convert_money($product->price, $product->currency);

                        if (Session::has('promotion')){
                            $originalDiscount =  $promotion->is_percent ? (($product->price * $promotion->discount) / 100) : $promotion->discount;
                            $convertedDiscount = convert_money($originalDiscount, $product->currency);
                            $originalDiscountAmount = $product->price - $originalDiscount;
                            $convertedDiscountAmount = convert_money($originalDiscountAmount, $product->currency);
                        }

                        $totalAmount = ($convertedDiscountAmount ?? $convertedPrice) + calculate_gateway_charge($gateway);

                        $payable = payable($convertedDiscountAmount ?? $convertedPrice, $gateway, true);
                    @endphp

                    <div
                        @class(['tab-pane fade show', 'active' => $loop->first])
                        id="tab_{{ $key }}_content"
                        role="tabpanel"
                        aria-labelledby="tab_{{ $key }}"
                    >
                        <form action="{{ route('order.make-payment', ['product' => $product->id, 'gateway' => $gateway->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <table class="table ">
                                <tbody>
                                <tr>
                                    <th>{{ __('Gateway Name') }}</th>
                                    <td>{{ str($gateway->name)->ucfirst() }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Gateway Currency') }}</th>
                                    <td>{{ $gateway->currency->code }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Product Price') }}</th>
                                    <td>
                                        {{ currency_format($product->price, 'icon', $product->currency->symbol) }}
                                    </td>
                                </tr>
                                @if(Session::has('promotion'))
                                    <tr>
                                        <th>{{ __('Discount') }} {{ $promotion->is_percent ? '('.$promotion->discount.'%)' : null }}</th>
                                        <td>
                                            {{ currency_format($originalDiscount, 'icon', $product->currency->symbol) }}
                                            = {{ currency_format($convertedDiscountAmount) }}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>{{ __('Gateway Charge') }}</th>
                                    <td>
                                        {{ calculate_gateway_charge($gateway, true) }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>{{ __('Total') }}</th>
                                    <td>{{ currency_format($totalAmount) }}</td>
                                </tr>

                                <tr>
                                    <th>{{ __('Gateway Rate') }}</th>
                                    <td>
                                        {{ currency_format(convert_money($gateway->currency->rate, $gateway->currency)) }}
                                        @if($gateway->currency->code !== default_currency('code'))
                                            = {{ currency_format($gateway->currency->rate, 'icon', $gateway->currency->symbol) }}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>{{ __('Payable') }} ({{ $gateway->currency->code }})</th>
                                    <td>
                                        {{ currency_format($payable, 'icon', $gateway->currency->symbol) }}
                                    </td>
                                </tr>

                                @if ($gateway->phone_required == 1)
                                    <tr>
                                        <th>
                                            <label for="phone" class="required">{{ __('Phone Number') }}</label>
                                        </th>
                                        <td>
                                            <input type="text" name="phone" id="phone" class="form-control" placeholder="{{ __('Enter your phone number') }}" required>
                                        </td>
                                    </tr>
                                @endif

                                @if ($gateway->image_accept == 1)
                                    <tr>
                                        <th>
                                            <label for="screenshot" class="required">
                                                {{ __('Upload Attachment') }}
                                            </label>
                                        </th>
                                        <td>
                                            <input type="file" name="screenshot" accept=".jpg,.png,.jpeg" class="form-control" required/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <label for="comment">
                                                {{ __('Payment Instructions') }}
                                            </label>
                                        </th>
                                        <td>
                                            <textarea class="form-control h-100" name="comment" id="" cols="30" rows="10"></textarea>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>

                            <div class="button-area text-center mt-30 mb-3">
                                <!-- Button -->
                                <button type="submit" class="btn hero-btn d-block w-100">
                                    {{ __('Continue To Payment') }}
                                </button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
