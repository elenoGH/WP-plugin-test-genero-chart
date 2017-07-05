<?php

/* 
 * Se crean los shortcodes (codigos cortos) para agregar
 * cada tipo de grafica necesaria para "genero"
 * sc = short-code
 */

/**
 * 
 * @param type $atts
 * @param type $content
 * @return type
 * #MujeresEnCargosPublicos
 */
function dwwp_sc_mcp_legislativo($atts, $content = NULL)
{
//    $pairs = array(
//            'title' =>  'Titulo por default'
//        ,   'src'   =>  'www.google.com'
//    );
//    $atts = shortcode_atts($pairs, $atts);
//    
//    return '<h1>'.$atts['title'].'</h1>';
    
    // obtenemos JSON temporal de datos a mostrar en la grafica
    // verificar como integrar codigo coneccion a la BD llamado a una 
    // tabla espesifica
    $url = 'http://datosgenero.aurealabs.org/json_grafica_test.php';
    
    /**
     * Recupere la respuesta bruta de una solicitud HTTP 
     * segura utilizando el método GET.
     */
    $response = wp_safe_remote_get($url);
    
    /**
     * Recupera el cuerpo de una solicitud HTTP ya recuperada.
     */
    $body = wp_remote_retrieve_body($response);
    
    $obj_json = json_decode($body);
    
    //var_dump($obj_json);
    
    // Incluir nuestro HTML
    /**
     * Frente a la aplicación de WordPress. Este archivo no hace nada, pero cargas
     * view-chart-mcpl.php que hace y dice a WordPress para cargar el tema.
     *
     * @package WordPress
     * 
     * Guarda la informacion en memoria, y hasta que no la requiramos
     * la liberamos
    */
    ob_start();
    require plugin_dir_path(dirname( __FILE__ )).'public/application/views/view-chart-mcpl.php';
    
    
    //Regresar el contenido
    return ob_get_clean();
    
}

add_shortcode('sc-mcp-legislativo', 'dwwp_sc_mcp_legislativo');