<?php
function gotoPage($page)
{
?>
    <script>
        window.location.href = '<?= $page ?>';
    </script>
<?php
}

function isAdmin($u_id)
{
    global $connect;
    $sql_account = 'SELECT role FROM account WHERE u_id = "' . $u_id . '"';
    $res_account = mysqli_query($connect, $sql_account);
    if ($res_account) {
        if (mysqli_num_rows($res_account) == 1) {
            $fetch_account = mysqli_fetch_assoc($res_account);
            if ($fetch_account['role'] == 'admin') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}
