Create database if not exists `saledb` default character set utf8mb4 collate utf8mb4_general_ci;
use `saledb`;


CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    birth_date DATE,
    email VARCHAR(100),
    phone VARCHAR(15),
    address VARCHAR(255),
    role VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE brands (
    brand_id INT AUTO_INCREMENT PRIMARY KEY,
    brand_name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    category_id INT,
    brand_id INT,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    image_path VARCHAR(255),
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL, --set khóa ngoại, ON DELETE SET NULL: khóa chính bị delete thì khóa ngoại set = null
    FOREIGN KEY (brand_id) REFERENCES brands(brand_id) ON DELETE SET NULL --set khóa ngoại, ON DELETE SET NULL: khóa chính bị delete thì khóa ngoại set = null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Bảng users
INSERT INTO users (username, password, full_name, birth_date, email, phone, address, role) VALUES
('admin', 'password_hash_1', 'Nguyen Van A', '1990-01-01', 'user1@example.com', '0123456789', 'Hanoi', 'admin'),
('user2', 'password_hash_2', 'Le Thi B', '1992-02-02', 'user2@example.com', '0987654321', 'HCMC', 'user'),
('user3', 'password_hash_3', 'Tran Van C', '1985-05-10', 'user3@example.com', '0987123456', 'Da Nang', 'user'),
('user4', 'password_hash_4', 'Pham Thi D', '1993-03-20', 'user4@example.com', '0912345678', 'Hue', 'user'),
('user5', 'password_hash_5', 'Ngo Van E', '1994-12-25', 'user5@example.com', '0965432187', 'Can Tho', 'user'),
('user6', 'password_hash_6', 'Dang Thi F', '1988-07-15', 'user6@example.com', '0932112345', 'Vinh', 'user'),
('user7', 'password_hash_7', 'Nguyen Van G', '1991-10-08', 'user7@example.com', '0977123445', 'Hai Phong', 'user'),
('user8', 'password_hash_8', 'Vu Thi H', '1989-09-12', 'user8@example.com', '0983123412', 'Quang Ninh', 'user'),
('user9', 'password_hash_9', 'Le Van I', '1995-02-18', 'user9@example.com', '0912123445', 'Nam Dinh', 'user'),
('user10', 'password_hash_10', 'Hoang Thi J', '1996-04-22', 'user10@example.com', '0909876543', 'Bac Ninh', 'user');


-- Bảng categories
INSERT INTO categories (category_name, description) VALUES
('Electronics', 'Thiết bị điện tử'),
('Clothing', 'Quần áo thời trang'),
('Home Appliances', 'Đồ gia dụng'),
('Books', 'Sách và tạp chí'),
('Sports', 'Dụng cụ thể thao'),
('Toys', 'Đồ chơi'),
('Beauty', 'Mỹ phẩm và làm đẹp'),
('Automotive', 'Phụ kiện xe hơi'),
('Jewelry', 'Trang sức'),
('Furniture', 'Nội thất');

-- Bảng brands
INSERT INTO brands (brand_name, description) VALUES
('Samsung', 'Thương hiệu công nghệ Hàn Quốc'),
('Nike', 'Thương hiệu thời trang Mỹ'),
('Sony', 'Thương hiệu điện tử Nhật Bản'),
('Apple', 'Thương hiệu công nghệ Mỹ'),
('Adidas', 'Thương hiệu thời trang Đức'),
('Panasonic', 'Thương hiệu điện tử Nhật Bản'),
('Puma', 'Thương hiệu thời trang Đức'),
('Asus', 'Thương hiệu công nghệ Đài Loan'),
('Dell', 'Thương hiệu công nghệ Mỹ'),
('Chanel', 'Thương hiệu thời trang Pháp');

-- Bảng products
INSERT INTO products (product_name, category_id, brand_id, price, description, image_path, stock) VALUES
('Samsung Galaxy S21', 1, 1, 15000000, 'Điện thoại thông minh Samsung Galaxy S21', 'images/product/galaxy_s21.jpg', 100),
('Nike Air Max', 2, 2, 3000000, 'Giày thể thao Nike Air Max', 'images/product/air_max.jpg', 50),
('Sony Bravia TV', 1, 3, 12000000, 'Tivi Sony Bravia 4K', 'images/product/bravia_tv.jpg', 30),
('Apple iPhone 13', 1, 4, 20000000, 'Điện thoại thông minh Apple iPhone 13', 'images/product/iphone_13.jpg', 100),
('Adidas Ultraboost', 2, 5, 3500000, 'Giày thể thao Adidas Ultraboost', 'images/product/ultraboost.jpg', 40),
('Panasonic Refrigerator', 3, 6, 10000000, 'Tủ lạnh Panasonic Inverter', 'images/product/panasonic_fridge.jpg', 15),
('Puma Running Shoes', 2, 7, 2500000, 'Giày chạy bộ Puma', 'images/product/puma_running.jpg', 60),
('Asus Laptop', 1, 8, 17000000, 'Laptop Asus chuyên dụng', 'images/product/asus_laptop.jpg', 25),
('Dell XPS 13', 1, 9, 30000000, 'Laptop cao cấp Dell XPS 13', 'images/product/dell_xps.jpg', 10),
('Chanel Perfume', 7, 10, 4000000, 'Nước hoa Chanel cao cấp', 'images/product/chanel_perfume.jpg', 45);
