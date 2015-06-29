
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo $_assets_url; ?>/images/icon.png">

    <title>Flat Dream</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo $_assets_url; ?>/js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo $_assets_url; ?>/fonts/font-awesome-4/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo $_assets_url; ?>/js/html5shiv.js"></script>
    <script src="<?php echo $_assets_url; ?>/js/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="<?php echo $_assets_url; ?>/css/style.css" rel="stylesheet" />

</head>

<body class="texture">

<div id="cl-wrapper" class="login-container">

    <?php echo $template['body']; ?>

</div>

<script src="<?php echo $_assets_url; ?>/js/jquery.js"></script>
<script type="text/javascript">
    $(function(){
        $("#cl-wrapper").css({opacity:1,'margin-left':0});
    });
</script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo $_assets_url; ?>/js/behaviour/voice-commands.js"></script>
<script src="<?php echo $_assets_url; ?>/js/bootstrap/dist/<?php echo $_assets_url; ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $_assets_url; ?>/js/jquery.flot/jquery.flot.js"></script>
<script type="text/javascript" src="<?php echo $_assets_url; ?>/js/jquery.flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="<?php echo $_assets_url; ?>/js/jquery.flot/jquery.flot.resize.js"></script>
<script type="text/javascript" src="<?php echo $_assets_url; ?>/js/jquery.flot/jquery.flot.labels.js"></script>
</body>
</html>
