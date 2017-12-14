@extends('emails.layouts-2')

@section('email_content')
    <div class="email_body">
        <p>Team,</p>
        <p>There is feedback provided by {!! $user !!}</p>
        <table>
            <tbody>
            <tr>
                <td><b style="font-weight: bold">Subject:</b></td>
                <td>{!! $subject !!}</td>
            </tr>

            <tr>
                <td><b style="font-weight: bold">Message:</b></td>
                <td>{!! $post !!}</td>
            </tr>

            </tbody>
        </table>


    </div>
@stop