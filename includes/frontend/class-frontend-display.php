<?php
/**
 * Frontend Display Class (Clase para la Visualización en el Frontend)
 *
 * Este archivo define la clase que se encarga de mostrar la información
 * nutricional, los sellos de advertencia y la tabla de alérgenos
 * en la página del producto, en el frontend de la tienda.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! class_exists( 'INCW_Productos_Alimenticios_Chile_Frontend_Display' ) ) :

    /**
     * INCW_Productos_Alimenticios_Chile_Frontend_Display Class
     * Clase para mostrar la información en el frontend.
     */
    class INCW_Productos_Alimenticios_Chile_Frontend_Display {

        /**
         * Constructor.
         */
        public function __construct() {
            add_action( 'woocommerce_after_single_product_summary', array( $this, 'incw_display_product_info' ), 20 );
        }

        /**
         * Muestra la información del producto (tabla nutricional, sellos y alérgenos) en el frontend.
         */
        public function incw_display_product_info() {
            global $product;

            if ( ! $product ) {
                return; // Si no hay objeto de producto, salir.
            }

            // --- Recupera los metadatos del producto ---
            $alto_en_sodio      = get_post_meta( $product->get_id(), '_alto_en_sodio', true );
            $alto_en_azucares    = get_post_meta( $product->get_id(), '_alto_en_azucares', true );
            $alto_en_grasas_sat  = get_post_meta( $product->get_id(), '_alto_en_grasas_sat', true );
            $alto_en_calorias    = get_post_meta( $product->get_id(), '_alto_en_calorias', true );

            $porcion_texto              = get_post_meta( $product->get_id(), '_porcion_texto', true );
            $porcion_gramos             = get_post_meta( $product->get_id(), '_porcion_gramos', true );
            $porciones_por_envase       = get_post_meta( $product->get_id(), '_porciones_por_envase', true );
            $energia_porcion            = get_post_meta( $product->get_id(), '_energia_porcion', true );
            $proteinas_porcion          = get_post_meta( $product->get_id(), '_proteinas_porcion', true );
            $grasa_total_porcion        = get_post_meta( $product->get_id(), '_grasa_total_porcion', true );
            $hidratos_carbono_porcion   = get_post_meta( $product->get_id(), '_hidratos_carbono_porcion', true );
            $azucares_totales_porcion   = get_post_meta( $product->get_id(), '_azucares_totales_porcion', true );
            $sodio_porcion              = get_post_meta( $product->get_id(), '_sodio_porcion', true );
            $ingredientes               = get_post_meta( $product->get_id(), '_ingredientes', true );

            // Recupera los metadatos de los alérgenos
            $alergenos = array(
                'gluten'     => array(
                    'ing' => get_post_meta( $product->get_id(), '_alergeno_gluten_ingrediente', true ),
                    'con' => get_post_meta( $product->get_id(), '_alergeno_gluten_contaminacion', true ),
                ),
                'crustaceos' => array(
                    'ing' => get_post_meta( $product->get_id(), '_alergeno_crustaceos_ingrediente', true ),
                    'con' => get_post_meta( $product->get_id(), '_alergeno_crustaceos_contaminacion', true ),
                ),
                'huevos'     => array(
                    'ing' => get_post_meta( $product->get_id(), '_alergeno_huevos_ingrediente', true ),
                    'con' => get_post_meta( $product->get_id(), '_alergeno_huevos_contaminacion', true ),
                ),
                'pescado'    => array(
                    'ing' => get_post_meta( $product->get_id(), '_alergeno_pescado_ingrediente', true ),
                    'con' => get_post_meta( $product->get_id(), '_alergeno_pescado_contaminacion', true ),
                ),
                'mani'       => array(
                    'ing' => get_post_meta( $product->get_id(), '_alergeno_mani_ingrediente', true ),
                    'con' => get_post_meta( $product->get_id(), '_alergeno_mani_contaminacion', true ),
                ),
                'soya'       => array(
                    'ing' => get_post_meta( $product->get_id(), '_alergeno_soya_ingrediente', true ),
                    'con' => get_post_meta( $product->get_id(), '_alergeno_soya_contaminacion', true ),
                ),
                'leche'      => array(
                    'ing' => get_post_meta( $product->get_id(), '_alergeno_leche_ingrediente', true ),
                    'con' => get_post_meta( $product->get_id(), '_alergeno_leche_contaminacion', true ),
                ),
                'nueces'     => array(
                    'ing' => get_post_meta( $product->get_id(), '_alergeno_nueces_ingrediente', true ),
                    'con' => get_post_meta( $product->get_id(), '_alergeno_nueces_contaminacion', true ),
                ),
                'sulfitos'   => array(
                    'ing' => get_post_meta( $product->get_id(), '_alergeno_sulfitos_ingrediente', true ),
                    'con' => get_post_meta( $product->get_id(), '_alergeno_sulfitos_contaminacion', true ),
                ),
            );

            // --- Calcula valores por 100g (si es posible) ---
            $energia_100g          = ( $porcion_gramos > 0 ) ? round( ( $energia_porcion / $porcion_gramos ) * 100, 1 ) : '';
            $proteinas_100g        = ( $porcion_gramos > 0 ) ? round( ( $proteinas_porcion / $porcion_gramos ) * 100, 1 ) : '';
            $grasa_total_100g      = ( $porcion_gramos > 0 ) ? round( ( $grasa_total_porcion / $porcion_gramos ) * 100, 1 ) : '';
            $hidratos_carbono_100g = ( $porcion_gramos > 0 ) ? round( ( $hidratos_carbono_porcion / $porcion_gramos ) * 100, 1 ) : '';
            $azucares_totales_100g = ( $porcion_gramos > 0 ) ? round( ( $azucares_totales_porcion / $porcion_gramos ) * 100, 1 ) : '';
            $sodio_100g            = ( $porcion_gramos > 0 ) ? round( ( $sodio_porcion / $porcion_gramos ) * 100 ) : '';

            echo '<div class="productos-alimenticios-chile-product-info">';

            // --- Sección: Tabla Nutricional ---
            $nutricional_exists = ! empty( $porcion_texto ) || ! empty( $porciones_por_envase ) || ! empty( $energia_porcion ) ||
                                  ! empty( $proteinas_porcion ) || ! empty( $grasa_total_porcion ) || ! empty( $hidratos_carbono_porcion ) ||
                                  ! empty( $azucares_totales_porcion ) || ! empty( $sodio_porcion ) || ! empty( $ingredientes );

            if ( $nutricional_exists ) {
                echo '<div class="tabla-nutricional-container">';
                echo '<table class="tabla-nutricional-3-columnas">';
                echo '<caption>' . esc_html__( 'Información Nutricional', 'woocommerce-productos-alimenticios-chile' ) . '</caption>';
                echo '<thead>';
                echo '<tr><th colspan="3">' . esc_html__( 'INFORMACIÓN NUTRICIONAL', 'woocommerce-productos-alimenticios-chile' ) . '</th></tr>';
                echo '<tr><th colspan="3">' . esc_html__( 'Porción: ', 'woocommerce-productos-alimenticios-chile' ) . esc_html( $porcion_texto ) . '</th></tr>';
                echo '<tr><th colspan="3">' . esc_html__( 'Porciones por Envase: ', 'woocommerce-productos-alimenticios-chile' ) . esc_html( $porciones_por_envase ) . '</th></tr>';
                echo '<tr class="encabezado-3-columnas">';
                echo '<th></th><th>' . esc_html__( '100g', 'woocommerce-productos-alimenticios-chile' ) . '</th><th>' . esc_html__( '1 Porción', 'woocommerce-productos-alimenticios-chile' ) . '</th></tr>';
                echo '</thead>';
                echo '<tbody>';
                echo '<tr>';
                echo '<td>' . esc_html__( 'Energía (kcal)', 'woocommerce-productos-alimenticios-chile' ) . '</td>';
                echo '<td>' . esc_html( $energia_100g ) . '</td>';
                echo '<td>' . esc_html( $energia_porcion ) . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>' . esc_html__( 'Proteínas (g)', 'woocommerce-productos-alimenticios-chile' ) . '</td>';
                echo '<td>' . esc_html( $proteinas_100g ) . '</td>';
                echo '<td>' . esc_html( $proteinas_porcion ) . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>' . esc_html__( 'Grasa Total (g)', 'woocommerce-productos-alimenticios-chile' ) . '</td>';
                echo '<td>' . esc_html( $grasa_total_100g ) . '</td>';
                echo '<td>' . esc_html( $grasa_total_porcion ) . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>' . esc_html__( 'Hidratos de Carbono disp. (g)', 'woocommerce-productos-alimenticios-chile' ) . '</td>';
                echo '<td>' . esc_html( $hidratos_carbono_100g ) . '</td>';
                echo '<td>' . esc_html( $hidratos_carbono_porcion ) . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>' . esc_html__( 'Azúcares Totales (g)', 'woocommerce-productos-alimenticios-chile' ) . '</td>';
                echo '<td>' . esc_html( $azucares_totales_100g ) . '</td>';
                echo '<td>' . esc_html( $azucares_totales_porcion ) . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>' . esc_html__( 'Sodio (mg)', 'woocommerce-productos-alimenticios-chile' ) . '</td>';
                echo '<td>' . esc_html( $sodio_100g ) . '</td>';
                echo '<td>' . esc_html( $sodio_porcion ) . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td colspan="3"><h4>' . esc_html__( 'Ingredientes:', 'woocommerce-productos-alimenticios-chile' ) . '</h4><p class="listado-ingredientes">' . esc_html( $ingredientes ) . '</p></td>';
                echo '</tr>';
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            }

            // --- Sección: Sellos de Advertencia ---
            $sellos = array(
                'sodio'      => array(
                    'activo' => $alto_en_sodio,
                    'texto'  => esc_attr__( 'Alto en Sodio', 'woocommerce-productos-alimenticios-chile' ),
                    'imagen' => INCW_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL . 'images/sellos/sello-alto-en-sodio.svg',
                ),
                'azucares'   => array(
                    'activo' => $alto_en_azucares,
                    'texto'  => esc_attr__( 'Alto en Azúcares', 'woocommerce-productos-alimenticios-chile' ),
                    'imagen' => INCW_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL . 'images/sellos/sello-alto-en-azucar.svg',
                ),
                'grasas_sat' => array(
                    'activo' => $alto_en_grasas_sat,
                    'texto'  => esc_attr__( 'Alto en Grasas Saturadas', 'woocommerce-productos-alimenticios-chile' ),
                    'imagen' => INCW_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL . 'images/sellos/sello-alto-en-grasas-saturadas.svg',
                ),
                'calorias'   => array(
                    'activo' => $alto_en_calorias,
                    'texto'  => esc_attr__( 'Alto en Calorías', 'woocommerce-productos-alimenticios-chile' ),
                    'imagen' => INCW_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL . 'images/sellos/sello-alto-en-calorias.svg',
                ),
            );

            $sellos_activos = false;
            foreach ( $sellos as $sello ) {
                if ( 'yes' === $sello['activo'] ) {
                    $sellos_activos = true;
                    break;
                }
            }

            if ( $sellos_activos ) {
                echo '<div class="sellos-container">';
                echo '<h4>' . esc_html__( 'Sellos de Advertencia:', 'woocommerce-productos-alimenticios-chile' ) . '</h4>';
                foreach ( $sellos as $sello ) {
                    if ( 'yes' === $sello['activo'] ) {
                        echo '<img src="' . esc_url( $sello['imagen'] ) . '" alt="' . $sello['texto'] . '" class="sello-alto-en" />';
                    }
                }
                echo '</div>';
            }

            // --- Sección: Tabla de Alérgenos ---
            $alergenos_exists = false;
            foreach ( $alergenos as $alergeno => $valores ) {
                if ( 'yes' === $valores['ing'] || 'yes' === $valores['con'] ) {
                    $alergenos_exists = true;
                    break;
                }
            }

            if ( $alergenos_exists ) {
                echo '<div class="tabla-alergenos-container">';
                echo '<h4>' . esc_html__( 'Tabla de Alérgenos:', 'woocommerce-productos-alimenticios-chile' ) . '</h4>';
                echo '<table class="tabla-alergenos-3-columnas">';
                echo '<caption>' . esc_html__( 'Alérgenos', 'woocommerce-productos-alimenticios-chile' ) . '</caption>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>' . esc_html__( 'Alérgeno', 'woocommerce-productos-alimenticios-chile' ) . '</th>';
                echo '<th>' . esc_html__( 'Como ingrediente', 'woocommerce-productos-alimenticios-chile' ) . '</th>';
                echo '<th>' . esc_html__( 'Posible contaminación cruzada', 'woocommerce-productos-alimenticios-chile' ) . '</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                $this->incw_alergeno_row( esc_html__( 'Cereales que contengan gluten y productos derivados', 'woocommerce-productos-alimenticios-chile' ), $alergenos['gluten']['ing'], $alergenos['gluten']['con'] );
                $this->incw_alergeno_row( esc_html__( 'Crustáceos y productos derivados', 'woocommerce-productos-alimenticios-chile' ), $alergenos['crustaceos']['ing'], $alergenos['crustaceos']['con'] );
                $this->incw_alergeno_row( esc_html__( 'Huevos y productos derivados', 'woocommerce-productos-alimenticios-chile' ), $alergenos['huevos']['ing'], $alergenos['huevos']['con'] );
                $this->incw_alergeno_row( esc_html__( 'Pescado y productos derivados', 'woocommerce-productos-alimenticios-chile' ), $alergenos['pescado']['ing'], $alergenos['pescado']['con'] );
                $this->incw_alergeno_row( esc_html__( 'Maní y productos derivados', 'woocommerce-productos-alimenticios-chile' ), $alergenos['mani']['ing'], $alergenos['mani']['con'] );
                $this->incw_alergeno_row( esc_html__( 'Soya y productos derivados', 'woocommerce-productos-alimenticios-chile' ), $alergenos['soya']['ing'], $alergenos['soya']['con'] );
                $this->incw_alergeno_row( esc_html__( 'Leche y productos derivados (incluida la lactosa)', 'woocommerce-productos-alimenticios-chile' ), $alergenos['leche']['ing'], $alergenos['leche']['con'] );
                $this->incw_alergeno_row( esc_html__( 'Nueces y productos derivados', 'woocommerce-productos-alimenticios-chile' ), $alergenos['nueces']['ing'], $alergenos['nueces']['con'] );
                $this->incw_alergeno_row( esc_html__( 'Anhídrido sulfuroso y sulfitos en concentraciones > 10 mg/kg o 10 mg/L expresado como SO2', 'woocommerce-productos-alimenticios-chile' ), $alergenos['sulfitos']['ing'], $alergenos['sulfitos']['con'] );
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            }

            echo '</div>'; // Fin contenedor principal.
        }

        /**
         * Genera una fila para la tabla de alérgenos.
         *
         * @param string $alergeno_nombre Nombre del alérgeno.
         * @param string $ingrediente_value Valor para "Como ingrediente" (yes/no).
         * @param string $contaminacion_value Valor para "Contaminación cruzada" (yes/no).
         */
        private function incw_alergeno_row( $alergeno_nombre, $ingrediente_value, $contaminacion_value ) {
            echo '<tr>';
            echo '<td>' . esc_html( $alergeno_nombre ) . '</td>';
            echo '<td>' . ( 'yes' === $ingrediente_value ? '&#10004;' : '' ) . '</td>';
            echo '<td>' . ( 'yes' === $contaminacion_value ? '&#10004;' : '' ) . '</td>';
            echo '</tr>';
        }
    }

    new INCW_Productos_Alimenticios_Chile_Frontend_Display();

endif;