<nav class="navbar navbar-expand-lg " color-on-scroll="500">
    <div class="container-fluid">
        @php
        $navName = '';   
        @endphp
        <style>
            .menu-drop-right {
                left: -100px !important;
                top: 70px !important;
            }
        </style>
        <a class="navbar-brand" href="#"> {{ $navName }} </a>
        <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
            <span class="navbar-toggler-bar burger-lines"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <div class="app">
                <nav-notification />
            </div>
            <ul class="navbar-nav d-flex align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  
                        id="navbarDropdownMenuLink" 
                        data-toggle="dropdown" 
                        aria-haspopup="true" 
                        aria-expanded="false">
                        <i class="nc-icon nc-circle-09"></i>
                    </a>
                    <div class="dropdown-menu menu-drop-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="/user">{{ __('Profile') }}</a>
                        <div class="divider"></div>
                        <form id="logout-form" class="dropdown-item" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <a class="text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Log out') }} </a>
                        </form>                        
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>