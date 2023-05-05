<?php
date_default_timezone_set( 'Asia/Jakarta' );
$db['host'] = "localhost"; //host
$db['user'] = "root"; //username database
$db['pass'] = ""; //password database
$db['name'] = "analisis_gaji_db"; //nama database
$koneksi = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['name']);
$act = isset( $_POST['act'] ) ? $_POST['act'] : '';
$page = isset( $_GET['page'] ) ? $_GET['page'] : '';

define( 'WEB', 'Victorystars' );
define( 'URL', 'http://localhost/victorystars/' ); // Ubah sesuai directory penyimpanan

function AturKode( $table, $id, $init) {
	$db['host'] = "localhost"; //host
	$db['user'] = "root"; //username database
	$db['pass'] = ""; //password database
	$db['name'] = "analisis_gaji_db"; //nama database
	$koneksi = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['name']);
	$data = mysqli_fetch_array( mysqli_query($koneksi, "SELECT MAX($id) AS kode FROM {$table}" ) );
	$kode = $data['kode'];
	if( $kode ) {
		$kode = substr( $kode, 0, 5 );
		$kode++;
	} else {
		$kode = $init . "001";
	}
	return $kode;
}	

function Rupiah( $id ) {
	return number_format( $id, 0, ", ", "." );
}
?>