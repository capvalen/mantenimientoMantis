<?php
/**
 * enviar_reporte.php
 * Reporte de alertas de vencimientos (SOAT, Aceite, Caja)
 * 
 * Uso:
 *   - Via web:   https://tudominio.com/php/enviar_reporte.php
 *   - Via cron:  php /ruta/php/enviar_reporte.php
 *   - Solo JSON: agregar ?action=json
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

// ========================== CONFIGURACIÓN ==========================
$emailFrom = 'automatico@contratistasjkm.com';  // remitente
$emailTo   = 'rquispe@contratistasjkm.com';     // destinatario
$emailBcc  = 'infocat.soluciones@gmail.com';                                // copia oculta (opcional)
// --- SMTP (servidor de correo) ---
$smtpHost = 'mail.contratistasjkm.com';
$smtpPort = 465;
$smtpUser = 'automatico@contratistasjkm.com';
$smtpPass = '';  // coloca aquí la contraseña
// ===================================================================

date_default_timezone_set('America/Lima');

include __DIR__ . '/conexion.php';

function obtenerAlertasSoat($cadena) {
	$sql = "SELECT *, date_format(vencimientoSoat, '%d/%m/%Y') as vencimientoSoatLatam,
		date_format(vencimientoRT, '%d/%m/%Y') as vencimientoRTLatam,
		date_format(vencimientoRCT, '%d/%m/%Y') as vencimientoRCTLatam
		FROM placas WHERE placActivo = 1 ORDER BY idPlaca";
	$resultado = $cadena->query($sql);
	$hoy = new DateTime(date('Y-m-d'));
	$warning = [];
	$danger = [];

	while ($row = $resultado->fetch_assoc()) {
		$placa = $row['placSerie'];
		$fechas = [
			['fecha' => $row['vencimientoSoat'] ?? '', 'label' => 'SOAT'],
			['fecha' => $row['vencimientoRT'] ?? '',  'label' => 'RT'],
			['fecha' => $row['vencimientoRCT'] ?? '', 'label' => 'RCT'],
		];

		$tieneWarning = false;
		$tieneDanger = false;

		foreach ($fechas as $f) {
			if ($f['fecha'] == '') continue;
			$vence = new DateTime($f['fecha']);
			$intervalo = (int)$hoy->diff($vence)->format('%R%a');

			if ($intervalo > 10) continue;
			if ($intervalo > 0) $tieneWarning = true;
			else $tieneDanger = true;
		}

		if ($tieneWarning) $warning[] = $placa;
		if ($tieneDanger)  $danger[] = $placa;
	}

	return ['warning' => $warning, 'danger' => $danger];
}

function obtenerAlertasAceite($cadena) {
	$sql = "SELECT a.idPlaca, a.horometro, a.kilometraje, a.tipo,
		p.rango, p.porcentajeAviso, p.placSerie,
		CASE a.tipo WHEN 1 THEN 'km' WHEN 2 THEN 'horas' END as queTipo
		FROM aceite a
		INNER JOIN (
			SELECT idPlaca, MAX(id) as max_id FROM aceite GROUP BY idPlaca
		) a2 ON a.id = a2.max_id
		INNER JOIN placas p ON a.idPlaca = p.idPlaca
		WHERE p.placActivo = 1
		ORDER BY p.idPlaca";
	$resultado = $cadena->query($sql);
	$warning = [];
	$danger = [];

	while ($row = $resultado->fetch_assoc()) {
		$proximo = $row['kilometraje'] + $row['rango'];
		$restante = $proximo - $row['horometro'];
		$aviso = $row['rango'] * $row['porcentajeAviso'] / 100;

		if ($restante >= $aviso) continue;

		if ($restante < 10) $danger[] = $row['placSerie'];
		else $warning[] = $row['placSerie'];
	}

	return ['warning' => $warning, 'danger' => $danger];
}

function obtenerAlertasCaja($esclavo) {
	$sql = "SELECT a.idPlaca,
		horometroAnterior(a.idPlaca) as horometroAnterior,
		p.rango2, p.porcentajeAviso2, p.placSerie,
		CASE queKilo(a.idPlaca) WHEN 1 THEN 'km' WHEN 2 THEN 'horas' END as queTipo,
		horometroRecienteCaja(a.idPlaca) as horometroReciente
		FROM placas p
		INNER JOIN aceite a ON a.idPlaca = p.idPlaca
		WHERE p.placActivo = 1
		GROUP BY a.idPlaca
		ORDER BY p.idPlaca";
	$resultado = $esclavo->query($sql);
	$warning = [];
	$danger = [];

	while ($row = $resultado->fetch_assoc()) {
		$proximo = $row['horometroReciente'] + $row['rango2'];
		$restante = $proximo - $row['horometroAnterior'];
		$aviso = $row['rango2'] * $row['porcentajeAviso2'] / 100;

		if ($restante >= $aviso) continue;

		if ($restante < 0) $danger[] = $row['placSerie'];
		else $warning[] = $row['placSerie'];
	}

	return ['warning' => $warning, 'danger' => $danger];
}

function enviarEmail($to, $subject, $htmlBody, $from, $smtpHost, $smtpPort, $smtpUser, $smtpPass, $bcc = '') {
	$mail = new PHPMailer(true);
	try {
		$mail->isSMTP();
		$mail->Host       = $smtpHost;
		$mail->SMTPAuth   = true;
		$mail->Username   = $smtpUser;
		$mail->Password   = $smtpPass;
		$mail->SMTPSecure = $smtpPort == 465 ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
		$mail->Port       = $smtpPort;
		$mail->CharSet    = 'UTF-8';
		$mail->setFrom($from);
		$mail->addAddress($to);
		if ($bcc) $mail->addBCC($bcc);
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body    = $htmlBody;
		$mail->send();
		return true;
	} catch (Exception $e) {
		return $mail->ErrorInfo;
	}
}

// ======================== MAIN ========================
$alertas = [
	'soat'  => obtenerAlertasSoat($cadena),
	'aceite' => obtenerAlertasAceite($cadena),
	'caja'  => obtenerAlertasCaja($esclavo),
];

$totalWarning = 0;
$totalDanger = 0;
foreach ($alertas as $t) {
	$totalWarning += count($t['warning']);
	$totalDanger += count($t['danger']);
}

// --- HTML del reporte ---
$itemsHtml = '';
$tablas = ['soat' => 'SOAT', 'aceite' => 'Aceite y Filtros', 'caja' => 'Caja y Corona'];
foreach ($tablas as $key => $label) {
	$w = $alertas[$key]['warning'];
	$d = $alertas[$key]['danger'];
	$partes = [];
	if ($d) $partes[] = '<span style="color:#dc3545;font-weight:bold">⛔ Vencidas (' . count($d) . '):</span> ' . implode(', ', $d);
	if ($w) $partes[] = '<span style="color:#664d03;font-weight:bold">⚠ Por vencer (' . count($w) . '):</span> ' . implode(', ', $w);
	if (!$partes) $partes[] = '<span style="color:#198754">✓ Sin alertas</span>';
	$itemsHtml .= "<tr><td style='padding:10px;border-bottom:1px solid #ddd;font-weight:bold;white-space:nowrap;vertical-align:top'>$label</td>
		<td style='padding:10px;border-bottom:1px solid #ddd;vertical-align:top'>" . implode('<br>', $partes) . "</td></tr>";
}

$html = "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'></head><body style='font-family:Arial,sans-serif;margin:0;padding:20px;background:#f5f5f5'>";
$html .= "<div style='max-width:700px;margin:0 auto;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.1)'>";
$html .= "<div style='background:#343a40;color:#fff;padding:20px;text-align:center'>";
$html .= "<h2 style='margin:0'>Reporte de Alertas - Mantenimiento</h2>";
$html .= "<p style='margin:5px 0 0;opacity:.9'>" . date('d/m/Y H:i') . "</p></div>";
$html .= "<div style='padding:20px'>";
$html .= "<p><strong>Resumen:</strong> " . ($totalWarning + $totalDanger) . " alertas (" . ($totalDanger ? "<span style='color:#dc3545'>$totalDanger urgentes</span>" : "0 urgentes") . ", " . ($totalWarning ? "<span style='color:#664d03'>$totalWarning por vencer</span>" : "0 por vencer") . ")</p>";
if ($totalWarning + $totalDanger > 0) {
	$html .= "<table style='width:100%;border-collapse:collapse;margin-top:10px'>";
	$html .= "<thead><tr style='background:#f8f9fa'><th style='padding:10px;text-align:left;border-bottom:2px solid #dee2e6'>Sección</th><th style='padding:10px;text-align:left;border-bottom:2px solid #dee2e6'>Alertas</th></tr></thead><tbody>$itemsHtml</tbody></table>";
} else {
	$html .= "<p style='text-align:center;color:#198754;font-size:1.2em;padding:30px'>✓ Todas las unidades se encuentran operativas</p>";
}
$html .= "</div></div></body></html>";

// --- Salida ---
if (isset($_GET['action']) && $_GET['action'] === 'json') {
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($alertas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	exit;
}

// Sin destinatario → mostrar HTML en navegador
if (empty($emailTo)) {
	echo $html;
	exit;
}

// Enviar correo con PHPMailer
$res = enviarEmail($emailTo, 'Reporte de Alertas - Mantenimiento', $html, $emailFrom,
	$smtpHost, $smtpPort, $smtpUser, $smtpPass, $emailBcc);

if ($res === true) {
	if (PHP_SAPI === 'cli') echo "Email enviado correctamente\n";
	else echo "<div style='padding:20px;color:#198754;font-weight:bold'>✓ Email enviado correctamente</div><hr>$html";
} else {
	if (PHP_SAPI === 'cli') echo "Error: $res\n";
	else echo "<div style='padding:20px;color:#dc3545;font-weight:bold'>✗ Error: $res</div><hr>$html";
}
