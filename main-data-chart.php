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
if ( is_admin() ) {
    // we are in admin mode
    /**
     * Esta etiqueta condicional comprueba si el panel de control o el panel de 
     * administración está intentando mostrarse. Es una función booleana que 
     * devolverá true si la URL que se accede está en la sección admin o 
     * false para una página front-end.
     * Esta función no comprueba si el usuario actual tiene permiso para ver el 
     * Panel de control o el panel de administración. En su lugar, use current_user_can ().
     */
}
else {
    require_once( dirname( __FILE__ ) . '/public/shortcodes-to-chart.php' );
}