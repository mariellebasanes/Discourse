<?php
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

<link rel="icon" type="image/x-icon" href="/assets/img/favicon.png">
<link rel="manifest" href="/assets/site.webmanifest?v=2">

<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Paraverse">
<link rel="apple-touch-icon" href="/assets/img/logo/icon-paraverse-192.png">

<link rel="stylesheet" href="/assets/plugins/global/plugins.bundle.css">
<link rel="stylesheet" href="/assets/css/style.keenicons.css">
<link rel="stylesheet" href="/assets/css/style.bundle.v2.full.css?version=1.1028">

<script src="/assets/js/jquery.js"></script>

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
