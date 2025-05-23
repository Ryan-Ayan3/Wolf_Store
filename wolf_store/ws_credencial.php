<?php
    session_start();

    if (!isset($_SESSION["conectado"])) {
        ?>
            <script>
               alert('Falha na autenticação, tente realizar o login novamente.');
		       document.location.href="index.php";
		    </script>
        <?php
        error_reporting(0);
    }
?>