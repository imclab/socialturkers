<?php
/** Loads the WordPress Environment and Template */
require('../wp-blog-header.php');
require_once('config.php');
session_start();

// reset lines
unset($_SESSION['LINES']);

// get question
$q_table = "turkers_012613_questions"; 
$qry = "SELECT * FROM ".$q_table." WHERE votes < 4 ORDER BY votes DESC, timestamp DESC LIMIT 5";
$res = mysql_query($qry);

if ($res && mysql_num_rows($res) > 0) {
	$_SESSION['LINES'] = array();
		
	for($i = 0; $i < mysql_num_rows($res); $i++){
		array_push($_SESSION['LINES'], mysql_result($res,$i,"suggested_line"));
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<script src=<?php echo get_option('home');?>/analyticstracking.js type="text/javascript"></script>
<style type="text/css" media="screen">



</style>

<?php wp_head(); ?>
</head>
<body>
	<div id="page">
	
	
	<div id="header">
		<div id="headerimg">
			<img class="prof" src=<?php bloginfo('stylesheet_directory'); ?>/images/prof-01.png />
			<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
			
			<div class="description" style="padding-top:80px">
			<?php
	            if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
	                echo '<ul class="err">';
	                foreach($_SESSION['ERRMSG_ARR'] as $msg) {
	                    echo '<li>',$msg,'</li>'; 
	                }
	                echo '</ul>';
	                unset($_SESSION['ERRMSG_ARR']);
	            }
	        ?>
	        
			Please watch the video stream and decide what the woman in the interaction should do. She will receive a text message with instructions based on your response. Upon submitting your response, you will receive a code to enter into Amazon Mechanical Turk to be paid for your work. **You are welcome to submit but you can get paid through Amazon Mechanical Turk.
			</div>
		</div>
	</div>


	<div id="primary" class="site-content">
		<div id="content" role="main">
									
			<iframe width="625" height="490" src="http://www.ustream.tv/embed/12970116?v=3&amp;wmode=direct" scrolling="no" frameborder="0" style="border: 0px none transparent;">    </iframe>
<br /><br><br>
		
			<form action="submit.php" method="post">
				<table border="0" width="625px" align="center" cellpadding="0" cellspacing="0" padding-bottom="40px">
					
					<tr>
					<td>Describe how the woman appears to be feeling at this moment in at least one complete sentence. (If you want your response to be approved, please be specific. If you can't tell, give your best guess or interpretation.)</td></tr>
					<tr><td><textarea style="width:613px; height: 200px; margin:0;" type="text" name="she_description"><?php echo $_SESSION['TEMP_SHE_DESCRIPTION']; ?></textarea></td>
					</tr>   
					
					<tr><td></td></tr>
					
					<tr>
					<td>Describe how the man appears to be feeling at this moment in at least one complete sentence. (If you want your response to be approved, please be specific. If you can't tell, give your best guess or interpretation.)</td></tr>
					<tr><td><textarea style="width:613px; height: 200px; margin:0;" type="text" name="he_description"><?php echo $_SESSION['TEMP_HE_DESCRIPTION']; ?></textarea></td>
					</tr>   
					
					<tr><td></td></tr>
					
					<tr><td>How would you rate this interaction?</td></tr>
					<tr><td><select name="rating">
						<option value=""></option>
						<option value="1">1 - terrible</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5 - fantastic</option>
						</select></td>
					</tr>
					
					<tr><td></td></tr>
					
					<?php if(isset ($_SESSION['LINES'])) {
						
						echo '<tr><td>Vote for one of the following questions for the woman to ask:</td></tr>';
						
						echo '<tr><td>';
						
						for($i = 0; $i < count($_SESSION['LINES']); $i++){
							echo '<input type="radio" name="chosen_line" value="'.$_SESSION['LINES'][$i].'">'.$_SESSION['LINES'][$i].'<br><br>';
						}
						echo '</td></tr>';
					
						echo '<tr><td></td></tr>';
						
					} ?>
							
					<tr>
					<td>Please suggest another question for the woman to ask.</td></tr>
					<tr><td><textarea style="width:613px; height: 50px; margin:0;" type="text" name="suggested_line"><?php echo $_SESSION['TEMP_LINE']; ?></textarea></td>
					</tr>
					
								
					<tr>
					<!--<?php if (strpos($_SERVER['HTTP_REFERER'],'mturk') !== false) echo' <td><input type="submit"></td>' ?>-->
					<td><input type="submit"></td>
					</tr>
				</table>
			</form>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
