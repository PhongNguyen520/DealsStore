<?php
require_once __DIR__ . "/models/Product.php";
require_once __DIR__ . "/models/Category.php";
require_once __DIR__ . "/models/Brand.php";

$product_id = isset($_GET['productId']) ? $_GET['productId'] : null;

$product = Product::getProductById($product_id);

if (!$product) {
    echo '<p>Sản phẩm không tồn tại!</p>';
    exit;
}

$category = Category::getCategoryById($product->category_id);
$brand = Brand::getBrandById($product->brand_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="css/productDetail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="product">
        <div class="product-detail">
            <div class="image">
                <img src="<?php echo $product->image_path; ?>" alt="Product Image">
            </div>

            <div class="product-info">
                <h1 class="name"><?php echo $product->product_name; ?></h1>
                <p class="price"><?php echo number_format($product->price); ?> VNĐ</p>
                <p class="description"><?php echo $product->description; ?></p>

                <div class="category">
                    <strong>Category: </strong><span><?php echo $category->category_name; ?></span>
                </div>
                <div class="brand">
                    <strong><i class="fas fa-tags fa-fill"></i> </strong><span><?php echo $brand->brand_name; ?></span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
