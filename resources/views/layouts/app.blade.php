<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="keywords" content="@yield('meta_keywords')"/>
        <meta name="author" content="Elena Jesus Mangas Perez">
        <meta name="description" content="PFC - @yield('meta_description')">

        <title>@section('title') PFC @show</title>

        <link rel="icon" href="/favicon.ico" type="image/x-icon" />
        @include('partials.header')
    </head>
    <body class="hold-transition skin-blue sidebar-mini fixed">
        <div class="wrapper">
            @include('partials.nav')
            @include('partials.sidebar')

            <div class="content-wrapper">
                <section class="content-header">
                    <h1>@yield('header_title') <small>@yield('header_description')</small></h1>
                    {!! Breadcrumbs::renderIfExists() !!}
                </section>
                <section class="content">
                    @include('partials.flash')
                    @yield('content')

                    <input type="hidden" id="formatDateMoment" value="{{ \App\Helpers\Helper::setFormatDate('js')['moment'] }}"/>
                    <input type="hidden" id="formatDatepicker" value="{{ \App\Helpers\Helper::setFormatDate('js')['datepicker'] }}"/>
                    <input type="hidden" id="locale" value="{{ App::getLocale() }}"/>
                </section>
            </div>

            @include('partials.footer')
        </div>

        @include('partials.scripts')
        @yield('after_footer')
    </body>
</html>