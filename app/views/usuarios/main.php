<?php include __DIR__ . '/header.php'; ?>

<div class="container-fluid">
    <?php
        if (isset($viewFile)) {
            include $viewFile;
        } else {
            echo "<div class='alert alert-warning'>No se ha encontrado el archivo de vista.</div>";
        }
    ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>