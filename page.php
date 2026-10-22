<?php
/**
 * Template halaman statis (classic).
 *
 * Dipakai oleh halaman biasa: kebijakan, kontak, dan halaman
 * WooCommerce (keranjang, checkout) yang memakai shortcode.
 *
 * @package ssst-child
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="ssst-main-content" class="ssst-page">
    <div class="ssst-container">

        <?php while ( have_posts() ) : the_post(); ?>

            <?php
            $ssst_page_title = get_the_title();

            if ( function_exists( 'is_order_received_page' ) && is_order_received_page() ) {
                $ssst_page_title = __( 'Pesanan Diterima', 'ssst-child' );
            }
            ?>

            <article <?php post_class( 'ssst-page__article' ); ?>>

                <?php if ( $ssst_page_title ) : ?>
                <header class="ssst-page__header">
                    <p class="ssst-page__eyebrow"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
                    <h1 class="ssst-page__title"><?php echo esc_html( $ssst_page_title ); ?></h1>
                </header>
                <?php endif; ?>

                <div class="ssst-entry-content">
                    <?php
                    the_content();

                    wp_link_pages( [
                        'before' => '<nav class="ssst-page__links" aria-label="' . esc_attr__( 'Halaman', 'ssst-child' ) . '">',
                        'after'  => '</nav>',
                    ] );
                    ?>
                </div>

            </article>

        <?php endwhile; ?>

        <?php if ( comments_open() || get_comments_number() ) : ?>
            <div class="ssst-page__comments">
                <?php comments_template(); ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
