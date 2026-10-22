<?php
/**
 * WooCommerce Setup Indonesia
 *
 * Konfigurasi WooCommerce untuk konteks Indonesia:
 * - Mata uang IDR dengan format Rp
 * - Separator ribuan titik, desimal koma, 0 desimal
 * - Field checkout disesuaikan (HP wajib, alamat Indonesia)
 * - Guest checkout aktif
 * - Default negara Indonesia
 *
 * CATATAN: Pengaturan ini menggunakan filter, bukan langsung
 * mengubah opsi WC di database. Pengaturan di WooCommerce >
 * General di wp-admin tetap berlaku dan lebih diprioritaskan
 * untuk sebagian besar opsi.
 *
 * @package ssst-child
 */

defined( 'ABSPATH' ) || exit;

// ============================================================
// 1. KONFIGURASI MATA UANG IDR
// ============================================================

/**
 * Pasang mata uang ke IDR saat tema diaktifkan pertama kali.
 * Ini dijalankan sekali lewat after_switch_theme.
 */
add_action( 'after_switch_theme', 'ssst_setup_woocommerce_indonesia' );

function ssst_setup_woocommerce_indonesia(): void {
    if ( ! function_exists( 'WC' ) ) {
        return;
    }

    $options = [
        'woocommerce_currency'           => 'IDR',
        'woocommerce_currency_pos'       => 'left',
        'woocommerce_price_thousand_sep' => '.',
        'woocommerce_price_decimal_sep'  => ',',
        'woocommerce_price_num_decimals' => '0',
        'woocommerce_default_country'    => 'ID',
        'woocommerce_allowed_countries'  => 'specific',
        'woocommerce_specific_allowed_countries' => [ 'ID' ],
        'woocommerce_default_customer_address'   => 'base',
        'woocommerce_calc_taxes'         => 'no',  // sesuaikan setelah konsultasi pajak
        'woocommerce_enable_guest_checkout' => 'yes',
        'woocommerce_enable_checkout_login_reminder' => 'yes',
        'woocommerce_enable_signup_and_login_from_checkout' => 'yes',
        'woocommerce_ship_to_countries'  => '',    // semua negara yang diizinkan
        'woocommerce_weight_unit'        => 'g',
        'woocommerce_dimension_unit'     => 'cm',
    ];

    foreach ( $options as $key => $value ) {
        // Hanya update jika belum pernah dikonfigurasi
        if ( false === get_option( $key ) ) {
            update_option( $key, $value );
        }
    }
}

// ============================================================
// 2. FILTER MATA UANG & FORMAT (fallback jika admin belum set)
// ============================================================
add_filter( 'woocommerce_currency', function( $currency ) {
    return $currency ?: 'IDR';
} );

add_filter( 'woocommerce_price_thousand_sep', function( $sep ) {
    return '.' === $sep ? $sep : '.';
} );

add_filter( 'woocommerce_price_decimal_sep', function( $sep ) {
    return ',' === $sep ? $sep : ',';
} );

add_filter( 'woocommerce_price_num_decimals', function( $num ) {
    return 0;
} );

// ============================================================
// 3. FIELD CHECKOUT INDONESIA
// ============================================================
// Prioritas 999: dijalankan setelah plugin lain agar label kita menang.
add_filter( 'woocommerce_checkout_fields', 'ssst_customize_checkout_fields', 999 );

/**
 * Sesuaikan field checkout untuk kebutuhan Indonesia:
 * - Label dalam Bahasa Indonesia
 * - HP wajib, validasi format
 * - Hapus field tidak relevan (fax, dsb.)
 * - Tambah placeholder informatif
 *
 * @param array $fields Array field checkout WooCommerce.
 * @return array
 */
function ssst_customize_checkout_fields( array $fields ): array {

    // --- BILLING ---
    if ( isset( $fields['billing'] ) ) {
        // Nama
        $fields['billing']['billing_first_name']['label']       = __( 'Nama Depan', 'ssst-child' );
        $fields['billing']['billing_first_name']['placeholder'] = __( 'Nama depan', 'ssst-child' );
        $fields['billing']['billing_last_name']['label']        = __( 'Nama Belakang', 'ssst-child' );
        $fields['billing']['billing_last_name']['placeholder']  = __( 'Nama belakang', 'ssst-child' );

        // Perusahaan - opsional, sembunyikan
        if ( isset( $fields['billing']['billing_company'] ) ) {
            $fields['billing']['billing_company']['required'] = false;
            $fields['billing']['billing_company']['class']    = [ 'form-row-wide', 'ssst-field-optional' ];
        }

        // Nomor HP - wajib, ganti label
        $fields['billing']['billing_phone']['label']       = __( 'Nomor HP / WhatsApp', 'ssst-child' );
        $fields['billing']['billing_phone']['placeholder'] = '08xxxxxxxxxx';
        $fields['billing']['billing_phone']['priority']    = 25; // dekat email
        $fields['billing']['billing_phone']['required']    = true;

        // Email
        $fields['billing']['billing_email']['label']       = __( 'Alamat Email', 'ssst-child' );
        $fields['billing']['billing_email']['placeholder'] = 'email@contoh.com';

        // Alamat
        $fields['billing']['billing_address_1']['label']       = __( 'Alamat Jalan', 'ssst-child' );
        $fields['billing']['billing_address_1']['placeholder'] = __( 'Nama jalan, nomor, RT/RW', 'ssst-child' );
        $fields['billing']['billing_address_2']['label']       = __( 'Kelurahan / Kecamatan', 'ssst-child' );
        $fields['billing']['billing_address_2']['placeholder'] = __( 'Kelurahan dan kecamatan', 'ssst-child' );

        // Kota
        $fields['billing']['billing_city']['label']       = __( 'Kota / Kabupaten', 'ssst-child' );
        $fields['billing']['billing_city']['placeholder'] = __( 'Kota atau kabupaten', 'ssst-child' );

        // Provinsi (WC pakai billing_state untuk Indonesia)
        $fields['billing']['billing_state']['label'] = __( 'Provinsi', 'ssst-child' );

        // Kode pos
        $fields['billing']['billing_postcode']['label']       = __( 'Kode Pos', 'ssst-child' );
        $fields['billing']['billing_postcode']['placeholder'] = '12345';
    }

    // --- SHIPPING ---
    if ( isset( $fields['shipping'] ) ) {
        $fields['shipping']['shipping_address_1']['label']       = __( 'Alamat Jalan', 'ssst-child' );
        $fields['shipping']['shipping_address_1']['placeholder'] = __( 'Nama jalan, nomor, RT/RW', 'ssst-child' );
        $fields['shipping']['shipping_address_2']['label']       = __( 'Kelurahan / Kecamatan', 'ssst-child' );
        $fields['shipping']['shipping_address_2']['placeholder'] = __( 'Kelurahan dan kecamatan', 'ssst-child' );
        $fields['shipping']['shipping_city']['label']            = __( 'Kota / Kabupaten', 'ssst-child' );
        $fields['shipping']['shipping_state']['label']           = __( 'Provinsi', 'ssst-child' );
        $fields['shipping']['shipping_postcode']['label']        = __( 'Kode Pos', 'ssst-child' );

        if ( isset( $fields['shipping']['shipping_company'] ) ) {
            $fields['shipping']['shipping_company']['required'] = false;
        }
    }

    // --- ORDER NOTES ---
    if ( isset( $fields['order']['order_comments'] ) ) {
        $fields['order']['order_comments']['label']       = __( 'Catatan Pesanan', 'ssst-child' );
        $fields['order']['order_comments']['placeholder'] = __( 'Instruksi khusus untuk pengiriman, dsb.', 'ssst-child' );
    }

    return $fields;
}

// ============================================================
// 4. VALIDASI NOMOR HP INDONESIA
// ============================================================
add_action( 'woocommerce_checkout_process', 'ssst_validate_phone_number' );

function ssst_validate_phone_number(): void {
    $phone = isset( $_POST['billing_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['billing_phone'] ) ) : '';

    if ( empty( $phone ) ) {
        return; // Required validation handled by WC
    }

    // Hapus spasi, dash, tanda kurung untuk validasi
    $clean = preg_replace( '/[\s\-\(\)]/', '', $phone );

    // Format valid: 08xx... (minimal 10 digit) atau 628xx...
    if ( ! preg_match( '/^(0|62)[0-9]{8,13}$/', $clean ) ) {
        wc_add_notice(
            __( 'Nomor HP tidak valid. Gunakan format 08xxx atau 628xxx.', 'ssst-child' ),
            'error'
        );
    }
}

// ============================================================
// 5. TEKS WooCommerce - BAHASA INDONESIA UNTUK ELEMEN KUNCI
// ============================================================
add_filter( 'gettext', 'ssst_wc_translate_text', 20, 3 );

/**
 * Override teks WooCommerce tertentu ke Bahasa Indonesia.
 * Ini lebih cepat daripada memuat locale penuh.
 *
 * @param string $translated Teks yang sudah diterjemahkan.
 * @param string $text       Teks asli.
 * @param string $domain     Text domain.
 * @return string
 */
function ssst_wc_translate_text( string $translated, string $text, string $domain ): string {
    if ( 'woocommerce' !== $domain ) {
        return $translated;
    }

    $translations = [
        'Add to cart'          => 'Tambah ke Keranjang',
        'View cart'            => 'Lihat Keranjang',
        'Proceed to checkout'  => 'Lanjut ke Checkout',
        'Place order'          => 'Buat Pesanan',
        'Your cart is currently empty.' => 'Keranjang Anda masih kosong.',
        'Return to shop'       => 'Kembali ke Toko',
        'Coupon code'          => 'Kode Kupon',
        'Apply coupon'         => 'Pakai Kupon',
        'Update cart'          => 'Perbarui Keranjang',
        'Order total'          => 'Total Pesanan',
        'Subtotal'             => 'Subtotal',
        'Shipping'             => 'Ongkos Kirim',
        'Tax'                  => 'Pajak',
        'Thank you. Your order has been received.' => 'Terima kasih! Pesanan Anda telah diterima.',
        'Order number'         => 'Nomor Pesanan',
        'Date'                 => 'Tanggal',
        'Total'                => 'Total',
        'Payment method'       => 'Metode Pembayaran',
        'In stock'             => 'Tersedia',
        'Out of stock'         => 'Habis',
        'Product'              => 'Produk',
        'Price'                => 'Harga',
        'Quantity'             => 'Jumlah',
        'No products were found matching your selection.' => 'Tidak ada produk yang ditemukan.',
        'Click here to enter your code' => 'Masukkan kode kupon Anda',
    ];

    return $translations[ $text ] ?? $translated;
}

// ============================================================
// 6. AKTIFKAN GUEST CHECKOUT VIA FILTER
// ============================================================
add_filter( 'woocommerce_checkout_registration_required', '__return_false' );

// ============================================================
// 7. SEMBUNYIKAN KOLOM "COMPANY" DI CHECKOUT JIKA KOSONG
// ============================================================
add_filter( 'woocommerce_enable_order_notes_field', '__return_true' );

// ============================================================
// 8. NOTIFIKASI EMAIL - SESUAIKAN SUBJEK EMAIL
// ============================================================
add_filter( 'woocommerce_email_subject_new_order', function( $subject, $order ) {
    return sprintf(
        '[ssst] Pesanan Baru #%s dari %s',
        $order->get_order_number(),
        $order->get_billing_first_name() . ' ' . $order->get_billing_last_name()
    );
}, 10, 2 );

add_filter( 'woocommerce_email_subject_customer_processing_order', function( $subject, $order ) {
    return sprintf(
        '[ssst] Pesanan #%s Anda Sedang Diproses',
        $order->get_order_number()
    );
}, 10, 2 );

add_filter( 'woocommerce_email_subject_customer_completed_order', function( $subject, $order ) {
    return sprintf(
        '[ssst] Pesanan #%s Anda Sudah Dikirim!',
        $order->get_order_number()
    );
}, 10, 2 );


// ============================================================
// 3b. PASTIKAN LABEL & ATRIBUT FIELD IKUT DESAIN SSST
//     Beberapa plugin membangun ulang argumen form field,
//     jadi kita set ulang di filter paling akhir.
// ============================================================
add_filter( 'woocommerce_form_field_args', 'ssst_checkout_form_field_args', 9999, 3 );

/**
 * @param array  $args  Argumen field.
 * @param string $key   Nama field.
 * @param mixed  $value Nilai field.
 * @return array
 */
function ssst_checkout_form_field_args( array $args, string $key, $value ): array {
    $overrides = [
        'billing_first_name' => [
            'label'       => 'Nama Depan',
            'placeholder' => 'Nama depan',
            'required'    => true,
        ],
        'billing_last_name'  => [
            'label'       => 'Nama Belakang',
            'placeholder' => 'Nama belakang',
            'required'    => true,
        ],
        'billing_phone'      => [
            'label'       => 'Nomor HP / WhatsApp',
            'placeholder' => '08xxxxxxxxxx',
            'required'    => true,
            'class'       => [ 'form-row-wide' ],
        ],
        'billing_email'      => [
            'label'       => 'Alamat Email',
            'placeholder' => 'email@contoh.com',
            'required'    => true,
        ],
        'billing_address_1'  => [
            'label'       => 'Alamat Jalan',
            'placeholder' => 'Nama jalan, nomor, RT/RW',
            'required'    => true,
        ],
        'billing_address_2'  => [
            'label'       => 'Kelurahan / Kecamatan',
            'placeholder' => 'Kelurahan dan kecamatan',
            'required'    => false,
        ],
        'billing_city'       => [
            'label'       => 'Kota / Kabupaten',
            'placeholder' => 'Kota atau kabupaten',
            'required'    => true,
        ],
        'billing_state'      => [
            'label'    => 'Provinsi',
            'required' => true,
        ],
        'billing_postcode'   => [
            'label'       => 'Kode Pos',
            'placeholder' => '12345',
            'required'    => true,
        ],
        'order_comments'     => [
            'label'       => 'Catatan Pesanan',
            'placeholder' => 'Instruksi khusus untuk pengiriman, dsb. (opsional)',
            'required'    => false,
        ],
    ];

    if ( isset( $overrides[ $key ] ) ) {
        $args = array_merge( $args, $overrides[ $key ] );
        if ( 'billing_phone' === $key ) { file_put_contents( WP_CONTENT_DIR . '/fieldargs.log', date('c').' AFTER label='.$args['label'].' req='.var_export($args['required'],true).PHP_EOL, FILE_APPEND ); }
    }

    return $args;
}


