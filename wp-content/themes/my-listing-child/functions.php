<?php
/**
 * Function PHP
 *
 * @package FindVC.
 */

/**
 * Init scripts
 */

function init() {
	wp_register_script( 'get-ajax', get_stylesheet_directory_uri() . '/findvc-dashboard/assets/js/ajax-pages-dashboard.js', '', '', true );

	wp_localize_script( 'get-ajax', 'dcms_vars', array( 'url' => admin_url( 'admin-ajax.php' ) ,
	'hook' => 'get_pages_dashboard' ,
	'nonce' => wp_create_nonce("vc-dashboard-founder")) );

	wp_enqueue_script( array( 'jquery', 'get-ajax'  ) );
}
add_action( 'wp_enqueue_scripts', 'init' );

/**
 * Global VARS
 */
define( 'DIR_TEMPLATE', get_stylesheet_directory_uri() );
define( 'DIR_TEMPLATE_ROOT', get_stylesheet_directory() );
define( 'GET_DIR', DIR_TEMPLATE . '/findvc-dashboard/' );
define( 'GET_INC', GET_DIR . 'inc/' );
define( 'GET_SRC', GET_DIR . 'src/' );
define( 'GET_IMG', GET_SRC . 'img/' );
define( 'GET_FOUNDER', GET_DIR . 'templates/founder/' );
define( 'GET_DIRECTORY', __DIR__ );
define( 'GET_DASH', GET_DIRECTORY . '/findvc-dashboard/' );
define( 'GET_DASH_SRC', GET_DASH . 'src/' );
define( 'GET_DASH_CSS', GET_DASH_SRC . 'css/' );

/**
 * Require all files in a directory.
 *
 * @param String $path The path to the directory (with trailing slash).
 */
function require_all() {
	$listOfDirectories = scandir( GET_DASH_CSS );
	$listOfCss         = array_diff( $listOfDirectories, array( '.', '..' ) );
	foreach ( $listOfCss as $index => $css ) {
		$name = str_replace( '.css', '', $css );
		wp_enqueue_style( $name, GET_SRC . "css/{$css}", array() );
	}
}


add_action( 'wp_enqueue_scripts', 'require_all' );

/**
 * Import PHP files from ./lib/ directory
 */
// require_all( DIR_TEMPLATE_ROOT . '/findvc-dashboard/src/css/' );

// Enqueue child theme style.css
add_action(
	'wp_enqueue_scripts',
	function() {
		wp_enqueue_style( 'child-style', get_stylesheet_uri() );
		if ( is_rtl() ) {
			wp_enqueue_style( 'mylisting-rtl', get_template_directory_uri() . '/rtl.css', array(), wp_get_theme()->get( 'Version' ) );

		}
	},
	500
);

function tailwind_init() {
	wp_enqueue_style( 'tailwind', 'https://cdn.tailwindcss.com', '', wp_get_theme()->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'tailwind_init' );

function custom_admin_js() {
	?> 
<script>
	document.addEventListener("DOMContentLoaded", function(event) { 
		const options = document.querySelectorAll(`li.select2-results__option`)
		const option = options.find( opt => opt.innerHTML == "£1.5m – £5m" )
		if (option) {
			option.parentElement.appendChild(option)
		}
	});
</script>
	<?php
}
add_action( 'admin_footer', 'custom_admin_js' );


function json_test() {
	$getContent = file_get_contents( get_stylesheet_directory() . '/json/founders.json' );
	$founders   = json_decode( $getContent );
	$html       = '';
	foreach ( $founders as $key => $founder ) {
		$html .= "<p>{$founder->investment_partner_name}</p>";
	}
	check_ajax_referer('vc-login', 'security');

	function founder__menu() {
		register_nav_menus(
			array(
				'founder_menu' => __( 'Founder Dashboard Menu', 'findvc' ),
			)
		);
	}
	add_action( 'after_setup_theme', 'founder__menu', 0 );
}


/**
 * Add margin current user login
 */
function add_margin() {
	if ( is_user_logged_in() ) {
		echo '<style>body{margin-top:32px;}</style>';
	}
}

function get_pages_dashboard() {
	check_ajax_referer('vc-dashboard-founder', 'security');
	$template = $_POST['template'];
	if ('founder-shortlist' == $template){
		echo get_template_part( 'findvc-dashboard/templates/founder/dashboard-fc__shortlist' );
	}
	die;
}
add_action( 'wp_ajax_nopriv_get_pages_dashboard', 'get_pages_dashboard' );
add_action( 'wp_ajax_get_pages_dashboard', 'get_pages_dashboard' );

add_action( 'wp_footer', 'add_margin' );

