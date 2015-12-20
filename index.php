<?php include 'sites.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <meta charset="utf-8">
    <title>IT-alan ty&ouml;paikka checklist</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="./css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="./css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="./ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="./ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="./ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="./ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="./ico/favicon.png">
  </head>

  <body>
    <!--
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Project name</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div> -->








    <div class="container">

      
      <div class="well" style="float: right;">
        <strong>Global actions</strong>
        <p>
          <a href="update.php" class="btn">P&auml;ivit&auml; lista</a><br />
          <small>(peliala.suomi reader)</small>
        </p>
      </div>
      <h1>Itala</h1>
      <table class="table table-bordered table-striped table-hover">
        <tr>
          <th>Firman nimi</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
        <?php foreach($sites as $filename => $site) { ?>
            <?php if( abs(strcmp(file_get_contents("/home/jehna/thejunkland.com/itala/tmp/".$filename), file_get_contents("/home/jehna/thejunkland.com/itala/tmp_recent/".$filename)) ) < 10 ) {?>
              <tr class="success">
                <td><a href="<?php echo $site; ?>"><?php echo $filename; ?></a></td>
                <td>OK</td>
                <td><a class="btn disabled">Ei teht&auml;v&auml;&auml;</a></td>
              </tr>
            <?php } else { ?>
              <tr class="error">
                <td><a href="<?php echo $site; ?>"><?php echo $filename; ?></a></td>
                <td>CHANGED</td>
                <td><a class="btn btn-danger" onclick="check('<?php echo $filename; ?>');">Olen tarkastanut sivuston.</a></td>
              </tr>
            <?php } ?>
        <?php }?>
      </table>
    </div> <!-- /container -->

  <script type="text/javascript">
    function check(site) {
      $.get("check.php?site="+site, function() {
        window.location.reload();
      });
    }
  </script>

  </body>
</html>