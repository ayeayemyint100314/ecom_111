<?php
require_once "dbconnect.php";

try {
    $sql = "select * from category";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll(); // multiple rows returned

} catch (PDOException $e) {
    echo $e->getMessage();
}


if ($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['val'] == 'del') {
  try {
    $id = $_GET['id'];

    $sql = "delete from product where id=?";
    $stmt = $conn->prepare($sql);
    $status = $stmt->execute([$id]);
    if ($status) {
      header("Location:viewInfo.php?show=products");
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
} else if ($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['val'] == 'edit') {
  $id = $_GET['id'];
  try {
    $sql =  "select  p.id, p.product_name,
		          p.cost, p.price,
        p.description, p.image_path,
        c.cat_name as category, 
        p.id catid, p.quantity
        from product p, category c 
        where p.category = c.id and 
        p.id=?"; // return single row corresponding this id
      $stmt = $conn->prepare($sql);
      $stmt->execute([$id]);
      $product = $stmt->fetch(); 
      


  } catch (PDOException $e) {
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once "navigation.php"; ?>
        </div>
        <div class="row">
                <div class="col-md-2"></div> 
                <div class="col-md-10">
                        <form action="" class="form">
                            <div class="row">
                                <div class="col-md-6 py-3">
                                        <div class="mb-3">
                                            <label for="pname" class="form-label">Product Name</label>
                                            <input id="pname" type="text" class="form-control" name="pname" 
                                            value="<?php if(isset($product))
                                                    { echo $product['product_name']; } ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="cost" class="form-label">Product Cost</label>
                                            <input id="cost" type="number" class="form-control" name="cost"
                                            value="<?php if(isset($product)){ echo $product['cost']; } ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Product Price</label>
                                            <input id="price" type="number" name="price" class="form-control"
                                            value="<?php if(isset($product)) { echo $product['price'];}?>">
                                        </div>
                                        <div class="mb-3">
                                              <label for="">You selected <?php if(isset($product))
                                                            { echo "$product[category]"; } ?></label>
                                              <select name="" id="" class="form-select">
                                              <?php 
                                                  if(isset($categories))
                                                  {
                                                    foreach($categories as $category)
                                                    {
                                                        echo "<option value=$category[id]>$category[cat_name] </option>";
                                                    }
                                                  }                                            
                                              
                                              ?>
                                              </select>


                                        </div>


                                </div>

                                <div class="col-md-6 py-3">
                                  




                                </div>
                            </div>


                        </form>

                </div>
        </div>




    </div>


    
</body>
</html>