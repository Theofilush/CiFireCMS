<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->CI->render_view('header');
?>
<div class="cols cols-full">
    <div class="colleft">
        <div class="page-404 box">
            <h1>
                <span>4</span>
                <i class="fa fa-frown-o"></i>
                <span>4</span>
            </h1>
            <p>Oops! Sorry this page doesn't exist. Back to home?</p>
            <a href="<?=site_url()?>" class="my-btn">TAKE ME HOME</a>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php $this->CI->render_view('footer'); ?>