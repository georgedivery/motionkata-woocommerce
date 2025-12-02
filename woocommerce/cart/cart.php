<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.1.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<div class="wc-modern-cart">
	<div class="wc-modern-cart__grid">
		<div class="wc-modern-cart__column wc-modern-cart__column--items">
			<div class="wc-modern-cart__panel">
				<div class="wc-modern-cart__panel-head">
					<h3 class="wc-modern-cart__panel-title"><?php esc_html_e( 'Shopping cart', 'woocommerce' ); ?></h3>
				</div>
				<div class="wc-modern-cart__panel-body">
					<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
						<?php do_action( 'woocommerce_before_cart_table' ); ?>

						<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
							<thead>
								<tr>
									<th class="product-remove"><span class="screen-reader-text"><?php esc_html_e( 'Remove item', 'woocommerce' ); ?></span></th>
									<th class="product-thumbnail"><span class="screen-reader-text"><?php esc_html_e( 'Thumbnail image', 'woocommerce' ); ?></span></th>
									<th scope="col" class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
									<th scope="col" class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
									<th scope="col" class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
									<th scope="col" class="product-subtotal"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php do_action( 'woocommerce_before_cart_contents' ); ?>

								<?php
								foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
									$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
									$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
									/**
									 * Filter the product name.
									 *
									 * @since 2.1.0
									 * @param string $product_name Name of the product in the cart.
									 * @param array $cart_item The product in the cart.
									 * @param string $cart_item_key Key for the product in the cart.
									 */
									$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

									if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
										$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
										?>
										<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

											<td class="product-remove">
												<?php
													echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
														'woocommerce_cart_item_remove_link',
														sprintf(
															'<a role="button" href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
															esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
															/* translators: %s is the product name */
															esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
															esc_attr( $product_id ),
															esc_attr( $_product->get_sku() )
														),
														$cart_item_key
													);
												?>
											</td>

											<td class="product-thumbnail">
											<?php
											/**
											 * Filter the product thumbnail displayed in the WooCommerce cart.
											 *
											 * This filter allows developers to customize the HTML output of the product
											 * thumbnail. It passes the product image along with cart item data
											 * for potential modifications before being displayed in the cart.
											 *
											 * @param string $thumbnail     The HTML for the product image.
											 * @param array  $cart_item     The cart item data.
											 * @param string $cart_item_key Unique key for the cart item.
											 *
											 * @since 2.1.0
											 */
											$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

											if ( ! $product_permalink ) {
												echo $thumbnail; // PHPCS: XSS ok.
											} else {
												printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
											}
											?>
											</td>

											<td scope="row" role="rowheader" class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
											<?php
											if ( ! $product_permalink ) {
												echo wp_kses_post( $product_name . '&nbsp;' );
											} else {
												/**
												 * This filter is documented above.
												 *
												 * @since 2.1.0
												 */
												echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
											}

											do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

											// Meta data.
											echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

											// Backorder notification.
											if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
												echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
											}
											?>
											</td>

											<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
												<?php
													echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
												?>
											</td>

											<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
											<?php
											if ( $_product->is_sold_individually() ) {
												$min_quantity = 1;
												$max_quantity = 1;
											} else {
												$min_quantity = 0;
												$max_quantity = $_product->get_max_purchase_quantity();
											}

											$product_quantity = woocommerce_quantity_input(
												array(
													'input_name'   => "cart[{$cart_item_key}][qty]",
													'input_value'  => $cart_item['quantity'],
													'max_value'    => $max_quantity,
													'min_value'    => $min_quantity,
													'product_name' => $product_name,
												),
												$_product,
												false
											);

											echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
											?>
											</td>

											<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
												<?php
													echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
												?>
											</td>
										</tr>
										<?php
									}
								}
								?>

								<?php do_action( 'woocommerce_cart_contents' ); ?>

								<tr>
									<td colspan="6" class="actions">
										<button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

										<?php do_action( 'woocommerce_cart_actions' ); ?>

										<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
									</td>
								</tr>

								<?php do_action( 'woocommerce_after_cart_contents' ); ?>
							</tbody>
						</table>
						<?php do_action( 'woocommerce_after_cart_table' ); ?>
					</form>
				</div>
			</div>
		</div>

		<div class="wc-modern-cart__column wc-modern-cart__column--summary">
			<?php if ( wc_coupons_enabled() ) { ?>
				<div class="wc-modern-cart__panel wc-modern-cart__panel--coupon">
					<div class="wc-modern-cart__panel-head">
						<h3 class="wc-modern-cart__panel-title"><?php esc_html_e( 'Discount code', 'woocommerce' ); ?></h3>
					</div>
					<div class="wc-modern-cart__panel-body">
						<div class="wc-modern-cart__coupon-form">
							<input type="text" name="coupon_code" class="wc-modern-cart__coupon-input" id="cart_coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" />
							<button type="button" class="wc-modern-cart__coupon-button" id="apply_cart_coupon"><?php esc_html_e( 'Apply', 'woocommerce' ); ?></button>
							<div class="wc-modern-cart__coupon-feedback" id="cart_coupon_feedback"></div>
						</div>
						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					</div>
				</div>
			<?php } ?>

			<div class="wc-modern-cart__panel wc-modern-cart__panel--totals">
				<div class="wc-modern-cart__panel-head">
					<h3 class="wc-modern-cart__panel-title"><?php esc_html_e( 'Cart totals', 'woocommerce' ); ?></h3>
				</div>
				<div class="wc-modern-cart__panel-body">
					<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>
					<?php
						/**
						 * Cart collaterals hook.
						 *
						 * @hooked woocommerce_cross_sell_display
						 * @hooked woocommerce_cart_totals - 10
						 */
						do_action( 'woocommerce_cart_collaterals' );
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
jQuery(function($) {
	var $couponInput = $('#cart_coupon_code');
	var $applyButton = $('#apply_cart_coupon');
	var $feedback = $('#cart_coupon_feedback');
	var $cartForm = $('.woocommerce-cart-form');

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
		var $hiddenCouponInput = $cartForm.find('input[name="coupon_code"]');
		if ($hiddenCouponInput.length === 0) {
			$cartForm.append('<input type="hidden" name="coupon_code" value="' + couponCode + '" />');
		} else {
			$hiddenCouponInput.val(couponCode);
		}

		var formData = $cartForm.serialize() + '&apply_coupon=<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>';

		$.ajax({
			type: 'POST',
			url: wc_add_to_cart_params.ajax_url || '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>',
			data: formData + '&action=woocommerce_apply_coupon',
			success: function(response) {
				if (response && typeof response === 'object' && response.success) {
					$feedback.removeClass('is-error').addClass('is-success').text(response.data && response.data.message ? response.data.message : '<?php esc_html_e( 'Coupon applied successfully', 'woocommerce' ); ?>');
					$couponInput.val('');
					$('body').trigger('wc_fragment_refresh');
					location.reload();
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
				var formData2 = $cartForm.serialize() + '&apply_coupon=<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>';
				$.post($cartForm.attr('action'), formData2, function() {
					location.reload();
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
});
</script>

<?php do_action( 'woocommerce_after_cart' ); ?>
