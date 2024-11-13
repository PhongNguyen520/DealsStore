<?php
require_once __DIR__ . "/Database.php";
class User
{
    public $user_id;
    public $username;
    public $password;
    public $full_name;
    public $birth_date;
    public $email;
    public $phone;
    public $address;
    public $role;
    public $created_at;

    static function login($username, $password)
    {
        $db = new Database();
        if (!$db->statusConnect) {
            echo "Connect lỗi";
            return false;
        }

        $sql = "SELECT * FROM users WHERE username= ? AND password = ?";

        $stmt = $db->connection->prepare($sql);
        $stmt->bind_param("ss", $username, $password);

        $stmt->execute();

        $result = $stmt->get_result();

        $user = $result->fetch_object("User");

        $stmt->close();
        $db->connection->close();

        if (!$user || is_null($user)) {
            return false;
        }
        return $user;
    }


    static function getAllUser()
    {
        $listUser = [];

        $db = new Database();

        if (!$db->statusConnect) {
            echo "Connect DB lỗi";
            return false;
        }

        $sql = "SELECT * FROM users ORDER BY full_name";

        $result = $db->connection->query($sql);
        if ($result->num_rows > 0) {
            while ($user = $result->fetch_object("User")) {
                array_push($listUser, $user);
            }
        }
        $db->connection->close();
        return $listUser;
    }


    static function addUser($username, $password, $full_name, $email, $phone, $address, $role)
    {
        $conn = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
        if ($conn->connect_error)
            die("Connect Fail" . $conn->connect_error);

        $sql = "INSERT INTO users(username, password, full_name, email, phone, address, role) 
            VALUES(?,?,?,?,?,?,?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $username, $password, $full_name, $email, $phone, $address, $role);
        $re = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $re;
    }


    static function getUserById($user_id)
    {
        $db = new Database();
        if (!$db->statusConnect) {
            echo "Kết nối lỗi";
            return false;
        }

        $sql = "SELECT * FROM users WHERE user_id = ?";

        $stmt = $db->connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_object("User");
        $stmt->close();
        $db->connection->close();

        if (!$user || is_null($user)) {
            return false;
        }
        return $user;
    }


    static function updateUser($user_id, $password, $full_name, $role, $email, $phone, $address)
    {
        $db = new Database();
        if (!$db->statusConnect) {
            echo "Kết nối lỗi";
            return false;
        }

        $password = md5($password);
        $sql = "UPDATE users SET password = ?, full_name = ?, role = ?, email = ?, phone = ?, address = ? WHERE user_id = ?";

        $stmt = $db->connection->prepare($sql);

        $stmt->bind_param("sssssii", $password, $full_name, $role, $email, $phone, $address, $user_id);
        $re = $stmt->execute();
        $stmt->close();
        $db->connection->close();
        return $re;
    }

    static function deleteUser($user_id)
    {
        $db = new Database();
        if (!$db->statusConnect) {
            echo "Kết nối lỗi";
            return false;
        }

        $sql = "DELETE FROM users WHERE user_id = ?";

        $stmt = $db->connection->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $re = $stmt->execute();
        $stmt->close();
        $db->connection->close();
        return $re;
    }
}

?>