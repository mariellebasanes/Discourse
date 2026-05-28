<?php

define('MBG', TRUE);
include($_SERVER['DOCUMENT_ROOT'] . "/functions-new.php");

DIRECT_ACCESS_BLOCKED();

$location = $_POST['location'] ?? '';

try {
    $SQL = $EDITH->prepare("SELECT message, role FROM gpt WHERE location = ? AND identification = ?");
    $SQL->bind_param("ss", $location, $identification);
    $SQL->execute();
    $result = $SQL->get_result();
    $messages = $result->fetch_all(MYSQLI_ASSOC);

    // If no messages found, set a default response
    if (empty($messages)) {
        $messages[] = [
            "message" => "Hi, " . $ACCOUNT['first_name'] . ". How can I help you today?",
            "role" => "assistant"
        ];
    }

    foreach ($messages as &$msg) {
        $msg["message"] = markdownToHTML($msg["message"]);
    }

    echo json_encode(["success" => true, "messages" => $messages]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}


function markdownToHTML($text)
{
    if (!is_string($text))
        return $text; // Ensure input is a string

    // Escape HTML inside code blocks to prevent execution
    $text = preg_replace_callback('/```(\w+)?\n([\s\S]*?)```/', function ($matches) {
        $lang = isset($matches[1]) ? "language-" . htmlspecialchars($matches[1]) : "language-plaintext";
        return "<pre><code class=\"$lang\">" . htmlspecialchars($matches[2]) . "</code></pre>";
    }, $text);

    // Convert inline code
    $text = preg_replace_callback('/`([^`]+)`/', function ($matches) {
        return "<code>" . htmlspecialchars($matches[1]) . "</code>";
    }, $text);

    // Bold & Italics
    $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text); // Bold
    $text = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $text); // Italics

    // Blockquotes
    $text = preg_replace('/^> (.*)$/m', '<blockquote>$1</blockquote>', $text);

    // Links
    $text = preg_replace('/\[(.*?)\]\((https?:\/\/[^\s]+)\)/', '<a href="$2" target="_blank">$1</a>', $text);

    // Headers (H1-H6)
    for ($i = 6; $i >= 1; $i--) {
        $text = preg_replace("/^" . str_repeat("#", $i) . " (.*)$/m", "<h$i>$1</h$i>", $text);
    }

    // Convert ordered lists
    $text = preg_replace_callback('/(?:^|\n)(\d+\.\s[^\n]+(?:\n\d+\.\s[^\n]+)*)/', function ($matches) {
        $items = preg_replace('/^\d+\.\s+/', '<li>', $matches[1]);
        $items = str_replace("\n", "</li>\n<li>", $items) . "</li>";
        return "<ol>$items</ol>";
    }, $text);

    // Convert unordered lists
    $text = preg_replace_callback('/(?:^|\n)(?:-\s[^\n]+(?:\n-\s[^\n]+)*)/', function ($matches) {
        $items = preg_replace('/^- /', '<li>', $matches[0]);
        $items = str_replace("\n", "</li>\n<li>", $items) . "</li>";
        return "<ul>$items</ul>";
    }, $text);

    // Convert Markdown Tables to HTML
    $text = preg_replace_callback('/\|(.+?)\|\n\|(?:-+\|)+\n((?:\|.*?\|\n)+)/', function ($matches) {
        return markdownTableToHTML($matches[0]);
    }, $text);

    // Ensure proper paragraph formatting
    $text = preg_replace("/\n{2,}/", "\n", $text); // Remove extra line breaks
    $text = preg_replace("/(?<!<h[1-6]|ul|ol|li|blockquote|pre|code|table|p|div|img|strong|em|a|hr)>(.*?)\n/", "<p>$1</p>\n", $text);

    return $text;
}

function markdownTableToHTML($mdTable)
{
    $rows = explode("\n", trim($mdTable));

    // Remove separator row (e.g., |---|---|)
    unset($rows[1]);

    $tableHTML = "<table border='1' style='width: 100%; border-collapse: collapse; text-align: left;'>";

    foreach ($rows as $index => $row) {
        $cols = array_filter(explode("|", $row), function ($col) {
            return trim($col) !== "";
        });

        $tableHTML .= ($index === 0) ? "<thead><tr>" : "<tr>";
        foreach ($cols as $col) {
            $tableHTML .= ($index === 0) ? "<th style='padding: 8px;'>" . trim($col) . "</th>" : "<td style='padding: 8px;'>" . trim($col) . "</td>";
        }
        $tableHTML .= ($index === 0) ? "</tr></thead><tbody>" : "</tr>";
    }

    $tableHTML .= "</tbody></table>";

    return "<div class='message bot'>$tableHTML</div>";
}

function escapeHtml($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

?>