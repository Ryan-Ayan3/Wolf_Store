<?php
require_once('../conn/conn.php');
$termo = $_GET['q'] ?? '';

if ($termo !== '') {
    // Escapa o termo para evitar SQL Injection básico
    $termo = mysqli_real_escape_string($conn, $termo);

    $sql = "SELECT id, nome FROM pessoa WHERE ativo=1 and categoria=1 and (id LIKE '%$termo%' or nome LIKE '%$termo%') LIMIT 10";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="item">' . htmlspecialchars($row['id']) . ' - ' . htmlspecialchars($row['nome']) . '</div>';
        }
    }
}
?>