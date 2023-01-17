<div class="card">
    <div class="card-header">
        <ul class="nav nav-pills" id="myTab2" role="tablist">
            @php
                $i = 0;
            @endphp
            @foreach($languages->value as $key => $value)
                <li class="nav-item">
                    <a class="nav-link {{ $i == 0 ? 'active' : null }}" id="{{ $key }}-call-to-action-tab" data-toggle="tab" href="#{{ $key }}-call-to-action" role="tab" aria-controls="{{ $key }}-call-to-action" aria-selected="true">{{ $value }} ({{ $key }})</a>
                </li>
                @php
                    $i++;
                @endphp
            @endforeach
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content tab-bordered" id="myTab3Content">
            @php
                $i = 0;
            @endphp
            @foreach($languages->value as $key => $value)
                <div class="tab-pane fade {{ $i == 0 ? 'active' : null }} show" id="{{ $key }}-call-to-action" role="tabpanel" aria-labelledby="{{ $key }}-call-to-action-tab">
                    <form class="ajaxform" action="{{ route('admin.settings.website.heading.update-call-to-action') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="lang" value="{{ $key }}">

                        <div class="form-group">
                            <label for="title" class="required">{{ __('Title') }} ({{ $key }})</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $headings['heading.call-to-action'][$key]['title'] ?? null }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description" class="required">{{ __('Description') }} ({{ $key }})</label>
                            <textarea name="description" id="description" class="form-control" rows="5" required>{{ $headings['heading.call-to-action'][$key]['description'] ?? null }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="button_text" class="required">{{ __('Button Text') }} ({{ $key }})</label>
                            <input type="text" name="button_text" id="button_text" class="form-control" value="{{ $headings['heading.call-to-action'][$key]['button_text'] ?? null }}" required>
                        </div>

                        <div class="form-group">
                            <label for="button_url" class="required">{{ __('Button Url') }} ({{ $key }})</label>
                            <input type="text" name="button_url" id="button_url" class="form-control" value="{{ $headings['heading.call-to-action'][$key]['button_url'] ?? null }}" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary basicbtn">
                                <i class="fas fa-save"></i>
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
                @php
                    $i++;
                @endphp
            @endforeach
        </div>
    </div>
</div>
