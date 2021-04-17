<?php


namespace App\Repositories;


interface BaseRepositoryInterface {

    public function all (  );

    public function add ( $id, $relation=[] );

    public function find ( $id, $relation=[] );

    public function update( $id, $relation=[] );

    public function delete ( $id, $relation=[] );

}
