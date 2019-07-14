<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * - Fungsi untuk menulis ulang konten file pada application/cache/routes.php
 * - Fungsi ini digunakan setelah melakukan perubahan pada setingan konfigurasi slug url.
 * 
 * @return bool
*/
function check_internet_connection($addr = 'www.google.com')
{
	return (bool)  @fsockopen($addr, 80, $num, $error, 5);
}


/**
 * - Fungsi untuk menulis ulang konten file pada application/cache/routes.php
 * - Fungsi ini digunakan setelah melakukan perubahan pada setingan konfigurasi slug url.
 * 
 * @return void
*/
function save_routes()
{
	$CI =& get_instance();
	$CI->load->database();

	$slg_setting = $CI->db->where('options', 'slug_url')->get('t_setting')->row_array()['value'];
	$slg_title   = $CI->db->where('options', 'slug_title')->get('t_setting')->row_array()['value'];
	$slg_actives = $CI->db->where('title', $slg_setting)->get('t_slug')->result_array();

	$data = [];
	$data[] = "<?php defined('BASEPATH') OR exit('No direct script access allowed');";
	foreach ($slg_actives as $key) 
	{
		if ( $slg_setting === 'slug/seotitle' )
			$data[] = '$route[\'' . $slg_title . '/([a-z0-9-]+)\'] = \'post/index/$1\';';

		if ( $slg_setting === 'yyyy/seotitle' )
			$data[] = '$route[\'' . $key['slug'] . '\'] = \'post/index/$2\';';

		if ( $slg_setting === 'yyyy/mm/seotitle' )
			$data[] = '$route[\'' . $key['slug'] . '\'] = \'post/index/$3\';';

		if ( $slg_setting === 'yyyy/mm/dd/seotitle' )
			$data[] = '$route[\'' . $key['slug'] . '\'] = \'post/index/$4\';';

		if ( $slg_setting === 'seotitle' )
			$data[] = '$route[\'' . $key['slug'] . '\'] = \'post/index/$1\';';
	}

	$output = implode("\n", $data);
	write_file(APPPATH . 'cache/routes.php', $output);
}





/**
 * - Fungsi untuk mengambil data tema yang aktif.
 * - Contoh : theme_active('folder');
 *  
 * @param   string $param
 * @return  string  
*/
function theme_active($param = 'folder')
{
	$CI =& get_instance();
	$CI->load->library('settings');
	if ( isset($CI->session->theme_active) )
	{
		return $CI->session->theme_active[$param];
	}
	else
	{
		return $CI->settings->theme($param);
	}
	
}


/**
 * - Fungsi untuk memanggil baris bahasa.
 * - Contoh : lang_line('button_save')
 *
 * @param   stting  $param
 * @return  string  
*/
function lang_line($param = '')
{
	$CI =& get_instance();
	return $CI->lang->line($param);
}


/**
 * - Fungsi untuk menampilkan url base halaman administrator
 * 
 *  Contoh : <?=admin_url('home')?>
 *  Hasil  : http://your.domain/l-admin/home
 * 
 * @param   string  $param
 * @param   string  $protocol
 * @return  string  
*/
function admin_url($param = '', $protocol = NULL)
{
	$CI =& get_instance();
	return $CI->config->base_url(FADMIN.'/'.$param, $protocol);
}


/**
 * - Fungsi untuk menampilkan url base halaman member
 * - Contoh : <?=member_url('profile')?>
 * - Hasil  : http://your.domain/l-member/profile
 * 
 * @param   string  $param
 * @param   string  $protocol
 * @return  string  
*/
function member_url($param = '', $protocol = NULL)
{
	$CI =& get_instance();
	return $CI->config->base_url('l-member/'.$param, $protocol);
}


/**
 * - Fungsi untuk menampilkan url folder content
 * 
 *  Contoh : <?=content_url('assets/foo/bar.css')?>
 *  Hasil  : http://your.domain/content/assets/foo/bar.css
 * 
 * @param   string  $param
 * @param   string	$protocol
 * @return  string  
*/
function content_url($param = '', $protocol = NULL)
{
	$CI =& get_instance();
	return $CI->config->base_url(FCONTENT.'/'.$param, $protocol);
}


/**
 * - Fungsi untuk menampilkan url post secara dinamis
 *   sesuai konfigurasi slug url pada tabel t_setting.
 * 
 *   Contoh : <?=post_url($seotitle)?>
 *   Hasil  : http://your.dmoain/your-slug/seotitle
 * 
 * @param   string  $seotitle
 * @return  string
*/
function post_url($seotitle = '')
{
	$CI =& get_instance();
	
	$slug_url = $CI->db
			  ->select('value')
			  ->where('options', 'slug_url')
			  ->get('t_setting')
			  ->row_array();
	$slug_url = $slug_url['value'];
	
	$slug_title = $CI->db
				->select('value')
				->where('options', 'slug_title')
				->get('t_setting')
				->row_array();
	$slug_title = $slug_title['value'];

	$date = $CI->db
		  ->select('datepost')
		  ->where('seotitle', $seotitle)
		  ->get('t_post')
		  ->row_array();

	$day  = date('d',strtotime($date['datepost']));
	$moon = date('m',strtotime($date['datepost']));
	$year = date('Y',strtotime($date['datepost']));

	switch ( $slug_url )
	{	
		default:
			$url = '';
		break;

		case 'seotitle':
			$url = site_url($seotitle);
		break;

		case 'slug/seotitle':
			$url = site_url("$slug_title/$seotitle");
		break;
		
		case 'yyyy/seotitle':
			$url = site_url("$year/$seotitle");
		break;
		
		case 'yyyy/mm/seotitle':
			$url = site_url("$year/$moon/$seotitle");
		break;
		
		case 'yyyy/mm/dd/seotitle':
			$url = site_url("$year/$moon/$day/$seotitle");
		break;
	}

	return $url;
}


/**
 * - Fungsi untuk menampilkan url favicon dan url logo.
 * 
 *   Contoh : <link rel="shortcut icon" href="<?=favicon()?>">
 * 
 * @param   string  $param
 * @return  string  
*/
function favicon($param = '') 
{
	$favicon = content_url('favicon/favicon.png');
	
	if ($param === 'logo') 
		$favicon = content_url('favicon/logo.png');
	
	return $favicon;
}


/**
 * - Fungsi untuk menampilkan url gambar.
 * - Mode : NULL, medium, thumb
 * - noimage : bool
 * 
 *   Contoh : post_images($filename, 'medium', TRUE)
 *   Hasil  : http://your.dmoain/content/uploads/medium/filename.jpg
 * 
 * @param   string  $filename
 * @param   string  $mode
 * @param   bool     $noimage
 * @return  string
*/
function post_images($filename = '', $mode = NULL, $noimage = FALSE)
{
	$image_url = '';
	$dt = "?".strtotime(date('YmdHis'));

	switch ($noimage) 
	{
		case TRUE:
			if ( !empty($filename) )
			{
				if ( $mode == 'thumb' ) 
				{
					if (file_exists(CONTENTPATH."thumbs/$filename")) 
						$image_url = content_url("thumbs/$filename").$dt;
					else 
						$image_url = content_url("images/thumb_noimage.jpg").$dt;
				}
				elseif ( $mode == 'medium' ) 
				{
					if (file_exists(CONTENTPATH."uploads/medium/$filename")) 
						$image_url = content_url("uploads/medium/$filename").$dt;
					else
						$image_url = content_url("images/medium_noimage.jpg").$dt;
				}
				else
				{
					if ( file_exists(CONTENTPATH."uploads/$filename") ) 
						$image_url = content_url("uploads/$filename").$dt;
					else
						$image_url = content_url("images/noimage.jpg").$dt;
				}
			}

			else
			{
				if ( $mode == 'thumb' )
					$image_url = content_url("images/thumb_noimage.jpg").$dt;
				elseif ($mode == 'medium')
					$image_url = content_url("images/medium_noimage.jpg").$dt;
				else
					$image_url = content_url("images/noimage.jpg").$dt;
			}			
		break;
		
		default:
		case FALSE:
			if ( !empty($filename) && file_exists(CONTENTPATH."uploads/$filename") && $mode == '' ) 
				$image_url = content_url("uploads/$filename").$dt;
			elseif ( !empty($filename) && file_exists(CONTENTPATH."uploads/medium/$filename") && $mode == 'medium' ) 
				$image_url = content_url("uploads/medium/$filename").$dt;
			elseif ( !empty($filename) && file_exists(CONTENTPATH."thumbs/$filename") && $mode == 'thumb' ) 
				$image_url = content_url("thumbs/$filename").$dt;
			else
				$image_url = '';
		break;
	}

	return $image_url;
}


/**
 * - Fungsi untuk menampilkan url file.
 * 
 *   Contoh : post_file('dokumen.xlsx', 'file')
 *   Hasil  : http://your.dmoain/content/uploads/file/dokumen.xlsx
 * 
 * @param   string  $filename
 * @param   string  $mode
 * @param   bool     $noimage
 * @return  string
*/
function post_file($filename = '', $type = 'file')
{
	$url_file = '';
	if ( file_exists(CONTENTPATH . "uploads/$type/$filename") )
		$url_file = content_url("uploads/$type/$filename");

	return $url_file;
}


/**
 * - Fungsi untuk menampilkan url foto user.
 * 
 *   Contoh : user_photo(user.jpg)
 *   Hasil  : http://your.dmoain/content/uploads/user/user.jpg
 * 
 * @param   string  $photo
 * @return  string
*/
function user_photo($photo = '')
{
	if ( !empty($photo) && file_exists(CONTENTPATH."uploads/user/$photo") ) 
		$user_photo = content_url("uploads/user/$photo");
	else
		$user_photo = content_url('images/avatar.jpg');

	return $user_photo."?".strtotime(date('YmdHis'));
}


/**
 * - Fungsi untuk menampilkan base64 image.
 *   
 *   Contoh : base64_image('http://your.dmoain/content/uploads/user/user.jpg')
 * 
 * @param   string  $img_url
 * @return  string
*/
function base64_image($img_url='')
{
	$src = "data:image/png;base64,".base64_encode(file_get_contents($img_url));
	return $src;
}



/**
 * - Fungsi untuk menentukn panjang karakter.
 * 
 *   Contoh : cut('foo bar bass pass', 2)
 * 
 * @param   string      $data
 * @param   string|int  $long
 * @param   bool         $option
 * @return  string
*/
function cut($data = '', $long = '', $option = FALSE)
{
	$str = $data;

	if ( isset($data) && isset($long))
	{
		if ($option == FALSE)
		{
			$str = html_entity_decode($str);
			$str = strip_tags($str);
			$str = mb_substr($str, 0, $long);
			$str = mb_substr($str, 0, strrpos($str," "));
		} 
		else
		{
			$str = mb_substr($str,0,$long);
		}
	}

	return $str;
}


/**
 * - Fungsi untuk menyoroti kata dalam kalimat.
 * 
 *   Contoh : text_highlight('foo bar bass pass', 'foo', 'color:red;')
 * 
 * @param 	string 	$words
 * @param 	string 	$text
 * @param 	string 	$style
 * @return 	string 	
*/
function text_highlight($words = '', $text = '', $style = '')
{
	$font_style = (!empty($params) ? $params : 'color:#FDFF2B;');
	
	preg_match_all('~[A-Za-z0-9_äöüÄÖÜ]+~', $words, $m);
	
	if ( !$m ) 
		$highlight = $text;

	$re = '~(' . implode('|', $m[0]) . ')~i';
	$highlight = preg_replace($re, '<font style="'. $font_style .'">$0</font>', $text);

	return $highlight;
}


/**
 * - Fungsi untuk konversi array ke string.
 * 
 *   Contoh : arrays_to_string(['foo','bar','bass'], ',')
 * 
 * @param 	array 	$ar
 * @param 	string 	$sep
 * @return 	string 	
*/
function arrays_to_string(array $ar, $sep = ',') 
{
	$str = '';

	foreach ($ar as $val) 
	{
		$str .= implode($sep, $val);
		$str .= $sep; // add separator between sub-arrays
	}
	
	$str = rtrim($str, $sep); // remove last separator
	
	return $str;
}


/**
 * - Fungsi untuk konversi data json ke array asosiatif.
 * 
 *   Contoh : json_to_array($data_json)
 * 
 * @param 	string|jon 	$data
 * @return 	array 	
*/
function json_to_array($data)
{
	if (is_object($data))
		$data = get_object_vars($data);

	$jdata = is_array($data) ? array_map(__FUNCTION__, $data) : $data;
	return json_decode($jdata);
}



/**
 * - Fungsi untuk memfilter string manjadi string seo.
 * 
 *   Contoh : seotitle("foo bar bass")
 *   Hasil  : foo-bar-bass
 * 
 * @param 	string 	$str
 * @param 	string 	$sp
 * @return 	string 	
*/
function seotitle($str = '', $sp = '-')
{
	$seotitle = '';

	if (!empty($str))
	{	
		$q_separator = preg_quote($sp, '#');

		$trans = array(
			'_' => $sp,
			'&.+?;' => '',
			'[^\w\d -]' => '',
			'\s+' => $sp,
			'('.$q_separator.')+' => $sp
		);

		$str = strip_tags($str);
		
		foreach ($trans as $key => $val)
		{
			$str = preg_replace('#'.$key.'#i'.(UTF8_ENABLED ? 'u' : ''), $val, $str);
		}
		
		$str = strtolower($str);
		
		$seotitle = trim(trim($str, $sp));
	}

	return $seotitle;
}


/**
 * - Fungsi untuk memfilter string dari karakter berbahaya.
 * - type : xss, sql
 * 
 *   Contoh : xss_filter("foo bar bass", 'xss')
 * 
 * @param 	string 	$str
 * @param 	string 	$type
 * @return 	string 	
*/
function xss_filter($str, $type = '')
{
	switch($type)
	{
		default:
			$str = stripcslashes(htmlspecialchars($str, ENT_QUOTES));
			return $str;
		break;

		case 'sql':
			$x = array('-','/','\\',',','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','%','$','^','&','*','=','?','+');
			$str = str_replace($x, '', $str);
			$str = stripcslashes($str);	
			$str = htmlspecialchars($str);				
			$str = preg_replace('/[^A-Za-z0-9]/','',$str);				
			return intval($str);
		break;

		case 'xss':
			$x = array ('\\','#',';','\'','"','[',']','{','}',')','(','|','`','~','!','%','$','^','*','=','?','+');

			$str = str_replace($x, '', $str);
			$str = stripcslashes($str);	
			$str = htmlspecialchars($str);
			return $str;
		break;
	}
}


/**
 * - Fungsi untuk mengurangi spasi ganda.
 * 
 *   Contoh : clean_space("foo bar   bass")
 * 
 * @param 	string 	$data
 * @return 	string 	
*/
function clean_space($data = '')
{
	$str = '';
	if ( !empty($data) )
	{
		$patterns = array("/\s+/", "/\s([?.!])/");
		$replacer = array(" ","$1");
		$str = preg_replace( $patterns, $replacer, $data );
	}
	return $str;
}


/**
 * - Fungsi untuk memfilter string dari karakter berbahaya untuk kebutuhan tag.
 * 
 *   Contoh : clean_tag("foo bar bass")
 *   Hasil  : foobarbass
 * 
 * @param 	string 	$str
 * @return 	string 	
*/
function clean_tag($str = '')
{
	if ( isset($str) )
	{
		$d = array ('\\','#',';','\'','"','[',']','{','}',')','(','|','`','~','!','%','$','^','*','=','?','+','<','>','.','@',':','/','&');
		$str = str_replace($d, '', $str);
		$str = stripcslashes($str);	
	}
	
	return $str;
}











/**
 * - Fungsi untuk memisahkan kata dalam kalimat.
 * 
 *   Contoh : 
 *      $kata = "foo bar bass";
 *      pecah_kata(NULL, $kata, FALSE, '#', ',')
 * 
 * @param 	string 	$str
 * @return 	string 	
*/
function pecah_kata($delimiter = NULL, $kata, $link = FALSE, $href = '#', $separator = '') 
{
	$_rez = '';
	
	if (empty($delimiter))
		$delimiter = ' ';

	$pecah = explode($delimiter,$kata);
	$arr_katas = (integer)count($pecah) - 1;						
	
	for ( $i = 0; $i <= $arr_katas ; $i++ )
	{
		if ( $i == $arr_katas )
			$separator = "";
		
		switch ($link)
		{
			default:
				$_rez .= $pecah[$i].$separator;
			break;
			case TRUE:
				$lstrlink = $href.$pecah[$i];
				$_rez .= '<a href="'.$lstrlink.'">'.$pecah[$i].'</a>'.$separator;
			break;				
		}			
	}

	return rtrim($_rez,$separator);
}










/**
 * - Fungsi untuk menyalin (copy) folder beserta isinya.
 * 
 *   Contoh : r_copy(foo/bar/, foo/bass)
 * 
 * @param 	string 	$src
 * @param 	string 	$dst
 * @return 	void 	
*/
function r_copy($src, $dst)
{
	if (is_dir($src)) // copy folder
	{
		if (!file_exists($dst))
			@mkdir($dst);
		
		$files = scandir($src);

		foreach ($files as $file)
		{
			if ($file != "." && $file != "..")
				r_copy("$src/.$file", "$dst/$file");
		}
	} 
	elseif (file_exists($src)) // copy file
	{
		copy($src, $dst);
	}
}



/**
 * - Fungsi untuk menyalin (copy) folder.
 * 
 *   Contoh : copy_folder(foo/, bar/, 0755, FALSE)
 * 
 * @param 	string 	$source
 * @param 	string 	$destination
 * @param 	int 	$permissions
 * @param 	bool 	$delete_source
 * @return 	bool 	
*/
function copy_folder($source, $destination, $permissions = 0755, $delete_source = FALSE)
{
	if (file_exists($source))
	{
		// Check for symlinks
		if (is_link($source)) 
		{
			return symlink(readlink($source), $destination);
		}

		// Simple copy for a file
		if (is_file($source)) 
		{
			return copy($source, $destination);
		}

		// Make destination directory
		if (!file_exists($destination)) 
		{
			@mkdir($destination, $permissions, TRUE);
		}

		// Loop through the folder
		$dir = dir($source);
		
		while ( FALSE !== $entry = $dir->read() ) 
		{
			// Skip pointers
			if ($entry == '.' || $entry == '..') 
				continue;

			// Deep copy directories
			copy_folder("$source".DIRECTORY_SEPARATOR."$entry", "$destination".DIRECTORY_SEPARATOR."$entry", $permissions);
		}

		// Clean up
		$dir->close();

		if ($delete_source == TRUE) 
		{
			delete_folder($source);
		}

		return TRUE;
	}

	return FALSE;
}



/**
 * - Fungsi untuk menghapus folder.
 * 
 *   Contoh : delete_folder('foo/bar')
 * 
 * @param 	string 	$path
 * @return 	bool|void	
*/
function delete_folder($path = '')
{
	if (!file_exists($path))
		return false;

	if (is_file($path) || is_link($path))
		return unlink($path);

	$stack = array($path);

	while ($entry = array_pop($stack)) 
	{
		if (is_link($entry)) 
		{
			unlink($entry);
			continue;
		}

		if (@rmdir($entry))
			continue;

		$stack[] = $entry;
		$dh = opendir($entry);

		while(false !== $child = readdir($dh)) 
		{
			if ($child === '.' || $child === '..')
				continue;

			$child = $entry . DIRECTORY_SEPARATOR . $child;
			
			if (is_dir($child) && !is_link($child))
				$stack[] = $child;
			else
				unlink($child);

		}

		closedir($dh);
	}

	return true;
}


/**
 * - Fungsi untuk decode url.
 * 
 *   Contoh : url_decode('foo%barr')
 * 
 * @param 	string 	$param
 * @return 	void|string	
*/
function url_decode($param = 'nourl')
{
	return urldecode(rawurldecode($param));
}

/**
 * - Fungsi untuk encode url.
 * 
 *   Contoh : url_decode('foo-barr')
 * 
 * @param 	string 	$param
 * @return 	void|string	
*/
function url_encode($param = 'nourl')
{ 
	return urlencode(rawurlencode($param));
}


/**
 * - Fungsi untuk encrypt string.
 * 
 *   Contoh : encrypt($str = '')
 * 
 * @param 	string 	$str
 * @return 	void|string	
*/
function encrypt($str = '')
{
	$CI =& get_instance();
	$CI->load->library('encryption');
	return $CI->encryption->encrypt($str);
}

/**
 * - Fungsi untuk decrypt string.
 * 
 *   Contoh : decrypt($str = '')
 * 
 * @param 	string 	$str
 * @return 	void|string	
*/
function decrypt($str = '')
{
	$CI =& get_instance();
	$CI->load->library('encryption');
	return $CI->encryption->decrypt($str);
}


/**
 * - Fungsi untuk mengatur waktu session login.
 * 
 *   Contoh : login_timeout($mode='admin')
 * 
 * @param 	string 	$mode
 * @return 	void|string	
*/
function login_timeout($mode)
{
	$timeout = config_item('sess_expiration');
	$sessions = "TimeOut_".$mode;
	$_SESSION[$sessions] = time() + $timeout;
}


/**
 * - Fungsi untuk memanggil status session login.
 * 
 *   Contoh : login_status($mode = 'admin')
 * 
 * @param 	string 	$mode
 * @return 	bool	
*/
function login_status($mode = '')
{
	if ( !empty($_SESSION["log_$mode"]) )
	{
		$CI =& get_instance();
		$CI->load->database();
		$key_id = $_SESSION["log_$mode"]['key'];
		$find   = $CI->db->where('id',$key_id)->get('t_user')->num_rows();

		if ( $find == 0 )
			return FALSE;
		else
			return TRUE;
	}
	else
	{
		return FALSE;
	}
}

function login_key($mode = 'null') 
{
	$item = 'log_'.$mode;
	$sesskey = NULL;

	if ( !empty($_SESSION[$item]['key']) )
		$sesskey = $_SESSION[$item]['key'];	

	return $sesskey;
}


/**
 * - Fungsi untuk menampilkan data login level.
 * 
 *   Contoh : login_level('member', FALSE) 
 * 
 * @param 	string 	$mode
 * @param 	bool 	$param
 * @return 	string	
*/
function login_level($mode = '', $param = FALSE) 
{
	$item = 'log_'.$mode;
	$session = $_SESSION[$item];
	$result = NULL;

	if ( !empty($session['level']) ) 
	{
		$result =  $session['level'];

		if ( $param == TRUE )
		{
			$CI =& get_instance();
			$CI->load->database();

			$query  = $CI->db->select('level')
				->where('id', $session['level'])
				->get('t_user_level')
				->row_array();
			$result = $query['level'];
		}
	}

	return $result;
}



function user_level($param = 'id')
{
	$CI =& get_instance();
	$CI->load->database();
	
	$id_session = $_SESSION['log_admin']['level'];

	$query  = $CI->db->where('id', $id_session);
	$query  = $CI->db->get('t_user_level');
	$query  = $query->row_array();
	$level  = $query[$param];

	return $level;
}


/**
 * - Fungsi untuk menampilkan data login.
 * 
 *   Contoh : data_login('member', 'name')
 * 
 * @param 	string 	$mode
 * @param 	string 	$field
 * @return 	string	
*/
function data_login($mode, $field)
{
	$CI =& get_instance();
	$CI->load->database();
	$key    = $_SESSION['log_'.$mode]['key'];
	$query  = $CI->db->where('id', $key)->get('t_user')->row_array();
	$result = $query[$field];
	return $result;
}



/**
 * @param 	string 	$level
 * @return 	string	
*/
function dashboard_menu_active($level = null)
{
	$menu = 0;
	if ( !empty($level) ) 
	{
		$CI =& get_instance();
		$CI->load->database();
		$query = $CI->db
			->select('menu')
			->where('level', $level)
			->get('t_user_level')
			->row_array();
		$menu = $query['menu'];
	}
	return $menu;
}

/**
 * @return 	void|string	
*/
function googleCaptcha() 
{
	$CI =& get_instance();
	$key = $CI->settings->website('recaptcha_secret_key');
	$get = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$key.'&response='.$_POST['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR']);
	if ($get)
		return json_decode($get);
	else
		return FALSE;
}



function show_400($page = '', $log_error = TRUE)
{
	if (is_cli())
	{
		$heading = '400 Bad Request';
		$message = 'Server cannot or will not process the request due to something that is perceived to be a client error.';
	}
	else
	{
		$heading = '400 Bad Request';
		$message = 'Server cannot or will not process the request due to something that is perceived to be a client error.';
	}

	// By default we log this, but allow a dev to skip it
	if ($log_error)
	{
		$CI =& get_instance();
		$page = base_url().$CI->uri->uri_string();
		log_message('error', $heading.': '.$page);
	}

	$_error =& load_class('Exceptions', 'core');
	echo $_error->show_error($heading, $message, 'error_400', 400);
	exit(4); // EXIT_UNKNOWN_FILE
}


function show_403($page = '', $log_error = TRUE)
{
	if ( is_cli() )
	{
		$heading = '403 Access Denied';
		$message = 'You don\'t have permission to access.';
	}
	else
	{
		$heading = '403 Access Denied';
		$message = 'You don\'t have permission to access this page.';
	}

	// By default we log this, but allow a dev to skip it
	if ( $log_error )
	{
		$CI =& get_instance();
		$page = base_url().$CI->uri->uri_string();
		log_message('error', $heading.': '.$page);
	}

	$_error =& load_class('Exceptions', 'core');
	echo $_error->show_error($heading, $message, 'error_403', 403);
	exit(4); // EXIT_UNKNOWN_FILE
}