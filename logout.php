<?php
// Инициализация сессии
session_start();

// Уничтожение всех данных сессии
session_destroy();

// Перенаправление на страницу входа
header("Location: indexxx.php");
?>