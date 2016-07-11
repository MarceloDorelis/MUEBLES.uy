<?php
// Inicializar la sesión.
session_start();

// Destruir todas las variables de sesión.
$_SESSION = array();

// Finalmente, destruir la sesión.
session_destroy();

//DESTRUIMOS LAS COOKIES DE PROVEEDOR
if (isset($_COOKIE['id_proveedor'])) {
    unset($_COOKIE['id_proveedor']);
    setcookie('id_proveedor', '', time() - 360000, "/", ".muebles.uy", false, true);
}

if (isset($_COOKIE['nombre_proveedor'])) {
    unset($_COOKIE['nombre_proveedor']);
    setcookie('nombre_proveedor', '', time() - 360000, "/", ".muebles.uy", false, true);
}

if (isset($_COOKIE['tipo'])) {
    unset($_COOKIE['tipo']);
    setcookie('tipo', '', time() - 360000, "/", ".muebles.uy", false, true);
}

if (isset($_COOKIE['mail_proveedor'])) {
    unset($_COOKIE['mail_proveedor']);
    setcookie('mail_proveedor', '', time() - 360000, "/", ".muebles.uy", false, true);
}

if (isset($_COOKIE['tel_proveedor'])) {
    unset($_COOKIE['tel_proveedor']);
    setcookie('tel_proveedor', '', time() - 360000, "/", ".muebles.uy", false, true);
}

if (isset($_COOKIE['zona_proveedor'])) {
    unset($_COOKIE['zona_proveedor']);
    setcookie('zona_proveedor', '', time() - 360000, "/", ".muebles.uy", false, true);
}

if (isset($_COOKIE['tipo_cuenta'])) {
    unset($_COOKIE['tipo_cuenta']);
    setcookie('tipo_cuenta', '', time() - 360000, "/", ".muebles.uy", false, true);
}

if (isset($_COOKIE['menuestandar'])) {
    unset($_COOKIE['menuestandar']);
    setcookie('menuestandar', '', time() - 360000, "/", ".muebles.uy", false, true);
}

if (isset($_COOKIE['menuamedida'])) {
    unset($_COOKIE['menuamedida']);
    setcookie('menuamedida', '', time() - 360000, "/", ".muebles.uy", false, true);
}

//DESTRUIMOS LAS COOKIES DE CLIENTE
if (isset($_COOKIE['id_clientes'])) {
    unset($_COOKIE['id_clientes']);
    setcookie('id_clientes', '', time() - 360000, "/", ".muebles.uy", false, true);
}

if (isset($_COOKIE['nombre_clientes'])) {
    unset($_COOKIE['nombre_clientes']);
    setcookie('nombre_clientes', '', time() - 360000, "/", ".muebles.uy", false, true);
}

if (isset($_COOKIE['mail_clientes'])) {
    unset($_COOKIE['mail_clientes']);
    setcookie('mail_clientes', '', time() - 360000, "/", ".muebles.uy", false, true);
}

if (isset($_COOKIE['tel_clientes'])) {
    unset($_COOKIE['tel_clientes']);
    setcookie('tel_clientes', '', time() - 360000, "/", ".muebles.uy", false, true);
}

if (isset($_COOKIE['zona_clientes'])) {
    unset($_COOKIE['zona_clientes']);
    setcookie('zona_clientes', '', time() - 360000, "/", ".muebles.uy", false, true);
}

if (isset($_COOKIE['menuamedida'])) {
    unset($_COOKIE['menuamedida']);
    setcookie('menuamedida', '', time() - 360000, "/", ".muebles.uy", false, true);
}

if (isset($_COOKIE['menuestandar'])) {
    unset($_COOKIE['menuestandar']);
    setcookie('menuestandar', '', time() - 360000, "/", ".muebles.uy", false, true);
}

//DESTRUIMOS COOKIES DE ADMIN
if (isset($_COOKIE['id_admin'])) {
    unset($_COOKIE['id_admin']);
    setcookie('id_admin', '', time() - 360000, "/", ".muebles.uy", false, true);
}
if (isset($_COOKIE['nombre'])) {
    unset($_COOKIE['nombre']);
    setcookie('nombre', '', time() - 360000, "/", ".muebles.uy", false, true);
}
if (isset($_COOKIE['mail'])) {
    unset($_COOKIE['mail']);
    setcookie('mail', '', time() - 360000, "/", ".muebles.uy", false, true);
}

if (isset($_COOKIE['tel'])) {
    unset($_COOKIE['tel']);
    setcookie('tel', '', time() - 360000, "/", ".muebles.uy", false, true);
}

header("Location: index.php");
