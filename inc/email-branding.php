<?php
/**
 * Branding email transaksi WooCommerce.
 *
 * Menyesuaikan warna, tipografi, dan footer email agar sesuai
 * identitas ssst. Email klien tidak memuat font kustom, jadi
 * judul memakai Georgia (serif) sebagai pengganti hangat.
 *
 * @package ssst-child
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'woocommerce_email_styles', 'ssst_email_styles', 20 );

/**
 * Tambahan CSS untuk template email WooCommerce.
 *
 * @param string $css CSS bawaan WooCommerce.
 * @return string
 */
function ssst_email_styles( string $css ): string {
    $css .= '
        body, #body_content {
            background-color: #F5EFE0 !important;
        }
        #body_content_inner {
            color: #3D2B1F !important;
            font-family: "Nunito Sans", Helvetica, Arial, sans-serif !important;
            font-size: 15px;
            line-height: 1.7;
        }
        #header_wrapper {
            background-color: #3D2B1F !important;
            padding-top: 26px !important;
            padding-bottom: 20px !important;
        }
        h1 {
            color: #FAF7F0 !important;
            font-family: Georgia, "Times New Roman", serif !important;
            font-size: 30px !important;
            letter-spacing: 0.02em;
        }
        h2, h3 {
            color: #3D2B1F !important;
            font-family: Georgia, "Times New Roman", serif !important;
        }
        a {
            color: #8A4A20 !important;
        }
        .ssst-email-tagline {
            margin: 6px 0 0;
            color: #E8D5B7;
            font-family: Georgia, serif;
            font-size: 15px;
            font-style: italic;
        }
        table.td, .td {
            border-color: #E8D5B7 !important;
        }
        .td {
            background-color: #FAF7F0 !important;
        }
        a.button, .button, #place_order {
            background-color: #C8763A !important;
            border: 2px solid #1A0F0A !important;
            border-radius: 4px !important;
            color: #1A0F0A !important;
            font-weight: 700 !important;
        }
        .address {
            color: #5C3D2E !important;
        }
    ';

    return $css;
}

/**
 * Tagline di bawah judul email.
 */
add_action( 'woocommerce_email_header', 'ssst_email_tagline', 20 );

function ssst_email_tagline(): void {
    echo '<p class="ssst-email-tagline">' . esc_html__( 'Friendssst', 'ssst-child' ) . '</p>';
}
