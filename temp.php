<?php
if(!empty($_GET['page']) && $_GET['page']=='phongban'){
    echo "<script>$('.nhaplieu>a').addClass('selectMenu');$('#phongban').addClass('selectMenu')</script>";
}

if (!empty($_POST['submit'])) {
//  tạo mảng lỗi nếu không nhập vào
    $error = [ "TenPhongBan" => "Vui Lòng Nhập: Tên Phòng Ban",
    ];
//-----------------------  Kiểm Tra Dữ Liệu Nhập Từ Form Bằng PHP
    $_SESSION['error'] = $FCT->KiemTraDuLieu($_POST,$error);
    if (!empty($_SESSION['error'])) {
        echo '<script>window.location="index.php?page=phongban"</script>';
        //header("Location:index.php?page=vanban");
        exit;
    }
//-----------------------  Lấy Giá Trị Khi Nhập Form
    if (empty($_GET['id'])) {//nếu không có id thì mới nhập dữ liệu
        $array = [
            'TenPhongBan' => addslashes($_POST['TenPhongBan']),
        ];
        //nhập dữ liệu vào data
        $FCT->NhapData('phongban', $array);
    }
}
//-----------------------  Giữ Lại Giá Trị Ban Đầu Khi Muốn Sửa Dữ Liệu
$row['TenPhongBan'] = "";
if (!empty($_GET['id'])) {
    $result = Query("SELECT top 1 * FROM phongban WHERE id='" . $_GET['id'] . "'");
    $row = $result[0];
}
//-----------------------  Xét Quyền
$quyen = "";
if(!empty($_SESSION['inf_user']['PhanQuyen'])){// nếu user có quyền sẽ được vào trang này và cụ thể quyền gì
    $quyen = $FCT->PhanQuyen($_SESSION['inf_user']['PhanQuyen']);
} elseif (!empty($_SESSION['inf_user']['QuyenHeThong'])){
    $quyenhethong = $_SESSION['inf_user']['QuyenHeThong'];
} else {// nếu user không có quyền sẽ không được vào trang này
    echo '<script>alert("Bạn Không Có Quyền Truy Cập")</script>';
    echo '<script>window.location="index.php?page=home"</script>';
    exit;
}
?>

<div class="box_giaodiennhaplieu">
    <div class="giaodiennhaplieu">
        <p>Nhập Phòng Ban:</p>
        <p>
            <?
            if (!empty($_SESSION['error'])) {
                echo implode("<br>", $_SESSION['error']);
            };
            $_SESSION['error'] = null; ///hủy session
            ?>
        </p>

        <form name="phongban" method="post" action="">
            <p>Tên Phòng Ban:<span style="color: #f00"> *</span></p>
            <input type="text" required name="TenPhongBan" id="TenPhongBan" value="<?= $row['TenPhongBan'] ?>"/><br><br>

            <p></p>
            <input onclick="return check_oder()" type="submit" name="submit" id="submit" value="Thực Hiện">
        </form>
        <p></p>
    </div>
    <div class="danhsachdata">
        <p>Danh Sách Dữ Liệu:</p>
        <?php
        $FCT->ChinhSua('phongban', 'Tên Phòng Ban', 'TenPhongBan','','','','','','',$quyen,$quyenhethong);//ham thêm, sửa, xóa dữ liệu
        ?>
        <p></p>
    </div>
    <div class="clear"></div>
</div>

<!--kiểm tra dữ liệu nhập từ form bằng javascript-->
<script>
    function check_oder() {
        if (document.phongban.TenPhongBan.value == "") {
            alert('Vui Lòng Nhập: Tên Phòng Ban');
            document.phongban.TenPhongBan.focus();
            return false;
        }
        return true;
    }
</script>






