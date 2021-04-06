/* Categories */
create table categories (
	id int(11) not null PRIMARY KEY AUTO_INCREMENT,
    category varchar(128) not null,
    category_titel varchar(128) not null
);

INSERT INTO categories (category, category_titel) VALUES ('kitchen', 'Küche');

/* Products */

create table products (
	id int(11) not null PRIMARY KEY AUTO_INCREMENT,
    category int(3) not null,
    state int(1) not null,
    titel varchar(128) not null,
    url varchar(256),
    price int(11),
    user varchar(20) not null
);

/* Users */
create table users (
	id int(11) not null PRIMARY KEY AUTO_INCREMENT,
    username varchar(10) not null,
    password varchar(128) not null,
    name varchar(40) not null,
    firstname varchar(40) not null
);



include_once "includes/connection.php";

$sql = "INSERT INTO products (category, state, titel, url, price) VALUES ('1', '1', 'Couch', '-', '300')";

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "" . mysqli_error($conn);
}
$conn->close();

    $sql = 'SELECT * FROM products';
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
               echo "Name: " . $row["category"]. "<br>";
        }
    } else {
        echo "0 results";
    }
    mysqli_close($conn);


CREATE TABLE `users` ( 
  `id` INT NOT NULL AUTO_INCREMENT ,
  `passwort` VARCHAR(255) NOT NULL ,
  `vorname` VARCHAR(255) NOT NULL DEFAULT '' ,
  `nachname` VARCHAR(255) NOT NULL DEFAULT '' ,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;