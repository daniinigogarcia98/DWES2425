<?php
function limitesArray($arra)
{
    /*sort($arra);
    $numPeque = $arra[0];
    $numGrande = $arra[count($arra)-1];*/
    $numPeque=100;
    $numGrande=0;
    foreach ($arra as $valor){
        if($valor<$numPeque){
            $numPeque=$valor;
        }
        if($valor>$numGrande){
            $numGrande=$valor;
        }
    }
    
        
    echo "<br>El valor más pequeño es " . $numPeque . " y el más grande es " . $numGrande;
}

//Nº elementos
$numElementos = 12;
//Rellenamos el array
$Valores = array();
for ($i = 0; $i < $numElementos; $i ++) {
    $Valores[$i] = rand(0, 100);
}
echo "<br/>Array: ";
foreach ($Valores as $valor){
    echo "$valor ";
}
//Llamamos a la función
echo "<br><br>Para el array Valores";
limitesArray($Valores)


?>
