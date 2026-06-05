<?php
session_name('mbg');
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// ── MySQL Database Connection (XAMPP) ──
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'discourse';

// Establish connection with silent fallback if database is not running/created yet
$EDITH = null;
try {
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if (!$conn->connect_error) {
        $conn->set_charset('utf8mb4');
        $EDITH = $conn;

        // Auto-initialize normalized hashtag tables & indexes
        $table_check = $EDITH->query("SHOW TABLES LIKE 'posts'");
        if ($table_check && $table_check->num_rows > 0) {
            $EDITH->query("CREATE TABLE IF NOT EXISTS `hashtags` (
              `id` INT AUTO_INCREMENT PRIMARY KEY,
              `name` VARCHAR(100) UNIQUE NOT NULL,
              `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

            $EDITH->query("CREATE TABLE IF NOT EXISTS `post_hashtags` (
              `post_id` INT NOT NULL,
              `hashtag_id` INT NOT NULL,
              PRIMARY KEY (`post_id`, `hashtag_id`),
              FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
              FOREIGN KEY (`hashtag_id`) REFERENCES `hashtags` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

            $EDITH->query("CREATE TABLE IF NOT EXISTS `followers` (
              `id` INT AUTO_INCREMENT PRIMARY KEY,
              `follower_id` VARCHAR(20) NOT NULL,
              `following_id` VARCHAR(20) NOT NULL,
              `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              UNIQUE KEY `follower_following` (`follower_id`, `following_id`),
              FOREIGN KEY (`follower_id`) REFERENCES `accounts` (`identification`) ON DELETE CASCADE,
              FOREIGN KEY (`following_id`) REFERENCES `accounts` (`identification`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
            
            // Create indexes
            $res = $EDITH->query("SHOW KEYS FROM `posts` WHERE Key_name = 'idx_posts_topic'");
            if ($res && $res->num_rows === 0) {
                $EDITH->query("ALTER TABLE `posts` ADD INDEX `idx_posts_topic` (`topic`)");
            }
            $res = $EDITH->query("SHOW KEYS FROM `posts` WHERE Key_name = 'idx_posts_community'");
            if ($res && $res->num_rows === 0) {
                $EDITH->query("ALTER TABLE `posts` ADD INDEX `idx_posts_community` (`community`)");
            }
            
            // Ensure logo_url column exists in communities
            $res_logo = $EDITH->query("SHOW COLUMNS FROM `communities` LIKE 'logo_url'");
            if ($res_logo && $res_logo->num_rows === 0) {
                $EDITH->query("ALTER TABLE `communities` ADD COLUMN `logo_url` VARCHAR(255) DEFAULT NULL");
            }
            
            // Ensure is_announcement column exists in posts
            $res_ann = $EDITH->query("SHOW COLUMNS FROM `posts` LIKE 'is_announcement'");
            if ($res_ann && $res_ann->num_rows === 0) {
                $EDITH->query("ALTER TABLE `posts` ADD COLUMN `is_announcement` TINYINT(4) NOT NULL DEFAULT 0");
            }
            
            // Ensure is_highlighted column exists in posts
            $res_hl = $EDITH->query("SHOW COLUMNS FROM `posts` LIKE 'is_highlighted'");
            if ($res_hl && $res_hl->num_rows === 0) {
                $EDITH->query("ALTER TABLE `posts` ADD COLUMN `is_highlighted` TINYINT(4) NOT NULL DEFAULT 0");
            }
            
            // Ensure cover_md, program, campus, bio columns exist in accounts
            $res_acct = $EDITH->query("SHOW COLUMNS FROM `accounts` LIKE 'cover_md'");
            if ($res_acct && $res_acct->num_rows === 0) {
                $EDITH->query("ALTER TABLE `accounts` ADD COLUMN `cover_md` VARCHAR(255) DEFAULT NULL");
            }
            $res_acct = $EDITH->query("SHOW COLUMNS FROM `accounts` LIKE 'program'");
            if ($res_acct && $res_acct->num_rows === 0) {
                $EDITH->query("ALTER TABLE `accounts` ADD COLUMN `program` VARCHAR(150) DEFAULT NULL");
            }
            $res_acct = $EDITH->query("SHOW COLUMNS FROM `accounts` LIKE 'campus'");
            if ($res_acct && $res_acct->num_rows === 0) {
                $EDITH->query("ALTER TABLE `accounts` ADD COLUMN `campus` VARCHAR(150) DEFAULT NULL");
            }
            $res_acct = $EDITH->query("SHOW COLUMNS FROM `accounts` LIKE 'bio'");
            if ($res_acct && $res_acct->num_rows === 0) {
                $EDITH->query("ALTER TABLE `accounts` ADD COLUMN `bio` TEXT DEFAULT NULL");
            }
            
            // Automatic backfill migration
            $res_count = $EDITH->query("SELECT COUNT(*) as cnt FROM `post_hashtags`");
            if ($res_count) {
                $row_count = $res_count->fetch_assoc();
                if ($row_count['cnt'] == 0) {
                    $posts_res = $EDITH->query("SELECT id, tags FROM posts WHERE tags IS NOT NULL AND tags != ''");
                    if ($posts_res) {
                        while ($post_row = $posts_res->fetch_assoc()) {
                            $pid = $post_row['id'];
                            $tags_raw = $post_row['tags'];
                            $tags = preg_split('/[,•]+/', $tags_raw);
                            foreach ($tags as $t) {
                                $t = trim($t);
                                if ($t === '') continue;
                                $t_clean = strtolower($t);
                                
                                $stmt = $EDITH->prepare("INSERT IGNORE INTO hashtags (name) VALUES (?)");
                                if ($stmt) {
                                    $stmt->bind_param("s", $t_clean);
                                    $stmt->execute();
                                    $stmt->close();
                                }
                                
                                $stmt = $EDITH->prepare("SELECT id FROM hashtags WHERE name = ?");
                                if ($stmt) {
                                    $stmt->bind_param("s", $t_clean);
                                    $stmt->execute();
                                    $hid_res = $stmt->get_result()->fetch_assoc();
                                    $stmt->close();
                                    
                                    if ($hid_res) {
                                        $hid = $hid_res['id'];
                                        $stmt = $EDITH->prepare("INSERT IGNORE INTO post_hashtags (post_id, hashtag_id) VALUES (?, ?)");
                                        if ($stmt) {
                                            $stmt->bind_param("ii", $pid, $hid);
                                            $stmt->execute();
                                            $stmt->close();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
} catch (Exception $e) {
    // Database connection failed, fallback gracefully
}

// Compatibility variables
$DB_SERVER   = $DB_HOST;
$DB_USERNAME = $DB_USER;
$DB_PASSWORD = $DB_PASS;
$DB_NAME_EDITH  = $DB_NAME;

// Define Identification Global (simulating logged in user or using session)
if (!isset($_SESSION['identification'])) {
    $_SESSION['identification'] = 'T202110117'; // Default: Marielle Basanes
}
$identification = $_SESSION['identification'];

// Helper Class for Sanitization (legacy compatibility)
class Sanitizer {
  public static function url($url) {
    return filter_var($url, FILTER_SANITIZE_URL);
  }
}

// Clean sanitization function for SQL input
if (!function_exists('sanitize')) {
    function sanitize($data) {
        global $EDITH;
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = sanitize($value);
            }
            return $data;
        }
        if (is_string($data)) {
            $data = trim($data);
            if ($EDITH) {
                return $EDITH->real_escape_string($data);
            } else {
                return addslashes($data);
            }
        }
        return $data;
    }
}

// Core Auth & Access Functions
if (!function_exists('IS_LOGGED_IN')) {
    function IS_LOGGED_IN($uri) {
      if (!isset($_SESSION['identification'])) {
        header("Location: /Discourse/index.php");
        exit();
      }
    }
}

if (!function_exists('DIRECT_ACCESS_BLOCKED')) {
    function DIRECT_ACCESS_BLOCKED() {
      if (!defined('MBG')) {
        die("Direct access blocked.");
      }
    }
}

// Get account details by identification
if (!function_exists('GET_ACCOUNT_DETAILS')) {
    function GET_ACCOUNT_DETAILS($id) {
      global $EDITH;
      
      // If we have a database connection, query it
      if ($EDITH) {
          $stmt = $EDITH->prepare("SELECT * FROM accounts WHERE identification = ?");
          if ($stmt) {
              $stmt->bind_param("s", $id);
              $stmt->execute();
              $result = $stmt->get_result()->fetch_assoc();
              $stmt->close();
              if ($result) {
                  return $result;
              }
          }
      }
      
      // Fallback/Mock data (used when database is offline or user not found in DB)
      $id_clean = trim($id);
      if ($id_clean === 'T202210344') {
          return [
              'identification' => 'T202210344',
              'display_name' => 'Sofia Karim',
              'role' => 'student',
              'avatar_md' => '/Discourse/assets/images/anonymous.png',
              'email' => 'sofia@example.com'
          ];
      } elseif ($id_clean === 'T202102837') {
          return [
              'identification' => 'T202102837',
              'display_name' => 'Marco Torres',
              'role' => 'student',
              'avatar_md' => '/Discourse/assets/images/catalina.webp',
              'email' => 'marco@example.com'
          ];
      } elseif ($id_clean === 'T202210202') {
          return [
              'identification' => 'T202210202',
              'display_name' => 'Catalina Smith',
              'role' => 'student',
              'avatar_md' => '/Discourse/assets/images/catalina.webp',
              'email' => 'catalina@example.com'
          ];
      } else {
          return [
              'identification' => $id_clean,
              'display_name' => 'User ' . $id_clean,
              'role' => 'student',
              'avatar_md' => '/Discourse/assets/images/anonymous.png',
              'email' => ''
          ];
      }
    }
}

// Fetch Account Info for current logged in user
$ACCOUNT = GET_ACCOUNT_DETAILS($identification);

if (!function_exists('DISPLAY_NAME')) {
    function DISPLAY_NAME($account) {
      return $account['display_name'] ?? 'User';
    }
}

if (!function_exists('getUserClassification')) {
    function getUserClassification($id) {
      $account = GET_ACCOUNT_DETAILS($id);
      if ($account && $account['role'] === 'admin') {
          return 'Associate';
      }
      return 'Student';
    }
}

if (!function_exists('respondWithError')) {
    function respondWithError($message) {
      header('Content-Type: application/json');
      echo json_encode(['status' => 'error', 'message' => $message]);
      exit();
    }
}

if (!function_exists('getUserAvatar')) {
    function getUserAvatar($id, $size = "MD") {
      $account = GET_ACCOUNT_DETAILS($id);
      return !empty($account['avatar_md']) ? $account['avatar_md'] : '/Discourse/assets/images/anonymous.png';
    }
}

// Asset Base Path
$BASE_PATH = "/Discourse";

if (!function_exists('getLightColorStyle')) {
    function getLightColorStyle($hex) {
        if (empty($hex)) $hex = '#1A8B44';
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2) ?: '0');
            $g = hexdec(substr($hex, 2, 2) ?: '0');
            $b = hexdec(substr($hex, 4, 2) ?: '0');
        }
        return "background-color: rgba($r, $g, $b, 0.1) !important; color: #$hex !important;";
    }
}

function HEAD_ESSENTIALS()
{
  global $META_TITLE;
  global $META_DESC;
  global $META_IMAGE;
  global $identification;

  $META_TITLE = empty($META_TITLE) ? "Educational Innovation and Technology Hub" : htmlspecialchars(
    $META_TITLE,
    ENT_NOQUOTES
  );
  $META_IMAGE = empty($META_IMAGE) ? "https://paraverse.feutech.edu.ph/assets/img/office.jpg" :
    Sanitizer::url($META_IMAGE);
  $META_LINK = "https://" . $_SERVER['HTTP_HOST'] . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

  $maintenance = isset($_SESSION['loggedins'])
    ? "
<script>
  $(document).ready(function () {
    var alertBox = $('<div class=\"alert bg-light-danger fw-semibold text-center fs-5 py-7 px-lg-20\"></div>')
      .html(`
                        <div class=\"app-container container-xxl\">
                            Some features may be temporarily unavailable as we complete recent updates. 
                            We are working to restore full functionality as quickly as possible. 
                            If you encounter any errors or issues, 
                            <a href='javascript:void(0);' id='reportLink' style='text-decoration:underline; color:blue;'>report here</a>. 
                            Thank you for your patience! ❤️
                        </div>
                    `);

    $('.app-wrapper').prepend(alertBox);

    $(document).on('click', '#reportLink', function () {
      $('#open-modal-feedback')[0].click();
      $('[feedback=\"report\"]')[0].click();
    });
  });
</script>
" : null;

  echo '
<title>' . $META_TITLE . '</title>
<meta charset="UTF-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="' . $META_DESC . '">

<meta property="og:title" content="' . $META_TITLE . '" />
<meta property="og:url" content="' . $META_LINK . '" />
<meta property="og:image" content="' . $META_IMAGE . '" />
<meta property="og:description" content="' . $META_DESC . '">
<meta property="og:type" content="article" />
<meta property="og:locale" content="en_US" />
<meta property="og:site_name" content="Educational Innovation and Technology Hub" />

<meta name="twitter:title" content="' . $META_TITLE . '">
<meta name="twitter:description" content="' . $META_DESC . '">
<meta name="twitter:image" content="' . $META_IMAGE . '">
<meta name="twitter:card" content="summary_large_image">

<link rel="icon" type="image/x-icon" href="/Discourse/assets/img/favicon.png">
<link rel="manifest" href="/Discourse/assets/site.webmanifest?v=2">

<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Paraverse">
<link rel="apple-touch-icon" href="/Discourse/assets/img/logo/icon-paraverse-192.png">

<link rel="stylesheet" href="/Discourse/assets/plugins/global/plugins.bundle.css">
<link rel="stylesheet" href="/Discourse/assets/css/style.keenicons.css">
<link rel="stylesheet" href="/Discourse/assets/css/style.bundle.v2.full.css?version=1.1028">

<script src="/Discourse/assets/js/jquery.js"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
  href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&Libre+Franklin:wght@400;600;800&family=News+Cycle:wght@700&display=swap"
  rel="stylesheet">

<script async src="https://www.googletagmanager.com/gtag/js?id=G-SR6Q4GLJJH"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag() { dataLayer.push(arguments); }
  gtag(\'js\', new Date());
                gtag(\'config\', \'G-SR6Q4GLJJH\');
</script>

<script>
            // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
            if (window.top != window.self) {
    // window.top.location.replace(window.self.location.href);
  }
</script>
' . $maintenance;
}

if (!function_exists('sort_discourse_posts')) {
    function sort_discourse_posts($posts, $criteria) {
        $sorted = $posts;
        if ($criteria === 'new') {
            usort($sorted, function($a, $b) {
                return strtotime($b['created_at'] ?? 'now') - strtotime($a['created_at'] ?? 'now');
            });
        } elseif ($criteria === 'top') {
            usort($sorted, function($a, $b) {
                $score_a = ($a['upvotes'] ?? 0) - ($a['downvotes'] ?? 0);
                $score_b = ($b['upvotes'] ?? 0) - ($b['downvotes'] ?? 0);
                return $score_b - $score_a;
            });
        } elseif ($criteria === 'rising') {
            usort($sorted, function($a, $b) {
                $now = time();
                $age_a = max(1, ($now - strtotime($a['created_at'] ?? 'now')) / 3600);
                $age_b = max(1, ($now - strtotime($b['created_at'] ?? 'now')) / 3600);
                $score_a = (($a['comment_count'] ?? 0) * 3 + ($a['upvotes'] ?? 0)) / pow($age_a + 2, 1.2);
                $score_b = (($b['comment_count'] ?? 0) * 3 + ($b['upvotes'] ?? 0)) / pow($age_b + 2, 1.2);
                if ($score_a == $score_b) return 0;
                return ($score_b > $score_a) ? 1 : -1;
            });
        } else { // 'hot'
            usort($sorted, function($a, $b) {
                $now = time();
                $age_a = max(1, ($now - strtotime($a['created_at'] ?? 'now')) / 3600);
                $age_b = max(1, ($now - strtotime($b['created_at'] ?? 'now')) / 3600);
                $score_a = (($a['upvotes'] ?? 0) - ($a['downvotes'] ?? 0) + ($a['comment_count'] ?? 0) * 2) / pow($age_a + 2, 1.5);
                $score_b = (($b['upvotes'] ?? 0) - ($b['downvotes'] ?? 0) + ($b['comment_count'] ?? 0) * 2) / pow($age_b + 2, 1.5);
                if ($score_a == $score_b) return 0;
                return ($score_b > $score_a) ? 1 : -1;
            });
        }
        return $sorted;
    }
}

if (!function_exists('get_relative_time')) {
    function get_relative_time($datetime) {
        $time = strtotime($datetime);
        if (!$time) return '1d ago';
        $now = time();
        $diff = $now - $time;
        if ($diff < 60) {
            return 'Just now';
        }
        $diff = round($diff / 60);
        if ($diff < 60) {
            return $diff . 'm ago';
        }
        $diff = round($diff / 60);
        if ($diff < 24) {
            return $diff . 'h ago';
        }
        $diff = round($diff / 24);
        if ($diff < 30) {
            return $diff . 'd ago';
        }
        return date('F j, Y', $time);
    }
}

if (!function_exists('getCategoryBadgeStyle')) {
  function getCategoryBadgeStyle($category)
  {
    $cat = strtoupper(trim($category));
    switch ($cat) {
      case 'ANNOUNCEMENT':
        return ['class' => 'badge-light-success',  'icon' => 'bi-megaphone',         'icon_color' => 'text-success'];
      case 'TECHNOLOGY':
        return ['class' => 'badge-light-primary',  'icon' => 'bi-cpu',               'icon_color' => 'text-primary'];
      case 'CULTURE':
        return ['class' => 'badge-light-danger',   'icon' => 'bi-palette',           'icon_color' => 'text-danger'];
      case 'GAMING':
        return ['class' => 'badge-light-warning',  'icon' => 'bi-controller',        'icon_color' => 'text-warning'];
      case 'FEU':
        return ['class' => 'badge-light-warning',  'icon' => 'bi-building',          'icon_color' => 'text-warning'];
      case 'IDEAS':
        return ['class' => 'badge-light-info',     'icon' => 'bi-lightbulb',         'icon_color' => 'text-info'];
      case 'CREATIVE':
        return ['class' => 'badge-light-primary',  'icon' => 'bi-stars',             'icon_color' => 'text-primary'];
      case 'SCIENCE':
        return ['class' => 'badge-light-info',     'icon' => 'bi-droplet-half',      'icon_color' => 'text-info'];
      case 'NEWS':
        return ['class' => 'badge-light-danger',   'icon' => 'bi-newspaper',         'icon_color' => 'text-danger'];
      case 'AI':
        return ['class' => 'badge-light-success',  'icon' => 'bi-robot',             'icon_color' => 'text-success'];
      case 'ACADEMICS':
        return ['class' => 'badge-light-warning',  'icon' => 'bi-book',              'icon_color' => 'text-warning'];
      case 'LIFESTYLE':
        return ['class' => 'badge-light-info',     'icon' => 'bi-emoji-smile',       'icon_color' => 'text-info'];
      case 'ENTERTAINMENT':
        return ['class' => 'badge-light-primary',  'icon' => 'bi-film',              'icon_color' => 'text-primary'];
      case 'MUSIC':
        return ['class' => 'badge-light-danger',   'icon' => 'bi-music-note',        'icon_color' => 'text-danger'];
      case 'POLITICS':
        return ['class' => 'badge-light-dark',     'icon' => 'bi-megaphone',         'icon_color' => 'text-dark'];
      case 'ISSUES':
        return ['class' => 'badge-light-danger',   'icon' => 'bi-exclamation-circle', 'icon_color' => 'text-danger'];
      case 'SPORTS':
        return ['class' => 'badge-light-warning',  'icon' => 'bi-trophy',            'icon_color' => 'text-warning'];
      default:
        // Try case-insensitive substring matches
        if (stripos($cat, 'TECH') !== false) {
          return ['class' => 'badge-light-primary',  'icon' => 'bi-cpu',               'icon_color' => 'text-primary'];
        } elseif (stripos($cat, 'ACAD') !== false) {
          return ['class' => 'badge-light-warning',  'icon' => 'bi-book',              'icon_color' => 'text-warning'];
        } elseif (stripos($cat, 'SPORT') !== false) {
          return ['class' => 'badge-light-warning',  'icon' => 'bi-trophy',            'icon_color' => 'text-warning'];
        } elseif (stripos($cat, 'LIFE') !== false) {
          return ['class' => 'badge-light-info',     'icon' => 'bi-emoji-smile',       'icon_color' => 'text-info'];
        } else {
          return ['class' => 'badge-light-secondary', 'icon' => 'bi-tag',               'icon_color' => 'text-secondary'];
        }
}
  }
}

if (!function_exists('getCommunityIconDetails')) {
  function getCommunityIconDetails($name, $category = null)
  {
    $name_lower = strtolower($name);

    // Default: FEU Tech — matches sidebar: bg-light-success text-success, bi-cpu
    $icon       = "bi-cpu";
    $bg_class   = "bg-light-success";
    $text_class = "text-success";

    if (strpos($name_lower, 'life') !== false) {
      // FEU Life — matches sidebar: bg-light-danger text-danger, bi-heart-fill
      $icon       = "bi-heart-fill";
      $bg_class   = "bg-light-danger";
      $text_class = "text-danger";
    } elseif (strpos($name_lower, 'culture') !== false || strpos($name_lower, 'hub') !== false) {
      // CultureHub — matches sidebar: bg-light-primary text-primary, bi-music-note-beamed
      $icon       = "bi-music-note-beamed";
      $bg_class   = "bg-light-primary";
      $text_class = "text-primary";
    } elseif (strpos($name_lower, 'fresh') !== false || strpos($name_lower, 'study') !== false || strpos($name_lower, 'group') !== false) {
      $icon       = "bi-people-fill";
      $bg_class   = "bg-light-info";
      $text_class = "text-info";
    } elseif (strpos($name_lower, 'food') !== false || strpos($name_lower, 'trip') !== false) {
      $icon       = "bi-cup-hot-fill";
      $bg_class   = "bg-light-warning";
      $text_class = "text-warning";
    } elseif (strpos($name_lower, 'cosplay') !== false || strpos($name_lower, 'artist') !== false) {
      $icon       = "bi-palette-fill";
      $bg_class   = "bg-light-primary";
      $text_class = "text-primary";
    } elseif (strpos($name_lower, 'enroll') !== false || strpos($name_lower, 'thesis') !== false || strpos($name_lower, 'advice') !== false) {
      $icon       = "bi-journal-bookmark-fill";
      $bg_class   = "bg-light-warning";
      $text_class = "text-warning";
    } elseif (strpos($name_lower, 'innovat') !== false) {
      $icon       = "bi-lightbulb-fill";
      $bg_class   = "bg-light-warning";
      $text_class = "text-warning";
    } elseif (strpos($name_lower, 'alabang') !== false) {
      $icon       = "bi-building-fill";
      $bg_class   = "bg-light-warning";
      $text_class = "text-warning";
    } elseif (strpos($name_lower, 'diliman') !== false) {
      $icon       = "bi-mortarboard-fill";
      $bg_class   = "bg-light-info";
      $text_class = "text-info";
    }

    return [
      'icon'       => $icon,
      'bg_class'   => $bg_class,
      'text_class' => $text_class,
      // keep hex keys as empty so old code doesn't break
      'bg_hex'     => '',
      'color_hex'  => '',
    ];
  }
}


if (!function_exists('renderCategoryBadge')) {
    function renderCategoryBadge($category) {
        $badge = getCategoryBadgeStyle($category);
        return '<span class="badge ' . $badge['class'] . ' rounded-pill px-3 py-2 fs-8 fw-bold">' .
               htmlspecialchars($category) . '</span>';
    }
}

if (!function_exists('IS_COMMUNITY_MEMBER')) {
    function IS_COMMUNITY_MEMBER($community_title, $identification) {
        global $EDITH;
        if (!$EDITH) {
            // Fallback: check session
            if (isset($_SESSION['joined_communities']) && is_array($_SESSION['joined_communities'])) {
                return in_array($community_title, $_SESSION['joined_communities']);
            }
            return false;
        }
        $stmt = $EDITH->prepare("SELECT 1 FROM community_members WHERE community_title = ? AND identification = ?");
        if ($stmt) {
            $stmt->bind_param("ss", $community_title, $identification);
            $stmt->execute();
            $stmt->store_result();
            $is_member = ($stmt->num_rows > 0);
            $stmt->close();
            return $is_member;
        }
        return false;
    }
}

if (!function_exists('IS_POST_SAVED')) {
    function IS_POST_SAVED($post_id, $identification) {
        global $EDITH;
        if (!$EDITH) {
            // Fallback: check session
            if (isset($_SESSION['saved_posts']) && is_array($_SESSION['saved_posts'])) {
                return in_array($post_id, $_SESSION['saved_posts']);
            }
            return false;
        }
        $stmt = $EDITH->prepare("SELECT 1 FROM saved_posts WHERE post_id = ? AND identification = ?");
        if ($stmt) {
            $stmt->bind_param("is", $post_id, $identification);
            $stmt->execute();
            $stmt->store_result();
            $is_saved = ($stmt->num_rows > 0);
            $stmt->close();
            return $is_saved;
        }
        return false;
    }
}



if (!function_exists('renderTopicBadge')) {
    function renderTopicBadge($topic) {
        if (empty($topic)) return '';
        if (!function_exists('getCategoryBadgeStyle')) return '';
        $badge = getCategoryBadgeStyle(strtoupper(trim($topic)));
        $label = strtoupper(trim($topic));
        $url   = '/Discourse/topics/index.php?t=' . urlencode($label);
        return '<a href="' . $url . '" class="badge ' . $badge['class'] . ' rounded-pill px-3 py-2 fs-8 fw-bold text-decoration-none me-1">'
             . htmlspecialchars($label)
             . '</a>';
    }
}

if (!function_exists('renderHashtagBadges')) {
    function renderHashtagBadges($tags_raw, $limit = 4) {
        if (empty($tags_raw)) return '';
        // Split by comma or bullet separator
        $tags = preg_split('/[,•]+/', $tags_raw);
        $html = '';
        $count = 0;
        foreach ($tags as $t) {
            $t = trim($t);
            if ($t === '') continue;
            $url = '/Discourse/hashtags/index.php?tag=' . urlencode($t);
            $html .= '<a href="' . $url . '" class="badge rounded-pill px-2 py-1 fs-9 fw-semibold text-decoration-none text-muted" '
                   . 'style="background:#f1f3f4;border:1px solid #e0e0e0;" '
                   . 'onmouseover="this.style.background=\'#e8ede9\'" onmouseout="this.style.background=\'#f1f3f4\'">'
                   . '#' . htmlspecialchars(strtolower($t))
                   . '</a> ';
            if (++$count >= $limit) break;
        }
        return $html;
    }
}

if (!function_exists('MIGRATE_POST_HASHTAGS')) {
    function MIGRATE_POST_HASHTAGS($post_id, $tags_raw) {
        global $EDITH;
        if (!$EDITH || empty($tags_raw)) return;
        $tags = preg_split('/[,•]+/', $tags_raw);
        foreach ($tags as $t) {
            $t = trim($t);
            if ($t === '') continue;
            $t_clean = strtolower($t);
            
            $stmt = $EDITH->prepare("INSERT IGNORE INTO hashtags (name) VALUES (?)");
            if ($stmt) {
                $stmt->bind_param("s", $t_clean);
                $stmt->execute();
                $stmt->close();
            }
            
            $stmt = $EDITH->prepare("SELECT id FROM hashtags WHERE name = ?");
            if ($stmt) {
                $stmt->bind_param("s", $t_clean);
                $stmt->execute();
                $hid_res = $stmt->get_result()->fetch_assoc();
                $stmt->close();
                
                if ($hid_res) {
                    $hid = $hid_res['id'];
                    $stmt = $EDITH->prepare("INSERT IGNORE INTO post_hashtags (post_id, hashtag_id) VALUES (?, ?)");
                    if ($stmt) {
                        $stmt->bind_param("ii", $post_id, $hid);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
            }
        }
    }
}

if (!function_exists('linkHashtags')) {
    function linkHashtags($text) {
        if (empty($text)) return '';
        return preg_replace_callback(
            '/(<[^>]*>)|(?<![a-zA-Z0-9&])#([a-zA-Z0-9_]+)/i',
            function($matches) {
                // If it matched an HTML tag (Group 1 is not empty), return the whole tag unmodified
                if (!empty($matches[1])) {
                    return $matches[1];
                }
                $tag = $matches[2];
                if (is_numeric($tag)) {
                    return $matches[0];
                }
                $url = '/Discourse/hashtags/index.php?tag=' . urlencode(strtolower($tag));
                return '<a href="' . $url . '" class="text-primary text-decoration-none fw-semibold">#' . htmlspecialchars($tag) . '</a>';
            },
            $text
        );
    }
}

