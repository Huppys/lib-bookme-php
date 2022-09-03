<?php

/*----------------------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 * Licensed under the MIT License. See LICENSE in the project root for license information.
 *---------------------------------------------------------------------------------------*/

function sayHello($name) {
	echo "Hello $name!";
}

?>

<html lang="en">
	<head>
		<title>Visual Studio Code Remote :: PHP</title>
	</head>
	<body>
		<?php

		sayHello('remote world');

		phpinfo();

		?>
	</body>
</html>