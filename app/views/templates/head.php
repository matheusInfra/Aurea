<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Auréa Restaurante — Experiência gastronômica exclusiva e refinada. Funcionamento exclusivo por reservas.">
    <meta name="author" content="Auréa Restaurante">
    <link rel="shortcut icon" href="assets/img/logo-letra.png" type="image/x-icon">
    
    <title><?php echo isset($dados['titulo']) ? htmlspecialchars($dados['titulo']) . ' | Auréa Restaurante' : 'Auréa — Alta Gastronomia'; ?></title>

    <!-- Google Fonts: Cormorant Garamond, Great Vibes, Lato -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Great+Vibes&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons 1.11.3 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Reset CSS -->
    <link rel="stylesheet" href="<?php echo URL_BASE; ?>assets/css/reset.css">

    <!-- Estilo Principal Auréa -->
    <link rel="stylesheet" href="<?php echo URL_BASE; ?>assets/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">