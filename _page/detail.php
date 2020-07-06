<?php
if (isset($_POST["election_id"])) { 
    $e_id = mysqli_real_escape_string($connect, $_POST["election_id"]);
    $sql_election_info = 'SELECT * FROM election WHERE election_id = "'. $e_id .'"';
    $res_election_info = mysqli_query($connect, $sql_election_info);
    $fetch_election_info = mysqli_fetch_assoc($res_election_info);
    ?>
    <script>
        function ElectionInfo() {
            $.ajax({
                    url: "./API/election_status.php",
                    type: "GET",
                    data: "keyword=<?php echo $fetch_election_info['election_id']; ?>"
                })
                .done(function(result) {
                    var object = jQuery.parseJSON(result);
                    if (object != '') {
                        $("#election_status").empty();
                        $("#vote_button").empty();
                        $.each(object, function(key, val) {
                            if (val["html"] === "3") {
                                status = 'สถานะ : <button type="submit" disabled class="btn btn-success">open</button>';
                                form = '<form action="?page=vote" method="post"><input type="hidden" name="election_id" value="' + val["election_id"] + '"><button type="submit" class="btn btn-primary">เข้าไปโหวตคะแนน</button>';
                            } else {
                                status = 'สถานะ : <button type="submit" disabled class="btn btn-danger">close</button></form>';
                                form = '<a href="login.php" class="btn btn-primary waves-effect waves-light disabled">เข้าไปโหวตคะแนน</a>';
                            }
                            $("#election_status").append(status);
                            $("#vote_button").append(form);
                        });
                    }
                });
        }
        ElectionInfo()
        setInterval(ElectionInfo, 5000); // 1000 = 1 second
    </script>
    <div class="container">
        <div class="row">
            <div class="col">
                <br>
                <h3><?php echo $fetch_election_info["title"]; ?></h3>
                <p>รายละเอียดการโหวต : <?php echo $fetch_election_info["detail"]; ?></p>
                <b style="color:blue;">เปิดระบบ <?php echo $fetch_election_info["start_time"]; ?> น. ถึง <?php echo $fetch_election_info["end_time"]; ?> น.</b>
                <br>
                <div id="election_status"></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <!--Section: Testimonials v.1-->
                <section class="section pb-3 text-center">
                    <!--Section heading-->
                    <h2 class="section-heading h1 pt-4">รายชื่อผู้สมัคร</h2>
                    <!--Section description-->
                    <p class="section-description">แนะนำข้อมูลผู้สมัครโหวต/เลือกตั้ง</p>
                    <div class="row">
                        <?php
                        $sql_candidatelist = 'SELECT * FROM candidatelist WHERE election_id = "'.$fetch_election_info["election_id"].'"';
                        $res_candidatelist = mysqli_query($connect, $sql_candidatelist);
                        while ($fetch_candidatelist = mysqli_fetch_assoc($res_candidatelist)) {
                        ?>
                        <!--Grid column-->
                        <div class="col col-sm-3 col-lg-3 col-md-3 mb-4">
                            <!--Card-->
                            <div class="card testimonial-card">
                                <!--Background color-->
                                <div class="card-up teal lighten-2">
                                </div>
                                <!--Avatar-->
                                <div class="avatar mx-auto white">
                                    <a c_id="29" class="showview">
                                        <img src="<?php echo $fetch_candidatelist['img']; ?>" class="rounded-circle img-fluid" width="60%" style="margin-top: 10px;">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <!--Name-->
                                    <h4 class="card-title mt-1">
                                        <a c_id="29" class="showview"><?php echo $fetch_candidatelist["FirstName"] . ' ' . $fetch_candidatelist["LastName"]; ?></a>
                                    </h4>
                                    <hr>
                                    <!--Quotation-->
                                    <p>
                                        หมายเลข : <font color="blue"><?php echo $fetch_candidatelist["cdd_id"]; ?></font><br>
                                        <i class="fas fa-quote-left"></i> <?php echo $fetch_candidatelist["slogan"]; ?> <i class="fas fa-quote-right"></i></p>
                                </div>
                            </div>
                            <!--Card-->
                        </div>
                        <!--Grid column-->
                        <?php } ?>
                    </div>
                    <div class="d-flex justify-content-center" id="vote_button"></div>
                </section>
                <!--Section: Testimonials v.1-->
            </div>
        </div>
    </div>
<?php } else { ?>
    <script langquage='javascript'>
        window.location = "?page=home";
    </script>
<?php } ?>