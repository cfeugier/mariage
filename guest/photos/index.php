<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/ring.png" sizes="32x32" type="image/png">
    <title>Wedding photos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-image: url("assets/noisemini.png");
            background-attachment: fixed;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            grid-auto-rows: 10px;
            gap: 10px;
            padding: 10px;
        }

        .gallery .thumbnail {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            grid-row-end: span 1;
        }

        .gallery img {
            display: block;
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .gallery img:hover {
            cursor: pointer;
        }

        .pagination {
            text-align: center;
            margin: 20px 0;
        }

        .pagination a {
            display: inline-block;
            margin: 0 5px;
            padding: 10px 15px;
            text-decoration: none;
            color: #6c757d;
            background-color: #f8f9fa;
            border-color: #6c757d;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #6c757d;
            color: #f8f9fa;
        }

        .pagination .current-page {
            background-color: #6c757d;
            color: #f8f9fa;
            pointer-events: none;
        }

        .pagination .disabled {
            background-color: #b4b9be;
            color: #f8f9fa;
            pointer-events: none;
        }

        .lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .lightbox img {
            max-width: 90%;
            max-height: 80%;
            border-radius: 8px;
        }

        .lightbox .download-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #6c757d;
            background-color: #f8f9fa;
            border-color: #6c757d;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .lightbox .download-btn:hover {
            background-color: #6c757d;
            color: #f8f9fa;
        }

        .lightbox .close {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 30px;
            color: white;
            cursor: pointer;
            z-index: 1100;
        }

        .lightbox .close:hover {
            color: red;
        }

        .lightbox .nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 40px;
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
            border: none;
            cursor: pointer;
            z-index: 1100;
            border-radius: 50%;
            height: 50px;
            width: 50px;
        }

        .lightbox .nav:hover {
            background-color: rgba(255, 255, 255, 0.5);
            color: black;
        }

        .lightbox .nav.prev {
            left: 10px;
        }

        .lightbox .nav.next {
            right: 10px;
        }
    </style>
</head>
<body>
<body onresize="resizeThumbnail();">
    <div class="gallery">
        <?php
        // Liste of the urls for all the images :
        $image_urls = ['https://res.cloudinary.com/diergyosw/image/upload/v1732649231/image47_e8jwut.jpg'];

        $images_per_page = 50; // Number of images for each page
        $total_images = count($image_urls);
        $total_pages = ceil($total_images / $images_per_page);
        $current_page = isset($_GET['page']) ? max(1, min($total_pages, intval($_GET['page']))) : 1;

        // Calculate the images to display on the current page
        $start_index = ($current_page - 1) * $images_per_page;
        $images_to_display = array_slice($image_urls, $start_index, $images_per_page);

        // Display the images of the current page 
        foreach ($images_to_display as $index => $url) {
            echo "<div class='thumbnail'>
                    <img src=\"$url\" alt=\"Image $index\" data-index=\"$index\" data-src=\"$url\">
                </div>";
        }
        ?>
    </div>

    <div class="pagination">
        <?php if ($current_page > 1): ?>
            <a href="?page=<?= $current_page - 1 ?>">Previous</a>
        <?php else: ?>
            <a class="disabled">Previous</a>
        <?php endif; ?>

        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            $class = ($i === $current_page) ? 'current-page' : '';
            echo "<a href=\"?page=$i\" class=\"$class\">$i</a>";
        }
        ?>

        <?php if ($current_page < $total_pages): ?>
            <a href="?page=<?= $current_page + 1 ?>">Next</a>
        <?php else: ?>
            <a class="disabled">Next</a>
        <?php endif; ?>
    </div>

    <div class="lightbox" id="lightbox">
        <button class="nav prev" id="prevBtn">&#10094;</button>
        <button class="nav next" id="nextBtn">&#10095;</button>
        <span class="close" id="closeLightbox">&times;</span>
        <a href="#" class="download-btn" id="downloadBtn" download>Download</a>
        <img src="" alt="Lightbox Image" id="lightboxImage">
    </div>

    <script>
        async function downloadImage(imageSrc) {
            const image = await fetch(imageSrc)
            const imageBlog = await image.blob()
            const imageURL = URL.createObjectURL(imageBlog)

            const link = document.createElement('a')
            link.href = imageURL
            link.download = imageSrc.split("/").slice(-1);
            document.body.appendChild(link)
            link.click()
            document.body.removeChild(link)
        }

        const thumbnails = document.querySelectorAll('.thumbnail img');
        thumbnails.forEach(img => {
            img.addEventListener('load', () => {
                const parent = img.parentElement;
                parent.style.gridRowEnd = `span ${Math.ceil(img.offsetHeight / 21)}`;
            });
        });
        const images = document.querySelectorAll('.gallery img');
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightboxImage');
        const downloadBtn = document.getElementById('downloadBtn');
        const closeLightbox = document.getElementById('closeLightbox');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        let currentIndex = -1;

        images.forEach((image, index) => {
            image.addEventListener('click', () => {
                const src = image.getAttribute('data-src');
                currentIndex = index;
                openLightbox(src);
            });
        });

        function openLightbox(src) {
            lightboxImage.src = src;
            downloadBtn.href = '#';
            downloadBtn.setAttribute("onclick", 'downloadImage("'+src+'")');
            lightbox.style.display = 'flex';
        }

        function closeLightboxHandler() {
            lightbox.style.display = 'none';
        }

        function showPrevImage() {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1;
            const prevSrc = images[currentIndex].getAttribute('data-src');
            openLightbox(prevSrc);
        }

        function showNextImage() {
            currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0;
            const nextSrc = images[currentIndex].getAttribute('data-src');
            openLightbox(nextSrc);
        }

        closeLightbox.addEventListener('click', closeLightboxHandler);
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) {
                closeLightboxHandler();
            }
        });

        prevBtn.addEventListener('click', showPrevImage);
        nextBtn.addEventListener('click', showNextImage);

        function resizeThumbnail() {
            const thumbnails = document.querySelectorAll('.thumbnail img');
            thumbnails.forEach(img => {
                const parent = img.parentElement;
                parent.style.gridRowEnd = `span ${Math.ceil(img.offsetHeight / 21)}`;
            });
        }
    </script>
</body>
</html>