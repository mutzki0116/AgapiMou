<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .scrollable-menu {
        height: auto;
        max-height: 500px;
        width: 300px;
        overflow-x: hidden;
        }
    </style>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Notifications &nbsp;<span id="notification_count" class="btn bg-danger text-white btn-sm">0</span> &nbsp;
                                </a>

                                <div class="dropdown-menu dropdown-menu-right  scrollable-menu" aria-labelledby="navbarDropdown" id="notificationList">
                                </div>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right " aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/Lei.js') }}" defer></script>

    <script type="text/javascript">
    
        function redirect_link(id) {
            httpAjax('post', '/ChangeStatus/' + id, {
                data : {
                    status : 1
                }
            }).then(res => {
                if(res.success) {
                    //window.location.href = link
                }
            });
        }

        window.onload = function() {
            
            $('#notification_count').hide();
            var notif_count = 0;
            var chk  = 0;

            setInterval( () => {
                httpAjax('get', '/getNotifications', {}).catch(errors => console.log(errors)).then(res => {
                
                    if(chk != res.checksum[0].Checksum) {
                        chk = res.checksum[0].Checksum;
                        notif_count = 0;

                        if(res.notifications.length !== 0) {


                            //Render Notifcation List
                            $('#notificationList').empty();
                                
                            

                            res.notifications.map( notif => {
                                
                                $('#notificationList').append('<a class="dropdown-item" onclick="event.preventDefault();redirect_link(' + notif.id + ')"><h5>' + (notif.isRead == 0 ? '<span class="badge badge-success"><small>New</small></span> &nbsp;' : '')  + notif.notif_title + '</h5><small class="text-secondary">' + notif.notif_message + '</small></a>')
                                $('#notificationList').append('<div class="dropdown-divider"></div>');

                                if(notif.isRead == 0) {
                                    notif_count += 1;
                                }
                            });




                            //Counter of Notications
                            if(notif_count != 0) {
                                $('#notification_count').show();
                                $('#notification_count').text(notif_count);
                                notif_count = 0;
                            }else {
                                $('#notification_count').hide();
                            }


                        }else {

                            $('#notification_count').hide();

                        }
                    }
                });

            }, 2000);

        }

    </script>
</body>
</html>
