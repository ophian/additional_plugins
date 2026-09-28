/***
 * Staticpage event backend JS
 * Refactored to modern Vanilla JS (ES6+)
 * Last modified: 2026-09-28
 **/

/**
 * Vanilla JS Pagination for the Staticpage-Entries list
 */
function renderStaticpagePagination(containerEl, totalItems, itemsPerPage, onPageChange) {
    if (!containerEl || totalItems <= 0) return;

    const totalPages = Math.ceil(totalItems / itemsPerPage);

    // Break if only page 1
    if (totalPages <= 1) {
        containerEl.innerHTML = '';
        return;
    }

    let currentPage = 1;

    const draw = () => {
        let html = '<ul class="simple-pagination light-theme">';

        // Previous Button
        if (currentPage > 1) {
            html += `<li><a href="#page-${currentPage - 1}" class="page-link prev" data-page="${currentPage - 1}">Prev</a></li>`;
        } else {
            html += '<li class="disabled"><span class="current prev">Prev</span></li>';
        }

        // Page Links
        for (let i = 1; i <= totalPages; i++) {
            if (i === currentPage) {
                html += `<li class="active"><span class="current">${i}</span></li>`;
            } else {
                html += `<li><a href="#page-${i}" class="page-link" data-page="${i}">${i}</a></li>`;
            }
        }

        // Next Button
        if (currentPage < totalPages) {
            html += `<li><a href="#page-${currentPage + 1}" class="page-link next" data-page="${currentPage + 1}">Next</a></li>`;
        } else {
            html += '<li class="disabled"><span class="current next">Next</span></li>';
        }

        html += '</ul>';
        containerEl.innerHTML = html;

        // Click Event Handler Delegation
        containerEl.querySelectorAll('a.page-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const selectedPage = parseInt(link.getAttribute('data-page'), 10);
                if (selectedPage && selectedPage !== currentPage) {
                    currentPage = selectedPage;
                    draw();
                    onPageChange(currentPage, totalPages);
                }
            });
        });
    };

    // First Render-Loop initiation
    draw();
}

/**
 * Stores 'remember option' states in localStorage
 * @param {string} name
 * @param {any} value
 */
window.setLocalStorage = function(name, value) {
    try {
        localStorage.removeItem(name);
        localStorage.setItem(name, JSON.stringify(value));
    } catch (e) {
        console.warn('LocalStorage unavailable:', e);
    }
};

/**
 * Toggles visibility of top tab navigation bar
 * @param {HTMLElement} b - Button element
 */
window.setTabBar = function(b) {
    const nav = document.getElementById('serendipityStaticpagesNav');
    const spNav = document.getElementById('sp_navigator');
    if (!nav) return false;

    const isVisible = window.getComputedStyle(nav).display !== 'none';

    if (isVisible) {
        nav.style.display = 'none';
        if (spNav) spNav.style.marginTop = '1.54em';

        if (b) {
            b.textContent = 'Show TabBar';
            b.classList.remove('icon-up-dir');
            b.classList.add('icon-down-dir');
        }
        window.setLocalStorage('staticpageTabBar', true);
    } else {
        nav.style.display = '';
        if (spNav) spNav.style.removeProperty('margin-top');

        if (b) {
            b.textContent = 'Hide TabBar';
            b.classList.remove('icon-down-dir');
            b.classList.add('icon-up-dir');
        }
        localStorage.removeItem('staticpageTabBar');
    }
    return false;
};

/**
 * Saves moved sequencers order IDs via Fetch API
 */
window.saveNewOrder = function() {
    const sequenceContainer = document.getElementById('sequence');
    if (!sequenceContainer) return;

    const ids = Array.from(sequenceContainer.children)
        .map(child => child.id)
        .filter(Boolean);

    const idList = ids.join(',');
    const url = `?serendipity[adminModule]=staticpages&serendipity[moveto]=move&serendipity[pagemoveorder]=${encodeURIComponent(idList)}&serendipity[adminModule]=event_display&serendipity[adminAction]=staticpages&serendipity[staticpagecategory]=pageorder`;

    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            const targetEl = document.getElementById('splistorder');
            if (targetEl) {
                targetEl.innerHTML = `<span class="icon-ok"></span> New staticpage pageorder list ${idList} successfully saved`;
            }
        })
        .catch(err => console.error('Failed to save page order:', err));
};

/**
 * Main Initializer on DOM Ready
 */
document.addEventListener('DOMContentLoaded', () => {

    // 1. Staticpage entries list Pagination executor
    const stepEl = document.getElementById('step');
    const items = stepEl ? Array.from(stepEl.querySelectorAll('.sp_entries_pane')) : [];
    const numItems = items.length;
    const perPage = (typeof spconfig_listPerPage !== 'undefined') ? spconfig_listPerPage : 6;
    const paginationEl = document.getElementById('sp_entry_pagination');

    if (stepEl && numItems > 0) {
        const updateBorders = (pageNumber, totalPages) => {
            if (pageNumber === totalPages) {
                stepEl.style.borderBottom = '';
                stepEl.style.marginBottom = '';
            } else {
                stepEl.style.borderBottom = '1px solid #CCC';
                stepEl.style.marginBottom = '1em';
            }
        };

        // Initial styling for the wrapper
        updateBorders(1, Math.ceil(numItems / perPage));

        // Hide all, then show first page
        items.forEach((item, idx) => {
            item.style.display = (idx < perPage) ? '' : 'none';
        });

        // Integrated Pagination Execution
        renderStaticpagePagination(paginationEl, numItems, perPage, (pageNumber, totalPages) => {
            const showFrom = perPage * (pageNumber - 1);
            const showTo = showFrom + perPage;

            items.forEach((item, idx) => {
                item.style.display = (idx >= showFrom && idx < showTo) ? '' : 'none';
            });

            updateBorders(pageNumber, totalPages);
        });
    }

    // 2. Dropdown confirmation handler before page switch
    const dropdown = document.getElementById('staticpage_dropdown');
    if (dropdown) {
        let prevValue = dropdown.value;

        dropdown.addEventListener('focus', () => {
            prevValue = dropdown.value;
        });

        dropdown.addEventListener('change', () => {
            const confirmMsg = typeof dropdown_dialog !== 'undefined' ? dropdown_dialog : 'Discard unsaved changes?';
            if (!confirm(confirmMsg)) {
                dropdown.value = prevValue;
                return false;
            } else if (dropdown.form && dropdown.form.elements['serendipity[staticSubmit]']) {
                dropdown.form.elements['serendipity[staticSubmit]'].click();
            }
        });
    }

    // 3. Collapsible box state executor for entry forms
    Object.keys(localStorage).forEach(key => {
        if (/^(staticpage_mobileform_)|(staticpage_defaultform_)/.test(key)) {
            const parts = key.split('_');
            const targetId = parts[2];
            if (!targetId) return;

            const targetBtn = document.getElementById(targetId);
            const containerId = targetId.replace('option', '');
            const containerEl = document.getElementById(containerId);

            if (localStorage.getItem(key) !== null) {
                if (targetBtn) {
                    const icon = targetBtn.querySelector('.icon-right-dir');
                    if (icon) {
                        icon.classList.remove('icon-right-dir');
                        icon.classList.add('icon-down-dir');
                    }
                }
                if (containerEl) {
                    containerEl.classList.remove('additional_info');
                }
            }
        }
    });

    // 4. Pageorder drag and drop form handler
    const sequencerForm = document.querySelector('#sp_sequencer form');
    if (sequencerForm) {
        sequencerForm.addEventListener('submit', (e) => {
            e.preventDefault();
            e.stopPropagation();

            window.saveNewOrder();

            const target = document.getElementById('splistorder');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }

    // 5. Toggle helper for active configuration group styling
    const optionGroups = document.querySelectorAll('.config_optiongroup:not(.additional_info)');
    optionGroups.forEach(group => {
        let prev = group.previousElementSibling;
        while (prev && !prev.classList.contains('configuration_group')) {
            prev = prev.previousElementSibling;
        }
        if (prev) {
            const btn = prev.querySelector('button.toggle_info.show_config_option.sp_toggle');
            if (btn) btn.classList.add('active');
        }
    });
});

/**
 * Overwrite CKEditor save plugin if registered
 */
if (typeof CKEDITOR !== 'undefined' && CKEDITOR.plugins && CKEDITOR.plugins.registered['save']) {
    CKEDITOR.plugins.registered['save'] = {
        init: function(editor) {
            editor.addCommand('save', {
                modes: { wysiwyg: 1, source: 1 }
            });
        }
    };
}