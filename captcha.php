<?php
/**
 * Captcha Generator
 * Rendered as SVG for crystal-clear vector display without requiring PHP GD extension
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
$length = 5;
$code = '';
$maxIndex = strlen($chars) - 1;
for ($i = 0; $i < $length; $i++) {
    $code .= $chars[random_int(0, $maxIndex)];
}

$_SESSION['security_code'] = $code;
$_SESSION['captcha'] = $code;

header('Content-Type: image/svg+xml; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

$width = 130;
$height = 42;

$colors = array('#13467d', '#0369a1', '#0f766e', '#1d4ed8', '#047857');
$lineColors = array('#cbd5e1', '#94a3b8', '#93c5fd', '#a7f3d0');

echo '<svg xmlns="http://www.w3.org/2000/svg" width="'.$width.'" height="'.$height.'" viewBox="0 0 '.$width.' '.$height.'">'."\n";
echo '  <defs>'."\n";
echo '    <linearGradient id="bgGrad" x1="0%" y1="0%" x2="100%" y2="100%">'."\n";
echo '      <stop offset="0%" stop-color="#f8fafc"/>'."\n";
echo '      <stop offset="100%" stop-color="#e2e8f0"/>'."\n";
echo '    </linearGradient>'."\n";
echo '  </defs>'."\n";
echo '  <rect width="'.$width.'" height="'.$height.'" rx="8" fill="url(#bgGrad)" stroke="#cbd5e1" stroke-width="1.2"/>'."\n";

// Noise lines
for ($l = 0; $l < 3; $l++) {
    $x1 = random_int(5, 30);
    $y1 = random_int(5, $height - 5);
    $cx = random_int(40, 80);
    $cy = random_int(5, $height - 5);
    $x2 = random_int(90, $width - 5);
    $y2 = random_int(5, $height - 5);
    $lc = $lineColors[$l % count($lineColors)];
    echo '  <path d="M'.$x1.','.$y1.' Q'.$cx.','.$cy.' '.$x2.','.$y2.'" stroke="'.$lc.'" stroke-width="1.5" fill="none" opacity="0.75"/>'."\n";
}

// Noise dots
for ($d = 0; $d < 12; $d++) {
    $dx = random_int(5, $width - 5);
    $dy = random_int(5, $height - 5);
    $r = random_int(1, 2);
    echo '  <circle cx="'.$dx.'" cy="'.$dy.'" r="'.$r.'" fill="#94a3b8" opacity="0.6"/>'."\n";
}

// Draw characters
$charSpacing = ($width - 24) / $length;
for ($i = 0; $i < $length; $i++) {
    $char = $code[$i];
    $color = $colors[$i % count($colors)];
    $rot = random_int(-16, 16);
    $fontSize = random_int(21, 24);
    $x = 14 + ($i * $charSpacing) + random_int(-2, 2);
    $y = 28 + random_int(-2, 2);
    echo '  <text x="'.$x.'" y="'.$y.'" font-family="Arial, Helvetica, sans-serif" font-size="'.$fontSize.'" font-weight="700" fill="'.$color.'" transform="rotate('.$rot.' '.$x.' '.$y.')" text-anchor="middle" style="user-select:none;">'.$char.'</text>'."\n";
}

echo '</svg>';
exit();
