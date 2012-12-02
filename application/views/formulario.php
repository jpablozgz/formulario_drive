<?php $arrayUser=$params['arrayUser']?>

<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="1"/>
<ul>
<li>Name: <input type="text" name="name" value="<?=htmlspecialchars($arrayUser['name'])?>"/></li>
<li>E-mail: <input type="text" name="email" value="<?=htmlspecialchars($arrayUser['email'])?>"/></li>
<li>Password: <input type="password" name="password"/></li>
<li>Description: <textarea rows="4" cols="50" name="description"><?=htmlspecialchars($arrayUser['description'])?></textarea></li>
<li>Pets: <select multiple name="pets[]">
		  <option value="dog"<?=(strpos($arrayUser['pets'],'dog')===FALSE) ? '' : ' selected'; ?>>Dog</option>
		  <option value="cat"<?=(strpos($arrayUser['pets'],'cat')===FALSE) ? '' : ' selected'; ?>>Cat</option>
		  <option value="tiger"<?=(strpos($arrayUser['pets'],'tiger')===FALSE) ? '' : ' selected'; ?>>Tiger</option>
	</select></li>
<li>City: <select name="city">
		  <option value="zgz"<?=($arrayUser['city']=='zgz') ? ' selected' : ''; ?>>Zaragoza</option>
		  <option value="bcn"<?=($arrayUser['city']=='bcn') ? ' selected' : ''; ?>>Barcelona</option>
		  <option value="mad"<?=($arrayUser['city']=='mad') ? ' selected' : ''; ?>>Madrid</option>
	</select></li>
<li>Coder: <input type="radio" name="coder" value="java"<?=($arrayUser['coder']=='java') ? ' checked' : '';?>/>Java &nbsp;
  			<input type="radio" name="coder" value="php"<?=($arrayUser['coder']=='php') ? ' checked' : '';?>/>PHP</li>
<li>Languages:<br>
  			<input type="checkbox" name="languages[]" value="en"<?=(strpos($arrayUser['languages'],'en')===FALSE) ? '' : ' checked'; ?>/>English<br>
  			<input type="checkbox" name="languages[]" value="es"<?=(strpos($arrayUser['languages'],'es')===FALSE) ? '' : ' checked'; ?>/>Spanish<br>
			<input type="checkbox" name="languages[]" value="cat"<?=(strpos($arrayUser['languages'],'cat')===FALSE) ? '' : ' checked'; ?>/>Catala<br>
			<input type="checkbox" name="languages[]" value="gal"<?=(strpos($arrayUser['languages'],'gal')===FALSE) ? '' : ' checked'; ?>/>Gallego<br>
			<input type="checkbox" name="languages[]" value="eus"<?=(strpos($arrayUser['languages'],'eus')===FALSE) ? '' : ' checked'; ?>/>Euskera</li>
<li>Photo: <input type="file" name="photo"/>
  		 <?php if(array_key_exists('photo',$arrayUser) && $arrayUser['photo']):?>
  		 	<img src="uploads/<?=$arrayUser['photo'];?>" style="width:150px;"/>
  		 <?php endif;?></li>
</ul>
  <input type="submit" value="submit"/>
  <input type="reset" value="reset"/>
</form>
