<?php
session_start();
session_unset();
session_destroy();

// trigger logout notification for other open tabs/windows from the same origin
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Logging out...</title>
	<script>
		try {
			localStorage.setItem('license_app_logout', Date.now());
		} catch (error) {
			console.warn('Logout sync failed', error);
		}
		window.location.href = 'index.php?action=show-login';
	</script>
</head>
<body>
	<p>Logging out...</p>
</body>
</html>