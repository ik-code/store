<?php
/**
 * import.php
 *
 * Copyright (c) "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is provided subject to the license granted.
 * Unauthorized use and distribution is prohibited.
 * See COPYRIGHT.txt and LICENSE.txt
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package affiliates-users
 * @since affiliates-users 1.2.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !current_user_can( AFFILIATES_ADMINISTER_AFFILIATES ) ) {
	wp_die( __( 'Access denied.', AFFILIATES_USERS_PLUGIN_DOMAIN ) );
}

if ( isset( $_POST['action'] ) && wp_verify_nonce( $_POST['affiliates-users-import'], 'admin' ) ) {
	if ( $_POST['action'] == 'import' ) {
		$maximum = null;
		if ( !empty( $_REQUEST['maximum'] ) ) {
			$maximum = intval( $_REQUEST['maximum'] );
		}
		$affiliate_ids = Affiliates_Users::all( $maximum );
		$n = count( $affiliate_ids );
		if ( $n > 0 ) {
			echo '<p class="some">';
			echo sprintf( _n( 'One new affiliate account has been created.', '%d new affiliate accounts have been created.', $n, AFFILIATES_USERS_PLUGIN_DOMAIN ), $n );
			echo '</p>';
		} else {
			echo '<p class="none">';
			echo __( 'No new affiliate accounts have been created.', AFFILIATES_USERS_PLUGIN_DOMAIN );
			echo '</p>';
		}
	}
}
?>
<div class="import">
	<form name="import" method="post" action="">
		<div>
			<p>
				<?php esc_html_e( 'Press the import button to create affiliate accounts for all user accounts.', AFFILIATES_USERS_PLUGIN_DOMAIN ) ?>
			</p>
			<p>
				<label for="maximum"><?php esc_html_e( 'Maximum', AFFILIATES_USERS_PLUGIN_DOMAIN ); ?></label>
				<input type="number" name="maximum" placeholder="<?php esc_attr_e( 'unlimited', AFFILIATES_USERS_PLUGIN_DOMAIN ); ?>" value="<?php echo ( !empty( $_REQUEST['maximum'] ) ? max( 1, intval( $_REQUEST['maximum'] ) ) : '' ); ?>" />
				<?php esc_html_e( 'Allows to limit the number of users imported per batch.', AFFILIATES_USERS_PLUGIN_DOMAIN ); ?>
			</p>
			<?php wp_nonce_field( 'admin', 'affiliates-users-import', true, true ); ?>
			<p>
				<?php esc_html_e( 'The import will start immediately once you click the button.', AFFILIATES_USERS_PLUGIN_DOMAIN ); ?>
			</p>
			<p>
				<input class="import button" type="submit" name="submit" value="<?php echo __( 'Import', AFFILIATES_USERS_PLUGIN_DOMAIN ); ?>" />
				<input type="hidden" name="action" value="import" />
			</p>
		</div>
	</form>
</div>
