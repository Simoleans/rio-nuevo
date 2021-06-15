<table>
    <thead>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
    <tr>
        <th>TEMPORADA</th>
        <th>SEMANA</th>
        <th>FECHA</th>
        <th>MAQUINA</th>
        <th>CONCATENADO PIZARRA</th>
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
        <th>FACTURA ARRIENDO</th>
        <th>STATUS ARRIENDO</th>
        <th>COMPLETO</th>
        <th>N. FACTURA</th>
        <th>STATUS FACTURA</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reportes as $r)
        <tr>
            <td>{{  $temporada }}</td>
            <td>{{ $r->created_at->weekOfYear }}</td>
            <td>{{ $r->created_at->format('d-m-Y') }}</td>
            <td>{{ $r->maquina->nombre }}</td>
            <td>{{ $r->created_at->format('d-m-Y').'-'.$r->maquina->nombre }}</td>
            <td>{{ $r->id }}</td>
            <td>{{ strtoupper($r->user->name) }}</td>
            <td>{{ strtoupper($r->productor->razon_social) }}</td>
            <td>{{ strtoupper($r->campo->nombre) ?? '-' }}</td>
            <td>{{ strtoupper($r->variedad->nombre) ?? '-' }}</td>
            <td>{{ strtoupper($r->concatenadoLiquidacion()) }}</td>
            <td>{{ $r->tipo_bandeja }}</td>
            <td>{{ $r->nro_bandeja }}</td>
            <td>{{ $r->kg_totales }}</td>
            <td>{{ $r->kg_teoricos }}</td>
            <td>{{ $r->hs_maquina ?? 0 }}</td>
            <td>{{ $r->horas_delta }}</td>
        </tr>
    @endforeach
    </tbody>
</table>