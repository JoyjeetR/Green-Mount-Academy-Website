function toggleSidebar() {
    var sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("active");
    
    // Create or toggle overlay
    var overlay = document.querySelector(".sidebar-overlay");
    if (!overlay) {
        overlay = document.createElement("div");
        overlay.className = "sidebar-overlay";
        document.body.appendChild(overlay);
        
        // Close sidebar when clicking overlay
        overlay.addEventListener('click', function() {
            sidebar.classList.remove("active");
            overlay.classList.remove("active");
            document.body.style.overflow = "";
        });
    }
    
    // Prevent body scroll when sidebar is open on mobile
    if (window.innerWidth <= 768) {
        if (sidebar.classList.contains("active")) {
            overlay.classList.add("active");
            document.body.style.overflow = "hidden";
        } else {
            overlay.classList.remove("active");
            document.body.style.overflow = "";
        }
    }
}

    // Close sidebar when clicking on sidebar links on mobile
    document.addEventListener('DOMContentLoaded', function() {
        var sidebar = document.getElementById("sidebar");
        var overlay = document.querySelector(".sidebar-overlay");
        
        // Close sidebar when clicking on sidebar links on mobile
        var sidebarLinks = sidebar.querySelectorAll('a');
        sidebarLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove("active");
                    if (overlay) overlay.classList.remove("active");
                    document.body.style.overflow = "";
                }
            });
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove("active");
                if (overlay) overlay.classList.remove("active");
                document.body.style.overflow = "";
            }
        });
    });

// Reset all filters when page is refreshed (F5 or refresh button)
(function() {
    var isReload = false;
    if (performance.getEntriesByType) {
        var nav = performance.getEntriesByType('navigation')[0];
        if (nav && nav.type === 'reload') isReload = true;
    } else if (performance.navigation && performance.navigation.type === 1) {
        isReload = true;
    }
    if (isReload && window.location.search) {
        window.location.replace('branch_enquiries.php');
    }
})();