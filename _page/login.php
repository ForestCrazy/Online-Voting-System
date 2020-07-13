<?php
if (isset($_SESSION["username"])) { ?>
    <script langquage='javascript'>
        window.location = "?page=home";
    </script>
<?php } else { ?>
    <div class="d-flex justify-content-center">
        <div class="col col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Login</h5>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                        <input type="hidden" name="submit_login">
                        <button type="submit" class="btn btn-success">Login</button>
                    </form>
                    <br>
                    <div class="card-text">
                        ยังไม่มีบัญชี? <a href="?page=register" class="card-link">คลิกเพื่อไปหน้าสมัครบัญชี</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST["submit_login"])) {
        $username = mysqli_real_escape_string($connect, $_POST["username"]);
        $password = mysqli_real_escape_string($connect, $_POST["password"]);
        $sql_checkuser = 'SELECT password FROM account WHERE username = "'. $username .'"';
        $res_checkuser = mysqli_query($connect, $sql_checkuser);
        $fetch_checkuser = mysqli_fetch_assoc($res_checkuser);
        $num_checkuser = mysqli_num_rows($res_checkuser);
        if ($num_checkuser > 0) {
            if ($fetch_checkuser["password"] == $password) {
                $msg = 'ล็อกอินสำเร็จ';
            } else {
                $msg = 'รหัสผ่านไม่ถูกต้อง';
            }
        } else {
            $msg = 'ไม่พบชื่อผู้ใช้นี้ในระบบ';
        }
        
    }
    ?>
<?php } ?>