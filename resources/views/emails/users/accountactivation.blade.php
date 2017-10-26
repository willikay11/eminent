@extends('emails.layout')

@section('email_content')
    <div class="email_body">
        <p>Dear {!! $firstname !!},</p>
        <p>You have been registered for an account in the <a href="http://crm.eminent.co.ke">CRM System</a>.</p>
        <p>Your account details are:</p>
        <table>
            <tbody>
            <tr><td><b style="font-weight: bold">Email:</b> </td><td>{!! $email !!}</td></tr>
            </tbody>
        </table>

        <p>You will need the email to login.</p>
        <p> Please follow this link to activate your account and create a password: <a href="{{ URL::to('users/activation/userId/'.$id.'/code/'.$code) }}" mc:disable-tracking> Activate my account now</a></p>
        <p>If clicking the link doesn't work you can copy the link into your browser window or type it there directly.</p>
        <p> {{ URL::to('users/activation/userId/'.$id.'/code/'.$code) }} </p>
        <p>Kindly note that the link will expire after 24 hrs</p>

        Regards,<br/>
        -----------------------------------------------------------------
    </div>
@stop