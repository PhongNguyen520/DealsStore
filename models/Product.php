<?php
require_once __DIR__ . "/Database.php";

class Product
{
    public $product_id;
    public $product_name;
    public $category_id;
    public $brand_id;
    public $price;
    public $description;
    public $image_path;
    public $stock;
    public $created_at;

    static function addProduct($product_name, $category_id, $brand_id, $price, $description, $image_path, $stock)
    {
        $conn = new mysqli(Config::DB_HOST, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO products (product_name, category_id, brand_id, price, description, image_path, stock) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siisdssi", $product_name, $category_id, $brand_id, $price, $description, $image_path, $stock);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();

        return $result;
    }

    static function getProductById($product_id)
    {
        $db = new Database();
        if (!$db->statusConnect) {
            echo "Connection error!";
            return false;
        }

        $sql = "SELECT p.*, c.category_name, b.brand_name 
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            JOIN brands b ON p.brand_id = b.brand_id
            WHERE p.product_id = ?";

        $stmt = $db->connection->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_object("Product");
        $stmt->close();
        $db->connection->close();

        if (!$product || is_null($product)) {
            return false;
        }
        return $product;
    }

    static function searchProductsByName($searchTerm)
    {
        $listProducts = [];
        $db = new Database();

        if (!$db->statusConnect) {
            echo "Database connection error";
            return false;
        }

        $sql = "SELECT p.*, c.category_name, b.brand_name 
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            JOIN brands b ON p.brand_id = b.brand_id
            WHERE p.product_name LIKE ?";

        $searchTerm = "%" . $searchTerm . "%";

        $stmt = $db->connection->prepare($sql);
        $stmt->bind_param("s", $searchTerm); 
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($product = $result->fetch_object("Product")) {
                array_push($listProducts, $product);
            }
        }

        $stmt->close();
        $db->connection->close();

        return $listProducts;
    }

    static function getByCategoryIdOrBrandId($category_id = null, $brand_id = null)
    {
        $listProducts = [];
        $db = new Database();

        if (!$db->statusConnect) {
            echo "Database connection error";
            return false;
        }

        $sql = "SELECT p.*, c.category_name, b.brand_name 
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            JOIN brands b ON p.brand_id = b.brand_id
            WHERE 1=1";

        if ($category_id !== null) {
            $sql .= " AND p.category_id = ?";
        }
        if ($brand_id !== null) {
            $sql .= " AND p.brand_id = ?";
        }

        $stmt = $db->connection->prepare($sql);

        if ($category_id !== null && $brand_id !== null) {
            $stmt->bind_param("ii", $category_id, $brand_id);
        } elseif ($category_id !== null) {
            $stmt->bind_param("i", $category_id);
        } elseif ($brand_id !== null) {
            $stmt->bind_param("i", $brand_id);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($product = $result->fetch_object("Product")) {
                array_push($listProducts, $product);
            }
        }

        $stmt->close();
        $db->connection->close();

        return $listProducts;
    }
    static function getAllProducts()
    {
        $listProducts = [];

        $db = new Database();

        if (!$db->statusConnect) {
            echo "Database connection error";
            return false;
        }

        $sql = "SELECT p.*, c.category_name, b.brand_name 
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            JOIN brands b ON p.brand_id = b.brand_id
            ORDER BY p.product_name";

        $result = $db->connection->query($sql);
        if ($result->num_rows > 0) {
            while ($product = $result->fetch_object("Product")) {
                array_push($listProducts, $product);
            }
        }
        $db->connection->close();
        return $listProducts;
    }

    static function updateProduct($product_id, $product_name, $category_id, $brand_id, $price, $description, $image_path, $stock)
    {
        $db = new Database();
        if (!$db->statusConnect) {
            echo "Connection error!";
            return false;
        }

        $sql = "UPDATE products 
            SET product_name = ?, category_id = ?, brand_id = ?, price = ?, description = ?, image_path = ?, stock = ? 
            WHERE product_id = ?";

        $stmt = $db->connection->prepare($sql);
        $stmt->bind_param("siisdssi", $product_name, $category_id, $brand_id, $price, $description, $image_path, $stock, $product_id);
        $result = $stmt->execute();
        $stmt->close();
        $db->connection->close();

        return $result;
    }

    static function deleteProduct($product_id)
    {
        $db = new Database();
        if (!$db->statusConnect) {
            echo "Connection error!";
            return false;
        }

        $sql = "DELETE FROM products WHERE product_id = ?";

        $stmt = $db->connection->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $result = $stmt->execute();
        $stmt->close();
        $db->connection->close();

        return $result;
    }
}
