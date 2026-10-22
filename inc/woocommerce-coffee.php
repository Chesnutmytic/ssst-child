<?php
/**
 * WooCommerce Coffee Products Logic
 *
 * Mengelola produk kopi yang TIDAK dijual langsung di website:
 * - Tambah custom field URL marketplace ke halaman edit produk
 * - Blokir add-to-cart untuk produk dalam kategori 'kopi'
 * - Tampilkan tombol marketplace di halaman produk kopi
 * - Sembunyikan tombol "Tambah ke Keranjang" di loop (katalog)
 * - Cegah akses langsung ke checkout via URL manipulation
 *
 * CARA KERJA:
 * 1. Buat kategori WooCommerce "Kopi" (slug: kopi) di wp-admin
 * 2. Masukkan produk kopi ke kategori tersebut
 * 3. Isi URL marketplace di meta box "Link Marketplace" di halaman edit produk
 * 4. Tombol marketplace akan otomatis muncul di halaman produk
 *
 * @package ssst-child
 */

defined( 'ABSPATH' ) || exit;

// Slug kategori produk kopi - ubah jika berbeda di wp-admin
define( 'SSST_COFFEE_CAT_SLUG', 'kopi' );

// ============================================================
// HELPER: Cek apakah produk termasuk kategori kopi
// ============================================================

/**
 * @param int|\WC_Product $product ID atau objek produk.
 * @return bool
 */
function ssst_is_coffee_product( int|\WC_Product $product ): bool {
    $product_id = $product instanceof \WC_Product ? $product->get_id() : $product;
    return has_term( SSST_COFFEE_CAT_SLUG, 'product_cat', $product_id );
}

// ============================================================
// 1. META BOX LINK MARKETPLACE DI EDITOR PRODUK
// ============================================================
add_action( 'add_meta_boxes', 'ssst_add_marketplace_meta_box' );

function ssst_add_marketplace_meta_box(): void {
    add_meta_box(
        'ssst_marketplace_links',
        __( 'Link Marketplace (Produk Kopi)', 'ssst-child' ),
        'ssst_render_marketplace_meta_box',
        'product',
        'side',
        'default'
    );
}

function ssst_render_marketplace_meta_box( WP_Post $post ): void {
    wp_nonce_field( 'ssst_save_marketplace_meta', 'ssst_marketplace_nonce' );

    $platforms = ssst_get_marketplace_platforms();
    ?>
    <p style="color:#666;font-size:12px;margin-bottom:12px;">
        <?php esc_html_e( 'Untuk produk kopi: isi URL marketplace tempat produk dijual. URL kosong = tombol tidak muncul. Khusus kategori "Kopi" - produk jenis ini tidak bisa masuk keranjang.', 'ssst-child' ); ?>
    </p>
    <?php foreach ( $platforms as $key => $label ) :
        $meta_key = "_ssst_coffee_{$key}_url";
        $value    = get_post_meta( $post->ID, $meta_key, true );
    ?>
    <div style="margin-bottom:10px;">
        <label for="<?php echo esc_attr( $meta_key ); ?>" style="display:block;font-weight:600;font-size:12px;margin-bottom:3px;">
            <?php echo esc_html( $label ); ?>
        </label>
        <input type="url"
               id="<?php echo esc_attr( $meta_key ); ?>"
               name="<?php echo esc_attr( $meta_key ); ?>"
               value="<?php echo esc_attr( $value ); ?>"
               style="width:100%;"
               placeholder="https://...">
    </div>
    <?php endforeach;
}

/**
 * Daftar platform marketplace.
 * Key = digunakan untuk nama meta field dan CSS class.
 *
 * @return array<string, string>
 */
function ssst_get_marketplace_platforms(): array {
    return [
        'tokopedia' => 'Tokopedia',
        'shopee'    => 'Shopee',
        'tiktok'    => 'TikTok Shop',
        'gofood'    => 'GoFood',
        'grabfood'  => 'GrabFood',
    ];
}

// ============================================================
// 2. SIMPAN FIELD MARKETPLACE
// ============================================================
add_action( 'save_post_product', 'ssst_save_marketplace_meta', 10, 2 );

function ssst_save_marketplace_meta( int $post_id, WP_Post $post ): void {
    if ( ! isset( $_POST['ssst_marketplace_nonce'] ) ||
         ! wp_verify_nonce( sanitize_key( $_POST['ssst_marketplace_nonce'] ), 'ssst_save_marketplace_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    foreach ( array_keys( ssst_get_marketplace_platforms() ) as $key ) {
        $meta_key = "_ssst_coffee_{$key}_url";
        $value    = isset( $_POST[ $meta_key ] ) ? esc_url_raw( wp_unslash( $_POST[ $meta_key ] ) ) : '';
        update_post_meta( $post_id, $meta_key, $value );
    }
}

// ============================================================
// 3. BLOKIR ADD-TO-CART UNTUK PRODUK KOPI
// ============================================================

/**
 * Redirect ke halaman produk jika mencoba add-to-cart produk kopi.
 * Ini menangkap request ?add-to-cart=ID lewat URL.
 */
add_filter( 'woocommerce_add_to_cart_validation', 'ssst_prevent_coffee_add_to_cart', 10, 2 );

function ssst_prevent_coffee_add_to_cart( bool $passed, int $product_id ): bool {
    if ( ! $passed ) {
        return $passed;
    }

    if ( ssst_is_coffee_product( $product_id ) ) {
        wc_add_notice(
            __( 'Produk kopi ini tidak dijual langsung di website. Gunakan tombol marketplace di bawah.', 'ssst-child' ),
            'error'
        );
        return false;
    }

    return $passed;
}

/**
 * Sembunyikan tombol "Tambah ke Keranjang" di loop katalog untuk produk kopi.
 */
add_filter( 'woocommerce_loop_add_to_cart_link', 'ssst_coffee_loop_button', 10, 2 );

function ssst_coffee_loop_button( string $button, \WC_Product $product ): string {
    if ( ssst_is_coffee_product( $product ) ) {
        $url = get_permalink( $product->get_id() );
        return sprintf(
            '<a href="%s" class="button btn btn--secondary ssst-view-product-btn" aria-label="%s">%s</a>',
            esc_url( $url ),
            esc_attr( sprintf( __( 'Lihat produk %s', 'ssst-child' ), $product->get_name() ) ),
            esc_html__( 'Lihat Produk', 'ssst-child' )
        );
    }
    return $button;
}

// ============================================================
// 4. TOMBOL MARKETPLACE DI HALAMAN SINGLE PRODUCT
// ============================================================

/**
 * Tampilkan tombol marketplace untuk produk kopi
 * dan sembunyikan form add-to-cart standar WC.
 */
add_action( 'woocommerce_single_product_summary', 'ssst_coffee_marketplace_buttons', 30 );

function ssst_coffee_marketplace_buttons(): void {
    global $product;

    if ( ! $product || ! ssst_is_coffee_product( $product ) ) {
        return;
    }

    $platforms = ssst_get_marketplace_platforms();
    $has_any   = false;

    // Kumpulkan platform yang punya URL
    $active_platforms = [];
    foreach ( $platforms as $key => $label ) {
        $url = get_post_meta( $product->get_id(), "_ssst_coffee_{$key}_url", true );
        if ( ! empty( $url ) ) {
            $active_platforms[ $key ] = [ 'label' => $label, 'url' => $url ];
            $has_any = true;
        }
    }

    if ( ! $has_any ) {
        echo '<p class="ssst-notice ssst-notice--warning">'
           . esc_html__( 'Produk ini belum tersedia di marketplace. Hubungi kami untuk informasi lebih lanjut.', 'ssst-child' )
           . '</p>';
        return;
    }

    $product_name = $product->get_name();
    ?>
    <div class="ssst-marketplace-section">
        <p class="ssst-marketplace-section__label">
            <?php esc_html_e( 'Beli di marketplace pilihan kamu:', 'ssst-child' ); ?>
        </p>
        <div class="ssst-marketplace-section__btns">
            <?php foreach ( $active_platforms as $key => $info ) :
                $svg_path = SSST_DIR . "/assets/svg/marketplace/{$key}.svg";
            ?>
            <a href="<?php echo esc_url( $info['url'] ); ?>"
               class="ssst-market-btn ssst-market-btn--<?php echo esc_attr( $key ); ?>"
               target="_blank"
               rel="noopener noreferrer"
               data-ssst-track="marketplace"
               data-ssst-platform="<?php echo esc_attr( $key ); ?>"
               data-ssst-product="<?php echo esc_attr( $product_name ); ?>">
                <?php if ( file_exists( $svg_path ) ) :
                    ssst_svg( "marketplace/{$key}", [ 'aria-hidden' => 'true', 'width' => '18', 'height' => '18' ] );
                endif; ?>
                <?php echo esc_html( $info['label'] ); ?>
                <span class="sr-only"><?php esc_html_e( '(buka di tab baru)', 'ssst-child' ); ?></span>
            </a>
            <?php endforeach; ?>
        </div>
        <p class="ssst-marketplace-section__note">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:inline-block;vertical-align:-2px;margin-right:4px;"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            <?php esc_html_e( 'Tautan di atas akan membuka halaman marketplace di tab baru.', 'ssst-child' ); ?>
        </p>
    </div>
    <?php
}

/**
 * Sembunyikan form add-to-cart WC standar untuk produk kopi.
 */
add_filter( 'woocommerce_is_purchasable', 'ssst_coffee_not_purchasable', 10, 2 );

function ssst_coffee_not_purchasable( bool $purchasable, \WC_Product $product ): bool {
    if ( ssst_is_coffee_product( $product ) ) {
        return false;
    }
    return $purchasable;
}

/**
 * Tampilkan pesan pengganti add-to-cart untuk produk kopi.
 */
add_action( 'woocommerce_single_product_summary', 'ssst_coffee_not_for_sale_notice', 25 );

function ssst_coffee_not_for_sale_notice(): void {
    global $product;

    if ( ! $product || ! ssst_is_coffee_product( $product ) ) {
        return;
    }
    ?>
    <div class="ssst-notice ssst-notice--warning ssst-notice--coffee" role="status" style="margin-bottom:1rem;display:flex;align-items:center;gap:0.75rem;">
        <span class="ssst-notice__icon" aria-hidden="true" style="display:inline-flex;color:var(--c-caramel);">
            <?php ssst_svg( 'doodles/bean', [ 'style' => 'width:20px;height:20px;' ] ); ?>
        </span>
        <span><?php esc_html_e( 'Produk kopi ini tersedia di marketplace - pilih platform di bawah.', 'ssst-child' ); ?></span>
    </div>
    <?php
}

// ============================================================
// 5. CSS MARKETPLACE SECTION (inline, hanya di single product)
// ============================================================
add_action( 'wp_head', 'ssst_coffee_inline_styles' );

function ssst_coffee_inline_styles(): void {
    if ( ! is_product() ) return;
    ?>
    <style>
    .ssst-marketplace-section { margin-top: 1.5rem; }
    .ssst-marketplace-section__label {
        font-family: var(--font-hand, cursive);
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--c-coffee, #3D2B1F);
        margin-bottom: 0.75rem;
    }
    .ssst-marketplace-section__btns {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }
    .ssst-marketplace-section__note {
        font-size: 0.8rem;
        color: var(--c-roast, #5C3D2E);
        opacity: 0.7;
    }
    </style>
    <?php
}

/* ============================================================
 * 6. HELPER: URL TOKO MARKETPLACE (untuk footer)
 * ============================================================ */

/**
 * Ambil satu URL contoh per marketplace dari produk kopi.
 * Dipakai footer agar tautan hanya muncul jika datanya ada.
 *
 * @return array<string, string>
 */
function ssst_get_marketplace_store_urls(): array {
    static $urls = null;

    if ( null !== $urls ) {
        return $urls;
    }

    $urls      = [];
    $coffee_ids = get_posts( [
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => 20,
        'fields'         => 'ids',
        'tax_query'      => [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => SSST_COFFEE_CAT_SLUG,
            ],
        ],
    ] );

    foreach ( $coffee_ids as $product_id ) {
        foreach ( array_keys( ssst_get_marketplace_platforms() ) as $key ) {
            if ( ! empty( $urls[ $key ] ) ) {
                continue;
            }
            $url = get_post_meta( $product_id, "_ssst_coffee_{$key}_url", true );
            if ( $url ) {
                $urls[ $key ] = $url;
            }
        }
    }

    return $urls;
}

/* ============================================================
 * 7. SEMBUNYIKAN PRODUK KOPI DARI KATALOG TOKO
 *    Kopi tetap bisa diakses lewat landing & halaman produk,
 *    tetapi tidak muncul di toko merchandise.
 * ============================================================ */
add_action( 'woocommerce_product_query', function ( $query ) {
    if ( is_admin() ) {
        return;
    }

    $tax_query   = (array) $query->get( 'tax_query' );
    $tax_query[] = [
        'taxonomy' => 'product_cat',
        'field'    => 'slug',
        'terms'    => SSST_COFFEE_CAT_SLUG,
        'operator' => 'NOT IN',
    ];

    $query->set( 'tax_query', $tax_query );
} );

/* ============================================================
 * 8. HAPUS TOMBOL "BELI DI MARKETPLACE" EKSTERNAL
 *    Produk kopi memakai tombol marketplace ssst sendiri.
 * ============================================================ */
add_action( 'wp', function (): void {
    if ( ! is_product() ) {
        return;
    }

    $product_id = get_queried_object_id();
    if ( $product_id && ssst_is_coffee_product( $product_id ) ) {
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    }
} );

/* ============================================================
 * 9. ARIA LABEL TOMBOL KERANJANG DI KATALOG
 *    Pastikan teks aksesibel memuat teks yang terlihat
 *    (menghindari label-content-name-mismatch).
 * ============================================================ */
add_filter( 'woocommerce_loop_add_to_cart_link', 'ssst_fix_loop_button_aria', 20, 2 );

/**
 * @param string     $html    HTML tombol.
 * @param WC_Product $product Produk.
 * @return string
 */
function ssst_fix_loop_button_aria( string $html, $product ): string {
    if ( ! $product instanceof WC_Product || ssst_is_coffee_product( $product ) ) {
        return $html;
    }

    $visible = $product->is_type( 'variable' )
        ? __( 'Pilih opsi', 'ssst-child' )
        : __( 'Tambah ke Keranjang', 'ssst-child' );

    $label = $visible . ': ' . $product->get_name();

    return preg_replace(
        '/aria-label="[^"]*"/',
        'aria-label="' . esc_attr( $label ) . '"',
        $html,
        1
    );
}
