<?php
/**
 * Template fallback: daftar tulisan (blog).
 *
 * @package ssst-child
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="ssst-main-content" class="ssst-page ssst-blog">
    <div class="ssst-container">

        <header class="ssst-page__header">
            <p class="ssst-page__eyebrow"><?php esc_html_e( 'Jurnal', 'ssst-child' ); ?></p>
            <h1 class="ssst-page__title">
                <?php
                if ( is_home() && ! is_front_page() ) {
                    single_post_title();
                } else {
                    esc_html_e( 'Catatan dari ssst', 'ssst-child' );
                }
                ?>
            </h1>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="ssst-post-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article <?php post_class( 'ssst-post-card' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a class="ssst-post-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                                <?php the_post_thumbnail( 'ssst-card', [ 'loading' => 'lazy' ] ); ?>
                            </a>
                        <?php endif; ?>

                        <div class="ssst-post-card__body">
                            <p class="ssst-post-card__meta">
                                <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
                            </p>
                            <h2 class="ssst-post-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <p class="ssst-post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
                            <a class="ssst-post-card__more" href="<?php the_permalink(); ?>">
                                <?php esc_html_e( 'Baca selengkapnya', 'ssst-child' ); ?>
                            </a>
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
                <p><?php esc_html_e( 'Belum ada catatan di sini. Sementara itu, mampir ke menu kami dulu, yuk.', 'ssst-child' ); ?></p>
                <a class="btn btn--primary" href="<?php echo esc_url( home_url( '/#menu' ) ); ?>"><?php esc_html_e( 'Lihat Menu', 'ssst-child' ); ?></a>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
