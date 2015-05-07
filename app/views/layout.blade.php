<!DOCTYPE html>
<html><head>
    <meta content="text/html; charset=utf-8" http-equiv="content-type">
    <title>@yield('title') - SBShare.ru</title>
    <meta name="keywords" content="starbound,координаты,база,планеты">
    <meta name="description" content="Русская база координат Stardound, обмен координатами">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="icon" href="/img/favicon.ico" type="image/x-icon"> -->
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
    <!-- Bootstrap -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <!-- WysiBB -->
    <script src="http://cdn.wysibb.com/js/jquery.wysibb.min.js"></script>
    <!-- Tag-it -->
    <script src="/js/tag-it.js" type="text/javascript" charset="utf-8"></script>
    <!-- TextComplete -->
    <script src="/jquery-textcomplete-0.2.4/jquery.textcomplete.min.js"></script>
    <script src="/jquery-textcomplete-0.2.4/media/javascripts/emoji.js"></script>

    <script src="/js/main.js"></script>
    <link href="/style/style.css" rel="stylesheet" type="text/css">
    <!-- <link href="/img/favicon.ico" rel="shortcut icon" type="image/x-icon"> -->

    <!-- Bootstrap -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <!-- WysiBB -->
    <link rel="stylesheet" href="http://cdn.wysibb.com/css/default/wbbtheme.css" />

    <!-- Tag-it -->
    <link href="/style/jquery.tagit.css" rel="stylesheet" type="text/css">
    <link href="/style/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">

    <!-- TextComplete -->
    <link href="/jquery-textcomplete-0.2.4/jquery.textcomplete.css" rel="stylesheet" type="text/css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('headExtra')
    {{ get_users_mentions() }}
    <script type="application/javascript">
        window.bbtags = ['b', 'i', 'u', 'img', 'url', 'quote', 'code'];
    </script>
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">SBShare.ru</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/planets">Планеты</a></li>
                    <li><a href="/planets/add">Добавить планету</a></li>
                    <li><a href="/tags">Тэги</a></li>
                </ul>

                @if (!Auth::check())
                    <form class="navbar-form navbar-right" role="form" action="{{ action('UsersController@postLogin') }}" method="post">
                        <a href="/users/login" class="btn btn-success">Войти</a>
                        <a href="/users/register" class="btn btn-success">Регистрация</a>
                    </form>
                @else
                    <form class="navbar-form navbar-right" role="form" action="/users/logout">
                        <button class="btn btn-success">Выйти</button>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="@if (Auth::user()->isAdmin) {{ URL::route('admin.index') }} @else # @endif"><strong>{{ Auth::user()->username }}</strong></a></li>
                    </ul>
                @endif
            </div><!--/.navbar-collapse -->
        </div>
    </div>

    @yield('content')

    <div id="footer">
        <div class="container">
            <div class="col-md-4">
                &copy; 2014 SBShare.ru
            </div>
            <div class="col-md-4">
                <!-- Yandex.Metrika informer -->
                <a href="https://metrika.yandex.ru/stat/?id=24402829&amp;from=informer"
                   target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/24402829/3_0_FFFFFFFF_EEEEEEFF_0_pageviews"
                                                       style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:24402829,lang:'ru'});return false}catch(e){}"/></a>
                <!-- /Yandex.Metrika informer -->

                <!-- Yandex.Metrika counter -->
                <script type="text/javascript">
                    (function (d, w, c) {
                        (w[c] = w[c] || []).push(function() {
                            try {
                                w.yaCounter24402829 = new Ya.Metrika({id:24402829,
                                    webvisor:true,
                                    clickmap:true,
                                    trackLinks:true,
                                    accurateTrackBounce:true});
                            } catch(e) { }
                        });

                        var n = d.getElementsByTagName("script")[0],
                            s = d.createElement("script"),
                            f = function () { n.parentNode.insertBefore(s, n); };
                        s.type = "text/javascript";
                        s.async = true;
                        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

                        if (w.opera == "[object Opera]") {
                            d.addEventListener("DOMContentLoaded", f, false);
                        } else { f(); }
                    })(document, window, "yandex_metrika_callbacks");
                </script>
                <noscript><div><img src="//mc.yandex.ru/watch/24402829" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
                <!-- /Yandex.Metrika counter -->
            </div>
        </div>
    </div>
</body>
</html>
