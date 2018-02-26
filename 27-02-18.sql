-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2018 at 09:26 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iskolcare`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `AccountId` int(11) NOT NULL,
  `Username` varchar(40) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `LastName` varchar(60) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `ContactNumber` varchar(40) NOT NULL DEFAULT '-',
  `Address` varchar(80) NOT NULL DEFAULT '-',
  `EmailAddress` varchar(60) NOT NULL DEFAULT '-',
  `DisplayPic` varchar(150) NOT NULL DEFAULT 'display-pic-male.png',
  `Birthday` varchar(20) NOT NULL DEFAULT '-',
  `Gender` varchar(10) NOT NULL DEFAULT '-',
  `UniversityId` int(11) NOT NULL DEFAULT '0',
  `AccountType` varchar(50) NOT NULL DEFAULT '-',
  `Status` int(11) NOT NULL DEFAULT '1',
  `Citizenship` varchar(50) NOT NULL DEFAULT '-',
  `ContPerson` varchar(100) NOT NULL DEFAULT '-',
  `ContPersonContNumber` varchar(50) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`AccountId`, `Username`, `Name`, `LastName`, `Password`, `ContactNumber`, `Address`, `EmailAddress`, `DisplayPic`, `Birthday`, `Gender`, `UniversityId`, `AccountType`, `Status`, `Citizenship`, `ContPerson`, `ContPersonContNumber`) VALUES
(1, 'ucmainccs', 'Heubert', 'Ferolino', 'ucmainccs', 'ucmainccs', '-', 'ferlintrev@gmail.com', 'display-pic-male.png', '2018-02-22', 'Male', 1, 'Volunteer - Faculty', 1, 'Filipino', 'Melvin M. Niñal', '23777 local 1334'),
(2, 'gerald', 'Gerald', 'Paradela', 'gerald', '09264014837', 'San Fernando, Cebu', 'geraldparadela@gmail.com', 'display-pic-male.png', '1997-09-14', 'Male', 1, 'Volunteer - Student', 1, 'Filipino', 'Richie Daneil  Morata', '09159274071'),
(3, 'sheryl', 'Sheryl', 'Satorre', 'sheryl', '09276168479', 'Brgy. Pardo, Cebu City, Cebu', 'sbsatorre@gmail.com', '3.jpg', '1990-02-22', 'Male', 1, 'Volunteer - Faculty', 1, 'Filipino', 'Melvin M. Niñal', '237777 local 133'),
(4, 'carubio', 'Christine Jhoy', 'Carubio', 'carubio', '0921127', 'Brgy. Mambaling, Cebu City, Cebu', 'cjcarubion@gmail.com', 'display-pic-male.png', '1997-04-13', 'Female', 1, 'Beneficiary - Member', 1, 'Filipino', 'Joshua del Mar', '0999212345'),
(5, 'bayojessa', 'Jessa', 'Bayo', 'selenagomez', '09233826952', 'Basak Iba, Lapu-Lapu City', 'bayojessa01@gmail.com', 'display-pic-male.png', '1997-01-12', 'Female', 1, 'Volunteer - Student', 1, 'Filipino', 'Josefin C. Bayo', '09225371121'),
(9, 'test', 'test', 'test', 'test', '-', '-', '-', 'display-pic-female.png', '2018-02-26', 'Female', 1, 'Beneficiary - Member', 1, '-', '-', '-');

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `ActivityId` int(11) NOT NULL,
  `ActivityName` varchar(40) NOT NULL,
  `ActivityDescription` varchar(200) NOT NULL,
  `ActivityVenue` varchar(80) NOT NULL,
  `TargetAudience` varchar(60) NOT NULL,
  `ProjectId` int(11) NOT NULL,
  `ActivityStatus` varchar(20) NOT NULL,
  `LocationLat` varchar(50) NOT NULL DEFAULT '10.3171',
  `LocationLng` varchar(50) NOT NULL DEFAULT '123.8906',
  `isExclusive` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`ActivityId`, `ActivityName`, `ActivityDescription`, `ActivityVenue`, `TargetAudience`, `ProjectId`, `ActivityStatus`, `LocationLat`, `LocationLng`, `isExclusive`) VALUES
(1, 'Programming Tutorial Activity', 'To help the target audience to learn simple programming.', 'Room 530 of University of Cebu-Main Campus', 'The people of Brgy. T. Padilla', 1, 'Approved', '10.3171', '123.8906', 1),
(2, 'testing google maps', 'just testing', 'Isagani, Cebu City, Cebu, Philippines', 'si junre lol', 3, 'Approved', '10.300256197612342', '123.90356386157202', 1);

-- --------------------------------------------------------

--
-- Table structure for table `activitysponsors`
--

CREATE TABLE `activitysponsors` (
  `ActivitySponsorId` int(11) NOT NULL,
  `SponsorId` int(11) NOT NULL,
  `ActivityId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activitysponsors`
--

INSERT INTO `activitysponsors` (`ActivitySponsorId`, `SponsorId`, `ActivityId`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `AdminId` int(11) NOT NULL,
  `Username` varchar(40) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`AdminId`, `Username`, `Password`, `Name`, `Status`) VALUES
(1, 'admin', 'admin', 'Junre Dexter Y. Zapico', 1);

-- --------------------------------------------------------

--
-- Table structure for table `beneficiaries`
--

CREATE TABLE `beneficiaries` (
  `BeneficiaryId` int(11) NOT NULL,
  `ProgramId` int(11) NOT NULL,
  `AccountId` int(11) NOT NULL,
  `BenStatus` int(11) NOT NULL,
  `Type` varchar(30) NOT NULL,
  `ApprovedDate` varchar(15) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE `choices` (
  `ChoiceId` int(11) NOT NULL,
  `ChoiceDescription` varchar(200) NOT NULL,
  `QuestionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (`ChoiceId`, `ChoiceDescription`, `QuestionId`) VALUES
(1, 'Sense of social/environmental responsibility', 1),
(2, 'Desire to learn through experience', 1),
(3, 'As part of my duties to God', 1),
(4, 'Understanding of UC''s Vision/Mission/Goals', 1),
(5, 'Understanding  of the College/Departments Objectives', 1),
(6, 'Others', 1),
(7, 'a friend', 3),
(8, 'a teacher', 3),
(9, 'a classmate', 3),
(10, 'a schoolmate', 3),
(11, 'a staff', 3),
(12, 'parents', 3),
(13, 'relatives', 3),
(14, 'on my own', 3);

-- --------------------------------------------------------

--
-- Table structure for table `coordinators`
--

CREATE TABLE `coordinators` (
  `CoordinatorId` int(11) NOT NULL,
  `ProgramId` int(11) NOT NULL,
  `isActive` int(11) NOT NULL,
  `AccountId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coordinators`
--

INSERT INTO `coordinators` (`CoordinatorId`, `ProgramId`, `isActive`, `AccountId`) VALUES
(3, 1, 0, 3),
(4, 2, 0, 3),
(19, 3, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `evaluationtools`
--

CREATE TABLE `evaluationtools` (
  `EvaluationFormId` int(11) NOT NULL,
  `EvaluationFormName` varchar(40) NOT NULL,
  `EvaluationFormDescription` varchar(200) NOT NULL,
  `UniId` int(11) NOT NULL,
  `ProgramId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluationtools`
--

INSERT INTO `evaluationtools` (`EvaluationFormId`, `EvaluationFormName`, `EvaluationFormDescription`, `UniId`, `ProgramId`) VALUES
(1, 'Volunteer Evaluation Form', 'Form for evaluating a volunteer', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `NotificationId` int(11) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0',
  `LinksTo` varchar(100) NOT NULL,
  `Recipient` varchar(100) NOT NULL,
  `RecipientId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`NotificationId`, `Description`, `Status`, `LinksTo`, `Recipient`, `RecipientId`) VALUES
(1, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Information Technology.', 0, 'getUniversityProgramsSpecific?id=1', 'Registered User', 1),
(2, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Information Technology.', 0, 'getUniversityProgramsSpecific?id=1', 'Registered User', 3),
(3, 'You are no longer a coordinator of Bachelor of Science in Information Technology', 0, 'getUniversityProgramsSpecific?id=1', 'Registered User', 3),
(4, 'A new Project has been added to the Bachelor of Science in Information Technology program by Cesar P. Gulang.', 0, 'getUniversityProgramsSpecific?id=1', 'Registered User', 1),
(5, 'A new Activity has been added to a program you were assigned in', 0, 'getActivityPage?id=1', 'Registered User', 1),
(6, 'A new Activity has been added to a program you were assigned in', 0, 'getActivityPage?id=1', 'Registered User', 3),
(7, 'A new Evaluation Tool has been released for Programming Tutorial Activity', 0, 'fillUpEvaluationForm?relfId=1', 'Registered User', 2),
(8, 'A new Evaluation Tool has been released for Programming Tutorial Activity', 0, 'fillUpEvaluationForm?relfId=2', 'Registered User', 2),
(9, 'A new Evaluation Tool has been released for Programming Tutorial Activity', 1, 'fillUpEvaluationForm?relfId=2', 'Registered User', 5),
(10, 'A new Activity has been added to a program you were assigned in', 0, 'getActivityPage?id=2', 'Registered User', 1),
(11, 'A new Activity has been added to a program you were assigned in', 0, 'getActivityPage?id=2', 'Registered User', 3),
(12, 'You are no longer a coordinator of Bachelor of Science in Information Technology', 0, 'getUniversityProgramsSpecific?id=1', 'Registered User', 1),
(13, 'You have been assigned as coordinator of Bachelor of Science in Information Technology', 0, 'getUniversityProgramsSpecific?id=1', 'Registered User', 3),
(14, 'You have been assigned as coordinator of Bachelor of Science in Information Technology', 0, 'getUniversityProgramsSpecific?id=1', 'Registered User', 1),
(15, 'You are no longer a coordinator of Bachelor of Science in Information Technology', 0, 'getUniversityProgramsSpecific?id=1', 'Registered User', 1),
(16, 'You have been assigned as coordinator of Bachelor of Science in Information Technology', 0, 'getUniversityProgramsSpecific?id=1', 'Registered User', 1),
(17, 'You are no longer a coordinator of Bachelor of Science in Information Technology', 0, 'getUniversityProgramsSpecific?id=1', 'Registered User', 1),
(18, 'You are now not a Coordinator.', 0, 'getProfile?', 'Coordinator', 1),
(19, 'You are now not a Coordinator.', 0, 'getProfile?', 'Coordinator', 3),
(20, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Information Technology.', 0, 'getUniversityProgramsSpecific?id=1', 'Registered User', 3),
(21, 'You are no longer a coordinator of Bachelor of Science in Information Technology', 0, 'getUniversityProgramsSpecific?id=1', 'Registered User', 3),
(22, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science Hotel and Restaurant Management.', 0, 'getUniversityProgramsSpecific?id=2', 'Registered User', 3),
(23, 'You are no longer a coordinator of Bachelor of Science Hotel and Restaurant Management', 0, 'getUniversityProgramsSpecific?id=2', 'Registered User', 3),
(24, 'You have been assigned as coordinator of Bachelor of Science in Information Technology', 0, 'getUniversityProgramsSpecific?id=1', 'Registered User', 3),
(25, 'You are no longer a coordinator of Bachelor of Science in Information Technology', 0, 'getUniversityProgramsSpecific?id=1', 'Registered User', 3),
(26, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Business Management.', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 1),
(27, 'You are now not a Coordinator.', 0, 'getProfile?', 'Coordinator', 1),
(28, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Business Management.', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 3),
(29, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Business Management.', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 3),
(30, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Business Management.', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 3),
(31, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Business Management.', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 3),
(32, 'You are now not a Coordinator.', 0, 'getProfile?', 'Coordinator', 3),
(33, 'You are now not a Coordinator.', 0, 'getProfile?', 'Coordinator', 3),
(34, 'You are now not a Coordinator.', 0, 'getProfile?', 'Coordinator', 3),
(35, 'You are now not a Coordinator.', 0, 'getProfile?', 'Coordinator', 3),
(36, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Business Management.', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 3),
(37, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Business Management.', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 3),
(38, 'You are now not a Coordinator.', 0, 'getProfile?', 'Coordinator', 3),
(39, 'You are now not a Coordinator.', 0, 'getProfile?', 'Coordinator', 3),
(40, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Business Management.', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 3),
(41, 'You are no longer a coordinator of Bachelor of Science in Business Management', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 3),
(42, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Business Management.', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 3),
(43, 'You are now not a Coordinator.', 0, 'getProfile?', 'Coordinator', 3),
(44, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Business Management.', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 3),
(45, 'You are now not a Coordinator.', 0, 'getProfile?', 'Coordinator', 3),
(46, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Business Management.', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 3),
(47, 'You are now not a Coordinator.', 0, 'getProfile?', 'Coordinator', 3),
(48, 'You are no longer a coordinator of Bachelor of Science in Business Management', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 3),
(49, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Business Management.', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 3),
(50, 'You are now not a Coordinator.', 0, 'getProfile?', 'Coordinator', 3),
(51, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Business Management.', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 3),
(52, 'You are now not a Coordinator.', 0, 'getProfile?', 'Coordinator', 3),
(53, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Business Management.', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 3),
(54, 'You are now not a Coordinator.', 0, 'getProfile?', 'Coordinator', 3),
(55, 'You have been assigned as coordinator of Bachelor of Science in Information Technology', 0, 'getUniversityProgramsSpecific?id=1', 'Registered User', 3),
(56, 'You are no longer a coordinator of Bachelor of Science in Information Technology', 0, 'getUniversityProgramsSpecific?id=1', 'Registered User', 3),
(57, 'You are now not a Coordinator.', 0, 'getProfile?', 'Coordinator', 3),
(58, 'You have been assigned as a Coordinator of University of Cebu''s Bachelor of Science in Business Management.', 0, 'getUniversityProgramsSpecific?id=3', 'Registered User', 3),
(59, 'A new Activity has been added to a program you were assigned in', 0, 'getActivityPage?id=2', 'Registered User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE `pictures` (
  `PictureId` int(11) NOT NULL,
  `FilePath` varchar(100) NOT NULL,
  `ActivityId` int(11) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `PostId` int(11) NOT NULL,
  `UniId` int(11) NOT NULL,
  `PostDescr` varchar(200) NOT NULL,
  `PostDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PostedBy` varchar(40) NOT NULL,
  `PosterDP` varchar(100) NOT NULL,
  `PosterDetails` varchar(30) NOT NULL,
  `PostWhat` varchar(100) DEFAULT NULL,
  `PostWhen` varchar(100) DEFAULT NULL,
  `PostWhere` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`PostId`, `UniId`, `PostDescr`, `PostDate`, `PostedBy`, `PosterDP`, `PosterDetails`, `PostWhat`, `PostWhen`, `PostWhere`) VALUES
(1, 1, 'Student-Volunteers Orientation on CARES', '2018-02-22 06:39:57', 'Heubert Ferolino', 'default-dp.jpg', 'Coordinator - 1', 'Student-Volunteers Orientation on CARES', 'Tomorrow', 'UC Main Offic'),
(2, 1, 'Freshmen Students Orientation on CARES June 30, 2018 @ CCS Multimedia Room', '2018-02-22 06:42:22', 'Heubert Ferolino', 'default-dp.jpg', 'Coordinator - 1', NULL, NULL, NULL),
(3, 1, 'ssda', '2018-02-26 03:48:41', 'Cesar P. Gulang', '../logos/university-logo.jpg', 'Director - 1', 'haha', 'hrrhr', 'hiho');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `ProgramId` int(11) NOT NULL,
  `ProgramName` varchar(100) NOT NULL,
  `ProgramDescription` varchar(200) NOT NULL,
  `ProgramObjective` varchar(200) NOT NULL,
  `Logo` varchar(40) NOT NULL DEFAULT 'program-logo.jpg',
  `UniversityId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`ProgramId`, `ProgramName`, `ProgramDescription`, `ProgramObjective`, `Logo`, `UniversityId`) VALUES
(1, 'Bachelor of Science in Information Technology', 'Welcome to UC-CCS.\r\nIn UC- CCS, we develop soution-oriented leaders and citizens in you. To the parents thank you for entrusting us.', '-', 'program-logo.jpg', 1),
(2, 'Bachelor of Science Hotel and Restaurant Management', 'BSHRM', 'Luto Luto Ta', 'program-logo.jpg', 1),
(3, 'Bachelor of Science in Business Management', 'BSBA', 'Utang', 'program-logo.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `ProjectId` int(11) NOT NULL,
  `ProjectName` varchar(70) NOT NULL,
  `ProjectDescription` varchar(200) NOT NULL,
  `ProgramId` int(11) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Banner` varchar(100) NOT NULL DEFAULT 'project-logo.jpg',
  `Level` varchar(30) NOT NULL DEFAULT 'Program'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`ProjectId`, `ProjectName`, `ProjectDescription`, `ProgramId`, `Status`, `Banner`, `Level`) VALUES
(1, 'CLiCK Project', 'Computer Literacy cum Kabuhayan', 1, 'Approved', 'project-logo.jpg', 'Program'),
(3, 'HoVer', 'Hover\r\nasda\r\nqweqwe\r\nazxcd', 1, 'Approved', 'project-logo.jpg', 'Program'),
(4, 'qweqw', 'asdas\r\nasdas\r\nzxczx', 1, 'Approved', 'project-logo.jpg', 'Institution'),
(5, 'asd', 'zxczx\r\nqweqw\r\nbaba', 1, 'Approved', 'project-logo.jpg', 'Institution');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `QuestionId` int(11) NOT NULL,
  `Question` varchar(200) NOT NULL,
  `QuestionType` varchar(40) NOT NULL,
  `FormId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`QuestionId`, `Question`, `QuestionType`, `FormId`) VALUES
(1, 'Reasons for volunteering:', 'Checkbox', 1),
(2, 'If the answer in question number 1 is otherts, please specify:', 'Open', 1),
(3, 'Have been encouraged to become aVolunteer by:', 'Checkbox', 1);

-- --------------------------------------------------------

--
-- Table structure for table `releasedforms`
--

CREATE TABLE `releasedforms` (
  `ReleasedFormId` int(11) NOT NULL,
  `ActivityId` int(11) NOT NULL,
  `FormId` int(11) NOT NULL,
  `FromDate` date NOT NULL,
  `ToDate` date NOT NULL,
  `ToBeAnsweredBy` varchar(40) NOT NULL,
  `totalResponses` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `releasedforms`
--

INSERT INTO `releasedforms` (`ReleasedFormId`, `ActivityId`, `FormId`, `FromDate`, `ToDate`, `ToBeAnsweredBy`, `totalResponses`) VALUES
(2, 1, 1, '2018-02-22', '2018-02-22', 'Student Volunteers', 1);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `SchedId` int(11) NOT NULL,
  `ProgramId` int(11) NOT NULL,
  `SchedTime` varchar(20) NOT NULL DEFAULT '-',
  `SchedTimeEnd` varchar(30) NOT NULL DEFAULT '-',
  `SchedDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`SchedId`, `ProgramId`, `SchedTime`, `SchedTimeEnd`, `SchedDate`) VALUES
(1, 1, '12:00:00', '15:00', '2018-02-24'),
(2, 2, '12:00:00', '13:00', '2018-02-25'),
(3, 2, '12:00:00', '12:01', '2018-02-27');

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE `sponsors` (
  `SponsorId` int(11) NOT NULL,
  `SponsorName` varchar(70) NOT NULL,
  `SponsorAddress` varchar(100) NOT NULL,
  `SponsorContactNo` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`SponsorId`, `SponsorName`, `SponsorAddress`, `SponsorContactNo`) VALUES
(1, 'Jollibee', '-', '-'),
(2, 'Julies Bakeshop', 'Sanciangko St, Cebu City, Cebu', '-');

-- --------------------------------------------------------

--
-- Table structure for table `submittedanswers`
--

CREATE TABLE `submittedanswers` (
  `SubmittedAnswersId` int(11) NOT NULL,
  `ReleasedFormId` int(11) NOT NULL,
  `QuestionId` int(11) NOT NULL,
  `Answer` varchar(200) NOT NULL DEFAULT '- ',
  `SubmittedBy` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `submittedanswers`
--

INSERT INTO `submittedanswers` (`SubmittedAnswersId`, `ReleasedFormId`, `QuestionId`, `Answer`, `SubmittedBy`) VALUES
(1, 2, 1, 'Desire to learn through experience', 5),
(2, 2, 2, '-', 5),
(3, 2, 3, 'on my own', 5);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `SubscriberId` int(11) NOT NULL,
  `Username` varchar(40) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `ContactNumber` varchar(40) NOT NULL,
  `Address` varchar(80) NOT NULL,
  `EmailAddress` varchar(40) NOT NULL,
  `Status` int(11) NOT NULL,
  `MaxPrograms` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`SubscriberId`, `Username`, `Password`, `ContactNumber`, `Address`, `EmailAddress`, `Status`, `MaxPrograms`) VALUES
(1, 'ucmain', 'ucmain', '09471850504', 'Sanciangko St., Cebu City, Cebu, Philippines', 'ucmain@uc.com.ph', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `SubscriptionId` int(11) NOT NULL,
  `SubscriptionName` varchar(100) NOT NULL,
  `SubscriptionDuration` varchar(50) NOT NULL,
  `SubscriptionPrice` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`SubscriptionId`, `SubscriptionName`, `SubscriptionDuration`, `SubscriptionPrice`) VALUES
(1, 'Petty Subscription', '1 month', '400.00');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `TransacId` int(11) NOT NULL,
  `SubscriberId` int(11) NOT NULL,
  `TransactionDate` date NOT NULL,
  `PaymentType` varchar(40) NOT NULL DEFAULT 'Paypal',
  `SubscriptionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`TransacId`, `SubscriberId`, `TransactionDate`, `PaymentType`, `SubscriptionId`) VALUES
(1, 1, '2018-02-04', 'Paypal', 1);

-- --------------------------------------------------------

--
-- Table structure for table `universities`
--

CREATE TABLE `universities` (
  `UniId` int(11) NOT NULL,
  `UniName` varchar(40) NOT NULL,
  `UniDescription` varchar(1000) NOT NULL,
  `UniLogo` varchar(40) NOT NULL DEFAULT 'university-logo.jpg',
  `Vision` varchar(1000) NOT NULL,
  `Mission` varchar(1000) NOT NULL,
  `ExtensionHeadName` varchar(120) NOT NULL,
  `SubscriberId` int(11) NOT NULL,
  `CoverPhoto` varchar(150) NOT NULL DEFAULT 'cover-photo.jpg',
  `UniAddress` varchar(150) NOT NULL DEFAULT '-',
  `UniContNum` varchar(50) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `universities`
--

INSERT INTO `universities` (`UniId`, `UniName`, `UniDescription`, `UniLogo`, `Vision`, `Mission`, `ExtensionHeadName`, `SubscriberId`, `CoverPhoto`, `UniAddress`, `UniContNum`) VALUES
(1, 'University of Cebu', 'Innovation, Camaraderie, Alignment, Respect, Excellence', 'university-logo.jpg', 'Democratize quality education\r\nBe the visionary and industry leader.\r\nGive hope and transform lives.', 'University of Cebu offers affordable and quality education responsive to the demands of local and international communities.\r\nUniversity of Cebu commits itself to:\r\n      - Serve as an active catalyst in providing efficient and effective delivery of educatioinal services;\r\n      - Pursue excellence in instruction, research and community service towards social and economic development as well as environmental sustainability;\r\n        Acquire, disseminate and utilize appropriate technology to enhance the university''''s educational services; and\r\n        Foster an organizational culture that nurtures employee productivity and engagement.', 'Cesar P. Gulang', 1, 'cover-photo.jpg', 'Sanciangko St, Brgy. Kalubihan, Cebu City, Cebu, Philippines 6000', '414-91801');

-- --------------------------------------------------------

--
-- Table structure for table `volunteerattendances`
--

CREATE TABLE `volunteerattendances` (
  `VolAttendanceId` int(11) NOT NULL,
  `AttendanceDate` date NOT NULL,
  `VolunteerId` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'Absent'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `volunteerattendances`
--

INSERT INTO `volunteerattendances` (`VolAttendanceId`, `AttendanceDate`, `VolunteerId`, `Status`) VALUES
(1, '2018-02-24', 1, 'Absent'),
(2, '2018-02-24', 2, 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `VolunteerId` int(11) NOT NULL,
  `ProgramId` int(11) NOT NULL,
  `AccountId` int(11) NOT NULL,
  `VolunteerStatus` int(11) NOT NULL,
  `Type` varchar(40) NOT NULL,
  `ApprovedDate` varchar(15) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`VolunteerId`, `ProgramId`, `AccountId`, `VolunteerStatus`, `Type`, `ApprovedDate`) VALUES
(1, 1, 2, 1, 'Student', '2018-02-22'),
(2, 1, 4, 1, 'External', '-'),
(3, 1, 5, 1, 'Student', '2018-02-22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`AccountId`);

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`ActivityId`);

--
-- Indexes for table `activitysponsors`
--
ALTER TABLE `activitysponsors`
  ADD PRIMARY KEY (`ActivitySponsorId`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`AdminId`);

--
-- Indexes for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD PRIMARY KEY (`BeneficiaryId`);

--
-- Indexes for table `choices`
--
ALTER TABLE `choices`
  ADD PRIMARY KEY (`ChoiceId`);

--
-- Indexes for table `coordinators`
--
ALTER TABLE `coordinators`
  ADD PRIMARY KEY (`CoordinatorId`);

--
-- Indexes for table `evaluationtools`
--
ALTER TABLE `evaluationtools`
  ADD PRIMARY KEY (`EvaluationFormId`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`NotificationId`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`PictureId`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`PostId`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`ProgramId`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`ProjectId`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`QuestionId`);

--
-- Indexes for table `releasedforms`
--
ALTER TABLE `releasedforms`
  ADD PRIMARY KEY (`ReleasedFormId`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`SchedId`);

--
-- Indexes for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`SponsorId`);

--
-- Indexes for table `submittedanswers`
--
ALTER TABLE `submittedanswers`
  ADD PRIMARY KEY (`SubmittedAnswersId`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`SubscriberId`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`SubscriptionId`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`TransacId`);

--
-- Indexes for table `universities`
--
ALTER TABLE `universities`
  ADD PRIMARY KEY (`UniId`);

--
-- Indexes for table `volunteerattendances`
--
ALTER TABLE `volunteerattendances`
  ADD PRIMARY KEY (`VolAttendanceId`);

--
-- Indexes for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`VolunteerId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `AccountId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `ActivityId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `activitysponsors`
--
ALTER TABLE `activitysponsors`
  MODIFY `ActivitySponsorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `AdminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  MODIFY `BeneficiaryId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
  MODIFY `ChoiceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `coordinators`
--
ALTER TABLE `coordinators`
  MODIFY `CoordinatorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `evaluationtools`
--
ALTER TABLE `evaluationtools`
  MODIFY `EvaluationFormId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `NotificationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `PictureId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `PostId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `ProgramId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `ProjectId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `QuestionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `releasedforms`
--
ALTER TABLE `releasedforms`
  MODIFY `ReleasedFormId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `SchedId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `SponsorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `submittedanswers`
--
ALTER TABLE `submittedanswers`
  MODIFY `SubmittedAnswersId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `SubscriberId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `SubscriptionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `TransacId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `universities`
--
ALTER TABLE `universities`
  MODIFY `UniId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `volunteerattendances`
--
ALTER TABLE `volunteerattendances`
  MODIFY `VolAttendanceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `VolunteerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
