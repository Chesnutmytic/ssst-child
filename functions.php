<?php
/**
 * ssst Child Theme - functions.php
 *
 * Semua pendaftaran fitur, enqueue aset, include file,
 * dan hook utama ada di sini. File ini sebisa mungkin
 * hanya berisi "kabel" - logika detail ada di inc/.
 *
 * @package ssst-child
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

// ============================================================
// 1. KONSTANTA
// ============================================================
define( 'SSST_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'SSST_DIR',     get_stylesheet_directory() );
define( 'SSST_URI',     get_stylesheet_directory_uri() );

// ============================================================
// 2. SETUP TEMA
// ============================================================
add_action( 'after_setup_theme', 'ssst_child_setup' );

/**
 * Daftarkan fitur tema dan menu navigasi.
 */
function ssst_child_setup(): void {
    // Dukungan WooCommerce
    add_theme_support( 'woocommerce', [
        'thumbnail_image_width' => 480,
        'single_image_width'    => 800,
        'product_grid'          => [
            'default_rows'    => 4,
            'min_rows'        => 1,
            'default_columns' => 3,
            'min_columns'     => 1,
            'max_columns'     => 4,
        ],
    ] );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // Gambar
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'ssst-card',    480, 360, true );
    add_image_size( 'ssst-hero',    1440, 810, true );
    add_image_size( 'ssst-square',  400,  400, true );
    add_image_size( 'ssst-product', 600,  600, true );

    // Menu navigasi
    register_nav_menus( [
        'ssst-primary' => __( 'Menu Utama', 'ssst-child' ),
        'ssst-footer'  => __( 'Menu Footer', 'ssst-child' ),
    ] );

    // HTML5 support
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ] );

    // Title tag dikelola WordPress
    add_theme_support( 'title-tag' );

    // Custom logo
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
    ] );
}

// ============================================================
// 2b. KEMBALIKAN PERILAKU WOOCOMMERCE STANDAR
//     Storefront mematikan CSS WooCommerce dan memindahkan
//     toolbar katalog ke Storefront. Karena tema ini memakai
//     template & desain sendiri, kita pakai kembali default WC.
// ============================================================
add_action( 'after_setup_theme', 'ssst_restore_woocommerce_defaults', 20 );

/**
 * Lepas hook WooCommerce milik Storefront dan pasang kembali
 * hook standar WooCommerce.
 */
function ssst_restore_woocommerce_defaults(): void {
    // Aktifkan kembali stylesheet inti WooCommerce.
    remove_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

    // Toolbar katalog: sembunyikan versi Storefront (muncul dua kali).
    remove_action( 'woocommerce_before_shop_loop', 'storefront_sorting_wrapper', 9 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
    remove_action( 'woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30 );
    remove_action( 'woocommerce_before_shop_loop', 'storefront_sorting_wrapper_close', 31 );

    remove_action( 'woocommerce_after_shop_loop', 'storefront_sorting_wrapper', 9 );
    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );
    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 30 );
    remove_action( 'woocommerce_after_shop_loop', 'storefront_sorting_wrapper_close', 31 );

    // Pasang kembali toolbar & pagination standar.
    add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
    add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
    add_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

    // Wrapper konten Storefront tidak dipakai pada template ssst.
    remove_action( 'woocommerce_before_main_content', 'storefront_before_content', 10 );
    remove_action( 'woocommerce_after_main_content', 'storefront_after_content', 10 );

    // Elemen single product khusus Storefront.
    remove_action( 'woocommerce_single_product_summary', 'storefront_edit_post_link', 60 );
    remove_action( 'woocommerce_after_single_product_summary', 'storefront_upsell_display', 15 );
    remove_action( 'woocommerce_after_single_product_summary', 'storefront_single_product_pagination', 30 );
    add_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

    // Kembalikan posisi badge sale standar.
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 6 );
    add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
}

// ============================================================
// 3. ENQUEUE ASET
// ============================================================
add_action( 'wp_enqueue_scripts', 'ssst_child_enqueue' );

/**
 * Daftarkan & antrekan CSS dan JS child theme.
 * Semua aset memakai versi tema agar cache-bust otomatis
 * saat version di style.css dinaikkan.
 */
function ssst_child_enqueue(): void {
    $v = SSST_VERSION;

    // --- CSS ---

    // Self-hosted fonts (woff2)
    wp_enqueue_style(
        'ssst-fonts',
        SSST_URI . '/assets/css/fonts.css',
        [],
        $v
    );

    // Design tokens + base
    wp_enqueue_style(
        'ssst-main',
        SSST_URI . '/assets/css/main.css',
        [ 'ssst-fonts' ],
        $v
    );

    // Header, footer, dan navigasi
    wp_enqueue_style(
        'ssst-header-footer',
        SSST_URI . '/assets/css/header-footer.css',
        [ 'ssst-main' ],
        $v
    );

    // Halaman statis, blog, 404
    wp_enqueue_style(
        'ssst-pages',
        SSST_URI . '/assets/css/pages.css',
        [ 'ssst-main', 'ssst-header-footer' ],
        $v
    );

    // Landing page - hanya di halaman depan
    if ( is_front_page() || is_page_template( 'page-templates/template-landing.php' ) ) {
        wp_enqueue_style(
            'ssst-landing',
            SSST_URI . '/assets/css/landing.css',
            [ 'ssst-main' ],
            $v
        );
    }

    // WooCommerce - hanya di halaman WC.
    // Dimuat lewat hook prioritas 100 (lihat di bawah) agar berada
    // setelah stylesheet bawaan WooCommerce.

    // --- JS ---

    // Main JS (deferred, non-blocking)
    wp_enqueue_script(
        'ssst-main',
        SSST_URI . '/assets/js/main.js',
        [],
        $v,
        [ 'strategy' => 'defer', 'in_footer' => true ]
    );

    // WooCommerce custom JS (cart AJAX, marketplace buttons, dll.)
    if ( function_exists( 'WC' ) && file_exists( SSST_DIR . '/assets/js/woocommerce-custom.js' ) ) {
        wp_enqueue_script(
            'ssst-woocommerce',
            SSST_URI . '/assets/js/woocommerce-custom.js',
            [ 'jquery', 'wc-cart-fragments' ],
            $v,
            [ 'in_footer' => true ]
        );
    }

    // Data yang dikirim ke JS
    $js_data = [
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'nonce'     => wp_create_nonce( 'ssst_nonce' ),
        'assetsUri' => SSST_URI . '/assets',
        'siteUrl'   => home_url(),
    ];

    if ( function_exists( 'WC' ) ) {
        $js_data['cartUrl']     = wc_get_cart_url();
        $js_data['checkoutUrl'] = wc_get_checkout_url();
        $js_data['cartCount']   = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
    }

    wp_localize_script( 'ssst-main', 'SSST', $js_data );
}

// ============================================================
// 4. INCLUDE FILE MODUL
// ============================================================
$ssst_includes = [
    '/inc/cpt-menu.php',
    '/inc/cpt-outlet.php',
    '/inc/cpt-promo.php',
    '/inc/woocommerce-setup.php',
    '/inc/woocommerce-coffee.php',
    '/inc/schema.php',
    '/inc/meta-og.php',
    '/inc/email-branding.php',
];

foreach ( $ssst_includes as $file ) {
    $path = SSST_DIR . $file;
    if ( file_exists( $path ) ) {
        require_once $path;
    }
}

// ============================================================
// 5. GAMBAR UKURAN RESPONSIF DI WooCommerce
// ============================================================
add_filter( 'woocommerce_get_image_size_single', function( $size ) {
    return [ 'width' => 800, 'height' => 800, 'crop' => 1 ];
} );

add_filter( 'woocommerce_get_image_size_thumbnail', function( $size ) {
    return [ 'width' => 480, 'height' => 480, 'crop' => 1 ];
} );

add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
    return [ 'width' => 120, 'height' => 120, 'crop' => 1 ];
} );

// ============================================================
// 6. TAMBAH CUSTOM IMAGE SIZES KE UKURAN YANG DIKENALI WP
// ============================================================
add_filter( 'image_size_names_choose', function( $sizes ) {
    return array_merge( $sizes, [
        'ssst-card'    => __( 'ssst Card (480×360)', 'ssst-child' ),
        'ssst-product' => __( 'ssst Product (600×600)', 'ssst-child' ),
        'ssst-square'  => __( 'ssst Square (400×400)', 'ssst-child' ),
    ] );
} );

// ============================================================
// 7. SECURITY: SEMBUNYIKAN WP VERSION
// ============================================================
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

// ============================================================
// 8. CART FRAGMENT (untuk live update ikon cart di header)
// ============================================================
add_filter( 'woocommerce_add_to_cart_fragments', 'ssst_cart_fragment' );

/**
 * Update fragment jumlah item keranjang via AJAX.
 * Data-selector harus cocok dengan HTML di header.
 *
 * @param array $fragments Array fragment AJAX WooCommerce.
 * @return array
 */
function ssst_cart_fragment( array $fragments ): array {
    $count = WC()->cart ? (int) WC()->cart->get_cart_contents_count() : 0;
    $class = $count > 0 ? 'ssst-cart-count' : 'ssst-cart-count is-empty';

    $fragments['span.ssst-cart-count'] = sprintf(
        '<span class="%s" aria-live="polite" aria-label="%s">%s</span>',
        esc_attr( $class ),
        esc_attr( $count > 0
            ? sprintf( _n( 'Keranjang belanja, %d item', 'Keranjang belanja, %d item', $count, 'ssst-child' ), $count )
            : __( 'Keranjang belanja kosong', 'ssst-child' ) ),
        $count > 0 ? esc_html( $count ) : ''
    );

    return $fragments;
}

// ============================================================
// 9. BODY CLASS TAMBAHAN
// ============================================================
add_filter( 'body_class', function( array $classes ): array {
    $classes[] = 'ssst-site';

    if ( is_front_page() ) {
        $classes[] = 'ssst-landing';
    }

    if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
        $classes[] = 'ssst-shop';
    }

    // Halaman transaksi: kartu konten dibuat full-width agar formulir lega.
    if ( function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() || is_order_received_page() ) ) {
        $classes[] = 'ssst-wc-page';
    }

    return $classes;
} );

// ============================================================
// 10. LEPASKAN ASET BAWAAN STOREFRONT
//     Tema induk tetap dipakai untuk template WooCommerce &
//     struktur dasar, tetapi seluruh tampilan dikendalikan
//     oleh CSS ssst (handwritten), bukan CSS Storefront.
// ============================================================
add_action( 'wp_enqueue_scripts', 'ssst_dequeue_parent_assets', 100 );

/**
 * Dequeue stylesheet, font Google, dan JS navigasi Storefront
 * agar tidak bertabrakan dengan desain ssst.
 */
function ssst_dequeue_parent_assets(): void {
    $parent_uri = get_template_directory_uri();

    // Semua stylesheet milik tema induk (Storefront) dilepas -
    // tampilan sepenuhnya memakai CSS ssst.
    $wp_styles = wp_styles();
    foreach ( (array) $wp_styles->queue as $handle ) {
        $style = $wp_styles->registered[ $handle ] ?? null;
        if ( ! $style ) {
            continue;
        }

        $src = (string) $style->src;
        if ( false !== strpos( $src, $parent_uri ) || false !== strpos( $src, 'fonts.googleapis.com' ) ) {
            wp_dequeue_style( $handle );
        }
    }

    // JS navigasi Storefront tidak dipakai (navigasi ditangani main.js).
    $wp_scripts = wp_scripts();
    foreach ( (array) $wp_scripts->queue as $handle ) {
        $script = $wp_scripts->registered[ $handle ] ?? null;
        if ( $script && false !== strpos( (string) $script->src, $parent_uri ) ) {
            wp_dequeue_script( $handle );
        }
    }
}

// ============================================================
// 10b. CSS WOOCOMMERCE - DIMUAT PALING AKHIR
// ============================================================
add_action( 'wp_enqueue_scripts', 'ssst_enqueue_woocommerce_style', 100 );

/**
 * Muat CSS WooCommerce ssst setelah stylesheet bawaan WooCommerce
 * agar aturan layout kita menang.
 */
function ssst_enqueue_woocommerce_style(): void {
    if ( ! function_exists( 'is_woocommerce' ) ) {
        return;
    }

    if ( ! ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() || is_order_received_page() ) ) {
        return;
    }

    wp_enqueue_style(
        'ssst-woocommerce',
        SSST_URI . '/assets/css/woocommerce.css',
        [ 'ssst-main' ],
        SSST_VERSION
    );

    // Toko hanya melayani Indonesia; script ini menimpa label & status
    // wajib field checkout dengan locale default WooCommerce.
    if ( is_checkout() ) {
        wp_dequeue_script( 'wc-address-i18n' );

        // Lepas juga dari dependency wc-checkout agar tidak ikut dimuat.
        $scripts = wp_scripts();
        if ( isset( $scripts->registered['wc-checkout'] ) ) {
            $scripts->registered['wc-checkout']->deps = array_values(
                array_diff( $scripts->registered['wc-checkout']->deps, [ 'wc-address-i18n' ] )
            );
        }

        wp_deregister_script( 'wc-address-i18n' );
    }
}

// ============================================================
// 10c. OPTIMASI ASET
//      - matikan emoji WordPress (tidak dipakai)
//      - aset WooCommerce hanya di halaman toko
//      - preload font judul untuk LCP
// ============================================================
add_action( 'wp_enqueue_scripts', 'ssst_optimize_assets', 200 );

function ssst_optimize_assets(): void {
    // WordPress memuat skrip emoji di semua halaman; kita tidak memakainya.
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    wp_dequeue_script( 'wp-emoji' );
    wp_dequeue_style( 'wp-emoji-styles' );

    $is_wc_page = function_exists( 'is_woocommerce' ) && (
        is_woocommerce() || is_cart() || is_checkout() || is_account_page() || is_order_received_page()
    );

    if ( $is_wc_page ) {
        return;
    }

    $scripts = wp_scripts();
    $styles  = wp_styles();

    $keep_scripts = [
        'jquery-core',
        'jquery-migrate',
        'wc-add-to-cart',
        'wc-cart-fragments',
        'js-cookie',
        'woocommerce',
        'wc-blocks-ui',
        'ssst-main',
    ];

    foreach ( (array) $scripts->queue as $handle ) {
        $script = $scripts->registered[ $handle ] ?? null;
        if ( ! $script ) {
            continue;
        }

        $src = (string) $script->src;
        if ( false === strpos( $src, '/woocommerce/assets/' ) ) {
            continue;
        }

        if ( ! in_array( $handle, $keep_scripts, true ) ) {
            wp_dequeue_script( $handle );
        }
    }

    foreach ( (array) $styles->queue as $handle ) {
        $style = $styles->registered[ $handle ] ?? null;
        if ( ! $style ) {
            continue;
        }

        $src = (string) $style->src;
        if ( false !== strpos( $src, '/woocommerce/assets/css/' ) ) {
            wp_dequeue_style( $handle );
        }
    }
}

/**
 * Preload font judul agar teks hero tampil lebih cepat.
 */
add_action( 'wp_head', function (): void {
    $font = SSST_URI . '/assets/fonts/caveat/Caveat-VariableFont_wght.woff2';
    printf(
        '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
        esc_url( $font )
    );
}, 1 );

// ============================================================
// 11. BREADCRUMB SEDERHANA (digunakan di WC templates)
// ============================================================
if ( ! function_exists( 'ssst_breadcrumb' ) ) {
    /**
     * Tampilkan breadcrumb sederhana.
     * WooCommerce punya breadcrumb sendiri; fungsi ini
     * untuk halaman non-WC jika dibutuhkan.
     */
    function ssst_breadcrumb(): void {
        if ( is_front_page() ) {
            return;
        }
        echo '<nav class="ssst-breadcrumb" aria-label="' . esc_attr__( 'Lokasi halaman', 'ssst-child' ) . '">';
        echo '<ol class="ssst-breadcrumb__list">';
        echo '<li><a href="' . esc_url( home_url() ) . '">' . esc_html__( 'Beranda', 'ssst-child' ) . '</a></li>';
        if ( is_page() ) {
            echo '<li><span>' . esc_html( get_the_title() ) . '</span></li>';
        }
        echo '</ol></nav>';
    }
}

// ============================================================
// 12. HELPER: FORMAT HARGA IDR
// ============================================================
if ( ! function_exists( 'ssst_format_price' ) ) {
    /**
     * Format angka sebagai harga IDR.
     *
     * @param int|float $amount Jumlah.
     * @return string Harga terformat, misal "Rp 35.000".
     */
    function ssst_format_price( int|float $amount ): string {
        return 'Rp&nbsp;' . number_format( (float) $amount, 0, ',', '.' );
    }
}

// ============================================================
// 13. HELPER: RENDER SVG INLINE (aman, escaped)
// ============================================================
if ( ! function_exists( 'ssst_svg' ) ) {
    /**
     * Echo SVG dari folder assets/svg/ secara inline.
     * Semua atribut diterima dari luar sebagai allowlist.
     *
     * @param string $name Nama file tanpa .svg (misal: 'decorative/wavy-line').
     * @param array  $atts Atribut HTML tambahan (class, aria-hidden, dll.).
     */
    function ssst_svg( string $name, array $atts = [] ): void {
        $file = SSST_DIR . '/assets/svg/' . $name . '.svg';

        if ( ! file_exists( $file ) ) {
            return;
        }

        // Baca konten SVG
        $svg = file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

        if ( empty( $svg ) ) {
            return;
        }

        // Inject atribut tambahan ke tag <svg>
        if ( ! empty( $atts ) ) {
            $attr_string = '';
            foreach ( $atts as $key => $val ) {
                $attr_string .= ' ' . esc_attr( $key ) . '="' . esc_attr( $val ) . '"';
            }
            $svg = preg_replace( '/<svg/', '<svg' . $attr_string, $svg, 1 );
        }

        // Output - SVG dibuat oleh developer terpercaya,
        // namun tetap kita sanitasi untuk keamanan.
        $allowed_svg_tags = [
            'svg'      => [ 'xmlns' => true, 'viewbox' => true, 'width' => true, 'height' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'class' => true, 'aria-hidden' => true, 'role' => true, 'focusable' => true ],
            'path'     => [ 'd' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'opacity' => true, 'stroke-dasharray' => true, 'stroke-dashoffset' => true, 'class' => true ],
            'circle'   => [ 'cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true ],
            'ellipse'  => [ 'cx' => true, 'cy' => true, 'rx' => true, 'ry' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true ],
            'line'     => [ 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true ],
            'polyline' => [ 'points' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true ],
            'polygon'  => [ 'points' => true, 'fill' => true, 'stroke' => true ],
            'rect'     => [ 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'ry' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true ],
            'g'        => [ 'fill' => true, 'stroke' => true, 'transform' => true, 'opacity' => true ],
            'title'    => [],
            'desc'     => [],
            'defs'     => [],
            'clipPath' => [ 'id' => true ],
        ];

        echo wp_kses( $svg, $allowed_svg_tags );
    }
}
