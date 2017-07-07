
jQuery(document).ready(js_general_admin);

function js_general_admin($)
{
    
    /**
     * 
     */
    
    jQuery.post(
        // este objeto se declara con el wp_localize_script
        // para poder tener acceso a admin-ajax.php 
        //do_action( 'wp_ajax_nopriv_' . $_REQUEST['action'] );
        //do_action( 'wp_ajax_' . $_POST['action'] );
        object_urls.admin_url_ajax,
        {
            // here we declare the parameters to send along with the request
            // this means the following action hooks will be fired:
            // wp_ajax_nopriv_myajax-submit and wp_ajax_myajax-submit
            action : 'custom_action',

            // other parameters can be added along with "action"
            postID : 'object_urls.postID'
        },
        function( response ) {
        alert( response.success );
        }
    );
    
//    $( "#p_nivel_gob" ).text('Todos');
//    $( "#p_cargo" ).text('Todos');
//    $( "#p_entidad_federativa" ).text('Todas');
//    $( "#p_partido_pol" ).text('Todos');
//    $( "#p_princ_rep" ).text('Todos');
//    $( "#p_pro_sup" ).text('Todos');
//    
//    jQuery.ajax(
//    {
//        type: "post",
//        dataType: "json",
//        url: object_urls.admin_url,
//        success: function(msg){
//            console.log(msg);
//        }
//    });
//    $.ajax({
//        url: ajaxurl
//    });
//    jQuery.post(ajaxurl, data, function(response) {
//            alert('Got this from the server: ' + response);
//    });
    /*****/
//    console.log('Aqui mi jquery');
//    var color = Chart.helpers.color;
//    var barChartData = {
//        labels: ["January", "February", "March", "April", "May", "June", "July"],
//        datasets: [{
//                type: 'bar',
//                label: 'Dataset 1',
//                backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
//                borderColor: window.chartColors.red,
//                data: [
//                    randomScalingFactor(),
//                    randomScalingFactor(),
//                    randomScalingFactor(),
//                    randomScalingFactor(),
//                    randomScalingFactor(),
//                    randomScalingFactor(),
//                    randomScalingFactor()
//                ]
//            }, {
//                type: 'line',
//                label: 'Dataset 2',
//                backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
//                borderColor: window.chartColors.blue,
//                data: [
//                    randomScalingFactor(),
//                    randomScalingFactor(),
//                    randomScalingFactor(),
//                    randomScalingFactor(),
//                    randomScalingFactor(),
//                    randomScalingFactor(),
//                    randomScalingFactor()
//                ]
//            }, {
//                type: 'bar',
//                label: 'Dataset 3',
//                backgroundColor: color(window.chartColors.green).alpha(0.2).rgbString(),
//                borderColor: window.chartColors.green,
//                data: [
//                    randomScalingFactor(),
//                    randomScalingFactor(),
//                    randomScalingFactor(),
//                    randomScalingFactor(),
//                    randomScalingFactor(),
//                    randomScalingFactor(),
//                    randomScalingFactor()
//                ]
//            }]
//    };
//
//    // Define a plugin to provide data labels
//    Chart.plugins.register({
//        afterDatasetsDraw: function (chart, easing) {
//            // To only draw at the end of animation, check for easing === 1
//            var ctx = chart.ctx;
//
//            chart.data.datasets.forEach(function (dataset, i) {
//                var meta = chart.getDatasetMeta(i);
//                if (!meta.hidden) {
//                    meta.data.forEach(function (element, index) {
//                        // Draw the text in black, with the specified font
//                        ctx.fillStyle = 'rgb(0, 0, 0)';
//
//                        var fontSize = 16;
//                        var fontStyle = 'normal';
//                        var fontFamily = 'Helvetica Neue';
//                        ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
//
//                        // Just naively convert to string for now
//                        var dataString = dataset.data[index].toString();
//
//                        // Make sure alignment settings are correct
//                        ctx.textAlign = 'center';
//                        ctx.textBaseline = 'middle';
//
//                        var padding = 5;
//                        var position = element.tooltipPosition();
//                        ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
//                    });
//                }
//            });
//        }
//    });
//
//    window.onload = function () {
//        var ctx = document.getElementById("canvas").getContext("2d");
//        window.myBar = new Chart(ctx, {
//            type: 'bar',
//            data: barChartData,
//            options: {
//                responsive: true,
//                title: {
//                    display: true,
//                    text: 'Mujeres y Hombres en cargos públicos'
//                },
//            }
//        });
//    };
//
//    document.getElementById('randomizeData').addEventListener('click', function () {
//        barChartData.datasets.forEach(function (dataset) {
//            dataset.data = dataset.data.map(function () {
//                return randomScalingFactor();
//            })
//        });
//        window.myBar.update();
//    });
}