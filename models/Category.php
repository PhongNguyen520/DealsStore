<?php
require_once __DIR__."/Database.php";

class Category
{
    public $category_id;
    public $category_name;
    public $description;

    static function getAllCategories()
    {
        $list = [];
        $db = new Database();
        if (!$db->statusConnect) {
            echo "Kết nối lỗi";
            return false;
        }
        $sql = "SELECT * FROM categories ORDER BY category_name";
        $result = $db->connection->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object("Category")) {
                array_push($list, $row);
            }
        }
        $db->connection->close();
        return $list;
    }

    static function addCategory($category_name, $description)
    {
        if (empty($category_name) || empty($description)) {
            return false;
        }

        $db = new Database();
        if (!$db->statusConnect) {
            echo "Kết nối lỗi";
            return false;
        }

        $sql = "INSERT INTO categories (category_name, description) VALUES (?, ?)";
        $stmt = $db->connection->prepare($sql);
        $stmt->bind_param("ss", $category_name, $description);  
        $re = $stmt->execute();
        $stmt->close();
        $db->connection->close();

        return $re;
    }

    static function getCategoryById($category_id)
    {
        $db = new Database();
        if (!$db->statusConnect) {
            echo "Kết nối lỗi";
            return null;
        }

        $sql = "SELECT * FROM categories WHERE category_id = ?";
        $stmt = $db->connection->prepare($sql);
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $ca = $result->fetch_object("Category");
        $stmt->close();
        $db->connection->close();

        if (!$ca || is_null($ca))
            return false;
        return $ca;
    }

    static function deleteCategory($category_id)
    {
        $db = new Database();
        if (!$db->statusConnect) {
            echo "Kết nối lỗi";
            return false;
        }

        $sql = "DELETE FROM categories WHERE category_id=?";
        $stmt = $db->connection->prepare($sql);
        $stmt->bind_param("i", $category_id);
        $re = $stmt->execute();
        $stmt->close();
        $db->connection->close();

        return $re;
    }

    static function updateCategory($category_id, $category_name, $description)
    {
        $db = new Database();
        if (!$db->statusConnect) {
            echo "Kết nối lỗi";
            return false;
        }

        $sql = "UPDATE categories SET category_name = ?, description = ? WHERE category_id = ?";
        $stmt = $db->connection->prepare($sql);
        $stmt->bind_param("ssi", $category_name, $description, $category_id); 
        $re = $stmt->execute();

        $stmt->close();
        $db->connection->close();
        return $re;
    }
}
?>
