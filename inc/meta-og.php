<?php
/**
 * Open Graph & Twitter Card Meta Tags
 *
 * SEO meta untuk sharing di media sosial.
 * Bekerja berdampingan dengan Yoast / Rank Math jika terpasang.
 * Jika plugin SEO sudah aktif, skip agar tidak duplikat.
 *
 * @package ssst-child
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_head', 'ssst_output_og_tags', 5 );

function ssst_output_og_tags(): void {
    // Skip jika plugin SEO sudah menangani OG tags
    if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) ) {
        return;
    }

    global $post;

    // Tentukan data berdasarkan konteks halaman
    $data = ssst_get_og_data();

    if ( empty( $data ) ) return;

    $tags = [
        // Open Graph
        'og:type'        => $data['type'],
        'og:title'       => $data['title'],
        'og:description' => $data['description'],
        'og:url'         => $data['url'],
        'og:site_name'   => get_bloginfo( 'name' ),
        'og:locale'      => 'id_ID',
        'og:image'       => $data['image'],
        'og:image:alt'   => $data['title'],
        // Twitter Card
        'twitter:card'        => 'summary_large_image',
        'twitter:title'       => $data['title'],
        'twitter:description' => $data['description'],
        'twitter:image'       => $data['image'],
    ];

    // Output meta tags
    foreach ( $tags as $property => $content ) {
        if ( empty( $content ) ) continue;

        $attr = str_starts_with( $property, 'og:' ) ? 'property' : 'name';
        printf(
            '<meta %s="%s" content="%s">' . "\n",
            esc_attr( $attr ),
            esc_attr( $property ),
            esc_attr( $content )
        );
    }

    // Meta description
    if ( ! empty( $data['description'] ) ) {
        echo '<meta name="description" content="' . esc_attr( $data['description'] ) . '">' . "\n";
    }
}

/**
 * Kumpulkan data OG berdasarkan tipe halaman.
 *
 * @return array<string, string>
 */
function ssst_get_og_data(): array {
    global $post;

    $site_name  = get_bloginfo( 'name' );
    $tagline    = get_bloginfo( 'description' );
    $site_url   = home_url( '/' );
    $logo_url   = SSST_URI . '/assets/img/og-default.jpg'; // Gambar OG bawaan ssst

    // Coba ambil logo dari custom logo WordPress
    $logo_id = get_theme_mod( 'custom_logo' );
    if ( $logo_id ) {
        $logo_data = wp_get_attachment_image_src( $logo_id, 'full' );
        $logo_url  = $logo_data ? $logo_data[0] : '';
    }

    // Default data
    $data = [
        'type'        => 'website',
        'title'       => $site_name . ( $tagline ? ' - ' . $tagline : '' ),
        'description' => $tagline ?: 'ssst Coffee - Kopi pilihan, merchandise hangat, outlet nyaman.',
        'url'         => $site_url,
        'image'       => $logo_url,
    ];

    // Landing / Front page
    if ( is_front_page() ) {
        return $data;
    }

    // Produk WooCommerce
    if ( function_exists( 'is_product' ) && is_product() && $post ) {
        /** @var \WC_Product|null $product */
        $product = wc_get_product( $post->ID );
        if ( ! $product ) return $data;

        $image_id  = $product->get_image_id();
        $image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'large' ) : $logo_url;

        return [
            'type'        => 'product',
            'title'       => esc_html( $product->get_name() ) . ' - ' . $site_name,
            'description' => esc_html( wp_strip_all_tags(
                $product->get_short_description() ?: $product->get_description() ?: $tagline
            ) ),
            'url'         => esc_url( get_permalink() ),
            'image'       => esc_url( $image_url ?: $logo_url ),
        ];
    }

    // Halaman kategori produk
    if ( function_exists( 'is_product_category' ) && is_product_category() ) {
        $term = get_queried_object();
        return [
            'type'        => 'website',
            'title'       => esc_html( $term->name ?? '' ) . ' - ' . $site_name,
            'description' => esc_html( $term->description ?? $tagline ),
            'url'         => esc_url( get_term_link( $term ) ),
            'image'       => $logo_url,
        ];
    }

    // Halaman statis
    if ( is_page() && $post ) {
        $thumb_url = get_the_post_thumbnail_url( $post->ID, 'large' );
        return [
            'type'        => 'website',
            'title'       => esc_html( get_the_title() ) . ' - ' . $site_name,
            'description' => esc_html( wp_strip_all_tags( $post->post_excerpt ?: $tagline ) ),
            'url'         => esc_url( get_permalink() ),
            'image'       => esc_url( $thumb_url ?: $logo_url ),
        ];
    }

    return $data;
}


