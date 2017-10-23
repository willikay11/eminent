<!doctype html>
<html lang="en" class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Eminent CRM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/css/app.css" rel="stylesheet">
    {{--<link rel="stylesheet" href="/css/font-awesome.min.css">--}}

</head>
<body>

@yield('content')

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="/js/app.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            $('#fixedNav').toggleClass('active');
        });
    });
</script>

</body>
</html>