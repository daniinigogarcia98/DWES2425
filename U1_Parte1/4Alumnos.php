<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="#" method="post">
        <div>
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre"/>
        </div>
        <div>
            <label for="curso">Curso</label><br />
            <select name="curso" id="curso">
                <option value="Primero DAW">1ºDAW</option>
                <option selected="selected">2ºDAW</option>
                <option>1ºDAW</option>
                <option>2ºDAW</option>
            </select>
        </div>
        <div>
            <label for="asig">Asignaturas</label><br />
            <select name="asig[]" id="asig" multiple="multiple">
                <option>DEWS</option>
                <option>DIC</option>
                <option>PROG</option>
                <option>BD</option>
            </select>
        </div>
        <div>
            <label>Sexo</label><br />
            <label for="hombre">Hombre</label>
            <input type="radio" id="hombre" name="sexo" value="hombre" checked="checked"/>
            <label for="mujer">Mujer</label>
            <input type="radio" id="mujer" name="sexo" value="mujer"/>
        </div>
        <div>
            <label>Otros</label><br />
            <label for="becaM">Beca Mec</label>
            <input type="checkbox" id="becaM" name="otros[]" value="Beca Mec"/>
            <label for="transporte">Transporte</label>
            <input type="checkbox" id="transporte" name="otros[]" value="Transporte"/>
            <label for="delegado">Transporte</label>
            <input type="checkbox" id="delegado" name="otros[]" value="Delegado"/>
        </div>
        <input type="submit" name="enviar"value="Enviar"/>
        <input type="reset" value="Cancela"/>
    </form>
    <?php
    if(isset($_POST['enviar'])){
        echo "Nombre:".$_POST['nombre'];
        echo "<br/>Curso:".$_POST['curso'];
        echo "<br/>Asignaturas:";
        if(isset($_POST['asig'])){
            foreach($_POST['asig'] as $a){
                echo $a.' ';
            }
           
        }
        echo "<br/>Sexo:";
        if(isset($_POST['sexo'])){
            foreach($_POST['sexo'] as $s){
                echo $s.' ';
            }
           
        }
        echo "<br/>Otros:";
        if(isset($_POST['otros'])){
            foreach($_POST['otros'] as $o){
                echo $o.' ';
            }
           
        }
    }
    ?>
</body>

</html>