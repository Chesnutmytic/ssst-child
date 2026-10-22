<?php
/**
 * CPT: ssst_outlet - Data Outlet / Cabang
 *
 * @package ssst-child
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'ssst_register_cpt_outlet', 0 );

function ssst_register_cpt_outlet(): void {
    $labels = [
        'name'               => _x( 'Outlet', 'post type general name', 'ssst-child' ),
        'singular_name'      => _x( 'Outlet', 'post type singular name', 'ssst-child' ),
        'add_new'            => __( 'Tambah Outlet', 'ssst-child' ),
        'add_new_item'       => __( 'Tambah Outlet Baru', 'ssst-child' ),
        'edit_item'          => __( 'Edit Outlet', 'ssst-child' ),
        'all_items'          => __( 'Semua Outlet', 'ssst-child' ),
        'not_found'          => __( 'Tidak ada outlet ditemukan.', 'ssst-child' ),
        'menu_name'          => __( 'Outlet', 'ssst-child' ),
    ];

    register_post_type( 'ssst_outlet', [
        'labels'          => $labels,
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'show_in_rest'    => true,
        'menu_position'   => 26,
        'menu_icon'       => 'dashicons-location-alt',
        'supports'        => [ 'title', 'thumbnail', 'page-attributes' ],
        'has_archive'     => false,
        'rewrite'         => false,
        'capability_type' => 'post',
    ] );
}

add_action( 'add_meta_boxes', 'ssst_add_meta_box_outlet' );

function ssst_add_meta_box_outlet(): void {
    add_meta_box(
        'ssst_outlet_details',
        __( 'Detail Outlet', 'ssst-child' ),
        'ssst_render_meta_box_outlet',
        'ssst_outlet',
        'normal',
        'high'
    );
}

function ssst_render_meta_box_outlet( WP_Post $post ): void {
    wp_nonce_field( 'ssst_save_outlet_meta', 'ssst_outlet_nonce' );

    $address   = get_post_meta( $post->ID, '_ssst_outlet_address',   true );
    $hours     = get_post_meta( $post->ID, '_ssst_outlet_hours',     true );
    $gmaps     = get_post_meta( $post->ID, '_ssst_outlet_gmaps_url', true );
    $wa        = get_post_meta( $post->ID, '_ssst_outlet_whatsapp',  true );
    $is_open   = get_post_meta( $post->ID, '_ssst_outlet_is_open',   true );

    if ( '' === $is_open ) $is_open = '1';
    ?>
    <style>
        .ssst-mb { padding: 12px 0; border-bottom: 1px solid #eee; display: flex; flex-direction: column; gap: 6px; }
        .ssst-mb:last-child { border-bottom: none; }
        .ssst-mb label { font-weight: 600; font-size: 13px; }
        .ssst-mb input[type="text"], .ssst-mb input[type="url"],
        .ssst-mb textarea { width: 100%; max-width: 500px; }
    </style>

    <div class="ssst-mb">
        <label for="ssst_outlet_address"><?php esc_html_e( 'Alamat Lengkap', 'ssst-child' ); ?></label>
        <textarea id="ssst_outlet_address" name="ssst_outlet_address" rows="3"
                  placeholder="Jl. Contoh No. 12, Kelurahan, Kecamatan, Kota, Provinsi"><?php echo esc_textarea( $address ); ?></textarea>
    </div>

    <div class="ssst-mb">
        <label for="ssst_outlet_hours"><?php esc_html_e( 'Jam Operasional', 'ssst-child' ); ?></label>
        <textarea id="ssst_outlet_hours" name="ssst_outlet_hours" rows="2"
                  placeholder="Senin – Jumat: 08.00 – 22.00&#10;Sabtu – Minggu: 09.00 – 23.00"><?php echo esc_textarea( $hours ); ?></textarea>
    </div>

    <div class="ssst-mb">
        <label for="ssst_outlet_gmaps_url"><?php esc_html_e( 'Link Google Maps', 'ssst-child' ); ?></label>
        <input type="url" id="ssst_outlet_gmaps_url" name="ssst_outlet_gmaps_url"
               value="<?php echo esc_attr( $gmaps ); ?>"
               placeholder="https://maps.google.com/?q=...">
    </div>

    <div class="ssst-mb">
        <label for="ssst_outlet_whatsapp"><?php esc_html_e( 'Nomor WhatsApp', 'ssst-child' ); ?></label>
        <input type="text" id="ssst_outlet_whatsapp" name="ssst_outlet_whatsapp"
               value="<?php echo esc_attr( $wa ); ?>"
               placeholder="6281234567890">
        <p class="description"><?php esc_html_e( 'Format internasional tanpa + (contoh: 6281234567890)', 'ssst-child' ); ?></p>
    </div>

    <div class="ssst-mb">
        <label>
            <input type="checkbox" name="ssst_outlet_is_open" value="1" <?php checked( $is_open, '1' ); ?>>
            <?php esc_html_e( 'Outlet aktif / buka (tampilkan di website)', 'ssst-child' ); ?>
        </label>
    </div>
    <?php
}

add_action( 'save_post_ssst_outlet', 'ssst_save_meta_outlet', 10, 2 );

function ssst_save_meta_outlet( int $post_id, WP_Post $post ): void {
    if ( ! isset( $_POST['ssst_outlet_nonce'] ) ||
         ! wp_verify_nonce( sanitize_key( $_POST['ssst_outlet_nonce'] ), 'ssst_save_outlet_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    update_post_meta( $post_id, '_ssst_outlet_address',
        sanitize_textarea_field( $_POST['ssst_outlet_address'] ?? '' ) );
    update_post_meta( $post_id, '_ssst_outlet_hours',
        sanitize_textarea_field( $_POST['ssst_outlet_hours'] ?? '' ) );
    update_post_meta( $post_id, '_ssst_outlet_gmaps_url',
        esc_url_raw( $_POST['ssst_outlet_gmaps_url'] ?? '' ) );
    update_post_meta( $post_id, '_ssst_outlet_whatsapp',
        preg_replace( '/[^0-9]/', '', $_POST['ssst_outlet_whatsapp'] ?? '' ) );
    update_post_meta( $post_id, '_ssst_outlet_is_open',
        isset( $_POST['ssst_outlet_is_open'] ) ? '1' : '' );
}

// Kolom admin
add_filter( 'manage_ssst_outlet_posts_columns', function( $cols ) {
    $new = [];
    foreach ( $cols as $k => $v ) {
        $new[$k] = $v;
        if ( 'title' === $k ) {
            $new['ssst_outlet_status'] = __( 'Status', 'ssst-child' );
            $new['ssst_outlet_wa']     = __( 'WhatsApp', 'ssst-child' );
        }
    }
    return $new;
} );

add_action( 'manage_ssst_outlet_posts_custom_column', function( $col, $id ) {
    if ( 'ssst_outlet_status' === $col ) {
        $open = get_post_meta( $id, '_ssst_outlet_is_open', true );
        echo $open ? '<span style="color:#4A7C59;font-weight:700;">● Buka</span>'
                   : '<span style="color:#B5451A;">● Tutup</span>';
    }
    if ( 'ssst_outlet_wa' === $col ) {
        $wa = get_post_meta( $id, '_ssst_outlet_whatsapp', true );
        if ( $wa ) {
            echo '<a href="https://wa.me/' . esc_attr( $wa ) . '" target="_blank">' . esc_html( $wa ) . '</a>';
        } else {
            echo '-';
        }
    }
}, 10, 2 );
