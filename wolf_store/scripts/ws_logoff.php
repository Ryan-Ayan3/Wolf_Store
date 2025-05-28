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
    /* 
        Botão para logoff:
        <form method="POST"><input type="submit" class="sair" name="sair" value="Sair"></form>
    */
?>