<?php
define('MBG', TRUE);
include_once(dirname(dirname(__DIR__)) . '/functions-new.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$community_title = isset($_POST['community_title']) ? trim($_POST['community_title']) : '';
if (empty($community_title)) {
    echo json_encode(['success' => false, 'message' => 'Community title is required.']);
    exit;
}

$user_id = $identification;

if ($EDITH) {
    // Check if already a member
    $stmt = $EDITH->prepare("SELECT 1 FROM community_members WHERE community_title = ? AND identification = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $community_title, $user_id);
        $stmt->execute();
        $stmt->store_result();
        $is_member = ($stmt->num_rows > 0);
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Database check query failed.']);
        exit;
    }

    if ($is_member) {
        // Leave community
        $stmt = $EDITH->prepare("DELETE FROM community_members WHERE community_title = ? AND identification = ?");
        if ($stmt) {
            $stmt->bind_param("ss", $community_title, $user_id);
            $stmt->execute();
            $stmt->close();
        }
        
        // Decrement member count
        $stmt = $EDITH->prepare("UPDATE communities SET members = GREATEST(0, members - 1) WHERE title = ?");
        if ($stmt) {
            $stmt->bind_param("s", $community_title);
            $stmt->execute();
            $stmt->close();
        }
        
        $joined = false;
    } else {
        // Join community
        $stmt = $EDITH->prepare("INSERT INTO community_members (community_title, identification) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $community_title, $user_id);
            $stmt->execute();
            $stmt->close();
        }
        
        // Increment member count
        $stmt = $EDITH->prepare("UPDATE communities SET members = members + 1 WHERE title = ?");
        if ($stmt) {
            $stmt->bind_param("s", $community_title);
            $stmt->execute();
            $stmt->close();
        }
        
        $joined = true;
    }
    
    // Fetch updated members count
    $members_count = 0;
    $stmt = $EDITH->prepare("SELECT members FROM communities WHERE title = ?");
    if ($stmt) {
        $stmt->bind_param("s", $community_title);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        $members_count = $res ? $res['members'] : 0;
        $stmt->close();
    }

    echo json_encode(['success' => true, 'joined' => $joined, 'members_count' => $members_count]);
    exit;
} else {
    // Session fallback
    if (!isset($_SESSION['joined_communities']) || !is_array($_SESSION['joined_communities'])) {
        $_SESSION['joined_communities'] = [];
    }
    
    $index = array_search($community_title, $_SESSION['joined_communities']);
    if ($index !== false) {
        unset($_SESSION['joined_communities'][$index]);
        $_SESSION['joined_communities'] = array_values($_SESSION['joined_communities']);
        $joined = false;
    } else {
        $_SESSION['joined_communities'][] = $community_title;
        $joined = true;
    }
    
    echo json_encode(['success' => true, 'joined' => $joined, 'members_count' => null]);
    exit;
}
?>
