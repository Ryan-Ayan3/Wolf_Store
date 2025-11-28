<?php
require_once('../conn/conn.php');
$intel = $_GET['i'] ?? '';
$idbh = $_GET['idbh'];

if ($intel !== '') {
    // Escapa a intel para evitar SQL Injection básico
    $intel = mysqli_real_escape_string($conn, $intel);

    //Procurar funcionários que não estão no BH que são ativos e não afastados
    $sql = mysqli_query($conn, "SELECT 
                                    f.id AS fid, f.matr AS fmatr, f.nome AS fnome
                                FROM funcionario f
                                JOIN departamento d ON f.fk_departamento = d.id
                                JOIN setor s ON f.fk_setor = s.id
                                JOIN funcao ff ON f.fk_funcao = ff.id
                                JOIN grupo g ON f.fk_grupo = g.id
                                LEFT JOIN banco_horas_func bhf ON f.matr = bhf.fk_matr
                                AND bhf.fk_banco_horas = $idbh
                                AND bhf.ativo = 1
                                LEFT JOIN banco_horas bh ON bhf.fk_banco_horas = bh.id 
                                AND bh.id = $idbh
                                WHERE 
                                    f.ativo = 1 AND
                                    f.afastado = 0 AND
                                    bh.id IS NULL AND
                                    (f.matr LIKE '%$intel%' OR f.nome LIKE '%$intel%')
                                GROUP BY f.matr
                                ORDER BY f.nome ASC
                                LIMIT 10") or die($conn);

    if ($sql) {
        while ($row = mysqli_fetch_assoc($sql)) {
            echo '<div class="busca-item" data-in2="'.htmlspecialchars($row['fid']).'">' . htmlspecialchars($row['fmatr']) . ' - ' . htmlspecialchars($row['fnome']) . '</div>';
        }
    }
}
?>