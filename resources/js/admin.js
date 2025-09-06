// Admin-specific JavaScript with performance optimizations

// Import utilities
import './bootstrap';

// Performance optimizations
const AdminApp = {
    // Initialize admin features
    init() {
        this.setupLazyLoading();
        this.setupFormValidation();
        this.setupTableOptimizations();
        this.setupImagePreview();
        this.setupConfirmDialogs();
        this.setupTooltips();
        this.setupSearchDebounce();
    },

    // Lazy loading for image
    setupLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    },

    // Enhanced form validation
    setupFormValidation() {
        const forms = document.querySelectorAll('.needs-validation');
        
        forms.forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    },

    // Table optimizations
    setupTableOptimizations() {
        // Virtual scrolling for large tables
        const largeTables = document.querySelectorAll('.table-large');
        largeTables.forEach(table => {
            this.enableVirtualScrolling(table);
        });

        // Sortable columns
        const sortableHeaders = document.querySelectorAll('.sortable');
        sortableHeaders.forEach(header => {
            header.addEventListener('click', this.handleSort.bind(this));
        });
    },

    // Image preview functionality
    setupImagePreview() {
        const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
        
        imageInputs.forEach(input => {
            input.addEventListener('change', event => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const preview = document.querySelector(`#${input.id}-preview`);
                        if (preview) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    },

    // Confirmation dialogs
    setupConfirmDialogs() {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', event => {
                if (!confirm('Are you sure you want to delete this item?')) {
                    event.preventDefault();
                }
            });
        });
    },

    // Bootstrap tooltips
    setupTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(tooltipTriggerEl => {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    },

    // Debounced search
    setupSearchDebounce() {
        const searchInputs = document.querySelectorAll('.search-input');
        
        searchInputs.forEach(input => {
            let timeout;
            input.addEventListener('input', event => {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    this.performSearch(event.target.value);
                }, 300);
            });
        });
    },

    // Virtual scrolling implementation
    enableVirtualScrolling(table) {
        // Simple virtual scrolling for demonstration
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const rowHeight = 50; // Approximate row height
        const visibleRows = Math.ceil(window.innerHeight / rowHeight);
        
        let startIndex = 0;
        
        const updateVisibleRows = () => {
            rows.forEach((row, index) => {
                if (index >= startIndex && index < startIndex + visibleRows) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        };
        
        table.addEventListener('scroll', () => {
            startIndex = Math.floor(table.scrollTop / rowHeight);
            updateVisibleRows();
        });
        
        updateVisibleRows();
    },

    // Sort handler
    handleSort(event) {
        const header = event.currentTarget;
        const table = header.closest('table');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const columnIndex = Array.from(header.parentNode.children).indexOf(header);
        const isAscending = !header.classList.contains('sort-asc');
        
        // Remove existing sort classes
        header.parentNode.querySelectorAll('.sortable').forEach(h => {
            h.classList.remove('sort-asc', 'sort-desc');
        });
        
        // Add new sort class
        header.classList.add(isAscending ? 'sort-asc' : 'sort-desc');
        
        // Sort rows
        rows.sort((a, b) => {
            const aValue = a.cells[columnIndex].textContent.trim();
            const bValue = b.cells[columnIndex].textContent.trim();
            
            if (isAscending) {
                return aValue.localeCompare(bValue, undefined, { numeric: true });
            } else {
                return bValue.localeCompare(aValue, undefined, { numeric: true });
            }
        });
        
        // Reorder DOM
        rows.forEach(row => tbody.appendChild(row));
    },

    // Search functionality
    performSearch(query) {
        // Implement search logic here
        console.log('Searching for:', query);
    },

    // Loading state management
    showLoading(element) {
        element.classList.add('loading');
        const spinner = document.createElement('div');
        spinner.className = 'spinner-border spinner-border-sm me-2';
        spinner.setAttribute('role', 'status');
        element.prepend(spinner);
    },

    hideLoading(element) {
        element.classList.remove('loading');
        const spinner = element.querySelector('.spinner-border');
        if (spinner) {
            spinner.remove();
        }
    },

    // Utility functions
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }
};

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => AdminApp.init());
} else {
    AdminApp.init();
}

// Export for global access
window.AdminApp = AdminApp;

// Performance monitoring
if ('performance' in window) {
    window.addEventListener('load', () => {
        setTimeout(() => {
            const perfData = performance.getEntriesByType('navigation')[0];
            console.log('Page load time:', perfData.loadEventEnd - perfData.loadEventStart, 'ms');
        }, 0);
    });
}