<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    {{-- <title>General Dashboard &mdash; Stisla</title> --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo/logo-transparent.png') }}">
    <title>@yield('pagetitle')</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/weather-icon/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/weather-icon/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

    <!-- datatable CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css" integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- /END GA -->

    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            {{-- tod navbar --}}
            @include('partials._header')
            {{-- sidebar nav --}}

            @include('partials._sidebar')
            <!-- Main Content -->
            <div class="main-content">


                {{-- Temp error --}}
                @if ($errors->any())
                    <script>
                        Swal.fire({
                            title: 'Validation Error!',
                            html: `
                                <ul style="text-align:left;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            `,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    </script>
                @endif

                {{-- Temp error end --}}

                @yield('main-content')

            </div>
            {{-- footer area --}}
            @include('partials._footer')
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('assets/modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('assets/modules/chart.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/scripts/choices.min.js"></script>
    <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>

    <script src="{{ asset('assets/modules/cleave-js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('assets/modules/cleave-js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/index-0.js') }}"></script>

    <!--datatble JS Libraies -->
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script> {{-- Auto hide after 5 seconds --}}
    <script>
        setTimeout(() => {
            document.querySelectorAll('.custom-alert').forEach(alert => {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 500); // remove after fade effect
            });
        }, 5000);
    </script>

    <!-- Search Functionality -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('global-search');
        const searchResults = document.getElementById('search-results');
        const searchItemsContainer = document.getElementById('search-items-container');
        const searchBackdrop = document.querySelector('.search-backdrop');
        
        // Define menu items with their routes and icons
        const menuItems = [
            { name: 'Dashboard', url: '{{ route("dashboard") }}', icon: 'fas fa-home', category: 'Main' },
            @can('user.view')
            { name: 'Users Management', url: '{{ route("users.index") }}', icon: 'fas fa-users', category: 'Main' },
            @endcan
            { name: 'Owner', url: '{{ route("owners.index") }}', icon: 'far fa-user', category: 'Main' },
            { name: 'Tenant', url: '{{ route("tenants.index") }}', icon: 'fas fa-th', category: 'Tenant' },
            { name: 'Rent', url: '{{ route("rents.index") }}', icon: 'fas fa-th', category: 'Tenant' },
            { name: 'Tower', url: '{{ route("towers.index") }}', icon: 'fa-regular fa-building', category: 'Apartment' },
            { name: 'Floor', url: '{{ route("floors.index") }}', icon: 'fa-regular fa-building', category: 'Apartment' },
            { name: 'Apartment', url: '{{ route("apartments.index") }}', icon: 'fa-regular fa-building', category: 'Apartment' },
            { name: 'Parking', url: '{{ route("parkings.index") }}', icon: 'fa-regular fa-building', category: 'Apartment' },
            { name: 'Amenities', url: '{{ route("amenities.index") }}', icon: 'fas fa-th-large', category: 'Amenities' },
            { name: 'Maintenance Report', url: '{{ url("reports") }}', icon: 'far fa-file-alt', category: 'Report' },
            { name: 'Apartment Type', url: '{{ route("settings.types.index") }}', icon: 'fas fa-cog', category: 'Settings' },
            { name: 'Service Type', url: '{{ route("settings.service_types.index") }}', icon: 'fas fa-cog', category: 'Settings' },
            { name: 'Maintenance', url: '{{ route("settings.maintenance.index") }}', icon: 'fas fa-cog', category: 'Settings' },
            { name: 'Events', url: '#', icon: 'fas fa-calendar', category: 'Main' },
            { name: 'Profile', url: '{{ route("profile") }}', icon: 'far fa-user', category: 'User' }
        ];

        // Recent searches (stored in localStorage)
        let recentSearches = JSON.parse(localStorage.getItem('recentSearches') || '[]');

        function performSearch(query) {
            if (!query) {
                searchResults.style.display = 'none';
                return;
            }

            const filteredItems = menuItems.filter(item => 
                item.name.toLowerCase().includes(query.toLowerCase())
            );

            // Group results by category
            const groupedResults = {};
            filteredItems.forEach(item => {
                if (!groupedResults[item.category]) {
                    groupedResults[item.category] = [];
                }
                groupedResults[item.category].push(item);
            });

            // Build HTML
            let html = '';

            // Show recent searches if query is empty or short
            if (query.length <= 2 && recentSearches.length > 0) {
                html += '<div class="search-header">Recent Searches</div>';
                recentSearches.slice(0, 3).forEach(search => {
                    html += `
                        <div class="search-item">
                            <a href="${search.url}">
                                <div class="search-icon bg-primary text-white mr-3">
                                    <i class="${search.icon}"></i>
                                </div>
                                ${search.name}
                            </a>
                            <a href="#" class="search-close" onclick="removeRecentSearch('${search.name}'); return false;">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    `;
                });
            }

            // Show search results
            if (filteredItems.length > 0) {
                Object.keys(groupedResults).forEach(category => {
                    html += `<div class="search-header">${category}</div>`;
                    groupedResults[category].forEach(item => {
                        const bgColor = category === 'Settings' ? 'bg-warning' : 
                                       category === 'Apartment' ? 'bg-info' :
                                       category === 'Tenant' ? 'bg-success' :
                                       category === 'Report' ? 'bg-danger' : 'bg-primary';
                        
                        html += `
                            <div class="search-item">
                                <a href="${item.url}" onclick="addToRecentSearch('${item.name}', '${item.url}', '${item.icon}')">
                                    <div class="search-icon ${bgColor} text-white mr-3">
                                        <i class="${item.icon}"></i>
                                    </div>
                                    ${item.name}
                                </a>
                            </div>
                        `;
                    });
                });
            } else if (query.length > 2) {
                html = '<div class="search-header">No Results Found</div>';
                html += '<div class="search-item">No menu items match your search.</div>';
            }

            searchItemsContainer.innerHTML = html;
            searchResults.style.display = html ? 'block' : 'none';
        }

        // Search input event
        searchInput.addEventListener('input', function(e) {
            performSearch(e.target.value);
        });

        // Focus event - show results if there's text
        searchInput.addEventListener('focus', function(e) {
            if (e.target.value || recentSearches.length > 0) {
                performSearch(e.target.value);
            }
        });

        // Click outside to close
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });

        // Add to recent searches
        window.addToRecentSearch = function(name, url, icon) {
            const search = { name, url, icon };
            recentSearches = recentSearches.filter(s => s.name !== name);
            recentSearches.unshift(search);
            recentSearches = recentSearches.slice(0, 5); // Keep only last 5
            localStorage.setItem('recentSearches', JSON.stringify(recentSearches));
        };

        // Remove from recent searches
        window.removeRecentSearch = function(name) {
            recentSearches = recentSearches.filter(s => s.name !== name);
            localStorage.setItem('recentSearches', JSON.stringify(recentSearches));
            performSearch(searchInput.value);
        };

        // Handle keyboard navigation
        searchInput.addEventListener('keydown', function(e) {
            const items = searchItemsContainer.querySelectorAll('.search-item a:first-child');
            const activeItem = searchItemsContainer.querySelector('.search-item.active');
            let currentIndex = -1;
            
            if (activeItem) {
                items.forEach((item, index) => {
                    if (item.parentElement === activeItem) {
                        currentIndex = index;
                    }
                });
            }

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (currentIndex >= 0) {
                    items[currentIndex].parentElement.classList.remove('active');
                }
                currentIndex = (currentIndex + 1) % items.length;
                if (items[currentIndex]) {
                    items[currentIndex].parentElement.classList.add('active');
                    items[currentIndex].focus();
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (currentIndex >= 0) {
                    items[currentIndex].parentElement.classList.remove('active');
                }
                currentIndex = currentIndex <= 0 ? items.length - 1 : currentIndex - 1;
                if (items[currentIndex]) {
                    items[currentIndex].parentElement.classList.add('active');
                    items[currentIndex].focus();
                }
            } else if (e.key === 'Enter') {
                if (currentIndex >= 0 && items[currentIndex]) {
                    e.preventDefault();
                    items[currentIndex].click();
                }
            } else if (e.key === 'Escape') {
                searchResults.style.display = 'none';
                searchInput.blur();
            }
        });
    });
    </script>



    <!-- Common SweetAlert Functions -->
    <script>
    // Common SweetAlert success function
    function showSuccessAlert(message, callback = null, timer = 3000) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: message,
            timer: timer,
            showConfirmButton: true,
            confirmButtonText: 'OK',
            confirmButtonColor: '#28a745'
        }).then((result) => {
            if (callback && typeof callback === 'function') {
                callback();
            }
        });
    }

    // Common SweetAlert error function
    function showErrorAlert(message, callback = null) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: message,
            showConfirmButton: true,
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc3545'
        }).then((result) => {
            if (callback && typeof callback === 'function') {
                callback();
            }
        });
    }

    // Common SweetAlert warning function
    function showWarningAlert(message, callback = null) {
        Swal.fire({
            icon: 'warning',
            title: 'Warning!',
            text: message,
            showConfirmButton: true,
            confirmButtonText: 'OK',
            confirmButtonColor: '#ffc107'
        }).then((result) => {
            if (callback && typeof callback === 'function') {
                callback();
            }
        });
    }

    // Common SweetAlert info function
    function showInfoAlert(message, callback = null) {
        Swal.fire({
            icon: 'info',
            title: 'Information',
            text: message,
            showConfirmButton: true,
            confirmButtonText: 'OK',
            confirmButtonColor: '#17a2b8'
        }).then((result) => {
            if (callback && typeof callback === 'function') {
                callback();
            }
        });
    }

    // Common SweetAlert confirmation function
    function showConfirmAlert(title, text, confirmCallback, cancelCallback = null) {
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, proceed!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed && confirmCallback && typeof confirmCallback === 'function') {
                confirmCallback();
            } else if (result.isDismissed && cancelCallback && typeof cancelCallback === 'function') {
                cancelCallback();
            }
        });
    }

    // Loading alert function
    function showLoadingAlert(message = 'Processing...') {
        Swal.fire({
            title: message,
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
    }

    // Close any open SweetAlert
    function closeSweetAlert() {
        Swal.close();
    }
    </script>

     <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Initialize Flatpickr for payment date
        flatpickr('#datepicker', {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'F j, Y',
            // maxDate: 'today'
        });
        </script>

    @yield('scripts')
</body>

</html>
