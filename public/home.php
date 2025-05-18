<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liberta Mobile</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <div class="carousel">
        <img src="./assets/images/apple-iphone-15.jpg" alt="Slide 1" class="carousel-image active">
        <img src="./assets/images/xiaomi-14.jpg" alt="Slide 2" class="carousel-image">
        <img src="./assets/images/apple-iphone-15.jpg" alt="Slide 3" class="carousel-image">
    </div>

    <script>
        const carouselImages = document.querySelectorAll('.carousel-image');
        let currentIndex = 0;

        function showNextImage() {
            carouselImages[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % carouselImages.length;
            carouselImages[currentIndex].classList.add('active');
        }

        setInterval(showNextImage, 3000);
    </script>
</body>
</html>
