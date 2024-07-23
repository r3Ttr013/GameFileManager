<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Library Manager</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }
        .navbar, .card, .jumbotron {
            background-color: #1e1e1e;
        }
        .card-title, .card-text {
            color: #ffffff;
        }
        .list-group-item {
            background-color: #1e1e1e;
            border: 1px solid #333;
        }
        .btn-primary {
            background-color: #6200ee;
            border-color: #6200ee;
        }
        .btn-secondary {
            background-color: #03dac5;
            border-color: #03dac5;
        }
        .card {
            height: 100%;
        }
        .card-body {
            display: flex;
            flex-direction: column;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        @keyframes hoverUp {
            from {
                transform: translateY(0);
                box-shadow: none;
            }
            to {
                transform: translateY(-10px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            }
        }
    </style>
</head>
<body>
    @include('partials.nav')
    <div class="container mt-5">
        @yield('content')
    </div>
    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
        <div id="toast-container" class="toast-container position-fixed bottom-0 end-0 p-3">
            <!-- Toasts will be dynamically added here -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function showToast(message) {
            const toastHTML = `
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                    <div class="toast-header">
                        <strong class="mr-auto">Notification</strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;
            const toastContainer = document.getElementById('toast-container');
            toastContainer.insertAdjacentHTML('beforeend', toastHTML);
            const toastElement = toastContainer.lastElementChild;
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }
    </script>
</body>
</html>
