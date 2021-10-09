<?php
function gotoPage($page) {
    ?>
    <script>
        window.location.href = '<?= $page ?>';
    </script>
    <?php
}