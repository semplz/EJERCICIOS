<?php
// EJERCICIO 03. Los datos llegan desde radioCheckbox.html por POST.
// TODO 1: comprueba el método de la petición y recoge los campos del formulario.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre       = trim((string) ($_POST['nombre'] ?? ''));
    $apellidos    = trim((string) ($_POST['apellidos'] ?? ''));
    $edad         = trim((string) ($_POST['edad'] ?? ''));
    $peso         = filter_var($_POST['peso'] ?? null, FILTER_VALIDATE_INT);
    $genero       = trim((string) ($_POST['genero'] ?? ''));
    $estadoCivil  =trim((string) ($_POST['estadoCivil'] ?? ''));
    $aficiones    = $_POST['aficiones'] ?? [];

    $edadValida = [
        "0-20",
        "21-39",
        "40-59",
        "60+",
    ];

    $genero = [
        "masculino",
        "femenino",
    ];

    $estadosCiviles = [
    "soltero",
    "casado",
    "otro",
    ];

    $aficiones = [
        "cine",
        "literatura",
        "tebeos",
        "deportes",
        "musica",
        "television",
    ];
    
}
// TODO 2: valida los datos obligatorios y que las opciones recibidas estén permitidas.
// TODO 3: muestra nombre y apellidos en un <h1> y el resto de campos en párrafos.
// TODO 4: recorre las aficiones y muéstralas en una lista <ul>.
// TODO 5: contempla el caso de no haber seleccionado ninguna afición.
// Nota: al imprimir texto enviado por el usuario, escápalo para HTML.

echo 'Pendiente de implementar el ejercicio 03.';
