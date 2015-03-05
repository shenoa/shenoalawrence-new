<?php 

date_default_timezone_set("America/Los_Angeles");

$contact_email = 'jarneson@viewportwireless.com';
// $contact_email = 'shenoa@sonic.net';
// $cc            = 'shenoa@sonic.net';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	foreach($_POST as $key => $value) {
		$_POST[$key] = htmlspecialchars(stripslashes(trim($value)));
	}
	
	$name    = @$_POST['name'];
	$company = @$_POST['company'];
	$email   = @$_POST['email'];
	$phone   = @$_POST['phone'];
//	$subject = @$_POST['subject'];
	$message = @$_POST['message'];
	
	$errors = array();
	
	if ($name == '' || strlen($name) < 6) {
		$errors[] = 'Please enter your full name.';
	}
	
	if ($email == '' || !isValidEmail($email)) {
		$errors[] = 'Invalid email address entered.';
	}
	
	if ($phone != '' && !preg_match('/^\d{3}-?\d{3}-?\d{4}$/', $phone)) {
		$errors[] = 'Please enter your 10-digit phone number using the format 707-555-1212.';
	}
	
	if ($message == '' || strlen($message) < 10) {
		$errors[] = 'Please enter a message to send.';
	}
	
	if (sizeof($errors) > 0) {
		$errmsg = '<strong>There was a problem with your submission!</strong><br /><br />'
		         .'<ul style="color: #f00">';
		         
        foreach($errors as $error) {
        	$errmsg .= "<li>$error</li>";
        }
        
        $errmsg .= '</ul>';
		
	} else {
		// send message
		$body = "A message has been submitted from the contact form on viewportwireless.com.<br /><br />"
		       ."<b>Name:</b> $name<br />\n"
		       ."<b>Company:</b> $company<br />\n"
		       ."<b>Email:</b> $email<br />\n"
		       ."<b>Phone:</b> $phone<br />\n"
               ."\n<b>Message:</b><br />\n"
               .nl2br($message)
               ."<br /><br /><b>Time sent:</b> " . date('D, F j, Y, g:i a T') . "<br />\n"
               ."<b>IP Address:</b> " . $_SERVER['REMOTE_ADDR'] . "<br />\n"
               ."<b>Referrer: </b>" . $_SERVER['HTTP_REFERER'] . "<br />\n"
               ."<b>User Agent: </b>" . $_SERVER['HTTP_USER_AGENT'] . "<br />\n";
		       
		$cc = (isset($cc) && $cc != '') ? 'CC: ' . $cc . "\r\n": '';
		mail($contact_email, "Contact Form Submission", $body, "From: $contact_email\r\n{$cc}Content-type: text/html; charset=ISO-8859-1\r\nX-Priority: 1 (Highest)\r\nX-MSMail-Priority: High\r\nImportance: High", "-f{$contact_email}");
		
		header('Location: contact-done.php');
		exit;
	}
}

?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Contact Us - ViewPort Wireless</title>
	<meta name="description" content="Would it improve your productivity if you knew the exact location of valuable assets, or could monitor parameters such as movement, temperatures, elevations, run times or alarms?">
	<meta name="keywords" content="real-time, telemetry, tri-cities, washington">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link href='http://fonts.googleapis.com/css?family=Questrial' rel='stylesheet' type='text/css'> 
	<link rel="stylesheet" href="stylesheets/compiled/main.css">
	<link rel="stylesheet" href="css/nav2.css">
<!--[if gte IE 9]>
  <style type="text/css">
    .gradient {filter: none;}
  </style>
<![endif]-->
	<script src="js/libs/modernizr-2.0.6.min.js"></script>
	
</head>

<body>
<header class="container">
	<p>Serving the Tri-Cities</p>
	<ul>
		<li>Call 509-396-6822 or <a href="contact-us.php">Contact Us</a></li>
		<li><a href="#" target="_blank">Client Login</a></li>
	</ul>
	<a href="index.html" id="logo">
		<img src="images/logo_viewport_wireless.png" width="292" height="72" alt="ViewPort Wireless" />
	</a>
	<nav class="navmain">
		<ul>
			<li><a href="how-it-works.html">How it Works</a></li>
			<li><a href="functions.html">Functions</a></li>
			<li><a href="industry-applications.html">Industry Applications</a>
				<ul>
					<li><a href="water-utilities.html">Water Utilities</a></li>
					<li><a href="hospitals.html">Hospitals</a></li>
									</ul>
			</li>
			<li><a href="about-us.html">About Us</a></li>
		</ul>
	</nav>
</header>

<div id="pagetitle">
	<h1 class="container">Contact Us</h1>
</div>

<div id="main" role="main" class="container">
	<p>Want to know more about how ViewPort Wireless and the RECON solution can help make your organization more efficient and give you greater operational control? We'd love to hear from you.</p>
	
<div class="columns">

            <?php if (isset($errmsg)): ?>
            <br />
            <p>
            <?php echo $errmsg; ?>
            </p>
            <?php endif; ?>

<form id="contact" name="contact" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<fieldset>
		<label for="name">Full Name</label>
		<input type="text" name="name" class="form-text" value="<?php if (isset($name)) echo $name; ?>" />
	</fieldset>

	<fieldset>
		<label for="company">Company or Agency</label>
		<input type="text" name="company" class="form-text" value="<?php if (isset($company)) echo $company; ?>" />
	</fieldset>

	<fieldset>
		<label for="phone">Phone Number</label>
		<input type="text" name="phone" class="form-text" value="<?php if (isset($phone)) echo $phone; ?>" />
	</fieldset>
	
	<fieldset>
		<label for="email">Email Address</label>
		<input type="email" name="email" class="form-text" value="<?php if (isset($email)) echo $email; ?>" />
	</fieldset>

	<fieldset>
		<label for="message">Message</label>
		<textarea name="message"><?php if (isset($message)) echo $message; ?></textarea>
	</fieldset>

	<fieldset class="form-actions">
		<input type="submit" value="Submit" />
	</fieldset>
</form>			
				
<div class="column3">
	<img src="images/icon_phone.gif" alt="" width="49" height="57" class="iconsm" />
	<p class="iconsm"><strong>Phone</strong><br />509-396-6822</p>
	<img src="images/icon_horn.gif" alt="" width="49" height="37" class="iconsm" />
	<p class="iconsm"><strong>Email</strong><br /><script type="text/javascript">
//<![CDATA[
<!--
var x="function f(x){var i,o=\"\",ol=x.length,l=ol;while(x.charCodeAt(l/13)!" +
"=76){try{x+=x;l+=l;}catch(e){}}for(i=l-1;i>=0;i--){o+=x.charAt(i);}return o" +
".substr(0,ol);}f(\")19,\\\"t~veit(g{+*'m12%S[OULNKWGAP]Er__\\\\\\\\KC^J@720" +
"\\\\n\\\\{400\\\\y130\\\\FNUIk>?@vuz6depxv`xg{|b||o`~Ghjwflsa420\\\\G320\\\\"+
"710\\\\620\\\\020\\\\130\\\\230\\\\T)I520\\\\720\\\\300\\\\030\\\\O710\\\\Q" +
"NC400\\\\500\\\\r\\\\320\\\\710\\\\720\\\\320\\\\M620\\\\710\\\\500\\\\2+>3" +
"?\\\"(f};o nruter};))++y(^)i(tAedoCrahc.x(edoCrahCmorf.gnirtS=+o;721=%y;2=*" +
"y))y+19(>i(fi{)++i;l<i;0=i(rof;htgnel.x=l,\\\"\\\"=o,i rav{)y,x(f noitcnuf\""+
")"                                                                           ;
while(x=eval(x));
//-->
//]]>
</script>
</p>
	<img src="images/icon_email.gif" alt="" width="49" height="33" class="iconsm" />
	<p class="iconsm"><strong>Postal</strong><br />PO Box 981<br />Richland WA 99352</p>
</div>

</div>

</div> <!-- end of #main -->

<footer>
	<div class="container">
	<p class="alignleft">509-396-6822<br />
	PO Box 981<br />
	Richland WA 99352</p>
	<p class="alignright textright">© 2012, ViewPort Wireless<br />
	Design by <a href="http://www.ShenoaLawrence.com" target="_blank">Shenoa</a></p>
	</div>
</footer>

</div> <!-- end of #container  -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>
<script>
	var _gaq=[['_setAccount','UA-25770338-1'],['_trackPageview']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script>
	<script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script>
<![endif]-->
</body>
</html>
<?php 

function isValidEmail($email)
{
    return preg_match('/^(?:[\w\d]+\.?)+@(?:(?:[\w\d]\-?)+\.)+\w{2,4}$/i', $email);
}

?>