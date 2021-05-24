<style>
    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
    }

    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #eceeef;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #eceeef;
    }

    .table tbody + tbody {
        border-top: 2px solid #eceeef;
    }

    .table .table {
        background-color: #fff;
    }

    .table-sm th,
    .table-sm td {
        padding: 0.3rem;
    }

    .table-bordered {
        border: 1px solid #eceeef;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #eceeef;
    }

    .table-bordered thead th,
    .table-bordered thead td {
        border-bottom-width: 2px;
    }

    .text-left {
        text-align: left;
    }

    .text-center {
        text-align: center;
    }

    .text-super-bold {
        font-weight: 700;
        color: #000000;
    }

    .text-bold {
        font-weight: bold;
    }
</style>
<table class="table table-bordered table-xml" style="color: black; text-align: center" cellpadding="0" cellspacing="0">
    <tr class="colhead">
        <th>#</th>
        <th>Items</th>
    </tr>
    @foreach($items as $idx => $item)
        <tr>
            <td>{{ $idx + 1 }}</td>
            <td>
                <ul>
                    @foreach($item['textItems'] as $text)
                        <li>{{ $text }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
    @endforeach
</table>
