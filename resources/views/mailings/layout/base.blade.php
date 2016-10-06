<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>@yield('mailTitle')</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width"/>

    <style type="text/css">
        body{padding:0;margin:0}
        table{max-width:640px;width:100%;font-family: sans-serif;}
        td{padding:0 16px;}
        td.mail__preview{text-align:center;height:40px;vertical-align:middle;border-bottom:1px solid #eee;}
        a.mail__preview-link{font-size:12px;color:#bbb;}
    </style>

    @yield('styles')

</head>
<body>
<center>
    <table>
        @unless(isset($_inBrowser) && $_inBrowser)
            <tr>
                <td class="mail__preview" colspan="42">
                    <a class="mail__preview-link" href="{{ route('reactor.mailings.preview', $mailing->translateOrFirst()->node_name) }}">{{ trans('mailings.preview_in_browser') }}</a>
                </td>
            </tr>
        @endunless

        @yield('content')
    </table>
</center>
</body>
</html>