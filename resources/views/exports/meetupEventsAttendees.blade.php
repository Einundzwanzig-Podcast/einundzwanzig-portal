<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($attendees as $a)
        <tr>
            <td>{{ $a['name'] }}</td>
            <td>{{ $a['status'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
