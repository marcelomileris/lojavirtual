<?php
    namespace App\Models;

    class User
    {
        private static $table = 'users';

        public static function select(int $id) {
            $conn = new \mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            $sql = "SELECT * FROM ".self::$table." WHERE id = $id";
            $res = $conn->query($sql);
             if ($res->num_rows > 0) {
                return $res->fetch_all(MYSQLI_ASSOC);
            } else {
                throw new \Exception("nenhum usuário encontrado!");
            }
        }

        public static function selectAll() {
            $conn = new \mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            $sql = 'SELECT * FROM '.self::$table;
            $res = $conn->query($sql);
             if ($res->num_rows > 0) {
                return $res->fetch_all(MYSQLI_ASSOC);
            } else {
                throw new \Exception("nenhum usuário encontrado!");
            }
        }

        public static function insert($data)
        {
            $conn = new \mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            $name = $data["name"];
            $email = $data["email"];
            $birth = $data["birth"];
            $phone = $data["phone"];
            $document = $data["document"];
            $zip_code = $data["zip_code"];
            $number = $data["number"];
            $address_data = self::getAddress($zip_code);
            $address = $address_data["logradouro"];
            $district = $address_data["bairro"];
            $city = $address_data["localidade"];
            $estate = $address_data["uf"];    

            if (count($address_data) == 0):
                throw new \Exception("Cep não encontrado!");
                exit;
            endif;

            $sql = "INSERT INTO ".self::$table." (name, email, birth, phone, document, zip_code, address, number, district, city, estate) values (?,?,?,?,?,?,?,?,?,?,?)";
            $res = $conn->prepare($sql);
            $res->bind_param('sssssssssss', $name, $email, $birth, $phone, $document, $zip_code, $address, $number, $district, $city, $estate);
            $res->execute();
            if ($res) {
                $return = array(
                        "id" => $conn->insert_id,
                        "name"=>$name,
                        "email"=>$email,
                        "birth"=>$birth,
                        "phone"=>$phone,
                        "document"=>$document,
                        "zip_code"=>$zip_code,
                        "address"=>$address,
                        "number"=>$number,
                        "district"=>$district,
                        "city"=>$city,
                        "estate"=>$estate);
                return $return;
            } else {
                throw new \Exception("Falha ao inserir usuário(a)!");
            }
        }

        public static function update($data)
        {
            $conn = new \mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            $id = $data["id"]??NULL;
            if ($id === NULL)
                throw new \Exception("id do usuário não informado");

            $name = $data["name"];
            $email = $data["email"];
            $birth = $data["birth"];
            $phone = $data["phone"];
            $document = $data["document"];
            $zip_code = $data["zip_code"];
            $number = $data["number"];
            $address_data = self::getAddress($zip_code);
            $address = $address_data["logradouro"];
            $district = $address_data["bairro"];
            $city = $address_data["localidade"];
            $estate = $address_data["uf"];    

            if (count($address_data) == 0)
                throw new \Exception("Cep não encontrado!");

            $sql = "UPDATE ".self::$table." SET name=?, email=?, birth=?, phone=?, document=?, zip_code=?, address=?, number=?, district=?, city=?, estate=? WHERE id = $id";
            $res = $conn->prepare($sql);
            $res->bind_param('sssssssssss', $name, $email, $birth, $phone, $document, $zip_code, $address, $number, $district, $city, $estate);
            $res->execute();
            if ($res) {
                $return = array(
                        "id" => $id,
                        "name"=>$name,
                        "email"=>$email,
                        "birth"=>$birth,
                        "phone"=>$phone,
                        "document"=>$document,
                        "zip_code"=>$zip_code,
                        "address"=>$address,
                        "number"=>$number,
                        "district"=>$district,
                        "city"=>$city,
                        "estate"=>$estate);
                return $return;
            } else {
                throw new \Exception("Falha ao atualizar o usuário!");
            }
        }

        public static function delete($id) {
            $conn = new \mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
            $sql = "SELECT * FROM ".self::$table." WHERE id = $id";
            $res = $conn->query($sql);
            $array = $res->fetch_all(MYSQLI_ASSOC);
            $sql = "DELETE FROM ".self::$table." WHERE id = $id";
            $del = $conn->query($sql);
             if ($res->num_rows > 0) {
                return $array;
            } else {
                throw new \Exception("nenhum usuário encontrado!");
            }
        }


        private static function getAddress(string $zip_code)  {
            $url = "https://viacep.com.br/ws/$zip_code/json/";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $res = curl_exec($curl);
            $httpcode = curl_getinfo($curl);
            curl_close($curl);
            return ($httpcode["http_code"] == "400") ? array() : json_decode($res, true);
        }
    }