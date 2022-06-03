<?php

class Movimiento
{
    public $monto;
    public $tipo;
    public function traeMovimientos()
    {
        try
        {
            $list = array();
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $sql = "SELECT * FROM movimientos_prueba WHERE estado = 1";
            $consulta = $objetoAccesoDato->RetornarConsulta($sql);
            $consulta->execute();

            if($consulta->rowCount() > 0){
                while($row = $consulta->fetch())
                {
                    $list[] = array(
                        "movimiento_id" => $row['movimiento_id'],
                        "monto" => $row['monto'],
                        "tipo" => $row['tipo'],
                        "fecha" => $row['fecha']
                    );
                }

                return json_encode($list);
            }
        } catch(PDOException $e){
            echo "Error : " . $e->getMessage() . "<br>";
        }
    }

    public function insertaMovimiento($monto, $tipo)
    {
        try
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $sql = "INSERT INTO movimientos_prueba (`monto`, `tipo`) VALUES ('$monto', '$tipo')";
            $consulta = $objetoAccesoDato->RetornarConsulta($sql);
            $consulta->execute();
        } 
        catch(PDOException $e)
        {
            echo "Error : " . $e->getMessage() . "<br>";
        }
    }
}