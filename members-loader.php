<?php
/**
 * members-loader.php
 * Dynamic logo grid loader for "Our Members" section.
 * Reads members.json and outputs accessible HTML grid.
 *
 * HOW TO ADD A NEW MEMBER MANUALLY:
 * 1. Place the logo image into the directory (e.g. ciba.jpeg, Sait.jpeg or assets/logos/)
 * 2. Add one object to members.json: { "name": "...", "logo": "...", "url": "..." }
 * The grid updates automatically.
 */

$jsonFile = __DIR__ . '/members.json';

// Authentic member bodies
$defaultMembers = [
    [
        'name' => 'Chartered Institute for Business Accountants NPC (CIBA)',
        'logo' => 'ciba.jpeg',
        'url'  => 'https://saiba.org.za'
    ],
    [
        'name' => 'South African Institute of Taxation (SAIT)',
        'logo' => 'Sait.jpeg',
        'url'  => 'https://thesait.org.za'
    ]
];

// Create members.json if it doesn't exist
if (!file_exists($jsonFile)) {
    @file_put_contents($jsonFile, json_encode($defaultMembers, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

// Read and decode members.json
$membersData = @file_get_contents($jsonFile);
$members = json_decode($membersData, true);

if (!is_array($members) || empty($members)) {
    $members = $defaultMembers;
}
?>
<!-- Our Members Section -->
<section id="our-members" class="members-section" aria-labelledby="members-heading">
  <div class="members-container">
    <div class="members-header text-center">
      <span class="members-subtitle">Professional Affiliations &amp; Accreditations</span>
      <h2 id="members-heading" class="members-title">Our Professional Accreditations</h2>
      <p class="members-desc">Proudly affiliated with South Africa's premier accounting and taxation statutory institutes, guaranteeing compliance and precision.</p>
    </div>

    <!-- Centered Logo Grid: 2 Large Prominent Boxes in the Middle -->
    <div class="members-grid" role="list">
      <?php foreach ($members as $member): ?>
        <?php
          $name = htmlspecialchars($member['name'] ?? 'Member', ENT_QUOTES, 'UTF-8');
          $logo = htmlspecialchars($member['logo'] ?? '', ENT_QUOTES, 'UTF-8');
          $url  = !empty($member['url']) ? htmlspecialchars($member['url'], ENT_QUOTES, 'UTF-8') : '';
        ?>
        <div class="member-tile" role="listitem">
          <?php if (!empty($url)): ?>
            <a href="<?= $url ?>" target="_blank" rel="noopener noreferrer" class="member-link" aria-label="<?= $name ?> (opens in a new tab)">
              <!-- Large Image Box -->
              <div class="member-logo-wrap">
                <img src="<?= $logo ?>" alt="<?= $name ?>" loading="lazy" class="member-logo">
              </div>
              <!-- Member Name Under the Image -->
              <h3 class="member-name-label"><?= $name ?></h3>
              <span class="member-external-hint">Visit Official Body &rarr;</span>
            </a>
          <?php else: ?>
            <div class="member-link" aria-label="<?= $name ?>">
              <!-- Large Image Box -->
              <div class="member-logo-wrap">
                <img src="<?= $logo ?>" alt="<?= $name ?>" loading="lazy" class="member-logo">
              </div>
              <!-- Member Name Under the Image -->
              <h3 class="member-name-label"><?= $name ?></h3>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
