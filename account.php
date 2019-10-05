<head>
	<link href="https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/litera/bootstrap.min.css" rel="stylesheet" integrity="sha384-D/7uAka7uwterkSxa2LwZR7RJqH2X6jfmhkJ0vFPGUtPyBMF2WMq9S+f9Ik5jJu1" crossorigin="anonymous">
	<style>
		body {
 			position: fixed;
            top: 50%;
            left: 50%;
            margin-top: -250px;
            margin-left: -145px;
		}
	</style>
</head>
<body>
<h1>Hello <?php echo $_GET['email'] ?></h1>
<form action="logout.php" method="get">
      <input type="hidden" name="email" value=<?php echo $_GET['email'] ?>>
 	  <input type="submit" class="btn btn-primary" value="Log out">
	</form>
</body>

<?php ?>