-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2020 at 04:00 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `parent`, `Ordering`, `Visibility`, `Allow_comment`, `Allow_Ads`) VALUES
(13, 'Hand Made', 'Hand Made items', 0, 1, 0, 0, 0),
(14, 'computers', 'computers items', 0, 2, 0, 0, 0),
(15, 'cell Phone', 'cell Phone cell Phone', 0, 3, 0, 0, 0),
(16, 'Clothing', 'clothing clothing clothing', 0, 4, 0, 0, 0),
(17, 'Tools', 'Home Tools ', 0, 5, 0, 0, 0),
(20, 't-shirt', 'cotone t-shirt', 16, 8, 0, 0, 0),
(22, 'I phone ', 'apple phone', 15, 8, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `cID` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `commentDate` date NOT NULL,
  `itemID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`cID`, `comment`, `status`, `commentDate`, `itemID`, `userID`) VALUES
(15, 'هذه الاداة مفيده و سريعة الاستخدام ', 1, '2020-10-15', 35, 1),
(17, 'هذا الطقم جيد جدا خاصة انهو من القطن ولهذا فهو مريح وجميل', 0, '2020-10-08', 31, 1),
(19, 'استارز  جميل جدا فعلا ومريح فاللعب', 1, '2020-11-06', 38, 67),
(20, 'موبيل جميل جدا جدا وبيشغل ببجي والكاميرا بتاعتة جميلة جدا برضه', 0, '2020-11-06', 27, 1),
(21, 'موبيل جميل جدا جدا وبيشغل ببجي والكاميرا بتاعتة جميلة جدا برضه', 1, '2020-11-06', 27, 1),
(22, 'موبيل جميل جدا', 1, '2020-11-06', 27, 65),
(23, 'ممتاز', 1, '2020-11-06', 27, 71),
(24, 'حميل جدا فعلا', 1, '2020-11-06', 38, 1),
(29, 'موبيل جميل والكاميرا جميلة فعلا', 1, '2020-11-10', 40, 1),
(30, 'tuyiktyrjr', 0, '2020-11-13', 38, 92);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `add_date` date NOT NULL,
  `country_made` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `rating` smallint(6) DEFAULT NULL,
  `approve` tinyint(4) NOT NULL DEFAULT 0,
  `catID` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemID`, `name`, `description`, `price`, `add_date`, `country_made`, `image`, `status`, `tags`, `rating`, `approve`, `catID`, `userID`) VALUES
(25, 'HP لاب توب 15.6 انش,1 تيرابايت,رام 4 جيجابايت,ايه ام دي اثلون,دوس,اسود - 15-db1033ne', '\r\nالعلامة التجارية : HP\r\nمنصة الجهاز : دوس\r\nاللون : اسود\r\nنوع نظام التشغيل : دوس\r\nسعة القرص الصلب : 1 تيرابايت\r\nنطاق حجم الشاشة : 15 - 15.9 بوصة\r\nProcessor Type : null\r\nيو إس بي : null\r\nواجهة القرص الصلب : null\r\nحجم الشاشة (انش) : null\r\nقارئ بطاقة الذاكرة : نعم\r\nحجم الذاكرة : 4 جيجابايت\r\nعائلة المعالج : ايه ام دي اثلون\r\nعدد المعالجات : ثنائي النواة\r\nالعلامة التجارية لمتحكم الفيديو : null\r\nتقنية ذاكرة التخزين : دي دي ار ...', '7,999.00 ', '2020-10-30', 'egypt', '', '1', '', NULL, 1, 14, 1),
(27, 'سامسونج جالكسي A10s بشريحتي اتصال - 32 جيجا، 2 جيجا رام، الجيل الرابع ال تي اي، اسود', 'شاهد محتواك المفضل أو تصفح الإنترنت على الهاتف المحمول سامسونج جالاكسي A10s بشريحتي اتصال. يمتلك شاشة إنفينيتي-في كبيرة 6.2 إنش والتي تقدم صوراً مثيرة للإعجاب وبدقة مذهلة 720 × 1520 بكسل، لجعل تجربتك في المشاهدة استثنائية. علاوةً على ذلك، تشعر أنه صغير الحجم وخفيف الوزن، لذا يمكنك حمله لساعاتٍ في راحة يدك ودون الشعور بالإرهاق. كما أنه يعمل بمعالج ثماني النواة وحجم الرام 2 جيجابايت، ...', '1,749.00 ', '2020-10-30', 'usa', '', '2', '', NULL, 1, 15, 1),
(28, 'موبايل سامسونج جالاكسي A11 SM-A115FZKDEGY بشريحتين اتصال - شاشة 6.4 بوصة، 32 جيجابايت، 2 جيجابايت رام، شبكة الجيل الرابع ال تي اي - اسود', 'مع موبايل جالاكسي A11 المبتكر، انغمس في مشاهدة محتواك المفضل على الشاشة بلا حدود ذات المساحة الرحبة مقاس 6.4 بوصات والفتحة العلوية على شكل حرف O. يؤدي كِبر حجم معامل العرض إلى الطول إلى ملء شاشتك بالمحتوى المعروض من الحافة إلى الحافة حتى يتسنى لك مشاهدة مقاطع الفيديو المفضلة، وتشغيل الألعاب التي تريدها، وتسجيل البث المباشر بتقنية HD+ TFT النابضة ...', '1,959.00 ', '2020-10-30', 'egy', '', '1', '', NULL, 1, 15, 64),
(29, 'نوكيا 3.2 بشريحتي اتصال - 16 جيجا، 2 جيجا رام، الجيل الرابع ال تي اي، فضي', 'استمتع بطريقة العرض المميزة وبتجربة رائعة مع الهاتف الذكي 3.2 من نوكيا ثنائي شريحة الاتصال. يتميز هذا الهاتف المحمول المبتكر بشاشة بحجم 6.26 انش عالية الدقة بالإضافة الى وجود نوتش يضم الكاميرا الأمامية لتبدو مذهلة كما أنها تمنحك طريقة عرض رائعة. يمكنك ملاحظة أدق التفاصيل أثناء مشاهدة المحتوى المفضل لديك على هذه الشاشة الكبيرة. كما تتكيف هذه الشاشة مع جميع ظروف الإضاءة المحيطة بك، ...', '1,250.00 ', '2020-10-30', 'egy', '', '3', '', NULL, 1, 15, 65),
(30, 'طقم ملابس سالوبيت بكباسين بدون اكمام بطبعة فيل مع سالوبيت بأكمام قصيرة للبنات من لوميكس - بينك، قطعتين، 0 - 3 شهور', 'العلامة التجارية: لوميكس\r\nالنوع: طقم من قطعتين\r\nسالوبيت بكباسين بدون أكمام\r\nطبعة فيل\r\nسالوبيت بكباسين بأكمام ...', '105.00 ', '2020-10-30', 'egy', '', '1', 'خصم', NULL, 1, 16, 65),
(31, 'مجموعة ملابس للاطفال من زيركون للاولاد - متعدد الالوان', 'العلامة التجارية: زيركون\r\nالنوع: مجموعة ملابس للاطفال\r\nالخامة: قطن\r\nالمقاس: 0 - 3 اشهر\r\nالفئة المستهدفة: اولاد\r\nاللون: متعدد الالوان', '175.00 ', '2020-10-30', 'egy', '', '1', '', NULL, 1, 16, 64),
(32, 'طقم ملابس سالوبيت بنقشة فراولة واطراف كرانيش مع تيشيرت بأكمام قصيرة للبنات من لوميكس - فوشيا، 9 - 12 شهر', 'العلامة التجارية: لوميكس\r\nالنوع: طقم من قطعتين\r\nسالوبيت بدون أكمام\r\nبنقشة فراولة\r\nتيشيرت بأكمام ...', '185.00 ', '2020-10-30', 'egy', '', '1', '', NULL, 1, 16, 64),
(33, 'مضخة مياة يدوية', 'العلامة التجارية : اخرى\r\nنوع المعدات اليدوية : مضخة المياه', '32.00 ', '2020-10-30', 'egy', '', '1', '', NULL, 1, 17, 64),
(35, 'كاويه لحام 60 وات', '', '37.07 ', '2020-10-30', 'egy', '', '1', '', NULL, 1, 17, 58),
(36, 'ترنج رجالي ليكرا', 'ترنج رجالي ليكرا مريح فالشغل والتدريب', '150', '2020-11-05', 'مصر', '', '1', '', NULL, 1, 16, 1),
(38, 'استارز مقاس 40', 'استارز مقاس 40 استارز مقاس 40 استارز مقاس 40', '200', '2020-11-05', 'مصر', '', '2', '', NULL, 1, 16, 1),
(40, 'موبيل شاومي ردمي 7 ', 'موبيل شاومي ردمي 7  موبيل شاومي ردمي 7 موبيل شاومي ردمي 7  موبيل شاومي ردمي 7  موبيل شاومي ردمي 7  موبيل شاومي ردمي 7 ', '300', '2020-11-10', 'مصر', '', '1', 'خصم', NULL, 1, 15, 58),
(41, 'لعبة اطفال ', 'لعبة خشب  لعبة خشب  لعبة خشب ', '53', '2020-11-11', 'مصر', '', '1', 'العاب خشب , لعبة ,خشب,خصم', NULL, 1, 13, 1),
(42, 'لعبة خشب ', 'لعبة خشب امنه علي الاطفال فاللعب وخفيفة', '50', '2020-11-11', 'مصر', '', '1', 'لعب, خشب, لعبة خشب,العب اطفال,Games,خصم', NULL, 1, 13, 58),
(43, 'العاب', 'العابالعابالعابالعابالعابالعابالعابالعاب', '100', '2020-11-12', 'مصر', '', '1', 'لعب, خشب, لعبة خشب,العب اطفال,Games,خصم', NULL, 1, 17, 65),
(53, 'kkkkkkkkkkkkkkkkkkkkk', 'sssssssssssssssssssssssssss', '$1000', '2020-11-14', 'مصر', '921542.kkkkkkkkkkkkkkkkkkkkk.2020-10-31_112623.png', '1', 'العاب خشب , لعبة ,خشب', NULL, 1, 14, 68);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL COMMENT 'to identify user',
  `userName` varchar(255) NOT NULL COMMENT 'username to login',
  `password` varchar(255) NOT NULL COMMENT 'password to login',
  `email` varchar(255) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `groupID` int(11) NOT NULL DEFAULT 0 COMMENT 'identify user group',
  `trustStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'seller rank',
  `regStatus` int(11) NOT NULL DEFAULT 0 COMMENT 'user approval',
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `userName`, `password`, `email`, `fullName`, `image`, `groupID`, `trustStatus`, `regStatus`, `date`) VALUES
(1, 'atef', '8cb2237d0679ca88db6464eac60da96345513964', 'ateftaha131@yahoo.com', 'atef taha', '', 1, 0, 1, '2020-11-12'),
(58, 'saied', 'dc8d84bdb9238db41e75fad045d4d64d8e128947', 'ateftaha12@gmail.com', 'ali ali', '', 0, 0, 1, '2020-10-17'),
(64, 'Ali Ahmed', '8cb2237d0679ca88db6464eac60da96345513964', 'Ali_Ahmed@gmail.com', 'Ali Ahmed', '', 0, 0, 1, '2020-10-30'),
(65, 'mohammed hussen', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'mohammed_hussen@gmail.com', 'mohammed hussen', '', 0, 0, 1, '2020-10-30'),
(66, 'Omar fthy', 'd2f75e8204fedf2eacd261e2461b2964e3bfd5be', 'Omarthy@gmail.com', 'Omar fthy', '', 0, 0, 1, '2020-10-30'),
(67, 'maha hamad', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'mahahamad@yahoo.com', 'maha hamad', '', 0, 0, 1, '2020-10-30'),
(68, 'omar hassan', '2365c757ae80bf7200ff03862527949a125a135f', 'omar_hassan@yahoo.com', 'omar hassan', '', 0, 0, 1, '2020-10-30'),
(69, 'amr gamal', 'd2f75e8204fedf2eacd261e2461b2964e3bfd5be', 'amr_gamal@yahoo.com', 'amr gamal', '', 0, 0, 0, '2020-10-30'),
(70, 'mahmod hany', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'mahmod_hany@yahoo.com', 'mahmod hany', '', 0, 0, 0, '2020-10-30'),
(71, 'hagr ezat', '8cb2237d0679ca88db6464eac60da96345513964', 'hag_ezat@yahoo.com', 'hagr ezat', '', 0, 0, 0, '2020-10-30'),
(72, 'mosad', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ateftaha131@gmail.com', 'mosad mosad', '', 0, 0, 0, '2020-11-03'),
(74, 'osama', '8cb2237d0679ca88db6464eac60da96345513964', 'ahmed@gmail.com', '', '', 0, 0, 1, '2020-11-09'),
(75, 'ahmed', '8cb2237d0679ca88db6464eac60da96345513964', 'ateftaha12@gmail.com', '', '', 0, 0, 0, '2020-11-12'),
(91, 'ali alia lai', '6587cf76cd5468f05f0a0e6884e8589981d18f27', 'ali@gmail.com', 'ali ali', '736393.ali alia lai.taef.jpeg', 0, 0, 0, '2020-11-12'),
(92, 'hossam hussein', '8cb2237d0679ca88db6464eac60da96345513964', 'ateftaha12@gmail.com', '', '', 0, 0, 1, '2020-11-13'),
(95, 'samar', '8cb2237d0679ca88db6464eac60da96345513964', 'ateftaha131@yahoo.com', '', '853568_samar.jpeg', 0, 0, 0, '2020-11-14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`cID`),
  ADD KEY `items_comment` (`itemID`),
  ADD KEY `comment_user` (`userID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `member_1` (`userID`) USING BTREE,
  ADD KEY `cat_1` (`catID`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userName` (`userName`),
  ADD KEY `userName_2` (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `cID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'to identify user', AUTO_INCREMENT=96;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`itemID`) REFERENCES `items` (`itemID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat` FOREIGN KEY (`catID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
