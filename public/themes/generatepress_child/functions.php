<?php
/**
 * GeneratePress child theme functions and definitions.
 *
 * Add your custom PHP in this file.
 * Only edit this file if you have direct access to it on your server (to fix errors if they happen).
 */

// https://www.kathyisawesome.com/woocommerce-modifying-product-query/
add_action('woocommerce_product_query', function (WP_Query $q) {
    $taxQuery = $q->get('tax_query');
    // https://stackoverflow.com/a/29806301/6824121
    $taxQuery[] = [
        'taxonomy' => 'product_type',
        'field' => 'slug',
        'terms' => 'woosb',
    ];
    $q->set('tax_query', $taxQuery);
});

if (!function_exists('woocommerce_subcategory_thumbnail')) {
    function woocommerce_subcategory_thumbnail($category)
    {
        $small_thumbnail_size = apply_filters('subcategory_archive_thumbnail_size', 'woocommerce_thumbnail');
        $dimensions = wc_get_image_size($small_thumbnail_size);
        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);

        $image = null;
        $image_srcset = false;
        $image_sizes = false;
        if ($thumbnail_id) {
            $image = wp_get_attachment_image_src($thumbnail_id, $small_thumbnail_size);
            $image = $image[0];
            $image_srcset = function_exists('wp_get_attachment_image_srcset') ? wp_get_attachment_image_srcset($thumbnail_id, $small_thumbnail_size) : false;
            $image_sizes = function_exists('wp_get_attachment_image_sizes') ? wp_get_attachment_image_sizes($thumbnail_id, $small_thumbnail_size) : false;
        }

        if ($image) {
            // Prevent esc_url from breaking spaces in urls for image embeds.
            // Ref: https://core.trac.wordpress.org/ticket/23605.
            $image = str_replace(' ', '%20', $image);

            // Add responsive image markup if available.
            if ($image_srcset && $image_sizes) {
                echo '<img src="' . esc_url($image) . '" alt="' . esc_attr($category->name) . '" width="' . esc_attr($dimensions['width']) . '" height="' . esc_attr($dimensions['height']) . '" srcset="' . esc_attr($image_srcset) . '" sizes="' . esc_attr($image_sizes) . '" />';
            } else {
                echo '<img src="' . esc_url($image) . '" alt="' . esc_attr($category->name) . '" width="' . esc_attr($dimensions['width']) . '" height="' . esc_attr($dimensions['height']) . '" />';
            }
        }
    }
}
