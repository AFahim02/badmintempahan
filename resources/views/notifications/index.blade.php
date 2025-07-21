@extends('layouts.home')

@section('title', 'Notifications')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Notifications</h2>
    <p class="text-center">You have <strong>{{ $notifications->where('read', false)->count() }}</strong> unread notifications.</p>
    
    <div id="notifications" class="notification-list">
        @foreach($notifications as $notification)
            <div class="notification {{ $notification->read ? 'read' : 'unread' }}">
                <div class="notification-content">
                    <span class="notification-message">{{ $notification->message }}</span>
                </div>
                <button class="delete" data-id="{{ $notification->id }}">🗑️</button>
            </div>
        @endforeach
    </div>
</div>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    var pusher = new Pusher('67ca0d4cfa419d251ce8', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('notifications');
    channel.bind('new-notification', function(data) {
        var notificationsDiv = document.getElementById('notifications');
        var newNotification = document.createElement('div');
        newNotification.classList.add('notification', 'unread');

        newNotification.innerHTML = `
            <div class="notification-content">
                <span class="notification-message">${data.message}</span>
            </div>
            <button class="delete" data-id="${data.id}">🗑️</button>
        `;
        
        notificationsDiv.prepend(newNotification);
        showPopup(data.message);
    });

    function showPopup(message) {
        var popup = document.createElement('div');
        popup.className = 'popup-notification';
        popup.innerText = message;
        document.body.appendChild(popup);
        setTimeout(function() {
            popup.remove();
        }, 5000);
    }

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete')) {
            var notificationId = e.target.getAttribute('data-id');
            fetch(`/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    e.target.closest('.notification').remove();
                } else {
                    alert('Failed to delete notification.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
</script>

{{-- Custom Styles --}}
<style>
    .notification-list {
        max-width: 600px;
        margin: 0 auto;
    }

    .notification {
        border: 1px solid #ccc;
        padding: 15px;
        margin: 10px 0;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background-color 0.3s;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .unread {
        background-color: #f9f9f9;
    }

    .read {
        background-color: #e9ecef;
    }

    .notification-content {
        display: flex;
        align-items: center;
    }

    .notification-message {
        flex-grow: 1;
        margin-right: 15px;
    }

    .delete {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 18px;
        color: #dc3545;
        transition: color 0.3s;
    }

    .delete:hover {
        color: #c82333;
    }

    .popup-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #007bff;
        color: white;
        padding: 15px;
        border-radius: 5px;
        z-index: 1000;
        transition: opacity 0.5s ease;
        opacity: 1;
    }
</style>
@endsection