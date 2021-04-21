<?php
/**
 * class-affiliates-dashboard-login-shortcode.php
 *
 * Copyright (c) 2010 - 2018 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package affiliates
 * @since affiliates 4.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dashboard section: Login
 */
class Affiliates_Dashboard_Login_Shortcode extends Affiliates_Dashboard_Login {

	/**
	 * Initialization - adds the shortcode.
	 */
	public static function init() {
		add_shortcode( 'affiliates_dashboard_login', array( __CLASS__, 'shortcode' ) );
	}

	/**
	 * Shortcode handler for the section shortcode.
	 *
	 * @param array $atts shortcode attributes
	 * @param string $content not used
	 *
	 * @return string
	 */
	public static function shortcode( $atts, $content = '' ) {
		/**
		 * @var Affiliates_Dashboard_Login $section
		 */
		$section = Affiliates_Dashboard_Section_Factory::get_section_instance( Affiliates_Dashboard_Login::get_key() );
		ob_start();
		$section->render();
		$output = ob_get_clean();
		return $output;
	}

}
Affiliates_Dashboard_Login_Shortcode::init();
