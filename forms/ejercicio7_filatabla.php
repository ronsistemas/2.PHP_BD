    <TR style="background-color:<?=$usuario['superuser']?'orange':'white'?>">
        <Td><?=$usuario['nombre']?></Td>
        <Td><?=$usuario['apellidos']?></Td>
        <Td><?=$usuario['email']?></Td>
        <Td><?=$usuario['dni']?></Td>
        <Td><?=$usuario['creacion']?></Td>
        <Td><?=$usuario['validacion']?></Td>
<?php if (!$usuario['superuser']) : ?>
            <form action="ejercicio5.php" method="post" style="display:inline;padding:0px;margin:0px">     
                <?php if (empty($usuario['validacion'])) {?>
                    <td><input type="submit" name="submit" value="Validar" style="display:inline"></td>
                    <input type="hidden" name="fecha" value="<?=date("d/m/Y")?>"> 
                <?php } else { ?>
                    <td><input type="submit" name="submit" value="Invalidar"></td>
                    <input type="hidden" name="fecha" value="INVALIDAR"> 
                <?php } ?>
                <input type="hidden" name="email" value="<?=$data['email']?>">
                <input type="hidden" name="password" value="<?=$data['password']?>">  
                <input type="hidden" name="irrd" value="<?=$usuario['irrd']?>">    
                <input type="hidden" name="emailemp" value="<?=$usuario['email']?>">                
            </form>                
        
       
            <form action="ejercicio6.php" method="post" style="display:inline;padding:0px;margin:0px">
                <TD> <input type="submit" name="submit" value="Borrar" style="display:inline"></td>                <input type="hidden" name="email" value="<?=$data['email']?>">
                <input type="hidden" name="password" value="<?=$data['password']?>">  
                <input type="hidden" name="emailemp" value="<?=$usuario['email']?>">                
            </form>                
    <?php else: ?>
            <TD></TD><TD></TD>
    <?php endif; ?>
    </TR>

