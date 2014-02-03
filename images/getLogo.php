<?php
/* deprecated now, but kept for compatibility */
if (isset($_GET['skin'])) {
	header('Location: logos/'.$_GET['skin'], false, 307);
}
?>