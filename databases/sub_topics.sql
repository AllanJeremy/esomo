-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2016 at 11:20 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esomo`
--

-- --------------------------------------------------------

--
-- Table structure for table `sub_topics`
--

CREATE TABLE `sub_topics` (
  `sub_topic_id` int(255) UNSIGNED NOT NULL,
  `sub_topic_name` varchar(256) NOT NULL,
  `sub_topic_description` text NOT NULL,
  `topic_id` int(255) UNSIGNED NOT NULL DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_topics`
--

INSERT INTO `sub_topics` (`sub_topic_id`, `sub_topic_name`, `sub_topic_description`, `topic_id`) VALUES
(1, 'Length and time', '', 18),
(2, 'Speed, velocity and acceleration', '', 18),
(3, 'Mass and weight', '', 18),
(4, 'Density', '', 18),
(5, 'Forces', '', 18),
(6, 'Energy, work and power', '', 18),
(7, 'Pressure', '', 19),
(8, 'Simple kinetic molecular model of matter', '', 19),
(9, 'Thermal properties', '', 19),
(10, 'Transfer of thermal energy', '', 19),
(11, 'General wave properties', '', 20),
(12, 'Light', '', 20),
(13, 'Sound', '', 20),
(14, 'Simple phenomena of magnetism', '', 21),
(15, 'Electrical quantities', '', 21),
(16, 'Electric circuits', '', 20),
(17, 'Dangers of electricity', '', 21),
(18, 'Electromagnetic effects', '', 21),
(19, 'Cathode-ray oscilloscopes', '', 21),
(20, 'Radioactivity', '', 22),
(21, 'The nuclear atom', '', 22),
(22, 'Isotopes', '', 22),
(23, 'Characteristics of living organisms', '', 23),
(24, 'Concept and use of a classification system', '', 23),
(25, 'Features of organisms', '', 23),
(26, 'Dichotomous keys', '', 23),
(27, 'Cell structure and organisation', '', 24),
(28, 'Levels of organisation', '', 24),
(29, 'Size of specimens', '', 24),
(30, 'Diffusion', '', 25),
(31, 'Osmosis', '', 25),
(32, 'Active transport', '', 25),
(33, 'Photosynthesis', '', 28),
(34, 'Leaf structure', '', 28),
(35, 'Mineral requirements', '', 28),
(36, 'Diet', '', 29),
(37, 'Alimentary canal', '', 29),
(38, 'Mechanical digestion', '', 29),
(39, 'Chemical digestion', '', 29),
(40, 'Absorption', '', 29),
(41, 'Transport in plants', '', 30),
(42, 'Water uptake', '', 30),
(43, 'Transpiration', '', 30),
(44, 'Translocation (Extended candidates only)', '', 30),
(45, 'Transport in animals', '', 31),
(46, 'Heart', '', 31),
(47, 'Blood and lymphatic vessels', '', 31),
(48, 'Blood', '', 31),
(49, 'Respiration', '', 34),
(50, 'Aerobic respiration', '', 34),
(51, 'Anaerobic respiration', '', 34),
(52, 'Nervous control in humans', '', 36),
(53, 'Sense organs', '', 36),
(54, 'Hormones in humans', '', 36),
(55, 'Homeostasis', '', 36),
(56, 'Tropic responses', '', 36),
(57, 'Drugs', '', 37),
(58, 'Medicinal drugs', '', 37),
(59, 'Misused drugs', '', 37),
(60, 'Asexual reproduction', '', 38),
(61, 'Sexual reproduction', '', 38),
(62, 'Sexual reproduction in plants', '', 38),
(63, 'Sexual reproduction in humans', '', 38),
(64, 'Sex hormones in humans', '', 38),
(65, 'Methods of birth control in humans', '', 38),
(66, 'Sexually transmitted infections (STIs)', '', 38),
(67, 'Inheritance', '', 39),
(68, 'Chromosomes, genes and proteins', '', 39),
(69, 'Mitosis', '', 39),
(70, 'Meiosis', '', 39),
(71, 'Monohybrid inheritance', '', 39),
(72, 'Variation', '', 40),
(73, 'Adaptive features', '', 40),
(74, 'Selection', '', 40),
(75, 'Energy flow', '', 41),
(76, 'Food chains and food webs', '', 41),
(77, 'Nutrient cycles', '', 41),
(78, 'Population size', '', 41),
(79, 'Biotechnology and genetic engineering', '', 42),
(80, 'Biotechnology', '', 42),
(81, 'Genetic engineering', '', 42),
(82, 'Food supply', '', 43),
(83, 'Habitat destruction', '', 43),
(84, 'Pollution', '', 43),
(85, 'Conservation', '', 43),
(86, 'States of matter', '', 44),
(87, 'Atoms', '', 44),
(88, 'Atomic structure', '', 44),
(89, 'Relative formula masses and molar volumes of gases', '', 44),
(90, 'Chemical formulae and chemical equations', '', 44),
(91, 'Ionic compounds', '', 44),
(92, 'Covalent substances', '', 44),
(93, 'Metallic crystals', '', 44),
(94, 'Electrolysis', '', 44),
(95, 'The Periodic Table', '', 45),
(96, 'Group 1 elements - lithium, sodium and potassium', '', 45),
(97, 'Group 7 elements - chlorine, bromine and iodine', '', 45),
(98, 'Oxygen and oxides', '', 45),
(99, 'Hydrogen and water', '', 45),
(100, 'Reactivity series', '', 45),
(101, 'Tests for ions and gases', '', 45),
(102, 'Introduction', '', 46),
(103, 'Alkanes', '', 46),
(104, 'Alkenes', '', 46),
(105, 'Ethanol', '', 46),
(106, 'Acids, alkalis and salts', '', 47),
(107, 'Energetics', '', 47),
(108, 'Rates of reaction', '', 47),
(109, 'Equilibria', '', 47),
(110, 'Extraction and uses of metals', '', 48),
(111, 'Crude oil', '', 48),
(112, 'Synthetic polymers', '', 48),
(113, 'The industrial manufacture of chemicals', '', 48),
(114, 'Population dynamics', '', 51),
(115, 'Settlement', '', 51),
(116, 'Plate tectonics', '', 52),
(117, 'Landforms and landscape processes', '', 52),
(118, 'Weather, climate and natural vegetation', '', 52),
(119, 'The inter-relationship of physical and human geography', '', 52),
(120, 'Agricultural systems', '', 53),
(121, 'Industrial systems', '', 53),
(122, 'Leisure activities and tourism', '', 53),
(123, 'Energy and water resources', '', 53),
(124, 'Environmental risks and benefits: resource conservation and\r\nmanagement', '', 53),
(125, 'Geographical skills', '', 54),
(126, 'Geographical investigations', '', 54),
(127, 'Understand and explain the structure of the international travel and tourism industry', '', 62),
(128, 'Investigate the social, cultural, economic and environmental impact of travel and tourism', '', 62),
(129, 'Identify the role of national governments in forming tourism policy and promotion', '', 62),
(130, 'Investigate the patterns of demand for international travel and tourism', '', 62),
(131, 'Demonstrate knowledge of the main global features', '', 63),
(132, 'Demonstrate awareness of different time zones and climates', '', 63),
(133, 'Investigate travel and tourism destinations', '', 63),
(134, 'Identify and describe the features which attract tourists to a particular destination', '', 63),
(135, 'Deal with customers and colleagues - "the moment of truth"', '', 64),
(136, 'Identify the essential personal skills required when working in the travel and tourism\r\nindustry', '', 64),
(137, 'Follow basic procedures when handling customer enquiries, making reservations and\r\npayments', '', 64),
(138, 'Use reference sources to obtain information', '', 64),
(139, 'Explore the presentation and promotion of tourist facilities', '', 64),
(140, 'Identify and describe tourism products', '', 65),
(141, 'Explore the roles of tour operators and travel agents in the chain of distribution', '', 65),
(142, 'Describe support facilities for travel and tourism', '', 65),
(143, 'Explore the features of worldwide transport in relation to major international routes', '', 65),
(144, 'Role and function of marketing and promotion', '', 66),
(145, 'Market segmentation and targeting', '', 66),
(146, '''Product'' as part of the marketing mix', '', 66),
(147, '''Price'' as part of the marketing mix', '', 66),
(148, '''Place'' as part of the marketing mix', '', 66),
(149, '''Promotion'' as part of the marketing mix', '', 66),
(150, 'The operation, role and function of tourism authorities responsible for tourism policy and\r\npromotion at a national, regional and local level, including tourist information centres and\r\nvisitor information services', '', 67),
(151, 'The provision of tourist products and services', '', 67),
(152, 'Basic principles of marketing and promotion', '', 67),
(153, 'The marketing mix', '', 67),
(154, 'Leisure travel services', '', 67),
(155, 'Business travel services', '', 67),
(156, 'Were the Revolutions of 1848 important?', '', 68),
(157, 'How was Italy unified?', '', 68),
(158, 'How was Germany unified?', '', 68),
(159, 'Why was there a civil war in the United States and what were its results?', '', 68),
(160, 'Why, and with what effects, did Europeans expand their overseas empires in the 19th century?', '', 68),
(161, 'What caused the First World War?', '', 68),
(162, 'Were the peace treaties of 1919–23 fair?', '', 69),
(163, 'To what extent was the League of Nations a success?', '', 69),
(164, 'Why had international peace collapsed by 1939?', '', 69),
(165, 'Who was to blame for the Cold War?', '', 69),
(166, 'How effectively did the USA contain the spread of Communism?', '', 69),
(167, 'How secure was the USSR’s control over Eastern Europe, 1948–c.1989?', '', 69),
(168, 'Why did events in the Gulf matter, c.1970–2000?', '', 69),
(169, 'Monoprinting', '', 71),
(170, 'Relief printing', '', 71),
(171, 'Etching', '', 71),
(172, 'Screen printing', '', 71),
(173, 'Sculpture', '', 72),
(174, 'Ceramics', '', 72),
(175, 'Theatre design/set design', '', 72),
(176, 'Environmental/architectural design', '', 72),
(177, 'Product design\r\nCandidates should d', '', 72),
(178, 'Craft design', '', 72),
(179, 'Still imagery', '', 73),
(180, 'Moving imagery', '', 73),
(181, 'Graphic design with lettering', '', 74),
(182, 'Illustration', '', 74),
(183, 'Printmaking', '', 74),
(184, 'Advertising', '', 74),
(185, 'Game design', '', 74),
(186, 'Printed and/or dyed', '', 75),
(187, 'Constructed', '', 75),
(188, 'Fashion', '', 75),
(189, 'Hardware and software', '', 76),
(190, 'The main components of computer systems', '', 76),
(191, 'Operating systems', '', 76),
(192, 'Types of computer', '', 76),
(193, 'Impact of emerging technologies', '', 76),
(194, 'Input devices and their uses', '', 77),
(195, 'Direct data entry and associated devices', '', 77),
(196, 'Output devices and their uses', '', 77),
(197, 'Networks', '', 79),
(198, 'Network issues and communication', '', 79),
(199, 'Effects of IT on employment', '', 80),
(200, 'Effects of IT on working patterns within organisations', '', 80),
(201, 'Microprocessor-controlled devices in the home', '', 80),
(202, 'Potential health problems related to the prolonged use of IT equipment', '', 80),
(203, 'Communication applications', '', 81),
(204, 'Data handling applications', '', 81),
(205, 'Measurement applications', '', 81),
(206, 'Microprocessors in control applications', '', 81),
(207, 'Modelling applications', '', 81),
(208, 'Applications in manufacturing industry', '', 81),
(209, 'School management systems', '', 81),
(210, 'Booking systems', '', 81),
(211, 'Banking applications', '', 81),
(212, 'Computers in medicine', '', 81),
(213, 'Computers in libraries', '', 81),
(214, 'Expert systems', '', 81),
(215, 'Computers in the retail industry', '', 81),
(216, 'Recognition systems', '', 81),
(217, 'Monitoring and tracking systems', '', 81),
(218, 'Satellite systems', '', 81),
(219, 'Analysis', '', 82),
(220, 'Design', '', 82),
(221, 'Development and testing', '', 82),
(222, 'Implementation', '', 82),
(223, 'Documentation', '', 82),
(224, 'Evaluation', '', 82),
(225, 'Physical safety', '', 83),
(226, 'E-safety', '', 83),
(227, 'Security of data', '', 83),
(228, 'Audience appreciation', '', 84),
(229, 'Legal, moral, ethical and cultural appreciation', '', 84),
(230, 'Communicate with other ICT users using email', '', 85),
(231, 'Effective use of the internet', '', 85),
(232, 'Manage files effectively', '', 86),
(233, 'Reduce file sizes for storage or transmission', '', 86),
(234, 'Software tools', '', 90),
(235, 'Proofing techniques', '', 90),
(236, 'Create a database structure', '', 93),
(237, 'Manipulate data', '', 93),
(238, 'Present data', '', 93),
(239, 'Create a data model', '', 95),
(240, 'Test the data model', '', 95),
(241, 'Manipulate data', '', 95),
(242, 'Present data', '', 95),
(243, 'Web development layers', '', 96),
(244, 'Create a web page', '', 96),
(245, 'Use stylesheets', '', 96),
(246, 'Test and publish a website', '', 96),
(247, 'Entrepreneurship', '', 97),
(248, 'Researching a business opportunity', '', 97),
(249, 'Supply and demand', '', 97),
(250, 'Finance', '', 97),
(251, 'Measuring business performance', '', 97),
(252, 'The wider business environment', '', 97),
(253, 'Marketing', '', 98),
(254, 'Managing operations', '', 98),
(255, 'Managing finance', '', 98),
(256, 'Managing people', '', 98),
(257, 'Corporate objectives and strategy', '', 99),
(258, 'Making strategic and tactical decisions', '', 99),
(259, 'Assessing competitiveness', '', 99),
(260, 'Company growth', '', 99),
(261, 'International markets', '', 100),
(262, 'Changing global economy', '', 100),
(263, 'Business location', '', 100),
(264, 'Other considerations before trading internationally', '', 100),
(265, 'Global marketing', '', 100),
(266, 'Multinational corporations (MNCs)', '', 100);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sub_topics`
--
ALTER TABLE `sub_topics`
  ADD PRIMARY KEY (`sub_topic_id`),
  ADD UNIQUE KEY `sub_topic_id` (`sub_topic_id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sub_topics`
--
ALTER TABLE `sub_topics`
  MODIFY `sub_topic_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `sub_topics`
--
ALTER TABLE `sub_topics`
  ADD CONSTRAINT `fk_subtopic` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
