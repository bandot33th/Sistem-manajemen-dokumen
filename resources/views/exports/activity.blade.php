<table>
    <thead>
        <tr>
            <th style="background-color: black; color: white; font-weight: bold;">No</th>
            <th style="background-color: black; color: white; font-weight: bold;">Description</th>
            <th style="background-color: black; color: white; font-weight: bold;">Event</th>
            <th style="background-color: black; color: white; font-weight: bold;">Causer</th>
            <th style="background-color: black; color: white; font-weight: bold;">Property</th>
            <th style="background-color: black; color: white; font-weight: bold;">Access Date</th>
            <th style="background-color: black; color: white; font-weight: bold;">Access Time</th>
        </tr>
    </thead>
    <tbody>
        @foreach($activities as $activity)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $activity->description }}</td>
            <td>{{ $activity->event }}</td>
            <td>{{ $activity->user->name }}</td>
            <td>{{ $activity->properties }}</td>
            <td>{{ date('d/m/Y', strtotime($activity->updated_at)) }}</td>
            <td>{{ date('H:i:s', strtotime($activity->updated_at)) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
