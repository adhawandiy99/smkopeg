<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: MetronicProduct Version: 8.2.6
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->


<html lang="en">
  <!--begin::Head-->
  <head>
    <title>@yield('tittle') | SM Pro</title>
    <meta charset="utf-8" />
    <meta
      name="description"
      content="SMPRO, KALSEL, tomman, TOMMAN, tomman.app, smpro"
    />
    <meta
      name="keywords"
      content="SMPRO, KALSEL, tomman, TOMMAN, tomman.app, smpro"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="SMPRO" />
    <meta property="og:title" content="SMPRO" />
    <meta property="og:url" content="https://smpro.tomman.app" />
    <meta property="og:site_name" content="SMPRO" />
    <link rel="canonical" href="http://preview.keenthemes.comlayouts/light-sidebar.html" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    @yield('css')
    <script>
      // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) 
      if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body id="kt_app_body"
    data-kt-app-layout="light-sidebar"
    data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="true"
    data-kt-app-sidebar-fixed="true"
    data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true"
    data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true"
    data-kt-app-toolbar-enabled="true"
    data-kt-app-page-loading-enabled="true"
    data-kt-app-page-loading="on"
    class="app-default">
    <!--begin::Theme mode setup on page load-->
    <script>
      var defaultThemeMode = "light";
      var themeMode;
      if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
          themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
          if (localStorage.getItem("data-bs-theme") !== null) {
            themeMode = localStorage.getItem("data-bs-theme");
          } else {
            themeMode = defaultThemeMode;
          }
        }
        if (themeMode === "system") {
          themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
      }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Page loading(append to body)-->
    <div class="page-loader flex-column bg-dark bg-opacity-25">
      <span class="spinner-border text-primary" role="status"></span>
      <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>
    <!--end::Page loading-->
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
      <!--begin::Page-->
      <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <!--begin::Header-->
        <div id="kt_app_header"
          class="app-header"
          data-kt-sticky="true"
          data-kt-sticky-activate="{default: true, lg: true}"
          data-kt-sticky-name="app-header-minimize"
          data-kt-sticky-offset="{default: '200px', lg: '0'}"
          data-kt-sticky-animation="false">
          <!--begin::Header container-->
          <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
            <!--begin::Sidebar mobile toggle-->
            <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
              <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-outline ki-abstract-14 fs-2 fs-md-1"></i>
              </div>
            </div>
            <!--end::Sidebar mobile toggle-->

            <!--begin::Mobile logo-->
            <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
              <a href="/" class="d-lg-none">
                <img alt="Logo" src="/assets/images/aicrone-logo.png" class="h-30px" />
              </a>
            </div>
            <!--end::Mobile logo-->

            <!--begin::Header wrapper-->
            <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
              <!--begin::Page title-->
              <div
                data-kt-swapper="true"
                data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
                data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0"
              >
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
                  @yield('tittle')
                </h1>
                <!--end::Title-->
              </div>
              <!--end::Page title-->

              <!--begin::Navbar-->
              <div class="app-navbar flex-shrink-0">

                <div id="kt_docs_search" class="d-flex align-items-center w-lg-200px me-2 me-lg-3 show menu-dropdown" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-search-responsive="lg" data-kt-menu-trigger="auto" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end" data-kt-search="true">

                  <!--begin::Tablet and mobile search toggle-->
                  <div data-kt-search-element="toggle" class="d-flex d-lg-none align-items-center">
                      <div class="btn btn-icon btn-color-gray-700 btn-active-color-primary bg-body w-40px h-40px">
                          <i class="ki-duotone ki-magnifier fs-2"><span class="path1"></span><span class="path2"></span></i>
                      </div>
                  </div>
                  <!--end::Tablet and mobile search toggle-->

                  <!--begin::Form-->
                  <form action="/search" data-kt-search-element="form" class="d-none d-lg-block w-100 mb-5 mb-lg-0 position-relative" autocomplete="off">  
                      <!--begin::Hidden input(Added to disable form autocomplete)-->
                      <input type="hidden">
                      <!--end::Hidden input-->

                      <!--begin::Icon-->
                      <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>        <!--end::Icon-->

                      <!--begin::Input-->
                      <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" name="q" value="" placeholder="Search" data-kt-search-element="input">
                      <!--end::Input-->

                      <!--begin::Spinner-->
                      <span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5" data-kt-search-element="spinner">
                          <span class="spinner-border h-15px w-15px align-middle text-gray-500"></span>
                      </span>
                      <!--end::Spinner-->

                      <!--begin::Reset-->
                      <span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4" data-kt-search-element="clear">
                          <i class="ki-duotone ki-cross fs-2 me-0"><span class="path1"></span><span class="path2"></span></i>
                      </span>
                      <!--end::Reset-->
                  </form>
                  <!--end::Form-->

                </div>

                <div class="app-navbar-item ms-1 ms-md-4">
                  <!--begin::Menu- wrapper-->
                  <div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" id="kt_menu_item_wow">
                    <i class="ki-duotone ki-notification-status fs-2">
                      <span class="path1"></span>
                      <span class="path2"></span>
                      <span class="path3"></span>
                      <span class="path4"></span>
                    </i>
                  </div>
                  <!--end::Menu wrapper-->
                </div>


                <!--begin::Theme mode-->
                <div class="app-navbar-item ms-1 ms-md-4">
                  <!--begin::Menu toggle-->
                  <a
                    href="#"
                    class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px"
                    data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                    data-kt-menu-attach="parent"
                    data-kt-menu-placement="bottom-end"
                  >
                    <i class="ki-outline ki-night-day theme-light-show fs-1"></i> <i class="ki-outline ki-moon theme-dark-show fs-1"></i>
                  </a>
                  <!--begin::Menu toggle-->

                  <!--begin::Menu-->
                  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                      <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                        <span class="menu-icon" data-kt-element="icon"> <i class="ki-outline ki-night-day fs-2"></i> </span>
                        <span class="menu-title">
                          Light
                        </span>
                      </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                      <a href="#" class="menu-link px-3 py-2 active" data-kt-element="mode" data-kt-value="dark">
                        <span class="menu-icon" data-kt-element="icon"> <i class="ki-outline ki-moon fs-2"></i> </span>
                        <span class="menu-title">
                          Dark
                        </span>
                      </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-0">
                      <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                        <span class="menu-icon" data-kt-element="icon"> <i class="ki-outline ki-screen fs-2"></i> </span>
                        <span class="menu-title">
                          System
                        </span>
                      </a>
                    </div>
                    <!--end::Menu item-->
                  </div>
                  <!--end::Menu-->
                </div>
                <!--end::Theme mode-->

                <?php
                  function remoteFileExists($url) {
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_NOBODY, true); // Only check the header
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout for safety
                    curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    return $httpCode == 200; // Return true if the HTTP status code is 200 (OK)
                  }

                  $avatarPath = "http://192.168.88.6:8046/storage/avatars/".@session('auth')->id_user.".jpg";
                  $defaultAvatar = '/assets/media/avatars/blank.png';
                  $avatarUrl = remoteFileExists($avatarPath) ? "https://portal.tomman.app/storage/avatars/".session('auth')->id_user.".jpg" : $defaultAvatar;
                ?>
                <!--begin::User menu-->
                <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
                  <!--begin::Menu wrapper-->
                  <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                    <img src="{{$avatarUrl}}" class="rounded-3" alt="user" />
                  </div>

                  <!--begin::User account menu-->
                  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                      <div class="menu-content d-flex align-items-center px-3">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-50px me-5">
                          <img alt="Logo" src="{{$avatarUrl}}" />
                        </div>
                        <!--end::Avatar-->

                        <!--begin::Username-->
                        <div class="d-flex flex-column">
                          <div class="fw-bold d-flex align-items-center fs-5">{{ session('auth')->name ?? 'NAMA' }} </div>

                          <a class="fw-semibold text-muted text-hover-primary fs-7"> {{ session('auth')->username ?? 'NIK' }} </a>
                        </div>
                        <!--end::Username-->
                      </div>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                      <a href="/user/{{ session('auth')->id_user ?? null }}" class="menu-link px-5">
                        Profile
                      </a>
                    </div>
                    <div class="menu-item px-5">
                      <a href="/logout" class="menu-link px-5">
                        Sign Out
                      </a>
                    </div>
                    <!--end::Menu item-->
                  </div>
                  <!--end::User account menu-->

                  <!--end::Menu wrapper-->
                </div>
                <!--end::User menu-->


                <!--begin::Aside toggle-->
                <!--end::Header menu toggle-->
              </div>
              <!--end::Navbar-->
            </div>
            <!--end::Header wrapper-->
          </div>
          <!--end::Header container-->
        </div>

        <!--end::Header-->
        <!--begin::Wrapper-->
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
          <!--begin::Sidebar-->
          <div
            id="kt_app_sidebar"
            class="app-sidebar flex-column"
            data-kt-drawer="true"
            data-kt-drawer-name="app-sidebar"
            data-kt-drawer-activate="{default: true, lg: false}"
            data-kt-drawer-overlay="true"
            data-kt-drawer-width="225px"
            data-kt-drawer-direction="start"
            data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
            <!--begin::Logo-->
            <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
              <!--begin::Logo image-->
              <a href="/">
                <img alt="Logo" src="/assets/images/aicrone-logo.png" class="h-50px app-sidebar-logo-default theme-light-show" />
                <img alt="Logo" src="/assets/images/aicrone-logo.png" class="h-50px app-sidebar-logo-default theme-dark-show" />
                <img alt="Logo" src="/assets/images/aicrone-logo.png" class="h-20px app-sidebar-logo-minimize" />
              </a>
              <!--end::Logo image-->
              <!--begin::Sidebar toggle-->
              <!--begin::Minimized sidebar setup:
            if (isset($_COOKIE["sidebar_minimize_state"]) && $_COOKIE["sidebar_minimize_state"] === "on") { 
                1. "src/js/layout/sidebar.js" adds "sidebar_minimize_state" cookie value to save the sidebar minimize state.
                2. Set data-kt-app-sidebar-minimize="on" attribute for body tag.
                3. Set data-kt-toggle-state="active" attribute to the toggle element with "kt_app_sidebar_toggle" id.
                4. Add "active" class to to sidebar toggle element with "kt_app_sidebar_toggle" id.
            }
        -->
              <div
                id="kt_app_sidebar_toggle"
                class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
                data-kt-toggle="true"
                data-kt-toggle-state="active"
                data-kt-toggle-target="body"
                data-kt-toggle-name="app-sidebar-minimize"
              >
                <i class="ki-duotone ki-eye-slash fs-3 rotate-180">
                  <span class="path1"></span>
                  <span class="path2"></span>
                  <span class="path3"></span>
                  <span class="path4"></span>
                </i>
                <!-- <i class="ki-outline ki-black-left-line fs-3 rotate-180"></i> -->
              </div>
              <!--end::Sidebar toggle-->
            </div>
            <!--end::Logo-->
            <!--begin::sidebar menu-->
            <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
              <!--begin::Menu wrapper-->
              <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
                <!--begin::Scroll wrapper-->
                <div
                  id="kt_app_sidebar_menu_scroll"
                  class="scroll-y my-5 mx-3"
                  data-kt-scroll="true"
                  data-kt-scroll-activate="true"
                  data-kt-scroll-height="auto"
                  data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                  data-kt-scroll-wrappers="#kt_app_sidebar_menu"
                  data-kt-scroll-offset="5px"
                  data-kt-scroll-save-state="true">
                  <!--begin::Menu-->
                  <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                    <div class="menu-item">
                      <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">REPORT</span>
                      </div>
                    </div>
                    <div class="menu-item">
                      <a class="menu-link" href="/dashboard?isp=ALL&tahun={{date('Y')}}&bulan={{date('m')}}">
                        <span class="menu-icon">
                          <i class="ki-duotone ki-chart fs-2">
                            <i class="path1"></i>
                            <i class="path2"></i>
                          </i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                      </a>
                    </div>

                    <div class="menu-item">
                      <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">TRANSACTION</span>
                      </div>
                    </div>
                    <div class="menu-item">
                      <a class="menu-link" href="/form_order/new">
                        <span class="menu-icon">
                          <i class="ki-duotone ki-add-item fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                          </i>
                        </span>
                        <span class="menu-title">Register Order</span>
                      </a>
                    </div>
                    <div class="menu-item">
                      <a class="menu-link" href="/approval_tl">
                        <span class="menu-icon">
                          <i class="ki-duotone ki-security-check fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                          </i>
                        </span>
                        <span class="menu-title">Approval TL</span>
                      </a>
                    </div>
                    <div class="menu-item">
                      <a class="menu-link" href="/approval_spv">
                        <span class="menu-icon">
                          <i class="ki-duotone ki-check-square fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                          </i>
                        </span>
                        <span class="menu-title">Approval SPV</span>
                      </a>
                    </div>
                    <div class="menu-item">
                      <a class="menu-link" href="/order_issued">
                        <span class="menu-icon">
                          <i class="ki-duotone ki-message-text fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                          </i>
                        </span>
                        <span class="menu-title">Order Issued</span>
                      </a>
                    </div>
                    <div class="menu-item">
                      <a class="menu-link" href="/update_status_batch">
                        <span class="menu-icon">
                          <i class="ki-duotone ki-message-text fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                          </i>
                        </span>
                        <span class="menu-title">Update Status Batch</span>
                      </a>
                    </div>

                    <div class="menu-item">
                      <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Master</span>
                      </div>
                    </div>
                    <div class="menu-item">
                      <a class="menu-link" href="/users">
                        <span class="menu-icon">
                          <i class="ki-duotone ki-people fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                          </i>
                        </span>
                        <span class="menu-title">Users</span>
                      </a>
                    </div>
                    <div class="menu-item">
                      <a class="menu-link" href="/odp">
                        <span class="menu-icon">
                          <i class="ki-duotone ki-electricity fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                           <span class="path5"></span>
                           <span class="path6"></span>
                           <span class="path7"></span>
                           <span class="path8"></span>
                           <span class="path9"></span>
                           <span class="path10"></span>
                          </i>
                        </span>
                        <span class="menu-title">ODP</span>
                      </a>
                    </div>
                    <div class="menu-item">
                      <a class="menu-link" href="/homepass">
                        <span class="menu-icon">
                          <i class="ki-duotone ki-home-3 fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                          </i>
                        </span>
                        <span class="menu-title">Homepass</span>
                      </a>
                    </div>
                    <div class="menu-item">
                      <a class="menu-link" href="/setting">
                        <span class="menu-icon">
                          <i class="ki-duotone ki-setting-2 fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                          </i>
                        </span>
                        <span class="menu-title">Setting</span>
                      </a>
                    </div>
                    
                  </div>
                  <!--end::Menu-->
                </div>
                <!--end::Scroll wrapper-->
              </div>
              <!--end::Menu wrapper-->
            </div>
            <!--end::sidebar menu-->
          </div>
          <!--end::Sidebar-->
          <!--begin::Main-->
          <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <!--begin::Content wrapper-->
            <div class="d-flex flex-column flex-column-fluid">
              <!--begin::Content-->
              <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-fluid mt-8">

                    <!--begin::Row-->
                    @yield('content')
                    <!--end::Row-->
                </div>
                <!--end::Content container-->
              </div>
              <!--end::Content-->
            </div>
            <!--end::Content wrapper-->
            <!--begin::Footer-->
            <div id="kt_app_footer" class="app-footer">
              <!--begin::Footer container-->
              <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                <!--begin::Copyright-->
                <div class="text-gray-900 order-2 order-md-1">
                  <span class="text-muted fw-semibold me-1">2024&copy;</span>
                  <a href="/" class="text-gray-800 text-hover-primary"></a>
                </div>
                <!--end::Copyright-->
              </div>
              <!--end::Footer container-->
            </div>
            <!--end::Footer-->
          </div>
          <!--end:::Main-->
        </div>
        <!--end::Wrapper-->
      </div>
      <!--end::Page-->
    </div>
    <!--end::App-->
    <!--begin::Drawers-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
      <i class="ki-outline ki-arrow-up"></i>
    </div>
    <!--end::Scrolltop-->
    <!--begin::Modals-->
    <div class="modal fade" tabindex="-1" id="modal_detil">
      <div class="modal-dialog modal-lg"> <!-- Changed from modal-fullscreen to modal-lg -->
        <div class="modal-content shadow-none">
          <div class="modal-header">
            <h5 id="text_detil" class="modal-title">Modal title</h5>
            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
              <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
            </div>
          </div>
          <div class="modal-body" id="ajax_detil">
          </div>
        </div>
      </div>
    </div>
    @yield('modal')
    <!--end::Modals-->
    <!--begin::Javascript-->
    <script>
      var hostUrl = "/assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <!-- <script src="/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script> -->
    <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="/assets/js/widgets.bundle.js"></script>
    <script src="/assets/js/custom/widgets.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0/dist/chartjs-adapter-moment.min.js"></script>
    <!-- <script src="/assets/js/custom/apps/chat/chat.js"></script>
    <script src="/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="/assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="/assets/js/custom/utilities/modals/users-search.js"></script> -->
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
    <script>
      var file = window.location.pathname;
      $('.menu')
      .find('.menu-item > a[href="' + file + '"]')
      .addClass('active')
      .closest('.menu-sub-accordion')  // Find the closest parent with class 'menu-accordion'
      .addClass('show')
      .closest('.menu-accordion')  // Find the closest parent with class 'menu-accordion'
      .addClass('here show');

      var alertExist = <?= json_encode(Session::has('alerts')); ?>;
      if(alertExist){
        toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": false,
          "progressBar": true,
          "positionClass": "toastr-top-center",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }
        var msg = <?= session('alerts')?json_encode(session('alerts')):'0'; ?>;
        if(msg.type=='success'){
          toastr.success(msg.text);
        }else{
          toastr.error(msg.text);
        }
      }

      var modal = document.getElementById('modal_detil');
      modal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var lop_id = button.getAttribute('data-bs-lop_id');
        var lop_name = button.getAttribute('data-bs-lop_name');
        $.get('/ajax/get_lop_detail/'+lop_id,function(html){
          $('#ajax_detil').html(html);
        });
        $('#text_detil').text("Detail Lop "+lop_name);
      });
    </script>
    @yield('js')

  </body>
  <!--end::Body-->
</html>
