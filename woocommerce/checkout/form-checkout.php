<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Remove the default coupon toggle output; we'll render it in a custom panel.
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

$coupon_form_markup = '';
if ( wc_coupons_enabled() ) {
	ob_start();
	woocommerce_checkout_coupon_form();
	$coupon_form_markup = ob_get_clean();
}

?>

<?php if ( $coupon_form_markup ) : ?>
	<div class="wc-modern-checkout__coupon-hidden" aria-hidden="true">
		<?php echo $coupon_form_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
<?php endif; ?>

<form name="checkout" method="post" class="checkout woocommerce-checkout wc-modern-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">

	<div class="wc-modern-checkout__grid">
		<div class="wc-modern-checkout__column wc-modern-checkout__column--form">

			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<?php if ( $checkout->get_checkout_fields() ) : ?>
				<div class="wc-modern-checkout__panels" id="customer_details">
					<div class="wc-modern-checkout__panel">
						<div class="wc-modern-checkout__panel-head">
							<h3 class="wc-modern-checkout__panel-title"><?php esc_html_e( 'Contact information & billing', 'woocommerce' ); ?></h3>
						</div>

						<div class="wc-modern-checkout__panel-body">
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
						</div>
					</div>

					<div class="wc-modern-checkout__panel">
						<div class="wc-modern-checkout__panel-head">
							<h3 class="wc-modern-checkout__panel-title"><?php esc_html_e( 'Shipping address', 'woocommerce' ); ?></h3>
						</div>

						<div class="wc-modern-checkout__panel-body">
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

		</div>

		<div class="wc-modern-checkout__column wc-modern-checkout__column--summary">
			<?php if ( $coupon_form_markup ) : ?>
				<div class="wc-modern-checkout__panel wc-modern-checkout__panel--coupon" data-wc-modern-coupon-panel>
					<div class="wc-modern-checkout__panel-head">
						<h3 class="wc-modern-checkout__panel-title"><?php esc_html_e( 'Discount code', 'woocommerce' ); ?></h3>
					</div>

					<div class="wc-modern-checkout__panel-body">
						<p class="wc-modern-checkout__coupon-description">
							<?php echo esc_html( apply_filters( 'woocommerce_checkout_coupon_message', __( 'If you have a coupon code, please apply it below.', 'woocommerce' ) ) ); ?>
						</p>

						<div class="wc-modern-checkout__coupon-form">
							<label class="screen-reader-text" for="wc-modern-coupon-input"><?php esc_html_e( 'Coupon code', 'woocommerce' ); ?></label>
							<input type="text" class="input-text wc-modern-checkout__coupon-input" id="wc-modern-coupon-input" placeholder="<?php esc_attr_e( 'Enter coupon code', 'woocommerce' ); ?>" />
							<button type="button" class="button wc-modern-checkout__coupon-button" data-wc-modern-apply-coupon>
								<?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?>
							</button>
						</div>

						<div class="wc-modern-checkout__coupon-feedback" role="status" aria-live="polite"></div>
					</div>
				</div>
			<?php endif; ?>

			<div class="wc-modern-checkout__panel wc-modern-checkout__panel--summary">
				<div class="wc-modern-checkout__panel-head">
					<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
					<h3 id="order_review_heading" class="wc-modern-checkout__panel-title"><?php esc_html_e( 'Order summary', 'woocommerce' ); ?></h3>
				</div>

				<div class="wc-modern-checkout__panel-body">
					<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

					<div id="order_review" class="woocommerce-checkout-review-order">
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					</div>

					<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
				</div>
			</div>
		</div>
	</div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<?php if ( $coupon_form_markup ) : ?>
	<script>
	(function() {
		var customPanel = document.querySelector('[data-wc-modern-coupon-panel]');
		var hiddenContainer = document.querySelector('.wc-modern-checkout__coupon-hidden');
		var hiddenForm = hiddenContainer ? hiddenContainer.querySelector('form.checkout_coupon') : null;

		if (!customPanel || !hiddenForm) {
			return;
		}

		var input = customPanel.querySelector('.wc-modern-checkout__coupon-input');
		var button = customPanel.querySelector('[data-wc-modern-apply-coupon]');
		var feedback = customPanel.querySelector('.wc-modern-checkout__coupon-feedback');
		var hiddenInput = hiddenForm.querySelector('input[name="coupon_code"]');
		var hiddenButton = hiddenForm.querySelector('button[name="apply_coupon"]');
		var isSubmitting = false;

		if (!input || !button || !feedback || !hiddenInput || !hiddenButton) {
			return;
		}

		var defaultErrorMessage = '<?php echo esc_js( __( 'Coupon could not be applied.', 'woocommerce' ) ); ?>';
		var defaultSuccessMessage = '<?php echo esc_js( __( 'Coupon applied successfully.', 'woocommerce' ) ); ?>';

		button.addEventListener('click', function(event) {
			event.preventDefault();
			var code = input.value.trim();

			if (!code.length) {
				input.focus();
				feedback.textContent = defaultErrorMessage;
				feedback.classList.remove('is-success');
				feedback.classList.add('is-error');
				return;
			}

			isSubmitting = true;
			button.disabled = true;
			feedback.textContent = '';
			feedback.classList.remove('is-error', 'is-success');

			hiddenInput.value = code;
			hiddenButton.click();
		});

		function enableButton() {
			button.disabled = false;
			isSubmitting = false;
		}

		function getInsertedMessage() {
			if (!hiddenContainer) {
				return '';
			}

			var notice = hiddenContainer.querySelector('.woocommerce-message, .woocommerce-error, .woocommerce-info');
			if (!notice) {
				return '';
			}

			var text = notice.textContent ? notice.textContent.trim() : '';
			notice.remove();
			return text;
		}

		function getErrorNotice() {
			return hiddenForm.querySelector('.coupon-error-notice');
		}

		if (window.jQuery) {
			jQuery(function($) {
				$( document.body ).on('applied_coupon_in_checkout', function() {
					if (!isSubmitting) {
						return;
					}

					var errorNotice = getErrorNotice();
					var inlineMessage = errorNotice ? errorNotice.textContent.trim() : '';
					var insertedMessage = getInsertedMessage();

					enableButton();

					if (errorNotice) {
						errorNotice.remove();
						feedback.textContent = inlineMessage || insertedMessage || defaultErrorMessage;
						feedback.classList.remove('is-success');
						feedback.classList.add('is-error');
						return;
					}

					input.value = '';
					feedback.textContent = insertedMessage || defaultSuccessMessage;
					feedback.classList.remove('is-error');
					feedback.classList.add('is-success');
				});
			});
		}
	})();
	</script>
<?php endif; ?>
