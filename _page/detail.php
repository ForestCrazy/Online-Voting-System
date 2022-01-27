<?php
if (!isset($_SESSION["u_id"])) {
    gotoPage('home');
} else {
    if (isset($_GET["election_id"])) {
        $e_id = mysqli_real_escape_string($connect, $_GET["election_id"]);
        $sql_election_info = 'SELECT * FROM election WHERE election_id = "' . $e_id . '"';
        $res_election_info = mysqli_query($connect, $sql_election_info);
        $fetch_election_info = mysqli_fetch_assoc($res_election_info);
    ?>
        <script>
            // $.ajax({
            //             url: "./API/election_detail.php",
            //             type: "GET",
            //             data: "keyword=<?php echo $fetch_election_info['election_id']; ?>"
            //         })
            //         .done(function(result) {
            //             var object = jQuery.parseJSON(result);
            //             if (object != '') {
            //                 $("#election_status").empty();
            //                 $("#vote_button").empty();
            //                 $.each(object, function(key, val) {
            //                     if (val["html"] === "3") {
            //                         status = 'สถานะ : <button type="submit" disabled class="btn btn-success">open</button>';
            //                         form = '<form action="?page=vote" method="post"><input type="hidden" name="election_id" value="' + <?php echo $fetch_election_info['election_id']; ?> + '"><button type="submit" class="btn btn-primary">เข้าไปโหวตคะแนน</button>';
            //                     } else {
            //                         status = 'สถานะ : <button type="submit" disabled class="btn btn-danger">close</button></form>';
            //                         form = '<a href="javascript:void(0)" class="btn btn-primary waves-effect waves-light disabled">เข้าไปโหวตคะแนน</a>';
            //                     }
            //                     $("#election_status").append(status);
            //                     $("#vote_button").append(form);
            //                 });
            //             }
            //         });
            var electionDetail = null;
            const urlParams = new URLSearchParams(window.location.search);
            const electionId = urlParams.get('election_id');

            function candidateComponent(candidate) {
                $('#candidate_list').append('<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4"><div class="card testimonial-card"><div class="card-up teal lighten-2"></div><div class="avatar mx-auto white"><img src="' + candidate.img + '" class="rounded-circle img-fluid" width="60%" style="margin-top: 10px;"></div><div class="card-body"><h4 class="card-title mt-1">' + candidate.FirstName + ' ' + candidate.LastName + '</h4><hr><div>หมายเลข : <div class="text-primary d-inline">' + candidate.cdd_id + '</div></div><i class="fas fa-quote-left"></i> ' + candidate.slogan + ' <i class="fas fa-quote-right"></i></div></div></div>');
            }

            function ElectionInfo() {
                $.get({
                    url: '/API/election.php',
                    data: {
                        election_id: electionId
                    }
                }).done((response) => {
                    try {
                        electionDetail = JSON.parse(response);
                    } catch (e) {
                        console.log(e);
                        return;
                    }
                    $('#election_title').text(electionDetail.title);
                    $('#election_detail').text(electionDetail.detail);
                    $('#election_time1').text(DateThai(electionDetail.start_time) + ' น.');
                    $('#election_time2').text(DateThai(electionDetail.end_time) + ' น.');
                    if (electionDetail.election_state === 2) {
                        $('#election_status').html('สถานะ : <button type="submit" disabled class="btn btn-success">open</button>');
                        $('#vote_button').removeClass('d-none');
                    } else {
                        $('#election_status').html('สถานะ : <button type="submit" disabled class="btn btn-danger">close</button></form>');
                    }
                    $('#candidate_list').empty();
                    electionDetail.candidate.forEach((candidate) => {
                        candidateComponent(candidate);
                    })
                })
            }

            $(document).ready(() => {
                ElectionInfo()
                setInterval(ElectionInfo, 1000 * 60);
            })
        </script>
        <div class="container">
            <div class="row">
                <div class="col">
                    <br>
                    <h3 id="election_title"></h3>
                    <p>รายละเอียดการโหวต :
                    <div class="d-inline" id="election_detail"></div>
                    </p>
                    <b class="">เปิดระบบ <div class="d-inline text-primary" id="election_time1"></div> ถึง <div class="d-inline text-primary" id="election_time2"></div></b>
                    <br>
                    <div id="election_status"></div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <section class="section pb-3 text-center">
                        <h2 class="section-heading h1 pt-4">รายชื่อผู้สมัคร</h2>
                        <p class="section-description">แนะนำข้อมูลผู้สมัครโหวต/เลือกตั้ง</p>
                        <div class="row" id="candidate_list"></div>
                        <div class="d-flex justify-content-center d-none" id="vote_button"><button class="btn btn-primary" onclick="windows.location = '?page=election&election_id=00001'">ไปลงคะแนน</button></div>
                    </section>
                </div>
            </div>
        </div>
    <?php } else {
        gotoPage('home');
    }
} ?>