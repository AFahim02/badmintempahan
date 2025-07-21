@extends('adminpage.adminlayout.home')

@section('title', 'Send Notification')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Send Notification</h1>
    
    @if (session('success'))
        <div id="success-message" class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form id="notificationForm">
                @csrf
                <div class="form-group">
                    <label for="user_id">Select User</label>
                    <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                        <option value="">Select a user</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <input type="text" class="form-control @error('message') is-invalid @enderror" id="message" name="message" required>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Send Notification</button>
            </form>
        </div>
    </div>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}'
        });

        var channel = pusher.subscribe('notifications');
        channel.bind('new-notification', function(data) {
            alert("New Notification: " + data.message);
        });

        document.getElementById('notificationForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            
            fetch('{{ route("admin.notifications.send") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const successMessage = document.createElement('div');
                    successMessage.className = 'alert alert-success';
                    successMessage.role = 'alert';
                    successMessage.innerText = 'Your notification has been successfully sent!';
                    document.querySelector('.container').prepend(successMessage);

                    setTimeout(() => {
                        successMessage.style.transition = 'opacity 0.5s ease';
                        successMessage.style.opacity = '0';
                        setTimeout(() => {
                            successMessage.remove();
                        }, 500);
                    }, 3000);

                    this.reset();
                } else {
                    alert('Failed to send notification: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while sending the notification.');
            });
        });
    </script>
</div>

{{-- Custom Styles --}}
<style>
    .card {
        border-radius: 12px;
    }

    .form-control {
        border-radius: 8px;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        border-color: #007bff;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .alert {
        border-radius: 8px;
    }
</style>
@endsection