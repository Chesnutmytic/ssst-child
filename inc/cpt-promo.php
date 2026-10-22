<?php
/**
 * CPT: ssst_promo - Promo Aktif
 *
 * @package ssst-child
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'ssst_register_cpt_promo', 0 );

function ssst_register_cpt_promo(): void {
    register_post_type( 'ssst_promo', [
        'labels'          => [
            'name'               => _x( 'Promo', 'post type general name', 'ssst-child' ),
            'singular_name'      => _x( 'Promo', 'post type singular name', 'ssst-child' ),
            'add_new'            => __( 'Tambah Promo', 'ssst-child' ),
            'add_new_item'       => __( 'Tambah Promo Baru', 'ssst-child' ),
            'edit_item'          => __( 'Edit Promo', 'ssst-child' ),
            'all_items'          => __( 'Semua Promo', 'ssst-child' ),
            'not_found'          => __( 'Tidak ada promo ditemukan.', 'ssst-child' ),
            'menu_name'          => __( 'Promo', 'ssst-child' ),
        ],
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'show_in_rest'    => true,
        'menu_position'   => 27,
        'menu_icon'       => 'dashicons-tag',
        'supports'        => [ 'title', 'thumbnail', 'page-attributes' ],
        'has_archive'     => false,
        'rewrite'         => false,
        'capability_type' => 'post',
    ] );
}

add_action( 'add_meta_boxes', 'ssst_add_meta_box_promo' );

function ssst_add_meta_box_promo(): void {
    add_meta_box(
        'ssst_promo_details',
        __( 'Detail Promo', 'ssst-child' ),
        'ssst_render_meta_box_promo',
        'ssst_promo',
        'normal',
        'high'
    );
}

function ssst_render_meta_box_promo( WP_Post $post ): void {
    wp_nonce_field( 'ssst_save_promo_meta', 'ssst_promo_nonce' );

    $label       = get_post_meta( $post->ID, '_ssst_promo_label',       true );
    $desc        = get_post_meta( $post->ID, '_ssst_promo_description',  true );
    $valid_until = get_post_meta( $post->ID, '_ssst_promo_valid_until',  true );
    $code        = get_post_meta( $post->ID, '_ssst_promo_code',         true );
    ?>
    <style>
        .ssst-mb{padding:12px 0;border-bottom:1px solid #eee;display:flex;flex-direction:column;gap:6px;}
        .ssst-mb:last-child{border-bottom:none;}
        .ssst-mb label{font-weight:600;font-size:13px;}
        .ssst-mb input,.ssst-mb textarea,.ssst-mb select{width:100%;max-width:400px;}
    </style>

    <div class="ssst-mb">
        <label for="ssst_promo_label"><?php esc_html_e( 'Label Badge (misal: Terbatas!)', 'ssst-child' ); ?></label>
        <input type="text" id="ssst_promo_label" name="ssst_promo_label"
               value="<?php echo esc_attr( $label ); ?>" maxlength="30"
               placeholder="Terbatas!">
    </div>

    <div class="ssst-mb">
        <label for="ssst_promo_description"><?php esc_html_e( 'Deskripsi Promo', 'ssst-child' ); ?></label>
        <textarea id="ssst_promo_description" name="ssst_promo_description" rows="3"
                  placeholder="Beli 2 gratis 1 untuk semua menu kopi susu..."><?php echo esc_textarea( $desc ); ?></textarea>
    </div>

    <div class="ssst-mb">
        <label for="ssst_promo_code"><?php esc_html_e( 'Kode Promo (opsional)', 'ssst-child' ); ?></label>
        <input type="text" id="ssst_promo_code" name="ssst_promo_code"
               value="<?php echo esc_attr( $code ); ?>"
               maxlength="20" style="text-transform:uppercase;letter-spacing:2px;"
               placeholder="SSST20">
        <p class="description"><?php esc_html_e( 'Kosongkan jika tidak ada kode khusus.', 'ssst-child' ); ?></p>
    </div>

    <div class="ssst-mb">
        <label for="ssst_promo_valid_until"><?php esc_html_e( 'Berlaku Hingga', 'ssst-child' ); ?></label>
        <input type="date" id="ssst_promo_valid_until" name="ssst_promo_valid_until"
               value="<?php echo esc_attr( $valid_until ); ?>">
        <p class="description"><?php esc_html_e( 'Kosongkan jika tidak ada batas waktu.', 'ssst-child' ); ?></p>
    </div>
    <?php
}

add_action( 'save_post_ssst_promo', 'ssst_save_meta_promo', 10, 2 );

function ssst_save_meta_promo( int $post_id, WP_Post $post ): void {
    if ( ! isset( $_POST['ssst_promo_nonce'] ) ||
         ! wp_verify_nonce( sanitize_key( $_POST['ssst_promo_nonce'] ), 'ssst_save_promo_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    update_post_meta( $post_id, '_ssst_promo_label',
        sanitize_text_field( $_POST['ssst_promo_label'] ?? '' ) );
    update_post_meta( $post_id, '_ssst_promo_description',
        sanitize_textarea_field( $_POST['ssst_promo_description'] ?? '' ) );
    update_post_meta( $post_id, '_ssst_promo_valid_until',
        sanitize_text_field( $_POST['ssst_promo_valid_until'] ?? '' ) );
    // Kode promo: hanya alfanumerik + strip
    update_post_meta( $post_id, '_ssst_promo_code',
        strtoupper( preg_replace( '/[^A-Za-z0-9\-]/', '', $_POST['ssst_promo_code'] ?? '' ) ) );
}

// Kolom admin
add_filter( 'manage_ssst_promo_posts_columns', function( $cols ) {
    $new = [];
    foreach ( $cols as $k => $v ) {
        $new[$k] = $v;
        if ( 'title' === $k ) {
            $new['ssst_promo_code']  = __( 'Kode', 'ssst-child' );
            $new['ssst_promo_valid'] = __( 'Berlaku Hingga', 'ssst-child' );
        }
    }
    return $new;
} );

add_action( 'manage_ssst_promo_posts_custom_column', function( $col, $id ) {
    if ( 'ssst_promo_code' === $col ) {
        $code = get_post_meta( $id, '_ssst_promo_code', true );
        echo $code ? '<code>' . esc_html( $code ) . '</code>' : '<em style="color:#999;">-</em>';
    }
    if ( 'ssst_promo_valid' === $col ) {
        $date = get_post_meta( $id, '_ssst_promo_valid_until', true );
        if ( ! $date ) {
            echo '<em style="color:#999;">Tanpa batas</em>';
            return;
        }
        $ts   = strtotime( $date );
        $now  = time();
        $color = $ts >= $now ? '#4A7C59' : '#B5451A';
        $label = $ts >= $now ? '' : ' (Kadaluarsa)';
        echo '<span style="color:' . esc_attr( $color ) . '">'
           . esc_html( wp_date( 'd M Y', $ts ) ) . esc_html( $label ) . '</span>';
    }
}, 10, 2 );
