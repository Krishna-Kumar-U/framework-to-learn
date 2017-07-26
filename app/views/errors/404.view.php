<?php

use App\Core\App;

	require(App::get('path.views').'/partials/head.php');
?>

    <h1>Error!</h1>
    <h2>Page Not Found</h2>

<?php 
	require(App::get('path.views').'/partials/footer.php'); 
?>