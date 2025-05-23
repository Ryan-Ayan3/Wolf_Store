<?php
    if (isset($_POST['sair'])) {
        session_unset();
        session_destroy();
        ?>
        <script>
            document.location.href="index.php";
        </script>
        <?php
    }
?>