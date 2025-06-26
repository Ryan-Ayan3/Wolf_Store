<?php
require_once('../conn/conn.php');
$intel = $_GET['i'] ?? '';

if ($intel !== '') {
    // Escapa a intel para evitar SQL Injection básico
    $intel = mysqli_real_escape_string($conn, $intel);

    $sql = mysqli_query($conn, "SELECT id, nome FROM pessoa WHERE ativo=1 and categoria=1 and (id LIKE '%$intel%' or nome LIKE '%$intel%') LIMIT 10");

    if ($sql) {
        while ($row = mysqli_fetch_assoc($sql)) {
            echo '<div class="busca-item">' . htmlspecialchars($row['id']) . ' - ' . htmlspecialchars($row['nome']) . '</div>';
        }
    }
}
?>