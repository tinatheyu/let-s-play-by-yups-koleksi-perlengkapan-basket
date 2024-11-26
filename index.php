<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRAKTIKUM PEMWEB</title>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
    <!-- Navbar 1 -->
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="login.php">Login</a></li>
            <!-- <li><a href="login.php" id="login-link">Login</a></li> -->
            <li><a href="signup.php">Sign Up</a></li>
        </ul>
    </nav>
    <!-- Navbar 1 selesai -->

<!-- Overlay and Popup for Login Options -->
<!-- <div class="overlay" id="overlay"></div>
<div class="popup" id="popup">
    <h3>Pilih Login</h3>
    <a href="login.php?role=guest">Tamu</a>
    <a href="login.php?role=admin">Admin</a>
    <div class="close-button" onclick="closePopup()">Batal</div>
</div> -->


    <!-- Navbar 2 -->
    <nav class="nav2">
        <ul class="ul2">
            <li class="li2"><a href="#">New</a></li>
            <li class="li2"><a href="#">Men</a></li>
            <li class="li2"><a href="#">Women</a></li>
            <li class="li2"><a href="#">Kids</a></li>
            <li class="li2"><a href="#">Sale</a></li>
            <li class="li2 right-icons">
                <a href="#">
                    <img src="https://img.icons8.com/ios/50/000000/search.png" alt="Search" class="icon">
                </a>
            </li>
            <li class="li2 right-icons">
                <a href="#">
                    <img src="https://img.icons8.com/ios/50/000000/like.png" alt="Like" class="icon">
                </a>
            </li>
        </ul>
    </nav>
    <!-- Navbar 2 selesai -->

    <!-- Body 1 -->
    <div class="div-3">
        <h2 class="h2-1">LET'S PLAY BY YUPS</h2>
    </div>
    <!-- Body 1 selesai -->

    <!-- Body 2 -->
    <div class="div-4">
        <img class="custombasket1" src="assets/halaman1.jpeg" alt="basketball" />
    </div>
    <div class="teks1">
        <p>Just In</p>
        <h1>V2K RUN</h1>
        <p>Transcend trend with a bold, energetic edge. With a timeless look and unique hourglass silhouette, the V2K Run has the flexibility to pair well with your everyday looks.</p>
    </div>        
    <!-- Body 2 selesai -->

    <!-- Body 3 -->
    <div class="div-5">
        <div class="photo-wrapper1">
            <img class="customkatalog1" src="assets/katalog1.jpeg" alt="Sepatu 1" />
        </div>
        <div class="photo-wrapper1">
            <img class="customkatalog1" src="assets/katalog2.jpg" alt="Sepatu 2" />
        </div>
        <div class="photo-wrapper1">
            <img class="customkatalog1" src="assets/katalog3.jpg" alt="Sepatu 3" />
        </div>
        <div class="photo-wrapper1">
            <img class="customkatalog1" src="assets/katalog4.jpeg" alt="Sepatu 4" />
        </div>
    </div>
    <!-- Body 3 selesai -->

    <!-- Body 4 -->
    <div class="div-6">
        <div class="photo-wrapper1">
            <img class="customkatalog1" src="assets/katalog5.jpg" alt="Sepatu 5" />
        </div>
        <div class="photo-wrapper1">
            <img class="customkatalog1" src="assets/katalog6.jpg" alt="Sepatu 6" />
        </div>
        <div class="photo-wrapper1">
            <img class="customkatalog1" src="assets/katalog7.jpg" alt="Sepatu 7" />
        </div>
        <div class="photo-wrapper1">
            <img class="customkatalog1" src="assets/katalog8.jpg" alt="Sepatu 8" />
        </div>
    </div>
    <!-- Body 4 selesai -->

    <!-- Pop-up Konfirmasi Wishlist -->
    <div class="overlay" id="wishlist-overlay"></div>
    <div class="wishlist-popup" id="wishlist-popup">
        <h3>Konfirmasi Wishlist</h3>
        <p id="wishlist-message"></p>
        <div class="close-button" onclick="closeWishlistPopup()">Batal</div>
        <div class="close-button" id="confirm-wishlist-button">Konfirmasi</div>
    </div>

    <!-- Pop-up Info Sepatu -->
    <div class="overlay" id="info-overlay"></div>
    <div class="info-popup" id="info-popup">
        <h3>Informasi Sepatu</h3>
        <p id="shoe-info-message"></p>
        <div class="close-button" onclick="closeInfoPopup()">Tutup</div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-section">
            <p>Eka Ayu Agustina</p>
            <p>Contact: tinatheyu@gmail.com</p>
            <p>Location: Jawa timur, Indonesia</p>
        </div>
        <div class="footer-section">
            <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
        </div>
    </footer>
    <!-- Footer selesai -->

    <!-- JavaScript Code -->
    <script>
        let wishlist = [];
        let currentShoeIndex = -1; // Menyimpan indeks sepatu saat ini yang diklik

        document.addEventListener("DOMContentLoaded", function () {
            loadWishlist(); // Memuat wishlist dari localStorage

            // Event untuk pop-up login
            document.getElementById("login-link").addEventListener("click", function(event) {
                event.preventDefault(); // Mencegah link melakukan navigasi
                document.getElementById("popup").style.display = "block";
                document.getElementById("overlay").style.display = "block";
            });

            // Tutup pop-up login
            document.getElementById("overlay").addEventListener("click", closePopup);

            // Mengatur event untuk gambar katalog
            const katalogImages = document.querySelectorAll(".customkatalog1");
            katalogImages.forEach((img, index) => {
                img.addEventListener("click", function () {
                    showShoeInfo(index); // Tampilkan pop-up info
                });
            });

            // Mengatur event untuk ikon like
            const likeIcons = document.querySelectorAll('.right-icons img[alt="Like"]');
            likeIcons.forEach((icon, index) => {
                icon.addEventListener("click", function () {
                    showWishlistPopup(index); // Tampilkan pop-up konfirmasi
                });

                icon.addEventListener("dblclick", function () {
                    const item = "Item " + (index + 1);
                    const itemIndex = wishlist.indexOf(item);
                    if (itemIndex > -1) {
                        wishlist.splice(itemIndex, 1);
                        saveWishlist(); // Simpan wishlist setelah dihapus
                        alert("Dihapus dari wishlist: " + item);
                        console.log("Wishlist Saat Ini:", wishlist);
                    }
                });
            });

            // Event untuk konfirmasi wishlist
            document.getElementById("confirm-wishlist-button").addEventListener("click", function () {
                if (currentShoeIndex > -1) {
                    const item = "Item " + (currentShoeIndex + 1);
                    wishlist.push(item);
                    saveWishlist(); // Simpan wishlist
                    document.getElementById("wishlist-message").textContent = "Ditambahkan ke wishlist: " + item;
                    console.log("Wishlist Saat Ini:", wishlist);
                }
                closeWishlistPopup();
            });

            // Load additional shoe data using fetch
            loadShoeData();
        });

        // Asynchronous Fetch dan Promises
        function loadShoeData() {
            fetch('https://example.com/api/shoes') // Ganti dengan URL API yang sesuai
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data sepatu berhasil dimuat:', data);
                    // Proses data sepatu yang dimuat
                    displayShoes(data); // Panggil fungsi untuk menampilkan data sepatu
                })
                .catch(error => {
                    console.error('Ada masalah dengan fetch:', error);
                });
        }
        // Asynchronous Fetch dan Promises selesai

        function displayShoes(data) {
            // Contoh cara menampilkan data sepatu di DOM
            const shoeContainer = document.querySelector('.div-5'); // Ganti dengan elemen yang sesuai
            data.forEach((shoe, index) => {
                const shoeElement = document.createElement('div');
                shoeElement.className = 'shoe-item';
                shoeElement.innerHTML = `
                    <img src="${shoe.image}" alt="${shoe.name}">
                    <h4>${shoe.name}</h4>
                    <p>${shoe.description}</p>
                `;
                shoeContainer.appendChild(shoeElement);
            });
        }

        function showWishlistPopup(index) {
            currentShoeIndex = index;
            document.getElementById("wishlist-message").textContent = "Tambahkan ke wishlist?";
            document.getElementById("wishlist-popup").style.display = "block";
            document.getElementById("wishlist-overlay").style.display = "block";
        }

        function closeWishlistPopup() {
            document.getElementById("wishlist-popup").style.display = "none";
            document.getElementById("wishlist-overlay").style.display = "none";
        }

        function showShoeInfo(index) {
            // Update currentShoeIndex untuk menampilkan info sepatu yang dipilih
            currentShoeIndex = index;
            const message = `Informasi untuk Sepatu ${index + 1}: Deskripsi, ukuran, harga, dll.`;
            document.getElementById("shoe-info-message").textContent = message;
            document.getElementById("info-popup").style.display = "block";
            document.getElementById("info-overlay").style.display = "block";
        }

        function closeInfoPopup() {
            document.getElementById("info-popup").style.display = "none";
            document.getElementById("info-overlay").style.display = "none";
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }

        // Web Storage
        function loadWishlist() {
            const storedWishlist = localStorage.getItem('wishlist');
            if (storedWishlist) {
                wishlist = JSON.parse(storedWishlist);
                console.log("Wishlist yang dimuat:", wishlist);
            }
        }

        function saveWishlist() {
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            console.log("Wishlist disimpan:", wishlist);
        }
        // web storage selesai
    </script>
</body>
</html>
