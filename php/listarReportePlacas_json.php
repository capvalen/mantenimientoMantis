<?php
include "conexion.php";

$placa = $_POST['placa'] ?? '';
$offset = intval($_POST['offset'] ?? 0);
$limit = intval($_POST['limit'] ?? 50);

if(empty($placa)) {
    echo json_encode(['rows' => [], 'total' => 0, 'hasMore' => false]);
    exit;
}

$stmtCount = $cadena->prepare("SELECT COUNT(*) as total FROM `mantenimiento` m
    inner join placas pl on pl.idPlaca = m.idPlaca
    where concat(upper(pl.movilidad), ' ',upper(pl.placSerie)) = upper(?) and mantActivo=1");
$stmtCount->bind_param("s", $placa);
$stmtCount->execute();
$total = intval($stmtCount->get_result()->fetch_assoc()['total']);

$sql = "SELECT m.`idMantenimiento`, date_format(m.`manFecha`, '%d/%m/%Y') as manFecha,
    m.`mantDescipcion`, m.`mantKilometraje`, lower(m.`mantLugar`) as mantLugar,
    lower(m.`mantResponsable`) as mantResponsable, m.`mantMonto`, m.`mantAdjunto`, m.`mantFactura`,
    tpm.`tipmDescripcion`, pl.`placSerie`, pl.`idPlaca`, m.`idTipoMantenimiento`
    FROM `mantenimiento` m
    inner join tipoMantenimiento tpm on tpm.idTipoMantenimiento = m.idTipoMantenimiento
    inner join placas pl on pl.idPlaca = m.idPlaca
    where concat(upper(pl.movilidad), ' ',upper(pl.placSerie)) = upper(?) and mantActivo=1
    ORDER BY m.manFecha DESC LIMIT ? OFFSET ?";

$stmt = $cadena->prepare($sql);
$stmt->bind_param("sii", $placa, $limit, $offset);
$stmt->execute();
$resultado = $stmt->get_result();

$rows = [];
while($row = $resultado->fetch_assoc()) {
    $row['mantDescipcion'] = nl2br($row['mantDescipcion']);
    $rows[] = $row;
}

echo json_encode([
    'rows' => $rows,
    'total' => $total,
    'offset' => $offset,
    'limit' => $limit,
    'hasMore' => ($offset + $limit) < $total
]);
