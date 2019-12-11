<?php

namespace Model;

abstract class Model{
    protected $conexion;
    public function __construct($cn){
        $this->conexion = $cn;
    }

    /** 
     * Método base de consulta
     * @param String $table Nombre de la tabla
     * @param Array $fields campos a consultar
     * @param Array $where Condiciones de busqueda
     * @param String $order Ordenamiento de resultados 
     * @param Array $join Enlace de tablas para relaciones
     * @param Array $group Condiciones de agrupamiento
     * @param Array $limit limite desde hasta
     * @return Array de resultados
     * @version 1.0
     * @author John Espitia
    */
    protected function select($table,$fields,$where=null,$order=null,$join=null,$group=null,$limit=null){
        $query = "SELECT ".implode(",",$fields)." FROM {$table} ";
        if(!empty($join)){
            foreach($join as $j){
                $query .= " {$j["tipo"]} JOIN {$j["tabla"]} AS {$j["alias"]} ON {$j['relaciones']} ";
            }
        }
        if(!empty($where)){
            $query .= " WHERE ";
            $first=true;
            foreach($where as $w){
                if($w["valores"] ===null){
                    $w["valores"]="NULL";
                }else{
                    switch(gettype($w["valores"])){
                        case "string":
                            $w["valores"]="'{$w["valores"]}'"; 
                        break;
                        case "boolean":
                            if($w["valores"] == 1){
                                $w["valores"]="true"; 
                            }else{
                                $w["valores"]="false"; 
                            }
                            
                        break;
                        default:
                            $w["valores"]="{$w["valores"]}"; 
                        break;
                    }
                }
                if($first){
                    $query .= " {$w["campo"]} {$w["operador"]} {$w["valores"]} ";
                    $first = !$first;
                }else{
                    $query .= " {$w["tipo"]} {$w["campo"]} {$w["operador"]} {$w["valores"]} ";
                }
            }
        }
        if(!empty($group)){
            $query.=" GROUP BY {$group['group']} ";
            if($group['having']){
                $query.=" HAVING {$group['having']} ";
            }
        }
        if(!empty($order)){
            $query .= " ORDER BY {$order} ";
        }
        if(!empty($limit)){
            if(!empty($limit['from'])){
                $query .= " LIMIT {$limit['from']} OFFSET {$limit['qty']} ";
            }else{
                $query .= " LIMIT {$limit['qty']} ";
            }
            
        }
        //echo $query;
        try{
            $stmt = $this->conexion->query($query);
            if($stmt === false){
                return null;
            }else{
                $result = [];
                while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $result[]=$row;
                }
                return $result;
            }
           }catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    /** 
     * Método base de insert
     * @param String $table Nombre de la tabla
     * @param Array $row valores a insertar
     * @return boolean TRUE si es correcto o FALSE si no se puede insertar
     * @version 1.0
     * @author John Espitia
    */
    protected function insert($table,$row){
        $query = " INSERT INTO {$table}";
        $fields=[];
        $values=[];
        foreach($row as $field=>$value){
            $fields[]=$field;
            switch(gettype($value)){
                case "string":
                    $values[]="'{$value}'"; 
                break;
                case "boolean":
                    if($value == 1){
                        $values[]="true"; 
                    }else{
                        $values[]="false"; 
                    }        
                break;
                default:
                    $values[]="{$value}"; 
                break;
            }
        }
        
        $query .= "(".implode(",",$fields).") VALUES (".implode(",",$values)."); ";
        return $this->conexion->exec($query);
    }

    /** 
     * Método base de actualización
     * @param String $table Nombre de la tabla
     * @param Array $values campos a actualizar
     * @param Array $where Condiciones de actualización
     * @return boolean TRUE si se pudo actualizar o FALSE si no se puede actualizar
     * @version 1.0
     * @author John Espitia
    */
    protected function update($table,$values,$where=null){
        
        $query = " UPDATE {$table} SET ";
        $update = [];
        
        foreach($values as $f=> $value){
            switch(gettype($value)){
                case "string":
                    $update[]="{$f} = '{$value}'"; 
                break;
                case "boolean":
                    if($value == 1){
                        $update[]="{$f} = true "; 
                    }else{
                        $update[]="{$f} = false "; 
                    }        
                break;
                default:
                   $update[]="{$f} = {$value}"; 
                break;
            }
        }
        $query.= implode(",", $update);
        if(!empty($where)){
            $query .= " WHERE ";
            $first=true;
            foreach($where as $w){
                switch(gettype($w["valores"])){
                    case "string":
                        $w["valores"]="'{$w["valores"]}'"; 
                    break;
                    default:
                        $w["valores"]="{$w["valores"]}"; 
                    break;
                }
                if($first){
                    $query .= " {$w["campo"]} {$w["operador"]} {$w["valores"]} ";
                    $first = !$first;
                }else{
                    $query .= " {$w["tipo"]} {$w["campo"]} {$w["operador"]} {$w["valores"]} ";
                }
                
            }
        }
        return $this->conexion->exec($query);
    }

    /** 
     * Método base de consulta
     * @param String $table Nombre de la tabla
     * @param Array $where Condiciones de busqueda
     * @return Array TRUE si elimina y FALSE si no puede eliminar
     * @version 1.0
     * @author John Espitia
    */
    protected function delete($table,$where=null){
        $query = "DELETE FROM {$table} ";
        if(!empty($where)){
            $query .= " WHERE ";
            $first=true;
            foreach($where as $w){
                switch(gettype($w["valores"])){
                    case "string":
                        $w["valores"]="'{$w["valores"]}'"; 
                    break;
                    default:
                        $w["valores"]="{$w["valores"]}"; 
                    break;
                }
                if($first){
                    $query .= " {$w["campo"]} {$w["operador"]} {$w["valores"]} ";
                    $first = !$first;
                }else{
                    $query .= " {$w["tipo"]} {$w["campo"]} {$w["operador"]} {$w["valores"]} ";
                }
                
            }
        }
        
        return $this->conexion->exec($query);
    }
}