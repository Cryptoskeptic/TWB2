<?php
include "linkers/common-head.html";
include "linkers/admin-panel-css.html";
include "linkers/header-css.html";
?>

<body>
	<?php
	session_start();
	include "pages/header.php";
	include_once "connect.php";
	include "pages/admin-panel.php";	
	?>
</body>

<?php
include "linkers/fallback-resources.html";
?>

</html>