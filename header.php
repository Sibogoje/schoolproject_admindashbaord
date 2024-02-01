      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item">
            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="dynamicPageName">
              <!-- Page name will be set here -->
            </a>
             </li>
             <script>
              document.addEventListener('DOMContentLoaded', function() {
                  // Assuming URL pattern like "http://example.com/page-name.php" or "http://example.com/#/page-name"
                  var urlPath = window.location.pathname || window.location.hash;
                  // Extract the page name using regex. Adjust the regex pattern based on your URL structure.
                  var pageName = urlPath.match(/\/([^\/]*?)(\/?|)$/)[1];
                  // Remove the .php extension, convert dashes to spaces, and capitalize if needed
                  pageName = pageName.replace('.php', '').replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

                  // Check if pageName is empty or not, set a default value if it is
                  if (!pageName || pageName === 'Index') pageName = "Home"; // Default page name, treating 'Index' as 'Home'

                  // Set the extracted page name to the navigation item
                  document.getElementById('dynamicPageName').textContent = pageName;
              });
              </script>


          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    
                    <a href="https://liquag.com/dev/school/admin/logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->

