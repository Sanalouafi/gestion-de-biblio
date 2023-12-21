<?php

namespace App\Controllers;
include __DIR__.'/../../vendor/autoload.php';

use App\Models\Reservation;
use App\Models\Book; 
class ReservationController
{
    public function getAllReservations()
    {
        $reservationModel = new Reservation('', '', '', '', '', '');
        $reservations = $reservationModel->getAllReservations();
        return $reservations;
    }

    public function getReservationById($id)
    {
        $reservationModel = new Reservation('', '', '', '', '', '');
        $reservation = $reservationModel->getReservationById($id);

        return $reservation;
    }

    public function addReservation($description, $reservation_date, $return_date, $is_returned, $book_id, $user_id)
    {
        $bookModel = new Book('', '', '', '', '', '', '', '');
        $book = $bookModel->getBookById($book_id);

        if ($book && $book['available_copies'] > 0) {
            $newAvailableCopies = $book['available_copies'] - 1;
            $bookModel->updateAvailableCopies($book_id, $newAvailableCopies);

            $reservationModel = new Reservation($description, $reservation_date, $return_date, $is_returned, $book_id, $user_id);

            if ($reservationModel->addReservation()) {
                return "Reservation added successfully!";
            } else {
                $bookModel->updateAvailableCopies($book_id, $book['available_copies']);

                return "Error adding reservation!";
            }
        } else {
            return "No available copies of the book.";
        }
    }

    public function editReservation($id, $description, $reservation_date, $return_date, $is_returned, $book_id, $user_id)
    {
        $reservationModel = new Reservation('', '', '', '', '', '');
        $reservation = $reservationModel->getReservationById($id);

        if (!$reservation) {
            return "Reservation not found!";
        }
        $reservation->setDescription($description);
        $reservation->setReservationDate($reservation_date);
        $reservation->setReturnDate($return_date);
        $reservation->setIsReturned($is_returned);
        $reservation->setBookId($book_id);
        $reservation->setUserId($user_id);

        if ($reservation->editReservation()) {
            return "Reservation updated successfully!";
        } else {
            return "Error updating reservation!";
        }
    }

    public function deleteReservation($id)
    {
        $reservationModel = new Reservation('', '', '', '', '', '');
        $reservation = $reservationModel->getReservationById($id);

        if (!$reservation) {
            return "Reservation not found!";
        }

        if ($reservation->deleteReservation()) {
            return "Reservation deleted successfully!";
        } else {
            return "Error deleting reservation!";
        }
    }
}
