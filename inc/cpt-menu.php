<?php
/**
 * CPT: ssst_menu - Item Menu Kafe
 *
 * Mendaftarkan Custom Post Type untuk item menu kafe ssst,
 * berikut custom field (harga, kategori, deskripsi, dll.)
 * dan meta box di wp-admin.
 *
 * @package ssst-child
 */

defined( 'ABSPATH' ) || exit;

// ============================================================
// 1. DAFTARKAN CPT
// ============================================================
add_action( 'init', 'ssst_register_cpt_menu', 0 );

function ssst_register_cpt_menu(): void {
    $labels = [
        'name'               => _x( 'Item Menu', 'post type general name', 'ssst-child' ),
        'singular_name'      => _x( 'Item Menu', 'post type singular name', 'ssst-child' ),
        'add_new'            => __( 'Tambah Item', 'ssst-child' ),
        'add_new_item'       => __( 'Tambah Item Menu Baru', 'ssst-child' ),
        'edit_item'          => __( 'Edit Item Menu', 'ssst-child' ),
        'view_item'          => __( 'Lihat Item Menu', 'ssst-child' ),
        'all_items'          => __( 'Semua Item Menu', 'ssst-child' ),
        'search_items'       => __( 'Cari Item Menu', 'ssst-child' ),
        'not_found'          => __( 'Tidak ada item menu ditemukan.', 'ssst-child' ),
        'not_found_in_trash' => __( 'Tidak ada item menu di tempat sampah.', 'ssst-child' ),
        'menu_name'          => __( 'Menu Kafe', 'ssst-child' ),
    ];

    register_post_type( 'ssst_menu', [
        'labels'              => $labels,
        'public'              => false,        // tidak butuh single page publik
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,          // untuk Gutenberg & REST API
        'menu_position'       => 25,
        'menu_icon'           => 'dashicons-coffee',
        'supports'            => [ 'title', 'thumbnail', 'page-attributes' ],
        'has_archive'         => false,
        'rewrite'             => false,
        'capability_type'     => 'post',
    ] );
}

// ============================================================
// 2. DAFTARKAN META FIELDS (REST API support)
// ============================================================
add_action( 'init', 'ssst_register_meta_menu' );

function ssst_register_meta_menu(): void {
    $meta_fields = [
        '_ssst_menu_category'     => [ 'type' => 'string',  'description' => 'Kategori menu' ],
        '_ssst_menu_price'        => [ 'type' => 'integer', 'description' => 'Harga dalam IDR' ],
        '_ssst_menu_description'  => [ 'type' => 'string',  'description' => 'Deskripsi singkat item menu' ],
        '_ssst_menu_is_available' => [ 'type' => 'boolean', 'description' => 'Apakah tersedia' ],
        '_ssst_menu_is_bestseller'=> [ 'type' => 'boolean', 'description' => 'Tandai sebagai bestseller' ],
    ];

    foreach ( $meta_fields as $key => $args ) {
        register_post_meta( 'ssst_menu', $key, [
            'type'              => $args['type'],
            'description'       => $args['description'],
            'single'            => true,
            'show_in_rest'      => false, // private meta, tidak ekspos ke REST
            'sanitize_callback' => match( $args['type'] ) {
                'integer' => 'absint',
                'boolean' => 'rest_sanitize_boolean',
                default   => 'sanitize_text_field',
            },
            'auth_callback'     => function() {
                return current_user_can( 'edit_posts' );
            },
        ] );
    }
}

// ============================================================
// 3. META BOX DI WP-ADMIN
// ============================================================
add_action( 'add_meta_boxes', 'ssst_add_meta_box_menu' );

function ssst_add_meta_box_menu(): void {
    add_meta_box(
        'ssst_menu_details',
        __( 'Detail Item Menu', 'ssst-child' ),
        'ssst_render_meta_box_menu',
        'ssst_menu',
        'normal',
        'high'
    );
}

/**
 * Render meta box untuk item menu.
 *
 * @param WP_Post $post Post saat ini.
 */
function ssst_render_meta_box_menu( WP_Post $post ): void {
    wp_nonce_field( 'ssst_save_menu_meta', 'ssst_menu_nonce' );

    $category     = get_post_meta( $post->ID, '_ssst_menu_category',     true );
    $price        = get_post_meta( $post->ID, '_ssst_menu_price',        true );
    $description  = get_post_meta( $post->ID, '_ssst_menu_description',  true );
    $is_available = get_post_meta( $post->ID, '_ssst_menu_is_available', true );
    $is_bestseller= get_post_meta( $post->ID, '_ssst_menu_is_bestseller',true );

    // Default tersedia
    if ( '' === $is_available ) {
        $is_available = '1';
    }

    $categories = [
        'kopi-susu'    => __( 'Kopi Susu', 'ssst-child' ),
        'manual-brew'  => __( 'Manual Brew', 'ssst-child' ),
        'non-kopi'     => __( 'Non-Kopi', 'ssst-child' ),
        'makanan'      => __( 'Makanan & Snack', 'ssst-child' ),
        'seasonal'     => __( 'Seasonal', 'ssst-child' ),
        'lainnya'      => __( 'Lainnya', 'ssst-child' ),
    ];
    ?>
    <style>
        .ssst-mb { padding: 12px 0; border-bottom: 1px solid #eee; display: flex; flex-direction: column; gap: 6px; }
        .ssst-mb:last-child { border-bottom: none; }
        .ssst-mb label { font-weight: 600; font-size: 13px; }
        .ssst-mb input[type="text"],
        .ssst-mb input[type="number"],
        .ssst-mb textarea,
        .ssst-mb select { width: 100%; max-width: 400px; }
        .ssst-mb-row { display: flex; gap: 24px; flex-wrap: wrap; }
        .ssst-mb-col { flex: 1; }
    </style>

    <div class="ssst-mb">
        <label for="ssst_menu_category"><?php esc_html_e( 'Kategori', 'ssst-child' ); ?></label>
        <select id="ssst_menu_category" name="ssst_menu_category">
            <option value=""><?php esc_html_e( '- Pilih kategori -', 'ssst-child' ); ?></option>
            <?php foreach ( $categories as $val => $label ) : ?>
                <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $category, $val ); ?>>
                    <?php echo esc_html( $label ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="ssst-mb">
        <label for="ssst_menu_price"><?php esc_html_e( 'Harga (IDR)', 'ssst-child' ); ?></label>
        <input type="number"
               id="ssst_menu_price"
               name="ssst_menu_price"
               value="<?php echo esc_attr( $price ); ?>"
               min="0"
               step="500"
               placeholder="Contoh: 35000">
        <p class="description"><?php esc_html_e( 'Masukkan angka saja, tanpa titik/koma. Contoh: 35000', 'ssst-child' ); ?></p>
    </div>

    <div class="ssst-mb">
        <label for="ssst_menu_description"><?php esc_html_e( 'Deskripsi Singkat', 'ssst-child' ); ?></label>
        <textarea id="ssst_menu_description"
                  name="ssst_menu_description"
                  rows="3"
                  maxlength="200"
                  placeholder="<?php esc_attr_e( 'Deskripsi singkat item menu, maks 200 karakter.', 'ssst-child' ); ?>"><?php echo esc_textarea( $description ); ?></textarea>
    </div>

    <div class="ssst-mb ssst-mb-row">
        <div class="ssst-mb-col">
            <label>
                <input type="checkbox"
                       name="ssst_menu_is_available"
                       value="1"
                       <?php checked( $is_available, '1' ); ?>>
                <?php esc_html_e( 'Tersedia (tampilkan di menu)', 'ssst-child' ); ?>
            </label>
        </div>
        <div class="ssst-mb-col">
            <label>
                <input type="checkbox"
                       name="ssst_menu_is_bestseller"
                       value="1"
                       <?php checked( $is_bestseller, '1' ); ?>>
                <?php esc_html_e( 'Tandai sebagai Terlaris', 'ssst-child' ); ?>
            </label>
        </div>
    </div>
    <?php
}

// ============================================================
// 4. SIMPAN META
// ============================================================
add_action( 'save_post_ssst_menu', 'ssst_save_meta_menu', 10, 2 );

/**
 * Simpan custom field item menu.
 *
 * @param int     $post_id ID post.
 * @param WP_Post $post    Post object.
 */
function ssst_save_meta_menu( int $post_id, WP_Post $post ): void {
    // Cek nonce
    if ( ! isset( $_POST['ssst_menu_nonce'] ) ||
         ! wp_verify_nonce( sanitize_key( $_POST['ssst_menu_nonce'] ), 'ssst_save_menu_meta' ) ) {
        return;
    }

    // Jangan simpan saat autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Cek kapabilitas
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Simpan masing-masing field dengan sanitasi yang tepat
    update_post_meta(
        $post_id,
        '_ssst_menu_category',
        sanitize_key( $_POST['ssst_menu_category'] ?? '' )
    );

    update_post_meta(
        $post_id,
        '_ssst_menu_price',
        absint( $_POST['ssst_menu_price'] ?? 0 )
    );

    update_post_meta(
        $post_id,
        '_ssst_menu_description',
        sanitize_textarea_field( $_POST['ssst_menu_description'] ?? '' )
    );

    // Checkbox: hanya simpan '1' jika dicentang, '' jika tidak
    update_post_meta(
        $post_id,
        '_ssst_menu_is_available',
        isset( $_POST['ssst_menu_is_available'] ) ? '1' : ''
    );

    update_post_meta(
        $post_id,
        '_ssst_menu_is_bestseller',
        isset( $_POST['ssst_menu_is_bestseller'] ) ? '1' : ''
    );
}

// ============================================================
// 5. KOLOM ADMIN LIST
// ============================================================
add_filter( 'manage_ssst_menu_posts_columns', 'ssst_menu_admin_columns' );

function ssst_menu_admin_columns( array $columns ): array {
    $new = [];
    foreach ( $columns as $key => $label ) {
        $new[ $key ] = $label;
        if ( 'title' === $key ) {
            $new['ssst_category']  = __( 'Kategori', 'ssst-child' );
            $new['ssst_price']     = __( 'Harga', 'ssst-child' );
            $new['ssst_available'] = __( 'Status', 'ssst-child' );
        }
    }
    return $new;
}

add_action( 'manage_ssst_menu_posts_custom_column', 'ssst_menu_admin_column_data', 10, 2 );

function ssst_menu_admin_column_data( string $column, int $post_id ): void {
    switch ( $column ) {
        case 'ssst_category':
            $cat = get_post_meta( $post_id, '_ssst_menu_category', true );
            echo esc_html( $cat ?: '-' );
            break;
        case 'ssst_price':
            $price = get_post_meta( $post_id, '_ssst_menu_price', true );
            echo $price ? 'Rp&nbsp;' . esc_html( number_format( (int) $price, 0, ',', '.' ) ) : '-';
            break;
        case 'ssst_available':
            $avail = get_post_meta( $post_id, '_ssst_menu_is_available', true );
            echo $avail ? '<span style="color:#4A7C59;font-weight:700;">Tersedia</span>'
                        : '<span style="color:#B5451A;">Tidak Tersedia</span>';
            break;
    }
}
