    <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 

	<meta property="business:contact_data:street_address" content="STREET_ADDRESS"/>
	<meta property="business:contact_data:locality" content="CITY_NAME"/>
	<meta property="business:contact_data:postal_code" content="POSTAL_CODE"/>
	<meta property="business:contact_data:country_name" content="COUNTRY_NAME"/>
	<meta property="business:contact_data:email" content="YOUR@EMAIL.HERE"/>
	<meta property="business:contact_data:phone_number" content="08123456789"/>
	<meta property="business:contact_data:website" content="<?=$this->settings->website('web_url');?>"/>

	<meta property="og:type" content="website"/> <!-- option : article, website, blog, profile -->
	<meta property="og:title" content="<?=$this->meta_title;?>"/>
	<meta property="og:description" content="<?=$this->meta_description;?>"/>
	<meta property="og:image" content="<?=$this->meta_image;?>"/>
	<meta property="og:url" content="<?=site_url(uri_string());?>"/>
	<meta property="og:site_name" content="<?=$this->settings->website('web_name');?>"/>

	<meta property="fb:admins" content="FACEBOOK_ID"/>
	<meta property="profile:first_name" content="FACEBOOK_FIRST_NAME"/>
	<meta property="profile:last_name" content="FACEBOOK_LAST_NAME"/>
	<meta property="profile:username" content="FACEBOOK_USERNAME"/>
	
	<meta itemprop="name" content="<?=$this->meta_title;?>"/>
	<meta itemprop="description" content="<?=$this->meta_description;?>"/>
	<meta itemprop="image" content="<?=$this->meta_image;?>"/>

	<meta property="place:location:latitude" content="1234567890"/>
	<meta property="place:location:longitude" content="1234567890"/>
	