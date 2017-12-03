<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">


</head>
<body style="background-color: #f3f3f3;font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; margin: 50px; color: #595959; line-height: 2">

<div style="border-radius: 5px">
    <div class="email-logo" style="height: 200px; background-color: white; text-align: center">
        <img style="height: 120px; position: relative; top: 50%;transform: translateY(-50%);" src="http://eminent.co.ke/images/logo.png">
    </div>

    <div style="height: 200px; background-color: #fff3e7; text-align: center">
        <span style="position: relative; top: 40%;transform: translateY(-50%);font-size: 26px;word-spacing: 4px; letter-spacing: 1px">Eminent CRM</span>
    </div>
    <div id="email-body" style="min-height: 500px; background-color: white">

        <div id="content" style="padding-bottom: 50px; padding-top: 50px; padding-right: 100px; padding-left: 100px;">

            @yield('email_content')

            <p>Best Regards,</p>

            <p>Eminent Business Group</p>
        </div>

        <hr style="border-color: #ffdaba;">

        <div id="info" style="padding-bottom: 50px; padding-top: 50px; padding-right: 100px; padding-left: 100px;">
            <p>8 Downhill Court, Riara Lane</p>
            <p>P.O. BOX 10216 – 00100</p>
            <p>Nairobi, Kenya</p>
        </div>

        <hr style="border-color: #ffdaba;">
    </div>
</div>
</body>
</html>