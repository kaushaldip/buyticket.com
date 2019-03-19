<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=windows-1256" />
<title>A PHP Error was encountered</title>
<link rel="shortcut icon" href="<?php echo MAIN_IMG_DIR_FULL_PATH;?>favicon.ico" />
<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>main.css" rel="stylesheet" type="text/css"/>

</head>

<body>
<div class="row-fluid content inside">
	<div class="main">
        
    
    <h4>A PHP Error was encountered</h4>
    
    
    
    <p>Severity: <?php echo $severity; ?></p>
    
    <p>Message:  <?php echo $message; ?></p>
    
    <p>Filename: <?php echo $filepath; ?></p>
    
    <p>Line Number: <?php echo $line; ?></p>
    </div>
</div> 
</body>
</html>