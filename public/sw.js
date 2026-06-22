self.addEventListener('notificationclick', function(event) {
    event.notification.close();

    // Jika pengguna mengklik tombol action (misal: "oke")
    if (event.action === 'oke') {
        // Fokuskan window aplikasi jika sedang terbuka
        event.waitUntil(
            clients.matchAll({ type: 'window' }).then(windowClients => {
                // Cek jika sudah ada tab yang terbuka untuk app ini
                for (var i = 0; i < windowClients.length; i++) {
                    var client = windowClients[i];
                    if (client.url.indexOf('/') !== -1 && 'focus' in client) {
                        return client.focus();
                    }
                }
                // Jika tidak ada tab yang terbuka, buka tab baru (opsional)
                if (clients.openWindow) {
                    return clients.openWindow('/');
                }
            })
        );
    } else {
        // Klik normal pada body notifikasi
        event.waitUntil(
            clients.matchAll({ type: 'window' }).then(windowClients => {
                for (var i = 0; i < windowClients.length; i++) {
                    var client = windowClients[i];
                    if (client.url.indexOf('/') !== -1 && 'focus' in client) {
                        return client.focus();
                    }
                }
                if (clients.openWindow) {
                    return clients.openWindow('/');
                }
            })
        );
    }
});

self.addEventListener('push', function(event) {
    // Kosong untuk saat ini, bisa diimplementasikan nanti jika menggunakan push API dari server
});
