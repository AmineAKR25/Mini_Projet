document.addEventListener('DOMContentLoaded', function() {
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('file-input');
    const fileDetails = document.getElementById('file-details');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const uploadProgress = document.getElementById('upload-progress');
    const progressFill = document.getElementById('progress-fill');
    const progressText = document.getElementById('progress-text');
    const uploadForm = document.getElementById('upload-form');
    
    if (!dropzone || !fileInput) return;
    
    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Handle file selection
    function handleFileSelect(file) {
        if (!file) return;
        
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        fileDetails.classList.remove('hidden');
        
        // Check file size (10MB limit)
        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
        
        if (file.size > maxSize) {
            alert('Le fichier est trop volumineux. Taille maximale: 10MB.');
            fileInput.value = '';
            fileDetails.classList.add('hidden');
        }
    }
    
    // File input change event
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        handleFileSelect(file);
    });
    
    // Drag and drop events
    dropzone.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropzone.classList.add('dragover');
    });
    
    dropzone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropzone.classList.remove('dragover');
    });
    
    dropzone.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropzone.classList.remove('dragover');
        
        const file = e.dataTransfer.files[0];
        fileInput.files = e.dataTransfer.files;
        handleFileSelect(file);
    });
    
    // Click on dropzone to trigger file input
    dropzone.addEventListener('click', function() {
        fileInput.click();
    });
    
    // Form submission with progress
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            const file = fileInput.files[0];
            
            if (!file) return;
            
            // Show progress bar
            uploadProgress.classList.remove('hidden');
            
            // Simulate upload progress (since we can't intercept actual form submission)
            // This is just for visual feedback, the actual upload is handled by the form submission
            let progress = 0;
            const interval = setInterval(function() {
                progress += 5;
                if (progress > 100) {
                    clearInterval(interval);
                    return;
                }
                
                progressFill.style.width = progress + '%';
                progressText.textContent = progress + '%';
            }, 100);
        });
    }
});