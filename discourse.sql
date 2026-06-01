-- ============================================================
-- Discourse Forum Database Schema
-- Local Dev Setup (XAMPP MySQL)
-- ============================================================

CREATE DATABASE IF NOT EXISTS `discourse` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `discourse`;

-- 1. Accounts Table
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identification` varchar(20) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'student',
  `avatar_md` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identification` (`identification`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2. Posts Table
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text DEFAULT NULL,
  `author_id` varchar(20) NOT NULL,
  `community` varchar(100) NOT NULL DEFAULT 'FEUTech',
  `topic` varchar(100) NOT NULL DEFAULT 'GENERAL',
  `tags` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `upvotes` int(11) NOT NULL DEFAULT 0,
  `downvotes` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_anonymous` tinyint(4) NOT NULL DEFAULT 0,
  `is_poll` tinyint(4) NOT NULL DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `fk_posts_author` FOREIGN KEY (`author_id`) REFERENCES `accounts` (`identification`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3. Poll Options Table
CREATE TABLE IF NOT EXISTS `poll_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `votes` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `fk_poll_options_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 4. Poll Votes Table (To keep track of who voted what)
CREATE TABLE IF NOT EXISTS `poll_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `identification` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_post_vote` (`post_id`, `identification`),
  KEY `option_id` (`option_id`),
  CONSTRAINT `fk_poll_votes_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_poll_votes_option` FOREIGN KEY (`option_id`) REFERENCES `poll_options` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 5. Comments Table
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `author_id` varchar(20) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `is_anonymous` tinyint(4) NOT NULL DEFAULT 0,
  `upvotes` int(11) NOT NULL DEFAULT 0,
  `downvotes` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `fk_comments_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_comments_parent` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 6. Feedback Table
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `feedback` text NOT NULL,
  `identification` varchar(20) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 7. Notifications Content Table
CREATE TABLE IF NOT EXISTS `notifications_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identification` varchar(20) DEFAULT NULL,
  `is_global` tinyint(4) NOT NULL DEFAULT 0,
  `recipient_type` varchar(50) DEFAULT NULL,
  `application` varchar(100) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 8. Notifications Engagement Table
CREATE TABLE IF NOT EXISTS `notifications_engagement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notifications_id` int(11) NOT NULL,
  `identification` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `notifications_id` (`notifications_id`),
  CONSTRAINT `fk_engagement_noti` FOREIGN KEY (`notifications_id`) REFERENCES `notifications_content` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ============================================================
-- Seed/Initial Data
-- ============================================================

-- Insert Accounts
INSERT INTO `accounts` (`identification`, `display_name`, `role`, `avatar_md`, `email`) VALUES
('T202110117',  'Marielle Basanes',  'student',   NULL, 'marielle@example.com'),
('T202210202',  'Catalina Smith',    'student',   '/Discourse/assets/images/catalina.webp', 'catalina@example.com'),
('T202110294',  'Ravi Joshi',        'student',   '/Discourse/assets/images/catalina.webp', 'ravi@example.com'),
('T202008123',  'John Doe',          'student',   '/Discourse/assets/images/catalina.webp', 'john@example.com'),
('T202102837',  'Marco Torres',      'student',   '/Discourse/assets/images/catalina.webp', 'marco@example.com'),
('T202210344',  'Sofia Karim',       'student',   NULL, 'sofia@example.com'),
('T202110295',  'Smith Doe',         'student',   '/Discourse/assets/images/catalina.webp', 'smith@example.com')
ON DUPLICATE KEY UPDATE display_name = VALUES(display_name);

-- Insert Posts
INSERT INTO `posts` (`id`, `title`, `body`, `author_id`, `community`, `topic`, `tags`, `slug`, `upvotes`, `downvotes`, `is_anonymous`, `is_poll`, `image_url`) VALUES
(1, 'The silent revolution in edge AI — why on-device inference is changing everything', 'A decade optimizing for server-side compute, but the thermal envelope of modern SoCs has quietly crossed a threshold nobody was paying attention to. Here''s why 2025 is the last year data centers dominate AI inference at scale.<br><br>The numbers are staggering — a modern mobile chip can...', 'T202110294', 'FEUTech', 'TECHNOLOGY', 'Technology', 'silent-revolution-edge-ai', 214, 0, 0, 0, NULL),
(2, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec.', 'T202008123', 'FEUTech', 'TECHNOLOGY', 'Technology', 'lorem-ipsum-dolor-sit-amet', 214, 0, 0, 0, NULL),
(3, 'What if FEU had a no-grade-penalty mental health leave policy?', 'Just thinking — a lot of students I know failed a whole semester because they were dealing with severe anxiety during midterms. The university had no mechanism to help them — just a strict drop policy or failure. Other universities have mental health leaves where students can pause without academic penalty. Should FEU implement something similar?', 'T202210202', 'FEUTech', 'TECHNOLOGY', 'Ideas', 'what-if-feu-had-mental-health-leave', 214, 0, 1, 0, NULL),
(4, 'Lorem ipsum dolor sit amet consectetur adipiscing elit.', 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam uma tempor.', 'T202008123', 'FEUTech', 'TECHNOLOGY', 'Technology', 'lorem-ipsum-consectetur-adipiscing', 214, 0, 0, 0, NULL),
(5, '📊 Poll: How do you actually study for finals? Be honest.', 'Curious how my fellow FEU Tech students survive finals season. Drop your honest answer below 👇', 'T202102837', 'FEULife', 'FEU', 'FEU • Academics', 'poll-how-do-you-study-finals', 456, 0, 0, 1, NULL),
(6, 'FEU Tech library study rooms — worth booking or just use the hallway?', 'Finally tried booking one of the new study rooms in the library. Honest review: the booking system is clunky, the AC is questionable, but the soundproofing is actually great. Worth it for group study if you plan ahead.<br><br>Not ideal for solo cramming though — the chairs are surprisingly uncomfortable for long sessions.', 'T202210202', 'FEUTech', 'TECHNOLOGY', 'FEU • Campus Life', 'feu-tech-library-study-rooms', 214, 0, 0, 0, 'https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?q=80&w=1200&auto=format&fit=crop');

-- Insert Poll Options
INSERT INTO `poll_options` (`id`, `post_id`, `option_text`, `votes`) VALUES
(1, 5, 'Start early, study consistently', 124),
(2, 5, 'Cram the night before', 199),
(3, 5, 'Rely on group chats and past papers', 84),
(4, 5, 'Pray and submit anyway', 35);

-- Insert Comments
INSERT INTO `comments` (`post_id`, `author_id`, `author_name`, `body`, `parent_id`, `is_anonymous`, `upvotes`, `downvotes`) VALUES
(1, 'T202210344', 'Sofia Karim', 'This is a game changer! On-device inference keeps user data private and offline.', NULL, 0, 15, 0),
(2, 'T202102837', 'Marco Torres', 'Totally agree with the points mentioned here. Looking forward to more updates.', NULL, 0, 10, 0),
(3, 'T202110294', 'Ravi Joshi', 'Mental health leaves with academic accommodations would be so helpful, especially during midterms.', NULL, 0, 24, 0),
(4, 'T202210202', 'Catalina Smith', 'Excellent writeup! Easy to follow and super insightful.', NULL, 0, 8, 0),
(5, 'T202210202', 'Catalina Smith', 'I cram the night before but always tell myself I''ll start early next time 😂', NULL, 0, 32, 0),
(6, 'T202110294', 'Ravi Joshi', 'Hallway is always too noisy for group discussions, booking a room is definitely worth it!', NULL, 0, 18, 0);

-- 9. Communities Table
CREATE TABLE IF NOT EXISTS `communities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `theme_color` varchar(50) DEFAULT '#1A8B44',
  `icon` varchar(50) DEFAULT 'bi-cpu',
  `bg_class` varchar(50) DEFAULT 'bg-light-success',
  `text_class` varchar(50) DEFAULT 'text-success',
  `members` int(11) NOT NULL DEFAULT 1,
  `posts` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert Seed Communities
INSERT INTO `communities` (`title`, `desc`, `category`, `theme_color`, `icon`, `bg_class`, `text_class`, `members`, `posts`) VALUES
('FEU LIFE', 'Campus life, events, enrollment tips, and all things FEU Institute of Technology.', 'FEU TECH', '#1A8B44', 'bi-heart-fill', 'bg-light-danger', 'text-danger', 4894, 12450),
('FEU ALABANG LIFE', 'Campus life, events, enrollment tips, and all things FEU Alabang.', 'FEU ALABANG', '#1A8B44', 'bi-building-fill', 'bg-light-warning', 'text-warning', 3201, 8400),
('Freshies', 'A community for all the newcomers to share their thoughts and get advice.', 'my-communities', '#1A8B44', 'bi-people-fill', 'bg-light-primary', 'text-primary', 1500, 320),
('Enrollment', 'Everything you need to know about enrollment in FEU Diliman.', 'FEU DILIMAN', '#1A8B44', 'bi-journal-bookmark-fill', 'bg-light-info', 'text-info', 890, 120),
('Cosplaying', 'A place for cosplayers to meet and share their passion.', 'FEU TECH', '#1A8B44', 'bi-palette-fill', 'bg-light-info', 'text-info', 450, 201),
('FEU TECH DEV', 'For aspiring developers and software engineers in FEU Tech.', 'FEU TECH', '#1A8B44', 'bi-cpu', 'bg-light-success', 'text-success', 2100, 5400),
('Food Trip Around TECH', 'Best spots to eat around the campus.', 'FEU TECH', '#1A8B44', 'bi-cup-hot-fill', 'bg-light-warning', 'text-warning', 3400, 670),
('Thesis Advice', 'Help and resources for your final year project.', 'FEU DILIMAN', '#1A8B44', 'bi-journal-bookmark-fill', 'bg-light-info', 'text-info', 600, 450),
('Alabang Innovators', 'Tech startup and innovation community in Alabang.', 'FEU ALABANG', '#1A8B44', 'bi-lightbulb-fill', 'bg-light-warning', 'text-warning', 210, 80),
('Diliman Artists', 'Art and creative works from FEU Diliman.', 'FEU DILIMAN', '#1A8B44', 'bi-palette-fill', 'bg-light-info', 'text-info', 750, 340),
('Study Group', 'Find study partners across all campuses.', 'my-communities', '#1A8B44', 'bi-people-fill', 'bg-light-primary', 'text-primary', 1200, 890),
('Tech Support', 'IT support and discussions for students.', 'FEU TECH', '#1A8B44', 'bi-cpu', 'bg-light-success', 'text-success', 850, 230)
ON DUPLICATE KEY UPDATE `desc` = VALUES(`desc`);

-- 10. Community Members Table (Tracking who joined what community)
CREATE TABLE IF NOT EXISTS `community_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `community_title` varchar(255) NOT NULL,
  `identification` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_comm` (`community_title`, `identification`),
  CONSTRAINT `fk_member_comm` FOREIGN KEY (`community_title`) REFERENCES `communities` (`title`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert Seed Community Members for Catalina Smith (T202210202)
INSERT IGNORE INTO `community_members` (`community_title`, `identification`) VALUES
('FEU LIFE', 'T202210202'),
('FEU TECH DEV', 'T202210202'),
('Study Group', 'T202210202');

