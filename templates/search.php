<?php

$searchQuery = $_GET['query'] ?? '';
$searchQuery = strtolower(trim($searchQuery));

$allServices = [
    'Website Development', 'Game Development', 'Support & IT', 'Cybersecurity',
    'Logo Design', 'Website Design', 'Illustration', 'Architecture and Interior Design',
    'Marketing Strategy', 'Video Marketing', 'Social Media Marketing', 'Influencer Marketing',
    'Video Editing', 'Visual Effects', 'Character Animation', '3D Product Animation',
    'Voice Over', 'Audio Editing', 'Sound Design', 'Podcast Production',
    'Sales', 'Legal Research', 'Business Plan', 'Project Management'
];

$results = [];

foreach ($allServices as $service) {
    if (stripos($service, $searchQuery) !== false) {
        $results[] = $service;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php require_once 'includes/header.php'; ?>

<section class="section">
    <div class="container">
        <h2 class="section-title">Search Results for: <?=htmlspecialchars($searchQuery) ?></h2>

        <?php if (!empty($results)): ?>
            <ul class="category-grid">
                <?php foreach ($results as $result): ?>
                    <li class="category-card"><?= htmlspecialchars($result) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No services found.</p>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

</body>
</html>

        
