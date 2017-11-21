@extends('emails.layouts-2')

@section('email_content')
    <div class="email_body">
        <p>Dear {!! $firstname !!},</p>
        <p>The following contact has been assigned to you in the CRM System:</p>
        <table>
            <tbody>
            <tr>
                <td><b style="font-weight: bold">Contact Type:</b></td>
                <td>{!! $typeName !!}</td>
            </tr>
            @if($type == 1)
                <tr>
                    <td><b style="font-weight: bold">Contact Name:</b></td>
                    <td>{!! $client !!}</td>
                </tr>
            @else
                <tr>
                    <td><b style="font-weight: bold">Contact Person:</b></td>
                    <td>{!! $client !!}</td>
                </tr>
            @endif

            @if($email)
                <tr>
                    <td><b style="font-weight: bold">Email:</b></td>
                    <td>{!! $email !!}</td>
                </tr>
            @endif
            @if($phone)
                <tr>
                    <td><b style="font-weight: bold">Phone:</b></td>
                    <td>{!! $phone !!}</td>
                </tr>
            @endif
            </tbody>
        </table>
        <p>Kindly follow this <a href="{{ URL::to('/contact/details/'. $userClient) }}">link</a> to view the contact details.</p>

        Regards,<br/>

        -----------------------------------------------------------------
    </div>
@stop