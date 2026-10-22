<?php
/**
 * Template pencarian.
 *
 * @package ssst-child
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="ssst-main-content" class="ssst-page ssst-blog">
    <div class="ssst-container">

        <header class="ssst-page__header">
            <p class="ssst-page__eyebrow"><?php esc_html_e( 'Pencarian', 'ssst-child' ); ?></p>
            <h1 class="ssst-page__title">
                <?php
                printf(
                    /* translators: %s: kata kunci pencarian. */
                    esc_html__( 'Hasil untuk “%s”', 'ssst-child' ),
                    esc_html( get_search_query() )
                );
                ?>
            </h1>
            <div class="ssst-page__search">
                <?php get_search_form(); ?>
            </div>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="ssst-post-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article <?php post_class( 'ssst-post-card' ); ?>>
                        <div class="ssst-post-card__body">
                            <p class="ssst-post-card__meta">
                                <?php
                                $ssst_type = get_post_type_object( get_post_type() );
                                echo esc_html( $ssst_type ? $ssst_type->labels->singular_name : '' );
                                ?>
                            </p>
                            <h2 class="ssst-post-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <p class="ssst-post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
                            <a class="ssst-post-card__more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Lihat', 'ssst-child' ); ?></a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="ssst-pagination">
                <?php the_posts_pagination( [
                    'mid_size'  => 1,
                    'prev_text' => esc_html__( 'Sebelumnya', 'ssst-child' ),
                    'next_text' => esc_html__( 'Berikutnya', 'ssst-child' ),
                ] ); ?>
            </div>
        <?php else : ?>
            <div class="ssst-empty-state">
                <p><?php esc_html_e( 'Tidak ada yang cocok. Coba kata kunci lain, atau lihat menu kami.', 'ssst-child' ); ?></p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
