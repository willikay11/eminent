@extends('emails.layouts-2')

@section('email_content')
    <div class="email_body">
        <p>Dear {!! $firstname !!},</p>

        <p>Please find attached a generated report on the interactions that you requested.</p>

    </div>
@stop