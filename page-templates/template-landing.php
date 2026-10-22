<?php
/**
 * Template Name: ssst Landing Page
 * Template Post Type: page
 *
 * One-page landing page coffee shop ssst.
 * Semua section ada di satu halaman:
 *   #hero -> #tentang -> #menu -> #beli-kopi -> #merchandise -> #promo -> #outlet -> #cara-pesan
 *
 * CARA PAKAI:
 * 1. Buat halaman baru di wp-admin > Halaman > Tambah Baru
 * 2. Beri judul "Beranda" (atau apa saja)
 * 3. Di sisi kanan, pilih Template: "ssst Landing Page"
 * 4. Publish
 * 5. Pergi ke Pengaturan > Membaca > set "Halaman Statis" ke halaman ini
 *
 * @package ssst-child
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="ssst-main-content" class="ssst-landing" aria-label="<?php esc_attr_e( 'Konten utama', 'ssst-child' ); ?>">

    <?php /* ============================================================
       SECTION 1 - HERO
    ============================================================ */ ?>
    <section class="ssst-hero ssst-section" id="hero" aria-labelledby="ssst-hero-title">

        <!-- Doodle background -->
        <div class="ssst-hero__bg-doodle ssst-hero__bg-doodle--cup" aria-hidden="true">
            <?php ssst_svg( 'doodles/cup' ); ?>
        </div>
        <div class="ssst-hero__bg-doodle ssst-hero__bg-doodle--bean" aria-hidden="true">
            <?php ssst_svg( 'doodles/bean' ); ?>
        </div>

        <div class="ssst-container">
            <div class="ssst-hero__content ssst-reveal">

                <span class="ssst-hero__eyebrow">
                    <?php esc_html_e( 'Coffee Shop Lokal', 'ssst-child' ); ?>
                </span>

                <h1 class="ssst-hero__title" id="ssst-hero-title">
                    <span class="ssst-underline">ssst.</span><br>
                    <?php esc_html_e( 'Friendssst', 'ssst-child' ); ?>
                </h1>

                <p class="ssst-hero__tagline">
                    <?php esc_html_e( 'Biji kopi pilihan, suasana yang nyaman, dan satu tegukan yang bikin kamu lupa kata-kata.', 'ssst-child' ); ?>
                </p>

                <div class="ssst-hero__ctas">
                    <a href="#menu"
                       class="btn btn--primary"
                       aria-label="<?php esc_attr_e( 'Lihat menu kami', 'ssst-child' ); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                            <path d="M17 8h1a4 4 0 1 1 0 8h-1"/>
                            <path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/>
                            <line x1="6" y1="2" x2="6" y2="4"/>
                            <line x1="10" y1="2" x2="10" y2="4"/>
                            <line x1="14" y1="2" x2="14" y2="4"/>
                        </svg>
                        <?php esc_html_e( 'Lihat Menu', 'ssst-child' ); ?>
                    </a>
                    <a href="#merchandise"
                       class="btn btn--secondary"
                       aria-label="<?php esc_attr_e( 'Lihat merchandise ssst', 'ssst-child' ); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <path d="M16 10a4 4 0 0 1-8 0"/>
                        </svg>
                        <?php esc_html_e( 'Merchandise', 'ssst-child' ); ?>
                    </a>
                </div>

            </div>
        </div>

        <!-- Scroll indicator -->
        <a href="#tentang"
           class="ssst-hero__scroll"
           aria-label="<?php esc_attr_e( 'Scroll ke bawah', 'ssst-child' ); ?>">
            <span><?php esc_html_e( 'scroll', 'ssst-child' ); ?></span>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <polyline points="19 12 12 19 5 12"/>
            </svg>
        </a>

    </section>

    <?php /* ============================================================
       SECTION 2 - TENTANG BRAND
    ============================================================ */ ?>
    <section class="ssst-about ssst-section" id="tentang" aria-labelledby="ssst-about-title">
        <div class="ssst-container">
            <div class="ssst-about__inner">

                <div class="ssst-about__text ssst-reveal">
                    <div class="ssst-section-eyebrow"><?php esc_html_e( 'Tentang Kami', 'ssst-child' ); ?></div>
                    <h2 class="ssst-section-title" id="ssst-about-title">
                        <?php esc_html_e( 'Bukan kopi biasa.', 'ssst-child' ); ?>
                    </h2>
                    <p>
                        <?php esc_html_e( 'ssst lahir dari percakapan yang pelan, kopi yang diseduh dengan sabar, dan keyakinan bahwa hal-hal terbaik tidak perlu terburu-buru.', 'ssst-child' ); ?>
                    </p>
                    <p>
                        <?php esc_html_e( 'Kami menggunakan biji kopi pilihan dari petani lokal Indonesia, disangrai dengan cermat untuk menghadirkan cita rasa yang jujur - tidak berlebihan, tapi selalu berkesan.', 'ssst-child' ); ?>
                    </p>
                    <p>
                        <?php esc_html_e( 'Kamu bisa mampir ke outlet kami, memesan online di marketplace, atau sekadar membawa pulang sebotol biji kopi untuk diseduh di rumah.', 'ssst-child' ); ?>
                    </p>
                    <a href="#outlet" class="btn btn--secondary" style="margin-top:1.5rem;">
                        <?php esc_html_e( 'Temukan Outlet', 'ssst-child' ); ?>
                    </a>
                </div>

                <div class="ssst-about__image ssst-reveal ssst-reveal--delay-1">
                    <div class="ssst-about__img-frame">
                        <?php
                        // Ambil gambar featured dari halaman, atau placeholder
                        global $post;
                        $thumb_id = get_post_thumbnail_id( $post->ID ?? 0 );
                        if ( $thumb_id ) {
                            echo wp_get_attachment_image( $thumb_id, 'large', false, [
                                'class' => 'ssst-about__img',
                                'alt'   => esc_attr__( 'Suasana ssst Coffee', 'ssst-child' ),
                                'loading' => 'lazy',
                            ] );
                        } else {
                            // Placeholder SVG
                            ?>
                            <div class="ssst-img-placeholder" role="img" aria-label="<?php esc_attr_e( 'Foto suasana ssst Coffee', 'ssst-child' ); ?>" style="aspect-ratio:4/3;background:var(--c-foam);display:flex;align-items:center;justify-content:center;color:var(--c-latte);">
                                <?php ssst_svg( 'doodles/cup', [ 'style' => 'width:80px;height:80px;opacity:.4;' ] ); ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="ssst-about__sticker" aria-hidden="true">
                        <?php esc_html_e( 'sejak 2020', 'ssst-child' ); ?>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php /* ============================================================
       SECTION 3 - MENU KAFE
    ============================================================ */ ?>
    <section class="ssst-menu ssst-section" id="menu" aria-labelledby="ssst-menu-title">
        <div class="ssst-container">

            <header class="ssst-section-header ssst-reveal">
                <div class="ssst-section-eyebrow"><?php esc_html_e( 'Menu Kami', 'ssst-child' ); ?></div>
                <h2 class="ssst-section-title" id="ssst-menu-title">
                    <?php esc_html_e( 'Buku Menu', 'ssst-child' ); ?>
                </h2>
                <p class="ssst-section-desc">
                    <?php esc_html_e( 'Semua harga untuk porsi reguler. Tersedia tambahan espresso shot & susu nabati.', 'ssst-child' ); ?>
                </p>
            </header>

            <?php
            // Query CPT ssst_menu
            $menu_query = new WP_Query( [
                'post_type'      => 'ssst_menu',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
                'meta_query'     => [
                    [
                        'key'   => '_ssst_menu_is_available',
                        'value' => '1',
                    ],
                ],
            ] );

            if ( $menu_query->have_posts() ) :
                // Kumpulkan kategori unik untuk tab filter
                $all_categories = [ 'all' => __( 'Semua', 'ssst-child' ) ];
                $cat_labels     = [
                    'kopi-susu'   => 'Kopi Susu',
                    'manual-brew' => 'Manual Brew',
                    'non-kopi'    => 'Non-Kopi',
                    'makanan'     => 'Makanan',
                    'seasonal'    => 'Seasonal',
                    'lainnya'     => 'Lainnya',
                ];

                while ( $menu_query->have_posts() ) {
                    $menu_query->the_post();
                    $cat = get_post_meta( get_the_ID(), '_ssst_menu_category', true );
                    if ( $cat && ! isset( $all_categories[ $cat ] ) ) {
                        $all_categories[ $cat ] = $cat_labels[ $cat ] ?? ucfirst( str_replace( '-', ' ', $cat ) );
                    }
                }
                $menu_query->rewind_posts();
            ?>

            <!-- Tab filter kategori -->
            <div class="ssst-menu__tabs ssst-reveal" role="tablist" aria-label="<?php esc_attr_e( 'Filter kategori menu', 'ssst-child' ); ?>">
                <?php foreach ( $all_categories as $slug => $label ) : ?>
                <button class="ssst-menu__tab <?php echo 'all' === $slug ? 'is-active' : ''; ?>"
                        role="tab"
                        data-filter="<?php echo esc_attr( $slug ); ?>"
                        aria-selected="<?php echo 'all' === $slug ? 'true' : 'false'; ?>">
                    <?php echo esc_html( $label ); ?>
                </button>
                <?php endforeach; ?>
            </div>

            <!-- Grid item menu -->
            <div class="ssst-menu__grid" role="tabpanel" aria-label="<?php esc_attr_e( 'Item menu', 'ssst-child' ); ?>">
                <?php while ( $menu_query->have_posts() ) :
                    $menu_query->the_post();
                    $menu_id      = get_the_ID();
                    $category     = get_post_meta( $menu_id, '_ssst_menu_category', true );
                    $price        = get_post_meta( $menu_id, '_ssst_menu_price', true );
                    $description  = get_post_meta( $menu_id, '_ssst_menu_description', true );
                    $is_bestseller= get_post_meta( $menu_id, '_ssst_menu_is_bestseller', true );
                ?>
                <article class="ssst-menu-item ssst-reveal <?php echo $is_bestseller ? 'ssst-menu-item--bestseller' : ''; ?>"
                         data-category="<?php echo esc_attr( $category ); ?>"
                         aria-label="<?php echo esc_attr( get_the_title() ); ?>">
                    <div class="ssst-menu-item__info">
                        <h3 class="ssst-menu-item__name"><?php the_title(); ?></h3>
                        <?php if ( $description ) : ?>
                        <p class="ssst-menu-item__desc"><?php echo esc_html( $description ); ?></p>
                        <?php endif; ?>
                    </div>
                    <span class="ssst-menu-item__dots" aria-hidden="true"></span>
                    <?php if ( $price ) : ?>
                    <span class="ssst-menu-item__price" aria-label="<?php echo esc_attr( 'Rp ' . number_format( (int) $price, 0, ',', '.' ) ); ?>">
                        Rp <?php echo esc_html( number_format( (int) $price, 0, ',', '.' ) ); ?>
                    </span>
                    <?php endif; ?>
                </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

            <?php else : ?>
            <!-- Placeholder saat belum ada data menu -->
            <div class="ssst-menu__empty ssst-reveal">
                <p style="text-align:center;color:var(--c-roast);font-family:var(--font-hand);font-size:1.5rem;padding:3rem 0;">
                    <?php esc_html_e( 'Menu sedang diperbarui, mampir lagi nanti ya!', 'ssst-child' ); ?>
                </p>
                <?php
                // Sample placeholder items
                $samples = [
                    [ 'name' => 'Kopi Susu Signature', 'price' => '32000', 'desc' => 'Espresso double shot, susu segar, sedikit karamel.' ],
                    [ 'name' => 'V60 Single Origin',    'price' => '38000', 'desc' => 'Manual brew dengan biji Gayo light roast.' ],
                    [ 'name' => 'Es Teh Tarik',          'price' => '18000', 'desc' => 'Non-kopi, manis alami, cocok untuk cuaca panas.' ],
                    [ 'name' => 'Croissant Mentega',     'price' => '22000', 'desc' => 'Renyah di luar, lembut di dalam.' ],
                ];
                foreach ( $samples as $s ) : ?>
                <article class="ssst-menu-item" data-category="all" style="opacity:0.5;">
                    <div class="ssst-menu-item__info">
                        <p class="ssst-menu-item__name"><?php echo esc_html( $s['name'] ); ?></p>
                        <p class="ssst-menu-item__desc"><?php echo esc_html( $s['desc'] ); ?></p>
                    </div>
                    <span class="ssst-menu-item__dots" aria-hidden="true"></span>
                    <span class="ssst-menu-item__price">Rp <?php echo esc_html( number_format( (int) $s['price'], 0, ',', '.' ) ); ?></span>
                </article>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

        </div>
    </section>

    <?php /* ============================================================
       SECTION 4 - BELI KOPI (Marketplace)
    ============================================================ */ ?>
    <section class="ssst-coffee ssst-section" id="beli-kopi" aria-labelledby="ssst-coffee-title">
        <div class="ssst-container">

            <header class="ssst-section-header ssst-reveal">
                <div class="ssst-section-eyebrow" style="color:var(--c-milk);"><?php esc_html_e( 'Kopi Kemasan', 'ssst-child' ); ?></div>
                <h2 class="ssst-section-title" id="ssst-coffee-title">
                    <?php esc_html_e( 'Bawa Pulang Kopinya.', 'ssst-child' ); ?>
                </h2>
                <p class="ssst-coffee__subtitle">
                    <?php esc_html_e( 'Biji kopi dan kopi kemasan ssst tersedia di berbagai marketplace. Pilih platform favorit kamu.', 'ssst-child' ); ?>
                </p>
            </header>

            <?php
            // Query produk WooCommerce kategori 'kopi'
            $coffee_args = [
                'post_type'      => 'product',
                'post_status'    => 'publish',
                'posts_per_page' => 6,
                'tax_query'      => [
                    [
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => SSST_COFFEE_CAT_SLUG,
                    ],
                ],
            ];
            $coffee_query = new WP_Query( $coffee_args );

            if ( $coffee_query->have_posts() ) : ?>
            <div class="ssst-coffee__grid">
                <?php while ( $coffee_query->have_posts() ) :
                    $coffee_query->the_post();
                    $product_id = get_the_ID();
                    $wc_product = wc_get_product( $product_id );
                    $platforms  = ssst_get_marketplace_platforms();
                    ?>
                <div class="ssst-coffee-card ssst-reveal">
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="ssst-coffee-card__img">
                        <?php the_post_thumbnail( 'medium', [
                            'alt'     => esc_attr( get_the_title() ),
                            'loading' => 'lazy',
                        ] ); ?>
                    </div>
                    <?php endif; ?>
                    <h3 class="ssst-coffee-card__name"><?php the_title(); ?></h3>
                    <?php if ( $wc_product && $wc_product->get_short_description() ) : ?>
                    <p class="ssst-coffee-card__desc">
                        <?php echo esc_html( wp_strip_all_tags( $wc_product->get_short_description() ) ); ?>
                    </p>
                    <?php endif; ?>
                    <div class="ssst-coffee-card__markets">
                        <?php foreach ( $platforms as $key => $label ) :
                            $url = get_post_meta( $product_id, "_ssst_coffee_{$key}_url", true );
                            if ( ! $url ) continue;
                        ?>
                        <a href="<?php echo esc_url( $url ); ?>"
                           class="ssst-market-btn ssst-market-btn--<?php echo esc_attr( $key ); ?>"
                           target="_blank"
                           rel="noopener noreferrer"
                           data-ssst-track="marketplace"
                           data-ssst-platform="<?php echo esc_attr( $key ); ?>"
                           data-ssst-product="<?php echo esc_attr( get_the_title() ); ?>">
                            <?php
                            $svg_path = SSST_DIR . "/assets/svg/marketplace/{$key}.svg";
                            if ( file_exists( $svg_path ) ) {
                                ssst_svg( "marketplace/{$key}", [ 'aria-hidden' => 'true', 'width' => '16', 'height' => '16' ] );
                            }
                            ?>
                            <?php echo esc_html( $label ); ?>
                            <span class="sr-only"><?php esc_html_e( '(buka di tab baru)', 'ssst-child' ); ?></span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

            <?php else : ?>
            <!-- Placeholder saat belum ada produk kopi di WooCommerce -->
            <div class="ssst-coffee__grid">
                <?php
                $coffee_samples = [
                    [ 'name' => 'Biji Kopi Gayo Natural', 'desc' => '250g • Light to Medium Roast • Aceh Tengah' ],
                    [ 'name' => 'Kopi Flores Bajawa',      'desc' => '200g • Medium Roast • Flores, NTT' ],
                    [ 'name' => 'Blend ssst. Signature',   'desc' => '250g • Espresso Blend • Campuran Terbaik' ],
                ];
                $platforms_samples = ssst_get_marketplace_platforms();
                foreach ( $coffee_samples as $cs ) : ?>
                <div class="ssst-coffee-card ssst-reveal">
                    <div class="ssst-coffee-card__img" style="background:rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:center;min-height:180px;">
                        <?php ssst_svg( 'doodles/bean', [ 'style' => 'width:60px;color:rgba(255,255,255,0.3);' ] ); ?>
                    </div>
                    <h3 class="ssst-coffee-card__name"><?php echo esc_html( $cs['name'] ); ?></h3>
                    <p class="ssst-coffee-card__desc"><?php echo esc_html( $cs['desc'] ); ?></p>
                    <div class="ssst-coffee-card__markets">
                        <?php foreach ( $platforms_samples as $key => $label ) : ?>
                        <span class="ssst-market-btn ssst-market-btn--<?php echo esc_attr( $key ); ?>" style="opacity:0.5;cursor:default;">
                            <?php echo esc_html( $label ); ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <p style="text-align:center;color:var(--c-milk);margin-top:2rem;font-size:0.9rem;">
                <?php esc_html_e( '^ Tambahkan produk kopi di WooCommerce > Produk dengan kategori "Kopi"', 'ssst-child' ); ?>
            </p>
            <?php endif; ?>

        </div>
    </section>

    <?php /* ============================================================
       SECTION 5 - MERCHANDISE
    ============================================================ */ ?>
    <section class="ssst-merchandise ssst-section" id="merchandise" aria-labelledby="ssst-merch-title">
        <div class="ssst-container">

            <div class="ssst-merchandise__header ssst-reveal">
                <div>
                    <div class="ssst-section-eyebrow"><?php esc_html_e( 'Koleksi', 'ssst-child' ); ?></div>
                    <h2 class="ssst-section-title" id="ssst-merch-title">
                        <?php esc_html_e( 'Merchandise ssst.', 'ssst-child' ); ?>
                    </h2>
                </div>
                <?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
                   class="btn btn--ghost">
                    <?php esc_html_e( 'Lihat Semua', 'ssst-child' ); ?> ->
                </a>
                <?php endif; ?>
            </div>

            <?php
            // Query produk merchandise - EXCLUDE kategori kopi
            $merch_args = [
                'post_type'      => 'product',
                'post_status'    => 'publish',
                'posts_per_page' => 8,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'tax_query'      => [
                    [
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => SSST_COFFEE_CAT_SLUG,
                        'operator' => 'NOT IN',
                    ],
                ],
            ];
            $merch_query = new WP_Query( $merch_args );

            if ( $merch_query->have_posts() ) : ?>
            <ul class="ssst-merchandise__grid" role="list">
                <?php while ( $merch_query->have_posts() ) :
                    $merch_query->the_post();
                    $product_id = get_the_ID();
                    $wc_product = wc_get_product( $product_id );
                    if ( ! $wc_product ) continue;

                    $is_new  = ( time() - get_the_date( 'U' ) ) < ( 30 * DAY_IN_SECONDS );
                    $on_sale = $wc_product->is_on_sale();
                ?>
                <li class="ssst-merch-card ssst-reveal">
                    <!-- Badge -->
                    <?php if ( $is_new || $on_sale ) : ?>
                    <div class="ssst-merch-card__badge">
                        <span class="ssst-badge <?php echo $on_sale ? 'ssst-badge--sale' : 'ssst-badge--new'; ?>">
                            <?php echo $on_sale ? esc_html__( 'Sale', 'ssst-child' ) : esc_html__( 'Baru', 'ssst-child' ); ?>
                        </span>
                    </div>
                    <?php endif; ?>

                    <!-- Gambar -->
                    <a href="<?php the_permalink(); ?>"
                       class="ssst-merch-card__img-wrap"
                       tabindex="-1"
                       aria-hidden="true">
                        <?php if ( has_post_thumbnail() ) {
                            the_post_thumbnail( 'medium', [
                                'alt'     => '',
                                'loading' => 'lazy',
                            ] );
                        } else { ?>
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--c-foam);color:var(--c-latte);">
                            <?php ssst_svg( 'doodles/cup', [ 'style' => 'width:50px;' ] ); ?>
                        </div>
                        <?php } ?>
                    </a>

                    <!-- Info -->
                    <div class="ssst-merch-card__body">
                        <h3 class="ssst-merch-card__name">
                            <a href="<?php the_permalink(); ?>" style="color:inherit;text-decoration:none;">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <p class="ssst-merch-card__price">
                            <?php
                            // Output harga dengan format WC
                            $price_html = $wc_product->get_price_html();
                            // Pastikan harga bersih
                            echo wp_kses_post( $price_html );
                            ?>
                        </p>

                        <?php
                        // Tombol add to cart
                        $is_purchasable = $wc_product->is_purchasable();
                        $is_in_stock    = $wc_product->is_in_stock();
                        $is_variable    = $wc_product->is_type( 'variable' );
                        ?>
                        <?php if ( $is_variable && $is_in_stock ) : ?>
                        <a href="<?php the_permalink(); ?>"
                           class="btn btn--primary ssst-merch-card__btn"
                           aria-label="<?php echo esc_attr( sprintf( __( 'Pilih ukuran %s', 'ssst-child' ), get_the_title() ) ); ?>">
                            <?php esc_html_e( 'Pilih Ukuran', 'ssst-child' ); ?>
                        </a>
                        <?php elseif ( $is_purchasable && $is_in_stock ) : ?>
                        <a href="?add-to-cart=<?php echo esc_attr( $product_id ); ?>"
                           class="btn btn--primary ssst-merch-card__btn add_to_cart_button ajax_add_to_cart"
                           data-product_id="<?php echo esc_attr( $product_id ); ?>"
                           data-quantity="1"
                           aria-label="<?php echo esc_attr( sprintf( __( 'Tambah ke Keranjang: %s', 'ssst-child' ), get_the_title() ) ); ?>"
                           rel="nofollow">
                            <?php esc_html_e( 'Tambah ke Keranjang', 'ssst-child' ); ?>
                        </a>
                        <?php elseif ( ! $is_in_stock ) : ?>
                        <span class="btn btn--disabled"><?php esc_html_e( 'Habis', 'ssst-child' ); ?></span>
                        <?php else : ?>
                        <a href="<?php the_permalink(); ?>" class="btn btn--secondary">
                            <?php esc_html_e( 'Lihat Produk', 'ssst-child' ); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endwhile; wp_reset_postdata(); ?>
            </ul>

            <?php else : ?>
            <!-- Placeholder merchandise -->
            <ul class="ssst-merchandise__grid" aria-label="<?php esc_attr_e( 'Contoh produk merchandise', 'ssst-child' ); ?>">
                <?php
                $merch_samples = [
                    [ 'name' => 'T-Shirt ssst.', 'price' => 'Rp 185.000' ],
                    [ 'name' => 'Tote Bag Canvas', 'price' => 'Rp 120.000' ],
                    [ 'name' => 'Tumbler 500ml', 'price' => 'Rp 250.000' ],
                    [ 'name' => 'Mug Keramik', 'price' => 'Rp 145.000' ],
                ];
                foreach ( $merch_samples as $ms ) : ?>
                <li class="ssst-merch-card ssst-reveal" aria-hidden="true">
                    <div class="ssst-merch-card__img-wrap">
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--c-foam);color:var(--c-latte);">
                            <?php ssst_svg( 'doodles/cup', [ 'style' => 'width:50px;opacity:.3;' ] ); ?>
                        </div>
                    </div>
                    <div class="ssst-merch-card__body">
                        <h3 class="ssst-merch-card__name"><?php echo esc_html( $ms['name'] ); ?></h3>
                        <p class="ssst-merch-card__price"><?php echo esc_html( $ms['price'] ); ?></p>
                        <span class="btn btn--primary" style="opacity:.4;cursor:default;"><?php esc_html_e( 'Tambah ke Keranjang', 'ssst-child' ); ?></span>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
            <p style="text-align:center;color:var(--c-roast);margin-top:2rem;font-size:0.9rem;">
                <?php esc_html_e( '^ Tambahkan produk merchandise di WooCommerce (bukan kategori "Kopi")', 'ssst-child' ); ?>
            </p>
            <?php endif; ?>

        </div>
    </section>

    <?php /* ============================================================
       SECTION 6 - PROMO
    ============================================================ */ ?>
    <?php
    // Hanya tampilkan section promo jika ada data
    $promo_query = new WP_Query( [
        'post_type'      => 'ssst_promo',
        'post_status'    => 'publish',
        'posts_per_page' => 6,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ] );

    if ( $promo_query->have_posts() ) :
    ?>
    <section class="ssst-promo ssst-section" id="promo" aria-labelledby="ssst-promo-title">
        <div class="ssst-container">

            <header class="ssst-section-header ssst-reveal">
                <div class="ssst-section-eyebrow"><?php esc_html_e( 'Penawaran', 'ssst-child' ); ?></div>
                <h2 class="ssst-section-title" id="ssst-promo-title">
                    <?php esc_html_e( 'Promo & Diskon', 'ssst-child' ); ?>
                </h2>
            </header>

            <div class="ssst-promo__grid">
                <?php while ( $promo_query->have_posts() ) :
                    $promo_query->the_post();
                    $pid         = get_the_ID();
                    $label       = get_post_meta( $pid, '_ssst_promo_label',       true );
                    $desc        = get_post_meta( $pid, '_ssst_promo_description',  true );
                    $valid_until = get_post_meta( $pid, '_ssst_promo_valid_until',  true );
                    $code        = get_post_meta( $pid, '_ssst_promo_code',         true );

                    // Skip jika promo sudah kadaluarsa
                    if ( $valid_until && strtotime( $valid_until ) < time() ) continue;
                ?>
                <div class="ssst-promo-card ssst-reveal">
                    <?php if ( $label ) : ?>
                    <span class="ssst-promo-card__label"><?php echo esc_html( $label ); ?></span>
                    <?php endif; ?>

                    <h3 class="ssst-promo-card__title"><?php the_title(); ?></h3>

                    <?php if ( $desc ) : ?>
                    <p class="ssst-promo-card__desc"><?php echo esc_html( $desc ); ?></p>
                    <?php endif; ?>

                    <?php if ( $code ) : ?>
                    <button class="ssst-promo-card__code"
                            title="<?php esc_attr_e( 'Klik untuk salin kode', 'ssst-child' ); ?>"
                            type="button"
                            aria-label="<?php echo esc_attr( sprintf( __( 'Salin kode promo %s', 'ssst-child' ), $code ) ); ?>">
                        <?php echo esc_html( $code ); ?>
                    </button>
                    <?php endif; ?>

                    <?php if ( $valid_until ) : ?>
                    <p class="ssst-promo-card__validity">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <?php echo esc_html( sprintf( __( 'Berlaku s.d. %s', 'ssst-child' ), wp_date( 'd F Y', strtotime( $valid_until ) ) ) ); ?>
                    </p>
                    <?php endif; ?>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

        </div>
    </section>
    <?php endif; ?>

    <?php /* ============================================================
       SECTION 7 - OUTLET
    ============================================================ */ ?>
    <section class="ssst-outlet ssst-section" id="outlet" aria-labelledby="ssst-outlet-title">
        <div class="ssst-container">

            <header class="ssst-section-header ssst-reveal">
                <div class="ssst-section-eyebrow"><?php esc_html_e( 'Lokasi', 'ssst-child' ); ?></div>
                <h2 class="ssst-section-title" id="ssst-outlet-title">
                    <?php esc_html_e( 'Outlet Kami', 'ssst-child' ); ?>
                </h2>
                <p class="ssst-section-desc">
                    <?php esc_html_e( 'Singgah, duduk, dan nikmati. Kami tunggu.', 'ssst-child' ); ?>
                </p>
            </header>

            <?php
            $outlet_query = new WP_Query( [
                'post_type'      => 'ssst_outlet',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
            ] );

            if ( $outlet_query->have_posts() ) : ?>
            <div class="ssst-outlet__grid">
                <?php while ( $outlet_query->have_posts() ) :
                    $outlet_query->the_post();
                    $oid     = get_the_ID();
                    $address = get_post_meta( $oid, '_ssst_outlet_address',   true );
                    $hours   = get_post_meta( $oid, '_ssst_outlet_hours',     true );
                    $gmaps   = get_post_meta( $oid, '_ssst_outlet_gmaps_url', true );
                    $wa      = get_post_meta( $oid, '_ssst_outlet_whatsapp',  true );
                    $is_open = get_post_meta( $oid, '_ssst_outlet_is_open',   true );
                ?>
                <article class="ssst-outlet-card ssst-reveal" aria-label="<?php echo esc_attr( get_the_title() ); ?>">

                    <div class="ssst-outlet-card__status <?php echo $is_open ? 'ssst-outlet-card__status--open' : 'ssst-outlet-card__status--closed'; ?>">
                        <span class="ssst-outlet-card__status-dot" aria-hidden="true"></span>
                        <span><?php echo $is_open ? esc_html__( 'Buka', 'ssst-child' ) : esc_html__( 'Tutup Sementara', 'ssst-child' ); ?></span>
                    </div>

                    <h3 class="ssst-outlet-card__name"><?php the_title(); ?></h3>

                    <?php if ( $address ) : ?>
                    <address class="ssst-outlet-card__address" style="font-style:normal;">
                        <?php echo nl2br( esc_html( $address ) ); ?>
                    </address>
                    <?php endif; ?>

                    <?php if ( $hours ) : ?>
                    <div class="ssst-outlet-card__hours">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span><?php echo nl2br( esc_html( $hours ) ); ?></span>
                    </div>
                    <?php endif; ?>

                    <div class="ssst-outlet-card__actions">
                        <?php if ( $gmaps ) : ?>
                        <a href="<?php echo esc_url( $gmaps ); ?>"
                           class="ssst-outlet-card__btn"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="<?php echo esc_attr( sprintf( __( 'Buka Google Maps untuk %s', 'ssst-child' ), get_the_title() ) ); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <?php esc_html_e( 'Maps', 'ssst-child' ); ?>
                        </a>
                        <?php endif; ?>

                        <?php if ( $wa ) : ?>
                        <a href="https://wa.me/<?php echo esc_attr( $wa ); ?>?text=<?php echo rawurlencode( sprintf( __( 'Halo ssst! Saya mau bertanya tentang outlet %s.', 'ssst-child' ), get_the_title() ) ); ?>"
                           class="ssst-outlet-card__btn ssst-outlet-card__btn--wa"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="<?php echo esc_attr( sprintf( __( 'Chat WhatsApp outlet %s', 'ssst-child' ), get_the_title() ) ); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                            <?php esc_html_e( 'WhatsApp', 'ssst-child' ); ?>
                        </a>
                        <?php endif; ?>
                    </div>

                </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

            <?php else : ?>
            <!-- Placeholder outlet -->
            <div class="ssst-outlet__grid">
                <?php for ( $i = 1; $i <= 2; $i++ ) : ?>
                <article class="ssst-outlet-card ssst-reveal" style="opacity:0.5;">
                    <div class="ssst-outlet-card__status ssst-outlet-card__status--open">
                        <span class="ssst-outlet-card__status-dot"></span>
                        <span><?php esc_html_e( 'Buka', 'ssst-child' ); ?></span>
                    </div>
                    <h3 class="ssst-outlet-card__name"><?php echo esc_html( sprintf( __( 'Outlet ssst. #%d', 'ssst-child' ), $i ) ); ?></h3>
                    <address class="ssst-outlet-card__address" style="font-style:normal;">
                        <?php esc_html_e( 'Jl. Contoh Alamat No. 1, Kota Anda', 'ssst-child' ); ?>
                    </address>
                    <div class="ssst-outlet-card__hours">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span><?php esc_html_e( 'Senin–Minggu: 08.00–22.00', 'ssst-child' ); ?></span>
                    </div>
                </article>
                <?php endfor; ?>
            </div>
            <p style="text-align:center;color:var(--c-roast);margin-top:2rem;font-size:0.9rem;">
                <?php esc_html_e( '^ Tambahkan outlet di menu "Outlet" di wp-admin', 'ssst-child' ); ?>
            </p>
            <?php endif; ?>

        </div>
    </section>

    <?php /* ============================================================
       SECTION 8 - CARA PESAN
    ============================================================ */ ?>
    <section class="ssst-howto ssst-section" id="cara-pesan" aria-labelledby="ssst-howto-title">
        <div class="ssst-container">

            <header class="ssst-section-header ssst-reveal">
                <div class="ssst-section-eyebrow"><?php esc_html_e( 'Cara Pesan', 'ssst-child' ); ?></div>
                <h2 class="ssst-section-title" id="ssst-howto-title">
                    <?php esc_html_e( 'Mudah, cepat, nyaman.', 'ssst-child' ); ?>
                </h2>
            </header>

            <!-- Merchandise pathway -->
            <h3 class="ssst-howto__channel" style="font-family:var(--font-hand);font-size:1.5rem;color:var(--c-coffee);text-align:center;margin-bottom:2rem;display:flex;align-items:center;justify-content:center;gap:.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>
                <?php esc_html_e( 'Merchandise - Langsung di Website', 'ssst-child' ); ?>
            </h3>
            <div class="ssst-howto__grid" style="margin-bottom:3rem;">
                <?php
                $merch_steps = [
                    [
                        'num'   => '01',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
                        'title' => __( 'Pilih Produk', 'ssst-child' ),
                        'desc'  => __( 'Jelajahi koleksi merchandise ssst dan pilih yang paling kamu suka.', 'ssst-child' ),
                    ],
                    [
                        'num'   => '02',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>',
                        'title' => __( 'Tambah ke Keranjang', 'ssst-child' ),
                        'desc'  => __( 'Masukkan ke keranjang, isi data pengiriman, lalu bayar secara online.', 'ssst-child' ),
                    ],
                    [
                        'num'   => '03',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>',
                        'title' => __( 'Terima di Rumah', 'ssst-child' ),
                        'desc'  => __( 'Pesanan dikemas dengan hati-hati dan dikirim ke alamat kamu. Selamat unboxing!', 'ssst-child' ),
                    ],
                ];
                foreach ( $merch_steps as $step ) : ?>
                <div class="ssst-howto-card ssst-reveal">
                    <div class="ssst-howto-card__number" aria-hidden="true"><?php echo esc_html( $step['num'] ); ?></div>
                    <div class="ssst-howto-card__icon" aria-hidden="true"><?php echo $step['icon']; // phpcs:ignore ?></div>
                    <h4 class="ssst-howto-card__title"><?php echo esc_html( $step['title'] ); ?></h4>
                    <p class="ssst-howto-card__desc"><?php echo esc_html( $step['desc'] ); ?></p>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Coffee pathway -->
            <h3 class="ssst-howto__channel" style="font-family:var(--font-hand);font-size:1.5rem;color:var(--c-coffee);text-align:center;margin:3rem 0 2rem;display:flex;align-items:center;justify-content:center;gap:.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/><line x1="6" y1="2" x2="6" y2="4"/><line x1="10" y1="2" x2="10" y2="4"/><line x1="14" y1="2" x2="14" y2="4"/></svg>
                <?php esc_html_e( 'Kopi - Via Marketplace', 'ssst-child' ); ?>
            </h3>
            <div class="ssst-howto__grid">
                <?php
                $coffee_steps = [
                    [
                        'num'   => '01',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>',
                        'title' => __( 'Pilih Kopi', 'ssst-child' ),
                        'desc'  => __( 'Temukan kopi ssst yang kamu inginkan di halaman "Beli Kopi".', 'ssst-child' ),
                    ],
                    [
                        'num'   => '02',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
                        'title' => __( 'Pilih Marketplace', 'ssst-child' ),
                        'desc'  => __( 'Klik tombol platform pilihanmu - Tokopedia, Shopee, TikTok Shop, dsb.', 'ssst-child' ),
                    ],
                    [
                        'num'   => '03',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>',
                        'title' => __( 'Selesaikan Pesanan', 'ssst-child' ),
                        'desc'  => __( 'Beli langsung di marketplace favorit kamu. Mudah, aman, sudah terpercaya.', 'ssst-child' ),
                    ],
                ];
                foreach ( $coffee_steps as $step ) : ?>
                <div class="ssst-howto-card ssst-reveal">
                    <div class="ssst-howto-card__number" aria-hidden="true"><?php echo esc_html( $step['num'] ); ?></div>
                    <div class="ssst-howto-card__icon" aria-hidden="true"><?php echo $step['icon']; // phpcs:ignore ?></div>
                    <h4 class="ssst-howto-card__title"><?php echo esc_html( $step['title'] ); ?></h4>
                    <p class="ssst-howto-card__desc"><?php echo esc_html( $step['desc'] ); ?></p>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Outlet pathway -->
            <h3 class="ssst-howto__channel" style="font-family:var(--font-hand);font-size:1.5rem;color:var(--c-coffee);text-align:center;margin:3rem 0 2rem;display:flex;align-items:center;justify-content:center;gap:.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <?php esc_html_e( 'Datang ke Outlet - Tanpa Buru-Buru', 'ssst-child' ); ?>
            </h3>
            <div class="ssst-howto__grid">
                <?php
                $outlet_steps = [
                    [
                        'num'   => '01',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
                        'title' => __( 'Pilih Outlet Terdekat', 'ssst-child' ),
                        'desc'  => __( 'Lihat daftar outlet kami lengkap dengan alamat dan jam buka di bagian Outlet.', 'ssst-child' ),
                    ],
                    [
                        'num'   => '02',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8z"/></svg>',
                        'title' => __( 'Buka Maps atau WhatsApp', 'ssst-child' ),
                        'desc'  => __( 'Cek rute lewat Google Maps, atau tanya langsung soal ketersediaan meja lewat WhatsApp.', 'ssst-child' ),
                    ],
                    [
                        'num'   => '03',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3h18v13H3z"/><path d="M8 21h8"/><path d="M12 16v5"/><path d="M7 8h10"/></svg>',
                        'title' => __( 'Pesan di Kasir', 'ssst-child' ),
                        'desc'  => __( 'Datang, duduk, dan pesan langsung di kasir outlet. Pembayaran di tempat dilayani lewat Pawoon.', 'ssst-child' ),
                    ],
                ];
                foreach ( $outlet_steps as $step ) : ?>
                <div class="ssst-howto-card ssst-reveal">
                    <div class="ssst-howto-card__number" aria-hidden="true"><?php echo esc_html( $step['num'] ); ?></div>
                    <div class="ssst-howto-card__icon" aria-hidden="true"><?php echo $step['icon']; // phpcs:ignore ?></div>
                    <h4 class="ssst-howto-card__title"><?php echo esc_html( $step['title'] ); ?></h4>
                    <p class="ssst-howto-card__desc"><?php echo esc_html( $step['desc'] ); ?></p>
                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

</main>

<?php get_footer(); ?>

