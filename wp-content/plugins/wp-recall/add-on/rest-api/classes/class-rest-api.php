<?php

class RCL_REST_API {
    
    public $tables;
    
    function __construct($tables){
        
        $this->tables = $tables;
        
    }
    
    function get($table, $args){

        $response = array();
        
        if($table == 'multiple'){

            foreach($_GET as $k => $query){
                
                if(!isset($query['table']) || !isset($this->tables[$query['table']])) continue;
                
                $response[$k] = $this->get_response($query['table'],$query['args']);
                
            }
            
        }else{

            $response = $this->get_response($table, $args);
        
        }

        return $response;
        
    }
    
    function setup_join($joinQuery){

        foreach($joinQuery as $k => $join){

            if(!isset($join['table']) || !isset($this->tables[$join['table']])){
                unset($joinQuery[$k]); continue;
            }

            $JoinClass = $this->tables[$join['table']];

            $Join = new $JoinClass();

            $joinQuery[$k]['table'] = $Join->query['table'];
            
            if(isset($join['join_query'])){
                $join['join_query'] = $this->setup_join($join['join_query']);
            }

        }
        
        return $joinQuery;
        
    }
    
    function get_response($table,$args){
        
        if(isset($args['join_query'])){
                
            $args['join_query'] = $this->setup_join($args['join_query']);

        }

        $QueryClass = $this->tables[$table];

        $Query = new $QueryClass();

        if(isset($args['number']) && ( $args['number'] < 0 || $args['number'] > 100 )){
            $args['number'] = 100;
        }
        
        $args = apply_filters('rcl_rest_request_args', $args, $table);
        
        $Query->set_query($args);
        
        return array(
            'result' => $args? $Query->get_data(): array(),
            'dataquery' => $Query
        );

    }
    
}

