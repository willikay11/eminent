@extends('emails.layouts-2')

@section('email_content')
    <div class="email_body">
        <p>Dear {!! $firstname !!},</p>
        <p>{!! $content !!}</p>
        <table>
            <tbody>
            <tr>
                <td><b style="font-weight: bold">Task:</b></td>
                <td>{!! $name !!}</td>
            </tr>

            <tr>
                <td><b style="font-weight: bold">Type:</b></td>
                <td>{!! $type !!}</td>
            </tr>

            <tr>
                <td><b style="font-weight: bold">Description:</b></td>
                <td>{!! $description !!}</td>
            </tr>

            <tr>
                <td><b style="font-weight: bold">Priority:</b></td>
                <td>{!! $priority !!}</td>
            </tr>

            <tr>
                <td><b style="font-weight: bold">Due Date:</b></td>
                <td>{!! $dueDate !!}</td>
            </tr>
            </tbody>
        </table>

        <p>Kindly follow this <a href="{{ URL::to('/activities') }}">link</a> to view the task.</p>

    </div>
@stop