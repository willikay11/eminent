@extends('emails.layouts-2')

@section('email_content')
    <div class="email_body">
        <p>A comment has been added to the following task <strong>{!! $taskname !!}</strong> by <strong>{!! $user !!}</strong></p>

        <p>Kindly follow this <a href="{{ URL::to('/activities') }}">link</a> to view the task.</p>

    </div>
@stop