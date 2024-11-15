<?php include_once('php/conexion.php'); ?>
<html>
    <head>
        <title>Estadistica</title>
        <meta charset="UTF-8">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/chartJS/Chart.min.js"></script>
        <!-- Select 2 -->
        <link rel="stylesheet" type="text/css" href="select2/css/select2.css">
        <script src="select2/jquery-3.1.1.min.js"></script>
        <script src="select2/js/select2.js"></script>
    </head>
    <style>
        .caja{
            margin: auto;
            max-width: 250px;
            padding: 20px;
            border: 1px solid #BDBDBD;
        }
        .caja select{
            width: 100%;
            font-size: 16px;
            padding: 5px;
        }
        .resultados{
            margin: auto;
            margin-top: 40px;
            width: 1000px;
        }
    </style>
    <body> 
        <div class="caja">
            <select id="periodo" name="periodo" onChange="mostrarResultados(this.value);" class="form-control">
                <?php
                    $model = new Model();
                    $resultado = $model->obtenerAnios();

              if ($resultado) {
    while ($rows = $resultado->fetch_assoc()) {
                ?>
                    <option value="<?php echo $rows['fecha_reg'] ?>">
                        <?php echo $rows['fecha_reg']  ?></option>
                <?php
                }
                } else {
                    echo "No se encontraron resultados.";
                }
                
                $model->cerrarConexion();
                    ?>
            </select>
        </div>
        <div class="resultados"><canvas id="grafico"></canvas></div>
    </body>
    <script>
            $(document).ready(mostrarResultados(<?php echo date("Y") ?>)); 
                function mostrarResultados(year){
                    $('.resultados').html('<canvas id="grafico"></canvas>');
                    $.ajax({
                        type: 'POST',
                        url: 'php/procesar.php',
                        data: 'year='+year,
                        dataType: 'JSON',
                        success:function(response){
                            var Datos = {
                                    labels : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                    datasets : [
                                        {
                                            fillColor : 'rgba(91,228,146,0.6)', //COLOR DE LAS BARRAS
                                            strokeColor : 'rgba(57,194,112,0.7)', //COLOR DEL BORDE DE LAS BARRAS
                                            highlightFill : 'rgba(73,206,180,0.6)', //COLOR "HOVER" DE LAS BARRAS
                                            highlightStroke : 'rgba(66,196,157,0.7)', //COLOR "HOVER" DEL BORDE DE LAS BARRAS
                                            data : response
                                        }
                                    ]
                                }
                            var contexto = document.getElementById('grafico').getContext('2d');
                            window.Barra = new Chart(contexto).Bar(Datos, { responsive : true });
                            Barra.clear();
                        }
                    });
                    return false;
                }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#periodo').select2();
        });
    </script>
</html>