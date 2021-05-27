<form action="ejercicio7.php" method="POST">        
     <input type="hidden" name="email" value="<?=$data['email']?>">
     <input type="hidden" name="password" value="<?=$data['password']?>">  
    
    <label for="tipolistado">
        Seleccione el tipo de listado:
    </label>
    <select name="tipolistado" id="tipolistado">
        <option value="ALL">Todos los usuarios</option>
        <option value="NOT_VALIDATED" <?=$data['tipolistado']=='NOT_VALIDATED'?'selected':''?>>Usuarios no validados</option>
        <option value="VALIDATED" <?=$data['tipolistado']=='VALIDATED'?'selected':''?>>Usuarios validados</option>
    </select>    
    <input type="submit" value="Enviar!">
</form>    

