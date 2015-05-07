@extends('layout')

@section('title')
Администрирование
@stop

@section('headExtra')
<script src="/js/admin.js" type="application/javascript"></script>
@stop

@section('content')
    <div class="container">
        <div class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/admin">Admin</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="/admin/news" class="dropdown-toggle" data-toggle="dropdown">Новости <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ URL::route('admin.news.index') }}">Список</a></li>
                                <!-- <li class="divider"></li> -->
                                <li><a href="{{ URL::route('admin.news.create') }}">Добавить новость</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </div>

        @if($errors->all())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        @if (Session::has('flash_message'))
        <div class="alert alert-success">
            <p>{{ Session::get('flash_message') }}</p>
        </div>
        @endif

        @yield('inner_content')
    </div>
@stop
