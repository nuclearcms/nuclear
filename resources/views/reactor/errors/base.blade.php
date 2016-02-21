<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">

    <link href="https://fonts.googleapis.com/css?family=Lato:100,300" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #5f696a;
            display: table;
            font-weight: 300;
            font-family: 'Lato';
            font-size: 1em;
        }

        a {
            color: #3498DB;
        }

        img {
            width: 6em;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
            padding: 1em
        }

        .title {
            font-size: 4.5em;
            margin-bottom: 0.5em;
            font-weight: 100;
            color: #bdc3c7;
        }

        .name {
            font-size: 2em;
        }

        .description {
            font-size: 0.875em
        }

    </style>
</head>
<body>
<div class="container">
    <div class="content">
        @yield('image')
        <div class="title">@yield('code')</div>
        <div class="name">@yield('title')</div>
        <div class="description">@yield('description')</div>
    </div>
</div>
</body>
</html>
