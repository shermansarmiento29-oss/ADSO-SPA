<?php

function crearCatalogoServicios(): array {
    return [
        ['nombre' => 'Limpieza facial',            'precio' => 80000,  'duracion' => 2],
        ['nombre' => 'Manicure',                    'precio' => 35000,  'duracion' => 1],
        ['nombre' => 'Pedicure',                     'precio' => 40000,  'duracion' => 1],
        ['nombre' => 'Masaje relajante',             'precio' => 90000,  'duracion' => 1],
        ['nombre' => 'Masaje descontracturante',     'precio' => 100000, 'duracion' => 1],
        ['nombre' => 'Exfoliación corporal',         'precio' => 60000,  'duracion' => 1],
        ['nombre' => 'Tratamiento antiedad',         'precio' => 120000, 'duracion' => 2],
    ];
}

const S_LIMPIEZA_FACIAL   = 0;
const S_MANICURE          = 1;
const S_PEDICURE          = 2;
const S_MASAJE_RELAJANTE  = 3;
const S_MASAJE_DESCONTRAC = 4;
const S_EXFOLIACION       = 5;
const S_ANTIEDAD          = 6;

function agregarEmpleado(array &$empleados, string $nombre, string $especialidad): void {
    $empleados[] = [
        'nombre'       => $nombre,
        'especialidad' => $especialidad,
        'citas'        => [],
    ];
}

function agregarCita(array &$empleados, int $idxEmpleado, string $cliente, string $dia, int $hora, array $servicios): void {
    $empleados[$idxEmpleado]['citas'][] = [
        'cliente'   => $cliente,
        'dia'       => $dia,
        'hora'      => $hora,
        'servicios' => $servicios,
    ];
}

function cargarDatosPrueba(): array {
    $empleados = [];

    agregarEmpleado($empleados, 'Ana Torres',      'Cosmetología facial');
    agregarEmpleado($empleados, 'Camila Rios',     'Manicure y pedicure');
    agregarEmpleado($empleados, 'Laura Gomez',     'Masajes');
    agregarEmpleado($empleados, 'Diego Salazar',   'Estética corporal');

    agregarCita($empleados, 0, 'Maria Perez',   'lunes',    8, [S_LIMPIEZA_FACIAL]);
    agregarCita($empleados, 0, 'Pedro Ruiz',    'lunes',    9, [S_MANICURE]);
    agregarCita($empleados, 0, 'Sofia Herrera', 'martes',  10, [S_ANTIEDAD]);
    agregarCita($empleados, 0, 'Carlos Muñoz',  'miércoles',14,[S_LIMPIEZA_FACIAL, S_MANICURE]);
    agregarCita($empleados, 0, 'Valentina Ortiz','jueves',  9, [S_EXFOLIACION]);

    agregarCita($empleados, 1, 'Laura Ibáñez',  'lunes',   11, [S_MANICURE, S_PEDICURE]);
    agregarCita($empleados, 1, 'Andrea Cortés', 'martes',   8, [S_PEDICURE]);
    agregarCita($empleados, 1, 'Julián Vargas', 'miércoles',10,[S_MANICURE]);
    agregarCita($empleados, 1, 'Camila Rojas',  'viernes', 15, [S_MANICURE, S_PEDICURE]);

    agregarCita($empleados, 2, 'Diana Peña',    'lunes',   14, [S_MASAJE_RELAJANTE]);
    agregarCita($empleados, 2, 'Esteban Duarte','martes',  16, [S_MASAJE_DESCONTRAC]);
    agregarCita($empleados, 2, 'Natalia Reyes', 'jueves',  11, [S_MASAJE_RELAJANTE, S_MASAJE_DESCONTRAC]);
    agregarCita($empleados, 2, 'Ricardo Lozano','sábado',   9, [S_MASAJE_DESCONTRAC]);

    agregarCita($empleados, 3, 'Paula Medina',  'miércoles',9, [S_EXFOLIACION, S_ANTIEDAD]);
    agregarCita($empleados, 3, 'Fernando Castro','viernes', 8, [S_LIMPIEZA_FACIAL]);

    return $empleados;
}

function leerTexto(string $mensaje): string {
    do {
        $valor = trim(readline($mensaje));
        if ($valor === '') {
            echo "Este dato no puede quedar vacio.\n";
        }
    } while ($valor === '');
    return $valor;
}

function leerSiNo(string $mensaje): bool {
    while (true) {
        $valor = strtolower(leerTexto($mensaje));
        if ($valor === 's') return true;
        if ($valor === 'n') return false;
        echo "Responda 's' o 'n'.\n";
    }
}

function leerDia(): string {
    $diasValidos = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
    while (true) {
        $dia = strtolower(leerTexto("Dia (lunes a sabado): "));
        if (in_array($dia, $diasValidos)) return $dia;
        echo "Dia invalido. Debe ser: lunes, martes, miércoles, jueves, viernes o sábado.\n";
    }
}

function leerHora(): int {
    while (true) {
        $hora = leerTexto("Hora de inicio (8 a 18): ");
        if (ctype_digit($hora) && (int)$hora >= 8 && (int)$hora <= 18) {
            return (int)$hora;
        }
        echo "Hora invalida. Debe ser un numero entre 8 y 18.\n";
    }
}

function mostrarEmpleados(array $empleados): void {
    echo str_pad("#", 4) . str_pad("Nombre", 25) . "Especialidad\n";
    foreach ($empleados as $i => $empleado) {
        echo str_pad((string)($i + 1), 4) . str_pad($empleado['nombre'], 25) . $empleado['especialidad'] . "\n";
    }
}

function mostrarCatalogo(array $catalogoServicios): void {
    echo str_pad("#", 4) . str_pad("Servicio", 26) . str_pad("Precio", 14) . "Duracion\n";
    foreach ($catalogoServicios as $i => $servicio) {
        $precio = number_format($servicio['precio'], 0, ',', '.');
        echo str_pad((string)($i + 1), 4) . str_pad($servicio['nombre'], 26) . str_pad('$' . $precio, 14) . $servicio['duracion'] . "h\n";
    }
}

function leerNumeroEmpleado(array $empleados): int {
    while (true) {
        $numero = leerTexto("Seleccione el numero de empleado: ");
        if (ctype_digit($numero) && (int)$numero >= 1 && (int)$numero <= count($empleados)) {
            return (int)$numero - 1;
        }
        echo "Numero de empleado invalido.\n";
    }
}

function leerNumeroServicio(array $catalogoServicios): int {
    while (true) {
        $numero = leerTexto("Seleccione el numero de servicio: ");
        if (ctype_digit($numero) && (int)$numero >= 1 && (int)$numero <= count($catalogoServicios)) {
            return (int)$numero - 1;
        }
        echo "Numero de servicio invalido.\n";
    }
}

function registrarEmpleado(array &$empleados): void {
    do {
        $nombre = leerTexto("Nombre del empleado: ");
        $especialidad = leerTexto("Especialidad: ");
        agregarEmpleado($empleados, $nombre, $especialidad);
        echo "Empleado registrado.\n";
    } while (leerSiNo("¿Desea registrar otro empleado? (s/n): "));
}

function registrarCita(array &$empleados, array $catalogoServicios): void {
    if (count($empleados) === 0) {
        echo "No hay empleados registrados. Registre al menos uno antes de agendar citas.\n";
        return;
    }

    echo "\nEmpleados disponibles:\n";
    mostrarEmpleados($empleados);
    $idxEmpleado = leerNumeroEmpleado($empleados);

    $cliente = leerTexto("Nombre del cliente: ");
    $dia = leerDia();
    $hora = leerHora();

    $servicios = [];
    do {
        echo "\nCatalogo de servicios:\n";
        mostrarCatalogo($catalogoServicios);
        $servicios[] = leerNumeroServicio($catalogoServicios);
    } while (leerSiNo("¿Desea agregar otro servicio a esta cita? (s/n): "));

    agregarCita($empleados, $idxEmpleado, $cliente, $dia, $hora, $servicios);
    echo "Cita registrada.\n";
}

function calcularDuracionCita(array $cita, array $catalogoServicios): int {
    $duracion = 0;
    foreach ($cita['servicios'] as $idxServicio) {
        $duracion += $catalogoServicios[$idxServicio]['duracion'];
    }
    return $duracion;
}

function calcularTotalCita(array $cita, array $catalogoServicios): int {
    $total = 0;
    foreach ($cita['servicios'] as $idxServicio) {
        $total += $catalogoServicios[$idxServicio]['precio'];
    }
    return $total;
}

function nombresServiciosCita(array $cita, array $catalogoServicios): string {
    $nombres = [];
    foreach ($cita['servicios'] as $idxServicio) {
        $nombres[] = $catalogoServicios[$idxServicio]['nombre'];
    }
    return implode(', ', $nombres);
}

function totalFacturadoPorEmpleado(array $empleados, array $catalogoServicios): void {
    if (count($empleados) === 0) {
        echo "No hay empleados registrados.\n";
        return;
    }

    $totales = [];
    foreach ($empleados as $empleado) {
        $total = 0;
        foreach ($empleado['citas'] as $cita) {
            $total += calcularTotalCita($cita, $catalogoServicios);
        }
        $totales[] = ['nombre' => $empleado['nombre'], 'total' => $total];
    }

    usort($totales, fn($a, $b) => $b['total'] <=> $a['total']);

    echo "\n" . str_pad("Empleado", 25) . "Total facturado\n";
    foreach ($totales as $fila) {
        $totalFormateado = '$' . number_format($fila['total'], 0, ',', '.');
        echo str_pad($fila['nombre'], 25) . $totalFormateado . "\n";
    }
}

function servicioMasSolicitado(array $empleados, array $catalogoServicios): void {
    $conteo = array_fill(0, count($catalogoServicios), 0);
    $facturado = array_fill(0, count($catalogoServicios), 0);

    foreach ($empleados as $empleado) {
        foreach ($empleado['citas'] as $cita) {
            foreach ($cita['servicios'] as $idxServicio) {
                $conteo[$idxServicio]++;
                $facturado[$idxServicio] += $catalogoServicios[$idxServicio]['precio'];
            }
        }
    }

    if (array_sum($conteo) === 0) {
        echo "No hay servicios registrados todavia.\n";
        return;
    }

    $idxGanador = array_keys($conteo, max($conteo))[0];
    $nombre = $catalogoServicios[$idxGanador]['nombre'];
    $veces = $conteo[$idxGanador];
    $totalFormateado = '$' . number_format($facturado[$idxGanador], 0, ',', '.');

    echo "\nServicio mas solicitado: $nombre\n";
    echo "Veces prestado: $veces\n";
    echo "Total facturado por ese servicio: $totalFormateado\n";
}

function agendaDeUnDia(array $empleados, array $catalogoServicios): void {
    $dia = leerDia();

    $citasDelDia = [];
    foreach ($empleados as $empleado) {
        foreach ($empleado['citas'] as $cita) {
            if ($cita['dia'] === $dia) {
                $citasDelDia[] = [
                    'hora'      => $cita['hora'],
                    'empleado'  => $empleado['nombre'],
                    'cliente'   => $cita['cliente'],
                    'servicios' => nombresServiciosCita($cita, $catalogoServicios),
                ];
            }
        }
    }

    if (count($citasDelDia) === 0) {
        echo "\nNo hay citas registradas para el dia $dia.\n";
        return;
    }

    usort($citasDelDia, fn($a, $b) => $a['hora'] <=> $b['hora']);

    echo "\nAgenda del dia $dia:\n";
    echo str_pad("Hora", 7) . str_pad("Empleado", 20) . str_pad("Cliente", 20) . "Servicios\n";
    foreach ($citasDelDia as $fila) {
        echo str_pad($fila['hora'] . ":00", 7) . str_pad($fila['empleado'], 20) . str_pad($fila['cliente'], 20) . $fila['servicios'] . "\n";
    }
}

function detectarConflictos(array $empleados, array $catalogoServicios): void {
    $huboConflicto = false;

    foreach ($empleados as $empleado) {
        $citasPorDia = [];
        foreach ($empleado['citas'] as $cita) {
            $duracion = calcularDuracionCita($cita, $catalogoServicios);
            $citasPorDia[$cita['dia']][] = [
                'cliente' => $cita['cliente'],
                'inicio'  => $cita['hora'],
                'fin'     => $cita['hora'] + $duracion,
            ];
        }

        foreach ($citasPorDia as $dia => $citas) {
            $cantidad = count($citas);
            for ($i = 0; $i < $cantidad; $i++) {
                for ($j = $i + 1; $j < $cantidad; $j++) {
                    $seSolapan = $citas[$i]['inicio'] < $citas[$j]['fin'] && $citas[$j]['inicio'] < $citas[$i]['fin'];
                    if ($seSolapan) {
                        $huboConflicto = true;
                        echo "\nConflicto: {$empleado['nombre']} el $dia tiene a {$citas[$i]['cliente']} "
                           . "({$citas[$i]['inicio']}h-{$citas[$i]['fin']}h) y a {$citas[$j]['cliente']} "
                           . "({$citas[$j]['inicio']}h-{$citas[$j]['fin']}h) al mismo tiempo.\n";
                    }
                }
            }
        }
    }

    if (!$huboConflicto) {
        echo "\nNo se encontraron conflictos de agenda.\n";
    }
}

function liquidacionComisiones(array $empleados, array $catalogoServicios): void {
    if (count($empleados) === 0) {
        echo "No hay empleados registrados.\n";
        return;
    }

    $resultados = [];
    $idxMayorFacturacion = 0;
    $mayorFacturacion = -1;

    foreach ($empleados as $i => $empleado) {
        $total = 0;
        foreach ($empleado['citas'] as $cita) {
            $total += calcularTotalCita($cita, $catalogoServicios);
        }
        $cantidadCitas = count($empleado['citas']);
        $porcentaje = $cantidadCitas >= 6 ? 0.12 : 0.08;
        $comision = $total * $porcentaje;

        $resultados[] = [
            'nombre'     => $empleado['nombre'],
            'total'      => $total,
            'citas'      => $cantidadCitas,
            'porcentaje' => $porcentaje,
            'comision'   => $comision,
        ];

        if ($total > $mayorFacturacion) {
            $mayorFacturacion = $total;
            $idxMayorFacturacion = $i;
        }
    }

    $resultados[$idxMayorFacturacion]['comision'] += 50000;
    $resultados[$idxMayorFacturacion]['bono'] = true;

    echo "\n" . str_pad("Empleado", 22) . str_pad("Citas", 8) . str_pad("Facturado", 15) . str_pad("%", 6) . str_pad("Comision", 15) . "Bono\n";
    foreach ($resultados as $fila) {
        $totalFormateado = '$' . number_format($fila['total'], 0, ',', '.');
        $comisionFormateada = '$' . number_format($fila['comision'], 0, ',', '.');
        $porcentajeTexto = ($fila['porcentaje'] * 100) . '%';
        $bonoTexto = isset($fila['bono']) ? 'Si (+$50.000)' : '';
        echo str_pad($fila['nombre'], 22) . str_pad((string)$fila['citas'], 8) . str_pad($totalFormateado, 15) . str_pad($porcentajeTexto, 6) . str_pad($comisionFormateada, 15) . $bonoTexto . "\n";
    }
}

$catalogoServicios = crearCatalogoServicios();
$empleados = [];
$datosPruebaCargados = false;

while (true) {
    echo "\n==================\n";
    echo "====opciones=====\n";
    echo "==================\n";
    echo "1. Registrar empleado" . ($datosPruebaCargados ? " (deshabilitado)" : "") . "\n";
    echo "2. Registrar cita" . ($datosPruebaCargados ? " (deshabilitado)" : "") . "\n";
    echo "3. Total facturado por empleado\n";
    echo "4. Servicio mas solicitado\n";
    echo "5. Agenda de un dia\n";
    echo "6. Deteccion de conflictos\n";
    echo "7. Liquidacion de comisiones\n";
    echo "8. Salir\n";

    $opcionMenu1 = trim(readline("digite el numero de la opcion que desea: "));

    if ($opcionMenu1 === 'dp') {
        if ($datosPruebaCargados) {
            echo "Esta opcion no esta disponible: los datos de prueba ya fueron cargados.\n";
            continue;
        }
        $empleados = cargarDatosPrueba();
        $datosPruebaCargados = true;
        echo "Datos de prueba cargados exitosamente.\n";
        continue;
    }

    switch ($opcionMenu1) {
        case '1':
            if ($datosPruebaCargados) {
                echo "Esta opcion no esta disponible porque ya se cargaron los datos de prueba.\n";
                break;
            }
            registrarEmpleado($empleados);
            break;

        case '2':
            if ($datosPruebaCargados) {
                echo "Esta opcion no esta disponible porque ya se cargaron los datos de prueba.\n";
                break;
            }
            registrarCita($empleados, $catalogoServicios);
            break;

        case '3':
            totalFacturadoPorEmpleado($empleados, $catalogoServicios);
            break;

        case '4':
            servicioMasSolicitado($empleados, $catalogoServicios);
            break;

        case '5':
            agendaDeUnDia($empleados, $catalogoServicios);
            break;

        case '6':
            detectarConflictos($empleados, $catalogoServicios);
            break;

        case '7':
            liquidacionComisiones($empleados, $catalogoServicios);
            break;

        case '8':
            echo "Hasta luego.\n";
            exit;

        default:
            echo "Opcion invalida.\n";
    }
}