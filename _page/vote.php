<?php
if (isset($_POST["election_id"])) { ?>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col col-sm-8">
            <hr>
            <h3>รายชื่อผู้สมัคร</h3>
            <form action="javascript:void(0)">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="grey lighten-2">
                            <th width="5%">หมายเลข.</th>
                            <th width="7%">IMG</th>
                            <th width="20%">ชื่อ</th>
                            <th width="50%">สโลแกน</th>
                            <th width="5%">
                                <center>เลือก</center>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1001</td>
                            <td><img src="assets/c_img/tonhom.jpg" width="100%"></td>
                            <td>ต้นหอม1</td>
                            <td>น่ารัก กัดเจ็บ</td>
                            <td align="center">
                                <input type="radio" name="candid_id" value="1001" required="">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p align="right">
                    <input type="hidden" name="event_id" value="15">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> บันทึก </button>
                </p>
            </form>
        </div>
    </div>
<?php } else { ?>
    <script langquage='javascript'>
        window.location = "?page=home";
    </script>
<?php } ?>