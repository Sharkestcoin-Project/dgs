@extends('layouts.backend.app',[
    'button_name' => __('Add New'),
    'button_link' => route('admin.settings.website.our-services.create')
])

@section('title', __('Our Services'))
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{ __('SL.') }}</th>
                        <th>{{ __('Icon') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($ourServices ?? [] as $index => $item)
                    <tr>
                        <td>{{  $index + 1 }}</td>
                        <td><i class="{{ $item->icon ?? null }}"></i></td>
                        <td>{{ $item->title ?? null }}</td>
                        <td>{{ $item->description ?? null }}</td>
                        <td>
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                {{ __('Action') }}
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item has-icon"
                                   href="{{ route('admin.settings.website.our-services.edit', $item->id) }}">
                                    <i class="fa fa-edit"></i>
                                    {{ __('Edit') }}
                                </a>


                                <a class="dropdown-item has-icon delete-confirm" href="javascript:void(0)"
                                   data-action="{{ route('admin.settings.website.our-services.destroy', $item->id) }}">
                                    <i class="fa fa-trash"></i>
                                    {{ __('Delete') }}
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
@endsection
