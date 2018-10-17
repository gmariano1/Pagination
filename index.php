<!DOCTYPE html>
<html>
<head>
	<title>Paginação</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>
<body>

<?php

	$link = mysqli_connect("localhost", "root", "", "page");
	//numero da página atual
	if(isset($_GET['pageno']))
		$pageno = $_GET['pageno'];
	else
		$pageno = 1;

	$no_of_records_per_page = 10; //numero de registros por página
	$offset = ($pageno-1) * $no_of_records_per_page; //controle do numero de registros

	$sql_total_paginas = "SELECT count(emp_id) FROM employee";
	$result = mysqli_query($link, $sql_total_paginas);
	$total_rows = $result->fetch_array(MYSQLI_NUM)[0];
	$total_paginas = ceil($total_rows / $no_of_records_per_page);

	$sql = "SELECT * FROM employee LIMIT $offset, $no_of_records_per_page";
	$page_data = mysqli_query($link, $sql);
	$cont = mysqli_num_rows($page_data);
	echo '<table class="table table-bordered">
	                <thead>
	                    <tr class="table-primary">
	                        <th scope="col">ID</th>
	                        <th scope="col">Nome</th>
	                        <th scope="col">Salário</th>
	                    </tr>
	                </thead>
	                <tbody>';
	while ($row = mysqli_fetch_array($page_data, MYSQLI_NUM)){
		echo '                  <tr>
									<th scope="row">'.$row[0].'</th>
		                            <td>'.$row[1].'</td>
		                            <td>'.$row[2].'</td>
		                        </tr>';
	}
	echo "</tbody>
	</table>";
	mysqli_close($link);

?>
	
		<nav>
			  <ul class="pagination">
			  	<li class="page-item <?php if($pageno <= 1) echo 'disabled'; ?>"><a class="page-link" href="?pageno=1">Primeira</a></li>
			    <li class="page-item <?php if($pageno <= 1) echo 'disabled'; ?>"><a class="page-link" href="<?php echo '?pageno='.($pageno-1) ?>">Anterior</a></li>
			    <li class="page-item <?php if($pageno >= $total_paginas) echo 'disabled'; ?>"><a class="page-link" href="<?php echo '?pageno='.($pageno+1) ?>">Próxima</a></li>
			    <li class="page-item <?php if($pageno >= $total_paginas) echo 'disabled'; ?>"><a class="page-link" href="?pageno=<?php echo $total_paginas; ?>">Última</a></li>
			  </ul>
		</nav>
	</body>
</html>