<?php 

function cek_prg_atm($id_user,$group_visit)
{
	$CI =& get_instance();
	$id_visit_atm = $CI->db->get_where('header_visit_atm', array('id_user'=>$id_user,'group_visit'=>$group_visit))->row()->id_visit_atm;
	$cek = $CI->db->query("SELECT * FROM visit_atm where pilihan_check = 0 and id_visit_atm='$id_visit_atm'");
	if ($cek->num_rows() > 0) {
		$n = 0;
	} else {
		$n = 1;
	}
	return $n;
	
}

function prg_atm($group_visit)
{
	$CI =& get_instance();
	$total = $CI->db->get_where('header_visit_atm', array('group_visit'=>$group_visit))->num_rows();
	$done = $CI->db->get_where('header_visit_atm', array('group_visit'=>$group_visit,'approve'=>1))->num_rows();
	$prg = ($done/$total)*100;
	return number_format($prg);
}

function cek_approval($id_user, $approve)
{
	$approve_n = get_data('user','id_user',$id_user,'approve');
	$n = '';
	if ($approve_n == $approve) {
		$n = 'ya';
	} else {
		$n = 'tidak';
	}
	return $n;
}


function create_random($length)
{
    $data = 'ABCDEFGHIJKLMNOPQRSTU1234567890';
    $string = '';
    for($i = 0; $i < $length; $i++) {
        $pos = rand(0, strlen($data)-1);
        $string .= $data{$pos};
    }
    return $string;
}

function upload_gambar_biasa($nama_gambar, $lokasi_gambar, $tipe_gambar, $ukuran_gambar, $name_file_form)
{
    $CI =& get_instance();
    $nmfile = $nama_gambar."_".time();
    $config['upload_path'] = './'.$lokasi_gambar;
    $config['allowed_types'] = $tipe_gambar;
    $config['max_size'] = $ukuran_gambar;
    $config['file_name'] = $nmfile;
    // load library upload
    $CI->load->library('upload', $config);
    // upload gambar 1
    if ( ! $CI->upload->do_upload($name_file_form)) {
    	return $CI->upload->display_errors();
    } else {
	    $result1 = $CI->upload->data();
	    $result = array('gambar'=>$result1);
	    $dfile = $result['gambar']['file_name'];
	    
	    return $dfile;
	}	
}

function get_ph($no_po,$total_h)
{
	$CI =& get_instance();
	// log_r($total_h);
	// if ($total_h = '') {
	// 	$total_h = 0;
	// }
	$ph = $CI->db->get_where('po_master', array('no_po'=>$no_po))->row()->potongan_harga;
	$d_ph = explode(';', $ph);
	$t_h_now = $total_h;
	foreach ($d_ph as $key => $value) {
		if (strstr($value, '%')) {
			$t_persen = str_replace('%', '', $value) /100;
			$n_persen = $t_persen * $t_h_now;
			$t_h_now = $t_h_now - $n_persen;
		} else {
			$t_h_now = $t_h_now - floatval($value);
			// log_r($t_h_now);
		}
	}
	return $t_h_now;

}

function get_diskon_beli($diskon,$total_h)
{
	$CI =& get_instance();
	// log_r($total_h);
	// if ($total_h = '') {
	// 	$total_h = 0;
	// }
	$ph = $diskon;
	$d_ph = explode(';', $ph);
	$t_h_now = $total_h;
	foreach ($d_ph as $key => $value) {
		if (strstr($value, '%')) {
			$t_persen = str_replace('%', '', $value) /100;
			$n_persen = $t_persen * $t_h_now;
			$t_h_now = $t_h_now - $n_persen;
		} else {
			$t_h_now = $t_h_now - floatval($value);
			// log_r($t_h_now);
		}
	}
	return $t_h_now;

}


function get_waktu()
{
	date_default_timezone_set('Asia/Jakarta');
	return date('Y-m-d H:i:s');
}
function select_option($name, $table, $field, $pk, $selected = null,$class = null, $extra = null, $option_tamabahan = null) {
    $ci = & get_instance();
    $cmb = "<select name='$name' class='form-control $class  ' $extra>";
    $cmb .= $option_tamabahan;
    $data = $ci->db->get($table)->result();
    foreach ($data as $row) {
        $cmb .="<option value='" . $row->$pk . "'";
        $cmb .= $selected == $row->$pk ? 'selected' : '';
        $cmb .=">" . strtoupper($row->$field ). "</option>";
    }
    $cmb .= "</select>";
    return $cmb;
}

function get_setting($select)
{
	$CI =& get_instance();
	$data = $CI->db->query("SELECT $select FROM pengaturan_aplikasi where id_pengaturan='1' ")->row_array();
	return $data[$select];
}

function get_data($tabel,$primary_key,$id,$select)
{
	$CI =& get_instance();
	$data = $CI->db->query("SELECT $select FROM $tabel where $primary_key='$id' ")->row_array();
	return $data[$select];
}

function get_produk($barcode,$select)
{
	$CI =& get_instance();
	$data = $CI->db->query("SELECT $select FROM produk where barcode1='$barcode' or barcode2='$barcode' ")->row_array();
	return $data[$select];
}



function alert_biasa($pesan,$type)
{
	return 'swal("'.$pesan.'", "You clicked the button!", "'.$type.'");';
}

function alert_tunggu($pesan,$type)
{
	return '
	swal("Silahkan Tunggu!", {
	  button: false,
	  icon: "info",
	});
	';
}

function selisih_waktu($start_date)
{
	date_default_timezone_set('Asia/Jakarta');
	$waktuawal  = date_create($start_date); //waktu di setting

	$waktuakhir = date_create(date('Y-m-d H:i:s')); //2019-02-21 09:35 waktu sekarang

	//Membandingkan
	$date1 = new DateTime($start_date);
	$date2 = new DateTime(date('Y-m-d H:i:s'));
	if ($date2 < $date1) {
	    $diff  = date_diff($waktuawal, $waktuakhir);
		return $diff->d . ' hari '.$diff->h . ' jam lagi ';
	} else {
		return 'berlangsung';
	}

	

	// echo 'Selisih waktu: ';

	// echo $diff->y . ' tahun, ';

	// echo $diff->m . ' bulan, ';

	// echo $diff->d . ' hari, ';

	// echo $diff->h . ' jam, ';

	// echo $diff->i . ' menit, ';

	// echo $diff->s . ' detik, ';
}



function filter_string($n)
{
	$hasil = str_replace('"', "'", $n);
	return $hasil;
}

function cek_nilai_lulus()
{	
	$CI 	=& get_instance();
	$nilai = $CI->db->query("SELECT sum(nilai_lulus) as lulus FROM mapel ")->row()->lulus;
	return $nilai;
}



function log_r($string = null, $var_dump = false)
    {
        if ($var_dump) {
            var_dump($string);
        } else {
            echo "<pre>";
            print_r($string);
        }
        exit;
    }

    function log_data($string = null, $var_dump = false)
    {
        if ($var_dump) {
            var_dump($string);
        } else {
            echo "<pre>";
            print_r($string);
        }
        // exit;
    }