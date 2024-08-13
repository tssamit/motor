<div class="col-md-12">

    <?php
    if (!empty($_SESSION['errormsg'])) {
        $errormsg = $_SESSION['errormsg'];
        $errorValue = $_SESSION['errorValue'];
        ?>

        <div class="alert alert-<?= $errorValue; ?> alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-message">
                <?= $errormsg; ?>
            </div>
        </div>


        <?php
        unset($_SESSION['errormsg']);
        unset($_SESSION['errorValue']);
    } else {
        unset($_SESSION['errormsg']);
        unset($_SESSION['errorValue']);
    }
    ?>
    <script>
        $(".alert").delay(6000).slideUp(200, function () {
            $(this).alert('close');
        });
    </script>
</div>
