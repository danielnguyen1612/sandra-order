<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <h3 class="text-center">The list of items - Generated date: {{ $date }}</h3>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Items</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $idx => $item)
            <tr>
                <th scope="row">{{ $idx + 1 }}</th>
                <td>
                    <ul>
                        @foreach($item['textItems'] as $text)
                            <li>{{ $text }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
