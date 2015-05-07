@extends('layout')

@section('title')
{{ $tag }} координаты
@stop

@section('content')
<div class="jumbotron">
    <div class="container">
        <h2>Планеты с тэгом '{{ $tag }}'</h2>
    </div>
</div>

<div class="container">
    <?php $counter = 0; ?>
    @foreach($planets as $planet)
    <?php $counter++ ?>
    @if ($counter % 3 == 0)
    <div class="row">
        @endif
        @include('planets/planet_summary')
        @if ($counter % 3 == 0)
    </div>
    @endif

    @endforeach

    @if ($counter % 3 != 0)
</div>
@endif

{{ $planets->links() }}
</div>
@stop
