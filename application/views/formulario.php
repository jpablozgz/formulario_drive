<?php $arrayUser=$params['arrayUser']?>

<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="1"/>
<ul>
<li>Name: <input type="text" name="name" value="<?=htmlspecialchars($arrayUser[1])?>"/></li>
<li>E-mail: <input type="text" name="email" value="<?=htmlspecialchars($arrayUser[2])?>"/></li>
<li>Password: <input type="password" name="pass"/></li>
<li>Description: <textarea rows="4" cols="50" name="desc"><?=htmlspecialchars($arrayUser[4])?></textarea></li>
<li>Pets: <select multiple name="pet[]">
		  <option value="dog"<?=(strpos($arrayUser[5],'dog')===FALSE) ? '' : ' selected'; ?>>Dog</option>
		  <option value="cat"<?=(strpos($arrayUser[5],'cat')===FALSE) ? '' : ' selected'; ?>>Cat</option>
		  <option value="tiger"<?=(strpos($arrayUser[5],'tiger')===FALSE) ? '' : ' selected'; ?>>Tiger</option>
	</select></li>
<li>City: <select name="city">
		  <option value="zgz"<?=($arrayUser[6]=='zgz') ? ' selected' : ''; ?>>Zaragoza</option>
		  <option value="bcn"<?=($arrayUser[6]=='bcn') ? ' selected' : ''; ?>>Barcelona</option>
		  <option value="mad"<?=($arrayUser[6]=='mad') ? ' selected' : ''; ?>>Madrid</option>
	</select></li>
<li>Coder: <input type="radio" name="coder" value="java"<?=($arrayUser[7]=='java') ? ' checked' : '';?>/>Java &nbsp;
  			<input type="radio" name="coder" value="php"<?=($arrayUser[7]=='php') ? ' checked' : '';?>/>PHP</li>
<li>Languages:<br>
  			<input type="checkbox" name="languages[]" value="en"<?=(strpos($arrayUser[8],'en')===FALSE) ? '' : ' checked'; ?>/>English<br>
  			<input type="checkbox" name="languages[]" value="es"<?=(strpos($arrayUser[8],'es')===FALSE) ? '' : ' checked'; ?>/>Spanish<br>
			<input type="checkbox" name="languages[]" value="cat"<?=(strpos($arrayUser[8],'cat')===FALSE) ? '' : ' checked'; ?>/>Catala<br>
			<input type="checkbox" name="languages[]" value="gal"<?=(strpos($arrayUser[8],'gal')===FALSE) ? '' : ' checked'; ?>/>Gallego<br>
			<input type="checkbox" name="languages[]" value="eus"<?=(strpos($arrayUser[8],'eus')===FALSE) ? '' : ' checked'; ?>/>Euskera</li>
<li>Photo: <input type="file" name="photo"/>
  		 <?php if($arrayUser[9]):?>
  		 	<img src="uploads/<?=$arrayUser[9];?>" style="width:150px;"/>
  		 <?php endif;?></li>
</ul>
  <input type="submit" value="submit"/>
  <input type="reset" value="reset"/>
</form>
