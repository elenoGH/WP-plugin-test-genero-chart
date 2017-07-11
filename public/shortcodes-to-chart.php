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
    wp_enqueue_style( 'graficas-css', plugin_dir_url( __FILE__ ).'assets/css/css-general-admin.css', '1.0');
    wp_enqueue_script('graficas-js', plugin_dir_url( __FILE__ ).'assets/js/js-grafica-mcpl.js', array('jquery'), '1.0');
    /**
     * @dominio : plugin_dir_url( __FILE__ )
     * @ruta_absoluta : dirname( __FILE__ )
     * USE ADMIN-AJAX.PHP TO HANDLE AJAX REQUESTS
     */
    wp_localize_script( 'graficas-js', 'object_urls',
            array(
                    'admin_url_ajax'   => admin_url( 'admin-ajax.php' )
                )
            );
    wp_enqueue_script('graficas-chart-bundle-js', plugin_dir_url( __FILE__ ).'assets/js/chartjs/Chart.bundle.js');
    wp_enqueue_script('graficas-utils-js', plugin_dir_url( __FILE__ ).'assets/js/chartjs/utils.js');
        
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
//function assets_script()
//{
//    wp_enqueue_style( 'graficas-css', plugin_dir_url( __FILE__ ).'assets/css/css-general-admin.css', '1.0');
//    wp_enqueue_script('graficas-js', plugin_dir_url( __FILE__ ).'assets/js/js-general-admin.js', array('jquery'), '1.0');
//    /**
//     * @dominio : plugin_dir_url( __FILE__ )
//     * @ruta_absoluta : dirname( __FILE__ )
//     * USE ADMIN-AJAX.PHP TO HANDLE AJAX REQUESTS
//     */
//    wp_localize_script( 'graficas-js', 'object_urls',
//            array(
//                    'admin_url_ajax'   => admin_url( 'admin-ajax.php' )
//                )
//            );
//    wp_enqueue_script('graficas-chart-bundle-js', plugin_dir_url( __FILE__ ).'assets/js/chartjs/Chart.bundle.js');
//    wp_enqueue_script('graficas-utils-js', plugin_dir_url( __FILE__ ).'assets/js/chartjs/utils.js');
//}
//
//add_action('wp_enqueue_scripts', 'assets_script');


// if both logged in and not logged in users can send this AJAX request,
// add both of these actions, otherwise add only the appropriate one
add_action( 'wp_ajax_nopriv_custom_action', 'get_data_custom_action' );
add_action( 'wp_ajax_custom_action', 'get_data_custom_action' );

/**
 * funcion que recupera datos via ajax
 */
function get_data_custom_action()
{
    // get the submitted parameters
    $nivel_gobierno_            = $_POST['nivel_gobierno_'];
    $cargo_                     = $_POST['cargo_'];
    $entidad_federativa_mcpl_   = $_POST['entidad_federativa_mcpl_'];
    $partido_politico_          = $_POST['partido_politico_'];
    $principio_rep_             = $_POST['principio_rep_'];
    $prop_sup_                  = $_POST['prop_sup_'];
    
    $and_cond = "";
    
    if (!empty($nivel_gobierno_)) {
        $and_cond = $and_cond." and nivel_gobierno = '".$nivel_gobierno_."' ";
    }
    if (!empty($cargo_)) {
        $and_cond = $and_cond." and cargo = '".$cargo_."'";
    }
    if (!empty($entidad_federativa_mcpl_)) {
        $and_cond = $and_cond." and entidad_federativa = '".$entidad_federativa_mcpl_."' ";
    }
    if (!empty($partido_politico_)) {
        $and_cond = $and_cond." and partido_politico = '".$partido_politico_."' ";
    }
    if (!empty($principio_rep_)) {
        $and_cond = $and_cond." and principio_representacion = '".$principio_rep_."' ";
    }
    if (!empty($prop_sup_)) {
        $and_cond = $and_cond." and propietario_suplente = '".$prop_sup_."' ";
    }
    /**
     * 
     */
    global $wpdb;
    $nombreTabla = $wpdb->prefix . "mcp_legislativo";
    if ($wpdb->get_var("SHOW TABLES LIKE '$nombreTabla'") == $nombreTabla) {
        
        $set_to_cero = $wpdb->get_results("SET @row_number = 0;");
        $objeto = $wpdb->get_results(
                " SELECT (@row_number:=@row_number + 1) AS count_rows "
                . " , MAX(anio_ini) as anio_ini"
                . " , MAX(anio_fin) as anio_fin "
                . " ,COALESCE(SUM(CASE WHEN sexo = 'Hombre' THEN 1 END), 0) AS hombre_suma "
                . " ,COALESCE(SUM(CASE WHEN sexo = 'Mujer' THEN 1 END), 0) AS mujer_suma "
                . " ,SUM(CASE WHEN sexo IS NOT NULL THEN 1 ELSE 0 END) AS total "
                . " from ". $nombreTabla ." where id > 0  "
                . $and_cond
                . " GROUP BY anio_ini, anio_fin "
                . " order by anio_ini ", OBJECT 
            );
    }
    
    // obtenemos JSON temporal de datos a mostrar en la grafica
    // verificar como integrar codigo coneccion a la BD llamado a una 
    // tabla espesifica
//    $url = 'http://datosgenero.aurealabs.org/json_grafica_test.php';
    
    /**
     * Recupere la respuesta bruta de una solicitud HTTP 
     * segura utilizando el método GET.
     */
//    $response = wp_safe_remote_get($url);
    
    /**
     * Recupera el cuerpo de una solicitud HTTP ya recuperada.
     */
//    $objeto = wp_remote_retrieve_body($response);
        
    // response output
//    header( "Content-Type: application/json" );
    echo json_encode($objeto);
    die;
}

/**
 * traemos partidos politicos de mcp_legislativo
 */
add_action( 'wp_ajax_nopriv_get_pp_mcpl', 'get_data_pp_mcpl' );
add_action( 'wp_ajax_get_pp_mcpl', 'get_data_pp_mcpl' );

function get_data_pp_mcpl()
{
    $ent_fed_ = $_POST['ent_fed_'];
    
    $and_cond = "";
    
    if (!empty($ent_fed_)) {
        $and_cond = $and_cond." and entidad_federativa = '".$ent_fed_."' ";
    }
    global $wpdb;
    $nombreTabla = $wpdb->prefix . "mcp_legislativo";
    if ($wpdb->get_var("SHOW TABLES LIKE '$nombreTabla'") == $nombreTabla) {
        
        $objeto = $wpdb->get_results(
                " select partido_politico, descripcion_pp "
                . " from ".$nombreTabla
                . " where id > 0 "
                . $and_cond
                . " group by partido_politico "
                . " order by partido_politico asc ", OBJECT 
            );
    }
    
    echo json_encode($objeto);
    die;
}

add_action( 'wp_ajax_nopriv_get_pr_mcpl', 'get_data_pr_mcpl' );
add_action( 'wp_ajax_get_pr_mcpl', 'get_data_pr_mcpl' );

function get_data_pr_mcpl()
{    
    $and_cond = "";
    
    global $wpdb;
    $nombreTabla = $wpdb->prefix . "mcp_legislativo";
    if ($wpdb->get_var("SHOW TABLES LIKE '$nombreTabla'") == $nombreTabla) {
        
        $objeto = $wpdb->get_results(
                " select principio_representacion "
                . " from ".$nombreTabla
                . " where id > 0 "
                . $and_cond
                . " group by principio_representacion "
                . " order by principio_representacion asc ", OBJECT 
            );
    }
    
    echo json_encode($objeto);
    die;
}
