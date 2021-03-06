<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @section('head')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Vault') }} - Secure All The Things!</title>

    <!-- Styles -->
    <link href="/css/app.css?ck=1" rel="stylesheet">
    <link href="/js/vendor/easy-autocomplete/easy-autocomplete.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="/fonts/privateers/styles.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    @show
</head>
<body>
    <div id="app">

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ route('lockbox.index') }}">
                    <i class="icon icon-vault icon-2x"></i>
                    {{--@if(Auth::guest())--}}
                    {{--{{ config('app.name', 'Vault') }}--}}
                    {{--@else--}}
                    {{--{{ (Auth::user()->currentVault) ? Auth::user()->currentVault->name : config('app.name', 'Vault') }}--}}
                    {{--@endif--}}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                @if (Auth::guest())

                @else
                <ul class="nav navbar-nav">
                    @if(Auth::user()->vaults()->count() > 1)
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Switch <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                @foreach(Auth::user()->vaults as $vault)
                                    <li @if($vault->id == Auth::user()->currentVault->id) class="active" @endif><a href="{{ route('vault.show', $vault->uuid) }}">{{ $vault->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>

                <form class="navbar-form navbar-left">
                    <div class="form-group">
                        {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Jump to lockbox...', 'role' => 'lockbox-autocomplete']) !!}
                    </div>
                </form>


                @endif

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        @if(config('vault.registrations'))
                        <li><a href="{{ url('/register') }}">Register</a></li>
                        @endif
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ route('user.edit') }}">Edit Profile</a></li>
                                <li><a href="{{ route('vault.index') }}">Manage Vaults</a></li>
                                <li class="divider"></li>
                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('flash::message')

                @yield('content')

            </div>
        </div>
    </div>

    <footer class="container">
        <p class="text-center small">
            @if (Auth::check())
                <a href="{{ route('vault.index') }}">Manage Vaults</a>
            @endif
        </p>

    </footer>

    </div>
    @section('scripts')
    <!-- Scripts -->
    <script src="/js/app.js"></script>
    @if(Auth::check())
    <script src="/js/vendor/easy-autocomplete/jquery.easy-autocomplete.min.js"></script>

    <script>
        $('[role="lockbox-autocomplete"]').easyAutocomplete({
            url: '{{ route('user.lockboxes', Auth::user()->uuid) }}',

            getValue: function(element) {
                return '[' + element.vault.name + '] ' + element.name;
            },

            list: {
                match: {
                    enabled: true
                },
                onChooseEvent: function() {
                    var value = $('[role="lockbox-autocomplete"]').getSelectedItemData().uuid;

                    window.location = '/lockbox/' + value;
                }
            }
        });
    </script>
    @endif
    @show
</body>
</html>
