<?php
require_once "functions.php";
session_start();
//if ($_SESSION['ativa']=='true'){
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>MetaAdmin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon 
    <link href="./img/icon.png" rel="icon">-->

    <!-- Google Web Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    
    <!-- Icon Font Stylesheet-->
    <link href="./fontawesome/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="./lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="./lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="./css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Inicio do spinner enquanto carrega página 
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
       Fim do spinner enquanto carrega página -->


        <!-- Inicio da barra lateral esquerda -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="./user_panel.php" class="navbar-brand mx-4 mb-3">
                    <h4 class="text-primary"><i class="fa-solid fa-chart-pie"></i>&nbsp;MetaAdmin</h4>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="./img/chefe.jpg" alt="" style="width: 35px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">ADMINISTRADOR</h6>
                        <span><?php echo $_SESSION['matricula']; ?></span><br>
                    </div>
                </div>
                <div class='navbar-nav w-100'>
                    <a href='./user_panel.php' class='nav-item nav-link active'><i class='fa fa-tachometer-alt me-2'></i>Dashboard</a>
                </div>
            </nav>
        </div>
        <!-- Fim da barra lateral esquerda -->


        <!-- Content Start -->
        <div class="content">
            <!-- Inicio da barra superior -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="./index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <!--<img class="rounded-circle me-lg-2" src="./img/<?php echo $_SESSION['om'].'.jpg'; ?>" alt="" style="width: 35px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?php echo $_SESSION['om']." <br>".$_SESSION['nip'];; ?></span>-->
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="./logout.php" class="dropdown-item">Sair</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!--Fim barra superior -->


<!-- Inicio da Area exibição central -->
            
<?php 
    $query = "SELECT SUM(meta_atual), SUM(valor_atual) FROM indicadores";
    $resultado = mysqli_query($connect, $query);

    while ($row_registro = mysqli_fetch_assoc($resultado))
    {
        $soma_meta = $row_registro['SUM(meta_atual)'];
        $soma_valor = $row_registro['SUM(valor_atual)'];
        $taxa_metas = ($soma_valor*100)/$soma_meta;
        $metas_nao_alcancadas = $soma_meta - $soma_valor;
    }
?>

<!-- Sale & Revenue Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-simple fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">N° Total de Metas</p>
                    <h6 class="mb-0"><?php echo $soma_meta;?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-line fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Metas Alcançadas</p>
                    <h6 class="mb-0"><?php echo $soma_valor;?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-thumbs-up fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Taxa de Metas Alcançadas</p>
                    <h6 class="mb-0"><?php echo round($taxa_metas)."%"?></h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-thumbs-down fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Metas não Alcançadas</p>
                    <h6 class="mb-0"><?php echo $metas_nao_alcancadas?></h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Sale & Revenue End -->


<!-- Sales Chart Start -->
<div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <!--<div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Single Line Chart</h6>
                            <canvas id="line-chart"></canvas>
                        </div>
                    </div>-->
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Comparativo Anual</h6>
                            <canvas id="salse-revenue"></canvas>
                        </div>
                    </div>
                    <!--<div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Single Bar Chart</h6>
                            <canvas id="bar-chart"></canvas>
                        </div>
                    </div>-->
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Comparativo Individual</h6>
                            <canvas id="worldwide-sales"></canvas>
                        </div>
                    </div>
                    <!--<div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Pie Chart</h6>
                            <canvas id="pie-chart"></canvas>
                        </div>
                    </div>-->
                    <!--<div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Doughnut Chart</h6>
                            <canvas id="doughnut-chart"></canvas>
                        </div>
                    </div>-->
                </div>
            </div>
<!-- Sales Chart End -->


<!-- Recent Sales Start -->

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Colaboradores</h6>
            <!--<a href="">Mostrar todos</a>-->
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Matricula</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Meta Atual</th>
                        <th scope="col">Meta Anterior</th>
                        <th scope="col">Valor Atual</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>                        
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                        $query = "SELECT * FROM indicadores ORDER BY matricula";
                        $resultado = mysqli_query($connect, $query);

                        while ($row_registro = mysqli_fetch_assoc($resultado)){
                        $matricula = $row_registro['matricula'];
                        $nome = $row_registro['nome'];
                        $meta_atual = $row_registro['meta_atual'];
                        $meta_anterior = $row_registro['meta_anterior'];
                        $valor_atual = $row_registro['valor_atual'];
                        
                        $query = "SELECT * FROM ponto WHERE matricula='$matricula' AND status='trabalhando'";
                        $executar = mysqli_query ($connect, $query);
                        $return = mysqli_fetch_assoc($executar);
                
                        if (!empty($return['matricula']) AND !empty($return['status'])) {
                            $status = 'trabalhando';
                        }else{
                            $status = 'pausado';
                        }
                        echo "<form method='post' action=''>";
                        echo "<tr>";
                        echo "<td>$matricula</td><td>$nome</td><td>$meta_atual</td><td>$meta_anterior</td><td>$valor_atual</td><td>$status</td><td><button type='submit' name='acessar' value='$matricula' formaction='./individual.php?matricula=$matricula' class='btn btn-primary m-2'>ACESSAR</button></td>";
                        echo "</tr>";
                        echo "</form>";
                    }
                    //echo $meta_atual;
                    ?>


            
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--Fim da Area de exibição central -->

            <!-- Inicio do rodapé -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy;<a>Instituto Federal do Rio Grande do Norte<br></a>All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fim do rodapé -->
        </div>
        <!-- Content End -->


        <!-- Back to Top 
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>-->
    </div>

    <!-- JavaScript Libraries -->
    <script src="./js/jquery-3.4.1.min.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./lib/chart/chart.min.js"></script>
    <script src="./lib/easing/easing.min.js"></script>
    <script src="./lib/waypoints/waypoints.min.js"></script>
    <script src="./lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="./lib/tempusdominus/js/moment.min.js"></script>
    <script src="./lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="./lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="./js/main.js"></script>
</body>
</html>

<?php/* }
else{
header('location:./index.php');
}*/?>