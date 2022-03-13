<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Fashion</title>
    <meta name="description" content="Fashion - интернет-магазин">
    <meta name="keywords" content="Fashion, интернет-магазин, одежда, аксессуары">
    <meta name="theme-color" content="#393939">

    <link rel="prefetch" href="../../public/img/intro/coats-2018.jpg" type="image/png">
    <link rel="prefetch" href="../../public/fonts/opensans-400-normal.woff2" as="font">
    <link rel="prefetch" href="../../public/fonts/roboto-400-normal.woff2" as="font">
    <link rel="prefetch" href="../../public/fonts/roboto-700-normal.woff2" as="font">

    <link rel="icon" href="../../public/img/favicon.png" type="image/png">

    <!--CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/style.min.css">

</head>
<?php require_once 'templates/header.php'; ?>

<?php if (isset($view)) {
    require_once $view;
} ?>

<?php require_once 'templates/footer.php'; ?>

