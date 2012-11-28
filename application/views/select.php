<?php $arrayUsers=$params['arrayUsers']?>

<a href="?action=insert">Agregar</a>
<table border =1>
	<tr>
		<th>Id</th><th>Name</th><th>E-mail</th><th>Password</th><th>Description</th><th>Pet</th>
		<th>City</th><th>Code</th><th>Language</th><th>Photo</th><th>Action</th>
	</tr>
	<?php foreach($arrayUsers as $key => $users):?>
		<tr>
		<?php
		$user=explode("|",$users);
		foreach($user as $value):
		?>
			<td>
			<?=nl2br(htmlspecialchars($value)); ?>
			</td>
		<?php endforeach;?>
		<td>
		<a href="?action=update&id=<?=$key?>">Editar</a>
		<a href="?action=delete&id=<?=$key?>">Borrar</a>
		</td>
		</tr>
	<?php endforeach;?>
</table>
