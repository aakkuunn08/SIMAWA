import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Kode Scroll Spy kamu
document.addEventListener('DOMContentLoaded', () => {
    // 1. Definisi Class (Harus sama persis dengan sidebar.blade.php)
    const activeClasses = ['border-l-4', 'border-orange-500', 'bg-orange-50', 'text-gray-900', 'font-medium'];
    const inactiveClasses = ['border-l-4', 'border-transparent', 'hover:bg-gray-100', 'text-gray-600'];

    const sections = document.querySelectorAll('section[id]'); 
    const navLinks = document.querySelectorAll('.nav-link:not(.no-spy)');

    function onScroll() {
        let currentSection = '';

        // LOGIKA BARU: Cek apakah user ada di paling atas (Hero Section)
        // Jika scroll kurang dari 100px dari atas, kita anggap masih di "Welcome"
        // Jadi currentSection dikosongkan agar tidak ada menu yang nyala.
        if (window.scrollY < 100) {
            currentSection = ''; 
        } else {
            // Jika sudah scroll ke bawah, baru cari section mana yang aktif
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                // Offset 150px untuk kompensasi tinggi header
                if (window.scrollY >= (sectionTop - 150)) { 
                    currentSection = section.getAttribute('id');
                }
            });
        }

        // Terapkan Class ke Menu
        navLinks.forEach(link => {
            // 1. "Cuci Bersih" dulu semua link (Reset ke inactive)
            // Hapus semua class active
            link.classList.remove(...activeClasses);
            
            // Tambahkan class inactive (termasuk border transparent agar tidak goyang)
            link.classList.add(...inactiveClasses);
            
            // Hapus duplikat class jika ada (untuk safety)
            activeClasses.forEach(cls => {
                if(inactiveClasses.includes(cls)) return; // skip yg sama
                link.classList.remove(cls);
            });

            // 2. Cek apakah link ini mengarah ke currentSection
            // Pastikan currentSection tidak kosong
            if (currentSection && link.getAttribute('href').includes('#' + currentSection)) {
                // Hapus class inactive
                link.classList.remove(...inactiveClasses);
                // Tambahkan class active
                link.classList.add(...activeClasses);
            }
        });
    }

    // Jalankan saat scroll
    if (sections.length > 0) {
        window.addEventListener('scroll', onScroll);
        onScroll(); // Jalankan sekali saat load
    }
});