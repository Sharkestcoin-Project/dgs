@if(!empty($menus))
<h4>{{ $menus['name'] ?? '' }}</h4>
<ul>
      @foreach ($menus['data'] ?? [] as $row)
        <li>
            <a href="{{ url($row->href) }}" @if(!empty($row->target)) target="{{ $row->target }}" @endif>{{ $row->text }}</a>
        </li>
      @endforeach
</ul>
@endif
