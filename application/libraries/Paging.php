<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Class Paging
 * Original script from PopojiCMS
 * Edited by Adiman
*/

class Paging {

	public function posisi($batas, $halaman = '')  
	{
		$posisi = (empty($halaman) ? 0 : ($halaman-1) * $batas);
		return $posisi;
	}


	public function jml_halaman($data, $batas) 
	{
		$hasil = ceil($data/$batas);
		return $hasil;
	}


	public function link($halaman_aktif, $jml_halaman, $url, $title = '') 
	{
		$result_page = "";
		$num = 1;
		$title = empty($title) ? $title : $title.'/';
		$halaman_aktif = (empty($halaman_aktif) ? '1' : $halaman_aktif);

		if ($halaman_aktif > 1) 
		{
			$prev = $halaman_aktif-1;
			$result_page.= '<li class="page-item"><a class="page-link" href="'.$url.'/'.$title.$prev.'">Previous</a></li>';
		} 
		else 
		{
			$result_page.= '<li class="page-item disabled"><a class="page-link">Previous</a></li>';
		}
		
		$number = ($halaman_aktif > 3 ? '<li class="page-item"><a class="page-link" href="'.$url.'/'.$title.'1">1</a><li class="page-item disabled"><a class="page-link">...</a></li>' : " ");
		
		for ($i=$halaman_aktif-2; $i<$halaman_aktif; $i++) 
		{
			if ($i < 1) continue;
			$number .= '<li class="page-item"><a class="page-link" href="'.$url.'/'.$title.$i.'">'.$i.'</a></li>';
		}

		$number .= "<li class='page-item active'><a class='page-link'>$halaman_aktif</a></li>";
		
		//$UL.= '<li class="active"><a>'.$halaman_aktif.'</a></li>';

		for ($i = $halaman_aktif + 1; $i < ($halaman_aktif + 3); $i++)  
		{
			if ($i > $jml_halaman) break;
			$number .= '<li class="page-item"><a class="page-link" href="'.$url.'/'.$title.$i.'">'.$i.'</a></li>';
		}

		$number .= ($halaman_aktif + 2 < $jml_halaman ? '<li class="page-item disabled"><a class="page-link">...</a></li><li class="page-item"><a class="page-link" href="'.$url.'/'.$title.$jml_halaman.'">'.$jml_halaman.'</a></li>' : " ");

		$result_page .= $number;
		
		if ($halaman_aktif < $jml_halaman) 
		{
			$next = $halaman_aktif + 1;
			$result_page .= '<li class="page-item"><a class="page-link" href="'.$url.'/'.$title.$next.'">Next</a></li>';
		} 
		else 
		{
			$result_page .= '<li class="page-item disabled"><a class="page-link">Next</a></li>';
		}

		return $result_page;
	}


	public function alink($halaman_aktif, $jml_halaman, $url, $title = '') 
	{
		$result_page = "";
		$num = 1;
		$title = !empty($title) ? $title : '';
		$halaman_aktif = (empty($halaman_aktif) ? '1' : $halaman_aktif);

		if ($halaman_aktif > 1) 
		{
			$prev = $halaman_aktif-1;
			$result_page.= '<li class="page-item"><a class="page-link" href="'.$url.$title.'&page='.$prev.'">Previous</a></li>';
		} 
		else 
		{
			$result_page.= '<li class="page-item disabled"><a class="page-link">Previous</a></li>';
		}
		
		$number = ($halaman_aktif > 3 ? '<li class="page-item"><a class="page-link" href="'.$url.$title.'&page=1">1</a><li class="page-item disabled"><a class="page-link">...</a></li>' : " ");
		
		for ($i=$halaman_aktif-2; $i<$halaman_aktif; $i++) 
		{
			if ($i < 1) continue;
			$number .= '<li class="page-item"><a class="page-link" href="'.$url.$title.'&page='.$i.'">'.$i.'</a></li>';
		}

		$number .= "<li class='page-item active'><a class='page-link'>$halaman_aktif</a></li>";

		for ($i = $halaman_aktif + 1; $i < ($halaman_aktif + 3); $i++)  
		{
			if ($i > $jml_halaman) break;
			$number .= '<li class="page-item"><a class="page-link" href="'.$url.$title.'&page='.$i.'">'.$i.'</a></li>';
		}

		$number .= ($halaman_aktif + 2 < $jml_halaman ? '<li class="page-item"><a class="page-link">...</a></li><li class="page-item"><a class="page-link" href="'.$url.$title.'&page='.$jml_halaman.'">'.$jml_halaman.'</a></li>' : " ");

		$result_page .= $number;
		
		if ($halaman_aktif < $jml_halaman) 
		{
			$next = $halaman_aktif + 1;
			$result_page .= '<li class="page-item"><a class="page-link" href="'.$url.$title.'&page='.$next.'">Next</a></li>';
		} 
		else 
		{
			$result_page .= '<li class="page-item disabled"><a class="page-link">Next</a></li>';
		}

		return $result_page;
	}
} // End Class.