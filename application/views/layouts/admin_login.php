<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')&& $_SERVER['HTTP_HOST'] == "buyticket.com") @ob_start("ob_gzhandler"); else ob_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Required Stylesheets -->
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>css/reset.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>css/mws.style.css" media="screen" />

<!-- Theme Stylesheet -->
<link rel="stylesheet" type="text/css" href="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>css/mws.theme.css" media="screen" />

<!-- JavaScript Plugins -->
<script type="text/javascript" src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>js/jquery-1.7.1.min.js"></script>

<title><?php echo $template['title']; ?></title>

</head>

<body>

	<div id="mws-login-bg">
        <div id="mws-login-wrapper">
            <?php echo $template['body']; ?>
            
        </div>
    </div>

</body>
</html>
