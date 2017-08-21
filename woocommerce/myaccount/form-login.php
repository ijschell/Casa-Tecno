<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="u-columns col2-set" id="customer_login">

	<div class="u-column1 col-1">

		<?php endif; ?>

		<h2><?php echo esc_html__( 'Login', 'smarket' ); ?></h2>

		<form class="woocomerce-form woocommerce-form-login login" method="post">
            <p class="text-login woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <span><?php echo esc_html__('Hello, Welcome to your account.','smarket'); ?></span>
            </p>
			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username"><?php echo esc_html__( 'Username or email address', 'smarket' ); ?> <span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''; ?>" />
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password"><?php echo esc_html__( 'Password', 'smarket' ); ?> <span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" />
			</p>
			<p class="form-row-first remember_me">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php echo esc_html__( 'Remember me', 'smarket' ); ?></span>
				</label>
			</p>
			<p class="form-row-last woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php echo esc_html__( 'Lost your password?', 'smarket' ); ?></a>
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<input type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Login', 'smarket' ); ?>" />
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

		<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	</div>

	<div class="u-column2 col-2">

		<h2><?php echo esc_html__( 'Register', 'smarket' ); ?></h2>

		<form method="post" class="register">
            <p class="text-login woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <span><?php echo esc_html__('Create your own Unicase account.','smarket'); ?></span>
            </p>
			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_username"><?php _e( 'Username', 'smarket' ); ?> <span class="required">*</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''; ?>" />
				</p>

			<?php endif; ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="reg_email"><?php echo esc_html__( 'Email address', 'smarket' ); ?> <span class="required">*</span></label>
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( $_POST['email'] ) : ''; ?>" />
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_password"><?php echo esc_html__( 'Password', 'smarket' ); ?> <span class="required">*</span></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" />
				</p>

			<?php endif; ?>

			<!-- Spam Trap -->
			<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php echo esc_html__( 'Anti-spam', 'smarket' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" autocomplete="off" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>

			<p class="woocomerce-FormRow form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<input type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Sign Up', 'smarket' ); ?>" />
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>
			<div class="banner-account">
				<h3 class="title"><?php echo esc_html__('Sign Up Today And You\'ll Be Able To :','smarket'); ?></h3>
                <ul>
                    <li><i class="fa fa-check-square-o" aria-hidden="true"></i><span><?php echo esc_html__('Speed your way through the checkout.','smarket'); ?></span></li>
                    <li><i class="fa fa-check-square-o" aria-hidden="true"></i><span><?php echo esc_html__('Track your orders easily.','smarket'); ?></span></li>
                    <li><i class="fa fa-check-square-o" aria-hidden="true"></i><span><?php echo esc_html__('Keep a record of all your purchases.','smarket'); ?></span></li>
                </ul>
			</div>
		</form>

	</div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
