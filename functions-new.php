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
    $_SESSION['identification'] = 'T202210202'; // Default: Catalina Smith
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

if (!function_exists('renderCategoryBadge')) {
    function renderCategoryBadge($category) {
        $badge = getCategoryBadgeStyle($category);
        return '<span class="badge ' . $badge['class'] . ' rounded-pill px-3 py-2 fs-8 fw-bold">' .
               '<i class="bi ' . $badge['icon'] . ' ' . $badge['icon_color'] . ' me-1"></i>' .
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
        $url   = '/Discourse/pages/view/topic.php?t=' . urlencode($label);
        return '<a href="' . $url . '" class="badge ' . $badge['class'] . ' rounded-pill px-3 py-2 fs-8 fw-bold text-decoration-none me-1">'
             . '<i class="bi ' . $badge['icon'] . ' ' . $badge['icon_color'] . ' me-1"></i>'
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
            $url = '/Discourse/pages/view/hashtag.php?tag=' . urlencode($t);
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
