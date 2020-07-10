<?php
if (!isset($_SESSION["username"])) {
    if (isset($_POST["election_id"])) { ?>
        <script type="text/javascript">
            function alertbox(msg_alert) {
                Swal.fire(
                    'สำเร็จ!',
                    msg_alert,
                    'success'
                ).then((value) => {
                    window.location.href = "?page=home";
                });
            }
            $(function() {
                $("#submit_select_candidate").click(function() {
                    var selectcandidatebox = $(".selectcandidatebox:checked").val();
                    var election_id = $('input[name="election_id"]').val();
                    $.ajax({
                        url: "API/vote_candidate.php",
                        type: "GET",
                        data: "candidate_id=" + selectcandidatebox + "&election_id=" + election_id,
                        dataType: "text", 
                        success: function(data){
                            alertbox(data)
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
                                $election_id = $_POST["election_id"];
                                $sql_candidatelist = 'SELECT * FROM candidatelist WHERE election_id = "' . $election_id . '"';
                                $res_candidatelist = mysqli_query($connect, $sql_candidatelist);
                                while ($fetchcandidatelist = mysqli_fetch_assoc($res_candidatelist)) {
                                ?>
                                    <tr>
                                        <td><?php echo $fetchcandidatelist["cdd_id"]; ?></td>
                                        <td><img src="<?php echo $fetchcandidatelist["img"]; ?>" width="100%"></td>
                                        <td><?php echo $fetchcandidatelist["FirstName"] . ' ' . $fetchcandidatelist["LastName"]; ?></td>
                                        <td><?php echo $fetchcandidatelist["slogan"]; ?></td>
                                        <td align="center">
                                            <input type="radio" class="selectcandidatebox" name="candidate_id" value="<?php echo $fetchcandidatelist["cdd_id"]; ?>" required>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <input type="hidden" name="election_id" name="election_id" value="<?php echo $_POST["election_id"]; ?>">
                        <p align="right">
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
} else {
    include("login.php");
}?>