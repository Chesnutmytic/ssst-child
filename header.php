<?php
/**
 * Site Header - ssst Coffee
 *
 * @package ssst-child
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Skip Navigation (aksesibilitas) -->
<a class="ssst-skip-link" href="#ssst-main-content">
    <?php esc_html_e( 'Langsung ke konten utama', 'ssst-child' ); ?>
</a>

<!-- =============================================
     SITE HEADER
     ============================================= -->
<header class="ssst-header" id="ssst-header" role="banner">
    <div class="ssst-container ssst-header__inner">

        <!-- Logo -->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
           class="ssst-logo"
           rel="home"
           aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' - ke beranda' ); ?>">
            ssst.
        </a>

        <!-- Nav Utama (Desktop) -->
        <nav class="ssst-nav" id="ssst-primary-nav" aria-label="<?php esc_attr_e( 'Navigasi utama', 'ssst-child' ); ?>">
            <ul class="ssst-nav__list" role="list">
                <li><a class="ssst-nav__link" href="<?php echo esc_url( home_url( '/#menu' ) ); ?>"><?php esc_html_e( 'Menu', 'ssst-child' ); ?></a></li>
                <li><a class="ssst-nav__link" href="<?php echo esc_url( home_url( '/#beli-kopi' ) ); ?>"><?php esc_html_e( 'Beli Kopi', 'ssst-child' ); ?></a></li>
                <li><a class="ssst-nav__link" href="<?php echo esc_url( home_url( '/#merchandise' ) ); ?>"><?php esc_html_e( 'Merchandise', 'ssst-child' ); ?></a></li>
                <li><a class="ssst-nav__link" href="<?php echo esc_url( home_url( '/#promo' ) ); ?>"><?php esc_html_e( 'Promo', 'ssst-child' ); ?></a></li>
                <li><a class="ssst-nav__link" href="<?php echo esc_url( home_url( '/#outlet' ) ); ?>"><?php esc_html_e( 'Outlet', 'ssst-child' ); ?></a></li>
            </ul>
        </nav>

        <!-- Actions: keranjang + hamburger -->
        <div class="ssst-header__actions">
            <?php if ( function_exists( 'WC' ) ) :
                $cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
            ?>
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>"
               class="ssst-cart-btn">
                <span class="sr-only"><?php esc_html_e( 'Keranjang belanja', 'ssst-child' ); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
                <span class="ssst-cart-count<?php echo $cart_count > 0 ? '' : ' is-empty'; ?>" aria-live="polite" aria-atomic="true">
                    <?php echo $cart_count > 0 ? esc_html( $cart_count ) : ''; ?>
                </span>
            </a>
            <?php endif; ?>

            <!-- Hamburger -->
            <button class="ssst-hamburger"
                    type="button"
                    aria-expanded="false"
                    aria-controls="ssst-nav-drawer"
                    aria-label="<?php esc_attr_e( 'Buka menu navigasi', 'ssst-child' ); ?>">
                <span class="ssst-hamburger__bar" aria-hidden="true"></span>
                <span class="ssst-hamburger__bar" aria-hidden="true"></span>
                <span class="ssst-hamburger__bar" aria-hidden="true"></span>
            </button>
        </div>

    </div><!-- .ssst-header__inner -->
</header>

<!-- Mobile Nav Drawer -->
<div class="ssst-drawer-overlay" aria-hidden="true" tabindex="-1"></div>
<nav id="ssst-nav-drawer"
     class="ssst-nav-drawer"
     aria-label="<?php esc_attr_e( 'Navigasi mobile', 'ssst-child' ); ?>"
     hidden>
    <div class="ssst-nav-drawer__inner">
        <ul class="ssst-nav-drawer__list" role="list">
            <li><a class="ssst-nav-drawer__link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Beranda', 'ssst-child' ); ?></a></li>
            <li><a class="ssst-nav-drawer__link" href="<?php echo esc_url( home_url( '/#menu' ) ); ?>"><?php esc_html_e( 'Menu', 'ssst-child' ); ?></a></li>
            <li><a class="ssst-nav-drawer__link" href="<?php echo esc_url( home_url( '/#beli-kopi' ) ); ?>"><?php esc_html_e( 'Beli Kopi', 'ssst-child' ); ?></a></li>
            <li><a class="ssst-nav-drawer__link" href="<?php echo esc_url( home_url( '/#merchandise' ) ); ?>"><?php esc_html_e( 'Merchandise', 'ssst-child' ); ?></a></li>
            <li><a class="ssst-nav-drawer__link" href="<?php echo esc_url( home_url( '/#promo' ) ); ?>"><?php esc_html_e( 'Promo', 'ssst-child' ); ?></a></li>
            <li><a class="ssst-nav-drawer__link" href="<?php echo esc_url( home_url( '/#outlet' ) ); ?>"><?php esc_html_e( 'Outlet', 'ssst-child' ); ?></a></li>
            <?php if ( function_exists( 'WC' ) ) : ?>
            <li>
                <a class="ssst-nav-drawer__link ssst-nav-drawer__link--cart"
                   href="<?php echo esc_url( wc_get_cart_url() ); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 0 1-8 0"/>
                    </svg>
                    <?php esc_html_e( 'Keranjang', 'ssst-child' ); ?>
                    <?php if ( $cart_count > 0 ) : ?>
                        <span class="ssst-cart-count ssst-cart-count--drawer"><?php echo esc_html( $cart_count ); ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <?php endif; ?>
        </ul>

        <div class="ssst-nav-drawer__footer">
            <p class="ssst-nav-drawer__tagline"><?php esc_html_e( 'Friendssst', 'ssst-child' ); ?></p>
        </div>
    </div>
</nav>

