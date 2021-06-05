<table>
    <thead>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
    <tr>
        <th>SEMANA</th>
        <th>FECHA</th>
        <th>MAQUINA</th>
        <th>CONCATENADO PIZARRA</th>
        <th>PROPIEDAD</th>
        <th>REPORT</th>
        <th>OPERADOR</th>
        <th>RAZÓN SOCIAL</th>
        <th>CAMPO</th>
        <th>VARIEDAD</th>
        <th>CONCATENADO LIQUIDACIONES</th>
        <th>BANDEJAS</th>
        <th>CANTIDAD BANDEJAS</th>
        <th>KILOS</th>
        <th>KILOS TEÓRICOS</th>
        <th>HORAS</th>
        <th>HORAS DELTA</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reportes as $r)
        <tr>
            <td>{{ $r->created_at->weekOfYear }}</td>
            <td>{{ $r->created_at->format('d-m-Y') }}</td>
            <td>{{ $r->maquina }}</td>
            <td>{{ $r->created_at->format('d-m-Y').'-'.$r->maquina }}</td>
            <td>{{ strtoupper($r->maquina()->tipo) }}</td>
            <td>{{ $r->id }}</td>
            <td>{{ strtoupper(auth()->user()->name) }}</td>
            <td>{{ strtoupper($r->productor) }}</td>
            <td>{{ strtoupper($r->campo) ?? '-' }}</td>
            <td>{{ strtoupper($r->variedad) ?? '-' }}</td>
            <td>CONCATENADO LIQUIDACIONES</td>
            <td>{{ $r->tipo_bandeja }}</td>
            <td>{{ $r->nro_bandeja }}</td>
            <td>{{ $r->kg_totales }}</td>
            <td>{{ $r->kg_teoricos }}</td>
            <td>{{ $r->hs_maquina }}</td>
            <td>Horas Delta</td>
        </tr>
    @endforeach
    </tbody>
</table>