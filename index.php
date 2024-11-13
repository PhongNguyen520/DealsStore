<?php $ownerInfo = [
    'fullName' => 'Pham Thi Cam Tien',
    'studentID' => '2123110228',
    'dateOfBirth' => '03/03/2005'
];
?>

<?php
require_once __DIR__ . "/models/Product.php";
require_once __DIR__ . "/models/Category.php";
require_once __DIR__ . "/models/Brand.php";
require_once __DIR__ . "/models/User.php";

$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
$brand_id = isset($_GET['brand_id']) ? $_GET['brand_id'] : null;
$searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

if ($searchTerm) {
    $products = Product::searchProductsByName($searchTerm);
} else {
    $products = Product::getByCategoryIdOrBrandId($category_id, $brand_id);
}

$brands = Brand::getAllBrands();
$categories = Category::getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="modal" id="modal" style="display: none;">
        <div class="modal-wrapper">
            <h3>About Myseft</h3>
            <div class="information">
                <strong>FullName: <span><?php echo $ownerInfo['fullName'] ?></span></strong>
                <strong>StudentID: <?php echo $ownerInfo['studentID'] ?></strong>
                <strong>DateOfBirth: <?php echo $ownerInfo['dateOfBirth'] ?></strong>
            </div>
            <div class="homebutton">
                <button onclick="closeModal()">Homepage</button>
            </div>
        </div>
    </div>

    <div class="homepage" id="homepage">
        <div class="header">
            <div class="logo">
                <img src="../FinalAssignment_2123110228_phamthicamtien/images/logo.png" alt='logo' />
                <div>
                    <span>Deals</span>
                    <div class="titleStore">
                        <span>Store</span>
                    </div>
                </div>
            </div>
            <div class="menu">
                <ul class="nav-item">
                    <li class="item" onclick="clickHome()">
                        <a href="<?php echo Config::PATH_ROOT ?>/index.php">
                            <span class="fas fa-home">Home</span>
                        </a>
                    </li>
                    <li class="item">
                        <form action="index.php" method="GET">
                            <input type="text" name="searchTerm" placeholder="Search for products..." value="<?php echo isset($_GET['searchTerm']) ? $_GET['searchTerm'] : ''; ?>">
                            <span class="fas fa-search" onclick="this.closest('form').submit();"></span>
                        </form>
                    </li>

                    <li class="item">
                        <?php
                        session_start();

                        if (isset($_SESSION['user'])) {
                            $user = unserialize($_SESSION['user']);
                            echo 'Welcome, ' . htmlspecialchars($user->full_name);
                            echo "<span class='dropdown'>
                            <div class='dropdown-content'>
                            <a href='". Config::PATH_ROOT. "/logout.php'><i class='fas fa-sign-out-alt'></i></a>
                            </div>
                            </span>";
                        } else {
                            echo "<a href='". Config::PATH_ROOT. "/login.php'>
                            <span class='btnLogin'>Login</span></a>";
                        } ?>

                       
                    </li>
                </ul>
            </div>


        </div>

        <div class="category-brand">
            <div>
                <strong>Category:</strong>
                <div class="categories">
                    <?php foreach ($categories as $category): ?>
                        <span class="clickable" data-id="<?php echo $category->category_id; ?>" onclick="setActive(this)">
                            <?php echo $category->category_name ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <strong>Brand:</strong>
                <div class="brands">
                    <?php foreach ($brands as $brand): ?>
                        <span class="clickable" data-id="<?php echo $brand->brand_id; ?>" onclick="setActive(this)">
                            <?php echo $brand->brand_name ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="listProduct" id="listProduct">
            <?php
            if (empty($products)) {
                echo '<p>No products found!</p>';
            } else {
                foreach ($products as $product): ?>
                    <a href="productDetail.php?productId=<?php echo $product->product_id ?>">
                        <div class="product">
                            <img src="<?php echo $product->image_path; ?>" alt="Product Image">
                            <div class="info">
                                <h4 class="brand"><?php echo $product->product_name; ?></h4>
                                <p class="price"><?php echo number_format($product->price); ?> VNĐ</p>
                                <p class="description"><?php echo $product->description; ?></p>
                            </div>
                        </div>
                    </a>
            <?php endforeach;
            }
            ?>

        </div>


        <script>
            function closeModal() {
                document.querySelector('#modal').style.display = "none";
                document.querySelector('#homepage').style.display = "block";
            }

            function clickHome() {
                clearActive();
            }

            function clickBrand() {
                document.querySelector('#listProduct').classList.add('hidden');
            }

            function setActive(element) {
                element.classList.add('active');
                clearActive();
                var categoryId = null;
                var brandId = null;

                if (element.parentElement.classList.contains('categories')) {
                    categoryId = element.dataset.id;
                } else if (element.parentElement.classList.contains('brands')) {
                    brandId = element.dataset.id;
                }

                loadProducts(categoryId, brandId);
            }

            function loadProducts(categoryId, brandId) {
                var url = "index.php";
                var params = new URLSearchParams();
                if (categoryId) {
                    params.append('category_id', categoryId);
                }
                if (brandId) {
                    params.append('brand_id', brandId);
                }

                window.location.href = url + "?" + params.toString();
            }

            function clearActive() {
                const categories = document.querySelectorAll('.clickable');
                const brands = document.querySelectorAll('.clickable');
                categories.forEach(category => {
                    category.classList.remove('active');
                });

                brands.forEach(brand => {
                    brand.classList.remove('active');
                });
            }
        </script>
</body>

</html>