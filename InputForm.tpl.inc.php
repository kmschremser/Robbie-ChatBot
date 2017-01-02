<html>
<body>

	<h1>DEBUG</h1>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	<textarea name="userMessage" cols="50" rows="6"><?php echo $_POST['userMessage']; ?></textarea>
	<input type="hidden" name="debug" value="true" />
	<input type="submit" name="submit" value="Submit">
	</form>

</body>
</html>