<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->CI->render_view('header');
?>
<div class="cols cols-full">
    <div class="colleft">
        <div class="box">
            <article class="detail">
                <h1><?=$res['title'];?></h1>
                <hr>
                <div class="detail-content">
                    <?=html_entity_decode($res['content']);?>
                </div>
            </article>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php $this->CI->render_view('footer'); ?>