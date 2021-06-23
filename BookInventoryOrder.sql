--Creating Order Table query
CREATE TABLE orders (order_id INT PRIMARY KEY AUTO_INCREMENT, book_id_fk INT NOT NULL, first_name VARCHAR(255), last_name VARCHAR(255),payment_mode VARCHAR(255), FOREIGN KEY (book_id_fk) REFERENCES bookinventory (book_id), quantity_purchased INT);
