<?php
if (!isset($_SESSION["username"])) { ?>
    <script langquage='javascript'>
        window.location = "?page=login";
    </script>
    <?php } else {
    if (isset($_POST["election_id"])) { ?>
        <script type="text/javascript">
            $(function() {
                $("#submit_select_candidate").click(function() {
                    var selectcandidatebox = $(".selectcandidatebox:checked").val();
                    var election_id = $('input[name="election_id"]').val();
                    $.ajax({
                        url: "API/vote_candidate.php",
                        type: "GET",
                        data: "candidate_id=" + selectcandidatebox + "&election_id=" + election_id,
                        dataType: "text",
                        success: function(result) {
                            var object = jQuery.parseJSON(result);
                            if (object != '') {
                                $.each(object, function(key, alertlabel) {
                                    alertbox(alertlabel["msg_title"], alertlabel["msg_alert"], alertlabel["icon"], alertlabel["href"]);
                                });
                            }
                        }
                    });
                });
            });
            $(function() {
                $("#notwishtovote").click(function() {
                    var election_id = $('input[name="election_id"]').val();
                    $.ajax({
                        url: "API/vote_candidate.php",
                        type: "GET",
                        data: "candidate_id=0" + "&election_id=" + election_id,
                        dataType: "text",
                        success: function(data) {
                            var object = jQuery.parseJSON(data);
                            if (object != '') {
                                $.each(object, function(key, alertlabel) {
                                    alertbox(alertlabel["msg_title"], alertlabel["msg_alert"], alertlabel["icon"], alertlabel["href"]);
                                });
                            }
                        }
                    });
                });
            });
        </script>
        <div class="d-flex justify-content-center">
            <div class="row">
                <div class="col col-sm-12">
                    <hr>
                    <h3>รายชื่อผู้สมัคร</h3>
                    <form action="javascript:void(0)" name="selectcandidate">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="grey lighten-2">
                                    <th width="5%">หมายเลข.</th>
                                    <th width="12%">IMG</th>
                                    <th width="20%">ชื่อ</th>
                                    <th width="50%">สโลแกน</th>
                                    <th width="5%">
                                        <center>เลือก</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $election_id = mysqli_real_escape_string($connect, $_POST["election_id"]);
                                $sql_candidate = 'SELECT * FROM candidate WHERE election_id = "' . $election_id . '"';
                                $res_candidate = mysqli_query($connect, $sql_candidate);
                                while ($fetchcandidate = mysqli_fetch_assoc($res_candidate)) {
                                ?>
                                    <tr>
                                        <td><?php echo $fetchcandidate["cdd_id"]; ?></td>
                                        <td><img src="<?php echo $fetchcandidate["img"]; ?>" width="100%"></td>
                                        <td><?php echo $fetchcandidate["FirstName"] . ' ' . $fetchcandidate["LastName"]; ?></td>
                                        <td><?php echo $fetchcandidate["slogan"]; ?></td>
                                        <td align="center">
                                            <input type="radio" class="selectcandidatebox" name="candidate_id" value="<?php echo $fetchcandidate["cdd_id"]; ?>" required>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <input type="hidden" name="election_id" name="election_id" value="<?php echo $_POST["election_id"]; ?>">
                        <p align="right">
                            <button class="btn btn-danger waves-effect waves-light" id="notwishtovote"> ไม่ประสงค์ลงคะแนน </button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light" id="submit_select_candidate"> บันทึก </button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <script langquage='javascript'>
            window.location = "?page=home";
        </script>
<?php }
} ?>