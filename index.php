<head>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan&display=swap" rel="stylesheet">
</head>
<?php
include("navbar.php");
?>

<div class="onSaleBanner">
    Currently On Offer!
</div>

<?php
include_once("mysqlConn.php");

$qry = "SELECT * FROM Product WHERE Offered = 1
        ORDER BY ProductTitle ASC";
$result = mysqli_query($conn, $qry);
$queryresult = mysqli_num_rows($result);

echo "<div class='container' mx-auto style='padding-top:20px; padding-bottom:100px; padding-left:20px;'>";
echo "<div class='row justify-content-center'>";
if ($queryresult > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $product = "productDesc.php?pid=$row[ProductID]"; // Getting Product ID
        $formattedPrice = number_format($row["Price"], 2); // Getting Product Price
        $img = "$row[ProductImage]"; // Getting Product Image Name
        $imgPathname = "Images/Products/$img";

        $currDate = date('Y-m-d');
        if ($row["Offered"] == 1 && $row["OfferEndDate"] > $currDate && $row["OfferStartDate"] < $currDate) {
            echo "<div class='col-md-3 justify-content-center' style='padding: 20px;'>";
            echo "<div class='card' style='width: 15rem;'>";
            echo "<img src='$imgPathname' class='card-img-top'>";
            echo "<div class='card-body text-center'>";

            $offeredPrice = number_format($row["OfferedPrice"], 2);
            echo "<h5 class='card-title'><b>$row[ProductTitle]</b></h5>";
            echo "<p><s>Price: S$$formattedPrice</s></p>";
            echo "<p class='salePrice' style='font-size: 15px;'>Offer Price: S$$offeredPrice</p>";

            echo "<a href='$product' class='btn btn-primary justify-content-center viewProduct'>View Product</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }
}
echo "</div>";
echo "</div>";

?>

<?php
include("footer.php");
?>