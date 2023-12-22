<?php
include __DIR__ . '/../../vendor/autoload.php';


use App\Controllers\BookController;
if (isset($_GET['searchTerm'])) {
    $searchQuery = $_GET['searchTerm'];
    $bookController = new BookController();
    $searchResults = $bookController->searchBooks($searchQuery);
    foreach($searchResults as $searchResult){
        echo "<tr>";
        echo "<td id='img' ><img src='" . $searchResult['photo'] . "'></td>";
        echo "<td>" . $searchResult['title'] . "</td>";
        echo "<td>" . $searchResult['author'] . "</td>";
        echo "<td>" . $searchResult['genre'] . "</td>";
        echo "<td>" . $searchResult['description'] . "</td>";
        echo "<td>" . $searchResult['publication_year'] . "</td>";
        echo "<td>";
        echo "<a href='#?id=" . $searchResult['id'] . "' class='link-dark'><i class='bx bxs-pencil fs-5 me-3'></i></a>";
        echo "<a href='reservation/reserver.php' data-delete='" . $searchResult['id'] . "' class='link-danger'><i class='bx bxs-user-x fs-5'></i></a>";
        echo "</td>";
        echo "</tr>";
       
    }

}
?>

