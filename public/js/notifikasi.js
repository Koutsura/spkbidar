document.addEventListener('DOMContentLoaded', () => {
    updateNotificationStyles();

    // Event klik "Lihat semua notifikasi"
    const clearBtn = document.getElementById('clearNotifications');
    if (clearBtn) {
        clearBtn.addEventListener('click', (e) => {
            e.preventDefault();
            clearNotifBadge();
        });
    }
});

function getReadNotifications() {
    const data = localStorage.getItem('readNotifications');
    return data ? JSON.parse(data) : [];
}

function setReadNotifications(ids) {
    localStorage.setItem('readNotifications', JSON.stringify(ids));
}

function markAllNotificationsRead() {
    const notifItems = document.querySelectorAll('[data-notif-id]');
    if (!notifItems.length) return;

    const notifIds = Array.from(notifItems).map(el => parseInt(el.getAttribute('data-notif-id')));
    setReadNotifications(notifIds);
}

function clearNotifBadge() {
    markAllNotificationsRead();
    updateNotificationStyles();
}

function updateNotificationStyles() {
    let readIds = getReadNotifications();
    const notifItems = document.querySelectorAll('[data-notif-id]');
    let unreadCount = 0;

    // Filter IDs yang masih ada di halaman notif
    const currentNotifIds = Array.from(notifItems).map(el => parseInt(el.getAttribute('data-notif-id')));
    readIds = readIds.filter(id => currentNotifIds.includes(id));
    setReadNotifications(readIds);

    notifItems.forEach(item => {
        const id = parseInt(item.getAttribute('data-notif-id'));
        if (readIds.includes(id)) {
            // Sudah dibaca → hapus latar biru
            item.classList.remove('bg-light');
            item.style.backgroundColor = '';
        } else {
            // Belum dibaca → beri latar biru
            item.classList.add('bg-light');
            item.style.backgroundColor = '#cce5ff';  // Warna biru muda
            unreadCount++;
        }
    });

    const badge = document.getElementById('notifBadge');
    if (badge) {
        if (unreadCount > 0) {
            badge.style.display = 'inline-block';
            badge.textContent = unreadCount;
        } else {
            badge.style.display = 'none';
            badge.textContent = '';
        }
    }
}
