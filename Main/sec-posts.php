<?php
if (!function_exists('getCommunityIconDetails')) {
  function getCommunityIconDetails($name, $category = null)
  {
    $name_lower = strtolower($name);

    $icon       = "bi-cpu";
    $bg_class   = "bg-light-success";
    $text_class = "text-success";

    if (strpos($name_lower, 'life') !== false) {
      $icon       = "bi-heart-fill";
      $bg_class   = "bg-light-danger";
      $text_class = "text-danger";
    } elseif (strpos($name_lower, 'culture') !== false || strpos($name_lower, 'hub') !== false) {
      $icon       = "bi-music-note-beamed";
      $bg_class   = "bg-light-primary";
      $text_class = "text-primary";
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
    } elseif (strpos($name_lower, 'innovat') !== false || strpos($name_lower, 'startup') !== false) {
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
    } elseif (strpos($name_lower, 'fresh') !== false || strpos($name_lower, 'study') !== false || strpos($name_lower, 'group') !== false) {
      $icon       = "bi-people-fill";
      $bg_class   = "bg-light-info";
      $text_class = "text-info";
    } elseif (strpos($name_lower, 'tech') !== false || strpos($name_lower, 'dev') !== false || strpos($name_lower, 'support') !== false) {
      $icon       = "bi-cpu-fill";
      $bg_class   = "bg-light-success";
      $text_class = "text-success";
    }

    return [
      'icon'       => $icon,
      'bg_class'   => $bg_class,
      'text_class' => $text_class,
      'bg_hex'     => '',
      'color_hex'  => '',
    ];
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
        return ['class' => 'badge-light-secondary', 'icon' => 'bi-tag',               'icon_color' => 'text-secondary'];
    }
  }
}

// Dynamic Fetching from Database with fallback

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

$feed_posts = [];
if (isset($EDITH) && $EDITH) {
    $query = "SELECT p.*, a.display_name, a.avatar_md, a.role as author_role
              FROM posts p
              JOIN accounts a ON p.author_id = a.identification
              ORDER BY p.created_at DESC";
    $result = $EDITH->query($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            // Get comment count
            $stmt_cc = $EDITH->prepare("SELECT COUNT(*) as cc FROM comments WHERE post_id = ?");
            $stmt_cc->bind_param("i", $row['id']);
            $stmt_cc->execute();
            $cc_res = $stmt_cc->get_result()->fetch_assoc();
            $row['comment_count'] = $cc_res['cc'] ?? 0;
            $stmt_cc->close();

            // Load comments list
            $row['comments'] = [];
            $stmt_c = $EDITH->prepare("SELECT c.*, a.avatar_md 
                                       FROM comments c 
                                       LEFT JOIN accounts a ON c.author_id = a.identification 
                                       WHERE c.post_id = ? AND c.parent_id IS NULL
                                       ORDER BY c.created_at ASC LIMIT 5");
            $stmt_c->bind_param("i", $row['id']);
            $stmt_c->execute();
            $c_res = $stmt_c->get_result();
            while ($c_row = $c_res->fetch_assoc()) {
                $row['comments'][] = $c_row;
            }
            $stmt_c->close();
            
            // If it is a poll, load options
            if ($row['is_poll']) {
                $options_query = "SELECT * FROM poll_options WHERE post_id = ?";
                $stmt_opt = $EDITH->prepare($options_query);
                $stmt_opt->bind_param("i", $row['id']);
                $stmt_opt->execute();
                $opt_res = $stmt_opt->get_result();
                $row['poll_options'] = [];
                $total_votes = 0;
                while ($opt = $opt_res->fetch_assoc()) {
                    $row['poll_options'][] = $opt;
                    $total_votes += $opt['votes'];
                }
                $row['total_poll_votes'] = $total_votes;
                $stmt_opt->close();
            }
            $feed_posts[] = $row;
        }
    }
}

// Add session mock posts if any exist
if (isset($_SESSION['mock_posts']) && is_array($_SESSION['mock_posts'])) {
    $existing_ids = array_column($feed_posts, 'id');
    $existing_slugs = array_column($feed_posts, 'slug');
    foreach ($_SESSION['mock_posts'] as $mp) {
        if (!in_array($mp['id'], $existing_ids) && !in_array($mp['slug'], $existing_slugs)) {
            array_unshift($feed_posts, $mp);
        }
    }
}

if (empty($feed_posts)) {
    // Mock posts fallback matching exactly the existing HTML design
    $feed_posts = [
        [
            'id' => 1,
            'title' => 'The silent revolution in edge AI — why on-device inference is changing everything',
            'body' => ' A decade optimizing for server-side compute, but the thermal envelope of modern SoCs has quietly crossed a threshold nobody was paying attention to. Here\'s why 2025 is the last year data centers dominate...',
            'author_id' => 'T202110294',
            'display_name' => 'Ravi Joshi',
            'avatar_md' => '/Discourse/assets/images/catalina.webp',
            'community' => 'FEU TECH DEV',
            'topic' => 'TECHNOLOGY',
            'tags' => 'Technology',
            'slug' => 'silent-revolution-edge-ai',
            'upvotes' => 214,
            'downvotes' => 0,
            'comment_count' => 1,
            'is_anonymous' => 0,
            'is_poll' => 0,
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'comments' => [
                [
                    'author_name' => 'Sofia Karim',
                    'avatar_md' => 'https://ui-avatars.com/api/?name=Sofia+Karim&background=f3f4f6&color=d97706&rounded=true',
                    'body' => 'This is a game changer! On-device inference keeps user data private and offline.',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
                ]
            ]
        ],
        [
            'id' => 2,
            'title' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec.',
            'body' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Nullam accumsan lorem in dui. Cras ultricies mi eu turpis hendrerit fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In ac dui quis mi consectetuer lacinia. Nam pretium turpis et arcu. Duis arcu tortor, suscipit eget, imperdiet nec, imperdiet iaculis, ipsum. Sed aliquam ultrices mauris. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Praesent adipiscing. Phasellus ullamcorper ipsum rutrum nunc. Nunc nonummy metus. Vestib',
            'author_id' => 'T202008123',
            'display_name' => 'John Doe',
            'avatar_md' => '/Discourse/assets/images/catalina.webp',
            'community' => 'FEU TECH DEV',
            'topic' => 'TECHNOLOGY',
            'tags' => 'Technology',
            'slug' => 'lorem-ipsum-dolor-sit-amet',
            'upvotes' => 214,
            'downvotes' => 0,
            'comment_count' => 1,
            'is_anonymous' => 0,
            'is_poll' => 0,
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'comments' => [
                [
                    'author_name' => 'Marco Torres',
                    'avatar_md' => 'https://ui-avatars.com/api/?name=Marco+Torres&background=e0f2fe&color=0369a1&rounded=true',
                    'body' => 'Totally agree with the points mentioned here. Looking forward to more updates.',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-3 hours'))
                ]
            ]
        ],
        [
            'id' => 3,
            'title' => 'What if FEU had a no-grade-penalty mental health leave policy?',
            'body' => ' Just thinking — a lot of students I know failed a whole semester because they were dealing with severe anxiety during midterms. The university had no mechanism to help them — just a...',
            'author_id' => 'T202210202',
            'display_name' => 'Anonymous',
            'avatar_md' => '/Discourse/assets/images/anonymous.png',
            'community' => 'FEU TECH DEV',
            'topic' => 'TECHNOLOGY',
            'tags' => 'Technology',
            'slug' => 'what-if-feu-had-mental-health-leave',
            'upvotes' => 214,
            'downvotes' => 0,
            'comment_count' => 1,
            'is_anonymous' => 1,
            'is_poll' => 0,
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'comments' => [
                [
                    'author_name' => 'Ravi Joshi',
                    'avatar_md' => '/Discourse/assets/images/catalina.webp',
                    'body' => 'Mental health leaves with academic accommodations would be so helpful, especially during midterms.',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-5 hours'))
                ]
            ]
        ],
        [
            'id' => 4,
            'title' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit.',
            'body' => ' Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam uma tempor.',
            'author_id' => 'T202008123',
            'display_name' => 'John Doe',
            'avatar_md' => '/Discourse/assets/images/catalina.webp',
            'community' => 'FEU TECH DEV',
            'topic' => 'TECHNOLOGY',
            'tags' => 'Technology',
            'slug' => 'lorem-ipsum-consectetur-adipiscing',
            'upvotes' => 214,
            'downvotes' => 0,
            'comment_count' => 1,
            'is_anonymous' => 0,
            'is_poll' => 0,
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'comments' => [
                [
                    'author_name' => 'Catalina Smith',
                    'avatar_md' => '/Discourse/assets/images/catalina.webp',
                    'body' => 'Excellent writeup! Easy to follow and super insightful.',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour'))
                ]
            ]
        ],
        [
            'id' => 5,
            'title' => '📊 Poll: How do you actually study for finals? Be honest.',
            'body' => 'Curious how my fellow FEU Tech students survive finals season. Drop your honest answer below 👇',
            'author_id' => 'T202102837',
            'display_name' => 'Marco Torres',
            'avatar_md' => '/Discourse/assets/images/catalina.webp',
            'community' => 'FEU LIFE',
            'topic' => 'FEU',
            'tags' => 'FEU',
            'slug' => 'poll-how-do-you-study-finals',
            'upvotes' => 456,
            'downvotes' => 0,
            'comment_count' => 1,
            'is_anonymous' => 0,
            'is_poll' => 1,
            'poll_options' => [
                ['id' => 1, 'option_text' => 'Start early, study consistently', 'votes' => 124],
                ['id' => 2, 'option_text' => 'Cram the night before', 'votes' => 199],
                ['id' => 3, 'option_text' => 'Rely on group chats and past papers', 'votes' => 84],
                ['id' => 4, 'option_text' => 'Pray and submit anyway', 'votes' => 35]
            ],
            'total_poll_votes' => 442,
            'created_at' => date('Y-m-d H:i:s', strtotime('-4 hours')),
            'comments' => [
                [
                    'author_name' => 'Catalina Smith',
                    'avatar_md' => '/Discourse/assets/images/catalina.webp',
                    'body' => 'I cram the night before but always tell myself I\'ll start early next time 😂',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-4 hours'))
                ]
            ]
        ],
        [
            'id' => 6,
            'title' => 'FEU Tech library study rooms — worth booking or just use the hallway?',
            'body' => ' Finally tried booking one of the new study rooms in the library. Honest review: the booking system is clunky, the AC is questionable, but the...',
            'author_id' => 'T202210202',
            'display_name' => 'Catalina Smith',
            'avatar_md' => '/Discourse/assets/images/catalina.webp',
            'community' => 'FEU TECH DEV',
            'topic' => 'TECHNOLOGY',
            'tags' => 'Technology',
            'slug' => 'feu-tech-library-study-rooms',
            'upvotes' => 214,
            'downvotes' => 0,
            'comment_count' => 1,
            'is_anonymous' => 0,
            'is_poll' => 0,
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'comments' => [
                [
                    'author_name' => 'Ravi Joshi',
                    'avatar_md' => '/Discourse/assets/images/catalina.webp',
                    'body' => 'Hallway is always too noisy for group discussions, booking a room is definitely worth it!',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-30 minutes'))
                ]
            ]
        ]
    ];
}
?>

<?php
$posts_hot = sort_discourse_posts($feed_posts, 'hot');
$posts_new = sort_discourse_posts($feed_posts, 'new');
$posts_top = sort_discourse_posts($feed_posts, 'top');
$posts_rising = sort_discourse_posts($feed_posts, 'rising');

if (!function_exists('renderPostCardMarkup')) {
    function renderPostCardMarkup($post, $ACCOUNT) {
        global $identification;
        $commDetails = getCommunityIconDetails($post['community']);
        $isAnon = (isset($post['is_anonymous']) && $post['is_anonymous'] == 1);
        $avatar = $isAnon ? '/Discourse/assets/images/anonymous.png' : (!empty($post['avatar_md']) ? $post['avatar_md'] : '/Discourse/assets/images/anonymous.png');
        $authorName = $isAnon ? 'Anonymous' : ($post['display_name'] ?? 'User');
        $authorLink = $isAnon ? 'javascript:void(0)' : '/Discourse/pages/version/profile-other.php?id=' . $post['author_id'];
        ?>
        <!-- ── Post Card ── -->
        <div class="card border-0 shadow mb-5" data-dc="post-card" data-post-id="<?php echo $post['id']; ?>">
          <div class="d-flex">
    
            <!-- Vote Column -->
            <div class="d-flex flex-column align-items-center gap-1 p-3" style="width:55px;flex-shrink:0;background-color:#e8ede9;">
              <button class="btn btn-sm btn-tertiary dc-vote-up" title="Upvote">
                <i class="bi bi-hand-thumbs-up p-0"></i>
              </button>
              <span class="fs-7 fw-bold text-gray-600 dc-vote-count"><?php echo $post['upvotes']; ?></span>
              <button class="btn btn-sm btn-tertiary dc-vote-down" title="Downvote">
                <i class="bi bi-hand-thumbs-down p-0"></i>
              </button>
            </div>
    
            <!-- Post Content -->
            <div class="d-flex flex-column py-5 flex-grow-1">
              <div class="row g-0 px-5">
    
                <!-- Row 1: Community badge + Report button -->
                <div class="col-12 mb-2">
                  <div class="d-flex justify-content-between align-items-center">
                    <a href="/Discourse/pages/version/community.php?c=<?php echo urlencode($post['community']); ?>" class="d-flex align-items-center gap-2 text-decoration-none">
                      <div class="d-flex align-items-center justify-content-center rounded-2 <?php echo $commDetails['bg_class']; ?>"
                           style="width: 24px; height: 24px;">
                        <i class="bi <?php echo $commDetails['icon']; ?> fs-8 <?php echo $commDetails['text_class']; ?>"></i>
                      </div>
                      <span class="fw-bold text-gray-800 text-hover-primary fs-7">c/<?php echo htmlspecialchars($post['community']); ?></span>
                    </a>
                    <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalReportPost">
                      <i class="bi bi-flag me-1"></i> Report
                    </button>
                  </div>
                </div>
    
                <!-- Row 2: Avatar + Author name + Timestamp -->
                <div class="col-12 mb-2">
                  <div class="d-flex gap-3 align-items-center">
                    <img src="<?php echo $avatar; ?>" alt="<?php echo htmlspecialchars($authorName); ?>" class="h-40px w-40px rounded-circle" />
                    <div class="d-flex flex-column">
                      <a href="<?php echo $authorLink; ?>" class="fs-6 fw-bold text-gray-800 text-hover-primary"><?php echo htmlspecialchars($authorName); ?></a>
                      <span class="text-muted fs-8"><i class="bi bi-clock me-1 fs-8"></i><?php echo get_relative_time($post['created_at']); ?></span>
                    </div>
                  </div>
                </div>
    
                <!-- Row 3: Title + Excerpt -->
                <div class="col-12 mb-2">
                  <div class="d-flex flex-column gap-2 text-start">
                    <div class="d-flex flex-wrap align-items-center gap-1">
                      <?php echo renderTopicBadge($post['topic']); ?>
                    </div>
                    <a href="/Discourse/pages/version/view-post.php?id=<?php echo $post['id']; ?>" class="text-gray-800 text-hover-primary fs-5 fw-bold dc-post-title-link">
                      <?php echo htmlspecialchars($post['title']); ?>
                    </a>
                    <div class="dc-body-wrap">
                      <span class="fs-7 text-gray-700 dc-body-clamp"><?php echo strip_tags($post['body']); ?></span>
                      <a href="#" class="dc-see-more-link fw-semibold cursor-pointer d-none" onclick="dcToggleBody(event, this)">See More</a>
                    </div>
                    <?php $htags = renderHashtagBadges($post['tags'] ?? ''); if ($htags): ?>
                    <div class="d-flex flex-wrap align-items-center gap-1 mt-1">
                      <?php echo $htags; ?>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
    
                <!-- Poll Options (If applicable) -->
                <?php if (isset($post['is_poll']) && $post['is_poll'] == 1 && !empty($post['poll_options'])) { ?>
                <div class="col-12 mb-2">
                  <div class="d-flex flex-column gap-2 mb-2 discourse-poll-options">
                    <?php foreach ($post['poll_options'] as $opt) { 
                        $pct = ($post['total_poll_votes'] > 0) ? round(($opt['votes'] / $post['total_poll_votes']) * 100) : 0;
                    ?>
                    <button class="discourse-poll-option" data-poll-id="finals-poll" data-option="<?php echo $opt['id']; ?>" style="--target-width: <?php echo $pct; ?>%;">
                      <span class="fs-7 fw-bold text-gray-800"><?php echo htmlspecialchars($opt['option_text']); ?></span>
                      <span class="fs-7 fw-bold text-gray-800 discourse-poll-percentage"><?php echo $pct; ?>%</span>
                    </button>
                    <?php } ?>
                  </div>
                  <span class="fs-8 text-muted"><?php echo $post['total_poll_votes']; ?> votes · 3 days left</span>
                </div>
                <?php } ?>
    
              </div>
    
              <!-- Actions Row -->
              <div class="row">
                <div class="d-flex justify-content-start align-items-center w-100 px-5">
                  <button class="btn btn-sm dc-post-comment"><i class="bi bi-chat me-1"></i> <?php echo $post['comment_count']; ?> Comment<?php echo $post['comment_count'] == 1 ? '' : 's'; ?></button>
                  <button class="btn btn-sm dc-post-share"><i class="bi bi-share me-1"></i> Share</button>
                  <?php 
                  $is_saved = IS_POST_SAVED($post['id'], $identification);
                  ?>
                  <button class="btn btn-sm dc-post-save" 
                          data-on="<?php echo $is_saved ? '1' : '0'; ?>"
                          style="<?php echo $is_saved ? 'background:rgba(13,110,253,.12);color:#0d6efd;border-color:#0d6efd;' : ''; ?>">
                      <i class="bi <?php echo $is_saved ? 'bi-bookmark-fill' : 'bi-bookmark'; ?> me-1"></i>
                      <?php echo $is_saved ? 'Saved' : 'Save'; ?>
                  </button>
                </div>
              </div>
    
              <!-- Inline Quick Comment Drawer -->
              <div class="dc-quick-comment-drawer border-top border-gray-200 mt-4 pt-4 px-5" style="display: none; background-color: #fcfdfc;">
                <div class="dc-quick-comments-list mb-4 d-flex flex-column gap-3" style="max-height: 180px; overflow-y: auto;">
                  <?php if (!empty($post['comments'])) {
                      foreach ($post['comments'] as $comment) { 
                          $c_avatar = !empty($comment['avatar_md']) ? $comment['avatar_md'] : 'https://ui-avatars.com/api/?name=' . urlencode($comment['author_name']) . '&background=f3f4f6&color=d97706&rounded=true';
                      ?>
                      <div class="d-flex align-items-start gap-2 fs-7">
                        <img src="<?php echo $c_avatar; ?>" class="h-25px w-25px rounded-circle" alt="<?php echo htmlspecialchars($comment['author_name']); ?>">
                        <div class="bg-light p-2 rounded-3 flex-grow-1 text-start">
                          <div class="d-flex justify-content-between">
                            <span class="fw-bold text-gray-800"><?php echo htmlspecialchars($comment['author_name']); ?></span>
                            <span class="text-muted fs-9"><?php echo get_relative_time($comment['created_at']); ?></span>
                          </div>
                          <p class="text-gray-700 m-0 mt-1"><?php echo htmlspecialchars($comment['body']); ?></p>
                        </div>
                      </div>
                      <?php } 
                  } ?>
                </div>
                <form class="dc-quick-comment-form">
                  <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>" />
                  <div class="d-flex align-items-center gap-2">
                    <img src="<?php echo !empty($ACCOUNT['avatar_md']) ? $ACCOUNT['avatar_md'] : '/Discourse/assets/images/anonymous.png'; ?>" class="h-30px w-30px rounded-circle" alt="User avatar" />
                    <input type="text" class="form-control form-control-sm rounded-pill px-4 fs-7 bg-white border border-gray-300" placeholder="Write a quick comment..." required />
                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-4 fw-bold" style="background:#0b301f; color:#fff;">Post</button>
                  </div>
                </form>
              </div>
            </div>
    
          </div>
        </div>
        <?php
    }
}
?>

<div class="tab-content" id="discoursePostTabsContent">

  <!-- ── HOT Tab (default active) ──────────────────────────── -->
  <div class="tab-pane fade show active" id="posts-hot" role="tabpanel" aria-labelledby="tab-hot">
    <?php if (empty($posts_hot)) { ?>
      <div class="text-center text-muted py-5">
        <i class="bi bi-fire fs-1 d-block mb-2"></i>
        No hot posts yet.
      </div>
    <?php } else {
      foreach ($posts_hot as $post) { 
          renderPostCardMarkup($post, $ACCOUNT);
      } 
    } ?>
  </div><!-- end #posts-hot -->

  <!-- ── NEW Tab ────────────────────────────────────────────── -->
  <div class="tab-pane fade" id="posts-new" role="tabpanel" aria-labelledby="tab-new">
    <?php if (empty($posts_new)) { ?>
      <div class="text-center text-muted py-5">
        <i class="bi bi-lightning-charge fs-1 d-block mb-2"></i>
        No new posts yet.
      </div>
    <?php } else {
      foreach ($posts_new as $post) {
          renderPostCardMarkup($post, $ACCOUNT);
      }
    } ?>
  </div>

  <!-- ── TOP Tab ────────────────────────────────────────────── -->
  <div class="tab-pane fade" id="posts-top" role="tabpanel" aria-labelledby="tab-top">
    <?php if (empty($posts_top)) { ?>
      <div class="text-center text-muted py-5">
        <i class="bi bi-trophy fs-1 d-block mb-2"></i>
        No top posts yet.
      </div>
    <?php } else {
      foreach ($posts_top as $post) {
          renderPostCardMarkup($post, $ACCOUNT);
      }
    } ?>
  </div>

  <!-- ── Feed Toast (Share / Save feedback) ─────────────────── -->
  <div id="dc-feed-toast" style="display:none;position:fixed;bottom:1.5rem;right:1.5rem;z-index:1090;" class="align-items-center gap-2 px-4 py-2 bg-light border rounded-2 fs-6 text-gray-700 shadow-sm">
    <i class="bi bi-check-circle-fill text-success"></i><span></span>
  </div>

  <!-- ── RISING Tab ─────────────────────────────────────────── -->
  <div class="tab-pane fade" id="posts-rising" role="tabpanel" aria-labelledby="tab-rising">
    <?php if (empty($posts_rising)) { ?>
      <div class="text-center text-muted py-5">
        <i class="bi bi-graph-up-arrow fs-1 d-block mb-2"></i>
        No rising posts yet.
      </div>
    <?php } else {
      foreach ($posts_rising as $post) {
          renderPostCardMarkup($post, $ACCOUNT);
      }
    } ?>
  </div>

</div>