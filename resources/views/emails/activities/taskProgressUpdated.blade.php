@extends('emails.layouts-2')

@section('email_content')
    <div class="email_body">
        <p>Progress update has been added to the following task by by <strong>{!! $user !!}</strong></p>
        <table>
            <tbody>
            <tr>
                <td><b style="font-weight: bold">Task:</b></td>
                <td>{!! $taskname !!}</td>
            </tr>

            <tr>
                <td><b style="font-weight: bold">Description:</b></td>
                <td>{!! $description !!}</td>
            </tr>

            <tr>
                <td><b style="font-weight: bold">Percentage:</b></td>
                <td>{!! $percentage !!}</td>
            </tr>
            </tbody>
        </table>

        <p>Kindly follow this <a href="{{ URL::to('/activities') }}">link</a> to view the task.</p>

    </div>
@stop