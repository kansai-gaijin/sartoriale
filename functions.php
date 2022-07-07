<?php

/*
 |------------------------------------------------------------------
 | Bootstraping a Theme
 |------------------------------------------------------------------
 |
 | This file is responsible for bootstrapping your theme. Autoloads
 | composer packages, checks compatibility and loads theme files.
 | Most likely, you don't need to change anything in this file.
 | Your theme custom logic should be distributed across a
 | separated components in the `/app` directory.
 |
 */

// Require Composer's autoloading file
// if it's present in theme directory.
if (file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
	require $composer;
}

// Before running we need to check if everything is in place.
// If something went wrong, we will display friendly alert.
$ok = require_once __DIR__ . '/bootstrap/compatibility.php';

if ($ok) {
	// Now, we can bootstrap our theme.
	$theme = require_once __DIR__ . '/bootstrap/theme.php';

	// Autoload theme. Uses localize_template() and
	// supports child theme overriding. However,
	// they must be under the same dir path.
	(new Tonik\Gin\Foundation\Autoloader($theme->get('config')))->register();
}

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
/**
 * Add our own action to the woocommerce_before_shop_loop_item_title hook with the same priority that woocommerce used
 */
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

/**
 * WooCommerce Loop Product Thumbs
 */
if (!function_exists('woocommerce_template_loop_product_thumbnail')) {
	/**
	 * echo thumbnail HTML
	 */
	function woocommerce_template_loop_product_thumbnail()
	{
		echo woocommerce_get_product_thumbnail();
	}
}

/**
 * WooCommerce Product Thumbnail
 */
if (!function_exists('woocommerce_get_product_thumbnail')) {

	/**
	 * @param string $size
	 * @param int $placeholder_width
	 * @param int $placeholder_height
	 * @return string
	 */
	function woocommerce_get_product_thumbnail($size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0)
	{
		global $post, $woocommerce;

		//NOTE: those are PHP 7 ternary operators. Change to classic if/else if you need PHP 5.x support.
		$placeholder_width = !$placeholder_width ?
			wc_get_image_size('shop_catalog_image_width')['width'] :
			$placeholder_width;

		$placeholder_height = !$placeholder_height ?
			wc_get_image_size('shop_catalog_image_height')['height'] :
			$placeholder_height;

		/**
		 * EDITED HERE: here I added a div around the <img> that will be generated
		 */
		$output = '<div class="my-3">';

		/**
		 * This outputs the <img> or placeholder image. 
		 * it's a lot better to use get_the_post_thumbnail() that hardcoding a text <img> tag
		 * as wordpress wil add many classes, srcset and stuff.
		 */
		$output .= has_post_thumbnail() ?
			get_the_post_thumbnail($post->ID, 'full') :
			'<img class="w-full" src="' . wc_placeholder_img_src() . '" alt="Placeholder" width="' . $placeholder_width . '" height="' . $placeholder_height . '" />';

		/**
		 * Close added div .my_new_wrapper
		 */
		$output .= '</div>';

		return $output;
	}
}

add_filter('woocommerce_product_tabs', '__return_empty_array', 98);




/**
 * @snippet       WooCommerce Product Reviews Shortcode
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 3.9
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

add_shortcode('product_reviews', 'bbloomer_product_reviews_shortcode');

function bbloomer_product_reviews_shortcode($atts)
{

	if (empty($atts)) return '';

	if (!isset($atts['id'])) return '';

	$comments = get_comments('post_id=' . $atts['id']);

	if (!$comments) return '';

	$html .= '<div class="woocommerce-tabs"><div id="reviews"><ol class="commentlist">';

	foreach ($comments as $comment) {
		$rating = intval(get_comment_meta($comment->comment_ID, 'rating', true));
		$html .= '<li class="review">';
		$html .= get_avatar($comment, '60');
		$html .= '<div class="comment-text">';
		if ($rating) $html .= wc_get_rating_html($rating);
		$html .= '<p class="meta"><strong class="woocommerce-review__author">';
		$html .= get_comment_author($comment);
		$html .= '</strong></p>';
		$html .= '<div class="description">';
		$html .= $comment->comment_content;
		$html .= '</div></div>';
		$html .= '</li>';
	}

	$html .= '</ol></div></div>';

	return $html;
}



// REGISTRATION SHORTCODE
function wc_registration_form_function()
{
	if (is_admin()) return;
	if (is_user_logged_in()) return;

	ob_start();

	do_action('woocommerce_before_customer_login_form');

?>

	<form method="post" class="reg-form" <?php do_action('woocommerce_register_form_tag'); ?>>
		<h2>新規会員登録</h2>
		<?php do_action('woocommerce_register_form_start'); ?>

		<p class="form-item">
			<label for="reg_email">メールアドレス</label>
			<input type="email" name="email" id="reg_email" autocomplete="email" value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" />
		</p>
		<p class="form-item">
			<label for="reg_email">パスワード</label>
			<input type="password" name="password" id="reg_password" value="<?php echo (!empty($_POST['password'])) ? esc_attr(wp_unslash($_POST['password'])) : ''; ?>" />
		</p>
		<div class="form-item">
			<label for="reg_email">お名前</label>
			<div class="grid grid-cols-2 gap-3">
				<div class="grid-item">
					<strong>姓</strong>
					<input type="text" name="billing_last_name" id="reg_billing_last_name" value="<?php if (!empty($_POST['billing_last_name'])) esc_attr_e($_POST['billing_last_name']); ?>" />
				</div>
				<div class="grid-item">
					<strong>名</strong>
					<input type="text" name="billing_first_name" id="reg_billing_first_name" value="<?php if (!empty($_POST['billing_first_name'])) esc_attr_e($_POST['billing_first_name']); ?>" />
				</div>
			</div>
		</div>
		<div class="form-item">
			<label for="reg_email">フリガナ</label>
			<div class="grid grid-cols-2 gap-3">
				<div class="grid-item">
					<strong>セイ</strong>
					<input type="text" name="billing_yomigana_last_name" id="reg_billing_yomigana_last_name" value="<?php if (!empty($_POST['billing_yomigana_last_name'])) esc_attr_e($_POST['billing_yomigana_last_name']); ?>" />
				</div>
				<div class="grid-item">
					<strong>メイ</strong>
					<input type="text" name="billing_yomigana_first_name" id="reg_billing_yomigana_first_name" value="<?php if (!empty($_POST['billing_yomigana_first_name'])) esc_attr_e($_POST['billing_last_name']); ?>" />
				</div>
			</div>
		</div>

		<p class="form-submit">
			<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
			<button type="submit" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>">新規会員登録する</button>
		</p>

		<?php do_action('woocommerce_register_form'); ?>

		<?php do_action('woocommerce_register_form_end'); ?>


	</form>

<?php

	return ob_get_clean();
}
add_shortcode('wc_registration_form', 'wc_registration_form_function');


// LOGIN SHORTCODE

function wc_login_form_function()
{
	if (is_admin()) return;
	if (is_user_logged_in()) return;
	ob_start();
?>


	<?= woocommerce_login_form(array('redirect' => 'https://lemeknow.jp')) ?>

	<div class="reg-form new-user-reg">
		<h2>未登録のお客さま</h2>
		<p><a href="/register">新規会員登録</a></p>
	</div>

<?php
	return ob_get_clean();
}
add_shortcode('wc_login_form', 'wc_login_form_function');



function wc_custom_lost_password_form($atts)
{
	ob_start();

	wc_get_template('myaccount/form-lost-password.php', array('form' => 'lost_password'));
	return ob_get_clean();
}
add_shortcode('lost_password_form', 'wc_custom_lost_password_form');


function product_block($atts)
{
	$a = shortcode_atts(array(
		'id' => get_the_id(),
	), $atts);

	$id = $a['id'];
	$product = wc_get_product_object('simple', $id);
	ob_start();
?>
	<?php ?>
	<div class="frag-product">
		<div class="frag-product-body">
			<a href="<?= get_the_permalink($id) ?>">
				<figure>
					<img src="<?= get_the_post_thumbnail_url($id) ?>" alt="">
				</figure>
				<p><?= get_post_meta($id, 'wpcf-english-name', true) ?></p>
				<p><?= get_the_title($id) ?></p>
				<p>¥6,930</p>
			</a>
		</div>
	</div>
<?php
	return ob_get_clean();
}
add_shortcode('product-block', 'product_block');


add_action('user_register', 'myplugin_user_register');
function myplugin_user_register($user_id)
{
	if (!empty($_POST['billing_last_name'])) {
		update_user_meta($user_id, 'billing_first_name', trim($_POST['billing_first_name']));
		update_user_meta($user_id, 'billing_last_name', trim($_POST['billing_last_name']));
		update_user_meta($user_id, 'billing_yomigana_first_name', trim($_POST['billing_yomigana_first_name']));
		update_user_meta($user_id, 'billing_yomigana_last_name', trim($_POST['billing_yomigana_last_name']));
	}
}


add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
    return array(
        'width' => 352,
        'height' => 302,
        'crop' => 0,
    );
} );


add_action( 'wp_enqueue_scripts', 'bbloomer_disable_woocommerce_cart_fragments', 11 ); 
 
function bbloomer_disable_woocommerce_cart_fragments() { 
   wp_dequeue_script( 'wc-cart-fragments' ); 
}