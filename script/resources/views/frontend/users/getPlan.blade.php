<div class="modal-content">
    <div class="modal-header try-demo">
        <img src="{{ asset($plan->cover) }}" alt="">
        <div class="price-tag">
            <h5>{{ currency_format($plan->price, 'icon', $plan->currency->symbol) }}</h5>
            <span class="video-sonar"></span>
        </div>

    </div>
    <div class="modal-body try-demo-form">
        <div class="modal-form-area">
            <form action="{{ route('subscriptions.payment', [$user->username, $plan->id]) }}" method="post" class="ajaxform">
                @csrf
                <div class="form__box mb-20">
                    <input type="text" name="name" id="name" class="form__input" placeholder="{{ __('Name') }}" required>
                    <label for="name" class="form__label">{{ __('Name') }}</label>
                    <div class="form__shadow"></div>
                </div>
                <div class="form__box mb-20">
                    <input type="email" name="email" id="email" class="form__input" placeholder="{{ __('Email') }}" required>
                    <label for="email" class="form__label">{{ __('Email') }}</label>
                    <div class="form__shadow"></div>
                </div>
                <div class="form__box mb-20">
                    <input type="tel" name="phone" id="phone" class="form__input" placeholder="{{ __('Phone') }}" required>
                    <label for="phone" class="form__label">{{ __('Phone') }}</label>
                    <div class="form__shadow"></div>
                </div>

                <button type="submit" class="btn modal-try-btn basicbtn">{{ __('Continue') }}</button>
            </form>
        </div>
    </div>
</div>
