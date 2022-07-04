<?php
    include'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="icon" href="favicon.ico"/>
    
    <title> SPK Kualitas Jamur </title>
    <link href="assets/css/spacelab-bootstrap.min.css" rel="stylesheet"/>
    <link href="assets/css/general.css" rel="stylesheet"/>                
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>    
  </head>
  <body>
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="?">Menghitung Peningkatan Kapal</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          <?php if(empty($_SESSION['login'])):?>
           <!--  <li><a href="?m=hitung"><span class="glyphicon glyphicon-calendar"></span> Perhitungan</a></li> -->
            <li><a href="?m=rel_alternatif"><span class="glyphicon glyphicon-hourglass"></span> Perhitungan</a></li>    
            <li><a href="?m=hitung"><span class="glyphicon glyphicon-refresh"></span> Hasil</a></li>
			<li><a href="?m=login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			
          <?php else:?>
          <li><a href="?m=alternatif"><span class="glyphicon glyphicon-list-alt"></span> Kondisi</a></li>  
            <li><a href="?m=kriteria"><span class="glyphicon glyphicon-asterisk"></span> Fungsi Keanggotaan</a></li>
            <li><a href="?m=aturan"><span class="glyphicon glyphicon-cog"></span> Aturan</a></li>
            <li><a href="?m=rel_alternatif"><span class="glyphicon glyphicon-hourglass"></span> Perhitungan</a></li>    
            <li><a href="?m=hitung"><span class="glyphicon glyphicon-refresh"></span> Hasil</a></li>
            <li><a href="?m=password"><span class="glyphicon glyphicon-lock"></span> Password</a></li>
            <li><a href="aksi.php?act=logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          <?php endif ?>                                           
          </ul>          
          <div class="navbar-text"></div>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
    <?php
        if(file_exists($mod.'.php'))
            include $mod.'.php';
        else
            include 'home.php';
    ?>
    </div>
    <footer class="footer bg-primary">
      <div class="container">
        <p>Copyright &copy; PDP 2019  <em class="pull-right"></em></p>
      </div>
    </footer>
  </body>
</html>