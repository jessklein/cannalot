// App.js - Main JavaScript functionality for Cannalot Dashboard

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize dashboard functionality
    initializeDashboard();
    
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize data tables
    initializeDataTables();
    
    // Initialize modals
    initializeModals();
    
});

/**
 * Initialize dashboard functionality
 */
function initializeDashboard() {
    // Mobile sidebar toggle
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('aside');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }
    
    // Auto-refresh dashboard stats (every 30 seconds) - DISABLED until API is implemented
    // if (window.location.pathname === '/dashboard' || window.location.pathname === '/') {
    //     setInterval(refreshDashboardStats, 30000);
    // }
    
    // Initialize tooltips
    initializeTooltips();
}

/**
 * Form validation
 */
function initializeFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });
}

function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            showFieldError(field, 'This field is required');
            isValid = false;
        } else {
            clearFieldError(field);
        }
    });
    
    // Email validation
    const emailFields = form.querySelectorAll('input[type="email"]');
    emailFields.forEach(field => {
        if (field.value && !isValidEmail(field.value)) {
            showFieldError(field, 'Please enter a valid email address');
            isValid = false;
        }
    });
    
    return isValid;
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'text-red-500 text-sm mt-1 field-error';
    errorDiv.textContent = message;
    
    field.classList.add('border-red-500');
    field.parentNode.appendChild(errorDiv);
}

function clearFieldError(field) {
    field.classList.remove('border-red-500');
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Data tables functionality
 */
function initializeDataTables() {
    // Search functionality
    const searchInputs = document.querySelectorAll('input[data-table-search]');
    
    searchInputs.forEach(input => {
        const tableId = input.getAttribute('data-table-search');
        const table = document.getElementById(tableId);
        
        if (table) {
            input.addEventListener('input', function() {
                filterTable(table, this.value);
            });
        }
    });
}

function filterTable(table, searchTerm) {
    const rows = table.querySelectorAll('tbody tr');
    const term = searchTerm.toLowerCase();
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(term) ? '' : 'none';
    });
}

/**
 * Modal functionality
 */
function initializeModals() {
    // Modal triggers
    const modalTriggers = document.querySelectorAll('[data-modal-target]');
    
    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            if (modal) {
                showModal(modal);
            }
        });
    });
    
    // Modal close buttons
    const modalCloseButtons = document.querySelectorAll('[data-modal-close]');
    
    modalCloseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) {
                hideModal(modal);
            }
        });
    });
    
    // Close modal on overlay click
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            const modal = e.target.closest('.modal');
            if (modal) {
                hideModal(modal);
            }
        }
    });
}

function showModal(modal) {
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function hideModal(modal) {
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

/**
 * Tooltip functionality
 */
function initializeTooltips() {
    const tooltipTriggers = document.querySelectorAll('[data-tooltip]');
    
    tooltipTriggers.forEach(trigger => {
        trigger.addEventListener('mouseenter', function() {
            showTooltip(this);
        });
        
        trigger.addEventListener('mouseleave', function() {
            hideTooltip(this);
        });
    });
}

function showTooltip(element) {
    const tooltipText = element.getAttribute('data-tooltip');
    const tooltip = document.createElement('div');
    
    tooltip.className = 'absolute z-50 px-2 py-1 text-sm text-white bg-black rounded shadow-lg tooltip';
    tooltip.textContent = tooltipText;
    
    document.body.appendChild(tooltip);
    
    const rect = element.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
}

function hideTooltip(element) {
    const tooltip = document.querySelector('.tooltip');
    if (tooltip) {
        tooltip.remove();
    }
}

/**
 * Refresh dashboard stats
 */
function refreshDashboardStats() {
    fetch('/api/dashboard/stats')
        .then(response => response.json())
        .then(data => {
            // Update stats cards
            updateStatsCards(data);
        })
        .catch(error => {
            console.error('Error refreshing dashboard stats:', error);
        });
}

function updateStatsCards(stats) {
    const statsElements = {
        'total_users': document.querySelector('[data-stat="total_users"]'),
        'total_orders': document.querySelector('[data-stat="total_orders"]'),
        'total_revenue': document.querySelector('[data-stat="total_revenue"]'),
        'pending_orders': document.querySelector('[data-stat="pending_orders"]')
    };
    
    Object.keys(statsElements).forEach(key => {
        const element = statsElements[key];
        if (element && stats[key] !== undefined) {
            element.textContent = formatStatValue(key, stats[key]);
        }
    });
}

function formatStatValue(type, value) {
    switch (type) {
        case 'total_revenue':
            return '$' + Number(value).toLocaleString();
        default:
            return Number(value).toLocaleString();
    }
}

/**
 * Utility functions
 */

// Show loading spinner
function showLoading(element) {
    const spinner = document.createElement('div');
    spinner.className = 'spinner';
    element.appendChild(spinner);
}

// Hide loading spinner
function hideLoading(element) {
    const spinner = element.querySelector('.spinner');
    if (spinner) {
        spinner.remove();
    }
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-md z-50 notification alert-${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// Confirm dialog
function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// AJAX helper
function ajaxRequest(url, options = {}) {
    const defaultOptions = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    };
    
    return fetch(url, { ...defaultOptions, ...options });
}

// Export functions for global use
window.CannalotDashboard = {
    showModal,
    hideModal,
    showNotification,
    confirmAction,
    ajaxRequest,
    showLoading,
    hideLoading
};
