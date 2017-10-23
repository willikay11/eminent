<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body style="background-color: #E6E6E6;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
<div class="email-logo" style="margin-top:0;background-color: transparent;padding: 20px 0">
    <div style="width: 80%;display: block;margin:0 auto;">
    </div>
</div>
<div class="email-body" style="
            padding: 0 0 20px;
            background-clip: content-box;
            background-color: #fff;
            width: 80%;
            margin: auto;
            margin-bottom: 20px;">

    <div style="padding: 0;margin: 0;display: flex;height: 5px;">
        <img  style="
            width:100%;height:auto;" src="http://s7.postimg.org/w2yxngwpn/top_line.png">
    </div>
    <div class="email-description" style="
        padding-top: 10px;
        padding-bottom: 10px;
            line-height: 1.5em;
            font-weight: 300;
             text-align: center;
             font-size: 24px;
            width: 100%;
            color: #176A5D;
            background: #f6f8fa">
        <p>Eminent</p>
    </div>
    <div class="email-description" style="padding: 10px;
            line-height: 1.5em;
            font-weight: 300;
             margin:auto;
            width: 80%;
            color: #565656;
            overflow: scroll">
        @yield('email_content')
    </div>
</div>
</body>
</html>