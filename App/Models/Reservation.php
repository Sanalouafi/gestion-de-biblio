<?php

namespace App\Models;

include __DIR__ . '/../../vendor/autoload.php';

use App\Database\DbHandler;
use App\Models\Book;

class Reservation
{
    private $id;
    private $description;
    private $reservation_date;
    private $return_date;
    private $is_returned;
    private $book_id;
    private $user_id;
    private $conn;

    public function __construct($description, $reservation_date, $return_date, $is_returned, $book_id, $user_id)
    {
        $this->conn = DbHandler::connect();
        $this->setDescription($description);
        $this->setReservationDate($reservation_date);
        $this->setReturnDate($return_date);
        $this->setIsReturned($is_returned);
        $this->setBookId($book_id);
        $this->setUserId($user_id);
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = mysqli_real_escape_string($this->conn, $description);
    }

    public function getReservationDate()
    {
        return $this->reservation_date;
    }

    public function setReservationDate($reservation_date)
    {
        $this->reservation_date = $reservation_date;
    }

    public function getReturnDate()
    {
        return $this->return_date;
    }

    public function setReturnDate($return_date)
    {
        $this->return_date = $return_date;
    }

    public function getIsReturned()
    {
        return $this->is_returned;
    }

    public function setIsReturned($is_returned)
    {
        $this->is_returned = $is_returned;
    }

    public function getBookId()
    {
        return $this->book_id;
    }

    public function setBookId($book_id)
    {
        $this->book_id = $book_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    public function getAllReservations()
    {
        $query = "SELECT r.*, b.*,u.* FROM book AS b INNER JOIN reservation AS r ON b.id = r.book_id INNER JOIN user AS u ON r.user_id = u.id";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error in query: " . mysqli_error($this->conn);
            return false;
        } else {
            return $result;
        }
    }

    public function getUserReservation($user_id)
    {
        $query = "SELECT r.*, b.*,u.* FROM book AS b INNER JOIN reservation AS r ON b.id = r.book_id INNER JOIN user AS u ON r.user_id = u.id where user_id=$user_id";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error in query: " . mysqli_error($this->conn);
            return false;
        } else {
            return $result;
        }
    }

    public function getReservationById($id)
    {
        $id = mysqli_real_escape_string($this->conn, $id);

        $query = "SELECT * FROM reservation WHERE id=$id";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error in query: " . mysqli_error($this->conn);
            return null;
        } else {
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                $reservation = new Reservation(
                    $row['description'],
                    $row['reservation_date'],
                    $row['return_date'],
                    $row['is_returned'],
                    $row['book_id'],
                    $row['user_id']
                );
                $reservation->setId($row['id']);
                return $reservation;
            } else {
                return null;
            }
        }
    }


    
    public function addReservation()
{
    $description = $this->getDescription();
    $reservation_date = $this->getReservationDate();
    $return_date = $this->getReturnDate();
    $is_returned = $this->getIsReturned();
    $book_id = $this->getBookId();
    $user_id = $this->getUserId();

    $bookModel = new Book('', '', '', '', '', '', '', '');
    $book = $bookModel->getBookById($book_id);

    if ($book && $book['available_copies'] > 0) {
        $newAvailableCopies = $book['available_copies'] - 1;
        $bookModel->updateAvailableCopies($book_id, $newAvailableCopies);

        $query = "INSERT INTO reservation (description, reservation_date, return_date, is_returned, book_id, user_id) 
                  VALUES ('$description', '$reservation_date', '$return_date', $is_returned, $book_id, $user_id)";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            $this->setId(mysqli_insert_id($this->conn));
            return true;
        } else {
            echo "Error adding reservation: " . mysqli_error($this->conn);

            $bookModel->updateAvailableCopies($book_id, $book['available_copies']);

            return false;
        }
    } else {
        echo "No available copies of the book.";
        return false;
    }
}

    


    public function editReservation()
    {
        $id = $this->getId();
        $description = $this->getDescription();
        $reservation_date = $this->getReservationDate();
        $return_date = $this->getReturnDate();
        $is_returned = $this->getIsReturned();
        $book_id = $this->getBookId();
        $user_id = $this->getUserId();

        $query = "UPDATE reservation 
                  SET description='$description', reservation_date='$reservation_date', return_date='$return_date',
                      is_returned=$is_returned, book_id=$book_id, user_id=$user_id
                  WHERE id=$id";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error updating reservation: " . mysqli_error($this->conn);
            return false;
        }

        return true;
    }

    public function deleteReservation()
    {
        $id = $this->getId();

        $query = "DELETE FROM reservation WHERE id=$id";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            echo "Error deleting reservation: " . mysqli_error($this->conn);
            return false;
        }

        return true;
    }
}
