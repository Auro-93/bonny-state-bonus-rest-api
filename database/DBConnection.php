<?php

class DBConnection {

   public static function make($config){
       try{
           return new PDO(
               $config['host'].';dbname='.$config['db_name'],
               $config['username'],
               $config['password'],
              
           );

       }catch(PDOException $e){
           http_response_code(500);
           $error = [
               "response" => "error",
               "status_code" => 500,
               "message" => $e->getMessage()
           ];
           print json_encode($error);
       }
   }

};