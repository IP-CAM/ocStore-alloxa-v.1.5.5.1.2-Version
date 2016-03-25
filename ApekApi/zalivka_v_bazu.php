<?php
ini_set('max_execution_time', 50000);
include 'inc/function.php';
include 'inc/db.php';
mysqli_query($db, "TRUNCATE TABLE oc_category;");
mysqli_query($db, "TRUNCATE TABLE oc_category_description;");
mysqli_query($db, "TRUNCATE TABLE oc_category_path;");
mysqli_query($db, "TRUNCATE TABLE oc_category_to_store;");
mysqli_query($db, "TRUNCATE TABLE oc_manufacturer;");
mysqli_query($db, "TRUNCATE TABLE oc_manufacturer_to_store;");
mysqli_query($db, "TRUNCATE TABLE oc_product;");
mysqli_query($db, "TRUNCATE TABLE oc_product_description;");
mysqli_query($db, "TRUNCATE TABLE oc_product_image;");
mysqli_query($db, "TRUNCATE TABLE oc_product_to_category;");
mysqli_query($db, "TRUNCATE TABLE oc_product_to_store;");
mysqli_query($db, "TRUNCATE TABLE oc_url_alias;");
mysqli_query($db, "TRUNCATE TABLE oc_product_special;");
//exit();
$count = mysqli_query($db, "SELECT * FROM root_tovar WHERE chek = 0");
//print_r($count->num_rows);
if ($count->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($count)) {

        if($row["price"] !== ""){
            $stock_status_id = 7;
            $price = $row["price"];
            $quantity = 100;
            $top =  array("Кондиционеры", "Телевизоры", "Irix", "Linux");
            if (in_array($row["breadcrumbs1"], $top)) {
                $top = 1;
            }else{$top = 0;}
        }else{
            $stock_status_id = 5;
            $price = 0;
            $quantity = 0;
        }
        if ($stock_status_id==5)
        {continue;
        }
        if(isset($row["breadcrumbs1"])){
            $category = $row["breadcrumbs1"];
            $count_category = mysqli_query($db, "SELECT * FROM oc_category_description WHERE name = '".$category."' LIMIT 1;");
            if ($count_category->num_rows == 0) {
                mysqli_query($db, "INSERT INTO oc_category_description
                (
                    language_id
                    ,name
                    ,description
                    ,meta_title
                    ,meta_description
                    ,meta_keyword
                )
VALUES
(
  1 -- language_id - INT(11) NOT NULL
 , '".$category."'  -- name - VARCHAR(255) NOT NULL
 ,'' -- description - TEXT NOT NULL
 , '".$category."'  -- meta_title - VARCHAR(255) NOT NULL
 , '".$category."'  -- meta_description - VARCHAR(255) NOT NULL
 , '".$category."'  -- meta_keyword - VARCHAR(255) NOT NULL
)");

                $id_category = mysqli_query($db, "SELECT * FROM oc_category_description WHERE name = '".$category."' LIMIT 1;");
                $id_category  = mysqli_fetch_assoc($id_category);
                $id_category  =$id_category["category_id"];
                mysqli_query($db, "INSERT INTO bt.oc_category
(
  category_id
 ,image
 ,parent_id
 ,top
 ,`column`
 ,sort_order
 ,status
 ,date_added
 ,date_modified
)
VALUES
(
  '".$id_category."' -- category_id - INT(11) NOT NULL
 ,'' -- image - VARCHAR(255)
 ,0 -- parent_id - INT(11) NOT NULL
 ,'".$top."' -- top - TINYINT(1) NOT NULL
 ,0 -- column - INT(3) NOT NULL
 ,0 -- sort_order - INT(3) NOT NULL
 ,1 -- status - TINYINT(1) NOT NULL
 ,NOW() -- date_added - DATETIME NOT NULL
 ,NOW() -- date_modified - DATETIME NOT NULL
)");


                mysqli_query($db, "INSERT INTO oc_category_path
(
  category_id
 ,path_id
 ,level
)
VALUES
(
  '".$id_category."' -- category_id - INT(11) NOT NULL
 ,'".$id_category."' -- path_id - INT(11) NOT NULL
 ,0 -- level - INT(11) NOT NULL
)");

                mysqli_query($db, " INSERT INTO oc_category_to_store
                (
                    category_id
                    ,store_id
                )
VALUES
(
   '".$id_category."' -- category_id - INT(11) NOT NULL
 ,0 -- store_id - INT(11) NOT NULL
)");
                mysqli_query($db, "INSERT INTO oc_url_alias
(
  query
 ,keyword
)
VALUES
(
  'category_id=" . $id_category . "' -- query - VARCHAR(255) NOT NULL
 ,'" . translitIt(preg_replace("/\s+/","",str_replace(array("\r\n", "\n"), "",  trim($category)))) . "' -- keyword - VARCHAR(255) NOT NULL
)");

            }else{ $id_category = mysqli_query($db, "SELECT * FROM oc_category_description WHERE name = '".$category."' LIMIT 1;");
                $id_category  = mysqli_fetch_assoc($id_category);
                $id_category  =$id_category["category_id"];}
        }else{$category = '';}

        if(isset($row["breadcrumbs2"])) {
            $manufacturer = str_replace($row["breadcrumbs1"] . " ", "", trim($row["breadcrumbs2"]));
            $count_manufacturer = mysqli_query($db, "SELECT * FROM oc_manufacturer WHERE name = '" . $manufacturer . "' LIMIT 1;");
            if ($count_manufacturer->num_rows == 0) {
                mysqli_query($db, "INSERT INTO oc_manufacturer
            (
                name
                ,image
                ,sort_order
            )
VALUES
(
  '" . $manufacturer . "' -- name - VARCHAR(64) NOT NULL
 ,'' -- image - VARCHAR(255)
 ,0 -- sort_order - INT(3) NOT NULL
)");

                $id_manufacturer = mysqli_query($db, "SELECT * FROM oc_manufacturer WHERE name = '" . $manufacturer . "' LIMIT 1;");
                $id_manufacturer = mysqli_fetch_assoc($id_manufacturer);
                $id_manufacturer = $id_manufacturer["manufacturer_id"];
                mysqli_query($db, " INSERT INTO oc_manufacturer_to_store
                (
                    manufacturer_id
                    ,store_id
                )
VALUES
(
    '" . $id_manufacturer . "' -- manufacturer_id - INT(11) NOT NULL
 ,0 -- store_id - INT(11) NOT NULL
)");
                mysqli_query($db, "INSERT INTO oc_url_alias
(
  query
 ,keyword
)
VALUES
(
  'manufacturer_id=" . $id_manufacturer . "' -- query - VARCHAR(255) NOT NULL
 ,'" . translitIt(preg_replace("/\s+/","",str_replace(array("\r\n", "\n"), "",  trim($manufacturer)))) . "' -- keyword - VARCHAR(255) NOT NULL
)");

            } else {
                $id_manufacturer = mysqli_fetch_assoc($count_manufacturer);
                $id_manufacturer = $id_manufacturer["manufacturer_id"];

            }
        }

        mysqli_query($db, " INSERT INTO oc_product
        (
            product_id
            ,model
            ,sku
            ,upc
            ,ean
            ,jan
            ,isbn
            ,mpn
            ,location
            ,quantity
            ,stock_status_id
            ,image
            ,manufacturer_id
            ,shipping
            ,price
            ,points
            ,tax_class_id
            ,date_available
            ,weight
            ,weight_class_id
            ,length
            ,width
            ,height
            ,length_class_id
            ,subtract
            ,minimum
            ,sort_order
            ,status
            ,viewed
            ,date_added
            ,date_modified
        )
VALUES
(
    '" . $row["id"] . "'
 ,'" . $row["id"] . "' -- model - VARCHAR(64) NOT NULL
 ,'" . $row["id"] . "' -- sku - VARCHAR(64) NOT NULL
 ,'' -- upc1 - VARCHAR(12) NOT NULL
 ,'' -- ean1 - VARCHAR(14) NOT NULL
 ,'' -- jan1 - VARCHAR(13) NOT NULL
 ,'' -- isbn1 - VARCHAR(17) NOT NULL
 ,'' -- mpn1 - VARCHAR(64) NOT NULL
 ,'' -- location - VARCHAR(128) NOT NULL
 ,".$quantity." -- quantity - INT(4) NOT NULL
 ,".$stock_status_id." -- stock_status_id - INT(11) NOT NULL
 ,'" . $row["img0"] . "' -- image - VARCHAR(255)
 ,'".$id_manufacturer."' -- manufacturer_id - INT(11) NOT NULL
 ,1 -- shipping - TINYINT(1) NOT NULL
 ,".$price." -- price - DECIMAL(15, 4) NOT NULL
 ,0 -- points - INT(8) NOT NULL
 ,0 -- tax_class_id - INT(11) NOT NULL
 ,NOW() -- date_available - DATE NOT NULL
 ,0 -- weight - DECIMAL(15, 8) NOT NULL
 ,0 -- weight_class_id - INT(11) NOT NULL
 ,0 -- length - DECIMAL(15, 8) NOT NULL
 ,0 -- width - DECIMAL(15, 8) NOT NULL
 ,0 -- height - DECIMAL(15, 8) NOT NULL
 ,0 -- length_class_id - INT(11) NOT NULL
 ,0 -- subtract - TINYINT(1) NOT NULL
 ,1 -- minimum - INT(11) NOT NULL
 ,0 -- sort_order - INT(11) NOT NULL
 ,1 -- status - TINYINT(1) NOT NULL
 ,0 -- viewed - INT(5) NOT NULL
 ,NOW() -- date_added - DATETIME NOT NULL
 ,NOW() -- date_modified - DATETIME NOT NULL
)");
        mysqli_query($db, "  INSERT INTO oc_product_to_category
        (
            product_id
            ,category_id
        )
VALUES
(
   '" . $row["id"] . "' -- product_id - INT(11) NOT NULL
 ,'".$id_category."' -- category_id - INT(11) NOT NULL
)");
        if($row["img1"] !== "") {mysqli_query($db, "  INSERT INTO oc_product_image
        (
            product_id
            ,image
            ,sort_order
        )
VALUES
(
  '" . $row["id"] . "' -- product_id - INT(11) NOT NULL
 ,'".$row["img1"]."' -- image - VARCHAR(255)
 ,0 -- sort_order - INT(3) NOT NULL
)");}

        if($row["img2"] !== "") {mysqli_query($db, "  INSERT INTO oc_product_image
        (
            product_id
            ,image
            ,sort_order
        )
VALUES
(
  '" . $row["id"] . "' -- product_id - INT(11) NOT NULL
 ,'".$row["img2"]."' -- image - VARCHAR(255)
 ,0 -- sort_order - INT(3) NOT NULL
)");}

        if($row["img3"] !== "") {mysqli_query($db, "  INSERT INTO oc_product_image
        (
            product_id
            ,image
            ,sort_order
        )
VALUES
(
  '" . $row["id"] . "' -- product_id - INT(11) NOT NULL
 ,'".$row["img3"]."' -- image - VARCHAR(255)
 ,0 -- sort_order - INT(3) NOT NULL
)");}

        if($row["img4"] !== "") {mysqli_query($db, "  INSERT INTO oc_product_image
        (
            product_id
            ,image
            ,sort_order
        )
VALUES
(
  '" . $row["id"] . "' -- product_id - INT(11) NOT NULL
 ,'".$row["img4"]."' -- image - VARCHAR(255)
 ,0 -- sort_order - INT(3) NOT NULL
)");}

        mysqli_query($db, "  INSERT INTO oc_product_to_store
        (
            product_id
            ,store_id
        )
VALUES
(
   '" . $row["id"] . "' -- product_id - INT(11) NOT NULL
 ,0 -- store_id - INT(11) NOT NULL
)");

        if( mysqli_query($db, "  INSERT INTO oc_product_description
        (
            product_id
            ,language_id
            ,name
            ,description
            ,tag
            ,meta_title
            ,meta_description
            ,meta_keyword
        )
VALUES
(
    '" . $row["id"] . "' -- product_id - INT(11) NOT NULL
 ,1 -- language_id - INT(11) NOT NULL
 ,'" . $row["name"] . "' -- name - VARCHAR(255) NOT NULL
 ,'" . str_replace(array("\"", "'"), "",$row["description"]) . "' -- description - TEXT NOT NULL
 ,'" . $row["name"] . "' -- tag - TEXT NOT NULL
 ,'" . $row["name"] . "' -- meta_title - VARCHAR(255) NOT NULL
 ,'" . $row["name"] . "' -- meta_description - VARCHAR(255) NOT NULL
 ,'" . $row["name"] . "' -- meta_keyword - VARCHAR(255) NOT NULL
) ")){
            /* if($row["price_new"] !== "") {mysqli_query($db, "  INSERT INTO oc_product_special
          (
              product_id
              ,customer_group_id
              ,priority
              ,price
              ,date_start
              ,date_end
          )
  VALUES
  (
     '" . $row["id"] . "' -- product_id - INT(11) NOT NULL
   ,1 -- customer_group_id - INT(11) NOT NULL
   ,0 -- priority - INT(5) NOT NULL
   ,'" . $row["price_new"] . "' -- price - DECIMAL(15, 4) NOT NULL
   ,NOW() -- date_start - DATE NOT NULL
   ,NOW() + interval 5 day -- date_end - DATE NOT NULL
  )");}*/
        }
        mysqli_query($db, "INSERT INTO oc_url_alias
(
  query
 ,keyword
)
VALUES
(
  'product_id=" . $row["id"] . "' -- query - VARCHAR(255) NOT NULL
 ,'" . translitIt(preg_replace("/\s+/","",str_replace(array("\r\n", "\n"), "",  trim($row["name"])))) . "' -- keyword - VARCHAR(255) NOT NULL
)");

    }
}
?>