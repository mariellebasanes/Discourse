<?php

define('MBG', TRUE);
include($_SERVER['DOCUMENT_ROOT'] . "/functions-new.php");

DIRECT_ACCESS_BLOCKED();

if (!empty($identification)) {
    $userId = sanitize($_POST['userId']);
    $offset = sanitize($_POST['offset']);
    $limit = 5;

    $SQL = $EDITH->prepare("
        SELECT * FROM notifications_content
        WHERE identification = ? OR is_global = 1
        ORDER BY created_at DESC
        LIMIT ?, ?
    ");
    $SQL->bind_param("sii", $identification, $offset, $limit);
    $SQL->execute();
    $RECORD = $SQL->get_result();

    $html_output = '';
    while ($ROW = $RECORD->fetch_assoc()) {
        $isNotificationSeen = isNotificationSeen($ROW['id']);
        $read_class = ($isNotificationSeen == false) ? "bg-light-primary" : "bg-hover-secondary";
        $rounded = "rounded-circle";
        $recipient_type = $ROW['recipient_type'];
        $reaction = null;
        $display = true;

        switch ($ROW['application']) {

            case "Eventually":
                $app = "<span class='text-eventually fw-bolder'>Eventually</span> · ";
                include("notifications-fetch-eventually.php");
                break;

            case "Briefcase":
                $app = "<span class='text-briefcase fw-bolder'>Briefcase</span> · ";
                include("notifications-fetch-briefcase.php");
                break;

            case "Credentials":
                $app = "<span class='text-credentials fw-bolder'>Credentials</span> · ";
                include("notifications-fetch-credentials.php");
                break;

            case "Guidance":
                $app = "<span class='text-primary fw-bolder'>Guidance</span> · ";
                include("notifications-fetch-guidance.php");
                break;

            default:
                $app = "";
                $link = "javascript:void(0)";
                $message = $ROW['message'];
                $timestamp = date('F j, Y, g:i a', strtotime($ROW['created_at']));
                $image = "";
        }

        if (!empty($message)) {

            $html_output .= "
                    <a href='{$link}' class='notification-item col-12 border-top p-0' data-id='{$ROW['id']}'>
                        <div class='{$read_class} px-8 py-5'>
                            <div class='d-flex align-items-start'>
                                <div class='d-block'>
                                    <div class='w-40px h-40px bgi-no-repeat bgi-position-center bgi-size-cover bg-dark rounded position-relative' style='background-image: url(&quot;{$image}&quot;);'>
                                        {$reaction}
                                    </div>
                                </div>
                                <div class='ms-4'>
                                    <p class='ellipsis-3 mb-1 text-gray-800'>{$message}</p>
                                    <p class='mb-0 small'>
                                        {$app}
                                        <span class='text-gray-600'>{$timestamp}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                ";

            // READ NOTIFICATION RECEIPT
            if (!$isNotificationSeen) {
                $READ = $EDITH->prepare("
                    INSERT INTO notifications_engagement (notifications_id, identification) 
                    VALUES (?, ?)
                ");
                $READ->bind_param("ss", $ROW['id'], $identification);
                $READ->execute();
                $READ->close();
            }

        }
    }

    $SQL->close();
}


echo $html_output;



function isNotificationSeen($id)
{
    global $EDITH;
    global $identification;

    $CHECK = $EDITH->prepare("SELECT 1 FROM notifications_engagement WHERE notifications_id = ? AND identification = ?");
    $CHECK->bind_param("is", $id, $identification);
    $CHECK->execute();
    $CHECK->store_result();
    $is_recorded = ($CHECK->num_rows > 0);
    $CHECK->close();

    return $is_recorded;
}

function getEventuallyPoster($EVENT)
{
    $directory = "/eventually/assets/media/uploads/";
    $year = date("Y", strtotime($EVENT['created_at'])) . "/";
    $image = str_replace("OR-", "SM-", $EVENT['image']);

    return $directory . $year . $image;
}


?>