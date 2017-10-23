@extends('emails.layout')

@section('email_content')

    <h3>Password Reset</h3>

    <div>
        <p>Click <a href="{!! URL::to('/password/remind/user/'.$id.'/token/'.$token) !!}"> here </a> to reset your password. </p>

        This link will expire in {{ Config::get('auth.passwords.users.expire') }} minutes.<br/>

        If you can't click the above link, copy the link below to your browser.<br/>

        <a href="{!! URL::to('/password/remind/user/'.$id.'/token/'.$token) !!}">{!! URL::to('/password/remind/user/'.$id.'/token/'.$token) !!}</a>
    </div>
@stop