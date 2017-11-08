@extends('emails.layout')

@section('email_content')
    <div class="email_body">
        <p>Dear {!! $firstname !!},</p>
        <p>A total of {!! $total !!} contact(s) have been assigned to you.</p>

        <p>Kindly follow this <a href="{{ URL::to('/contacts/user') }}">link</a> to view your leads.</p>

        Regards,<br/>

        -----------------------------------------------------------------
    </div>
@stop