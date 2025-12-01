<?php
/**
 * Page Class
 * Manages page metadata and rendering
 */
class Page {
    private $title;
    private $description;
    private $keywords;
    private $theme;
    
    public function __construct($title = 'SwiftServe', $description = 'Modern Web Experience', $keywords = 'web development, design, mobile apps') {
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
        $this->theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getTheme() {
        return $this->theme;
    }
    
    public function renderHead() {
        ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo htmlspecialchars($this->description); ?>">
        <meta name="keywords" content="<?php echo htmlspecialchars($this->keywords); ?>">
        <title><?php echo htmlspecialchars($this->title); ?></title>
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
        
        <!-- Custom CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/delivery.css">
        <link rel="stylesheet" href="assets/css/customizer.css">
        
        <!-- AOS Animation Library -->
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <?php
    }
    
    public function renderScripts() {
        ?>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- AOS Animation Library -->
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        
        <!-- Custom JavaScript -->
        <script src="assets/js/main.js"></script>
        <script src="assets/js/customizer.js"></script>
        <script src="assets/js/food-filter.js"></script>
        <?php
    }
}
