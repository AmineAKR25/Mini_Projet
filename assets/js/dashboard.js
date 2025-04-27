document.addEventListener('DOMContentLoaded', function() {
    const fileSearch = document.getElementById('file-search');
    const fileItems = document.querySelectorAll('.file-item');
    
    if (!fileSearch || !fileItems.length) return;
    
    // Search functionality
    fileSearch.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        fileItems.forEach(item => {
            const fileName = item.querySelector('.file-name').textContent.toLowerCase();
            
            if (fileName.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
        
        // Show message if no results
        const visibleItems = Array.from(fileItems).filter(item => item.style.display !== 'none');
        const fileList = document.querySelector('.file-list');
        let noResultsMsg = document.getElementById('no-results-message');
        
        if (visibleItems.length === 0 && searchTerm !== '') {
            if (!noResultsMsg) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.id = 'no-results-message';
                noResultsMsg.className = 'empty-state';
                noResultsMsg.innerHTML = `
                    <h3>Aucun résultat</h3>
                    <p>Aucun fichier ne correspond à votre recherche "${searchTerm}"</p>
                `;
                fileList.parentNode.appendChild(noResultsMsg);
            }
            fileList.style.display = 'none';
        } else {
            if (noResultsMsg) {
                noResultsMsg.remove();
            }
            fileList.style.display = '';
        }
    });
    
    // Sort functionality
    const fileHeaders = document.querySelectorAll('.file-header span');
    
    fileHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const column = this.className.replace('-header', '');
            const isAscending = !this.classList.contains('sorted-asc');
            
            // Reset all headers
            fileHeaders.forEach(h => {
                h.classList.remove('sorted-asc', 'sorted-desc');
            });
            
            // Set current sort direction
            this.classList.add(isAscending ? 'sorted-asc' : 'sorted-desc');
            
            // Get all file items as an array for sorting
            const itemsArray = Array.from(fileItems);
            
            // Sort the array
            itemsArray.sort((a, b) => {
                let aValue = a.querySelector(`.${column}`).textContent;
                let bValue = b.querySelector(`.${column}`).textContent;
                
                // Special handling for file size
                if (column === 'file-size') {
                    // Extract numeric value and unit
                    const aMatch = aValue.match(/^([\d.]+)\s*([A-Z]+)$/);
                    const bMatch = bValue.match(/^([\d.]+)\s*([A-Z]+)$/);
                    
                    if (aMatch && bMatch) {
                        const aNum = parseFloat(aMatch[1]);
                        const aUnit = aMatch[2];
                        const bNum = parseFloat(bMatch[1]);
                        const bUnit = bMatch[2];
                        
                        // Convert to bytes for comparison
                        const units = {
                            'B': 1,
                            'KB': 1024,
                            'MB': 1024 * 1024,
                            'GB': 1024 * 1024 * 1024,
                            'TB': 1024 * 1024 * 1024 * 1024
                        };
                        
                        const aBytes = aNum * units[aUnit];
                        const bBytes = bNum * units[bUnit];
                        
                        return isAscending ? aBytes - bBytes : bBytes - aBytes;
                    }
                }
                
                // Special handling for dates
                if (column === 'file-date') {
                    const aParts = aValue.split(/[\s\/\:]/);
                    const bParts = bValue.split(/[\s\/\:]/);
                    
                    if (aParts.length >= 5 && bParts.length >= 5) {
                        // Convert DD/MM/YYYY HH:MM to YYYY-MM-DD HH:MM for proper comparison
                        const aDate = new Date(aParts[2], aParts[1] - 1, aParts[0], aParts[3], aParts[4]);
                        const bDate = new Date(bParts[2], bParts[1] - 1, bParts[0], bParts[3], bParts[4]);
                        
                        return isAscending ? aDate - bDate : bDate - aDate;
                    }
                }
                
                // Default string comparison
                return isAscending
                    ? aValue.localeCompare(bValue)
                    : bValue.localeCompare(aValue);
            });
            
            // Reorder items in the DOM
            const fileList = document.querySelector('.file-list');
            const fileHeader = document.querySelector('.file-header');
            
            // Clear the list except the header
            while (fileList.childNodes.length > 1) {
                fileList.removeChild(fileList.lastChild);
            }
            
            // Append sorted items
            itemsArray.forEach(item => {
                fileList.appendChild(item);
            });
        });
    });
});