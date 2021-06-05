<table>
    <thead>
    <tr>
        <th>SEMANA</th>
        <th>FECHA</th>
        <th>MAQUINA</th>
        <th>CONCATENADO PIZARRA</th>
        <th>PROPIEDAD</th>
        <th>REPORT</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reportes as $r)
        <tr>
            <td>{{ $r->created_at->weekOfYear }}</td>
            <td>{{ $r->created_at->format('d-m-Y') }}</td>
            <td>{{ $r->maquina }}</td>
            <td>{{ $r->created_at->format('d-m-Y').'-'.$r->maquina }}</td>
            <td>{{ $r->maquina }}</td>
            <td>{{ $r->maquina }}</td>
        </tr>
    @endforeach
    </tbody>
</table>