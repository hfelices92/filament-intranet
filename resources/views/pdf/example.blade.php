<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">

<style>
    body {
        font-family: DejaVu Sans, sans-serif;
    }

    h1 {
        font-size: 24px;
        font-weight: bold;
        color: white;
        background: #3b82f6; /* azul vivo */
        padding: 10px 16px;
        border-radius: 6px;
        display: inline-block;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    thead th {
        background: #06b6d4; /* cian */
        color: white;
        padding: 8px;
        border-bottom: 2px solid #0ea5e9;
        text-align: left;
        font-weight: bold;
    }

    tbody td {
        padding: 8px;
        border-bottom: 1px solid #e5e7eb;
    }

    tbody tr:nth-child(odd) {
        background: #dbeafe; /* azul claro */
    }

    tbody tr:nth-child(even) {
        background: #cffafe; /* cian claro */
    }

    tbody tr:hover {
        background: #bfdbfe; /* azul más fuerte */
    }

</style>
</head>

<body>

<h1>Timesheets</h1>

<table>
    <thead>
        <tr>
            <th>Calendario</th>
            <th>Tipo</th>
            <th>Entrada</th>
            <th>Salida</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($timesheets as $timesheet)
            <tr>
                <td>{{ $timesheet->calendar->name }}</td>
                <td>{{ $timesheet->type }}</td>
                <td>{{ $timesheet->day_in }}</td>
                <td>{{ $timesheet->day_out }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
