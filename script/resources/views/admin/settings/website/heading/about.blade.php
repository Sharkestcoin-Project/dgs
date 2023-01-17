<div class="card">
    <div class="card-header">
        <ul class="nav nav-pills" id="myTab2" role="tablist">
            @php
                $i = 0;
            @endphp
            @foreach($languages->value as $key => $value)
                <li class="nav-item">
                    <a class="nav-link {{ $i == 0 ? 'active' : null }}" id="{{ $key }}-about-tab" data-toggle="tab" href="#{{ $key }}-about" role="tab" aria-controls="{{ $key }}-about" aria-selected="true">{{ $value }} ({{ $key }})</a>
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
                <div class="tab-pane fade {{ $i == 0 ? 'active' : null }} show" id="{{ $key }}-about" role="tabpanel" aria-labelledby="{{ $key }}-about-tab">
                    <form class="ajaxform" action="{{ route('admin.settings.website.heading.update-about') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="lang" value="{{ $key }}">

                        <div class="form-group">
                            <label for="heading" class="required">{{ __('Heading') }} ({{ $key }})</label>
                            <input type="text" name="heading" id="heading" class="form-control" value="{{ $headings['heading.about'][$key]['heading'] ?? null }}" required>
                        </div>

                        <div class="form-group">
                            <label for="title" class="required">{{ __('Title') }} ({{ $key }})</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $headings['heading.about'][$key]['title'] ?? null }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description" class="required">{{ __('Description') }} ({{ $key }})</label>
                            <textarea name="description" id="description" class="form-control" rows="5" required>{{ $headings['heading.about'][$key]['description'] ?? null }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="option_1" class="required">{{ __('Option 1 Text') }} ({{ $key }})</label>
                            <input type="text" name="option_1" id="option_1" class="form-control" value="{{ $headings['heading.about'][$key]['option_1'] ?? null }}" required>
                        </div>

                        <div class="form-group">
                            <label for="option_2" class="required">{{ __('Option 2 Text') }} ({{ $key }})</label>
                            <input type="text" name="option_2" id="option_2" class="form-control" value="{{ $headings['heading.about'][$key]['option_2'] ?? null }}" required>
                        </div>

                        <div class="form-group">
                            <label for="option_3" class="required">{{ __('Option 3 Text') }} ({{ $key }})</label>
                            <input type="text" name="option_3" id="option_3" class="form-control" value="{{ $headings['heading.about'][$key]['option_3'] ?? null }}" required>
                        </div>

                        <div class="form-group">
                            <label for="option_4" class="required">{{ __('Option 4 Text') }} ({{ $key }})</label>
                            <input type="text" name="option_4" id="option_4" class="form-control" value="{{ $headings['heading.about'][$key]['option_4'] ?? null }}" required>
                        </div>

                        <div class="form-group">
                            <label for="about_image_{{ $key }}" class="required">{{ __('Image') }} ({{ $key }})</label>
                            {{ mediasection([
                                'input_name' => 'image',
                                'input_id' => 'about_image_'.$key,
                                'preview' => $headings['heading.about'][$key]['image'] ?? null,
                                'value' => $headings['heading.about'][$key]['image'] ?? null
                            ]) }}
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
