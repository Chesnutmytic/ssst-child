<?php
/**
 * Schema.org JSON-LD
 *
 * Menambahkan data terstruktur schema.org untuk:
 * - CafeOrCoffeeShop / LocalBusiness di landing page
 * - Product schema di halaman produk WooCommerce
 *
 * @package ssst-child
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_head', 'ssst_output_schema', 99 );

function ssst_output_schema(): void {
    if ( is_front_page() || is_page_template( 'page-templates/template-landing.php' ) ) {
        ssst_schema_local_business();
    } elseif ( function_exists( 'is_product' ) && is_product() ) {
        ssst_schema_product();
    } elseif ( function_exists( 'is_product_category' ) && is_product_category() ) {
        ssst_schema_breadcrumb();
    }
}

/**
 * Schema LocalBusiness / CafeOrCoffeeShop untuk landing page.
 */
function ssst_schema_local_business(): void {
    // Ambil outlet pertama dari CPT jika ada
    $outlets   = get_posts( [ 'post_type' => 'ssst_outlet', 'posts_per_page' => -1, 'post_status' => 'publish' ] );
    $locations = [];

    foreach ( $outlets as $outlet ) {
        $address = get_post_meta( $outlet->ID, '_ssst_outlet_address', true );
        if ( $address ) {
            $locations[] = [
                '@type'   => 'CafeOrCoffeeShop',
                'name'    => esc_html( get_the_title( $outlet ) ),
                'address' => [
                    '@type'           => 'PostalAddress',
                    'streetAddress'   => esc_html( $address ),
                    'addressCountry'  => 'ID',
                ],
                'openingHours' => esc_html( get_post_meta( $outlet->ID, '_ssst_outlet_hours', true ) ?: '' ),
                'hasMap'       => esc_url( get_post_meta( $outlet->ID, '_ssst_outlet_gmaps_url', true ) ?: '' ),
            ];
        }
    }

    $schema = [
        '@context'        => 'https://schema.org',
        '@type'           => 'CafeOrCoffeeShop',
        'name'            => 'ssst Coffee',
        'url'             => esc_url( home_url( '/' ) ),
        'logo'            => esc_url( home_url( '/' ) ),
        'description'     => esc_html( get_bloginfo( 'description' ) ?: 'Coffee shop ssst - biji kopi pilihan, merchandise, dan atmosfer hangat.' ),
        'currenciesAccepted' => 'IDR',
        'paymentAccepted'    => 'Cash, Credit Card, E-Wallet',
        'priceRange'         => '$$',
        'servesCuisine'      => 'Coffee, Beverages',
        'sameAs'             => [],
    ];

    if ( ! empty( $locations ) ) {
        if ( 1 === count( $locations ) ) {
            $schema = array_merge( $schema, $locations[0] );
            unset( $schema['@type'] );
            $schema['@type'] = 'CafeOrCoffeeShop';
        } else {
            $schema['location'] = $locations;
        }
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
}

/**
 * Schema Product untuk halaman produk WooCommerce.
 */
function ssst_schema_product(): void {
    global $product;

    if ( ! $product instanceof \WC_Product ) {
        return;
    }

    $is_coffee   = ssst_is_coffee_product( $product );
    $schema_type = $is_coffee ? 'Product' : 'Product';

    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => $schema_type,
        'name'        => esc_html( $product->get_name() ),
        'description' => esc_html( wp_strip_all_tags( $product->get_description() ?: $product->get_short_description() ) ),
        'url'         => esc_url( get_permalink() ),
    ];

    // Gambar
    $image_id = $product->get_image_id();
    if ( $image_id ) {
        $schema['image'] = esc_url( wp_get_attachment_url( $image_id ) );
    }

    // SKU
    $sku = $product->get_sku();
    if ( $sku ) {
        $schema['sku'] = esc_html( $sku );
    }

    // Brand
    $schema['brand'] = [
        '@type' => 'Brand',
        'name'  => 'ssst Coffee',
    ];

    // Harga - hanya untuk merchandise (yang purchasable)
    if ( ! $is_coffee && $product->is_purchasable() ) {
        $price    = $product->get_price();
        $currency = get_option( 'woocommerce_currency', 'IDR' );
        $in_stock = $product->is_in_stock();

        $schema['offers'] = [
            '@type'           => 'Offer',
            'url'             => esc_url( get_permalink() ),
            'priceCurrency'   => $currency,
            'price'           => $price,
            'availability'    => $in_stock
                ? 'https://schema.org/InStock'
                : 'https://schema.org/OutOfStock',
            'seller'          => [
                '@type' => 'Organization',
                'name'  => 'ssst Coffee',
            ],
        ];
    }

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
}

/**
 * Breadcrumb schema sederhana.
 */
function ssst_schema_breadcrumb(): void {
    $term = get_queried_object();
    if ( ! $term ) return;

    $schema = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type'    => 'ListItem',
                'position' => 1,
                'name'     => esc_html__( 'Beranda', 'ssst-child' ),
                'item'     => esc_url( home_url( '/' ) ),
            ],
            [
                '@type'    => 'ListItem',
                'position' => 2,
                'name'     => esc_html( $term->name ?? '' ),
                'item'     => esc_url( get_term_link( $term ) ),
            ],
        ],
    ];

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
