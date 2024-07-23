@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-5">Upload Directory</h1>
    <form id="directoryForm" action="{{ route('directories.scan') }}" method="POST" class="mb-4">
        @csrf
        <div class="form-group">
            <label for="directory_path" class="form-label">Select Directory:</label>
            <div class="custom-file">
                <input type="file" id="directory_path" webkitdirectory directory class="custom-file-input" required>
                <label class="custom-file-label" for="directory_path">Choose directory</label>
            </div>
            <input type="hidden" id="directory_full_path" name="directory_full_path">
        </div>
        <button type="submit" class="btn btn-secondary mt-3">Scan Directory</button>
    </form>
    <div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var directoryInput = document.getElementById('directory_path');
        directoryInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const fullPath = "C:\\" + this.files[0].webkitRelativePath.split('/')[0];
                this.nextElementSibling.innerHTML = fullPath;
                document.getElementById('directory_full_path').value = fullPath;
            } else {
                this.nextElementSibling.innerHTML = 'Choose directory';
            }
        });

        document.getElementById('directoryForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const directoryPath = document.getElementById('directory_full_path').value;

            if (!directoryPath) {
                showToast('Please select a directory.');
                return;
            }

            const formData = new FormData();
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            formData.append('directory_path', directoryPath);

            fetch(this.action, {
                method: 'POST',
                body: formData
            }).then(response => response.json())
            .then(data => {
                if (data.error) {
                    showToast(`Failed to scan directory: ${data.error}`);
                } else {
                    showToast('Directory scanned successfully!');
                    setTimeout(() => {
                        window.location.href = "{{ route('directories.index') }}";
                    }, 3000);
                }
            }).catch(error => {
                showToast(`Failed to scan directory: ${error.message}`);
            });
        });

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
    });
</script>
@endsection
