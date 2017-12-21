<!doctype html>
<html lang="en" class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Eminent CRM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{--<link rel="stylesheet" href="/css/app.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>

<div id="app">

    @yield('content')

    <flash-message message="{!! session('success') !!}" type="success"></flash-message>

    <flash-message message="{!! session('error') !!}" type="error"></flash-message>

</div>


<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
{{--<script src="/js/app.js"></script>--}}
<script src="{{ mix('/js/app.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('show');
            $('#fixedNav').toggleClass('show');
        });
    });
</script>

</body>
</html>