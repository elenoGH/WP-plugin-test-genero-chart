<?php
/*
 * Plugin Name: Graphic Manager Charts
 * Plugin URI:https://developer.wordpress.org/plugins/the-basics/
 * Description: Manegador de graficas (Big Data Genero)
 * Version:1.0
 * Author:Martin Eleno Perez
 * Author URI:https://developer.wordpress.org/
 * License:GPL2
 * License URI:https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:wporg
 * Domain Path:/prueba_plugin
 * {Plugin Name} is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 2 of the License, or
  any later version.

  {Plugin Name} is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with {Plugin Name}. If not, see {URI to Plugin License}.

 */
if (is_admin()) {
    // we are in admin mode
    /**
     * Esta etiqueta condicional comprueba si el panel de control o el panel de 
     * administración está intentando mostrarse. Es una función booleana que 
     * devolverá true si la URL que se accede está en la sección admin o 
     * false para una página front-end.
     * Esta función no comprueba si el usuario actual tiene permiso para ver el 
     * Panel de control o el panel de administración. En su lugar, use current_user_can ().
     */
//    require_once( dirname( __FILE__ ) . '/public/shortcodes-to-chart.php' );
    global $wpdb;
    $nombreTabla = $wpdb->prefix . "mcp_legislativo";
    if ($wpdb->get_var("SHOW TABLES LIKE '$nombreTabla'") == $nombreTabla) {
        /**
         * Si la tabla existe...
         * No haremos nada, pero se puede comprobar lo que hay actualizarlo por 
         * si había una versión vieja, guardar una copia de lo que hay etc etc..
         */
    } else {
        $sql = "CREATE TABLE ".$nombreTabla." ( "
            . " id int(11) NOT NULL AUTO_INCREMENT "
            . ", apellido varchar(33) DEFAULT NULL "
            . ", nombre varchar(29) DEFAULT NULL "
            . ", sexo varchar(6) DEFAULT NULL "
            . ", partido_politico varchar(50) NOT NULL "
            . ", principio_representacion varchar(27) DEFAULT NULL "
            . ", distrito_electoral varchar(10) DEFAULT NULL "
            . ", circunscripcion varchar(10) DEFAULT NULL "
            . ", propietario_suplente varchar(11) DEFAULT NULL "
            . ", periodo varchar(100) DEFAULT NULL "
            . ", anio_ini int(11) DEFAULT NULL "
            . ", anio_fin int(11) DEFAULT NULL "
            . ", poder varchar(100) DEFAULT NULL "
            . ", nivel_gobierno varchar(100) DEFAULT NULL "
            . ", cargo varchar(100) DEFAULT NULL "
            . ", descripcion_pp varchar(300) DEFAULT NULL "
            . ", entidad_federativa varchar(100) DEFAULT NULL "
            . ", PRIMARY KEY (id) "
            . ") ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";
        $wpdb->query($sql);
    }
}


//add_action( 'wp_loaded', function ()
//{
//    if ( !is_admin() ) { // Only target the front end
//        // Do what you need to do
//        require_once( dirname( __FILE__ ) . '/public/shortcodes-to-chart.php' );
//    }
//});
///**
// * Activacion de un hook
// * En la activación, los complementos pueden ejecutar una rutina para agregar 
// * reglas de reescritura, agregar tablas de base de datos personalizadas o 
// * establecer valores de opción predeterminados.
// */
//
//register_activation_hook( __FILE__, 'plugin_f_a_tets_eleno_activation' );
//
///**
// * Desactivar Hook
// * Al desactivar, los complementos pueden ejecutar una rutina para eliminar 
// * datos temporales, como caché y archivos temporales y directorios.
// */
//
//register_deactivation_hook( __FILE__, 'plugin_f_a_tets_eleno_deactivation' );


require_once( dirname(__FILE__) . '/public/shortcodes-to-chart.php' );

class import_csv {

    function main_body() {
        $string = 'Agregar solo archivo CSV';
        echo $string;
        ?>
        <div class="wrap">
            <h2>Import CSV Files</h2><br/>
            <?php if ($this->error !== '') : ?>
                <div class="error"><?php echo $this->error; ?></div>
            <?php endif; ?>
            <form class="add:the-list: validate" method="post" enctype="multipart/form-data">
                <input name="_csv_import_files_next" type="hidden" value="next" />
                <label for="csv_import">Select a CSV file:</label><br/>
                <input name="csv_import" id="csv_import" type="file" value=""/>
                <!--div id="formatdiv" class="postbox" style="display: block;max-width:350px;">
                    <h3 class="hndle" style="cursor:auto;padding:10px;">
                        <span>Select Import Type</span>
                    </h3>
                    <div class="inside">
                        <div id="post-formats-select">
                            <input id="post-format-0" class="post-format" type="radio" checked="checked" value="post" name="post_format">
                            <label class="post-format-icon post-format-standard" for="post-format-0">
                                Posts
                            </label>
                            <br>
                            <input id="post-format-page" class="post-format" type="radio" value="page" name="post_format">
                            <label for="post-format-page">&nbsp;&nbsp;Pages</label>
                            <br>
                        </div>
                    </div>
                </div>
                <div id="formatdiv" class="postbox" style="display: block;max-width:350px;">
                    <h3 class="hndle" style="cursor:auto;padding:10px;">
                        <span>
                            Select Field Delimiter
                        </span>
                    </h3>
                    <div class="inside">
                        <div id="post-formats-select">
                            <select name="field-delimiter">
                                <option value=",">comma  ( , )</option>
                                <option value=";">semicolon  ( ; )</option>
                                <option value="	">tab  ( &nbsp;&nbsp;&nbsp;&nbsp; )</option>
                            </select>
                        </div>
                    </div>
                </div-->
                <input type="submit" class="button" name="submit" value="Agregar" />
            </form>
        </div>
        <?php
    }

}

function get_action_class_import_csv() {
    $plugin = new import_csv;
    add_management_page("Datos CSV", "Importar Archivo CSV", "manage_options", "import_csv_files", array($plugin, 'main_body'));
}

add_action('admin_menu', 'get_action_class_import_csv');
