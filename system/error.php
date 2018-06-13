<?php
if (!defined("NO_SESSION"))
	define("NO_SESSION", 1);
require_once __DIR__ . '/bootstrap.php';

if (isset($GLOBAL["PAGE"])) {
	ob_end_clean();
}

if (!filter_input(INPUT_GET, 'error_code', FILTER_VALIDATE_INT) && !isset($HTTP_ERROR_CODE)) {
	redirect("");
}
$id = isset($HTTP_ERROR_CODE) ? $HTTP_ERROR_CODE :
	filter_input(INPUT_GET, 'error_code', FILTER_SANITIZE_NUMBER_INT);
$validCodes = [400, 401, 403, 404, 409, 429, 500, 501, 502, 503];

if (!in_array($id, $validCodes)) {
	$id = 400;
	$description = "Unknown error code " . $id;
} else {
	switch ($id) {
		case 400:
			$description = 'Bad Request';
			break;
		case 401:
			$description = 'Unauthorized';
			break;
		case 403:
			$description = 'Forbidden';
			break;
		case 404:
			$description = 'Not Found';
			break;
		case 409:
			$description = 'Conflict';
			break;
		case 429:
			$description = 'Too many requests';
			break;
		case 500:
			$description = 'Internal Server Error';
			break;
		case 501:
			$description = 'Bad Gateway';
			break;
		case 502:
			$description = 'Service Unavailable';
			break;
		case 503:
			$description = 'Gateway Time-out';
			break;
		default:
			$description = "Unknown error code " . $id;
			break;
	}
}
$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
header($protocol . ' ' . $id . ' ' . $description);
if (isset($GLOBALS["PAGE"]))
	ob_end_clean();
include_template("default");
//$PAGE["title"] = $id . ' ' . $description . " - " . $PAGE["title"];
if(isset($ERROR)) {
	$txt = "[" . date(DATE_RFC2822) . "] " . $_SERVER['REQUEST_URI'] . "\n" . jTraceEx($ex);
	file_put_contents(__DIR__ . '/../log/error.log', $txt.PHP_EOL, FILE_APPEND | LOCK_EX);
}
?>
<?PHP if (startsWith((string)$id, "5")) : ?>

	<div class="alert alert-danger" role="alert">
		<h1><?= $id . ' ' . $description ?></h1>
		<?PHP if (isset($ERROR)) : ?>
			<h2><samp><?= $ERROR->getMessage(); ?></samp></h2>
		<?PHP endif; ?>
		<p>Er is iets misgegaan met uw pagina weergave.</p>
		<p>Onze beheerders zijn hiervan op hoogste gesteld.</p>
	</div>
	<?PHP else : ?>
		<div class="alert alert-warning" role="alert">
			<h1><?= $id . ' ' . $description ?></h1>
			<p>Er is iets misgegaan met uw pagina weergave.</p>
			<p>Onze beheerders zijn hiervan op hoogste gesteld.</p>
		</div>
	<?PHP endif; ?>
	<div class="page-header">
		<h1>Pagina informatie</h1>
	</div>
	<div class="well">
		<table class="table table-condensed">
			<?PHP foreach (["REQUEST_METHOD", "REQUEST_URI", "HTTP_REFERER", "REMOTE_ADDR"] as $err) { ?>
				<tr>
					<th>
						<?= $err ?>
					</th>
					<td>
						<?= filter_input(INPUT_SERVER, $err, FILTER_SANITIZE_SPECIAL_CHARS) ?>
					</td>
				</tr>
			<?PHP } ?>
		</table>
	</div>
	<?PHP if (in_array(get_current_ip_address(), ["127.0.0.1", "::1"])) : ?>
		<?PHP if (isset($ERROR)) : ?>
			<div class="page-header">
				<h1>Stack trace</h1>
			</div>
			<pre><?= htmlentities(str_replace(" at error_handler(bootstrap.php:79)\n", "", jTraceEx($ex))) ?></pre>
		<?PHP endif; ?>
		<div class="page-header">
			<h1>$_GET:</h1>
		</div>
		<?PHP if (!empty($_GET)) : ?>
			<pre class="pre-scrollable"><?= htmlentities(var_dump_str($_GET)) ?></pre>
		<?PHP else: ?>
			<p>$_GET is empty</p>
		<?PHP endif; ?>
		<div class="page-header">
			<h1>$_POST:</h1>
		</div>
		<?PHP if (!empty($_POST)) : ?>
			<pre class="pre-scrollable"><?= htmlentities(var_dump_str($_POST)) ?></pre>
		<?PHP else: ?>
			<p>$_POST is empty</p>
		<?PHP endif; ?>
		<div class="page-header">
			<h1>$_FILES:</h1>
		</div>
		<?PHP if (!empty($_FILES)) : ?>
			<pre class="pre-scrollable"><?= htmlentities(var_dump_str($_FILES)) ?></pre>
		<?PHP else: ?>
			<p>$_FILES is empty</p>
		<?PHP endif; ?>
	<?PHP endif; ?>

	<?PHP ob_flush() ?>
<?PHP exit(); ?>
