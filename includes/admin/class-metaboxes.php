<?php
// filepath: c:\Users\gusta\OneDrive\Desktop\Freemius\woocommerce-informacion-nutricional-chile\woocommerce-informacion-nutricional-chile\includes\admin\class-metaboxes.php
/**
 * Metaboxes Class
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'INCW_Productos_Alimenticios_Chile_Metaboxes' ) ) :

    /**
     * INCW_Productos_Alimenticios_Chile_Metaboxes Class
     */
    class INCW_Productos_Alimenticios_Chile_Metaboxes {

        /**
         * Constructor.
         */
        public function __construct() {
            add_action( 'add_meta_boxes', array( $this, 'incw_add_product_metaboxes' ) );
            add_action( 'save_post_product', array( $this, 'incw_save_product_metaboxes' ), 10, 2 );
        }

        /**
         * Add metaboxes to product page.
         */
        public function incw_add_product_metaboxes() {
            add_meta_box(
                'incw_productos_alimenticios_chile_sellos',          // ID
                __( 'Sellos de Advertencia', 'woocommerce-productos-alimenticios-chile' ), // Title
                array( $this, 'incw_display_sellos_metabox' ),      // Callback
                'product',                                     // Post type
                'normal',                                       // Context
                'default'                                      // Priority
            );

            add_meta_box(
                'incw_productos_alimenticios_chile_tabla_nutricional', // ID
                __( 'Tabla Nutricional', 'woocommerce-productos-alimenticios-chile' ), // Title
                array( $this, 'incw_display_tabla_nutricional_metabox' ), // Callback
                'product',                                     // Post type
                'normal',                                       // Context
                'default'                                      // Priority
            );

            add_meta_box(
                'incw_productos_alimenticios_chile_alergenos',       // ID
                __( 'Tabla de Alérgenos', 'woocommerce-productos-alimenticios-chile' ), // Title
                array( $this, 'incw_display_alergenos_metabox' ),    // Callback
                'product',                                     // Post type
                'normal',                                       // Context
                'default'                                      // Priority
            );
        }

        /**
         * Display Sellos Metabox content.
         *
         * @param WP_Post $post
         */
        public function incw_display_sellos_metabox( $post ) {
            // Nonce
            wp_nonce_field( 'productos_alimenticios_chile_save_metaboxes', 'productos_alimenticios_chile_sellos_nonce' );

            // Get values
            $alto_en_sodio_value      = get_post_meta( $post->ID, '_alto_en_sodio', true );
            $alto_en_azucares_value    = get_post_meta( $post->ID, '_alto_en_azucares', true );
            $alto_en_grasas_sat_value  = get_post_meta( $post->ID, '_alto_en_grasas_sat', true );
            $alto_en_calorias_value    = get_post_meta( $post->ID, '_alto_en_calorias', true );

            $sellos = array(
                'sodio'      => array(
                    'label' => esc_html__( 'Alto en Sodio', 'woocommerce-productos-alimenticios-chile' ),
                    'value' => $alto_en_sodio_value,
                    'image' => INCW_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL . 'images/sellos/sello-alto-en-sodio.svg',
                ),
                'azucares'   => array(
                    'label' => esc_html__( 'Alto en Azúcares', 'woocommerce-productos-alimenticios-chile' ),
                    'value' => $alto_en_azucares_value,
                    'image' => INCW_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL . 'images/sellos/sello-alto-en-azucar.svg',
                ),
                'grasas_sat' => array(
                    'label' => esc_html__( 'Alto en Grasas Saturadas', 'woocommerce-productos-alimenticios-chile' ),
                    'value' => $alto_en_grasas_sat_value,
                    'image' => INCW_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL . 'images/sellos/sello-alto-en-grasas-saturadas.svg',
                ),
                'calorias'   => array(
                    'label' => esc_html__( 'Alto en Calorías', 'woocommerce-productos-alimenticios-chile' ),
                    'value' => $alto_en_calorias_value,
                    'image' => INCW_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL . 'images/sellos/sello-alto-en-calorias.svg',
                ),
            );

            echo '<table class="sellos-table" style="width:100%;">';
            echo '<tr>';
            foreach ( $sellos as $key => $sello ) {
                echo '<td style="padding:10px; width: 25%; text-align: center;">' . $sello['label'] . '</td>';
            }
            echo '</tr>';

            echo '<tr>';
            foreach ( $sellos as $key => $sello ) {
                echo '<td style="padding:10px; width: 25%; text-align: center;">';
                echo '<label for="_alto_en_' . $key . '">';
                echo '<input type="checkbox" id="_alto_en_' . $key . '" name="_alto_en_' . $key . '" value="yes" ' . checked( $sello['value'], 'yes', false ) . ' />';
                echo '</label>';
                echo '</td>';
            }
            echo '</tr>';

            echo '<tr>';
            foreach ( $sellos as $key => $sello ) {
                echo '<td style="padding:10px; width: 25%; text-align: center;">';
                echo '<img src="' . esc_url( $sello['image'] ) . '" alt="' . esc_attr( $sello['label'] ) . '" style="max-width: 3cm; max-height: 3cm; width: auto; height: auto;" />';
                echo '</td>';
            }
            echo '</tr>';
            echo '</table>';
        }

        /**
         * Display Tabla Nutricional Metabox content.
         *
         * @param WP_Post $post
         */
        public function incw_display_tabla_nutricional_metabox( $post ) {
            wp_nonce_field( 'productos_alimenticios_chile_save_metaboxes', 'productos_alimenticios_chile_tabla_nutricional_nonce' );

            $porcion_texto_value              = get_post_meta( $post->ID, '_porcion_texto', true );
            $porcion_gramos_value             = get_post_meta( $post->ID, '_porcion_gramos', true );
            $porciones_por_envase_value       = get_post_meta( $post->ID, '_porciones_por_envase', true );
            $energia_porcion_value            = get_post_meta( $post->ID, '_energia_porcion', true );
            $proteinas_porcion_value          = get_post_meta( $post->ID, '_proteinas_porcion', true );
            $grasa_total_porcion_value        = get_post_meta( $post->ID, '_grasa_total_porcion', true );
            $hidratos_carbono_porcion_value   = get_post_meta( $post->ID, '_hidratos_carbono_porcion', true );
            $azucares_totales_porcion_value  = get_post_meta( $post->ID, '_azucares_totales_porcion', true );
            $sodio_porcion_value              = get_post_meta( $post->ID, '_sodio_porcion', true );
            $ingredientes_value               = get_post_meta( $post->ID, '_ingredientes', true );

            echo '<table class="tabla-nutricional-inputs" style="width:100%;">';

            echo '<tr>';
            echo '<td style="width:30%; padding:5px;"><label for="_porcion_texto">' . esc_html__( 'Descripción de la Porción:', 'woocommerce-productos-alimenticios-chile' ) . '</label></td>';
            echo '<td style="width:70%; padding:5px;"><textarea id="_porcion_texto" name="_porcion_texto" rows="2" style="width:100%">' . esc_textarea( $porcion_texto_value ) . '</textarea></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td style="padding:5px;"><label for="_porcion_gramos">' . esc_html__( 'Porción en gramos:', 'woocommerce-productos-alimenticios-chile' ) . '</label></td>';
            echo '<td style="padding:5px;"><input type="number" id="_porcion_gramos" name="_porcion_gramos" value="' . esc_attr( $porcion_gramos_value ) . '" style="width:100px;" /></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td style="padding:5px;"><label for="_porciones_por_envase">' . esc_html__( 'Porciones por Envase:', 'woocommerce-productos-alimenticios-chile' ) . '</label></td>';
            echo '<td style="padding:5px;"><input type="number" id="_porciones_por_envase" name="_porciones_por_envase" value="' . esc_attr( $porciones_por_envase_value ) . '" style="width:100px;" /></td>';
            echo '</tr>';

            echo '<tr><td colspan="2"><hr></td></tr>';

            echo '<tr>';
            echo '<td style="padding:5px;"><label for="_energia_porcion">' . esc_html__( 'Energía (kcal) por Porción:', 'woocommerce-productos-alimenticios-chile' ) . '</label></td>';
            echo '<td style="padding:5px;"><input type="number" step="0.1" id="_energia_porcion" name="_energia_porcion" value="' . esc_attr( $energia_porcion_value ) . '" style="width:100px;" /></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td style="padding:5px;"><label for="_proteinas_porcion">' . esc_html__( 'Proteínas (g) por Porción:', 'woocommerce-productos-alimenticios-chile' ) . '</label></td>';
            echo '<td style="padding:5px;"><input type="number" step="0.1" id="_proteinas_porcion" name="_proteinas_porcion" value="' . esc_attr( $proteinas_porcion_value ) . '" style="width:100px;" /></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td style="padding:5px;"><label for="_grasa_total_porcion">' . esc_html__( 'Grasa Total (g) por Porción:', 'woocommerce-productos-alimenticios-chile' ) . '</label></td>';
            echo '<td style="padding:5px;"><input type="number" step="0.1" id="_grasa_total_porcion" name="_grasa_total_porcion" value="' . esc_attr( $grasa_total_porcion_value ) . '" style="width:100px;" /></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td style="padding:5px;"><label for="_hidratos_carbono_porcion">' . esc_html__( 'Hidratos de Carbono (g) por Porción:', 'woocommerce-productos-alimenticios-chile' ) . '</label></td>';
            echo '<td style="padding:5px;"><input type="number" step="0.1" id="_hidratos_carbono_porcion" name="_hidratos_carbono_porcion" value="' . esc_attr( $hidratos_carbono_porcion_value ) . '" style="width:100px;" /></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td style="padding:5px;"><label for="_azucares_totales_porcion">' . esc_html__( 'Azúcares Totales (g) por Porción:', 'woocommerce-productos-alimenticios-chile' ) . '</label></td>';
            echo '<td style="padding:5px;"><input type="number" step="0.1" id="_azucares_totales_porcion" name="_azucares_totales_porcion" value="' . esc_attr( $azucares_totales_porcion_value ) . '" style="width:100px;" /></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td style="padding:5px;"><label for="_sodio_porcion">' . esc_html__( 'Sodio (mg) por Porción:', 'woocommerce-productos-alimenticios-chile' ) . '</label></td>';
            echo '<td style="padding:5px;"><input type="number" step="0.1" id="_sodio_porcion" name="_sodio_porcion" value="' . esc_attr( $sodio_porcion_value ) . '" style="width:100px;" /></td>';
            echo '</tr>';

            echo '<tr><td colspan="2"><hr></td></tr>';

            echo '<tr>';
            echo '<td style="padding:5px;"><label for="_ingredientes">' . esc_html__( 'Listado de Ingredientes:', 'woocommerce-productos-alimenticios-chile' ) . '</label></td>';
            echo '<td style="padding:5px;"><textarea id="_ingredientes" name="_ingredientes" rows="4" style="width:100%">' . esc_textarea( $ingredientes_value ) . '</textarea></td>';
            echo '</tr>';

            echo '</table>';
        }

        /**
         * Display Alergenos Metabox content.
         *
         * @param WP_Post $post
         */
        public function incw_display_alergenos_metabox( $post ) {
            // Nonce
            wp_nonce_field( 'productos_alimenticios_chile_save_metaboxes', 'productos_alimenticios_chile_alergenos_nonce' );

            // Get values
            $alergenos = array(
                'gluten'     => array(
                    'ing' => get_post_meta( $post->ID, '_alergeno_gluten_ingrediente', true ),
                    'con' => get_post_meta( $post->ID, '_alergeno_gluten_contaminacion', true ),
                ),
                'crustaceos' => array(
                    'ing' => get_post_meta( $post->ID, '_alergeno_crustaceos_ingrediente', true ),
                    'con' => get_post_meta( $post->ID, '_alergeno_crustaceos_contaminacion', true ),
                ),
                'huevos'     => array(
                    'ing' => get_post_meta( $post->ID, '_alergeno_huevos_ingrediente', true ),
                    'con' => get_post_meta( $post->ID, '_alergeno_huevos_contaminacion', true ),
                ),
                'pescado'    => array(
                    'ing' => get_post_meta( $post->ID, '_alergeno_pescado_ingrediente', true ),
                    'con' => get_post_meta( $post->ID, '_alergeno_pescado_contaminacion', true ),
                ),
                'mani'       => array(
                    'ing' => get_post_meta( $post->ID, '_alergeno_mani_ingrediente', true ),
                    'con' => get_post_meta( $post->ID, '_alergeno_mani_contaminacion', true ),
                ),
                'soya'       => array(
                    'ing' => get_post_meta( $post->ID, '_alergeno_soya_ingrediente', true ),
                    'con' => get_post_meta( $post->ID, '_alergeno_soya_contaminacion', true ),
                ),
                'leche'      => array(
                    'ing' => get_post_meta( $post->ID, '_alergeno_leche_ingrediente', true ),
                    'con' => get_post_meta( $post->ID, '_alergeno_leche_contaminacion', true ),
                ),
                'nueces'     => array(
                    'ing' => get_post_meta( $post->ID, '_alergeno_nueces_ingrediente', true ),
                    'con' => get_post_meta( $post->ID, '_alergeno_nueces_contaminacion', true ),
                ),
                'sulfitos'   => array(
                    'ing' => get_post_meta( $post->ID, '_alergeno_sulfitos_ingrediente', true ),
                    'con' => get_post_meta( $post->ID, '_alergeno_sulfitos_contaminacion', true ),
                ),
            );

            // Table start
            echo '<table class="alergenos-table" style="width:100%; border-collapse: collapse;">';
            echo '<thead>';
            echo '<tr style="background-color:#f7f7f7;">';
            echo '<th style="padding:8px; border:1px solid #ddd;">' . esc_html__( 'Alergeno', 'woocommerce-productos-alimenticios-chile' ) . '</th>';
            echo '<th style="padding:8px; border:1px solid #ddd;">' . esc_html__( 'Como ingrediente', 'woocommerce-productos-alimenticios-chile' ) . '</th>';
            echo '<th style="padding:8px; border:1px solid #ddd;">' . esc_html__( 'Posible contaminación cruzada', 'woocommerce-productos-alimenticios-chile' ) . '</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ( $alergenos as $alergeno => $valores ) {
                // Translate alergeno name
                $alergeno_traducido = '';
                switch ( $alergeno ) {
                    case 'gluten':
                        $alergeno_traducido = esc_html__( 'Cereales con gluten y productos derivados', 'woocommerce-productos-alimenticios-chile' );
                        break;
                    case 'crustaceos':
                        $alergeno_traducido = esc_html__( 'Crustáceos y productos derivados', 'woocommerce-productos-alimenticios-chile' );
                        break;
                    case 'huevos':
                        $alergeno_traducido = esc_html__( 'Huevos y productos derivados', 'woocommerce-productos-alimenticios-chile' );
                        break;
                    case 'pescado':
                        $alergeno_traducido = esc_html__( 'Pescado y productos derivados', 'woocommerce-productos-alimenticios-chile' );
                        break;
                    case 'mani':
                        $alergeno_traducido = esc_html__( 'Maní y productos derivados', 'woocommerce-productos-alimenticios-chile' );
                        break;
                    case 'soya':
                        $alergeno_traducido = esc_html__( 'Soya y productos derivados', 'woocommerce-productos-alimenticios-chile' );
                        break;
                    case 'leche':
                        $alergeno_traducido = esc_html__( 'Leche y productos derivados (incluida la lactosa)', 'woocommerce-productos-alimenticios-chile' );
                        break;
                    case 'nueces':
                        $alergeno_traducido = esc_html__( 'Nueces y productos derivados', 'woocommerce-productos-alimenticios-chile' );
                        break;
                    case 'sulfitos':
                        $alergeno_traducido = esc_html__( 'Anhídrido sulfuroso y sulfitos (> 10 mg/kg o 10 mg/L SO2)', 'woocommerce-productos-alimenticios-chile' );
                        break;
                }

                // Row
                echo '<tr>';
                echo '<td style="padding:8px; border:1px solid #ddd;">' . $alergeno_traducido . '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                echo '<input type="checkbox" id="_alergeno_' . $alergeno . '_ingrediente" name="_alergeno_' . $alergeno . '_ingrediente" value="yes" ' . checked( $valores['ing'], 'yes', false ) . ' />';
                echo '</td>';
                echo '<td style="text-align:center; padding:8px; border:1px solid #ddd;">';
                echo '<input type="checkbox" id="_alergeno_' . $alergeno . '_contaminacion" name="_alergeno_' . $alergeno . '_contaminacion" value="yes" ' . checked( $valores['con'], 'yes', false ) . ' />';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        }

        /**
         * Save Metabox data.
         *
         * @param int     $post_id
         * @param WP_Post $post
         */
        public function incw_save_product_metaboxes( $post_id, $post ) {

            // Verify nonces
            $nonces = array(
                'sellos'          => 'productos_alimenticios_chile_sellos_nonce',
                'tabla_nutricional' => 'productos_alimenticios_chile_tabla_nutricional_nonce',
                'alergenos'       => 'productos_alimenticios_chile_alergenos_nonce',
            );

            foreach ( $nonces as $metabox => $nonce ) {
                if ( ! isset( $_POST[ $nonce ] ) || ! wp_verify_nonce( $_POST[ $nonce ], 'productos_alimenticios_chile_save_metaboxes' ) ) {
                    return;
                }
            }

            // Check user permissions
            if ( ! current_user_can( 'edit_product', $post_id ) ) {
                return;
            }

            // Check autosave
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }

            // Save Sellos data
            $sellos = array(
                '_alto_en_sodio',
                '_alto_en_azucares',
                '_alto_en_grasas_sat',
                '_alto_en_calorias',
            );

            foreach ( $sellos as $sello ) {
                $value = isset( $_POST[ $sello ] ) ? 'yes' : '';
                update_post_meta( $post_id, $sello, sanitize_text_field( $value ) );
            }

            // Save Tabla Nutricional data
            if ( isset( $_POST['_porcion_texto'] ) ) {
                update_post_meta( $post_id, '_porcion_texto', sanitize_textarea_field( $_POST['_porcion_texto'] ) );
            }
            if ( isset( $_POST['_porcion_gramos'] ) ) {
                update_post_meta( $post_id, '_porcion_gramos', absint( $_POST['_porcion_gramos'] ) );
            }
            if ( isset( $_POST['_porciones_por_envase'] ) ) {
                update_post_meta( $post_id, '_porciones_por_envase', absint( $_POST['_porciones_por_envase'] ) );
            }
            if ( isset( $_POST['_energia_porcion'] ) ) {
                update_post_meta( $post_id, '_energia_porcion', floatval( $_POST['_energia_porcion'] ) );
            }
            if ( isset( $_POST['_proteinas_porcion'] ) ) {
                update_post_meta( $post_id, '_proteinas_porcion', floatval( $_POST['_proteinas_porcion'] ) );
            }
            if ( isset( $_POST['_grasa_total_porcion'] ) ) {
                update_post_meta( $post_id, '_grasa_total_porcion', floatval( $_POST['_grasa_total_porcion'] ) );
            }
            if ( isset( $_POST['_hidratos_carbono_porcion'] ) ) {
                update_post_meta( $post_id, '_hidratos_carbono_porcion', floatval( $_POST['_hidratos_carbono_porcion'] ) );
            }
            if ( isset( $_POST['_azucares_totales_porcion'] ) ) {
                update_post_meta( $post_id, '_azucares_totales_porcion', floatval( $_POST['_azucares_totales_porcion'] ) );
            }
            if ( isset( $_POST['_sodio_porcion'] ) ) {
                update_post_meta( $post_id, '_sodio_porcion', floatval( $_POST['_sodio_porcion'] ) );
            }
            if ( isset( $_POST['_ingredientes'] ) ) {
                update_post_meta( $post_id, '_ingredientes', sanitize_textarea_field( $_POST['_ingredientes'] ) );
            }

            // Save Alergenos data
            $alergenos = array(
                'gluten',
                'crustaceos',
                'huevos',
                'pescado',
                'mani',
                'soya',
                'leche',
                'nueces',
                'sulfitos',
            );

            foreach ( $alergenos as $alergeno ) {
                $ing_key = '_alergeno_' . $alergeno . '_ingrediente';
                $con_key = '_alergeno_' . $alergeno . '_contaminacion';

                $ing_value = isset( $_POST[ $ing_key ] ) ? 'yes' : '';
                $con_value = isset( $_POST[ $con_key ] ) ? 'yes' : '';

                update_post_meta( $post_id, $ing_key, sanitize_text_field( $ing_value ) );
                update_post_meta( $post_id, $con_key, sanitize_text_field( $con_value ) );
            }
        }
    }

    // Remove class instantiation from here

endif;