<?php $arrayUsers=$params['arrayUsers']?>

<a href="?action=insert">Agregar</a>
<table border =1>
	<tr>
		<th>Id</th><th>Name</th><th>E-mail</th><th>Password</th><th>Description</th><th>Pet</th>
		<th>City</th><th>Code</th><th>Language</th><th>Photo</th><th>Action</th>
	</tr>
	<?php foreach($arrayUsers as $key => $user):?>
		<tr>
		<?php
		foreach($user as $value):
		?>
			<td>
			<?=str_replace(array("\n","\r"),"", nl2br(htmlspecialchars($value))); ?>
			</td>
		<?php endforeach;?>
		<td>
		<a href="?action=update&id=<?=$key?>">Editar</a>
		<a href="?action=delete&id=<?=$key?>">Borrar</a>
		</td>
		</tr>
	<?php endforeach;?>
</table>
