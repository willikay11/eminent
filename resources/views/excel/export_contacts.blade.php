<table>
        <tr>
            <th></th>
            <th style="text-align: center">Type</th>
            <th style="text-align: center">Name</th>
            <th style="text-align: center">Email</th>
            <th style="text-align: center">Phone</th>
            <th style="text-align: center">Status</th>
            <th style="text-align: center">Source</th>
            <th style="text-align: center">User</th>
        </tr>

        @foreach($values as $key => $value)
            <tr>
                <td style="text-align: center">{!! $key !!}</td>
                <td style="text-align: center">{!! $value['type'] !!}</td>
                <td style="text-align: center">{!! $value['name'] !!}</td>
                <td style="text-align: center">{!! $value['email'] !!}</td>
                <td style="text-align: center">{!! $value['phone'] !!}</td>
                <td style="text-align: center">{!! $value['status'] !!} </td>
                <td style="text-align: center">{!! $value['source'] !!}</td>
                <td style="text-align: center">{!! $value['user'] !!}</td>
            </tr>
        @endforeach
        <tr></tr>
</table>