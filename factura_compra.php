<?php
session_start();
include_once 'persistencia/persona_bd.php';
require "code128.php";

// Verifica si la sesión está iniciada y si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['estado_admin'] ==  1) {
    header('Location: index.php'); // Redirige si no está autenticado o no es admin
    exit();
}

// Verificar si las variables de sesión están establecidas
if (isset($_SESSION['id_compra']) && isset($_SESSION['fecha_compra'])) {
    $id_compra = $_GET['id_compra'];
    $fecha_compra = $_GET['fecha_compra'];
}

$cedula_usuario = $_SESSION['usuario']['cedula'];

$personaBD = new PersonaBD();
$detalles_compra = $personaBD->obtenerDetallesCompra($id_compra);
$subtotal_sin_iva = 0;

$pdf = new PDF_Code128('P', 'mm', 'Letter');
$pdf->SetMargins(11, 11, 11);
$pdf->AddPage();

// Logo de la empresa formato png
$pdf->Image('assets/logo_negro.png', 150, 12, 0, 20, 'PNG');

// Encabezado y datos de la empresa
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(64, 66, 82);
$pdf->Cell(150, 10, iconv("UTF-8", "ISO-8859-1", strtoupper("Suits S.A.S.")), 0, 0, 'L');

$pdf->Ln(9);

$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(39, 39, 51);
$pdf->Cell(150, 9, iconv("UTF-8", "ISO-8859-1", "RUT: 0501034800015"), 0, 0, 'L');

$pdf->Ln(5);

$pdf->Cell(150, 9, iconv("UTF-8", "ISO-8859-1", "Dirección: Herrera 664, Durazno, Uruguay"), 0, 0, 'L');

$pdf->Ln(5);

$pdf->Cell(150, 9, iconv("UTF-8", "ISO-8859-1", "Teléfono: 43623475"), 0, 0, 'L');

$pdf->Ln(5);

$pdf->Ln(10);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 7, iconv("UTF-8", "ISO-8859-1", "Fecha:"), 0, 0);
$pdf->SetTextColor(97, 97, 97);
$pdf->Cell(116, 7, iconv("UTF-8", "ISO-8859-1", $fecha_compra), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 7, iconv("UTF-8", "ISO-8859-1", "Pedido:"), 0, 0);
$pdf->SetTextColor(39, 39, 51);
$pdf->Cell(35, 7, iconv("UTF-8", "ISO-8859-1", $id_compra), 'C');

$pdf->Ln(7);

$pdf->Ln(10);

$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(39, 39, 51);
$pdf->Cell(13, 7, iconv("UTF-8", "ISO-8859-1", "Cliente:"), 0, 0);
$pdf->SetTextColor(97, 97, 97);
$pdf->Cell(60, 7, iconv("UTF-8", "ISO-8859-1", $_SESSION['usuario']['nombre'] . " " . $_SESSION['usuario']['apellido']), 0, 0, 'L');
$pdf->SetTextColor(39, 39, 51);
$pdf->Cell(8, 7, iconv("UTF-8", "ISO-8859-1", "C.I.: "), 0, 0, 'L');
$pdf->SetTextColor(97, 97, 97);
$pdf->Cell(60, 7, iconv("UTF-8", "ISO-8859-1", $_SESSION['usuario']['cedula']), 0, 0, 'L');
$pdf->SetTextColor(39, 39, 51);
$pdf->Cell(7, 7, iconv("UTF-8", "ISO-8859-1", "Tel:"), 0, 0, 'L');
$pdf->SetTextColor(97, 97, 97);
$pdf->Cell(35, 7, iconv("UTF-8", "ISO-8859-1", $_SESSION['usuario']['telefono']), 0, 0);
$pdf->SetTextColor(39, 39, 51);

$pdf->Ln(7);
$pdf->SetTextColor(39, 39, 51);
$pdf->Cell(6, 7, iconv("UTF-8", "ISO-8859-1", "Dirección:"), 0, 0);
$pdf->SetTextColor(97, 97, 97);
$pdf->Cell(109, 7, iconv("UTF-8", "ISO-8859-1", "           " . $_SESSION['usuario']['direccion']), 0, 0);

$pdf->SetTextColor(39, 39, 51);
$pdf->Cell(13, 7, iconv("UTF-8", "ISO-8859-1", ""), 0, 0);
$pdf->SetTextColor(97, 97, 97);
$pdf->Cell(60, 7, iconv("UTF-8", "ISO-8859-1", ""), 0, 0);
$pdf->Ln(9);

// Configura la fuente y el tamaño
$pdf->SetFont('Arial', '', 8);

// Establece el color de fondo, el color de dibujo y el color del texto en #404252
$pdf->SetFillColor(64, 66, 82); // R:64, G:66, B:82
$pdf->SetDrawColor(64, 66, 82); // R:64, G:66, B:82
$pdf->SetTextColor(255, 255, 255); // Blanco para el texto, si quieres un color claro sobre el fondo oscuro

// Define las celdas de la tabla con el color de fondo aplicado
$pdf->Cell(90, 8, iconv("UTF-8", "ISO-8859-1", strtoupper("Detalle")), 1, 0, 'C', true);
$pdf->Cell(34, 8, iconv("UTF-8", "ISO-8859-1", strtoupper("Cantidad")), 1, 0, 'C', true);
$pdf->Cell(25, 8, iconv("UTF-8", "ISO-8859-1", strtoupper("Precio")), 1, 0, 'C', true);
$pdf->Cell(32, 8, iconv("UTF-8", "ISO-8859-1", strtoupper("Subtotal")), 1, 0, 'C', true);

$pdf->Ln(8);

// Cambia el color del texto para las filas de datos si es necesario
$pdf->SetTextColor(64, 66, 82); // R:64, G:66, B:82

// Muestra los detalles de la compra
foreach ($detalles_compra as $detalle) {
    $pdf->Cell(90, 7, iconv("UTF-8", "ISO-8859-1", $detalle['nombre_producto']), 'L', 0, 'L');
    $pdf->Cell(34, 7, iconv("UTF-8", "ISO-8859-1", $detalle['cantidad']), 'L', 0, 'C');
    $pdf->Cell(25, 7, iconv("UTF-8", "ISO-8859-1", "$" . number_format($detalle['precio_unitario'], 2)), 'L', 0, 'C');
    $pdf->Cell(32, 7, iconv("UTF-8", "ISO-8859-1", "$" . number_format($detalle['subtotal'], 2)), 'LR', 0, 'C');
    $pdf->Ln(7);
    $subtotal_sin_iva += $detalle['subtotal'];
}

$pdf->SetFont('Arial', 'B', 9);

// Impuestos y totales
$subtotal_sin_iva = $subtotal_sin_iva / 1.22;
$iva = $subtotal_sin_iva * 0.22;
$total_compra = $subtotal_sin_iva + $iva;
$pdf->Cell(100, 7, iconv("UTF-8", "ISO-8859-1", ''), 'T', 0, 'C');
$pdf->Cell(15, 7, iconv("UTF-8", "ISO-8859-1", ''), 'T', 0, 'C');
$pdf->Cell(32, 7, iconv("UTF-8", "ISO-8859-1", strtoupper("Sub Total")), 'T', 0, 'C');
$pdf->Cell(34, 7, iconv("UTF-8", "ISO-8859-1", "$" . number_format($subtotal_sin_iva, 2)), 'T', 0, 'C');

$pdf->Ln(7);

$pdf->Cell(100, 7, iconv("UTF-8", "ISO-8859-1", ''), '', 0, 'C');
$pdf->Cell(15, 7, iconv("UTF-8", "ISO-8859-1", ''), '', 0, 'C');
$pdf->Cell(32, 7, iconv("UTF-8", "ISO-8859-1", "IVA (22%)"), '', 0, 'C');
$pdf->Cell(34, 7, iconv("UTF-8", "ISO-8859-1", "$" . number_format($iva, 2)), '', 0, 'C');

$pdf->Ln(7);

$pdf->Cell(100, 7, iconv("UTF-8", "ISO-8859-1", ''), '', 0, 'C');
$pdf->Cell(15, 7, iconv("UTF-8", "ISO-8859-1", ''), '', 0, 'C');
$pdf->Cell(32, 7, iconv("UTF-8", "ISO-8859-1", strtoupper("Total")), 'T', 0, 'C');
$pdf->Cell(34, 7, iconv("UTF-8", "ISO-8859-1", "$" . number_format($total_compra, 2)), 'T', 0, 'C');

$pdf->Ln(12);

$pdf->SetFont('Arial', '', 9);

$pdf->SetTextColor(39, 39, 51);
$pdf->MultiCell(0, 9, iconv("UTF-8", "ISO-8859-1", "IVA al día"), 0, 'C', false);
$pdf->MultiCell(0, 9, iconv("UTF-8", "ISO-8859-1", "Puede verificar comprobante en www.dgi.gub.uy"), 0, 'C', false);

$pdf->Ln(9);

// Código de barras
$pdf->SetFillColor(39, 39, 51);
$pdf->SetDrawColor(23, 83, 201);
$pdf->Code128(72, $pdf->GetY(), "COD000001V0001", 70, 20);
$pdf->SetXY(12, $pdf->GetY() + 21);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "COD000001V0001"), 0, 'C', false);

// Nombre del archivo PDF y salida para descargar "D" o ver "I"
$pdf->Output("I", "Factura_Compra.pdf", true);
