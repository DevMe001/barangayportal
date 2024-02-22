<script>
    // Function to show the alarming notification
    function showAlarmingNotification() {
        const notification = document.createElement('div');
        notification.className = 'notification';

        const message = document.createElement('div');
        message.className = 'message';
        message.innerText = 'This is an alarming notification!';

        notification.appendChild(message);
        document.body.appendChild(notification);

        // After a delay, remove the notification
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 1000);
        }, 3000);

        // Redirect to request.php after a delay
        setTimeout(() => {
            window.location.href = 'request.php';
        }, 4000);
    }

    // Add a click event listener to the button
    const showNotificationButton = document.getElementById('show-notification-button');
    showNotificationButton.addEventListener('click', showAlarmingNotification);
</script>
