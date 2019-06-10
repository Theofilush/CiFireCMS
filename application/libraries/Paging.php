<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
			$result_page.= '<li><a href="'.$url.'/'.$title.$prev.'">Previous</a></li>';
		} 
		else 
		{
			$result_page.= '<li class="disabled"><a>Previous</a></li>';
		}
		
		$number = ($halaman_aktif > 3 ? '<li><a href="'.$url.'/'.$title.'1">1</a><li class="disabled"><a>...</a></li>' : " ");
		
		for ($i=$halaman_aktif-2; $i<$halaman_aktif; $i++) 
		{
			if ($i < 1) continue;
			$number .= '<li><a href="'.$url.'/'.$title.$i.'">'.$i.'</a></li>';
		}

		$number .= "<li class='active'><a>$halaman_aktif</a></li>";
		
		//$UL.= '<li class="active"><a>'.$halaman_aktif.'</a></li>';

		for ($i = $halaman_aktif + 1; $i < ($halaman_aktif + 3); $i++)  
		{
			if ($i > $jml_halaman) break;
			$number .= '<li><a href="'.$url.'/'.$title.$i.'">'.$i.'</a></li>';
		}

		$number .= ($halaman_aktif + 2 < $jml_halaman ? '<li class="disabled"><a>...</a></li><li><a href="'.$url.'/'.$title.$jml_halaman.'">'.$jml_halaman.'</a></li>' : " ");

		$result_page .= $number;
		
		if ($halaman_aktif < $jml_halaman) 
		{
			$next = $halaman_aktif + 1;
			$result_page .= '<li><a href="'.$url.'/'.$title.$next.'">Next</a></li>';
		} 
		else 
		{
			$result_page .= '<li class="disabled"><a>Next</a></li>';
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
			$result_page.= '<li><a href="'.$url.$title.'&page='.$prev.'">Previous</a></li>';
		} 
		else 
		{
			$result_page.= '<li class="disabled"><a>Previous</a></li>';
		}
		
		$number = ($halaman_aktif > 3 ? '<li><a href="'.$url.$title.'&page=1">1</a><li class="disabled"><a>...</a></li>' : " ");
		
		for ($i=$halaman_aktif-2; $i<$halaman_aktif; $i++) 
		{
			if ($i < 1) continue;
			$number .= '<li><a href="'.$url.$title.'&page='.$i.'">'.$i.'</a></li>';
		}

		$number .= "<li class='active'><a>$halaman_aktif</a></li>";
		
		//$UL.= '<li class="active"><a>'.$halaman_aktif.'</a></li>';

		for ($i = $halaman_aktif + 1; $i < ($halaman_aktif + 3); $i++)  
		{
			if ($i > $jml_halaman) break;
			$number .= '<li><a href="'.$url.$title.'&page='.$i.'">'.$i.'</a></li>';
		}

		$number .= ($halaman_aktif + 2 < $jml_halaman ? '<li class="disabled"><a>...</a></li><li><a href="'.$url.$title.'&page='.$jml_halaman.'">'.$jml_halaman.'</a></li>' : " ");

		$result_page .= $number;
		
		if ($halaman_aktif < $jml_halaman) 
		{
			$next = $halaman_aktif + 1;
			$result_page .= '<li><a href="'.$url.$title.'&page='.$next.'">Next</a></li>';
		} 
		else 
		{
			$result_page .= '<li class="disabled"><a>Next</a></li>';
		}

		return $result_page;
	}

} // End Class.