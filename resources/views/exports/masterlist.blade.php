<table>
    <thead>
        <tr>
            <th>NO.</th>
            <th>ADDRESS OF DRAWING</th>
            <th>DRAWING NO.</th>
            <th>NAME OF MACHINE</th>
            <th>DRAWING FILE CONTENTS</th>
            <th>REMARKS</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($masterLists as $item)
        <tr>

            <td align="center" valign="center">{{ $loop->iteration }}</td>
            <td align="center" valign="center">{{ $item->address_of_drawing }}</td>
            <td align="center" valign="center">{{ $item->drawing_number }}</td>
            <td align="center" valign="center">{{ $item->name_of_machine }}</td>
            <td valign="center">
                @php
                $contents = preg_split("/\r\n|\n|\r/", $item->drawing_file_contents);
                @endphp

                @foreach ($contents as $content)
                {{ $content }}<br />
                @endforeach
            </td>
            <td valign="center">{{ $item->remarks }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
