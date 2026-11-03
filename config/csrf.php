<?php
/**
 * Helper de Segurança e Proteção CSRF — Auréa
 */

if (!function_exists('gerarTokenCSRF')) {
    function gerarTokenCSRF() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('validarTokenCSRF')) {
    function validarTokenCSRF($token) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}

if (!function_exists('campoCSRF')) {
    function campoCSRF() {
        $token = gerarTokenCSRF();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}

if (!function_exists('requireLogin')) {
    function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['id_cliente'])) {
            header('Location: ' . URL_BASE . 'home?login=1');
            exit;
        }
    }
}
