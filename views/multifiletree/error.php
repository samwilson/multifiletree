<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="UTF-8" />
		<title>Error <?php echo $exception->getCode() ?></title>
	</head>
	<body>
		<h1>Error <?php echo $exception->getCode() ?></h1>
		<p><?php echo $exception->getMessage() ?></p>
	</body>
</html>
