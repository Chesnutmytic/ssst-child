<?php
/**
 * Template semua halaman WooCommerce (katalog, kategori, produk tunggal).
 *
 * Memakai woocommerce_content() agar template bawaan WooCommerce
 * (loop, single product, dsb.) tetap dipakai, dibungkus layout ssst.
 *
 * @package ssst-child
 */

defined( 'ABSPATH' ) || exit;

get_header();

$ssst_is_catalog = is_shop() || is_product_taxonomy();

// Judul katalog kita render sendiri di hero agar hierarki heading rapi.
if ( $ssst_is_catalog ) {
    add_filter( 'woocommerce_show_page_title', '__return_false' );
}
?>

<main id="ssst-main-content" class="ssst-page ssst-shop-page">
    <div class="ssst-container">

        <div class="ssst-shop-breadcrumb">
            <?php woocommerce_breadcrumb( [
                'delimiter'   => '<span class="ssst-breadcrumb__sep" aria-hidden="true">/</span>',
                'wrap_before' => '<nav class="woocommerce-breadcrumb ssst-breadcrumb" aria-label="' . esc_attr__( 'Lokasi halaman', 'ssst-child' ) . '">',
                'wrap_after'  => '</nav>',
            ] ); ?>
        </div>

        <?php if ( $ssst_is_catalog ) : ?>
            <header class="ssst-shop-hero">
                <p class="ssst-page__eyebrow">
                    <?php echo is_shop() ? esc_html__( 'Merchandise', 'ssst-child' ) : esc_html__( 'Kategori', 'ssst-child' ); ?>
                </p>
                <h1 class="ssst-page__title"><?php woocommerce_page_title(); ?></h1>
                <p class="ssst-shop-hero__desc">
                    <?php esc_html_e( 'Barang-barang kecil yang bikin harimu (dan kopimu) terasa lebih hangat. Dikirim ke seluruh Indonesia.', 'ssst-child' ); ?>
                </p>
            </header>
        <?php endif; ?>

        <?php woocommerce_content(); ?>

    </div>
</main>

<?php get_footer(); ?>
