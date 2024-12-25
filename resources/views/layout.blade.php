<!DOCTYPE html>
<html>
    <head>

        <meta
            charset="UTF-8"
        >
        <meta
            name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
        >
        <meta
            http-equiv="X-UA-Compatible"
            content="ie=edge"
        >

        <meta
            name="csrf-token"
            content="{{ csrf_token() }}"
        >

        @vite([
        'resources/css/app.css',
        'resources/js/app.js'
        ])

        {{--PageDone - Tailwind CSS--}}
        <link
            href="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/css/pagedone.css "
            rel="stylesheet"
        />

        {{--Remix icons--}}
        <link
            href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css"
            rel="stylesheet"
            integrity="sha512-MqL4+Io386IOPMKKyplKII0pVW5e+kb+PI/I3N87G3fHIfrgNNsRpzIXEi+0MQC0sR9xZNqZqCYVcC61fL5+Vg=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />

        {{--Swiper--}}
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
        />
        <title>
            Online - store
        </title>

    </head>
    <body>

       @yield('content')
       {{--PageDone - Tailwind CSS--}}
        <script
            src="https://cdn.jsdelivr.net/npm/pagedone@1.2.2/src/js/pagedone.js"
        ></script>

       {{--Swiper--}}
       <script
           src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"
       ></script>

    </body>
</html>
