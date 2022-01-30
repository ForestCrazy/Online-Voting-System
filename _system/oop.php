<?php
function gotoPage($page)
{
?>
    <script>
        window.location.href = '?page=<?= $page ?>';
    </script>
<?php
}

function isAdmin($u_id)
{
    global $connect;
    $sql_account = 'SELECT role FROM account WHERE id = "' . $u_id . '"';
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

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}
