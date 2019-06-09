<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function delete_folder($path) {
	if (!file_exists($path))
		return false;

	if (is_file($path) || is_link($path))
		return unlink($path);

	$stack = array($path);

	while ($entry = array_pop($stack)) {
		if (is_link($entry)) {
			unlink($entry);
			continue;
		}

		if (@rmdir($entry)) continue;

		$stack[] = $entry;
		$dh = opendir($entry);

		while(false !== $child = readdir($dh)) {
			if ($child === '.' || $child === '..') continue;

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


function cdb($conf) {
	$db_host  = $conf['db_host'];
	$db_name  = $conf['db_name'];
	$db_user  = $conf['db_user'];
	$db_pass  = $conf['db_pass'];

$content = <<<EOS
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

\$active_group = 'default';
\$query_builder = TRUE;

\$db['default'] = array(
	'dsn'	   => 'mysql:host={$db_host}; dbname={$db_name}; charset=utf8;',
	'hostname' => '{$db_host}',
	'username' => '{$db_user}',
	'password' => '{$db_pass}',
	'database' => '{$db_name}',
	'dbdriver' => 'pdo',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt'  => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

\$db['mysqli'] = array(
	'hostname' => '{$db_host}',
	'username' => '{$db_user}',
	'password' => '{$db_pass}',
	'database' => '{$db_name}',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt'  => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
EOS;
return $content;
}


function cfile($data) {
	$base_url = $data['site_url'];
	$en_key   = $data['key'];
	$db_host  = $data['db_host'];
	$db_name  = $data['db_name'];
	$db_user  = $data['db_user'];
	$db_pass  = $data['db_pass'];
$content = <<<EOS
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

@\$config['base_url']               = ((isset(\$_SERVER['HTTPS']) && \$_SERVER['HTTPS'] == "on") ? "https" : "http");
@\$config['base_url']              .= "://" . \$_SERVER['HTTP_HOST'];
@\$config['base_url']              .= str_replace(basename(\$_SERVER['SCRIPT_NAME']), "", \$_SERVER['SCRIPT_NAME']);

\$config['index_page']              = '';
\$config['uri_protocol']            = 'REQUEST_URI';
\$config['url_suffix']              = '';
\$config['language']                = '';
\$config['charset']                 = 'UTF-8';
\$config['enable_hooks']            = FALSE;
\$config['subclass_prefix']         = 'MY_';
\$config['composer_autoload']       = FALSE;
\$config['permitted_uri_chars']     = 'a-z 0-9~%.:_-';
\$config['enable_query_strings']    = FALSE;
\$config['controller_trigger']      = 'c';
\$config['function_trigger']        = 'm';
\$config['directory_trigger']       = 'd';
\$config['allow_get_array']         = TRUE;
\$config['log_threshold']           = 0;
\$config['log_path']                = '';
\$config['log_file_extension']      = '';
\$config['log_file_permissions']    = 0644;
\$config['log_date_format']         = 'Y-m-d H:i:s';
\$config['error_views_path']        = '';
\$config['cache_path']              = '';
\$config['cache_query_string']      = FALSE;
\$config['encryption_key']          = hex2bin('{$en_key}');
\$config['sess_driver']             = '';
\$config['sess_cookie_name']        = md5('{$en_key}');
\$config['sess_expiration']         = 7200;
\$config['sess_save_path']          = NULL;
\$config['sess_match_ip']           = FALSE;
\$config['sess_time_to_update']     = 300;
\$config['sess_regenerate_destroy'] = FALSE;
\$config['cookie_prefix']           = '';
\$config['cookie_domain']           = '';
\$config['cookie_path']             = '/';
\$config['cookie_secure']           = FALSE;
\$config['cookie_httponly']         = FALSE;
\$config['standardize_newlines']    = FALSE;
\$config['global_xss_filtering']    = FALSE;
\$config['csrf_protection']         = FALSE;
\$config['csrf_token_name']         = 'csrf_name';
\$config['csrf_cookie_name']        = 'csrf_cookie_name';
\$config['csrf_expire']             = 7200;
\$config['csrf_regenerate']         = FALSE;
\$config['csrf_exclude_uris']       = array();
\$config['compress_output']         = FALSE;
\$config['time_reference']          = 'local';
\$config['rewrite_short_tags']      = TRUE;
\$config['proxy_ips']               = '';
EOS;
return $content;
}


function cindex() {
$content = <<< EOS
<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
*/

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
*/
define('ENVIRONMENT', isset(\$_SERVER['CI_ENV']) ? \$_SERVER['CI_ENV'] : 'development');

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
*/
switch (ENVIRONMENT)
{
	case 'development':
		error_reporting(-1);
		error_reporting(E_ALL ^ E_DEPRECATED);
		ini_set('display_errors', 1);

	break;

	case 'testing':
	case 'production':
		ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>='))
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		}
		else
		{
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		}
	break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_ERROR
}

/*
 *---------------------------------------------------------------
 * SYSTEM DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" directory.
 * Set the path if it is not in the same directory as this file.
*/
\$system_path = 'system';

/*
 *---------------------------------------------------------------
 * APPLICATION DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * directory than the default one you can set its name here. The directory
 * can also be renamed or relocated anywhere on your server. If you do,
 * use an absolute (full) server path.
 * For more info please see the user guide:
 *
 * https://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
*/
\$application_folder = 'application';

/*
 *---------------------------------------------------------------
 * VIEW DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * If you want to move the view directory out of the application
 * directory, set the path to it here. The directory can be renamed
 * and relocated anywhere on your server. If blank, it will default
 * to the standard location inside your application directory.
 * If you do move this, use an absolute (full) server path.
 *
 * NO TRAILING SLASH!
*/
\$view_folder = '';

/*
 *---------------------------------------------------------------
 * CUSTOM ADMINISTRATOR DIRECTORY & NAME
 *---------------------------------------------------------------
 *
 * If you want to move the view directory out of the application
 * directory, set the path to it here. The directory can be renamed
 * and relocated anywhere on your server. If blank, it will default
 * to the standard location inside your application directory.
 * If you do move this, use an absolute (full) server path.
 *
 * NO TRAILING SLASH!
*/
\$admin_folder = 'l-admin';

/*
 *---------------------------------------------------------------
 * CUSTOM CONTENT DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * NO TRAILING SLASH!
*/
\$content_folder = 'content';

/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normally you will set your default controller in the routes.php file.
 * You can, however, force a custom routing by hard-coding a
 * specific controller class/function here. For most applications, you
 * WILL NOT set your routing here, but it's an option for those
 * special instances where you might want to override the standard
 * routing in a specific front controller that shares a common CI installation.
 *
 * IMPORTANT: If you set the routing here, NO OTHER controller will be
 * callable. In essence, this preference limits your application to ONE
 * specific controller. Leave the function name blank if you need
 * to call functions dynamically via the URI.
 *
 * Un-comment the \$routing array below to use this feature
*/
	// The directory name, relative to the "controllers" directory.  Leave blank
	// if your controller is not in a sub-directory within the "controllers" one
	// \$routing['directory'] = '';

	// The controller class file name.  Example:  mycontroller
	// \$routing['controller'] = '';

	// The controller function you wish to be called.
	// \$routing['function']	= '';


/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 *
 * The \$assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config
 * items or override any default config values found in the config.php file.
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different
 * config values.
 *
 * Un-comment the \$assign_to_config array below to use this feature
*/
	// \$assign_to_config['name_of_config_item'] = 'value of config item';



// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
*/

// Set the current directory correctly for CLI requests
if (defined('STDIN'))
{
	chdir(dirname(__FILE__));
}

if ((\$_temp = realpath(\$system_path)) !== FALSE)
{
	\$system_path = \$_temp.DIRECTORY_SEPARATOR;
}
else
{
	// Ensure there's a trailing slash
	\$system_path = strtr(
		rtrim(\$system_path, '/\\\'),
		'/\\\',
		DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
	).DIRECTORY_SEPARATOR;
}

// Is the system path correct?
if ( ! is_dir(\$system_path))
{
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
	exit(3); // EXIT_CONFIG
}

// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// Path to the system directory
define('BASEPATH', \$system_path);

// Path to the front controller (this file) directory
define('FCPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

// Name of the "system" directory
define('SYSDIR', basename(BASEPATH));

// The path to the "application" directory
if (is_dir(\$application_folder))
{
	if ((\$_temp = realpath(\$application_folder)) !== FALSE)
	{
		\$application_folder = \$_temp;
	}
	else
	{
		\$application_folder = strtr(
			rtrim(\$application_folder, '/\\\'),
			'/\\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		);
	}
}
elseif (is_dir(BASEPATH.\$application_folder.DIRECTORY_SEPARATOR))
{
	\$application_folder = BASEPATH.strtr(
		trim(\$application_folder, '/\\\'),
		'/\\\',
		DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
	);
}
else
{
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
	exit(3); // EXIT_CONFIG
}

define('APPPATH', \$application_folder.DIRECTORY_SEPARATOR);

// The path to the "views" directory
if ( ! isset(\$view_folder[0]) && is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR))
{
	\$view_folder = APPPATH.'views';
}
elseif (is_dir(\$view_folder))
{
	if ((\$_temp = realpath(\$view_folder)) !== FALSE)
	{
		\$view_folder = \$_temp;
	}
	else
	{
		\$view_folder = strtr(
			rtrim(\$view_folder, '/\\\'),
			'/\\\',
			DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
		);
	}
}
elseif (is_dir(APPPATH.\$view_folder.DIRECTORY_SEPARATOR))
{
	\$view_folder = APPPATH.strtr(
		trim(\$view_folder, '/\\\'),
		'/\\\',
		DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
	);
}
else
{
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
	exit(3); // EXIT_CONFIG
}

define('VIEWPATH', \$view_folder.DIRECTORY_SEPARATOR);

// Custom path
define('CONTENTPATH', \$content_folder.DIRECTORY_SEPARATOR);
define('FCONTENT', \$content_folder);
define('FADMIN', \$admin_folder);

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
*/
require_once BASEPATH.'core/CodeIgniter.php';
EOS;
return $content;
}