<div class="card">
    <div class="card-header">
        <ul class="nav nav-pills" id="myTab2" role="tablist">
            @php
                $i = 0;
            @endphp
            @foreach($languages->value as $key => $value)
                <li class="nav-item">
                    <a class="nav-link {{ $i == 0 ? 'active' : null }}" id="{{ $key }}-trusted-by-tab" data-toggle="tab" href="#{{ $key }}-trusted-by" role="tab" aria-controls="{{ $key }}-trusted-by" aria-selected="true">{{ $value }} ({{ $key }})</a>
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
                <div class="tab-pane fade {{ $i == 0 ? 'active' : null }} show" id="{{ $key }}-trusted-by" role="tabpanel" aria-labelledby="{{ $key }}-trusted-by-tab">
                    <form class="ajaxform" action="{{ route('admin.settings.website.heading.update-trusted-by') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="lang" value="{{ $key }}">

                        <div class="form-group">
                            <label for="title" class="required">{{ __('Title') }} ({{ $key }})</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $headings['heading.trusted-by'][$key]['title'] ?? null }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description" class="required">{{ __('Description') }} ({{ $key }})</label>
                            <textarea name="description" id="description" class="form-control" rows="5" required>{{ $headings['heading.trusted-by'][$key]['description'] ?? null }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="widget_1_title" class="required">{{ __('Widget 1 Title') }} ({{ $key }})</label>
                                            <input type="text" name="widget_1_title" id="widget_1_title" class="form-control" value="{{ $headings['heading.trusted-by'][$key]['widget_1_title'] ?? null }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="widget_1_description" class="required">{{ __('Widget 1 Description') }} ({{ $key }})</label>
                                            <input type="text" name="widget_1_description" id="widget_1_description" class="form-control" value="{{ $headings['heading.trusted-by'][$key]['widget_1_description'] ?? null }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="widget_2_rating" class="required">{{ __('Widget 2 Rating') }} ({{ $key }})</label>
                                            <input type="number" name="widget_2_rating" id="widget_2_rating" class="form-control" value="{{ $headings['heading.trusted-by'][$key]['widget_2_rating'] ?? null }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="widget_2_rating_count" class="required">{{ __('Widget 2 Rating Count') }} ({{ $key }})</label>
                                            <input type="number" name="widget_2_rating_count" id="widget_2_rating_count" class="form-control" value="{{ $headings['heading.trusted-by'][$key]['widget_2_rating_count'] ?? null }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
