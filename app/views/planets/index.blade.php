@extends('layout')

@section('title')
Планеты (координаты)
@stop

@section('content')
<div class="jumbotron">
    <div class="container">
        @if (Input::has('search'))
        <h2>Найдено планет: {{ $planets->getTotal() }}</h2>
        @else
        <h2>Всего планет в базе: {{ $planets->getTotal() }}</h2>
        @endif

        <div id="search-div">
            <form action="{{ action('PlanetsController@getIndex') }}" method="get" role="form">
                <div class="row">
                    <div class="form-group col-xs-2">
                        <label for="sector">Сектор</label>
                        <select name="sector" class="form-control">
                            <option value="any" @if (Input::get('sector') == 'any') selected="true" @endif>Любой</option>
                            @foreach(Planet::$sectors as $key => $sector)
                            <option value="{{ $key }}" @if (Input::get('sector') == $key) selected="true" @endif>{{ $sector }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-xs-2">
                        <label for="level">Уровень</label>
                        {{ Form::text('level', Input::get('level'), array('class' => 'form-control')) }}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-2">
                        <label for="biome">Биом</label>
                        <select name="biome" class="form-control">
                            <option value="any" @if (Input::get('biome') == 'any') selected="true" @endif>Любой</option>
                            @foreach(Planet::$bioms as $key => $biome)
                            <option value="{{ $key }}" @if (Input::get('biome') == $key) selected="true" @endif>{{ $biome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-xs-2">
                        <label for="version">Версия игры</label>
                        <select name="version" class="form-control">
                            <option value="any" @if (Input::get('version') == 'any') selected="true" @endif>Любая</option>
                            @foreach(Planet::$versions as $key => $version)
                            <option value="{{ $key }}" @if (Input::get('version') == $key) selected="true" @endif>{{ $version }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-xs-3">
                        <label for="os">OS (операционная система)</label>
                        <select name="os" class="form-control">
                            <option value="any" @if (Input::get('os') == 'any') selected="true" @endif>Любая</option>
                            @foreach(Planet::$oses as $key => $os)
                            <option value="{{ $key }}" @if (Input::get('os') == $key) selected="true" @endif>{{ $os }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{ Form::hidden('search', true) }}
                <button type="submit" class="btn btn-primary">Поиск</button>
            </form>
        </div>
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
