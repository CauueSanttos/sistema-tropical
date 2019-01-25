<?php

$aConexao            = [];
$aConexao['host']    = 'localhost';
$aConexao['port']    = '5432';
$aConexao['db']      = 'banco_tropical';
$aConexao['user']    = 'postgres';
$aConexao['password']= 'postgres';

$oConexao = pg_connect("host={$aConexao['host']}  
                        port={$aConexao['port']}  
                        dbname={$aConexao['db']}  
                        user={$aConexao['user']} 
                        password={$aConexao['password']}");