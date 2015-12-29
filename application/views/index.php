<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="robots" content="index, follow">
<meta name="author" content="Aditya Nursyahbani & Hartanto Kurniawan">
<meta name="language" content="Indonesia">
<meta name="revisit-after" content="7">
<meta name="rating" content="general">
<meta name="spiders" content="all">
<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico">
<title><?php echo $page_title; ?></title>
	<?php echo $_includes; ?>
</head>
<body>
<div class="mainwrapper">
    <!-- START OF HEADER -->
    <?php echo $_header; ?>
    <!-- END OF HEADER -->
	
    <!-- START OF LEFT PANEL -->
    <?php echo $_side_menu; ?>
    <!-- END OF LEFT PANEL -->
    
    <!-- START OF RIGHT PANEL -->
    <?php echo $_content; ?>
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
    
    <?php echo $_footer; ?>
</div><!--mainwrapper-->



<!-- Additional files for the Highslide popup effect -->
<!--
<script type="text/javascript" src="http://www.highcharts.com/media/com_demo/highslide-full.min.js"></script>
<script type="text/javascript" src="http://www.highcharts.com/media/com_demo/highslide.config.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="http://www.highcharts.com/media/com_demo/highslide.css" />
!-->
</body>
</html>
