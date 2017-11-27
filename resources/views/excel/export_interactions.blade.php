<table>
    <tr>
        <th></th>
        <th style="text-align: center">Client</th>
        <th style="text-align: center">Interaction Type</th>
        <th style="text-align: center">Date</th>
        <th style="text-align: center">Remarks</th>
        <th style="text-align: center">User</th>
    </tr>

    @foreach($values as $key => $value)
        <tr>
            <td style="text-align: center">{!! $key !!}</td>
            <td style="text-align: center">{!! $value['client'] !!}</td>
            <td style="text-align: center">{!! $value['interactionType'] !!}</td>
            <td style="text-align: center">{!! $value['date'] !!}</td>
            <td>{!! $value['remarks'] !!}</td>
            <td style="text-align: center">{!! $value['user'] !!}</td>
        </tr>
    @endforeach
    <tr></tr>
</table>