# Woocommerce - Información Nutricional Chile

**Versión:** 1.0.2  
**Autor:** Tech4In  
**Plugin URI:** https://tech4in.com/producto/woocommerce-informacion-nutricional-chile/  
**Author URI:** https://tech4in.com  
**Text Domain:** woocommerce-informacion-nutricional-chile  
**Domain Path:** /languages

## Descripción

El plugin "Woocommerce - Información Nutricional Chile" añade información nutricional y sellos de advertencia a los productos de WooCommerce según la normativa chilena. Permite especificar datos como porciones, energía, proteínas, grasas, hidratos de carbono, azúcares y sodio, además de marcar alérgenos y activar sellos de advertencia.

## Instalación

1. **Requisitos:**  
   - WordPress 5.0 o superior.  
   - WooCommerce 3.0 o superior.  
   - PHP 7.0 o superior.

2. **Subir e Instalar el Plugin:**  
   1. **Descarga** el archivo ZIP del plugin `woocommerce-informacion-nutricional-chile`.
   2. En tu panel de administración de WordPress, ve a **Plugins > Añadir Nuevo**.
   3. Haz clic en **Subir Plugin** y selecciona el archivo ZIP que descargaste.
   4. Haz clic en **Instalar Ahora**.
   5. Una vez instalado, haz clic en **Activar Plugin**.
   6. ¡Listo! El plugin **Información Nutricional Chile** ya está instalado y activado.

3. **Configuración Inicial:**  
   - Tras la activación, edita un producto para visualizar las nuevas secciones (metaboxes) que añade el plugin.

## Configuración

El plugin añade tres metaboxes en la pantalla de edición de productos de WooCommerce:

- **Sellos de Advertencia:**  
  Permite activar opciones como “Alto en Sodio”, “Alto en Azúcares”, “Alto en Grasas Saturadas” y “Alto en Calorías”.

- **Tabla Nutricional:**  
  Permite ingresar:
  - Descripción de la porción.
  - Porción en gramos.
  - Porciones por envase.
  - Valores de energía, proteínas, grasa total, hidratos de carbono, azúcares y sodio.
  - Listado de ingredientes.

- **Tabla de Alérgenos:**  
  Permite marcar, mediante checkboxes, los alérgenos presentes (como gluten, crustáceos, huevos, etc.).

## Uso

1. **Edición del Producto:**  
   - Al editar un producto en WooCommerce, encontrarás las secciones de "Sellos de Advertencia", "Tabla Nutricional" y "Tabla de Alérgenos".
   - Marca las opciones correspondientes para los sellos y alérgenos.
   - Ingresa los datos nutricionales en la tabla.
   *   Asegúrate de tener la información nutricional precisa de tus productos. Consulta las etiquetas de los productos o la información proporcionada por tus proveedores.
   *   Si un campo no aplica para un producto, puedes dejarlo en blanco.

2. **Visualización en el Frontend:**  
   - La información ingresada se mostrará en la página del producto, debajo del resumen.
   - Se presentará una tabla nutricional comparando valores por porción y por 100g, además de imágenes de los sellos activos.

## Preguntas Frecuentes (FAQ)

**P: ¿Necesito conocimientos técnicos para usar este plugin?**
R: No, **Información Nutricional Chile** está diseñado para ser fácil de usar incluso para usuarios sin experiencia técnica. La interfaz es intuitiva y la documentación te guía paso a paso.

**P: ¿El plugin es compatible con mi tema de WooCommerce?**
R: **Información Nutricional Chile** debería ser compatible con la mayoría de los temas de WooCommerce.  Sin embargo, si experimentas algún problema de compatibilidad, contáctanos y te ayudaremos.

**P: ¿Dónde se muestra la tabla nutricional en la página del producto?**
R: La tabla nutricional se muestra debajo de la descripción corta del producto, en la pestaña "Información Adicional" o en una ubicación similar, dependiendo de tu tema.  [Image of Nutritional information table location on product page]

**P: ¿Qué unidades de medida debo usar?**
R: Utiliza las unidades de medida estándar chilenas para la información nutricional (kcal, g, mg, etc.).

**P: ¿Cómo puedo obtener soporte si tengo problemas?**
R: Puedes contactarnos a través de nuestro sistema de tickets de soporte en www.tech4in.com o enviarnos un correo electrónico a soporte@tech4in.com.  ¡Estamos aquí para ayudarte!

**P: ¿Los datos ingresados se eliminan al desactivar el plugin?**  
R: No, los metadatos se mantienen en la base de datos. Para eliminarlos, se debe realizar una limpieza manual o mediante un script de desinstalación.

**P: ¿Puedo personalizar el estilo de la tabla nutricional?**  
R: Sí, puedes editar el archivo CSS ubicado en `assets/css/frontend-styles.css` para modificar la apariencia.

## Changelog

**1.0.2**  
- Unificación de la versión en la cabecera (actualizado a 1.0.2).  
- Correcciones menores en la visualización de metaboxes.  
- Mejoras en la validación y sanitización de entradas.

**1.0.1**  
- Primera versión estable con funcionalidades básicas.

## Licencia

Este plugin se distribuye bajo la licencia GPLv2 o superior.

## Soporte

Para soporte, visita [TECH4in](https://tech4in.com/soporte) o envía un correo a [soporte@tech4in.com](mailto:soporte@tech4in.com).