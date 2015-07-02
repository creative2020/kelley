<?php 

if(!isset($_GET["font"]))
die("Cannot Be accessed directly");

$font = trim($_GET["font"]);
$script_font = str_replace(" ","+",$font);

$fsize = ( isset($_GET["fontsize"])) ? $_GET["fontsize"] : 12 ;

$import_style = "<link href='http://fonts.googleapis.com/css?family={$script_font}&v2' rel='stylesheet' type='text/css'>";
$code = "<style> #inject-font { color:#313131; font-size:{$fsize}px; font-family: '".$font."', sans-serif; } </style>" ;

if(isset($_GET["cufon"]))
{
 $font_name = $font;
 $c_check = substr ($font_name,0,7);
 if($c_check=="custom_")
 $font_name = "uploaded/".$font_name;
 else
 $font_name = $font_name.".font.js";
 $path = $_GET["path"];
 
	$import_style = "
	<script type='text/javascript' src='{$path}/jquery.js'></script>
	<script type='text/javascript' src='{$path}/cufon-yui.js'></script>
	<script type='text/javascript' src='{$path}/cufon-fonts/$font_name'></script>
	";
    $code = "<script type='text/javascript'>
		        Cufon.replace('#inject-font p');
		     </script> ";;
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Google Font Preview</title>
<?php echo $import_style; ?>
<?php echo $code;?>

</head>

<body>




<div id="inject-font">
<p> <strong>This is preview text </strong>Grumpy wizards make toxic brew for the evil Queen and Jack. One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. </p><p> He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections. </p>
</div>

</body>
</html>