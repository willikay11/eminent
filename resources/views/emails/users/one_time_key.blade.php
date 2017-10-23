@extends('emails.layout')

@section('email_content')
    <div>
        <h3>Eminent Login Token</h3>
        <p>
        <p>Dear {{$name}},</p>

        <p>Please use <b style="font-weight: bold">{{$otp}}</b> to login</p>
        <p>You can also <a href="{!! URL::to('/login/confirm/'.$email.'?one_time_key='.$otp) !!}">
                click here to login</a></p>

        <p>Regards,</p>
        </p>
    </div>
@stop