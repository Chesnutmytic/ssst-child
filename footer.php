<?php
/**
 * Site Footer - ssst Coffee
 *
 * @package ssst-child
 */

defined( 'ABSPATH' ) || exit;

$ssst_shipping_page = get_page_by_path( 'kebijakan-pengiriman' );
$ssst_return_page   = get_page_by_path( 'kebijakan-pengembalian' );
$ssst_store_urls    = function_exists( 'ssst_get_marketplace_store_urls' ) ? ssst_get_marketplace_store_urls() : [];
$ssst_platforms     = function_exists( 'ssst_get_marketplace_platforms' ) ? ssst_get_marketplace_platforms() : [];
?>

<!-- =============================================
     SITE FOOTER
     ============================================= -->
<footer class="ssst-footer" role="contentinfo">

    <!-- Wavy divider -->
    <div class="ssst-footer__wave" aria-hidden="true">
        <?php ssst_svg( 'decorative/wavy-line', [ 'class' => 'ssst-wavy-divider' ] ); ?>
    </div>

    <div class="ssst-container ssst-footer__grid">

        <!-- Kolom 1: Brand -->
        <div class="ssst-footer__brand">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
               class="ssst-footer__logo"
               aria-label="<?php esc_attr_e( 'ssst Coffee - ke beranda', 'ssst-child' ); ?>">
                ssst.
            </a>
            <p class="ssst-footer__tagline">
                <?php esc_html_e( 'Friendssst', 'ssst-child' ); ?>
            </p>
            <p class="ssst-footer__desc">
                <?php esc_html_e( 'Coffee shop dengan biji kopi pilihan, merchandise hangat, dan suasana yang nyaman untuk ngobrol atau santai bekerja.', 'ssst-child' ); ?>
            </p>

            <ul class="ssst-footer__contact" role="list">
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <a href="mailto:halo@ssst.id">halo@ssst.id</a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer">0812-3456-7890</a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span><?php esc_html_e( 'Jl. Kemang Raya No. 18, Jakarta Selatan', 'ssst-child' ); ?></span>
                </li>
            </ul>

            <!-- Sosial Media -->
            <div class="ssst-footer__social" aria-label="<?php esc_attr_e( 'Media sosial ssst Coffee', 'ssst-child' ); ?>">
                <?php
                $socials = [
                    'instagram' => [
                        'url'   => 'https://instagram.com/ssst.coffee',
                        'label' => 'Instagram ssst Coffee',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
                    ],
                    'tiktok' => [
                        'url'   => 'https://tiktok.com/@ssst.coffee',
                        'label' => 'TikTok ssst Coffee',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.28 6.28 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.53V6.77a4.85 4.85 0 0 1-1.01-.08z"/></svg>',
                    ],
                ];
                foreach ( $socials as $key => $s ) :
                ?>
                <a href="<?php echo esc_url( $s['url'] ); ?>"
                   class="ssst-social-btn"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="<?php echo esc_attr( $s['label'] ); ?>">
                    <?php echo $s['icon']; // phpcs:ignore WordPress.Security.EscapeOutput ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Kolom 2: Navigasi -->
        <div class="ssst-footer__nav">
            <h3 class="ssst-footer__nav-heading"><?php esc_html_e( 'Navigasi', 'ssst-child' ); ?></h3>
            <ul class="ssst-footer__nav-list" role="list">
                <li><a href="<?php echo esc_url( home_url( '/#menu' ) ); ?>"><?php esc_html_e( 'Menu Kafe', 'ssst-child' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/#beli-kopi' ) ); ?>"><?php esc_html_e( 'Beli Kopi', 'ssst-child' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/#merchandise' ) ); ?>"><?php esc_html_e( 'Merchandise', 'ssst-child' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/#promo' ) ); ?>"><?php esc_html_e( 'Promo', 'ssst-child' ); ?></a></li>
                <li><a href="<?php echo esc_url( home_url( '/#outlet' ) ); ?>"><?php esc_html_e( 'Outlet', 'ssst-child' ); ?></a></li>
            </ul>
        </div>

        <!-- Kolom 3: Marketplace Kopi -->
        <div class="ssst-footer__nav">
            <h3 class="ssst-footer__nav-heading"><?php esc_html_e( 'Beli Kopi Online', 'ssst-child' ); ?></h3>
            <ul class="ssst-footer__nav-list" role="list">
                <?php
                $ssst_has_marketplace = false;
                foreach ( $ssst_platforms as $key => $label ) :
                    $url = $ssst_store_urls[ $key ] ?? '';
                    if ( ! $url ) {
                        continue;
                    }
                    $ssst_has_marketplace = true;
                    ?>
                    <li>
                        <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo esc_html( $label ); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <?php if ( ! $ssst_has_marketplace ) : ?>
                    <li><a href="<?php echo esc_url( home_url( '/#beli-kopi' ) ); ?>"><?php esc_html_e( 'Lihat di halaman Beli Kopi', 'ssst-child' ); ?></a></li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Kolom 4: Info -->
        <div class="ssst-footer__nav">
            <h3 class="ssst-footer__nav-heading"><?php esc_html_e( 'Informasi', 'ssst-child' ); ?></h3>
            <ul class="ssst-footer__nav-list" role="list">
                <?php if ( function_exists( 'WC' ) ) : ?>
                <li><a href="<?php echo esc_url( wc_get_cart_url() ); ?>"><?php esc_html_e( 'Keranjang', 'ssst-child' ); ?></a></li>
                <li><a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"><?php esc_html_e( 'Checkout', 'ssst-child' ); ?></a></li>
                <li><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'Akun Saya', 'ssst-child' ); ?></a></li>
                <?php endif; ?>
                <?php if ( $ssst_shipping_page ) : ?>
                    <li><a href="<?php echo esc_url( get_permalink( $ssst_shipping_page ) ); ?>"><?php esc_html_e( 'Kebijakan Pengiriman', 'ssst-child' ); ?></a></li>
                <?php endif; ?>
                <?php if ( $ssst_return_page ) : ?>
                    <li><a href="<?php echo esc_url( get_permalink( $ssst_return_page ) ); ?>"><?php esc_html_e( 'Kebijakan Pengembalian', 'ssst-child' ); ?></a></li>
                <?php endif; ?>
                <li><a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Kebijakan Privasi', 'ssst-child' ); ?></a></li>
            </ul>
        </div>

    </div><!-- .ssst-footer__grid -->

    <!-- Footer bottom bar -->
    <div class="ssst-footer__bottom">
        <div class="ssst-container ssst-footer__bottom-inner">
            <p class="ssst-footer__copyright">
                &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">ssst Coffee</a>.
                <?php esc_html_e( 'All rights reserved.', 'ssst-child' ); ?>
            </p>
            <p class="ssst-footer__made-with">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/><line x1="6" y1="2" x2="6" y2="4"/><line x1="10" y1="2" x2="10" y2="4"/><line x1="14" y1="2" x2="14" y2="4"/></svg>
                <?php esc_html_e( 'Dibuat dengan kopi dan kode.', 'ssst-child' ); ?>
            </p>
        </div>
    </div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
