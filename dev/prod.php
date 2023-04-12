<?php
    $url = isset($_GET['q']) ? base64_decode ($_GET['q']) : '/';
    header("Location: {$url}");
    die();