<!-- resources/views/location/list.blade.php -->
 <table>
    <thead>
        <tr>
            <th>#</th>
            <th>Latitude</th>
            <th>Longitude</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($locationlist as $key => $item)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $item->latitude }}</td>
                <td>{{ $item->longitude }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
