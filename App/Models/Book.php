<?php

namespace App\Models;

include __DIR__ . '/../../vendor/autoload.php';

use App\Database\DbHandler;

class Book
{
    private $id;
    private $title;
    private $author;
    private $genre;
    private $description;
    private $photo;
    private $publicationYear;
    private $totalCopies;
    private $availableCopies;
    private $conn;

    public function __construct(
        $title,
        $author,
        $genre,
        $description,
        $photo,
        $publicationYear,
        $totalCopies,
        $availableCopies
    ) {
        $this->conn = DbHandler::connect();

        $this->setTitle($title);
        $this->setAuthor($author);
        $this->setGenre($genre);
        $this->setDescription($description);
        $this->setPhoto($photo);
        $this->setPublicationYear($publicationYear);
        $this->setTotalCopies($totalCopies);
        $this->setAvailableCopies($availableCopies);
    }

    public function getAllBooks()
    {
        $query = "SELECT * FROM book";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error in query: " . mysqli_error($this->conn);
            return false;
        } else {
            return $result;
        }
    }

    public function getBookById($id)
    {
        $query = "SELECT * FROM book WHERE id = $id";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error in query: " . mysqli_error($this->conn);
            return false;
        } else {
            return mysqli_fetch_assoc($result);
        }
    }

    public function addBook()
    {
        $title = $this->getTitle();
        $author = $this->getAuthor();
        $genre = $this->getGenre();
        $description = $this->getDescription();
        $photo = $this->getPhoto();
        $publicationYear = $this->getPublicationYear();
        $totalCopies = $this->getTotalCopies();
        $availableCopies = $this->getAvailableCopies();

        $query = "INSERT INTO book (title, author, genre, description, photo, publication_year, total_copie, available_copies) 
                  VALUES ('$title', '$author', '$genre', '$description', '$photo', '$publicationYear', $totalCopies, $availableCopies)";

        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error adding book: " . mysqli_error($this->conn);
            return false;
        } else {
            return true;
        }
    }

    public function editBook($id)
    {
        $title = $this->getTitle();
        $author = $this->getAuthor();
        $genre = $this->getGenre();
        $description = $this->getDescription();
        $photo = $this->getPhoto();
        $publicationYear = $this->getPublicationYear();
        $totalCopies = $this->getTotalCopies();
        $availableCopies = $this->getAvailableCopies();

        $query = "UPDATE book 
                  SET title='$title', author='$author', genre='$genre', description='$description', 
                  photo='$photo', publication_year='$publicationYear', total_copie=$totalCopies, available_copies=$availableCopies 
                  WHERE id = $id";

        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error updating book: " . mysqli_error($this->conn);
            return false;
        } else {
            return true;
        }
    }

    public function deleteBook($id)
    {
        $query = "DELETE FROM book WHERE id = $id";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            $query_delete = "DELETE FROM reservation WHERE id = $id";
            $result_delete = mysqli_query($this->conn, $query_delete);

            echo "Error deleting book: " . mysqli_error($this->conn);
            return false;
        } else {
            return true;
        }
    }

   

    public function updateAvailableCopies($id, $newAvailableCopies)
    {
        $query = "UPDATE book SET available_copies=$newAvailableCopies WHERE id=$id";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error updating available_copies in book table: " . mysqli_error($this->conn);
            return false;
        } else {
            $this->setAvailableCopies($newAvailableCopies);
            return true;
        }
    }


    public function setTitle($title)
    {
        $this->title = mysqli_real_escape_string($this->conn, $title);
    }

    public function getTitle()
    {
        return $this->title;
    }
    public function setAuthor($author)
    {
        $this->author = mysqli_real_escape_string($this->conn, $author);
    }

    public function getAuthor()
    {
        return $this->author;
    }
    public function setGenre($genre)
    {
        $this->genre = mysqli_real_escape_string($this->conn, $genre);
    }

    public function getGenre()
    {
        return $this->genre;
    }
    public function setDescription($description)
    {
        $this->description = mysqli_real_escape_string($this->conn, $description);
    }

    public function getDescription()
    {
        return $this->description;
    }
    public function setPhoto($photo)
    {
        $this->photo = mysqli_real_escape_string($this->conn, $photo);
    }

    public function getPhoto()
    {
        return $this->photo;
    }
    public function setPublicationYear($publicationYear)
    {
        $this->publicationYear = mysqli_real_escape_string($this->conn, $publicationYear);
    }

    public function getPublicationYear()
    {
        return $this->publicationYear;
    }
    public function setTotalCopies($totalCopies)
    {
        $this->totalCopies = mysqli_real_escape_string($this->conn, $totalCopies);
    }

    public function getTotalCopies()
    {
        return $this->totalCopies;
    }
    public function setAvailableCopies($availableCopies)
    {
        $this->availableCopies = mysqli_real_escape_string($this->conn, $availableCopies);
    }

    public function getAvailableCopies()
    {
        return $this->availableCopies;
    }
}
