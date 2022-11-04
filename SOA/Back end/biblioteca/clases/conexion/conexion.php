<?php
    class conexion {
        private $server;
        private $user;
        private $password;
        private $database;
        private $port;
        private $conexion;
    
        public function __construct(){
            $listados = $this->datosConexion();
            foreach($listados as $key => $value){
                $this->server = $value['server'];
                $this->user = $value['user'];
                $this->password = $value['password'];
                $this->database = $value['database'];
                $this->port = $value['port'];     
            }
            $this->conexion = new mysqli($this->server,$this->user,$this->password,$this->database,$this->port);
            if($this->conexion->connect_errno){
                echo"problemas en la conexion";
                die();
            }
            
        }

        //Busca la ruta y trae la informacion del config para la conexion
        private function datosConexion(){
            $direccion = dirname(__FILE__);
            $jsondata = file_get_contents($direccion . "/" . "config");
            return json_decode($jsondata,true);
        }

        private function convertirUTF8($array){
            array_walk_recursive($array,function(&$item,$key){
                if(!mb_detect_encoding($item,'utf-8',true)){
                    $item = utf8_encode($item);
                }
            });
            return $array;
        }
        
        //Recibe una sentencia select retornando la informacion en un array
        public function obtenerDatos($sqltext){
            $results = $this->conexion->query($sqltext);
            $resultArray = array();
            foreach ($results as $key){
                $resulArray[] = $key;
            }
            return $this->convertirUTF8($resulArray);
        }

        //Recibe una sentencia sql diferente al select y al insert de datos 
        public function nonQuery($sqltext){
            $results = $this->conexion->query($sqltext);
            return $this->conexion->affected_rows;
        }

        //Recibe una sentencia sql diferente al select y al insert de datos 
        public function insertQuery($sqltext){
            $results = $this->conexion->query($sqltext);
            $filas = $this->conexion->affected_rows;
            if($filas >1){
                return $this->conexion->insert_id;
            }
            else{
            return 0;
            }
        }




    }
?>