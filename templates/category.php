<?php
declare(strict_types = 1);

$category = $_GET['name'] ?? 'Unknown';
$category = urldecode($category);

$services = [
    'Programming & Tech' => ['Website Development', 'Game Development', 'Support & IT', 'Cybersecurity'],
    'Graphics and Design' => ['Logo Design', 'Website Design', 'Illustration', 'Architecture and Interior Design'],
    'Digital Marketing' => ['Marketing Strategy', 'Video Marketing', 'Social Media Marketing', 'Influencer Marketing'],
    'Video & Animation' => ['Video Editing', 'Visual Effects', 'Character Animation', '3D Product Animation'],
    'Music & Audio' => ['Voice Over', 'Audio Editing', 'Sound Design', 'Podcast Production'],
    'Business' => ['Sales', 'Legal Research', 'Business Plan', 'Project Management'],
];

$selectedServices = $services[$category] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($category); ?> Services</title>
    <link rel="stylesheet" href="/templates/style.css">
</head>
<body>

<?php require_once __DIR__ . '/../includes/header.php'; ?>

<section class="section">
    <div class="container">
        <h2 class="section-title"><?php echo htmlspecialchars($category); ?> Services</h2>
        <div class="category-grid">
            <?php if (empty($selectedServices)): ?>
                <p>No services found for this category.</p>
            <?php else: ?>
                <?php foreach ($selectedServices as $service): ?>
                    <div class="category-card"><?php echo htmlspecialchars($service); ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
