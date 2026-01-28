-- Create database
CREATE DATABASE IF NOT EXISTS easybooking;
USE easybooking;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (email)
);

-- Hotels table
CREATE TABLE IF NOT EXISTS hotels (
    hotel_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(100) NOT NULL,
    description TEXT,
    price_per_night DECIMAL(10,2) NOT NULL,
    rating DECIMAL(3,1),
    image_url VARCHAR(255)
);

-- Hotel bookings table
CREATE TABLE IF NOT EXISTS hotel_bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    hotel_id INT NOT NULL,
    check_in_date DATE NOT NULL,
    check_out_date DATE NOT NULL,
    adults INT NOT NULL DEFAULT 1,
    children INT NOT NULL DEFAULT 0,
    rooms INT NOT NULL DEFAULT 1,
    total_price DECIMAL(10,2) NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (hotel_id) REFERENCES hotels(hotel_id)
);

-- Flights table
CREATE TABLE IF NOT EXISTS flights (
    flight_id INT AUTO_INCREMENT PRIMARY KEY,
    airline VARCHAR(100) NOT NULL,
    flight_number VARCHAR(20) NOT NULL,
    departure_location VARCHAR(100) NOT NULL,
    arrival_location VARCHAR(100) NOT NULL,
    departure_date DATE NOT NULL,
    departure_time TIME NOT NULL,
    arrival_date DATE NOT NULL,
    arrival_time TIME NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    available_seats INT NOT NULL
);

-- Flight bookings table
CREATE TABLE IF NOT EXISTS flight_bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    flight_id INT NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    passengers INT NOT NULL DEFAULT 1,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (flight_id) REFERENCES flights(flight_id)
);

-- Car rentals table
CREATE TABLE IF NOT EXISTS cars (
    car_id INT AUTO_INCREMENT PRIMARY KEY,
    model VARCHAR(100) NOT NULL,
    brand VARCHAR(100) NOT NULL,
    year INT NOT NULL,
    type VARCHAR(50) NOT NULL,
    price_per_day DECIMAL(10,2) NOT NULL,
    location VARCHAR(100) NOT NULL,
    available BOOLEAN DEFAULT TRUE,
    image_url VARCHAR(255)
);

-- Car bookings table
CREATE TABLE IF NOT EXISTS car_bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    car_id INT NOT NULL,
    pickup_location VARCHAR(100) NOT NULL,
    dropoff_location VARCHAR(100) NOT NULL,
    pickup_date DATE NOT NULL,
    pickup_time TIME NOT NULL,
    dropoff_date DATE NOT NULL,
    dropoff_time TIME NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (car_id) REFERENCES cars(car_id)
);

-- Destinations table
CREATE TABLE IF NOT EXISTS destinations (
    destination_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    country VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255)
);

-- Contact messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample destinations
INSERT INTO destinations (name, country, description, image_url) VALUES
('Kuala Lumpur', 'Malaysia', 'The capital city of Malaysia', 'images/destination1.jpg'),
('Dhaka', 'Bangladesh', 'The capital city of Bangladesh', 'images/destination2.jpg'),
('Bangkok', 'Thailand', 'The capital city of Thailand', 'images/destination3.jpg'),
('Singapore', 'Singapore', 'A sovereign island city-state', 'images/destination4.jpg'),
('Cox\'s Bazar', 'Bangladesh', 'The longest natural sea beach in the world', 'images/destination5.jpg');

-- Insert sample hotels
INSERT INTO hotels (name, location, description, price_per_night, rating, image_url) VALUES
('Grand Hotel', 'Kuala Lumpur', 'Luxury hotel in the heart of the city', 150.00, 4.5, 'images/hotel1.jpg'),
('Seaside Resort', 'Cox\'s Bazar', 'Beautiful beachfront resort', 120.00, 4.2, 'images/hotel2.jpg'),
('City Comfort', 'Bangkok', 'Modern hotel with all amenities', 95.00, 4.0, 'images/hotel3.jpg'),
('Marina Bay', 'Singapore', 'Iconic hotel with stunning views', 200.00, 4.8, 'images/hotel4.jpg'),
('Urban Stay', 'Dhaka', 'Comfortable hotel in downtown', 80.00, 3.9, 'images/hotel5.jpg');

-- Insert sample flights
INSERT INTO flights (airline, flight_number, departure_location, arrival_location, departure_date, departure_time, arrival_date, arrival_time, price, available_seats) VALUES
('Air Asia', 'AA123', 'Kuala Lumpur', 'Bangkok', '2024-06-15', '10:00:00', '2024-06-15', '12:00:00', 150.00, 50),
('Singapore Airlines', 'SQ456', 'Singapore', 'Dhaka', '2024-06-20', '14:30:00', '2024-06-20', '17:30:00', 280.00, 35),
('Thai Airways', 'TG789', 'Bangkok', 'Cox\'s Bazar', '2024-06-25', '08:45:00', '2024-06-25', '11:15:00', 200.00, 40),
('Malaysia Airlines', 'MH012', 'Kuala Lumpur', 'Singapore', '2024-06-18', '16:20:00', '2024-06-18', '17:30:00', 120.00, 60),
('Biman Bangladesh', 'BG345', 'Dhaka', 'Kuala Lumpur', '2024-06-22', '23:00:00', '2024-06-23', '02:30:00', 250.00, 45);

-- Insert sample cars
INSERT INTO cars (model, brand, year, type, price_per_day, location, available, image_url) VALUES
('Corolla', 'Toyota', 2022, 'Sedan', 50.00, 'Kuala Lumpur', TRUE, 'images/car1.jpg'),
('Civic', 'Honda', 2021, 'Sedan', 55.00, 'Bangkok', TRUE, 'images/car2.jpg'),
('Fortuner', 'Toyota', 2023, 'SUV', 85.00, 'Singapore', TRUE, 'images/car3.jpg'),
('City', 'Honda', 2022, 'Sedan', 45.00, 'Dhaka', TRUE, 'images/car4.jpg'),
('Hiace', 'Toyota', 2021, 'Van', 70.00, 'Cox\'s Bazar', TRUE, 'images/car5.jpg');
