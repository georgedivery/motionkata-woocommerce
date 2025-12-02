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

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout wc-modern-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">

	<div class="wc-modern-checkout__grid">
		<div class="wc-modern-checkout__column">
			<?php if ( $checkout->get_checkout_fields() ) : ?>

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<div class="col2-set" id="customer_details">
					<div class="">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div>
					<?php if ( WC()->cart->needs_shipping() && ! wc_ship_to_billing_address_only() ) : ?>
						<br>
						<div class="">
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
						</div>
					<?php endif; ?>
					
					<?php do_action( 'woocommerce_checkout_before_order_notes', $checkout ); ?>
					
					<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>
						<br>
						<div class="woocommerce-additional-fields">
							<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>
								<h3><?php esc_html_e( 'Additional information', 'woocommerce' ); ?></h3>
							<?php endif; ?>
							
							<div class="woocommerce-additional-fields__field-wrapper">
								<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
									<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
					
					<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
					
					<?php do_action( 'woocommerce_checkout_terms_and_conditions' ); ?>
				</div>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

			<?php endif; ?>
		</div>

		<div class="wc-modern-checkout__column">
			<?php if ( wc_coupons_enabled() ) { ?>
				<div class="wc-modern-checkout__panel wc-modern-checkout__panel--coupon">
					<div class="wc-modern-checkout__panel-head">
						<h3 class="wc-modern-checkout__panel-title"><?php esc_html_e( 'Код за отстъпка', 'woocommerce' ); ?></h3>
					</div>
					<div class="wc-modern-checkout__panel-body">
						<div class="wc-modern-checkout__coupon-form">
							<input type="text" name="coupon_code" class="wc-modern-checkout__coupon-input" id="checkout_coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" />
							<button type="button" class="wc-modern-checkout__coupon-button" id="apply_checkout_coupon"><?php esc_html_e( 'Apply', 'woocommerce' ); ?></button>
							<div class="wc-modern-checkout__coupon-feedback" id="checkout_coupon_feedback"></div>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
			
			<div class="wc-modern-checkout__panel wc-modern-checkout__panel--summary">
				<div class="wc-modern-checkout__panel-head">
					<h3 class="wc-modern-checkout__panel-title" id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
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

<script>
jQuery(function($) {
	var $couponInput = $('#checkout_coupon_code');
	var $applyButton = $('#apply_checkout_coupon');
	var $feedback = $('#checkout_coupon_feedback');
	var $checkoutForm = $('form.checkout');

	$applyButton.on('click', function(e) {
		e.preventDefault();
		var couponCode = $couponInput.val().trim();

		if (!couponCode) {
			$feedback.removeClass('is-success').addClass('is-error').text('<?php esc_attr_e( 'Please enter a coupon code', 'woocommerce' ); ?>');
			return;
		}

		$applyButton.prop('disabled', true).text('<?php esc_attr_e( 'Applying...', 'woocommerce' ); ?>');
		$feedback.removeClass('is-error is-success').text('');

		// Add coupon code to form and submit
		var $hiddenCouponInput = $checkoutForm.find('input[name="coupon_code"]');
		if ($hiddenCouponInput.length === 0) {
			$checkoutForm.append('<input type="hidden" name="coupon_code" value="' + couponCode + '" />');
		} else {
			$hiddenCouponInput.val(couponCode);
		}

		var formData = $checkoutForm.serialize() + '&apply_coupon=<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>';

		$.ajax({
			type: 'POST',
			url: wc_add_to_cart_params.ajax_url || '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>',
			data: formData + '&action=woocommerce_apply_coupon',
			success: function(response) {
				if (response && typeof response === 'object' && response.success) {
					$feedback.removeClass('is-error').addClass('is-success').text(response.data && response.data.message ? response.data.message : '<?php esc_html_e( 'Coupon applied successfully', 'woocommerce' ); ?>');
					$couponInput.val('');
					$('body').trigger('update_checkout');
				} else {
					var errorMsg = '<?php esc_attr_e( 'Invalid coupon code', 'woocommerce' ); ?>';
					if (response && response.data && response.data.message) {
						errorMsg = response.data.message;
					}
					$feedback.removeClass('is-success').addClass('is-error').text(errorMsg);
				}
			},
			error: function() {
				// Fallback to form submission
				var formData2 = $checkoutForm.serialize() + '&apply_coupon=<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>';
				$.post($checkoutForm.attr('action'), formData2, function() {
					$('body').trigger('update_checkout');
				});
			},
			complete: function() {
				$applyButton.prop('disabled', false).text('<?php esc_attr_e( 'Apply', 'woocommerce' ); ?>');
			}
		});
	});

	$couponInput.on('keypress', function(e) {
		if (e.which === 13) {
			e.preventDefault();
			$applyButton.trigger('click');
		}
	});

	// Remove duplicate terms and conditions wrappers, keep only the one in customer_details
	var $termsWrappers = $('.woocommerce-terms-and-conditions-wrapper');
	if ($termsWrappers.length > 1) {
		$termsWrappers.not('#customer_details .woocommerce-terms-and-conditions-wrapper').remove();
	}
});
</script>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
