<script>
    function ElectionList() {
        $.ajax({
                url: "./API/election_list.php",
                type: "GET",
                data: "keyword=<?php if (isset($_GET["keyword"])) { echo $_GET["keyword"]; } ?>"
            })
            .done(function(result) {
                var object = jQuery.parseJSON(result);
                if (object != '') {
                    $("#election_list").empty();
                    $.each(object, function(key, val) {
                        card = '<div class="col-lg-4"><div class="card">';
                        card = card + '<img class="card-img-top" src="' + val["img"] + '" alt="' + val["title"] + '">';
                        card = card + '<div class="card-body"><h5 class="card-title">' + val["title"] + '</h5><div class="card-text">' + val["description"] + '</div></div>';
                        if (val["html"] === "1") {
                            htmlform = '<form action="?page=result" method="post"><input type="hidden" name="election_id" value="' + val["election_id"] + '"><button type="submit" class="btn btn-success">คลิกเพื่อไปดูผลโหวต</button></form>';
                        } else if (val["html"] === "2") {
                            htmlform = '<form action="?page=result" method="post"><input type="hidden" name="election_id" value="' + val["election_id"] + '"><button type="submit" class="btn btn-danger">ในขณะนี้ระบบปิดแล้ว</button></form>';
                        } else if (val["html"] === "3") {
                            htmlform = '<form action="?page=detail" method="post"><input type="hidden" name="election_id" value="' + val["election_id"] + '"><button type="submit" class="btn btn-primary">คลิกเพื่อไปโหวต</button>';
                        } else {
                            htmlform = '<form action="?page=detail" method="post"><input type="hidden" name="election_id" value="' + val["election_id"] + '"><button type="submit" class="btn btn-warning">ระบบยังไม่เปิดในขณะนี้</button></form>';
                        }
                        card = card + htmlform;
                        card = card + '<div class="card-footer text-right"><small class="text-muted">' + val["format_date"] + val["cooldown"] + '</small></div>';
                        card = card + '<div class="card-footer text-right"><small class="text-muted">' + val["start_time"] + ' - ' + val["end_time"] + '</small></div>';
                        card = card + '</div></div>';
                        $("#election_list").append(card);
                    });
                }
            });
    }
    ElectionList()
    setInterval(ElectionList, 5000); // 1000 = 1 second
</script>
<div class="row" id="election_list"></div>