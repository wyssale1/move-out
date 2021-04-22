<?php
    include_once "connection.php";
    $input = json_decode(file_get_contents('php://input'), true);
    $function = $input['function'];

    if ($function == "addNewEntry") {
        $category = $input['category'];
        $new_title = $input['title'];
        $price = $input['price'];
        $sql_add_entry = "INSERT INTO $table(category, state, titel, url, price) VALUES('$category', '0', '$new_title', '-', '$price');";
        if (mysqli_query($conn, $sql_add_entry)) {
            $inseret_id = $conn->insert_id;
            echo "$inseret_id";
        } else {
            echo "Error: " . $sql_add_entry . "" . mysqli_error($conn);
        }
        $conn->close();
    } elseif ($function == "updateState") {
        $id = $input['id'];
        $state = $input['state'];
        $sql_update_state = "UPDATE $table SET state=$state WHERE id=$id;";
        if (mysqli_query($conn, $sql_update_state)) {
            echo "Updated record successfully";
        } else {
            echo "Error: " . $sql_update_state . "" . mysqli_error($conn);
        }
        $conn->close();
    }   elseif ($function == "updateUser") {
            $id = $input['id'];
            $user = $input['user'];
            $sql_update_state = "UPDATE $table SET user=$user WHERE id=$id;";
            if (mysqli_query($conn, $sql_update_state)) {
                echo "Updated record successfully";
            } else {
                echo "Error: " . $sql_update_state . "" . mysqli_error($conn);
            }
            $conn->close();
    } elseif ($function == "deleteProduct") {
        $id = $input['id'];
        $sql_delete_product = "DELETE FROM $table WHERE id='$id';";
        if (mysqli_query($conn, $sql_delete_product)) {
            echo "Product successfully deleted";
        } else {
            echo "Error: " . $sql_delete_product . "" . mysqli_error($conn);
        }
        $conn->close();
    } elseif ($function == "getAllData") {
        $data = array();
        $cat = $input['cat'];
        $sql_get_cat = "SELECT * FROM $table WHERE (category = '$cat');";
        $result_cat = mysqli_query($conn, $sql_get_cat);
        if (mysqli_num_rows($result_cat) > 0) {
            while($content = mysqli_fetch_assoc($result_cat)) {
                array_push($data, array("id"=>$content['id'], "category"=>$content['category'], "state"=>$content['state'], "title"=>$content['titel'], "price"=>$content['price']));
            }
            echo json_encode($data);
        } else {
            echo "false";
        }
        $conn->close(); 
    } elseif ($function == "getData") {
        $id = $input['id'];
        $sql_get = "SELECT * FROM $table WHERE id LIKE '$id';";
        $result = mysqli_query($conn, $sql_get);
        if (mysqli_num_rows($result) > 0) {
            while($item = mysqli_fetch_assoc($result)) {
                echo '{"id":"' . $item["id"] . '", "titel":"' . $item["titel"] . '", "url":"' . $item["url"] . '", "price":"' . $item["price"] . '"}';
            }
        } else {
            echo "keine Daten";
        }
        $conn->close();
    } elseif ($function == "getUsers") {
        $data = array();
        $sql_get = "SELECT * FROM users;";
        $result = mysqli_query($conn, $sql_get);
        if (mysqli_num_rows($result) > 0) {
            while($item = mysqli_fetch_assoc($result)) {
                array_push($data, array("id"=>$item['id'], "username"=>$item['username'], "name"=>$item['name'], "firstname"=>$item['firstname']));
            }
            echo json_encode($data);
        } else {
            echo "false";
        }
        $conn->close();
    } 
?>