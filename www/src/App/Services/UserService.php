<?php
    namespace App\Services;

    use App\Models\User;

    class UserService
    {
        public function get($id = null) 
        {
            if ($id)
                return User::select($id);
            else
                return User::selectAll();
        }

        public function post() 
        {
            $received = json_decode(file_get_contents('php://input'), true);
            $data = ($received==NULL) ? $_POST : $received;
            return User::insert($data);
        }

        public function put() 
        {
            $received = json_decode(file_get_contents('php://input'), true);
            $data = ($received==NULL) ? $_POST : $received;
            return User::update($data);   
        }

        public function delete($id = null) 
        {
            if ($id)
                return User::delete($id);
            else 
                throw new \Exception("usuário não informado");
            
        }
    }