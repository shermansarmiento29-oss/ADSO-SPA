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
    agregarEmpleado($empleados, 'Camila Ríos',     'Manicure y pedicure');
    agregarEmpleado($empleados, 'Laura Gómez',     'Masajes');
    agregarEmpleado($empleados, 'Diego Salazar',   'Estética corporal');

    agregarCita($empleados, 0, 'María Pérez',   'lunes',    8, [S_LIMPIEZA_FACIAL]);
    agregarCita($empleados, 0, 'Pedro Ruiz',    'lunes',    9, [S_MANICURE]);
    agregarCita($empleados, 0, 'Sofía Herrera', 'martes',  10, [S_ANTIEDAD]);
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

$catalogoServicios = crearCatalogoServicios();
$empleados = cargarDatosPrueba();

$totalCitas = 0;
$totalMultiservicio = 0;
foreach ($empleados as $empleado) {
    $totalCitas += count($empleado['citas']);
    foreach ($empleado['citas'] as $cita) {
        if (count($cita['servicios']) >= 2) $totalMultiservicio++;
    }
}

echo "Empleados cargados: " . count($empleados) . "\n";
echo "Citas totales: $totalCitas\n";
echo "Citas con 2 o más servicios: $totalMultiservicio\n";