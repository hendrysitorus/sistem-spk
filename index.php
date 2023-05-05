<?php
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; // cek jika user sudah login
$kary_id = isset($_GET['kary_id']) ? $_GET['kary_id'] : '';
include "fungsi.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>VictoryStars</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript">
		function hitung_gaji() {
			var jam_lembur = document.transfer.jam_lembur.value;
			var uang_lembur = document.transfer.uang_lembur.value;
			var gaji_utama = document.transfer.gaji_utama.value;
			uang_lembur = ( gaji_utama / 173 ) * jam_lembur;
			document.transfer.uang_lembur.value = Math.floor( uang_lembur );
		}

		// function hitung_bonus() {
		// 	var uang_bonus = document.transfer.uang_bonus.value;
		// 	var total_uang_bonus = document.transfer.total_uang_bonus.value;
		// 	var gol_kar = document.transfer.gol_kar.value;
		// 	total_uang_bonus = (uang_bonus * gol_kar) - ((uang_bonus * gol_kar) * ( 10 / 100 )) ;
		// 	document.transfer.total_uang_bonus.value = Math.floor( total_uang_bonus );
		// }

		function tanya(id) {
			var aa = confirm( 'Yakin akan menghapus data dengan ID - ' + id + '?' );
			if( aa == true ) return true;
			else return false;
		}
	</script>
</head>
<body>

	<?php
// jika user sudah login
if ($user_id) {
    // ambil data user dari database
    $userdata = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tb_user WHERE user_id='{$user_id}'"));
    // Header Sintax Start
    echo "<div class=\"wrap\">\n";
    echo "	<div class=\"header\">\n";
    echo "		<div class=\"h-left\">\n";
    echo "			<div class=\"u-logo\">\n";
    echo "				<img src=\"" . URL . "/images/logo.jpg\" alt=\"Logo\">\n";
    echo "				<div class=\"u-title\"><b>VictoryStars</b></p></div>\n";
    echo "			</div>\n";
    echo "		</div>\n";
    echo "		<div class=\"h-right\">\n";
    echo "			<div class=\"u-info\">\n";
    echo "                <div class=\"u-foto\"><img src=\"" . URL . "/images/pic-menu.jpg\" alt=\"Foto\"></div>\n";
    echo "				<div class=\"u-text\">\n";
    echo "					<div class=\"u-name\">" . hello_title . "<b>{$userdata['fullname']}</b></div>\n";
    echo "					<div class=\"u-link\"><a href=\"" . URL . "/index.php?page=logout\">" . logout_title . "</a></div>\n";
    echo "				</div>\n";
    echo "				<div class=\"clear\"></div>\n";
    echo "			</div>\n";
    echo "		</div>\n";
    echo "		<div class=\"clear\"></div>\n";
    echo "	</div>\n";
    // Header Sintax End
    // Page Menu Sintax Start
    echo "	<div class=\"page\">\n";
    echo "		<div class=\"p-left\">\n";
    echo "			<div class=\"box\">\n";
    echo "				<div class=\"box-menu\">\n";
    echo "					<h1><div class=\"menus\"><b>" . menu_title . "</b></div></h1>\n";
    echo "					<ul class=\"nav\">\n";
    echo "						<li><a href=\"index.php\">" . home_title . "</a></li>\n";
    echo "						<li><a href=\"index.php?page=tambah-karyawan\">" . add_kary_title . "</a></li>\n";
    echo "						<li><a href=\"index.php?page=tinjau-karyawan\">" . view_kary_title . "</a></li>\n";
    echo "						<li><a href=\"index.php?page=data-gajian\">" . history_kary_title . "</a></li>\n";
    echo "						<li><a href=\"index.php?page=cari-karyawan\">" . search_kary_title . "</a></li>\n";
    echo "					</ul>\n";
    echo "				</div>\n";
    echo "			</div>\n";
    echo "		</div>\n";
    // Page Menu Sintax End
    echo "		<div class=\"p-right\">\n";
    if ($page == 'tinjau-karyawan') {
        // Page Tinjau Sintax start
        echo "		<div class=\"box\">\n";
        echo "			<h1>" . view_title . "</h1>\n";
        echo "			<p>" . view_sub_title . "</p>\n";
        echo "			<table border=\"0\">\n";
        echo "			<tr class=\"head\">\n";
        echo "				<td width=\"30\" align=\"center\">" . tab_no_title . "</td>\n";
        echo "				<td width=\"150\">" . tab_name_title . "</td>\n";
        echo "				<td width=\"180\">" . tab_alamat_title . "</td>\n";
        echo "				<td width=\"90\">" . tab_gaji_title . "</td>\n";
        echo "				<td width=\"30\" align=\"center\">" . tab_gol_title . "</td>\n";
        echo "				<td width=\"80\" align=\"center\">" . tab_aksi_title . "</td>\n";
        echo "			</tr>\n";
        $sql_karyawan = mysqli_query($koneksi, "SELECT * FROM tb_karyawan");
        if (mysqli_num_rows($sql_karyawan) == 0) {
            echo "		<tr class=\"no-data\"><td colspan=\"6\">Maaf, belum ada data karyawan saat ini</td></tr>\n";
        } else {
            $no = 1;
            while ($row_karyawan = mysqli_fetch_array($sql_karyawan)) {
                echo "	<tr class=\"data\">\n";
                echo "		<td align=\"center\">{$no}</td>\n";
                echo "		<td><a href=\"" . URL . "/index.php?page=transfer-gaji&kary_id={$row_karyawan['kary_id']}\" title=\"Transfer Gaji &rarr; {$row_karyawan['nama_kar']}\">{$row_karyawan['nama_kar']}</a></td>\n";
                echo "		<td>{$row_karyawan['alamat_kar']}</td>\n";
                echo "		<td>Rp. " . Rupiah($row_karyawan['gaji_utama']) . "</td>\n";
                echo "		<td align=\"center\">{$row_karyawan['gol_kar']}</td>\n";
                echo "		<td align=\"center\">\n";
                echo "			<a href=\"" . URL . "/index.php?page=transfer-gaji&kary_id={$row_karyawan['kary_id']}\" title=\"Transfer Gaji &rarr; {$row_karyawan['nama_kar']}\"><img src=\"" . URL . "/images/s_okay.png\"></a> &nbsp;\n";
                echo "			<a href=\"" . URL . "/index.php?page=edit-karyawan&kary_id={$row_karyawan['kary_id']}\" title=\"Ubah Karyawan &rarr; {$row_karyawan['nama_kar']}\"><img src=\"" . URL . "/images/b_edit.png\"></a> &nbsp;\n";
                echo "			<a href=\"" . URL . "/index.php?page=delete-karyawan&kary_id={$row_karyawan['kary_id']}\" title=\"Hapus Karyawan &rarr; {$row_karyawan['nama_kar']}\" onclick=\"return tanya('" . $row_karyawan['kary_id'] . "')\"><img src=\"" . URL . "/images/b_drop.png\"></a></td>\n";
                echo "	</tr>\n";
                $no++;
            }
        }
        echo "			</table>\n";
        echo "		</div>\n";
        // Page Tinjau Sintax End
    } elseif ($page == 'tambah-karyawan') {
        // page Add_kary start
        echo "		<div class=\"box\">\n";
        echo "			<h1>" . add_title . "</h1>\n";
        if (isset($_SESSION['tambah-kar']['gagal'])) {
            echo "		<div class=\"salah\">" . $_SESSION['tambah-kar']['gagal'] . "</div>\n";
            unset($_SESSION['tambah-kar']['gagal']);
        }
        echo "			<form method=\"post\" action=\"\" autocomplete=\"off\" class=\"form\">\n";
        echo "				" . kode_title . ":<br><input type=\"text\" name=\"kode_kar\" value=\"" . AturKode("tb_karyawan", "kode_kar", "KR") . "\" disabled=\"disabled\"><br>\n";
        echo "				" . name_title . ":<br><input type=\"text\" name=\"nama_kar\" placeholder=\"" . name_placeholder . "\" id=\"nama_kar\" autofocus><br>\n";
        echo "				" . alamat_title . ":<br><input type=\"text\" name=\"alamat_kar\" placeholder=\"" . alamat_placeholder . "\" id=\"alamat_kar\"><br>\n";
        echo "				" . norek_title . ":<br><input type=\"text\" name=\"no_rek\" placeholder=\"" . norek_placeholder . "\" id=\"no_rek\"><br>\n";
        echo "				" . gaji_title . ":<br><input type=\"text\" name=\"gaji_utama\" placeholder=\"" . gaji_placeholder . "\" id=\"gaji_utama\"><br>\n";
        echo "				" . gol_title . ":<br><input type=\"text\" name=\"gol_kar\" placeholder=\"" . gol_placeholder . "\" id=\"gol_kar\"><br>\n";
        echo "				<input type=\"submit\" name=\"act\" value=\"" . add_btn_title . "\">\n";
        echo "			</form>\n";
        echo "		</div>\n";
        // page Add_kary end
    } elseif ($page == 'edit-karyawan') {
        // page edit_kary sintax Start
        $editkar = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tb_karyawan WHERE kary_id='{$kary_id}'"));
        echo "		<div class=\"box\">\n";
        echo "			<h1>" . edit_title . "</h1>\n";
        if (isset($_SESSION['edit-kar']['gagal'])) {
            echo "		<div class=\"salah\">" . $_SESSION['edit-kar']['gagal'] . "</div>\n";
            unset($_SESSION['edit-kar']['gagal']);
        }
        echo "			<form method=\"post\" action=\"\" autocomplete=\"off\" class=\"form\">\n";
        echo "				" . kode_title . ":<br><input type=\"text\" name=\"kode_kar\" value=\"{$editkar['kode_kar']}\" disabled=\"disabled\"><br>\n";
        echo "				" . name_title . ":<br><input type=\"text\" name=\"nama_kar\" value=\"{$editkar['nama_kar']}\" placeholder=\"" . name_placeholder . "\" id=\"nama_kar\" autofocus><br>\n";
        echo "				" . alamat_title . ":<br><input type=\"text\" name=\"alamat_kar\" value=\"{$editkar['alamat_kar']}\" placeholder=\"" . alamat_placeholder . "\" id=\"alamat_kar\"><br>\n";
        echo "				" . norek_title . ":<br><input type=\"text\" name=\"no_rek\" value=\"{$editkar['no_rek']}\" placeholder=\"" . norek_placeholder . "\" id=\"no_rek\"><br>\n";
        echo "				" . gaji_title . ":<br><input type=\"text\" name=\"gaji_utama\" value=\"{$editkar['gaji_utama']}\" placeholder=\"" . gaji_placeholder . "\" id=\"gaji_utama\"><br>\n";
        echo "				" . gol_title . ":<br><input type=\"text\" name=\"gol_kar\" value=\"{$editkar['gol_kar']}\" placeholder=\"" . gol_placeholder . "\" id=\"gol_kar\"><br>\n";
        echo "				<input type=\"submit\" name=\"act\" value=\"" . edit_btn_title . "\">\n";
        echo "			</form>\n";
        echo "		</div>\n";
        // page edit_kary Sintax end
    } elseif ($page == 'transfer-gaji') {
        // page transfer_gaji_kary Sintax start
        if ($kary_id) {
            $transfer = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tb_karyawan WHERE kary_id='{$kary_id}'"));
            echo "		<div class=\"box\">\n";
            echo "			<h1>" . transfer_title . "</h1>\n";
            echo "			<p>" . transfer_sub_title . "</p>\n";
            echo "			<table border=\"0\">\n";
            echo "			<tr class=\"data\">\n";
            echo "				<td width=\"180\">" . kode_title . "</td>\n";
            echo "				<td width=\"350\"><b>: &nbsp; {$transfer['kode_kar']}</b></td>\n";
            echo "				<td width=\"140\">" . kode_peng_title . "</td>\n";
            echo "				<td width=\"130\"><b>: " . AturKode("tb_gaji", "kode_gaji", "GJ") . "</b></td>\n";
            echo "			</tr>\n";
            echo "			<tr class=\"data\">\n";
            echo "				<td>" . name_title . "</td>\n";
            echo "				<td><b>: &nbsp; {$transfer['nama_kar']}</b></td>\n";
            echo "				<td>" . month_peng_title . "</td>\n";
            echo "				<td><b>: " . date("F Y") . "</td>\n";
            echo "			</tr>\n";
            echo "			<tr class=\"data\">\n";
            echo "				<td>" . alamat_title . "</td>\n";
            echo "				<td><b>: &nbsp; {$transfer['alamat_kar']}</b></td>\n";
            echo "				<td>" . date_peng_title . "</td>\n";
            echo "				<td><b>: " . date("d/m/Y") . "</td>\n";
            echo "			</tr>\n";
            echo "			<tr class=\"data\">\n";
            echo "				<td>" . gaji_peng_title . "</td>\n";
            echo "				<td><b>: &nbsp; Rp. " . Rupiah($transfer['gaji_utama']) . "</b></td>\n";
            echo "				<td>" . hours_peng_title . "</td>\n";
            echo "				<td><b>: " . date("H:i:s") . "</td>\n";
            echo "			</tr>\n";
            echo "			<tr class=\"data\">\n";
            echo "				<td>" . gol_title . "</td>\n";
            echo "				<td><b>: &nbsp; {$transfer['gol_kar']}</b></td>\n";
            echo "				<td>" . norek_peng_title . "</td>\n";
            echo "				<td><b>: &nbsp; {$transfer['no_rek']}</b></td>\n";
            echo "			</tr>\n";
            echo "			</table>\n";
            echo "		</div>\n";

            echo "		<div class=\"box\">\n";
            if (isset($_SESSION['gaji']['gagal'])) {
                echo "		<div class=\"salah\">" . $_SESSION['gaji']['gagal'] . "</div>\n";
                unset($_SESSION['gaji']['gagal']);
            }
            echo "			<form method=\"post\" action=\"\" autocomplete=\"off\" class=\"form\" name=\"transfer\">\n";
            // variable lembur
            echo "				" . total_lembur_title . " :<br><input type=\"text\" name=\"jam_lembur\" placeholder=\"... Jam\" onkeyup=\"hitung_gaji()\" onkeydown=\"hitung_gaji()\" onchange=\"hitung_gaji()\"> &nbsp; \n";
            echo "				" . uang_lembur_title . "<input type=\"text\" name=\"gaji_utama\" value=\"{$transfer['gaji_utama']}\" style=\"display:none;\">\n";
            echo "				<input type=\"text\" name=\"kode_gaji\" value=\"" . AturKode("tb_gaji", "kode_gaji", "GJ") . "\" style=\"display:none;\">\n";
            echo "				<input type=\"text\" name=\"uang_lembur\" placeholder=\"Rp.-\"><br>\n";
            // // variable bonus
            // echo "                Uang bonus :<br><input type=\"text\" name=\"uang_bonus\" placeholder=\"Isi jumlah bonus\" onkeyup=\"hitung_bonus()\" onkeydown=\"hitung_bonus()\" onchange=\"hitung_bonus()\"> &nbsp; \n";
            // echo "                Total Bonus dipotong PPH<input type=\"text\" name=\"gol_kar\" value=\"{$transfer['gol_kar']}\" style=\"display:none;\">\n";
            // echo "                <input type=\"text\" name=\"kode_gaji\" value=\"".AturKode( "tb_gaji", "kode_gaji", "GJ" )."\" style=\"display:none;\">\n";
            // echo "                <input type=\"text\" name=\"total_uang_bonus\" placeholder=\"Rp.-\"><br>\n";
            echo "				<input type=\"submit\" name=\"act\" value=\"" . transfer_btn_title . "\">\n";
            echo "			</form>\n";
            echo "		</div>\n";
        }
        // page transfer_gaji_kary Sintax end
    } elseif ($page == 'data-transfer-gaji') {
        // page data_transfer_gaji_kary Sintax start
        if ($kary_id) {
            echo "		<div class=\"box\">\n";
            echo "			<h1>" . data_tf_title . "</h1>\n";
            echo "			<p>" . data_tf_sub_title . "</p>\n";
            $transfer_gaji = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tb_karyawan k,tb_gaji g WHERE k.kary_id=g.kary_id AND k.kary_id='{$kary_id}'"));
            echo "			<table border=\"0\">\n";
            echo "			<tr class=\"data\">\n";
            echo "				<td width=\"180\">" . kode_title . "</td>\n";
            echo "				<td width=\"350\"><b>: &nbsp; {$transfer_gaji['kode_kar']}</b></td>\n";
            echo "				<td width=\"140\">" . kode_peng_title . "</td>\n";
            echo "				<td width=\"130\"><b>: {$transfer_gaji['kode_gaji']}</b></td>\n";
            echo "			</tr>\n";
            echo "			<tr class=\"data\">\n";
            echo "				<td>" . name_title . "</td>\n";
            echo "				<td><b>: &nbsp; {$transfer_gaji['nama_kar']}</b></td>\n";
            echo "				<td>" . month_peng_title . "</td>\n";
            echo "				<td><b>: {$transfer_gaji['bulan_transfer']}</td>\n";
            echo "			</tr>\n";
            echo "			<tr class=\"data\">\n";
            echo "				<td>" . alamat_title . "</td>\n";
            echo "				<td><b>: &nbsp; {$transfer_gaji['alamat_kar']}</b></td>\n";
            echo "				<td>" . date_peng_title . "</td>\n";
            echo "				<td><b>: {$transfer_gaji['tgl_transfer']}</td>\n";
            echo "			</tr>\n";
            echo "			<tr class=\"data\">\n";
            echo "				<td>" . gaji_peng_title . "</td>\n";
            echo "				<td><b>: &nbsp; Rp. " . Rupiah($transfer_gaji['gaji_utama']) . "</b></td>\n";
            echo "				<td>" . hours_peng_title . "</td>\n";
            echo "				<td><b>: {$transfer_gaji['jam_transfer']}</td>\n";
            echo "			</tr>\n";
            echo "			<tr class=\"data\">\n";
            echo "				<td>" . gol_title . "</td>\n";
            echo "				<td><b>: &nbsp; {$transfer_gaji['gol_kar']}</b></td>\n";
            echo "				<td>" . norek_peng_title . "</td>\n";
            echo "				<td><b>: &nbsp; {$transfer_gaji['no_rek']}</b></td>\n";
            echo "			</tr>\n";
            echo "			<tr class=\"data\"><td colspan=\"4\"></td></tr>\n";

            echo "			<tr class=\"data\">\n";
            echo "				<td>" . data_tf_jam_lembur_title . "</td>\n";
            echo "				<td><b>: &nbsp; {$transfer_gaji['jam_lembur']} Jam</b></td>\n";
            echo "				<td>&nbsp;</td>\n";
            echo "				<td>&nbsp;</td>\n";
            echo "			</tr>\n";
            echo "			<tr class=\"data\">\n";
            echo "				<td>" . data_tf_uang_lembur_title . "</td>\n";
            echo "				<td><b>: &nbsp; Rp. " . Rupiah($transfer_gaji['uang_lembur']) . "</b></td>\n";
            echo "				<td>&nbsp;</td>\n";
            echo "				<td>&nbsp;</td>\n";
            echo "			</tr>\n";
            echo "			<tr class=\"data\">\n";
            echo "				<td>" . data_tf_total_gaji_title . "</td>\n";
            echo "				<td><b>: &nbsp; Rp. " . Rupiah($transfer_gaji['total_gaji']) . "</b></td>\n";
            echo "				<td>&nbsp;</td>\n";
            echo "				<td>&nbsp;</td>\n";
            echo "			</tr>\n";
            echo "			</table>\n";
            echo "			<p><a href=\"index.php?page=data-gajian\">" . data_tf_riwayat_gaji_title . "</a></p>\n";
            echo "		</div>\n";
        }
        // page data transfer_gaji_kary Sintax end
    } elseif ($page == 'data-gajian') {
        echo "		<div class=\"box\">\n";
        echo "			<h1>" . history_tf_title . "</h1>\n";
        echo "			<p>" . history_tf_sub_title . " <b>" . date("F Y") . "</b></p>\n";
        echo "			<table border=\"0\">\n";
        echo "			<tr class=\"head\">\n";
        echo "				<td width=\"25\" align=\"center\">" . tab_no_title . "</td>\n";
        echo "				<td width=\"60\" align=\"center\">" . tab_date_title . "</td>\n";
        echo "				<td width=\"180\">" . tab_name_title . "</td>\n";
        echo "				<td width=\"90\">" . tab_norek_title . "</td>\n";
        echo "				<td width=\"80\">" . tab_kode_title . "</td>\n";
        echo "				<td width=\"100\">" . tab_tf_title . "</td>\n";
        echo "			</tr>\n";
        $bulan_transfer = date("F Y");
        $data_gajian = mysqli_query($koneksi, "SELECT * FROM tb_karyawan k,tb_gaji g WHERE k.kary_id=g.kary_id AND g.bulan_transfer='{$bulan_transfer}'");
        if (mysqli_num_rows($data_gajian) == 0) {
            echo "		<tr class=\"no-data\"><td colspan=\"7\">" . history_no_tf_title . "</td></tr>\n";
        } else {
            $no = 1;
            while ($row_gaji = mysqli_fetch_array($data_gajian)) {
                echo "	<tr class=\"data\">\n";
                echo "		<td align=\"center\">{$no}</td>\n";
                echo "		<td align=\"center\">{$row_gaji['tgl_transfer']}</td>\n";
                echo "		<td>{$row_gaji['nama_kar']}</td>\n";
                echo "		<td>{$row_gaji['no_rek']}</td>\n";
                echo "		<td>{$row_gaji['kode_gaji']}</td>\n";
                echo "		<td>Rp. " . Rupiah($row_gaji['total_gaji']) . "</td>\n";
                echo "	</tr>\n";
                $no++;
            }
        }
        echo "			</table>\n";
        echo "			<p>&nbsp;</p>\n";
        echo "		</div>\n";
    } elseif ($page == 'cari-karyawan') {
        echo "		<div class=\"box\">\n";
        echo "			<h1>" . search_title . "</h1>\n";
        echo "			<form method=\"post\" action=\"\" autocomplete=\"off\" class=\"form\">\n";
        echo "				<input type=\"text\" name=\"kata\" id=\"kata\" placeholder=\"" . Search_placeholder . "\" autofocus><br>\n";
        echo "				<input type=\"submit\" name=\"act\" value=\"Cari\">\n";
        echo "			</form>\n";
        echo "		</div>\n";
        if ($act == 'Cari') {
            $kata = isset($_POST['kata']) ? $_POST['kata'] : '';
            $katas = ($kata == "") ? "Kata Kunci Pencarian Tidak Disebutkan" : $kata;
            $cari = mysqli_query($koneksi, "SELECT * FROM tb_karyawan WHERE nama_kar LIKE '%$kata%' OR kode_kar LIKE '%$kata%' OR gol_kar LIKE '%$kata%'");
            echo "		<div class=\"box\">\n";
            echo "			<h1>" . search_value_title . "</h1>\n";
            echo "			<p>" . search_keyword_title . ": <b>{$katas}</b> | " . search_jumlah_data_title . ": <b>" . mysqli_num_rows($cari) . "</b> Data</p>\n";
            echo "			<table border=\"0\">\n";
            echo "			<tr class=\"head\">\n";
            echo "				<td width=\"30\" align=\"center\">" . tab_no_title . "</td>\n";
            echo "				<td width=\"150\">" . tab_name_title . "</td>\n";
            echo "				<td width=\"180\">" . tab_alamat_title . "</td>\n";
            echo "				<td width=\"95\">" . tab_gaji_title . "</td>\n";
            echo "				<td width=\"30\" align=\"center\">" . tab_gol_title . "</td>\n";
            echo "				<td width=\"90\" align=\"center\">" . tab_norek_title . "</td>\n";
            echo "			</tr>\n";
            if (mysqli_num_rows($cari) == 0) {
                echo "		<tr class=\"no-data\"><td colspan=\"6\">" . search_not_found_title . "</td></tr>\n";
            } else {
                $no = 1;
                while ($datacari = mysqli_fetch_array($cari)) {
                    echo "	<tr class=\"data\">\n";
                    echo "		<td align=\"center\">{$no}</td>\n";
                    echo "		<td><a href=\"" . URL . "/index.php?page=transfer-gaji&kary_id={$datacari['kary_id']}\" title=\"Transfer Gaji &rarr; {$datacari['nama_kar']}\">{$datacari['nama_kar']}</a></td>\n";
                    echo "		<td>{$datacari['alamat_kar']}</td>\n";
                    echo "		<td>Rp. " . Rupiah($datacari['gaji_utama']) . "</td>\n";
                    echo "		<td align=\"center\">{$datacari['gol_kar']}</td>\n";
                    echo "		<td align=\"center\">{$datacari['no_rek']}</td>\n";
                    echo "	</tr>\n";
                    $no++;
                }
            }
            echo "			</table>\n";
            echo "			<p>" . search_all_title . "</p>\n";
            echo "		</div>\n";
        }
    } else {
        // page index sintax Start
        echo "		<div class=\"box\">\n";
        echo "			<h1>" . beranda_title . "</h1>\n";
        echo "           <p><img src=\"" . URL . "/images/office.jpg\" alt=\"office\"> &nbsp &nbsp<img src=\"" . URL . "/images/office.jpg\" alt=\"office\"></p>\n";
        echo "			<p>" . beranda_desc . "</p>\n";
        echo "		</div>\n";
        // page index sintax End
    }
    echo "		</div>\n";
    echo "		<div class=\"clear\"></div>\n";
    echo "	</div>\n";
    // footer sintax Start
    echo "	<div class=\"footer\">\n";
    echo "		 " . copyright_title . " &copy; - " . date("Y") . " | " . ptvictory_title . " \n";
    echo "	</div>\n";
    // footer sintax End
    echo "</div>\n";
} else {
    // Form Login Sintax Start
    echo "<div class=\"login-box\">\n";
    echo "	<div class=\"login-logo\">\n";
    echo " <h1>" . welcome_title . "</h1>\n";
    echo "	</div>\n";
    echo "	<div class=\"login-form\">\n";
    echo "		<div class=\"login-info\">" . welcomesub_title . "</div>\n";
    echo "		<form method=\"post\" action=\"\" name=\"login\" autocomplete=\"off\">\n";
    echo "			" . usr_title . " :<br><br><input type=\"text\" name=\"username\" placeholder=\"" . usr_placeholder . "\" id=\"username\" autofocus><br>\n";
    echo "			" . pass_title . " :<br><br><input type=\"password\" name=\"password\" placeholder=\"" . pass_placeholder . "\" id=\"password\"><br>\n";
    echo "			<input type=\"submit\" name=\"act\" value=\"" . login_btn_title . "\" onclick=\"cek_login();\">\n";
    echo "          <div class=\"u-login\"><img src=\"" . URL . "/images/pic-login.jpg\" alt=\"Foto\"></div>\n";
    echo "		</form>\n";
    if (isset($_SESSION['login']['gagal'])) {
        echo "	<div class=\"error-login\">" . $_SESSION['login']['gagal'] . "</div>\n";
        unset($_SESSION['login']['gagal']);
    }
    echo "	</div>\n";
    echo "	<div class=\"copy\"> " . copyright_title . " &copy; - " . date("Y") . " | " . ptvictory_title . "</div>\n";
    echo "</div>\n";
    // Form Login Sintax end
}
?>

</body>
</html>