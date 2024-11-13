<?php
require_once __DIR__ . "/Database.php";
class Brand
{
    public $brand_id;
    public $brand_name;
    public $description;

    // Thêm brand mới vào database
    static function addBrand($brand_name, $description)
    {
        $conn = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query để thêm brand
        $sql = "INSERT INTO brands (brand_name, description) VALUES (?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $brand_name, $description);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();

        return $result;
    }

    // Lấy thông tin của một brand theo brand_id
    static function getBrandById($brand_id)
    {
        $db = new Database();
        if (!$db->statusConnect) {
            echo "Connection error!";
            return false;
        }

        $sql = "SELECT * FROM brands WHERE brand_id = ?";

        $stmt = $db->connection->prepare($sql);
        $stmt->bind_param("i", $brand_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $brand = $result->fetch_object("Brand");
        $stmt->close();
        $db->connection->close();

        if (!$brand || is_null($brand)) {
            return false;
        }
        return $brand;
    }

    // Lấy tất cả các brand từ database
    static function getAllBrands()
    {
        $listBrands = [];

        $db = new Database();

        if (!$db->statusConnect) {
            echo "Database connection error";
            return false;
        }

        $sql = "SELECT * FROM brands ORDER BY brand_name";

        $result = $db->connection->query($sql);
        if ($result->num_rows > 0) {
            while ($brand = $result->fetch_object("Brand")) {
                array_push($listBrands, $brand);
            }
        }
        $db->connection->close();
        return $listBrands;
    }

    // Cập nhật thông tin của một brand
    static function updateBrand($brand_id, $brand_name, $description)
    {
        $db = new Database();
        if (!$db->statusConnect) {
            echo "Connection error!";
            return false;
        }

        $sql = "UPDATE brands SET brand_name = ?, description = ? WHERE brand_id = ?";

        $stmt = $db->connection->prepare($sql);
        $stmt->bind_param("ssi", $brand_name, $description, $brand_id);
        $result = $stmt->execute();
        $stmt->close();
        $db->connection->close();

        return $result;
    }
    // Xóa một brand theo brand_id
    static function deleteBrand($brand_id)
    {
        $db = new Database();
        if (!$db->statusConnect) {
            echo "Connection error!";
            return false;
        }

        $sql = "DELETE FROM brands WHERE brand_id = ?";

        $stmt = $db->connection->prepare($sql);
        $stmt->bind_param("i", $brand_id);
        $result = $stmt->execute();
        $stmt->close();
        $db->connection->close();

        return $result;
    }
}

?>