-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2025 at 03:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mountapollo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `admission_id` int(11) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `roomNumber` int(11) NOT NULL,
  `admit_date` date NOT NULL,
  `discharge_date` date NOT NULL,
  `patient_name` varchar(30) NOT NULL,
  `contact_number` int(12) NOT NULL,
  `additional_record` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Admitted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admissions`
--

INSERT INTO `admissions` (`admission_id`, `reason`, `roomNumber`, `admit_date`, `discharge_date`, `patient_name`, `contact_number`, `additional_record`, `status`) VALUES
(1, 'Pneumonia', 3, '2025-01-06', '2025-01-06', 'Shasani Nisansala', 764846394, 'Initial diagnosis pending', 'Admitted'),
(2, 'Fracture treatment', 5, '2025-01-06', '2025-01-06', 'Chamika Heshani', 752041657, 'Under observation', 'Admitted'),
(3, 'Pneumonia', 3, '2025-01-06', '2025-01-06', 'Shasani Nisansala', 764846394, 'Initial diagnosis pending', 'Admitted'),
(4, 'Fracture treatment', 5, '2025-01-06', '2025-01-06', 'Chamika Heshani', 752041657, 'Under observation', 'Admitted'),
(5, 'Post-surgery recovery', 8, '2025-01-06', '2025-01-15', 'Nigeeth Maleesha', 764846395, 'Rehabilitation required', 'Admitted'),
(6, 'Chronic pain management', 3, '2025-01-06', '2025-01-10', 'Binuri Umanda', 724869521, 'Pain management therapy', 'Admitted'),
(7, 'Maternity care', 7, '2025-01-06', '2025-01-30', 'Nethmi Chehani', 784592147, 'Delivery planned', 'Admitted'),
(8, 'Cardiac monitoring', 8, '2025-01-06', '2025-01-25', 'Udesh Lakshan', 712458796, 'High-risk patient', 'Admitted'),
(9, 'Post-operative care', 5, '2025-01-06', '2025-01-18', 'Nisansala Fernando', 785462137, 'Surgical recovery', 'Admitted'),
(10, 'Respiratory therapy', 3, '2025-01-06', '2025-01-12', 'Amasha Perera', 742158746, 'Oxygen therapy required', 'Admitted'),
(11, 'Urgent treatment for stroke', 2, '2025-01-06', '2025-01-14', 'Ramesh Bandara', 721459632, 'Neurological monitoring', 'Admitted'),
(12, 'Chronic illness management', 12, '2025-01-06', '2025-01-22', 'Sanduni Jayasinghe', 754589632, 'Long-term care required', 'Admitted'),
(13, 'Accident', 2, '2025-01-04', '2025-01-05', 'shasani Nisansala', 764846394, NULL, 'Admitted');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointmentid` int(11) NOT NULL,
  `patientName` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointmentDate` date NOT NULL,
  `appointmentTime` time NOT NULL,
  `contactNo` varchar(15) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointmentid`, `patientName`, `age`, `doctor_id`, `appointmentDate`, `appointmentTime`, `contactNo`, `status`, `created_at`) VALUES
(1, 'Shasani Nisansala', 21, 1, '2025-01-10', '10:00:00', '764846394', 'pending', '2025-01-05 07:30:00'),
(2, 'Chamika Heshani', 21, 2, '2025-01-11', '11:00:00', '0752041657', 'pending', '2025-01-05 07:45:00'),
(3, 'Nigeeth Maleesha', 21, 3, '2025-01-12', '12:00:00', '0764846395', 'pending', '2025-01-05 08:00:00'),
(4, 'Binuri Umanda', 21, 4, '2025-01-13', '13:00:00', '0724869521', 'pending', '2025-01-05 08:15:00'),
(5, 'Nethmi Chehani', 21, 5, '2025-01-14', '14:00:00', '784592147', 'pending', '2025-01-05 08:30:00'),
(6, 'Udesh Lakshan', 30, 1, '2025-01-15', '15:00:00', '0712458796', 'pending', '2025-01-05 08:45:00'),
(7, 'Nisansala Fernando', 37, 2, '2025-01-16', '16:00:00', '0785462137', 'pending', '2025-01-05 09:00:00'),
(8, 'Amasha Perera', 14, 3, '2025-01-17', '17:00:00', '0742158746', 'pending', '2025-01-05 09:15:00'),
(9, 'Ramesh Bandara', 24, 4, '2025-01-18', '18:00:00', '0721459632', 'pending', '2025-01-05 09:30:00'),
(10, 'Sanduni Jayasinghe', 49, 5, '2025-01-19', '19:00:00', '0754125896', 'pending', '2025-01-05 09:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `billID` int(11) NOT NULL,
  `patientid` int(11) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `address` varchar(30) NOT NULL,
  `contact` int(11) NOT NULL,
  `date` date NOT NULL,
  `grandTotal` double(10,2) NOT NULL,
  `paidAmount` double(10,2) NOT NULL,
  `dueAmount` double(10,2) NOT NULL,
  `balance` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`billID`, `patientid`, `firstName`, `lastName`, `address`, `contact`, `date`, `grandTotal`, `paidAmount`, `dueAmount`, `balance`) VALUES
(1, 1, 'Shasani', 'Nisansala', 'Angode', 764846394, '2025-01-05', 1000.00, 5000.00, 0.00, 4000.00),
(2, 2, 'chamika', 'Heshani', 'Rathmalana', 752041657, '2025-01-05', 1000.00, 500.00, 500.00, 0.00),
(3, 2, 'Chamika', 'Heshani', 'Rathmalana', 752041657, '2025-01-06', 3000.00, 2000.00, 1000.00, 0.00),
(4, 3, 'Nigeeth', 'Maleesha', 'Embilipitiya', 764846395, '2025-01-06', 4500.00, 4500.00, 0.00, 0.00),
(5, 5, 'Binuri', 'Umanda', 'Galle', 724869521, '2025-01-06', 500.00, 500.00, 0.00, 0.00),
(6, 6, 'Nethmi', 'Chehani', 'Wakwella', 784592147, '2025-01-06', 1200.00, 700.00, 500.00, 0.00),
(7, 7, 'Udesh', 'Lakshan', 'Kandy', 712458796, '2025-01-06', 6000.00, 4000.00, 2000.00, 0.00),
(8, 8, 'Nisansala', 'Fernando', 'Colombo', 785462137, '2025-01-06', 2500.00, 2500.00, 0.00, 0.00),
(9, 9, 'Amasha', 'Perera', 'Negombo', 742158746, '2025-01-06', 800.00, 800.00, 0.00, 0.00),
(10, 10, 'Ramesh', 'Bandara', 'Kurunegala', 721459632, '2025-01-06', 3400.00, 2000.00, 1400.00, 0.00),
(11, 11, 'Sanduni', 'Jayasinghe', 'Matara', 754125896, '2025-01-06', 12000.00, 10000.00, 2000.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `bill_items`
--

CREATE TABLE `bill_items` (
  `id` int(11) NOT NULL,
  `billID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `accountName` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `subtotal` double NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_items`
--

INSERT INTO `bill_items` (`id`, `billID`, `patientID`, `accountName`, `description`, `quantity`, `price`, `subtotal`, `time`) VALUES
(1, 1, 1, 'Consultation', 'diet', 1, 1000, 1000, '2025-01-05 18:15:55'),
(2, 2, 2, 'Labtest', 'blood', 1, 1000, 1000, '2025-01-05 18:17:02'),
(3, 3, 2, 'Consultation', 'General consultation fee', 1, 3000, 3000, '2025-01-06 00:46:03'),
(4, 4, 3, 'Medication', 'Antibiotics', 2, 1500, 3000, '2025-01-06 00:46:03'),
(5, 5, 5, 'Labtest', 'Complete blood test', 1, 4500, 4500, '2025-01-06 00:46:03'),
(6, 6, 6, 'Consultation', 'Follow-up consultation', 1, 500, 500, '2025-01-06 00:46:03'),
(7, 7, 7, 'Medication', 'Pain relievers', 3, 400, 1200, '2025-01-06 00:46:03'),
(8, 8, 8, 'Labtest', 'X-ray', 1, 6000, 6000, '2025-01-06 00:46:03'),
(9, 9, 9, 'Consultation', 'Dermatology consultation', 1, 2500, 2500, '2025-01-06 00:46:03'),
(10, 10, 10, 'Medication', 'Cough syrup', 4, 200, 800, '2025-01-06 00:46:03'),
(11, 11, 11, 'Labtest', 'MRI scan', 1, 3400, 3400, '2025-01-06 00:46:03'),
(12, 11, 11, 'Consultation', 'Cardiology check-up', 1, 12000, 12000, '2025-01-06 00:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `budget_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `starting_date` date NOT NULL,
  `ending_date` date NOT NULL,
  `allocated_expenses` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget`
--

INSERT INTO `budget` (`budget_id`, `description`, `amount`, `starting_date`, `ending_date`, `allocated_expenses`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Quarter 1 Office Supplies', 5000.00, '2024-01-01', '2024-03-31', 3000.00, 'Active', '2024-01-01 02:30:00', '2024-01-01 02:30:00'),
(2, 'Quarter 1 Marketing Campaign', 12000.00, '2024-01-01', '2024-03-31', 8000.00, 'Active', '2024-01-01 02:35:00', '2024-01-01 02:35:00'),
(3, 'Employee Training Program', 15000.00, '2024-01-15', '2024-02-15', 5000.00, 'Completed', '2024-01-10 03:30:00', '2024-02-20 12:00:00'),
(4, 'System Upgrade Project', 20000.00, '2024-02-01', '2024-06-01', 12000.00, 'Active', '2024-02-01 04:30:00', '2024-02-01 04:30:00'),
(5, 'Quarter 2 Office Supplies', 6000.00, '2024-04-01', '2024-06-30', 0.00, 'Pending', '2024-03-15 03:00:00', '2024-03-15 03:00:00'),
(6, 'Research and Development', 50000.00, '2024-01-10', '2024-12-31', 15000.00, 'Active', '2024-01-10 03:15:00', '2024-01-10 03:15:00'),
(7, 'Annual Maintenance Services', 30000.00, '2024-01-01', '2024-12-31', 10000.00, 'Active', '2024-01-05 05:30:00', '2024-01-05 05:30:00'),
(8, 'Quarter 1 IT Infrastructure', 25000.00, '2024-01-01', '2024-03-31', 15000.00, 'Completed', '2024-01-01 04:45:00', '2024-03-30 08:30:00'),
(9, 'Healthcare Initiatives', 8000.00, '2024-03-01', '2024-05-31', 3000.00, 'Active', '2024-02-28 03:45:00', '2024-02-28 03:45:00'),
(10, 'Staff Welfare Program', 7000.00, '2024-02-10', '2024-04-10', 5000.00, 'Completed', '2024-02-05 06:30:00', '2024-04-12 11:00:00'),
(11, 'Software License Renewals', 15000.00, '2024-03-01', '2024-03-31', 0.00, 'Pending', '2024-02-25 08:30:00', '2024-02-25 08:30:00'),
(12, 'Employee Bonuses', 45000.00, '2024-12-01', '2024-12-31', 0.00, 'Pending', '2024-11-20 02:30:00', '2024-11-20 02:30:00'),
(13, 'Corporate Social Responsibility', 12000.00, '2024-04-01', '2024-06-30', 5000.00, 'Active', '2024-03-25 04:30:00', '2024-03-25 04:30:00'),
(14, 'Building Renovation', 75000.00, '2024-05-01', '2024-08-31', 25000.00, 'Active', '2024-04-15 06:00:00', '2024-04-15 06:00:00'),
(15, 'Security Upgrades', 20000.00, '2024-06-01', '2024-07-31', 5000.00, 'Pending', '2024-05-20 10:15:00', '2024-05-20 10:15:00'),
(16, 'Employee Health Insurance', 100000.00, '2024-01-01', '2024-12-31', 50000.00, 'Active', '2024-01-01 02:00:00', '2024-01-01 02:00:00'),
(17, 'Annual General Meeting', 25000.00, '2024-12-01', '2024-12-02', 15000.00, 'Pending', '2024-11-15 04:30:00', '2024-11-15 04:30:00'),
(18, 'Marketing Research Project', 18000.00, '2024-03-01', '2024-05-31', 12000.00, 'Completed', '2024-02-20 04:15:00', '2024-05-30 11:30:00'),
(19, 'Quarter 3 Office Supplies', 6500.00, '2024-07-01', '2024-09-30', 0.00, 'Pending', '2024-06-20 09:00:00', '2024-06-20 09:00:00'),
(20, 'New Product Launch', 90000.00, '2024-04-15', '2024-06-30', 60000.00, 'Active', '2024-04-10 03:30:00', '2024-04-10 03:30:00'),
(21, 'Corporate Training Initiative', 30000.00, '2024-09-01', '2024-10-31', 20000.00, 'Pending', '2024-08-15 06:00:00', '2024-08-15 06:00:00'),
(22, 'Quarter 4 Office Supplies', 7000.00, '2024-10-01', '2024-12-31', 0.00, 'Pending', '2024-09-15 07:30:00', '2024-09-15 07:30:00'),
(23, 'International Business Conference', 60000.00, '2024-11-01', '2024-11-07', 45000.00, 'Pending', '2024-10-10 07:15:00', '2024-10-10 07:15:00'),
(24, 'Technology Research', 80000.00, '2024-05-01', '2024-12-31', 30000.00, 'Active', '2024-04-30 04:45:00', '2024-04-30 04:45:00'),
(25, 'Community Outreach Program', 15000.00, '2024-08-01', '2024-10-31', 10000.00, 'Active', '2024-07-15 08:30:00', '2024-07-15 08:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `budget_reports`
--

CREATE TABLE `budget_reports` (
  `id` int(11) NOT NULL,
  `budget_id` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `starting_date` date NOT NULL,
  `allocated_expenses` decimal(10,2) NOT NULL,
  `remaining_amount` decimal(10,2) GENERATED ALWAYS AS (`amount` - `allocated_expenses`) VIRTUAL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `budget_reports`
--

INSERT INTO `budget_reports` (`id`, `budget_id`, `amount`, `description`, `status`, `starting_date`, `allocated_expenses`, `created_at`, `updated_at`) VALUES
(1, 'BUD001', 5000.00, 'Purchase of hospital beds', 'active', '2025-01-01', 1500.00, '2025-01-05 10:08:44', '2025-01-05 10:08:44'),
(2, 'BUD002', 10000.00, 'Renovation of ICU unit', 'pending', '2025-02-15', 2000.00, '2025-01-05 10:08:44', '2025-01-05 10:08:44'),
(3, 'BUD003', 7500.00, 'Purchase of X-ray machine', 'active', '2025-03-01', 5000.00, '2025-01-05 10:08:44', '2025-01-05 10:08:44'),
(4, 'BUD004', 12000.00, 'Expansion of outpatient department', 'approved', '2025-01-20', 3000.00, '2025-01-05 10:08:44', '2025-01-05 10:08:44'),
(5, 'BUD005', 8500.00, 'Installation of new software system', 'rejected', '2025-02-10', 0.00, '2025-01-05 10:08:44', '2025-01-05 10:08:44'),
(6, 'BUD006', 4500.00, 'Maintenance and repairs', 'active', '2025-01-30', 1000.00, '2025-01-05 10:08:44', '2025-01-05 10:08:44'),
(7, 'BUD007', 3000.00, 'Procurement of medical supplies', 'pending', '2025-03-05', 500.00, '2025-01-05 10:08:44', '2025-01-05 10:08:44'),
(8, 'BUD008', 20000.00, 'Construction of new wing', 'approved', '2025-01-01', 10000.00, '2025-01-05 10:08:44', '2025-01-05 10:08:44'),
(9, 'b123', 1000000.00, 'vvvvvvvvvvvvvvvvvv', 'Pending', '2025-01-14', 100000.00, '2025-01-05 10:10:09', '2025-01-05 10:10:27'),
(10, 'b1235', 1000000.00, 'ddddddddddddddd', 'Pending', '2025-01-14', 500000.00, '2025-01-05 10:10:57', '2025-01-05 13:34:02');

-- --------------------------------------------------------

--
-- Table structure for table `cashiers`
--

CREATE TABLE `cashiers` (
  `cashier_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `cashier_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cashiers`
--

INSERT INTO `cashiers` (`cashier_id`, `staff_id`, `cashier_name`, `email`, `specialization`, `phone`) VALUES
(1, 2, 'Dilmi', 'd@gmail.com', 'Specialist', '720357717'),
(2, 21, 'Malsha', 'nm@gmail.com', '2 Years Experience', '764842394');

-- --------------------------------------------------------

--
-- Table structure for table `credit_table`
--

CREATE TABLE `credit_table` (
  `c_id` int(11) NOT NULL,
  `billID` varchar(50) NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `expiry_date` date NOT NULL,
  `cvv` varchar(4) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `debit_table`
--

CREATE TABLE `debit_table` (
  `d_id` int(11) NOT NULL,
  `billID` varchar(50) NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `expiry_date` date NOT NULL,
  `cvv` varchar(4) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doctor_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `doctor_name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `specialization` varchar(50) NOT NULL,
  `phone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctor_id`, `staff_id`, `doctor_name`, `email`, `specialization`, `phone`) VALUES
(1, 6, 'samadi', 'do@gmail.com', 'MMBA UOC', 758084150),
(2, 11, 'Maleesha', 'nm@gmail.com', 'specialist', 764846395),
(3, 12, 'Nisansala', 'ni@gmail.com', 'Children specialist', 756981352),
(4, 17, 'Dishan Keminda', 'dk@gmail.com', 'Mental specialization', 724586594),
(5, 25, 'Suman', 'su@gmail.com', 'special', 764846300);

-- --------------------------------------------------------

--
-- Table structure for table `drugs`
--

CREATE TABLE `drugs` (
  `drug_id` int(11) NOT NULL,
  `drug_name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `dosage_form` varchar(100) NOT NULL,
  `dosage` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drugs`
--

INSERT INTO `drugs` (`drug_id`, `drug_name`, `category`, `dosage_form`, `dosage`, `created_at`) VALUES
(1, 'penadol', 'Pain Relievers', 'Tablet', '500mg', '2024-12-29 09:14:01'),
(2, 'penadol', 'Pain Relievers', 'Tablet', '500mg', '2024-12-29 09:14:01'),
(3, 'paracetamol', 'Pain Relievers', 'Tablet', '650mg', '2024-12-29 09:30:00'),
(4, 'amoxicillin', 'Antibiotics', 'Capsule', '250mg', '2024-12-29 09:45:00'),
(5, 'lisinopril', 'Antihypertensives', 'Tablet', '10mg', '2024-12-29 10:00:00'),
(6, 'metformin', 'Diabetes Medications', 'Tablet', '500mg', '2024-12-29 10:15:00'),
(7, 'Ciprofloxacin', 'Antibiotics', 'Tablet', '500mg', '2025-01-05 02:01:03'),
(8, 'ibuprofen', 'Pain Relievers', 'Syrup', '200mg', '2024-12-29 10:30:00'),
(9, 'loratadine', 'Antihistamines', 'Suspension', '10mg', '2024-12-29 10:45:00'),
(10, 'omeprazole', 'Gastrointestinal', 'Injection', '20mg', '2024-12-29 11:00:00'),
(11, 'cetirizine', 'Antihistamines', 'Tablet', '10mg', '2024-12-29 11:15:00'),
(12, 'prednisolone', 'Anti-inflammatory', 'Syrup', '5mg', '2024-12-29 11:30:00'),
(13, 'hydrochlorothiazide', 'Antihypertensives', 'Tablet', '25mg', '2024-12-29 11:45:00'),
(14, 'paracetamol', 'Pain Relievers', 'Suspension', '250mg', '2024-12-29 12:00:00'),
(15, 'diphenhydramine', 'Antihistamines', 'Capsule', '25mg', '2024-12-29 12:15:00'),
(16, 'salbutamol', 'Bronchodilators', 'Inhaler', '100mcg', '2024-12-29 12:30:00'),
(17, 'clindamycin', 'Antibiotics', 'Capsule', '300mg', '2024-12-29 12:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `drug_orders`
--

CREATE TABLE `drug_orders` (
  `id` int(11) NOT NULL,
  `drug_name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `dosage_form` varchar(100) NOT NULL,
  `urgency` varchar(50) NOT NULL,
  `request_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `decline_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drug_orders`
--

INSERT INTO `drug_orders` (`id`, `drug_name`, `category`, `quantity`, `dosage_form`, `urgency`, `request_date`, `notes`, `status`, `decline_reason`) VALUES
(1, 'penadol', 'Pain Relievers', 100, 'Tablet', 'Low', '2024-12-30', '', 'Approved', NULL),
(2, 'amoxiline', 'Pain Relievers', 200, 'Capsule', 'Medium', '2024-12-31', '', 'Declined', 'low stock'),
(3, 'Ciprofloxacin', 'Antibiotics', 500, 'Tablet', 'Medium', '2025-01-05', '', 'Declined', 'low stock'),
(4, 'cetirizine', 'Other', 100, 'Capsule', 'Medium', '2025-01-07', '', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `drug_stock`
--

CREATE TABLE `drug_stock` (
  `stock_id` int(11) NOT NULL,
  `drug_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `dosage_form` varchar(255) NOT NULL,
  `dosage` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `stock_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drug_stock`
--

INSERT INTO `drug_stock` (`stock_id`, `drug_name`, `category`, `dosage_form`, `dosage`, `quantity`, `stock_date`, `expiry_date`, `created_at`) VALUES
(1, 'penadol', 'Pain Relievers', 'Tablet', '500mg', 1500, '2025-01-05', '2025-02-13', '2024-12-29 14:19:02'),
(2, 'amoxiline', 'Antibiotics', 'Capsule', '250mg', 200, '2024-12-29', '2025-02-12', '2024-12-29 14:24:35'),
(3, 'Ciprofloxacin', 'Antibiotics', 'Tablet', '500mg', 500, '2025-01-05', '2025-02-03', '2025-01-05 01:59:28'),
(4, 'loratadine', 'Antihistamines', 'Suspension', '10mg', 150, '2024-12-29', '2026-12-29', '2024-12-29 10:45:00'),
(5, 'omeprazole', 'Gastrointestinal', 'Injection', '20mg', 80, '2024-12-29', '2026-12-29', '2024-12-29 11:00:00'),
(6, 'cetirizine', 'Antihistamines', 'Tablet', '10mg', 200, '2024-12-29', '2025-12-29', '2024-12-29 11:15:00'),
(7, 'prednisolone', 'Anti-inflammatory', 'Syrup', '5mg', 120, '2024-12-29', '2025-12-29', '2024-12-29 11:30:00'),
(8, 'hydrochlorothiazide', 'Antihypertensives', 'Tablet', '25mg', 90, '2024-12-29', '2026-12-29', '2024-12-29 11:45:00'),
(9, 'paracetamol', 'Pain Relievers', 'Suspension', '250mg', 300, '2024-12-29', '2025-12-29', '2024-12-29 12:00:00'),
(10, 'diphenhydramine', 'Antihistamines', 'Capsule', '25mg', 150, '2024-12-29', '2026-12-29', '2024-12-29 12:15:00'),
(11, 'salbutamol', 'Bronchodilators', 'Inhaler', '100mcg', 200, '2024-12-29', '2026-12-29', '2024-12-29 12:30:00'),
(12, 'clindamycin', 'Antibiotics', 'Capsule', '300mg', 50, '2024-12-29', '2025-12-29', '2024-12-29 12:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `message`) VALUES
(1, 'shasani', 'm@gmail.com', 'esdrtfgyhuijo'),
(2, 'shasani', 'm@gmail.com', 'esdrtfgyhuijo'),
(3, 'Maleesha', 'm@gmail.com', 'ASD');

-- --------------------------------------------------------

--
-- Table structure for table `finance_manager`
--

CREATE TABLE `finance_manager` (
  `financemanager_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `financemanager_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finance_manager`
--

INSERT INTO `finance_manager` (`financemanager_id`, `staff_id`, `financemanager_name`, `email`, `specialization`, `phone`) VALUES
(1, 8, 'Dumindu', 'fm@gmail.com', 'CIMP Certificate', '745894856');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_manager`
--

CREATE TABLE `inventory_manager` (
  `inventorymanager_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `inventorymanager_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_manager`
--

INSERT INTO `inventory_manager` (`inventorymanager_id`, `staff_id`, `inventorymanager_name`, `email`, `specialization`, `phone`) VALUES
(1, 4, 'Masanda', 'im@gmail.com', 'BBA UOR', '742156894');

-- --------------------------------------------------------

--
-- Table structure for table `lab_requests`
--

CREATE TABLE `lab_requests` (
  `request_id` int(11) NOT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `contact` int(20) DEFAULT NULL,
  `test_type` varchar(255) DEFAULT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_requests`
--

INSERT INTO `lab_requests` (`request_id`, `patient_name`, `contact`, `test_type`, `request_date`, `status`) VALUES
(1, 'shasani Nisansala', 764846394, 'Blood Test', '2024-12-22 08:23:50', 'Accepted'),
(2, 'shasani Nisansala', 764846394, 'CT Scan', '2025-01-04 19:45:18', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `lab_supplies_request`
--

CREATE TABLE `lab_supplies_request` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `urgency` varchar(20) NOT NULL,
  `notes` text DEFAULT NULL,
  `request_date` date NOT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `decline_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_supplies_request`
--

INSERT INTO `lab_supplies_request` (`id`, `item_name`, `category`, `quantity`, `urgency`, `notes`, `request_date`, `status`, `decline_reason`) VALUES
(1, 'Ctrizen', 'Reagents', 2, 'Low', 'ABC', '2024-12-29', 'Approved', NULL),
(2, 'Ctrizen', 'Reagents', 2, 'Low', 'ABC', '2024-12-30', 'Declined', 'low stock'),
(3, 'Test Tubes', 'Equipment', 50, 'Low', '', '2024-12-31', 'Declined', 'low stock'),
(4, 'microscope', 'Equipment', 3, 'Medium', '', '2024-12-31', 'Pending', NULL),
(5, 'syringe', 'Equipment', 2, 'Medium', '', '2025-01-04', 'Pending', NULL),
(6, 'cottons', 'Consumables', 100, 'High', '', '2025-01-05', 'Approved', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lab_test_results`
--

CREATE TABLE `lab_test_results` (
  `id` int(11) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `patientName` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `testType` varchar(50) NOT NULL,
  `filePath` varchar(255) DEFAULT NULL,
  `testDate` date DEFAULT NULL,
  `resultDetails` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_test_results`
--

INSERT INTO `lab_test_results` (`id`, `mail`, `patientName`, `contact`, `testType`, `filePath`, `testDate`, `resultDetails`, `created_at`) VALUES
(1, 'm@gmail.com', 'shasani Nisansala', '764846394', 'Blood Test', 'uploads/Blood Test Report.docx', '2024-12-28', '', '2024-12-28 04:09:19'),
(2, 'm@gmail.com', 'shasani Nisansala', '764846394', 'Blood Test', 'uploads/Blood Test Report.docx', NULL, NULL, '2024-12-28 04:12:45'),
(3, 'm@gmail.com', 'shasani Nisansala', '764846394', 'MRI', NULL, '2024-12-30', 'Normal ', '2024-12-30 05:03:06'),
(4, 'chami@gmail.com', 'Chamika Heshani', '0752041657', 'Blood Test', NULL, '2025-01-05', 'Normal', '2025-01-05 02:09:36');

-- --------------------------------------------------------

--
-- Table structure for table `mlt`
--

CREATE TABLE `mlt` (
  `mlt_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `mlt_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mlt`
--

INSERT INTO `mlt` (`mlt_id`, `staff_id`, `mlt_name`, `email`, `specialization`, `phone`) VALUES
(1, 9, 'Nigeeth', 'mlt@gmail.com', 'Diploma in MLT', '758946122'),
(2, 24, 'Gunawardhane', 'g@gmail.com', 'Special', '724896542');

-- --------------------------------------------------------

--
-- Table structure for table `nurses`
--

CREATE TABLE `nurses` (
  `nurse_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `nurse_name` varchar(100) NOT NULL,
  `email` varchar(20) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `phone` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nurses`
--

INSERT INTO `nurses` (`nurse_id`, `staff_id`, `nurse_name`, `email`, `specialization`, `phone`) VALUES
(1, 1, 'Shasani', 's@gmail.com', 'NVQ 5', 764846394),
(2, 14, 'Nethmi', 'nm@gmail.com', 'NVQ L4', 784589362),
(3, 16, 'Chehani', 'ch@gmail.com', 'NVQ L4', 784589400),
(4, 18, 'Keminda', 'k@gmail.com', 'UOP Nursing', 764846394),
(5, 19, 'Uvindu', 'u@gmail.com', 'NVQ 4', 764846924),
(6, 23, 'Gunasinghe', 'gs@gmail.com', 'NVQ 5', 754555481);

-- --------------------------------------------------------

--
-- Table structure for table `nurse_tasks`
--

CREATE TABLE `nurse_tasks` (
  `task_id` int(11) NOT NULL,
  `task_description` text NOT NULL,
  `nurse_id` int(11) DEFAULT NULL,
  `task_date` date NOT NULL,
  `task_time` time NOT NULL,
  `assigned_by` int(11) DEFAULT NULL,
  `doctor_name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nurse_tasks`
--

INSERT INTO `nurse_tasks` (`task_id`, `task_description`, `nurse_id`, `task_date`, `task_time`, `assigned_by`, `doctor_name`) VALUES
(1, 'Monitor patient vitals', 1, '2025-01-06', '18:58:00', 6, 'samadi'),
(2, 'Provide wound care', 2, '2025-01-06', '07:00:00', 6, 'samadi');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `status` enum('Pending','Accepted','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `supplier_id`, `item_name`, `quantity`, `order_date`, `status`) VALUES
(1, 1, 'sissors', 100, '2025-01-05', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `firstName`, `lastName`, `dob`, `age`, `gender`, `nic`, `address`, `contact`) VALUES
(1, 'Shasani', 'Nisansala', '2003-02-24', 21, 'Female', '200355513584', 'Angode', '764846394'),
(2, 'chamika', 'Heshani', '2003-04-07', 21, 'Female', '200351213574', 'Rathmalana', '0752041657'),
(3, 'Nigeeth', 'Maleesha', '2003-08-06', 21, 'Male', '200321911531', 'Embilipitiya', '0764846395'),
(5, 'Binuri', 'Umanda', '2003-01-03', 21, 'Female', '20034548965', 'Galle', '0724869521'),
(6, 'Nethmi', 'Chehani', '2003-06-04', 21, 'Female', '20034595214', 'Wakwella', '784592147'),
(7, 'Udesh', 'Lakshan', '1995-03-11', 30, 'Male', '9535471234V', 'Kandy', '0712458796'),
(8, 'Nisansala', 'Fernando', '1988-05-08', 37, 'Female', '885987412V', 'Colombo', '0785462137'),
(9, 'Amasha', 'Perera', '2010-10-15', 14, 'Female', '1016741256V', 'Negombo', '0742158746'),
(10, 'Ramesh', 'Bandara', '2000-07-02', 24, 'Male', '0031245879V', 'Kurunegala', '0721459632'),
(11, 'Sanduni', 'Jayasinghe', '1975-09-09', 49, 'Female', '7545879632V', 'Matara', '0754125896'),
(12, 'Kasun', 'Wickramasinghe', '1965-12-01', 59, 'Male', '6539874125V', 'Kalutara', '0762145879'),
(13, 'Chamodi', 'Silva', '2007-11-19', 17, 'Female', '0735698412V', 'Gampaha', '0712458963'),
(14, 'Praveen', 'Weerasinghe', '1993-01-15', 32, 'Male', '9335478962V', 'Ja-Ela', '0763245879'),
(15, 'Harini', 'Pathirana', '2005-06-18', 19, 'Female', '0536874521V', 'Panadura', '0784123658'),
(16, 'Supun', 'Kumara', '1997-04-22', 27, 'Male', '9735784692V', 'Nuwara Eliya', '0754692138'),
(17, 'Dilini', 'Ranasinghe', '1985-08-25', 39, 'Female', '8535987415V', 'Ratnapura', '0724567892'),
(18, 'Malinda', 'Hettiarachchi', '2002-05-30', 22, 'Male', '0235647812V', 'Hambantota', '0765148963'),
(19, 'Ruwani', 'Kavindi', '2011-07-14', 13, 'Female', '115987456V', 'Veyangoda', '0712459687'),
(20, 'Kalana', 'Mendis', '1978-02-20', 46, 'Male', '7835648792V', 'Piliyandala', '0789632541'),
(21, 'Hiruni', 'Jayawardana', '1999-03-10', 25, 'Female', '9935748965V', 'Maharagama', '0765148963'),
(22, 'Asela', 'De Silva', '1968-01-25', 56, 'Male', '6835987413V', 'Anuradhapura', '0742159874'),
(23, 'Tharushi', 'Gunasekara', '2012-11-05', 12, 'Female', '1258741298V', 'Polonnaruwa', '0784125632'),
(24, 'Naveen', 'Liyanage', '1989-09-21', 35, 'Male', '8935487912V', 'Badulla', '0712458963'),
(25, 'Iresha', 'Kumari', '2004-04-11', 20, 'Female', '0435798456V', 'Chilaw', '0754589621'),
(26, 'Manjula', 'Wijesinghe', '1992-08-13', 32, 'Male', '9235648795V', 'Kegalle', '0724567896'),
(27, 'Sandali', 'Madushani', '2014-06-19', 10, 'Female', '1458974129V', 'Hatton', '0762458963'),
(28, 'Thilina', 'Ekanayake', '1983-05-04', 41, 'Male', '8335784691V', 'Matale', '0745124789'),
(29, 'Rashmi', 'Samarasekara', '1990-07-17', 34, 'Female', '9035987458V', 'Avissawella', '0782143659'),
(30, 'Sahan', 'Dias', '1998-02-08', 26, 'Male', '9835647895V', 'Wattala', '0754698752'),
(31, 'Chathura', 'Kumara', '2006-11-14', 18, 'Male', '0654789125V', 'Homagama', '0774589632'),
(32, 'Shasani', 'ishara', '2025-01-08', 0, 'Female', '200253902810', 'colombo', '02245689753');

-- --------------------------------------------------------

--
-- Table structure for table `patientprofile`
--

CREATE TABLE `patientprofile` (
  `id` int(11) NOT NULL,
  `reg_id` int(11) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `age` int(3) NOT NULL,
  `dob` date NOT NULL,
  `nic` varchar(12) NOT NULL,
  `contact` int(12) NOT NULL,
  `address` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  `special_notes` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patientprofile`
--

INSERT INTO `patientprofile` (`id`, `reg_id`, `firstname`, `lastname`, `gender`, `age`, `dob`, `nic`, `contact`, `address`, `email`, `password`, `special_notes`) VALUES
(1, 7, 'Udesh', 'Lakshan', 'Male', 30, '1995-03-11', '9535471234V', 712458796, 'Kandy', 'udesh@mail.com', 'udesh2025', 'No allergies'),
(2, 12, 'Kasun', 'Wickramasinghe', 'Male', 59, '1965-12-01', '6539874125V', 762145879, 'Kalutara', 'kasun@mail.com', 'kasunkal65', 'Heart condition'),
(3, 9, 'Amasha', 'Perera', 'Female', 14, '2010-10-15', '1016741256V', 742158746, 'Negombo', 'amasha@mail.com', 'amasha1010', 'Asthma history'),
(4, 21, 'Kusal', 'Fernando', 'Male', 29, '1994-10-12', '9412759632V', 772145632, 'Colombo', 'kusal@mail.com', 'kfer94co', 'No allergies'),
(5, 8, 'Nisansala', 'Fernando', 'Female', 37, '1988-05-08', '885987412V', 785462137, 'Colombo', 'nisansala@mail.com', 'nfernando8', 'Diabetic'),
(6, 15, 'Harini', 'Pathirana', 'Female', 19, '2005-06-18', '0536874521V', 784123658, 'Panadura', 'harini@mail.com', 'harini0618', 'Seasonal allergies'),
(7, 13, 'Chamodi', 'Silva', 'Female', 17, '2007-11-19', '0735698412V', 712458963, 'Gampaha', 'chamodi@mail.com', 'csilva0719', 'No special notes'),
(8, 16, 'Supun', 'Kumara', 'Male', 27, '1997-04-22', '9735785421V', 745123659, 'Galle', 'supun@mail.com', 'supunk97gl', 'No special notes'),
(9, 20, 'Madhavi', 'Peiris', 'Female', 26, '1998-05-15', '9812476325V', 754879632, 'Batticaloa', 'peiris@mail.com', 'mpeiris199', 'Allergy to penicillin'),
(10, 10, 'Ramesh', 'Bandara', 'Male', 24, '2000-07-02', '0031245879V', 721459632, 'Kurunegala', 'ramesh@mail.com', 'rb200007', 'Regular checkups needed'),
(11, 14, 'Praveen', 'Weerasinghe', 'Male', 32, '1993-01-15', '9335478962V', 763245879, 'Ja-Ela', 'praveen@mail.com', 'praveenja9', 'Requires medication'),
(12, 17, 'Binura', 'Hettiarachchi', 'Male', 45, '1979-12-15', '7912458631V', 762158745, 'Hambantota', 'binura@mail.com', 'bhet1979', 'High cholesterol'),
(13, 18, 'Malini', 'Ranasinghe', 'Female', 54, '1969-08-11', '6912458632V', 773654879, 'Kalutara', 'malini@mail.com', 'malini1969', 'Hypertension'),
(14, 19, 'Nimal', 'Rathnayake', 'Male', 36, '1987-03-20', '8712568471V', 712365987, 'Nuwara Eliya', 'nimal@mail.com', 'nimalne87', 'Regular medication'),
(15, 11, 'Sanduni', 'Jayasinghe', 'Female', 49, '1975-09-09', '7545879632V', 754125896, 'Matara', 'sanduni@mail.com', 'sjmatara75', 'Hypertension'),
(16, 1, 'Shasani', 'Nisansala', 'Female', 21, '2003-02-24', '200355513574', 764846394, 'Angoda', 'm@gmail.com', 'm1234', 'Mental Problem'),
(17, 2, 'chamika', 'Heshani', 'Female', 21, '2003-04-07', '200351213574', 752041657, 'Rathmalana', 'chami@gmail.com', 'cha123', 'Weak ');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `billID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `paymentType` enum('Debit','Credit','Paypal') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paymentDate` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paypal_table`
--

CREATE TABLE `paypal_table` (
  `p_id` int(11) NOT NULL,
  `billID` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `verification_code` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pharmacist`
--

CREATE TABLE `pharmacist` (
  `pharmacist_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `pharmacist_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pharmacist`
--

INSERT INTO `pharmacist` (`pharmacist_id`, `staff_id`, `pharmacist_name`, `email`, `specialization`, `phone`) VALUES
(1, 7, 'Amani', 'p@gmail.com', '1 Year Experience', '75416578'),
(2, 20, 'Maleesha', 'tm@gmail.com', 'Training Student', '764846350');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `id` int(11) NOT NULL,
  `contact_no` int(12) NOT NULL,
  `patient_name` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `diagnosis` varchar(100) NOT NULL,
  `additional_notes` varchar(100) NOT NULL,
  `drugs` varchar(20) NOT NULL,
  `dosages` varchar(15) NOT NULL,
  `durations` varchar(100) NOT NULL,
  `instructions` text NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `diagnosis` text NOT NULL,
  `additional_notes` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `contact_no`, `patient_name`, `date`, `diagnosis`, `additional_notes`, `status`) VALUES
(1, '764846394', 'Shasani', '2025-01-05', 'Fever', 'meet me after 3 days', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `prescription_drugs`
--

CREATE TABLE `prescription_drugs` (
  `id` int(11) NOT NULL,
  `prescription_id` int(11) NOT NULL,
  `drug_name` varchar(100) NOT NULL,
  `dosage` varchar(50) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `instructions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription_drugs`
--

INSERT INTO `prescription_drugs` (`id`, `prescription_id`, `drug_name`, `dosage`, `duration`, `instructions`) VALUES
(1, 1, 'penadol', '15mg', '6 hours', '1 1/2'),
(2, 1, 'amoxicillin', '10mg', 'day night', '1');

-- --------------------------------------------------------

--
-- Table structure for table `progressnotes`
--

CREATE TABLE `progressnotes` (
  `progressNId` int(11) NOT NULL,
  `patientName` varchar(30) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(30) NOT NULL,
  `contactNo` int(11) NOT NULL,
  `c_complaint` varchar(100) NOT NULL,
  `assessment` varchar(100) NOT NULL,
  `plan` varchar(100) NOT NULL,
  `diagnosis` varchar(100) NOT NULL,
  `staffid` int(11) NOT NULL,
  `staffName` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progressnotes`
--

INSERT INTO `progressnotes` (`progressNId`, `patientName`, `dob`, `email`, `contactNo`, `c_complaint`, `assessment`, `plan`, `diagnosis`, `staffid`, `staffName`, `date`, `time`) VALUES
(1, 'shasani', '2024-12-21', 'm@gmail.com', 764846394, 'fever has increased', 'take rest', 'medication', 'fever', 1, 'shasani', '2024-12-21', '2025-01-04 23:52:03'),
(2, 'Nigeeth Maleesha', '2003-08-06', 'nm@gmail.com', 764846395, 'Dengui Fever', 'Rest Gave Medications regulerly', 'check blood test for each day', 'Dengui Fever', 1, 'shasani', '2025-01-05', '2025-01-04 23:47:16');

-- --------------------------------------------------------

--
-- Table structure for table `receptionists`
--

CREATE TABLE `receptionists` (
  `receptionist_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `receptionist_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receptionists`
--

INSERT INTO `receptionists` (`receptionist_id`, `staff_id`, `receptionist_name`, `email`, `specialization`, `phone`) VALUES
(1, 5, 'Supun', 'r@gmail.com', '2 Years Experience', '785462147');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_no` int(11) NOT NULL,
  `department` varchar(20) NOT NULL,
  `room_type` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_no`, `department`, `room_type`, `status`) VALUES
(1, 'Eye', 'Private', 'Not Available'),
(2, 'Inward Room', 'Private', 'Available'),
(3, 'Inward Room', 'General', 'Available'),
(3, 'OPD', 'General', 'Available'),
(4, 'ETU', 'ICU', 'Not Available'),
(5, 'Dental', 'Private', 'Available'),
(6, 'Eye', 'General', 'Not Available'),
(7, 'Cosmetic Center', 'Private', 'Available'),
(8, 'Inward Room', 'ICU', 'Available'),
(9, 'OPD', 'Private', 'Not Available'),
(10, 'ETU', 'General', 'Available'),
(11, 'Dental', 'ICU', 'Not Available'),
(12, 'Cosmetic Center', 'General', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(50) NOT NULL,
  `staff_name` varchar(100) NOT NULL,
  `salary_method` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `ot_rate` decimal(10,2) NOT NULL,
  `ot_hours` int(11) NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `salary_date` date NOT NULL,
  `net_salary` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`id`, `staff_id`, `staff_name`, `salary_method`, `department`, `ot_rate`, `ot_hours`, `basic_salary`, `salary_date`, `net_salary`, `created_at`, `updated_at`) VALUES
(4, '1', 'Shasani', 'Bank Transfer', 'medical', 2.00, 10, 75000.00, '2025-01-10', 75020, '2025-01-05 04:49:02', '2025-01-05 05:11:44'),
(5, '2', 'Dilmi', 'Cash', 'Administrative Finance', 100.00, 4, 45000.00, '2025-01-06', 45400, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(6, '3', 'Chami', 'Cheque', 'Administrative HR', 120.00, 6, 60000.00, '2025-01-06', 60720, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(7, '4', 'Masanda', 'Bank Transfer', 'Administrative Finance', 130.00, 3, 52000.00, '2025-01-06', 52390, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(8, '5', 'Supun', 'Cash', 'Other', 110.00, 2, 40000.00, '2025-01-06', 40220, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(9, '6', 'Samadi', 'Bank Transfer', 'Medical', 200.00, 4, 70000.00, '2025-01-06', 70800, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(10, '7', 'Amani', 'Cheque', 'Medical', 90.00, 5, 48000.00, '2025-01-06', 48450, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(11, '8', 'Dumindu', 'Bank Transfer', 'Administrative Finance', 160.00, 7, 75000.00, '2025-01-06', 76120, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(12, '9', 'Nigeeth', 'Cash', 'Medical', 140.00, 4, 62000.00, '2025-01-06', 62560, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(13, '11', 'Maleesha', 'Cheque', 'Medical', 250.00, 3, 82000.00, '2025-01-06', 82750, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(14, '12', 'Nisansala', 'Bank Transfer', 'Medical', 180.00, 6, 57000.00, '2025-01-06', 58080, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(15, '14', 'Nethmi', 'Cash', 'Medical', 150.00, 5, 52000.00, '2025-01-06', 52750, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(16, '16', 'Chehani', 'Bank Transfer', 'Medical', 130.00, 4, 48000.00, '2025-01-06', 48520, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(17, '17', 'Dishan', 'Cheque', 'Medical', 210.00, 5, 64000.00, '2025-01-06', 65050, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(18, '18', 'Keminda', 'Bank Transfer', 'Medical', 140.00, 4, 51000.00, '2025-01-06', 51560, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(19, '19', 'Uvindu', 'Cash', 'Medical', 125.00, 2, 43000.00, '2025-01-06', 43250, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(20, '20', 'Maleesha', 'Bank Transfer', 'Medical', 90.00, 5, 47000.00, '2025-01-06', 47450, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(21, '21', 'Malsha', 'Cheque', 'Administrative Finance', 170.00, 4, 58000.00, '2025-01-06', 58680, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(22, '23', 'Gunasinghe', 'Cash', 'Medical', 150.00, 3, 50000.00, '2025-01-06', 50450, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(23, '24', 'Gunawardhane', 'Bank Transfer', 'Medical', 135.00, 5, 55000.00, '2025-01-06', 55675, '2025-01-05 19:21:15', '2025-01-05 19:21:15'),
(24, '25', 'Suman', 'Cheque', 'Medical', 220.00, 4, 63000.00, '2025-01-06', 63880, '2025-01-05 19:21:15', '2025-01-05 19:21:15');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  `role` varchar(50) NOT NULL,
  `name` varchar(20) NOT NULL,
  `nic` varchar(12) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone` int(12) NOT NULL,
  `additionalNotes` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `email`, `password`, `role`, `name`, `nic`, `gender`, `phone`, `additionalNotes`) VALUES
(1, 's@gmail.com', 's1234', 'nurse', 'Shasani', '200355513574', 'Female', 764846394, 'NVQ 5'),
(2, 'd@gmail.com', 'd1234', 'cashier', 'dilmi', '200755623489', 'Female', 720357717, 'specialist'),
(3, 'cm@gmail.com', 'c1234', 'center manager', 'chami', '200312459876', 'Female', 756451478, 'Management Degree UOJ'),
(4, 'im@gmail.com', 'i1234', 'inventory manager', 'masanda', '200219876543', 'Male', 742156894, 'BBA UOR'),
(5, 'r@gmail.com', 'r1234', 'receptionist', 'supun', '200311223344', 'Male', 785462147, '2 year Experience'),
(6, 'do@gmail.com', 'd1234', 'doctor', 'samadi', '200155998301', 'Female', 758084150, 'MMBA UOC'),
(7, 'p@gmail.com', 'p1234', 'pharmacist', 'amani', '200355513573', 'Female', 75416578, '1 year experience'),
(8, 'fm@gmail.com', 'f1234', 'finance manager', 'dumindu', '200355513574', 'Female', 745894856, 'CIMP certificate'),
(9, 'mlt@gmail.com', 'mlt1234', 'MLT', 'nigeeth', '200355513576', 'Male', 758946122, 'deploma in MLT'),
(11, 'nm@gmail.com', 'nm1234', 'doctor', 'Maleesha', '200321911532', 'Male', 764846394, 'specialist'),
(12, 'ni@gmail.com', 'ni1234', 'doctor', 'Nisansala', '200355513584', 'Female', 756981352, 'Children specialist'),
(14, 'nm@gmail.com', 'nethmi1234', 'nurse', 'Nethmi ', '200025512589', 'Female', 784589362, 'NVQ L4'),
(16, 'ch@gmail.com', 'ch123', 'nurse', 'Chehani', '200025512590', 'Female', 784589400, 'NVQ L4'),
(17, 'dk@gmail.com', 'diashan123', 'doctor', 'Dishan', '200389456728', 'Male', 724586594, 'Mental specialization'),
(18, 'k@gmail.com', '1234', 'nurse', 'Keminda', '200355513574', 'Male', 764846394, 'UOP Nursing'),
(19, 'u@gmail.com', '1234', 'nurse', 'Uvindu', '200355513574', 'Male', 764846924, 'NVQ 4'),
(20, 'tm@gmail.com', 'p2345', 'pharmacist', 'Maleesha', '200321911531', 'Male', 764846350, 'Training student'),
(21, 'nm@gmail.com', 'cmm1234', 'cashier', 'Malsha', '200321911531', 'Male', 764842394, '2 years experience'),
(23, 'gs@gmail.com', 'gs1234', 'nurse', 'Gunasinghe', '199925460000', 'Male', 754555481, 'NVQ 5'),
(24, 'g@gmail.com', 'g1234', 'MLT', 'Gunawardhane', '19991245658', 'Male', 724896542, 'special'),
(25, 'su@gmail.com', 'su1234', 'doctor', 'Suman', '20025678900', 'Male', 764846300, 'special');

-- --------------------------------------------------------

--
-- Table structure for table `stock_details`
--

CREATE TABLE `stock_details` (
  `stock_id` int(11) NOT NULL,
  `item_name` varchar(30) NOT NULL,
  `quantity` int(11) NOT NULL,
  `ex_date` date NOT NULL,
  `department` varchar(30) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_details`
--

INSERT INTO `stock_details` (`stock_id`, `item_name`, `quantity`, `ex_date`, `department`, `time`) VALUES
(1, 'Ctrizen', 105, '2024-12-24', 'Medical', '2025-01-05 03:30:21'),
(2, 'Amoxaline', 1000, '2025-01-22', 'Medical', '2024-12-31 06:14:39'),
(3, 'Glucose Drip 500ml', 100, '2024-11-05', 'OPD', '2024-09-25 08:50:00'),
(4, 'Bandage Roll', 300, '2025-01-10', 'Lab', '2024-10-01 03:15:00'),
(5, 'Antibiotic Cream', 50, '2024-12-20', 'Cosmetics', '2024-10-05 06:40:00'),
(6, 'Blood Pressure Monitor', 10, '2025-03-01', 'OPD', '2024-10-15 11:10:00'),
(7, 'Insulin Injection', 80, '2025-01-05', 'Pharmacy', '2024-10-18 05:55:00'),
(8, 'Surgical Gloves', 200, '2024-12-15', 'Dental', '2024-10-20 07:30:00'),
(9, 'Digital Thermometer', 25, '2025-02-28', 'Lab', '2024-11-01 09:30:00'),
(10, 'Pain Relief Gel', 40, '2024-12-01', 'Pharmacy', '2024-11-05 04:25:00'),
(11, 'IV Cannula 18G', 150, '2025-03-10', 'OPD', '2024-11-10 05:05:00'),
(12, 'Cotton Balls', 500, '2025-02-20', 'Dental', '2024-11-15 08:35:00'),
(13, 'Surgical Mask', 300, '2025-01-31', 'Lab', '2024-11-20 06:15:00'),
(14, 'Oxygen Cylinder', 12, '2025-02-25', 'OPD', '2024-11-25 02:45:00'),
(15, 'Hand Sanitizer', 60, '2024-12-25', 'Cosmetics', '2024-12-01 07:00:00'),
(16, 'Sterile Gauze Pads', 400, '2025-01-15', 'Dental', '2024-12-05 03:50:00'),
(17, 'Antiseptic Solution', 80, '2025-04-10', 'Pharmacy', '2024-12-10 09:20:00'),
(18, 'Face Shield', 150, '2025-01-20', 'Lab', '2024-12-15 06:00:00'),
(19, 'Medical Tape', 250, '2024-11-30', 'OPD', '2024-12-20 09:40:00'),
(20, 'Cough Syrup 100ml', 70, '2025-01-12', 'Pharmacy', '2024-12-25 05:10:00'),
(21, 'Scissors', 15, '2025-02-01', 'Dental', '2025-01-01 08:25:00'),
(22, 'Sterilization Pouches', 300, '2024-12-10', 'Lab', '2024-11-28 02:40:00'),
(23, 'Disposable Aprons', 100, '2025-03-15', 'Cosmetics', '2024-12-30 11:55:00'),
(24, 'Eye Drops', 45, '2025-01-05', 'Eye', '2024-12-12 03:45:00'),
(25, 'Glucose Test Strips', 200, '2025-04-01', 'Pharmacy', '2024-12-22 06:20:00'),
(26, 'Vitamin C Tablets', 150, '2025-07-05', 'Pharmacy', '2025-01-05 03:00:00'),
(27, 'Dental Floss', 300, '2025-06-15', 'Dental', '2025-01-05 04:15:00'),
(28, 'Blood Test Kit', 50, '2025-08-10', 'Lab', '2025-01-05 04:45:00'),
(29, 'Anti-Glare Glasses', 20, '2025-04-12', 'Eye', '2025-01-05 05:30:00'),
(30, 'Moisturizing Cream', 40, '2025-06-20', 'Cosmetics', '2025-01-05 06:35:00'),
(31, 'Thermal Blankets', 25, '2025-05-05', 'OPD', '2025-01-05 07:50:00'),
(32, 'Hand Gloves', 200, '2025-09-10', 'Lab', '2025-01-05 09:00:00'),
(33, 'Eye Protection Shields', 15, '2025-04-15', 'Eye', '2025-01-05 09:40:00'),
(34, 'Lip Balm', 60, '2025-02-25', 'Cosmetics', '2025-01-05 11:15:00'),
(35, 'Stethoscope', 10, '2025-05-30', 'OPD', '2025-01-05 11:55:00');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(20) NOT NULL,
  `company` varchar(100) NOT NULL,
  `contact_no` int(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nic` varchar(12) NOT NULL,
  `company_address` varchar(50) NOT NULL,
  `item_names` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `company`, `contact_no`, `email`, `nic`, `company_address`, `item_names`, `password`) VALUES
(1, 'John ', 'John Brothers', 741112221, 'j@gmail.com', '20035558884', 'Borella', 'Medical Equipment, Pharmaceutical', 'Sh@nm2402');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `nurse_id` int(11) NOT NULL,
  `task_description` text NOT NULL,
  `task_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `test_name` varchar(100) NOT NULL,
  `status` enum('pending','completed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `test_name`, `status`) VALUES
(1, 'Blood Test', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `test_types`
--

CREATE TABLE `test_types` (
  `id` int(11) NOT NULL,
  `test_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_types`
--

INSERT INTO `test_types` (`id`, `test_name`) VALUES
(1, 'Blood Test'),
(2, 'X-Ray'),
(3, 'CT Scan'),
(4, 'MRI');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `visitor_id` int(11) NOT NULL,
  `visitor_name` varchar(30) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `address` varchar(50) NOT NULL,
  `contact` int(11) NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`visitor_id`, `visitor_name`, `nic`, `address`, `contact`, `purpose`, `date`, `time`) VALUES
(1, 'shasani', '200355513574', 'Angoda', 720357717, 'urebihnkrbghk', '2024-12-21', '2024-12-21 05:37:42'),
(4, 'John Doe', '2000213245V', 'Colombo', 711234567, 'Business Visit', '2025-01-06', '2025-01-06 04:30:00'),
(5, 'Jane Smith', '2000213246V', 'Kandy', 722345678, 'Consultation', '2025-01-06', '2025-01-06 05:00:00'),
(6, 'Mark Anderson', '2000213247V', 'Galle', 733456789, 'Medical Checkup', '2025-01-06', '2025-01-06 05:30:00'),
(7, 'Sara Lee', '2000213248V', 'Matara', 744567890, 'Follow-up Appointment', '2025-01-06', '2025-01-06 06:00:00'),
(8, 'Ravi Perera', '2000213249V', 'Negombo', 755678901, 'Payment Processing', '2025-01-06', '2025-01-06 06:30:00'),
(9, 'Amira Khan', '2000213250V', 'Kurunegala', 766789012, 'Consultation', '2025-01-06', '2025-01-06 07:00:00'),
(10, 'Pradeep Kumara', '2000213251V', 'Nuwara Eliya', 777890123, 'Hospital Visit', '2025-01-06', '2025-01-06 07:30:00'),
(11, 'Nimal Fernando', '2000213252V', 'Ratnapura', 788901234, 'Business Visit', '2025-01-06', '2025-01-06 08:00:00'),
(12, 'Anjali Wijesinghe', '2000213253V', 'Badulla', 799012345, 'Medical Consultation', '2025-01-06', '2025-01-06 08:30:00'),
(13, 'Chamodi Silva', '2000213254V', 'Gampaha', 710123456, 'General Inquiry', '2025-01-06', '2025-01-06 09:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `vital_signs`
--

CREATE TABLE `vital_signs` (
  `vitalId` int(11) NOT NULL,
  `patientName` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact_no` int(12) NOT NULL,
  `bloodp` double NOT NULL,
  `height` double NOT NULL,
  `weight` double NOT NULL,
  `bmi` double NOT NULL,
  `staffid` int(11) NOT NULL,
  `staffname` varchar(20) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vital_signs`
--

INSERT INTO `vital_signs` (`vitalId`, `patientName`, `email`, `contact_no`, `bloodp`, `height`, `weight`, `bmi`, `staffid`, `staffname`, `time`) VALUES
(1, 'shasani', 'm@gmail.com', 764846394, 20, 120, 70, 48.61, 1, 'shasani', '2025-01-04 23:28:48'),
(2, 'chamika', 'chami@gmail,com', 752041657, 10, 150, 54, 24, 1, 'Shasani', '2025-01-04 23:19:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`admission_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointmentid`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`billID`),
  ADD KEY `patientid` (`patientid`);

--
-- Indexes for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `billID` (`billID`);

--
-- Indexes for table `budget`
--
ALTER TABLE `budget`
  ADD PRIMARY KEY (`budget_id`);

--
-- Indexes for table `budget_reports`
--
ALTER TABLE `budget_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashiers`
--
ALTER TABLE `cashiers`
  ADD PRIMARY KEY (`cashier_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `credit_table`
--
ALTER TABLE `credit_table`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `debit_table`
--
ALTER TABLE `debit_table`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doctor_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `drugs`
--
ALTER TABLE `drugs`
  ADD PRIMARY KEY (`drug_id`);

--
-- Indexes for table `drug_orders`
--
ALTER TABLE `drug_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drug_stock`
--
ALTER TABLE `drug_stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance_manager`
--
ALTER TABLE `finance_manager`
  ADD PRIMARY KEY (`financemanager_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `inventory_manager`
--
ALTER TABLE `inventory_manager`
  ADD PRIMARY KEY (`inventorymanager_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `lab_requests`
--
ALTER TABLE `lab_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `lab_supplies_request`
--
ALTER TABLE `lab_supplies_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab_test_results`
--
ALTER TABLE `lab_test_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mlt`
--
ALTER TABLE `mlt`
  ADD PRIMARY KEY (`mlt_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `nurses`
--
ALTER TABLE `nurses`
  ADD PRIMARY KEY (`nurse_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `nurse_tasks`
--
ALTER TABLE `nurse_tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `assigned_by` (`assigned_by`),
  ADD KEY `nurse_id` (`nurse_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patientprofile`
--
ALTER TABLE `patientprofile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reg_id` (`reg_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `billID` (`billID`),
  ADD KEY `patientID` (`patientID`);

--
-- Indexes for table `paypal_table`
--
ALTER TABLE `paypal_table`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `pharmacist`
--
ALTER TABLE `pharmacist`
  ADD PRIMARY KEY (`pharmacist_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescription_drugs`
--
ALTER TABLE `prescription_drugs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescription_id` (`prescription_id`);

--
-- Indexes for table `progressnotes`
--
ALTER TABLE `progressnotes`
  ADD PRIMARY KEY (`progressNId`);

--
-- Indexes for table `receptionists`
--
ALTER TABLE `receptionists`
  ADD PRIMARY KEY (`receptionist_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_details`
--
ALTER TABLE `stock_details`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `nurse_id` (`nurse_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test_types`
--
ALTER TABLE `test_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`visitor_id`);

--
-- Indexes for table `vital_signs`
--
ALTER TABLE `vital_signs`
  ADD PRIMARY KEY (`vitalId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `admission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointmentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `billID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `bill_items`
--
ALTER TABLE `bill_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `budget_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `budget_reports`
--
ALTER TABLE `budget_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cashiers`
--
ALTER TABLE `cashiers`
  MODIFY `cashier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `credit_table`
--
ALTER TABLE `credit_table`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `debit_table`
--
ALTER TABLE `debit_table`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `drugs`
--
ALTER TABLE `drugs`
  MODIFY `drug_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `drug_orders`
--
ALTER TABLE `drug_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `drug_stock`
--
ALTER TABLE `drug_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `finance_manager`
--
ALTER TABLE `finance_manager`
  MODIFY `financemanager_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventory_manager`
--
ALTER TABLE `inventory_manager`
  MODIFY `inventorymanager_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lab_requests`
--
ALTER TABLE `lab_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lab_supplies_request`
--
ALTER TABLE `lab_supplies_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lab_test_results`
--
ALTER TABLE `lab_test_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mlt`
--
ALTER TABLE `mlt`
  MODIFY `mlt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nurses`
--
ALTER TABLE `nurses`
  MODIFY `nurse_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nurse_tasks`
--
ALTER TABLE `nurse_tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `patientprofile`
--
ALTER TABLE `patientprofile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paypal_table`
--
ALTER TABLE `paypal_table`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pharmacist`
--
ALTER TABLE `pharmacist`
  MODIFY `pharmacist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `prescription_drugs`
--
ALTER TABLE `prescription_drugs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `progressnotes`
--
ALTER TABLE `progressnotes`
  MODIFY `progressNId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `receptionists`
--
ALTER TABLE `receptionists`
  MODIFY `receptionist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `stock_details`
--
ALTER TABLE `stock_details`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `test_types`
--
ALTER TABLE `test_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `visitor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `vital_signs`
--
ALTER TABLE `vital_signs`
  MODIFY `vitalId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`doctor_id`);

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`patientid`) REFERENCES `patient` (`id`);

--
-- Constraints for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD CONSTRAINT `bill_items_ibfk_1` FOREIGN KEY (`billID`) REFERENCES `bills` (`billID`);

--
-- Constraints for table `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `finance_manager`
--
ALTER TABLE `finance_manager`
  ADD CONSTRAINT `finance_manager_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `inventory_manager`
--
ALTER TABLE `inventory_manager`
  ADD CONSTRAINT `inventory_manager_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `mlt`
--
ALTER TABLE `mlt`
  ADD CONSTRAINT `mlt_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `nurses`
--
ALTER TABLE `nurses`
  ADD CONSTRAINT `nurses_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `nurse_tasks`
--
ALTER TABLE `nurse_tasks`
  ADD CONSTRAINT `nurse_tasks_ibfk_2` FOREIGN KEY (`assigned_by`) REFERENCES `staff` (`id`),
  ADD CONSTRAINT `nurse_tasks_ibfk_3` FOREIGN KEY (`nurse_id`) REFERENCES `nurses` (`nurse_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_supplier_orders` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patientprofile`
--
ALTER TABLE `patientprofile`
  ADD CONSTRAINT `patientprofile_ibfk_1` FOREIGN KEY (`reg_id`) REFERENCES `patient` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`billID`) REFERENCES `bills` (`billID`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`patientID`) REFERENCES `patient` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pharmacist`
--
ALTER TABLE `pharmacist`
  ADD CONSTRAINT `pharmacist_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `prescription_drugs`
--
ALTER TABLE `prescription_drugs`
  ADD CONSTRAINT `prescription_drugs_ibfk_1` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`);

--
-- Constraints for table `receptionists`
--
ALTER TABLE `receptionists`
  ADD CONSTRAINT `receptionists_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
