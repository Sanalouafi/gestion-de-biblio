<?php

namespace App\Controllers;

include __DIR__ . '/../../vendor/autoload.php';

use App\Models\Book;

class BookController
{

    public function getBookById()
{
    $id = $_GET['id'];
    $book = new Book('', '', '', '', '', '', '', '');
    $bookData = $book->getBookById($id);
    return $bookData;
}

    public function getAllBooks()
    {
        $book = new Book('', '', '', '', '', '', '', '');
        return $book->getAllBooks();
    }

    public function addBook($title, $author, $genre, $description, $photo, $publicationYear, $totalCopies, $availableCopies)
    {
        $uploadDir = '../../public/images/';
        $uploadFile = $uploadDir . basename($_FILES['photo']['name']);

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            $book = new Book($title, $author, $genre, $description, $uploadFile, $publicationYear, $totalCopies, $availableCopies);

            if ($book->addBook()) {
                header('Location:../../../views/admin/book/showBooks.php');
            } else {
                echo "Error adding book !!";
            }
        } else {
            echo "Error uploading file.";
        }
    }

    public function editBook($id, $title, $genre, $author, $description, $photo, $publicationYear, $totalCopies, $availableCopies)
    {
        $uploadDir = '../../public/images/';
        $uploadFile = $uploadDir . basename($_FILES['photo']['name']);

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            $book = new Book($title, $author, $genre, $description, $uploadFile, $publicationYear, $totalCopies, $availableCopies);

            if ($book->editBook($id)) {
                header('Location: ../../views/admin/book/showBooks.php');
            } else {
                echo "Error editing book !!";
            }
        } else {
            echo "Error uploading file.";
        }
        
    }

    public function deleteBook($id)
    {
        $book = new Book('', '', '', '', '', '', '', '');

        if ($book->deleteBook($id)) {
            header('Location: ../../views/admin/book/showBooks.php');
        } else {
            echo "Error deleting book !!";
        }
    }
}

if (isset($_POST['add_book_submit'])) {
    $bookController = new BookController();
    $bookController->addBook(
        $_POST['title'],
        $_POST['author'],
        $_POST['genre'],
        $_POST['description'],
        $_FILES['photo']['name'],
        $_POST['publication_year'],
        $_POST['total_copie'],
        $_POST['available_copies']
    );
}

if (isset($_POST['edit_book_submit'])) {
    $bookController = new BookController();
    $bookController->editBook(
        $_POST['book_id'],
        $_POST['title'],
        $_POST['author'],
        $_POST['genre'],
        $_POST['description'],
        $_FILES['photo']['name'],
        $_POST['publication_year'],
        $_POST['total_copie'],
        $_POST['available_copies']
    );
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $bookController = new BookController();
    $bookController->deleteBook($_GET['id']);
}


