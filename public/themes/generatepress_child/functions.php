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

add_action('woosb_before_item', function (WC_Product_Simple $product, WC_Product_Woosb $product2, int $order) {
    echo $order;
}, accepted_args: 3);

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/script.js', ['jquery']);
});

function addIconsSubMenu(DomDocument $dom, DOMElement $li, int $depth)
{
    $depth++;
    $linkElement = null;
    foreach ($li->childNodes as $ul) {
        if ($ul->tagName === 'a') {
            $linkElement = $ul;
            continue;
        }
        if ($ul->tagName !== 'ul') {
            continue;
        }
        if ($depth > 1) {
            $div = $dom->createElement('div');
            $div->setAttribute('style', 'display: flex;justify-content: space-between;align-items: center;');

            $span = $dom->createElement('span');
            $span->setAttribute('class', 'dashicons dashicons-plus accordion dashicons-actions');

            if(!is_null($linkElement)) {
                $div->insertBefore($linkElement);
            }
            $div->insertBefore($span);

            $ul->parentNode->insertBefore($div, $ul);
            $ul->setAttribute('style', 'display: none;');
            $class = $ul->getAttribute('class');
            $ul->setAttribute('class', 'panel ' . $class);
        }
        foreach ($ul->childNodes as $li2) {
            if ($li2->tagName !== 'li') {
                continue;
            }
            addIconsSubMenu($dom, $li2, $depth);
        }
    }
}

add_filter('wp_nav_menu', function (string $nav_menu, stdClass $args) {
    if ($args->theme_location !== '') {
        return $nav_menu;
    }
    $dom = new DOMDocument();
    $dom->loadHTML('<?xml encoding="UTF-8">' . $nav_menu);
    foreach ($dom->childNodes as $childNode) {
        if ($childNode->hasChildNodes()) {
            $ul = $childNode->firstChild->firstChild->firstChild;
            foreach ($ul->childNodes as $li) {
                if ($li->tagName !== 'li') {
                    continue;
                }
                $class = $li->getAttribute('class');
                $li->setAttribute('class', 'custom-primary-menu-item ' . $class);
                addIconsSubMenu($dom, $li, 0);
            }
            break;
        }
    }
    $result = str_replace(["\n", '</body></html>'], '', $dom->saveHTML());
    preg_replace('/<!DOCTYPE.*<body>/', '', $result);
    return $result;
}, 20, 2);


add_action('woosb_after_item_name', function (WC_Product_Simple $product) {
    $constructorNums = [];
    $data = $product->get_data();
    if (isset($data["attributes"]['numero-constructeur'])) {
        $constructorNums = $data["attributes"]['numero-constructeur']['data']["options"];
    }
    echo array_reduce($constructorNums, static function (string $r, string $num) {
        return $r . "<span style='display: block'>$num</span>";
    }, '');
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
