<div class="sidebar" data-image="{{ asset('light-bootstrap/img/sidebar-5.jpg') }}">
    <!--
Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

Tip 2: you can also add an image using data-image tag
-->
@php
 $activeButton = '';   
@endphp
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="/dashboard" class="simple-text">
                {{ __("Monitoria") }}
            </a>
        </div>
        <ul class="nav">
            <li class="nav-item @if($activePage == 'dashboard') active @endif">
                <a class="nav-link" href="{{route('dashboard')}}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>{{ __("Dashboard") }}</p>
                </a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#store" @if($activeButton =='store') aria-expanded="true" @endif>
                    <i class="nc-icon nc-cart-simple"></i>
                    <p>
                        {{ __('Store') }}
                        <b class="caret"></b>
                    </p>
                </a>
                
                <div class="collapse @showMenu(["client", "supply", "product"])" id="store">
                    <ul class="nav">
                        <li class="nav-item sub-nav @active('client')">
                            <a class="nav-link" href="{{route('client.index')}}">
                                <i class="nc-icon nc-single-02"></i>
                                <p>{{ __("Client") }}</p>
                            </a>
                        </li>
                        <li class="nav-item sub-nav @active('supply')">
                            <a class="nav-link" href="{{route('supply.index')}}">
                                <i class="nc-icon nc-single-02"></i>
                                <p>{{ __("Supply") }}</p>
                            </a>
                        </li>
                        <li class="nav-item sub-nav @active('product')">
                            <a class="nav-link" href="{{route('product.index')}}">
                                <i class="nc-icon nc-single-02"></i>
                                <p>{{ __("Product") }}</p>
                            </a>
                        </li>
                        <li class="nav-item sub-nav @active('types')">
                            <a class="nav-link" href="{{route('types.index')}}">
                                <i class="nc-icon nc-single-02"></i>
                                <p>{{ __("Types") }}</p>
                            </a>
                        </li>
                        <li class="nav-item sub-nav @active('brand')">
                            <a class="nav-link" href="{{route('brand.index')}}">
                                <i class="nc-icon nc-single-02"></i>
                                <p>{{ __("Brand") }}</p>
                            </a>
                        </li>
                        
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#laravelExamples" @if($activeButton =='laravel') aria-expanded="true" @endif>
                    <i>
                        <img src="{{ asset('light-bootstrap/img/laravel.svg') }}" style="width:25px">
                    </i>
                    <p>
                        {{ __('Laravel example') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse @showMenu(["profile", "table"])" id="laravelExamples">
                    <ul class="nav">
                        <li class="nav-item sub-nav @active('profile')">
                            <a class="nav-link" href="{{route('profile.edit')}}">
                                <i class="nc-icon nc-single-02"></i>
                                <p>{{ __("User Profile") }}</p>
                            </a>
                        </li>
                        <li class="nav-item sub-nav @if($activePage == 'user-management') active @endif">
                            <a class="nav-link" href="{{route('user.index')}}">
                                <i class="nc-icon nc-circle-09"></i>
                                <p>{{ __("User Management") }}</p>
                            </a>
                        </li>
                        <li class="nav-item sub-nav @if($activePage == 'table') active @endif">
                            <a class="nav-link" href="{{route('page.index', 'table')}}">
                                <i class="nc-icon nc-notes"></i>
                                <p>{{ __("Table List") }}</p>
                            </a>
                        </li>
                        <li class="nav-item sub-nav @if($activePage == 'typography') active @endif">
                            <a class="nav-link" href="{{route('page.index', 'typography')}}">
                                <i class="nc-icon nc-paper-2"></i>
                                <p>{{ __("Typography") }}</p>
                            </a>
                        </li>
                        <li class="nav-item sub-nav @if($activePage == 'icons') active @endif">
                            <a class="nav-link" href="{{route('page.index', 'icons')}}">
                                <i class="nc-icon nc-atom"></i>
                                <p>{{ __("Icons") }}</p>
                            </a>
                        </li>
                        <li class="nav-item sub-nav @if($activePage == 'maps') active @endif">
                            <a class="nav-link" href="{{route('page.index', 'maps')}}">
                                <i class="nc-icon nc-pin-3"></i>
                                <p>{{ __("Maps") }}</p>
                            </a>
                        </li>
                        <li class="nav-item sub-nav @if($activePage == 'notifications') active @endif">
                            <a class="nav-link" href="{{route('page.index', 'notifications')}}">
                                <i class="nc-icon nc-bell-55"></i>
                                <p>{{ __("Notifications") }}</p>
                            </a>
                        </li>
                        <li class="nav-item sub-nav ">
                            <a class="nav-link active bg-danger" href="{{route('page.index', 'upgrade')}}">
                                <i class="nc-icon nc-alien-33"></i>
                                <p>{{ __("Upgrade to PRO") }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
