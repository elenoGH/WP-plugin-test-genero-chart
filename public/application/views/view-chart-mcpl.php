<section class="aquiMiEstilo">
    <h1>Aqui van nuestras Graficas</h1>
    <canvas id="canvas"></canvas>
    
<?php 
    foreach ($obj_json as $key => $item) {
        
        echo '<br>'.$key.' '.$item->anio_ini." ".$item->anio_fin.' '.$item->totales_mujeres_suma.' '.$item->totales_hombres_suma.' '.$item->total;
    }
?>
</section>