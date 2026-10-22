<?php
/**
 * Template 404.
 *
 * @package ssst-child
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="ssst-main-content" class="ssst-page ssst-404">
    <div class="ssst-container ssst-container--narrow">

        <div class="ssst-404__inner">
            <div class="ssst-404__doodle" aria-hidden="true">
                <?php ssst_svg( 'doodles/cup' ); ?>
            </div>

            <p class="ssst-page__eyebrow"><?php esc_html_e( 'Halaman tidak ditemukan', 'ssst-child' ); ?></p>
            <h1 class="ssst-404__code">404</h1>
            <p class="ssst-404__text">
                <?php esc_html_e( 'Sepertinya cangkir ini sudah kosong. Halamannya mungkin dipindah, dihapus, atau tidak pernah ada.', 'ssst-child' ); ?>
            </p>

            <div class="ssst-404__actions">
                <a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Kembali ke Beranda', 'ssst-child' ); ?></a>
                <a class="btn btn--secondary" href="<?php echo esc_url( home_url( '/#menu' ) ); ?>"><?php esc_html_e( 'Lihat Menu', 'ssst-child' ); ?></a>
            </div>

            <div class="ssst-404__search">
                <?php get_search_form(); ?>
            </div>
        </div>

    </div>
</main>

<?php get_footer(); ?>
