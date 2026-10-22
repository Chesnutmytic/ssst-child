<?php
/**
 * Template satu tulisan.
 *
 * @package ssst-child
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="ssst-main-content" class="ssst-page ssst-single">
    <div class="ssst-container ssst-container--narrow">

        <?php while ( have_posts() ) : the_post(); ?>

            <article <?php post_class( 'ssst-single__article' ); ?>>
                <header class="ssst-page__header ssst-page__header--left">
                    <p class="ssst-page__eyebrow">
                        <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
                        <?php
                        $ssst_cats = get_the_category();
                        if ( $ssst_cats ) {
                            echo ' · ' . esc_html( $ssst_cats[0]->name );
                        }
                        ?>
                    </p>
                    <h1 class="ssst-page__title"><?php the_title(); ?></h1>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <figure class="ssst-single__media">
                        <?php the_post_thumbnail( 'large', [ 'loading' => 'eager' ] ); ?>
                    </figure>
                <?php endif; ?>

                <div class="ssst-entry-content">
                    <?php the_content(); ?>
                </div>

                <footer class="ssst-single__footer">
                    <?php the_tags( '<ul class="ssst-tags" role="list"><li>', '</li><li>', '</li></ul>' ); ?>

                    <nav class="ssst-post-nav" aria-label="<?php esc_attr_e( 'Navigasi tulisan', 'ssst-child' ); ?>">
                        <div class="ssst-post-nav__prev"><?php previous_post_link( '%link', '← %title' ); ?></div>
                        <div class="ssst-post-nav__next"><?php next_post_link( '%link', '%title →' ); ?></div>
                    </nav>
                </footer>
            </article>

            <?php if ( comments_open() || get_comments_number() ) : ?>
                <?php comments_template(); ?>
            <?php endif; ?>

        <?php endwhile; ?>

    </div>
</main>

<?php get_footer(); ?>
