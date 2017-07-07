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

/**
 * script que utilizaran mis vistas de graficas
 */
function assets_script(){
    
    wp_enqueue_style( 'graficas-css', plugin_dir_url( __FILE__ ).'assets/css/css-general-admin.css', '1.0');
    wp_enqueue_script('graficas-js', plugin_dir_url( __FILE__ ).'assets/js/js-general-admin.js', array('jquery'), '1.0');
    /**
     * @dominio : plugin_dir_url( __FILE__ )
     * @ruta_absoluta : dirname( __FILE__ )
     * USE ADMIN-AJAX.PHP TO HANDLE AJAX REQUESTS
     */
    wp_localize_script( 'graficas-js', 'object_urls',
            array(
                 'get_data_mcpl' => plugin_dir_url( __FILE__ ).'application/controllers/get_data.php'
                ,    'admin_url_ajax'   => admin_url( 'admin-ajax.php' )
                )
            );
    wp_enqueue_script('graficas-chart-bundle-js', plugin_dir_url( __FILE__ ).'assets/js/chartjs/Chart.bundle.js');
    wp_enqueue_script('graficas-utils-js', plugin_dir_url( __FILE__ ).'assets/js/chartjs/utils.js');
}

add_action('wp_enqueue_scripts', 'assets_script');


// if both logged in and not logged in users can send this AJAX request,
// add both of these actions, otherwise add only the appropriate one
add_action( 'wp_ajax_nopriv_custom_action', 'ajax_custom_action' );
add_action( 'wp_ajax_custom_action', 'ajax_custom_action' );


function ajax_custom_action() {
 // get the submitted parameters
 $postID = $_POST['postID'];
 
 // generate the response
 $response = json_encode(
            array(
                'success' => true
                , 'postID' => $postID) 
         );
 
 // response output
 header( "Content-Type: application/json" );
 echo $response;
 
 // IMPORTANT: don't forget to "exit"
 exit;
}

add_action('wp_ajax_custom_action', 'ajax_custom_action');
add_action('wp_ajax_nopriv_custom_action', 'ajax_custom_action');