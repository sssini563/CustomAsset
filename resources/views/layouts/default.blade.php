<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
dir="{{ Helper::determineLanguageDirection() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @section('title')
        @show
        :: {{ $snipeSettings->site_name }}
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <meta name="apple-mobile-web-app-capable" content="yes">


    <link rel="apple-touch-icon"
          href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->logo)) :  config('app.url').'/img/snipe-logo-bug.png' }}">
    <link rel="apple-touch-startup-image"
          href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->logo)) :  config('app.url').'/img/snipe-logo-bug.png' }}">
    <link rel="shortcut icon" type="image/ico"
          href="{{ ($snipeSettings) && ($snipeSettings->favicon!='') ?  Storage::disk('public')->url(e($snipeSettings->favicon)) : config('app.url').'/favicon.ico' }}">


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="language" content="{{ Helper::mapBackToLegacyLocale(app()->getLocale()) }}">
    <meta name="language-direction" content="{{ Helper::determineLanguageDirection() }}">
    <meta name="baseUrl" content="{{ config('app.url') }}/">

    <script nonce="{{ csrf_token() }}">
        window.Laravel = {csrfToken: '{{ csrf_token() }}'};
    </script>

    {{-- stylesheets --}}
    <link rel="stylesheet" href="{{ url(mix('css/dist/all.css')) }}">
    {{-- AdminLTE skins: load the correct skin CSS --}}
    @php
        $appSkin = $snipeSettings->skin ?: 'blue';
        $userSkin = null;
        if (($snipeSettings->allow_user_skin=='1') && (isset($user)) && ($user->skin)) {
            $userSkin = $user->skin;
        }
    @endphp
    @if ($userSkin)
        {{-- Prefer minified user-selected skin for performance --}}
        <link rel="stylesheet" href="{{ url(mix('css/dist/skins/skin-' . $userSkin . '.min.css')) }}">
    @else
        {{-- Fallback to the app-selected (non-minified) skin --}}
        <link rel="stylesheet" href="{{ url(mix('css/dist/skins/skin-' . $appSkin . '.css')) }}">
    @endif
    {{-- page level css --}}
    @stack('css')



    {{-- Energizing Colorful UI - Inspired by Modern Learning Apps --}}
    <style nonce="{{ csrf_token() }}">
        /* PERFORMANCE: Disable all transitions for better performance */
        * {
            transition: none !important;
            animation: none !important;
        }
        
        :root { 
            --primary-blue: #4A90E2;
            --primary-blue-dark: #3A7BC8;
            --accent-orange: #FF9800;
            --accent-green: #4CAF50;
            --accent-purple: #9C27B0;
            --text-dark: #2C3E50;
            --text-medium: #5A6C7D;
            --bg-white: #FFFFFF;
            --bg-light: #F7F9FC;
            --border-light: #E1E8ED;
        }
        
        /* FORCE Beautiful Navbar - Soft Gradient with Shadow */
        body .skin-blue .main-header .navbar,
        body .main-header .navbar,
        .skin-blue .main-header .navbar,
        .main-header .navbar {
            background: linear-gradient(to bottom, #FFFFFF 0%, #F5F7FA 100%) !important;
            background-color: #FFFFFF !important;
            background-image: linear-gradient(to bottom, #FFFFFF 0%, #F5F7FA 100%) !important;
            border-bottom: 1px solid #E3E7ED !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05) !important;
            min-height: 50px !important;
            height: 50px !important;
        }
        
        /* FORCE Beautiful Logo - Match Navbar Gradient */
        body .skin-blue .main-header .logo,
        body .main-header .logo,
        .skin-blue .main-header .logo,
        .main-header .logo {
            background: linear-gradient(to bottom, #FFFFFF 0%, #F5F7FA 100%) !important;
            background-color: #FFFFFF !important;
            background-image: linear-gradient(to bottom, #FFFFFF 0%, #F5F7FA 100%) !important;
            color: #4A90E2 !important;
            border-right: 1px solid #E3E7ED !important;
            font-weight: 600 !important;
            min-height: 50px !important;
            height: 50px !important;
        }
        
        body .skin-blue .main-header .logo:hover,
        body .main-header .logo:hover,
        .main-header .logo:hover {
            background: linear-gradient(to bottom, #F8FAFB 0%, #EDF1F5 100%) !important;
            background-color: #F8FAFB !important;
        }
        
        /* FORCE Navbar Links Color */
        body .skin-blue .main-header .navbar .nav > li > a,
        body .main-header .navbar .nav > li > a,
        .main-header .navbar .nav > li > a {
            color: #2C3E50 !important;
        }
        
        body .skin-blue .main-header .navbar .nav > li > a:hover,
        body .main-header .navbar .nav > li > a:hover,
        body .skin-blue .main-header .navbar .nav > li > a:focus,
        body .main-header .navbar .nav > li > a:focus,
        .main-header .navbar .nav > li > a:hover,
        .main-header .navbar .nav > li > a:focus {
            background-color: #ECEFF3 !important;
            color: #4A90E2 !important;
        }
        
        /* FORCE Sidebar Toggle - Soft Gray with Blue Bars */
        body .skin-blue .main-header .navbar .sidebar-toggle,
        body .main-header .navbar .sidebar-toggle,
        .main-header .navbar .sidebar-toggle,
        a.sidebar-toggle {
            background-color: transparent !important;
            background: transparent !important;
            color: #4A90E2 !important;
            border: none !important;
            border-radius: 4px !important;
            padding: 8px 12px !important;
        }
        
        body .skin-blue .main-header .navbar .sidebar-toggle:hover,
        body .main-header .navbar .sidebar-toggle:hover,
        .main-header .navbar .sidebar-toggle:hover {
            background-color: #ECEFF3 !important;
            background: #ECEFF3 !important;
            color: #3A7BC8 !important;
            border-color: #4A90E2 !important;
        }
        
        /* FORCE Hamburger Bars Blue */
        body .sidebar-toggle .icon-bar,
        .sidebar-toggle .icon-bar,
        a.sidebar-toggle .icon-bar {
            background-color: #4A90E2 !important;
            background: #4A90E2 !important;
        }
        
        body .sidebar-toggle:hover .icon-bar,
        .sidebar-toggle:hover .icon-bar {
            background-color: #3A7BC8 !important;
            background: #3A7BC8 !important;
        }
        
        /* FORCE Beautiful White Sidebar - With Elegant Shadow */
        body .skin-blue .main-sidebar,
        body .skin-blue .left-side,
        body .main-sidebar,
        body .left-side,
        .skin-blue .main-sidebar,
        .main-sidebar,
        .left-side {
            background-color: #FFFFFF !important;
            background: #FFFFFF !important;
            border-right: 1px solid #E8EBF0 !important;
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.04) !important;
        }
        
        /* FORCE Sidebar Menu Items - Match Learning App Icons */
        body .skin-blue .sidebar-menu > li > a,
        body .sidebar-menu > li > a,
        .sidebar-menu > li > a {
            color: #5A6C7D !important;
            background-color: transparent !important;
            background: transparent !important;
            border-left: 3px solid transparent !important;
            font-weight: 400 !important;
            padding: 12px 5px 12px 15px !important;
        }
        
        /* FORCE Sidebar Icons - Soft Gray like in Learning App */
        body .skin-blue .sidebar-menu > li > a > .fa,
        body .skin-blue .sidebar-menu > li > a > .fas,
        body .skin-blue .sidebar-menu > li > a > .far,
        body .sidebar-menu > li > a > .fa,
        body .sidebar-menu > li > a > .fas,
        body .sidebar-menu > li > a > .far,
        .sidebar-menu > li > a > .fa,
        .sidebar-menu > li > a > .fas,
        .sidebar-menu > li > a > .far,
        .sidebar-menu > li > a > svg {
            color: #9E9E9E !important;
            font-size: 16px !important;
            width: 20px !important;
            margin-right: 10px !important;
            text-align: center !important;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55) !important;
        }
        
        /* Lightweight sidebar icons - no filters */
        
        /* FORCE Sidebar Hover - Light Blue Background like Learning App */
        body .skin-blue .sidebar-menu > li:hover > a,
        body .sidebar-menu > li:hover > a,
        .sidebar-menu > li:hover > a {
            background-color: #F0F7FF !important;
            background: #F0F7FF !important;
            border-left-color: transparent !important;
            color: #4A90E2 !important;
        }
        
        body .skin-blue .sidebar-menu > li:hover > a > .fa,
        body .skin-blue .sidebar-menu > li:hover > a > .fas,
        body .skin-blue .sidebar-menu > li:hover > a > .far,
        body .sidebar-menu > li:hover > a > .fa,
        body .sidebar-menu > li:hover > a > .fas,
        body .sidebar-menu > li:hover > a > .far,
        .sidebar-menu > li:hover > a > .fa,
        .sidebar-menu > li:hover > a > .fas,
        .sidebar-menu > li:hover > a > .far,
        .sidebar-menu > li:hover > a > svg {
            color: #4A90E2 !important;
        }
        
        /* FORCE Sidebar Active - Blue Background like Learning App "Overview" */
        body .skin-blue .sidebar-menu > li.active > a,
        body .sidebar-menu > li.active > a,
        .sidebar-menu > li.active > a,
        .sidebar-menu li.active > a {
            background-color: #E3F2FD !important;
            background: #E3F2FD !important;
            border-left-color: transparent !important;
            color: #4A90E2 !important;
            font-weight: 500 !important;
        }
        
        body .skin-blue .sidebar-menu > li.active > a > .fa,
        body .skin-blue .sidebar-menu > li.active > a > .fas,
        body .skin-blue .sidebar-menu > li.active > a > .far,
        body .sidebar-menu > li.active > a > .fa,
        body .sidebar-menu > li.active > a > .fas,
        body .sidebar-menu > li.active > a > .far,
        .sidebar-menu > li.active > a > .fa,
        .sidebar-menu > li.active > a > .fas,
        .sidebar-menu > li.active > a > .far,
        .sidebar-menu > li.active > a > svg {
            color: #4A90E2 !important;
        }
        
        /* FORCE Sidebar Submenu */
        body .skin-blue .treeview-menu,
        body .treeview-menu,
        .treeview-menu {
            background-color: #FAFBFC !important;
            background: #FAFBFC !important;
        }
        
        body .skin-blue .treeview-menu > li > a,
        body .treeview-menu > li > a,
        .treeview-menu > li > a {
            color: #7A8A9E !important;
            padding: 8px 5px 8px 15px !important;
            padding-left: 15px !important;
            margin-left: 0 !important;
            font-size: 13px !important;
        }
        
        /* Remove icon width from submenu to make it aligned */
        body .skin-blue .treeview-menu > li > a > .fa,
        body .skin-blue .treeview-menu > li > a > .fas,
        body .treeview-menu > li > a > i,
        body .treeview-menu > li > a > .fa,
        body .treeview-menu > li > a > .fas,
        body .treeview-menu > li > a > i,
        .treeview-menu > li > a > .fa,
        .treeview-menu > li > a > .fas,
        .treeview-menu > li > a > i {
            width: 20px !important;
            margin-right: 10px !important;
            text-align: center !important;
        }
        
        body .skin-blue .treeview-menu > li:hover > a,
        body .treeview-menu > li:hover > a,
        .treeview-menu > li:hover > a {
            color: #4A90E2 !important;
            background-color: #F0F7FF !important;
        }
        
        body .skin-blue .treeview-menu > li.active > a,
        body .treeview-menu > li.active > a,
        .treeview-menu > li.active > a {
            color: #4A90E2 !important;
            background-color: #E3F2FD !important;
            font-weight: 500 !important;
        }
        
        /* FORCE User Panel - Clean Look */
        body .skin-blue .user-panel,
        body .user-panel,
        .user-panel {
            border-bottom: 1px solid #F0F0F0 !important;
            padding: 15px !important;
        }
        
        body .skin-blue .user-panel .info,
        body .user-panel .info,
        .user-panel .info {
            color: #2C3E50 !important;
            font-weight: 500 !important;
        }
        
        /* FORCE Primary Buttons - Blue like Learning App */
        body .btn-primary,
        .btn-primary {
            background-color: #4A90E2 !important;
            background: #4A90E2 !important;
            background-image: none !important;
            border: none !important;
            color: white !important;
            font-weight: 500 !important;
            box-shadow: 0 2px 4px rgba(74, 144, 226, 0.3) !important;
            border-radius: 6px !important;
        }
        
        body .btn-primary:hover,
        .btn-primary:hover {
            background-color: #3A7BC8 !important;
            background: #3A7BC8 !important;
            box-shadow: 0 4px 8px rgba(74, 144, 226, 0.4) !important;
            transform: translateY(-1px);
        }
        
        /* Search box in navbar - Clean white style */
        body .navbar-form .form-control,
        .navbar-form .form-control {
            background-color: #F5F6F8 !important;
            border: 1px solid #E1E8ED !important;
            color: #2C3E50 !important;
            border-radius: 20px !important;
            padding: 6px 15px !important;
        }
        
        body .navbar-form .form-control::placeholder,
        .navbar-form .form-control::placeholder {
            color: #9E9E9E !important;
        }
        
        body .navbar-form .form-control:focus,
        .navbar-form .form-control:focus {
            background-color: #FFFFFF !important;
            border-color: #4A90E2 !important;
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.1) !important;
        }
        
        /* Dropdown menus - Clean modern style */
        body .dropdown-menu,
        .dropdown-menu {
            border: 1px solid #E1E8ED !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
            border-radius: 8px !important;
        }
        
        /* Content wrapper - Beautiful Soft Background */
        body .skin-blue .content-wrapper,
        body .content-wrapper,
        .content-wrapper {
            background: linear-gradient(135deg, #F0F4F8 0%, #F8FAFC 50%, #F5F7FA 100%) !important;
            background-color: #F5F7FA !important;
            min-height: calc(100vh - 50px - 40px) !important; /* viewport - header - footer */
            padding-bottom: 10px !important;
        }
        
        /* Main content padding */
        .content {
            padding-top: 10px !important;
        }
        
        .content-header {
            padding: 5px 15px 3px !important;
            margin-bottom: 5px !important;
        }
        
        .content-header h1 {
            font-size: 22px !important;
            margin: 0 !important;
            line-height: 1.2 !important;
        }
        
        /* Info boxes - Modern rounded cards */
        body .info-box,
        .info-box {
            box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
            border-radius: 12px !important;
            border: none !important;
        }
        
        body .info-box-icon,
        .info-box-icon {
            border-radius: 12px 0 0 12px !important;
        }
        
        /* Dashboard Small Boxes - Clear Borders with Hover Animation */
        .dashboard.small-box {
            border-radius: 16px !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15) !important;
            overflow: hidden !important;
            position: relative !important;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55) !important;
        }
        
        .dashboard.small-box:hover {
            transform: translateY(-5px) scale(1.02) !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25) !important;
        }
        
        .dashboard.small-box .icon {
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55) !important;
        }
        
        .dashboard.small-box:hover .icon {
            transform: translateY(-50%) rotate(15deg) scale(1.1) !important;
        }
        
        .dashboard.small-box .inner {
            position: relative !important;
            z-index: 2 !important;
            padding: 20px !important;
        }
        
        .dashboard.small-box .inner h3 {
            font-size: 42px !important;
            font-weight: 700 !important;
            margin: 0 0 10px 0 !important;
            text-decoration: none !important;
            border-bottom: none !important;
        }
        
        .dashboard.small-box .inner p {
            font-size: 15px !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            border-bottom: none !important;
        }
        
        .dashboard.small-box .icon {
            position: absolute !important;
            right: 20px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            font-size: 90px !important;
            opacity: 0.25 !important;
            z-index: 1 !important;
        }
        
        /* Lightweight icon styling - no heavy filters */
        
        /* Lightweight SVG icons */
        .dashboard.small-box .icon svg path,
        .dashboard.small-box .icon svg circle,
        .dashboard.small-box .icon svg rect {
            fill: rgba(255, 255, 255, 0.9) !important;
        }
        
        .dashboard.small-box .small-box-footer {
            background-color: rgba(0,0,0,0.1) !important;
            color: white !important;
            padding: 10px 0 !important;
            text-align: center !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            border-bottom: none !important;
        }
        
        .dashboard.small-box .small-box-footer:hover {
            text-decoration: none !important;
            border-bottom: none !important;
        }
        
        .dashboard.small-box .small-box-footer svg,
        .dashboard.small-box .small-box-footer i {
            margin-left: 5px !important;
            display: inline-block !important;
        }
        
        .dashboard.small-box .small-box-footer a,
        .dashboard.small-box .small-box-footer a:hover,
        .dashboard.small-box .small-box-footer a:focus {
            text-decoration: none !important;
            border-bottom: none !important;
            color: white !important;
        }
        
        .dashboard.small-box:hover .small-box-footer {
            background-color: rgba(0,0,0,0.2) !important;
            text-decoration: none !important;
        }
        
        /* Dashboard Compact Layout - Fit in One Page with Aligned Heights */
        body .skin-blue .dashboard.small-box {
            margin-bottom: 6px !important;
            min-height: 95px !important;
            height: 95px !important;
        }
        
        body .skin-blue .dashboard.small-box .inner {
            padding: 10px 12px !important;
        }
        
        body .skin-blue .dashboard.small-box .inner h3 {
            font-size: 28px !important;
            margin: 0 0 3px 0 !important;
            line-height: 1 !important;
        }
        
        body .skin-blue .dashboard.small-box .inner p {
            font-size: 12px !important;
            margin: 0 !important;
        }
        
        body .skin-blue .dashboard.small-box .icon {
            font-size: 50px !important;
            right: 10px !important;
        }
        
        body .skin-blue .dashboard.small-box .small-box-footer {
            padding: 5px 0 !important;
            font-size: 11px !important;
        }
        
        body .skin-blue .box {
            margin-bottom: 10px !important;
            margin-top: 5px !important;
        }
        
        body .skin-blue .box-header {
            padding: 8px 15px !important;
        }
        
        body .skin-blue .box-header .box-title {
            font-size: 15px !important;
        }
        
        body .skin-blue .box-body {
            padding: 10px !important;
        }
        
        body .skin-blue .table {
            margin-bottom: 0 !important;
            font-size: 12px !important;
        }
        
        body .skin-blue .table thead th {
            padding: 6px 4px !important;
            font-size: 11px !important;
        }
        
        body .skin-blue .table tbody td {
            padding: 5px 4px !important;
            font-size: 12px !important;
        }
        
        body .skin-blue .btn-sm {
            padding: 5px 10px !important;
            font-size: 12px !important;
        }
        
        /* Compact table containers */
        body .skin-blue #dashLocationSummary,
        body .skin-blue #dashCategorySummary {
            font-size: 11px !important;
        }
        
        /* ULTRA COMPACT Dashboard Tables - Override All Styles */
        #dashCategorySummary .fixed-table-toolbar,
        #dashActivityReport .fixed-table-toolbar,
        #dashLocationSummary .fixed-table-toolbar {
            padding: 2px 4px !important;
            min-height: 24px !important;
            margin-bottom: 2px !important;
        }

        #dashCategorySummary .search input,
        #dashActivityReport .search input,
        #dashLocationSummary .search input {
            height: 20px !important;
            font-size: 10px !important;
            padding: 2px 6px !important;
            width: 120px !important;
            border-radius: 4px !important;
        }

        #dashCategorySummary .fixed-table-toolbar .btn-group button,
        #dashActivityReport .fixed-table-toolbar .btn-group button,
        #dashLocationSummary .fixed-table-toolbar .btn-group button {
            padding: 2px 5px !important;
            font-size: 10px !important;
            height: 20px !important;
            line-height: 1 !important;
            min-width: 20px !important;
            background-color: #f5f5f5 !important;
            border-color: #ddd !important;
            color: #333 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-decoration: none !important;
            vertical-align: middle !important;
        }
        
        /* Keep dashboard table search input compact */
        #dashCategorySummary .search input,
        #dashActivityReport .search input,
        #dashLocationSummary .search input {
            height: 20px !important;
        }
        
        #dashCategorySummary .fixed-table-toolbar .btn-group button:hover,
        #dashActivityReport .fixed-table-toolbar .btn-group button:hover,
        #dashLocationSummary .fixed-table-toolbar .btn-group button:hover {
            background-color: #e8e8e8 !important;
            border-color: #bbb !important;
            text-decoration: none !important;
        }

        #dashCategorySummary .fixed-table-toolbar .btn-group button i,
        #dashActivityReport .fixed-table-toolbar .btn-group button i,
        #dashLocationSummary .fixed-table-toolbar .btn-group button i,
        #dashCategorySummary .fixed-table-toolbar .btn-group button svg,
        #dashActivityReport .fixed-table-toolbar .btn-group button svg,
        #dashLocationSummary .fixed-table-toolbar .btn-group button svg {
            font-size: 10px !important;
            line-height: 1 !important;
            display: inline-block !important;
            vertical-align: middle !important;
            margin: 0 auto !important;
            padding: 0 !important;
        }
        
        /* Force perfect center for dashboard table icons */
        #dashCategorySummary .fixed-table-toolbar button > *,
        #dashActivityReport .fixed-table-toolbar button > *,
        #dashLocationSummary .fixed-table-toolbar button > * {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }
        
        /* Make dropdown buttons smaller too */
        #dashCategorySummary .fixed-table-toolbar .dropdown-toggle,
        #dashActivityReport .fixed-table-toolbar .dropdown-toggle,
        #dashLocationSummary .fixed-table-toolbar .dropdown-toggle {
            padding: 2px 5px !important;
            height: 20px !important;
            font-size: 10px !important;
        }
        
        #dashCategorySummary .fixed-table-toolbar .btn-group,
        #dashActivityReport .fixed-table-toolbar .btn-group,
        #dashLocationSummary .fixed-table-toolbar .btn-group {
            margin-left: 1px !important;
            margin-right: 1px !important;
        }

        #dashCategorySummary tbody td,
        #dashActivityReport tbody td,
        #dashLocationSummary tbody td {
            padding: 4px 6px !important;
            font-size: 11px !important;
            line-height: 1.4 !important;
        }

        #dashCategorySummary thead th,
        #dashActivityReport thead th,
        #dashLocationSummary thead th {
            padding: 4px 6px !important;
            font-size: 11px !important;
            line-height: 1.4 !important;
            font-weight: 600 !important;
        }

        #dashCategorySummary .fixed-table-container,
        #dashActivityReport .fixed-table-container,
        #dashLocationSummary .fixed-table-container {
            border: none !important;
            padding: 0 !important;
        }

        #dashCategorySummary .fixed-table-toolbar .columns,
        #dashActivityReport .fixed-table-toolbar .columns,
        #dashLocationSummary .fixed-table-toolbar .columns {
            margin-right: 2px !important;
        }

        #dashCategorySummary .fixed-table-toolbar .pull-right,
        #dashActivityReport .fixed-table-toolbar .pull-right,
        #dashLocationSummary .fixed-table-toolbar .pull-right {
            margin-left: 2px !important;
        }

        #dashCategorySummary .fixed-table-toolbar .pull-left,
        #dashActivityReport .fixed-table-toolbar .pull-left,
        #dashLocationSummary .fixed-table-toolbar .pull-left {
            margin-right: 2px !important;
        }

        #dashCategorySummary .search,
        #dashActivityReport .search,
        #dashLocationSummary .search {
            margin-bottom: 0 !important;
            margin-top: 0 !important;
        }

        #dashCategorySummary .fixed-table-body,
        #dashActivityReport .fixed-table-body,
        #dashLocationSummary .fixed-table-body {
            padding: 0 !important;
        }
        
        /* Override box headers for dashboard tables */
        .content-wrapper .box-header.with-border {
            padding: 5px 10px !important;
        }
        
        .content-wrapper .box-header .box-title {
            font-size: 14px !important;
            margin: 0 !important;
            line-height: 1.4 !important;
            font-weight: 600 !important;
        }
        
        .content-wrapper .box-body {
            padding: 3px !important;
        }
        
        /* Align Heights: Make chart and categories boxes match - BOTH 300px */
        /* Chart box (col-lg-3) - same height as categories */
        body.skin-blue .content-wrapper > .row:first-child .col-lg-3 > .box,
        body.skin-blue .content-wrapper > .row:first-child .col-lg-3 > .box.box-default,
        body .wrapper .content-wrapper > .row:first-child .col-lg-3 > .box {
            height: 250px !important;
            min-height: 250px !important;
            max-height: 250px !important;
        }
        
        body.skin-blue .content-wrapper > .row:first-child .col-lg-3 > .box .box-body,
        body .wrapper .content-wrapper > .row:first-child .col-lg-3 > .box .box-body {
            height: calc(100% - 48px) !important;
            min-height: 202px !important;
            max-height: 202px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 20px !important;
            overflow: hidden !important;
            background: #FFFFFF !important;
            position: relative !important;
        }
        
        /* Removed chart glow effect */
        
        body.skin-blue .content-wrapper > .row:first-child .col-lg-3 .chart-responsive,
        body .wrapper .content-wrapper > .row:first-child .col-lg-3 .chart-responsive {
            width: 100% !important;
            height: 100% !important;
            max-height: 200px !important;
            position: relative !important;
            z-index: 1 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        body.skin-blue .content-wrapper > .row:first-child .col-lg-3 .chart-responsive canvas,
        body .wrapper .content-wrapper > .row:first-child .col-lg-3 .chart-responsive canvas {
            max-height: 180px !important;
            max-width: 180px !important;
        }
        
        /* Categories table box (col-lg-5) - match height */
        body.skin-blue .content-wrapper > .row:first-child .col-lg-5:last-of-type > .box,
        body.skin-blue .content-wrapper > .row:first-child .col-lg-5:last-of-type > .box.box-default,
        body .wrapper .content-wrapper > .row:first-child .col-lg-5:last-of-type > .box {
            height: 350px !important;
            min-height: 350px !important;
            max-height: 350px !important;
        }
        
        body.skin-blue .content-wrapper > .row:first-child .col-lg-5:last-of-type > .box .box-body,
        body .wrapper .content-wrapper > .row:first-child .col-lg-5:last-of-type > .box .box-body {
            height: calc(100% - 42px) !important;
            min-height: 308px !important;
            max-height: 308px !important;
            overflow-y: auto !important;
            padding: 8px 10px !important;
        }
        
        body.skin-blue .content-wrapper > .row:first-child .col-lg-5:last-of-type .table-responsive,
        body .wrapper .content-wrapper > .row:first-child .col-lg-5:last-of-type .table-responsive {
            max-height: 300px !important;
            overflow-y: auto !important;
        }
        
        /* Make Locations & Categories tables taller */
        body .content-wrapper .col-lg-8 .row:last-child .box {
            min-height: 400px !important;
        }
        
        body .content-wrapper .col-lg-8 .row:last-child .box .box-body {
            min-height: 350px !important;
        }
        
        /* Recent Activity table ultra compact */
        body .skin-blue #dashActivityReport {
            font-size: 11px !important;
        }
        
        body .skin-blue #dashActivityReport thead th {
            padding: 5px 3px !important;
            font-size: 10px !important;
        }
        
        body .skin-blue #dashActivityReport tbody td {
            padding: 4px 3px !important;
        }
        
        /* Colorful Gradients for Each Box - Match Learning App */
        .dashboard.small-box.bg-teal {
            background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%) !important;
            color: white !important;
            position: relative !important;
        }
        
        .dashboard.small-box.bg-teal::after {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            right: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 50%) !important;
            pointer-events: none !important;
        }
        
        .dashboard.small-box.bg-maroon {
            background: linear-gradient(135deg, #FF6B9D 0%, #F06292 100%) !important;
            color: white !important;
            position: relative !important;
        }
        
        .dashboard.small-box.bg-maroon::after {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            right: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 50%) !important;
            pointer-events: none !important;
        }
        
        .dashboard.small-box.bg-orange {
            background: linear-gradient(135deg, #FFB74D 0%, #FFA726 100%) !important;
            color: white !important;
            position: relative !important;
        }
        
        .dashboard.small-box.bg-orange::after {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            right: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 50%) !important;
            pointer-events: none !important;
        }
        
        .dashboard.small-box.bg-purple {
            background: linear-gradient(135deg, #BA68C8 0%, #AB47BC 100%) !important;
            color: white !important;
            position: relative !important;
        }
        
        .dashboard.small-box.bg-purple::after {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            right: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 50%) !important;
            pointer-events: none !important;
        }
        
        .dashboard.small-box.bg-yellow {
            background: linear-gradient(135deg, #FFD54F 0%, #FFCA28 100%) !important;
            color: white !important;
            position: relative !important;
        }
        
        .dashboard.small-box.bg-yellow::after {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            right: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 50%) !important;
            pointer-events: none !important;
        }
        
        .dashboard.small-box.bg-blue {
            background: linear-gradient(135deg, #64B5F6 0%, #42A5F5 100%) !important;
            color: white !important;
            position: relative !important;
        }
        
        .dashboard.small-box.bg-blue::after {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            right: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 50%) !important;
            pointer-events: none !important;
        }
        
        .dashboard.small-box.bg-green {
            background: linear-gradient(135deg, #81C784 0%, #66BB6A 100%) !important;
            color: white !important;
            position: relative !important;
        }
        
        .dashboard.small-box.bg-green::after {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            right: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 50%) !important;
            pointer-events: none !important;
        }
        
        .dashboard.small-box.bg-red {
            background: linear-gradient(135deg, #E57373 0%, #EF5350 100%) !important;
            color: white !important;
            position: relative !important;
        }
        
        .dashboard.small-box.bg-red::after {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            right: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 50%) !important;
            pointer-events: none !important;
        }
        
        .dashboard.small-box.bg-light-blue {
            background: linear-gradient(135deg, #64B5F6 0%, #42A5F5 100%) !important;
            color: white !important;
            position: relative !important;
        }
        
        .dashboard.small-box.bg-light-blue::after {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            right: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 50%) !important;
            pointer-events: none !important;
        }
        
        /* Lightweight hover effect */
        .dashboard.small-box:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        }
        
        /* Modern Box Styling for Dashboard - Clear Borders with Hover Animation */
        .box {
            border-radius: 8px !important;
            border: 1px solid #E8E8E8 !important;
            background: #FFFFFF !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08) !important;
            margin-bottom: 20px !important;
            overflow: hidden !important;
            position: relative !important;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55) !important;
        }
        
        .box:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
            border-color: #4FC3F7 !important;
            transform: translateY(-3px) !important;
        }
        
        .box-header {
            border-radius: 8px 8px 0 0 !important;
            background: white !important;
            padding: 12px 15px !important;
            border-bottom: 1px solid #F0F0F0 !important;
            position: relative !important;
            box-shadow: none !important;
        }
        
        /* Removed box-header::before */
        
        .box-header .box-title {
            font-size: 15px !important;
            font-weight: 700 !important;
            color: #2C3E50 !important;
            margin: 0 !important;
            line-height: 1.4 !important;
            position: relative !important;
            display: inline-block !important;
            text-shadow: none !important;
            letter-spacing: 0.3px !important;
        }
        
        .box-header .box-title::before {
            content: '●' !important;
            margin-right: 8px !important;
            font-size: 10px !important;
            opacity: 0.7 !important;
            color: #2196F3 !important;
        }
        
        .box-body {
            padding: 15px !important;
            background: #FFFFFF !important;
            position: relative !important;
        }
        
        .box-body::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            height: 0px !important;
            background: transparent !important;
            display: none !important;
        }
        
        /* Removed gradient animation */
        
        /* Table Styling - Clean White No Borders */
        .table-responsive {
            border-radius: 8px !important;
            overflow: hidden !important;
            background: white !important;
            padding: 0 15px !important;
            border: none !important;
            box-shadow: none !important;
        }
        
        .table-responsive > div {
            background: white !important;
            border-radius: 8px !important;
        }
        
        .snipe-table {
            border-radius: 8px !important;
            background: white !important;
        }
        
        .snipe-table thead {
            background: white !important;
            border-bottom: none !important;
        }
        
        .snipe-table thead th {
            color: #333 !important;
            font-weight: 600 !important;
            text-shadow: none !important;
            border-bottom: none !important;
            background: white !important;
            border-top: none !important;
        }
        
        .snipe-table tbody tr {
            background: white !important;
        }
        
        .snipe-table tbody tr:nth-child(even) {
            background: #fafafa !important;
        }
        
        .snipe-table tbody td {
            border-bottom: none !important;
        }
        
        .snipe-table tbody tr:hover {
            background: #f5f5f5 !important;
        }
        
        /* Fixed Table Container - No Borders */
        .fixed-table-container {
            border-radius: 8px !important;
            overflow: hidden !important;
            box-shadow: none !important;
            border: none !important;
            background: white !important;
            padding: 0 15px !important;
        }
        
        .fixed-table-toolbar {
            background: white !important;
            border-bottom: none !important;
            padding: 10px 0 !important;
            border-top: none !important;
        }
        
        /* Fix ALL toolbar buttons - Light Blue Solid */
        .fixed-table-toolbar .btn-group > button,
        .fixed-table-toolbar .btn-group > .btn,
        .fixed-table-toolbar button.btn,
        .fixed-table-toolbar .btn {
            background: #4FC3F7 !important;
            border: none !important;
            color: white !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        .fixed-table-toolbar .btn-group > button:hover,
        .fixed-table-toolbar .btn-group > .btn:hover,
        .fixed-table-toolbar button.btn:hover,
        .fixed-table-toolbar .btn:hover {
            background: #29B6F6 !important;
            border: none !important;
            color: white !important;
            text-decoration: none !important;
        }
        
        .fixed-table-toolbar .btn-group > button:active,
        .fixed-table-toolbar .btn-group > .btn:active,
        .fixed-table-toolbar button.btn:active,
        .fixed-table-toolbar .btn:active,
        .fixed-table-toolbar .btn-group > button.active,
        .fixed-table-toolbar .btn-group > .btn.active {
            background: #1E88E5 !important;
            border: none !important;
        }
        
        /* Center icons in toolbar buttons - PERFECT CENTER */
        .fixed-table-toolbar .btn i,
        .fixed-table-toolbar .btn-group button i,
        .fixed-table-toolbar .btn-group .btn i,
        .fixed-table-toolbar button i,
        .fixed-table-toolbar .btn svg,
        .fixed-table-toolbar .btn-group button svg,
        .fixed-table-toolbar .btn-group .btn svg,
        .fixed-table-toolbar button svg {
            display: inline-block !important;
            vertical-align: middle !important;
            line-height: 1 !important;
            margin: 0 auto !important;
            padding: 0 !important;
        }
        
        /* Force button flexbox for perfect centering */
        .fixed-table-toolbar .btn,
        .fixed-table-toolbar .btn-group button,
        .fixed-table-toolbar .btn-group .btn,
        .fixed-table-toolbar button {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            line-height: 1 !important;
            padding: 6px 12px !important;
        }
        
        /* Remove any extra margins */
        .fixed-table-toolbar .btn > *,
        .fixed-table-toolbar button > * {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }
        
        /* Remove underline from all toolbar elements */
        .fixed-table-toolbar a,
        .fixed-table-toolbar button,
        .fixed-table-toolbar .btn,
        .fixed-table-toolbar a:hover,
        .fixed-table-toolbar button:hover,
        .fixed-table-toolbar .btn:hover,
        .fixed-table-toolbar a:focus,
        .fixed-table-toolbar button:focus,
        .fixed-table-toolbar .btn:focus {
            text-decoration: none !important;
            border-bottom: none !important;
        }
        
        /* Icon Styling - Modern and Elegant */
        .box-header .box-title i,
        .box-header .box-title svg {
            margin-right: 8px !important;
            filter: none !important;
            color: #2196F3 !important;
        }
        
        /* No animations for box icons */
        
        /* Lightweight chart - no animations */
        
        /* Chart container - clean and simple */
        .chart-responsive {
            position: relative !important;
        }
        
        /* Remove any remaining old hover styles */
        .sidebar-toggle:hover {
            background-color: #F7F9FC !important;
        }
        
        /* Modern Button Styles for Dashboard Actions */
        .btn-warning-modern,
        .btn-info-modern {
            transition: all 0.3s ease !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;
        }
        
        .btn-warning-modern:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(255, 183, 77, 0.4) !important;
        }
        
        .btn-info-modern:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(100, 181, 246, 0.4) !important;
        }
        
        /* Override AdminLTE Default Colors with Modern Theme */
        /* Links - Modern Blue */
        a {
            color: #42A5F5 !important;
        }
        
        a:hover,
        a:focus,
        a:active {
            color: #64B5F6 !important;
        }
        
        /* Modern Form Styling - Beautiful & Clean */
        .form-control {
            border: 2px solid #E3F2FD !important;
            border-radius: 8px !important;
            padding: 10px 15px !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
            background: #FFFFFF !important;
        }
        
        .form-control:hover {
            border-color: #BBDEFB !important;
        }
        
        .form-control:focus {
            border-color: #2196F3 !important;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1) !important;
            background: #FAFFFE !important;
        }
        
        /* Form Group Styling */
        .form-group {
            margin-bottom: 20px !important;
        }
        
        .form-group label {
            font-weight: 600 !important;
            color: #37474F !important;
            margin-bottom: 8px !important;
            font-size: 14px !important;
        }
        
        .form-group label .required {
            color: #FF5252 !important;
        }
        
        /* Input Group Styling */
        .input-group-addon {
            background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%) !important;
            border: 2px solid #BBDEFB !important;
            border-radius: 8px 0 0 8px !important;
            color: #1976D2 !important;
            font-weight: 600 !important;
        }
        
        .input-group .form-control:first-child {
            border-radius: 8px 0 0 8px !important;
        }
        
        .input-group .form-control:last-child {
            border-radius: 0 8px 8px 0 !important;
        }
        
        /* Select Styling */
        select.form-control {
            appearance: none !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%232196F3' d='M6 9L1 4h10z'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 15px center !important;
            padding-right: 40px !important;
        }
        
        /* Textarea Styling */
        textarea.form-control {
            resize: vertical !important;
            min-height: 100px !important;
        }
        
        /* Success - Modern Green */
        .form-group.has-success label,
        .form-group.has-success .help-block {
            color: #4CAF50 !important;
        }
        
        .form-group.has-success .form-control,
        .form-group.has-success .input-group-addon {
            border-color: #4CAF50 !important;
            background: #F1F8F4 !important;
        }
        
        .form-group.has-success .form-control:focus {
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1) !important;
        }
        
        /* Warning - Modern Orange */
        .form-group.has-warning label,
        .form-group.has-warning .help-block {
            color: #FF9800 !important;
        }
        
        .form-group.has-warning .form-control,
        .form-group.has-warning .input-group-addon {
            border-color: #FF9800 !important;
            background: #FFF8F0 !important;
        }
        
        .form-group.has-warning .form-control:focus {
            box-shadow: 0 0 0 3px rgba(255, 152, 0, 0.1) !important;
        }
        
        /* Error - Modern Red */
        .form-group.has-error label,
        .form-group.has-error .help-block,
        .error label,
        .alert-msg {
            color: #FF5252 !important;
        }
        
        .form-group.has-error .form-control,
        .form-group.has-error .input-group-addon,
        .error input {
            border-color: #FF5252 !important;
            background: #FFF5F5 !important;
        }
        
        .form-group.has-error .form-control:focus {
            box-shadow: 0 0 0 3px rgba(255, 82, 82, 0.1) !important;
        }
        
        /* Modern Button Styling */
        .btn {
            border-radius: 8px !important;
            padding: 10px 20px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
            border: none !important;
        }
        
        .btn i,
        .btn svg {
            margin-right: 6px !important;
        }
        
        .btn-primary {
            background: #4FC3F7 !important;
            box-shadow: 0 2px 8px rgba(79, 195, 247, 0.3) !important;
        }
        
        .btn-primary:hover {
            background: #29B6F6 !important;
            box-shadow: 0 4px 12px rgba(41, 182, 246, 0.4) !important;
            transform: translateY(-1px) !important;
        }
        
        .btn-success {
            background: #4FC3F7 !important;
            box-shadow: 0 2px 8px rgba(79, 195, 247, 0.3) !important;
        }
        
        .btn-success:hover {
            background: #29B6F6 !important;
            box-shadow: 0 4px 12px rgba(41, 182, 246, 0.4) !important;
            transform: translateY(-1px) !important;
        }
        
        .btn-danger {
            background: #4FC3F7 !important;
            box-shadow: 0 2px 8px rgba(79, 195, 247, 0.3) !important;
        }
        
        .btn-danger:hover {
            background: #29B6F6 !important;
            box-shadow: 0 4px 12px rgba(41, 182, 246, 0.4) !important;
            transform: translateY(-1px) !important;
        }
        
        .btn-warning {
            background: #4FC3F7 !important;
            box-shadow: 0 2px 8px rgba(79, 195, 247, 0.3) !important;
            color: white !important;
        }
        
        .btn-warning:hover {
            background: #29B6F6 !important;
            box-shadow: 0 4px 12px rgba(41, 182, 246, 0.4) !important;
            transform: translateY(-1px) !important;
        }
        
        .btn-default {
            background: #FFFFFF !important;
            border: 2px solid #E3F2FD !important;
            color: #2196F3 !important;
        }
        
        .btn-default:hover {
            background: #E3F2FD !important;
            border-color: #2196F3 !important;
            transform: translateY(-1px) !important;
        }
        
        /* Fixed Table Toolbar Buttons - Solid Light Blue */
        .fixed-table-toolbar .btn,
        .fixed-table-toolbar .btn-group .btn,
        .fixed-table-toolbar button {
            background: #4FC3F7 !important;
            border: none !important;
            color: white !important;
            border-radius: 6px !important;
            padding: 6px 12px !important;
            font-weight: 600 !important;
            box-shadow: 0 2px 6px rgba(79, 195, 247, 0.3) !important;
        }
        
        .fixed-table-toolbar .btn:hover,
        .fixed-table-toolbar .btn-group .btn:hover,
        .fixed-table-toolbar button:hover {
            background: #29B6F6 !important;
            box-shadow: 0 3px 10px rgba(41, 182, 246, 0.4) !important;
            transform: translateY(-1px) !important;
        }
        
        .fixed-table-toolbar .btn i,
        .fixed-table-toolbar .btn svg,
        .fixed-table-toolbar .btn-group .btn i,
        .fixed-table-toolbar .btn-group .btn svg,
        .fixed-table-toolbar button i,
        .fixed-table-toolbar button svg {
            color: white !important;
            fill: white !important;
        }
        
        /* Ensure all icons in buttons are white */
        .btn-primary i,
        .btn-primary svg,
        .btn-primary .fa,
        .btn-primary .fas,
        .btn-success i,
        .btn-success svg,
        .btn-success .fa,
        .btn-success .fas {
            color: white !important;
        }
        
        .btn-primary svg path,
        .btn-success svg path,
        .btn-danger svg path,
        .btn-warning svg path,
        .fixed-table-toolbar .btn svg path,
        .fixed-table-toolbar button svg path {
            fill: white !important;
        }
        
        /* Progress Bars - Modern Colors */
        .progress-bar-primary,
        .progress-bar-light-blue {
            background-color: #42A5F5 !important;
        }
        
        .progress-bar-success,
        .progress-bar-green {
            background-color: #66BB6A !important;
        }
        
        .progress-bar-warning,
        .progress-bar-yellow {
            background-color: #FFA726 !important;
        }
        
        .progress-bar-danger,
        .progress-bar-red {
            background-color: #EF5350 !important;
        }
        
        /* Box Border Colors - Modern Theme */
        .box.box-primary {
            border-top-color: #42A5F5 !important;
        }
        
        .box.box-info {
            border-top-color: #29B6F6 !important;
        }
        
        .box.box-success {
            border-top-color: #66BB6A !important;
        }
        
        .box.box-warning {
            border-top-color: #FFA726 !important;
        }
        
        .box.box-danger {
            border-top-color: #EF5350 !important;
        }
        
        /* Solid Box Headers - Modern Gradients */
        .box.box-solid.box-primary {
            border: 1px solid #42A5F5 !important;
        }
        
        .box.box-solid.box-primary > .box-header {
            background: linear-gradient(135deg, #64B5F6 0%, #42A5F5 100%) !important;
        }
        
        .box.box-solid.box-info {
            border: 1px solid #29B6F6 !important;
        }
        
        .box.box-solid.box-info > .box-header {
            background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%) !important;
        }
        
        .box.box-solid.box-success {
            border: 1px solid #66BB6A !important;
        }
        
        .box.box-solid.box-success > .box-header {
            background: linear-gradient(135deg, #81C784 0%, #66BB6A 100%) !important;
        }
        
        .box.box-solid.box-warning {
            border: 1px solid #FFA726 !important;
        }
        
        .box.box-solid.box-warning > .box-header {
            background: linear-gradient(135deg, #FFB74D 0%, #FFA726 100%) !important;
        }
        
        .box.box-solid.box-danger {
            border: 1px solid #EF5350 !important;
        }
        
        .box.box-solid.box-danger > .box-header {
            background: linear-gradient(135deg, #E57373 0%, #EF5350 100%) !important;
        }
        
        /* ================================================
           GLOBAL BOOTSTRAP-TABLE STYLING
           ================================================ */
        
        /* Fix ALL Bootstrap-Table Toolbar Buttons - Make them rounded and consistent */
        .fixed-table-toolbar .btn,
        .fixed-table-toolbar .btn-group button,
        .fixed-table-toolbar .btn-default,
        .fixed-table-toolbar button {
            border-radius: 6px !important;
            padding: 6px 12px !important;
            font-size: 13px !important;
            height: auto !important;
            line-height: 1.42857143 !important;
            border: 1px solid #ddd !important;
            background-color: #fff !important;
            color: #333 !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
        }
        
        .fixed-table-toolbar .btn:hover,
        .fixed-table-toolbar .btn-group button:hover,
        .fixed-table-toolbar button:hover {
            background-color: #f5f5f5 !important;
            border-color: #bbb !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15) !important;
            transform: translateY(-1px) !important;
        }
        
        /* Primary buttons in toolbar - Solid Light Blue */
        .fixed-table-toolbar .btn-primary,
        .fixed-table-toolbar button.btn-primary {
            background: #4FC3F7 !important;
            border: none !important;
            color: white !important;
        }
        
        .fixed-table-toolbar .btn-primary:hover,
        .fixed-table-toolbar button.btn-primary:hover {
            background: #29B6F6 !important;
            border: none !important;
        }
        
        /* Action Buttons - Modern Colors Matching Theme */
        /* Info/View Button - Solid Light Blue */
        .btn-info,
        a.btn-info,
        button.btn-info,
        .table .btn-info {
            background: #4FC3F7 !important;
            border: none !important;
            color: white !important;
            border-radius: 6px !important;
            box-shadow: 0 2px 5px rgba(79, 195, 247, 0.3) !important;
            transition: all 0.3s ease !important;
        }
        
        .btn-info:hover,
        a.btn-info:hover,
        button.btn-info:hover,
        .table .btn-info:hover {
            background: #29B6F6 !important;
            border: none !important;
            box-shadow: 0 4px 8px rgba(41, 182, 246, 0.4) !important;
            transform: translateY(-1px) !important;
        }
        
        /* Primary/Edit Button - Solid Light Blue */
        .btn-primary,
        a.btn-primary,
        button.btn-primary,
        .table .btn-primary {
            background: #4FC3F7 !important;
            border: none !important;
            color: white !important;
            border-radius: 6px !important;
            box-shadow: 0 2px 5px rgba(79, 195, 247, 0.3) !important;
            transition: all 0.3s ease !important;
        }
        
        .btn-primary:hover,
        a.btn-primary:hover,
        button.btn-primary:hover,
        .table .btn-primary:hover {
            background: #29B6F6 !important;
            border: none !important;
            box-shadow: 0 4px 8px rgba(41, 182, 246, 0.4) !important;
            transform: translateY(-1px) !important;
        }
        
        /* Warning Button - Solid Light Blue */
        .btn-warning,
        a.btn-warning,
        button.btn-warning,
        .table .btn-warning {
            background: #4FC3F7 !important;
            border: none !important;
            color: white !important;
            border-radius: 6px !important;
            box-shadow: 0 2px 5px rgba(79, 195, 247, 0.3) !important;
            transition: all 0.3s ease !important;
        }
        
        .btn-warning:hover,
        a.btn-warning:hover,
        button.btn-warning:hover,
        .table .btn-warning:hover {
            background: #29B6F6 !important;
            border: none !important;
            box-shadow: 0 4px 8px rgba(41, 182, 246, 0.4) !important;
            transform: translateY(-1px) !important;
        }
        
        /* Danger/Delete Button - Solid Light Blue */
        .btn-danger,
        a.btn-danger,
        button.btn-danger,
        .table .btn-danger {
            background: #4FC3F7 !important;
            border: none !important;
            color: white !important;
            border-radius: 6px !important;
            box-shadow: 0 2px 5px rgba(79, 195, 247, 0.3) !important;
            transition: all 0.3s ease !important;
        }
        
        .btn-danger:hover,
        a.btn-danger:hover,
        button.btn-danger:hover,
        .table .btn-danger:hover {
            background: #29B6F6 !important;
            border: none !important;
            box-shadow: 0 4px 8px rgba(41, 182, 246, 0.4) !important;
            transform: translateY(-1px) !important;
        }
        
        /* Success Button - Solid Light Blue */
        .btn-success,
        a.btn-success,
        button.btn-success,
        .table .btn-success {
            background: #4FC3F7 !important;
            border: none !important;
            color: white !important;
            border-radius: 6px !important;
            box-shadow: 0 2px 5px rgba(79, 195, 247, 0.3) !important;
            transition: all 0.3s ease !important;
        }
        
        .btn-success:hover,
        a.btn-success:hover,
        button.btn-success:hover,
        .table .btn-success:hover {
            background: #29B6F6 !important;
            border: none !important;
            box-shadow: 0 4px 8px rgba(41, 182, 246, 0.4) !important;
            transform: translateY(-1px) !important;
        }
        
        /* Make action buttons in tables smaller and consistent */
        .table .btn-sm,
        .table a.btn,
        .table button.btn {
            padding: 6px 10px !important;
            font-size: 12px !important;
            margin: 2px !important;
            min-width: 32px !important;
            text-align: center !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            line-height: 1 !important;
            vertical-align: middle !important;
        }
        
        .table .btn i,
        .table .btn .fa,
        .table .btn .fas,
        .table .btn .far,
        .table .btn svg {
            font-size: 12px !important;
            transition: all 0.3s ease !important;
            margin: 0 !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }
        
        /* Force all action buttons to be light blue - SUPER SPECIFIC */
        table .btn-info,
        table .btn-primary,
        table .btn-warning,
        table .btn-default,
        table .btn-sm.btn-info,
        table .btn-sm.btn-primary,
        table .btn-sm.btn-warning,
        table .btn-sm.btn-default,
        table a.btn.btn-info,
        table a.btn.btn-primary,
        table a.btn.btn-warning,
        table a.btn.btn-default,
        table button.btn.btn-info,
        table button.btn.btn-primary,
        table button.btn.btn-warning,
        table button.btn.btn-default,
        .table .btn-info,
        .table .btn-primary,
        .table .btn-warning,
        .table .btn-default,
        .table .btn-sm.btn-info,
        .table .btn-sm.btn-primary,
        .table .btn-sm.btn-warning,
        .table .btn-sm.btn-default,
        .table a.btn.btn-info,
        .table a.btn.btn-primary,
        .table a.btn.btn-warning,
        .table a.btn.btn-default,
        .table button.btn.btn-info,
        .table button.btn.btn-primary,
        .table button.btn.btn-warning,
        .table button.btn.btn-default,
        .bootstrap-table .btn-info,
        .bootstrap-table .btn-primary,
        .bootstrap-table .btn-warning,
        .bootstrap-table .btn-default,
        .fixed-table-container .btn-info,
        .fixed-table-container .btn-primary,
        .fixed-table-container .btn-warning,
        .fixed-table-container .btn-default {
            background-color: #4FC3F7 !important;
            background-image: none !important;
            background: #4FC3F7 !important;
            border-color: #4FC3F7 !important;
            border: 1px solid #4FC3F7 !important;
            color: white !important;
            box-shadow: none !important;
        }
        
        table .btn-info:hover,
        table .btn-primary:hover,
        table .btn-warning:hover,
        table .btn-default:hover,
        .table .btn-info:hover,
        .table .btn-primary:hover,
        .table .btn-warning:hover,
        .table .btn-default:hover,
        .bootstrap-table .btn-info:hover,
        .bootstrap-table .btn-primary:hover,
        .bootstrap-table .btn-warning:hover,
        .bootstrap-table .btn-default:hover,
        .fixed-table-container .btn-info:hover,
        .fixed-table-container .btn-primary:hover,
        .fixed-table-container .btn-warning:hover,
        .fixed-table-container .btn-default:hover {
            background-color: #29B6F6 !important;
            background-image: none !important;
            background: #29B6F6 !important;
            border-color: #29B6F6 !important;
            color: white !important;
        }
        
        /* Keep danger button red for delete */
        table .btn-danger,
        .table .btn-danger,
        .table a.btn-danger,
        .table button.btn-danger,
        .bootstrap-table .btn-danger,
        .fixed-table-container .btn-danger {
            background-color: #EF5350 !important;
            background-image: none !important;
            background: #EF5350 !important;
            border-color: #EF5350 !important;
            border: 1px solid #EF5350 !important;
            color: white !important;
            box-shadow: none !important;
        }
        
        table .btn-danger:hover,
        .table .btn-danger:hover,
        .table a.btn-danger:hover,
        .bootstrap-table .btn-danger:hover,
        .fixed-table-container .btn-danger:hover {
            background-color: #E53935 !important;
            background-image: none !important;
            background: #E53935 !important;
            border-color: #E53935 !important;
            color: white !important;
        }
        
        /* Icon animation in buttons on hover */
        .btn:hover i,
        .btn:hover .fa,
        .btn:hover .fas,
        .btn:hover svg {
            transform: scale(1.1) !important;
        }
        
        .btn-danger:hover i,
        .btn-danger:hover .fa,
        .btn-danger:hover svg {
            transform: scale(1.1) rotate(5deg) !important;
        }
        
        .btn-info:hover i,
        .btn-info:hover .fa,
        .btn-info:hover svg {
            animation: iconBounce 0.6s ease-in-out !important;
        }
        
        @keyframes iconBounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-3px);
            }
        }
        
        /* Add glow to icons in gradient buttons */
        .btn-info svg,
        .btn-primary svg,
        .btn-warning svg,
        .btn-danger svg,
        .btn-success svg {
            filter: drop-shadow(0 1px 2px rgba(255, 255, 255, 0.3)) !important;
        }
        
        .btn-info:hover svg,
        .btn-primary:hover svg,
        .btn-warning:hover svg,
        .btn-danger:hover svg,
        .btn-success:hover svg {
            filter: drop-shadow(0 2px 4px rgba(255, 255, 255, 0.5)) !important;
        }
        
        /* Dropdown toggle buttons */
        .fixed-table-toolbar .dropdown-toggle,
        .btn-group .dropdown-toggle {
            border-radius: 6px !important;
        }
        
        /* Search input in toolbar */
        .fixed-table-toolbar .search input {
            border-radius: 20px !important;
            padding: 6px 15px !important;
            border: 1px solid #ddd !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
            transition: all 0.3s ease !important;
        }
        
        .fixed-table-toolbar .search input:focus {
            border-color: #42A5F5 !important;
            box-shadow: 0 0 0 3px rgba(66, 165, 245, 0.1) !important;
            outline: none !important;
        }
        
        /* ================================================
           MODERN ENHANCEMENTS - Advanced UI Features
           ================================================ */
        
        /* Beautiful Custom Scrollbar - Modern Chrome/Edge/Safari */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: #F5F7FA;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #B8C5D6 0%, #8B9BB0 100%);
            border-radius: 10px;
            border: 2px solid #F5F7FA;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #8B9BB0 0%, #6A7B8F 100%);
        }
        
        /* Scrollbar for Firefox */
        * {
            scrollbar-width: thin;
            scrollbar-color: #B8C5D6 #F5F7FA;
        }
        
        /* ================================================
           ALERT BOX STYLING - Modern & Clean
           ================================================ */
        
        /* Alert Success - Light Blue */
        .alert-success {
            background-color: #E3F2FD !important;
            border: 1px solid #4FC3F7 !important;
            color: #1565C0 !important;
            border-radius: 8px !important;
            padding: 12px 15px !important;
        }
        
        .alert-success .alert-icon,
        .alert-success i,
        .alert-success .fas {
            color: #4FC3F7 !important;
        }
        
        /* Alert Info - Light Blue */
        .alert-info {
            background-color: #E3F2FD !important;
            border: 1px solid #4FC3F7 !important;
            color: #1565C0 !important;
            border-radius: 8px !important;
            padding: 12px 15px !important;
        }
        
        .alert-info .alert-icon,
        .alert-info i,
        .alert-info .fas {
            color: #4FC3F7 !important;
        }
        
        /* Alert Warning - Orange */
        .alert-warning {
            background-color: #FFF8E1 !important;
            border: 1px solid #FFB74D !important;
            color: #E65100 !important;
            border-radius: 8px !important;
            padding: 12px 15px !important;
        }
        
        .alert-warning .alert-icon,
        .alert-warning i,
        .alert-warning .fas {
            color: #FFB74D !important;
        }
        
        /* Alert Danger/Error - Red */
        .alert-danger,
        .alert-error {
            background-color: #FFEBEE !important;
            border: 1px solid #EF5350 !important;
            color: #C62828 !important;
            border-radius: 8px !important;
            padding: 12px 15px !important;
        }
        
        .alert-danger .alert-icon,
        .alert-danger i,
        .alert-danger .fas,
        .alert-error .alert-icon,
        .alert-error i,
        .alert-error .fas {
            color: #EF5350 !important;
        }
        
        /* Alert Message (inline errors) */
        .alert-msg {
            color: #EF5350 !important;
            font-size: 13px !important;
            display: inline-block !important;
            margin-top: 5px !important;
        }
        
        .alert-msg i,
        .alert-msg .fas {
            margin-right: 5px !important;
        }
        
        /* Smooth Page Load Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        /* Apply animations to elements - HIGHLY OPTIMIZED */
        .content-wrapper {
            animation: fadeInUp 0.25s ease-out;
        }
        
        .box {
            animation: scaleIn 0.2s ease-out backwards;
        }
        
        /* Faster staggered animation for boxes */
        .box:nth-child(1) { animation-delay: 0s; }
        .box:nth-child(2) { animation-delay: 0.02s; }
        .box:nth-child(3) { animation-delay: 0.04s; }
        .box:nth-child(4) { animation-delay: 0.06s; }
        .box:nth-child(5) { animation-delay: 0.08s; }
        .box:nth-child(6) { animation-delay: 0.1s; }
        
        .sidebar-menu > li {
            animation: slideInRight 0.15s ease-out backwards;
        }
        
        /* Minimal delays for sidebar - feels instant */
        .sidebar-menu > li:nth-child(1) { animation-delay: 0s; }
        .sidebar-menu > li:nth-child(2) { animation-delay: 0.01s; }
        .sidebar-menu > li:nth-child(3) { animation-delay: 0.02s; }
        .sidebar-menu > li:nth-child(4) { animation-delay: 0.03s; }
        .sidebar-menu > li:nth-child(5) { animation-delay: 0.04s; }
        .sidebar-menu > li:nth-child(6) { animation-delay: 0.05s; }
        .sidebar-menu > li:nth-child(7) { animation-delay: 0.06s; }
        .sidebar-menu > li:nth-child(8) { animation-delay: 0.07s; }
        
        /* Glassmorphism Effect for Cards */
        .box {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95) !important;
        }
        
        /* Premium Glow Effect on Focus */
        .form-control:focus,
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        textarea:focus,
        select:focus {
            border-color: #42A5F5 !important;
            box-shadow: 0 0 0 3px rgba(66, 165, 245, 0.15), 
                        0 4px 12px rgba(66, 165, 245, 0.2) !important;
            transform: translateY(-1px);
            transition: all 0.3s ease;
        }
        
        /* Enhanced Table Rows Hover - OPTIMIZED for Performance */
        .table tbody tr {
            transition: background-color 0.15s ease, box-shadow 0.15s ease;
            cursor: pointer;
        }
        
        .table tbody tr:hover {
            background-color: #F8FAFB !important;
            box-shadow: 0 1px 4px rgba(66, 165, 245, 0.06);
            /* transform removed to prevent layout shift and improve performance */
        }
        
        /* Add subtle highlight on table row selection */
        .table tbody tr:active {
            background-color: #F0F7FF !important;
        }
        
        /* Pulse Animation for Notifications */
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }
        
        .label-danger,
        .badge-danger {
            animation: pulse 2s ease-in-out infinite;
        }
        
        /* Ripple Effect for Buttons */
        .btn {
            position: relative;
            overflow: hidden;
        }
        
        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn:active::after {
            width: 300px;
            height: 300px;
        }
        
        /* Floating Effect for Dashboard Cards - DISABLED (too distracting) */
        /* You can enable this if you want, but it might be too much movement */
        /*
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-5px);
            }
        }
        
        .dashboard.small-box {
            animation: float 8s ease-in-out infinite;
        }
        
        .dashboard.small-box:nth-child(even) {
            animation-delay: 2s;
        }
        
        .dashboard.small-box:nth-child(3n) {
            animation-delay: 4s;
        }
        */
        
        /* Smooth Icon Rotation on Hover */
        .sidebar-menu > li > a > .fa,
        .sidebar-menu > li > a > .fas {
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        .sidebar-menu > li:hover > a > .fa,
        .sidebar-menu > li:hover > a > .fas {
            transform: scale(1.2) rotate(5deg);
        }
        
        /* Specific icon colors and effects for dashboard small boxes */
        .dashboard.small-box .icon .fa-desktop {
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        .dashboard.small-box .icon .fa-certificate {
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        .dashboard.small-box .icon .fa-mouse {
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        .dashboard.small-box .icon .fa-microchip {
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        .dashboard.small-box .icon .fa-box-open {
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        .dashboard.small-box .icon .fa-user-friends {
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        /* Make Font Awesome icons more crisp */
        .fa, .fas, .far, .fal, .fab {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font-weight: 900 !important;
        }
        
        /* Beautiful Focus Ring for Accessibility */
        a:focus,
        button:focus,
        input:focus,
        select:focus,
        textarea:focus {
            outline: 2px solid #42A5F5;
            outline-offset: 2px;
            border-radius: 4px;
        }
        
        /* Skeleton Loading Effect */
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }
        
        .skeleton-loading {
            background: linear-gradient(
                90deg,
                #f0f0f0 25%,
                #e0e0e0 50%,
                #f0f0f0 75%
            );
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }
        
        /* Enhanced Dropdown Menu */
        .dropdown-menu {
            animation: scaleIn 0.2s ease-out;
            transform-origin: top;
        }
        
        .dropdown-menu > li > a {
            transition: all 0.2s ease;
        }
        
        .dropdown-menu > li > a:hover {
            transform: translateX(5px);
            background-color: #F0F7FF !important;
        }
        
        /* Progress Bar with Gradient Animation */
        @keyframes progressGradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        
        .progress-bar {
            background: linear-gradient(
                90deg,
                #42A5F5,
                #64B5F6,
                #42A5F5
            ) !important;
            background-size: 200% 200% !important;
            animation: progressGradient 3s ease infinite;
        }
        
        /* Badge with Modern Style */
        .badge,
        .label {
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            letter-spacing: 0.3px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .badge:hover,
        .label:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        /* Tooltip Enhancement */
        .tooltip {
            animation: fadeInUp 0.3s ease-out;
        }
        
        .tooltip-inner {
            background: linear-gradient(135deg, #2C3E50 0%, #34495E 100%);
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            font-weight: 500;
        }
        
        /* Hide ALL tooltips on toolbar buttons - FORCE */
        .fixed-table-toolbar .tooltip,
        .fixed-table-toolbar + .tooltip,
        .tooltip.in,
        .tooltip.show,
        body .tooltip {
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
        }
        
        /* Prevent title attribute from showing native tooltips */
        .fixed-table-toolbar button[title],
        .fixed-table-toolbar .btn[title],
        .fixed-table-toolbar a[title],
        .fixed-table-toolbar [data-original-title] {
            pointer-events: auto !important;
        }
        
        .fixed-table-toolbar button[title]:hover::after,
        .fixed-table-toolbar .btn[title]:hover::after,
        .fixed-table-toolbar a[title]:hover::after {
            content: none !important;
            display: none !important;
        }
        
        .fixed-table-toolbar .btn[title],
        .fixed-table-toolbar button[title],
        .fixed-table-toolbar .btn-group button[title] {
            pointer-events: auto !important;
        }
        
        .fixed-table-toolbar .btn[title]:hover::after,
        .fixed-table-toolbar button[title]:hover::after,
        .fixed-table-toolbar .btn-group button[title]:hover::after {
            display: none !important;
        }
        
        /* Navbar Icons Pulse on Alerts */
        .navbar .nav > li > a > .label-danger {
            animation: pulse 1.5s ease-in-out infinite;
        }
        
        /* Fix navbar top icons size */
        .navbar-nav > li > a {
            padding-top: 15px !important;
            padding-bottom: 15px !important;
        }
        
        .navbar-nav > li > a > i,
        .navbar-nav > li > a > .fa,
        .navbar-nav > li > a > .fas,
        .navbar-nav > li > a > svg {
            font-size: 16px !important;
            width: 16px !important;
            height: 16px !important;
        }
        
        /* Lightweight toggle - no animations */
        
        /* Clean minimalist - no fancy effects */
        
        /* Fix navbar search icon size and search field height */
        .navbar-form .btn-primary,
        .navbar-form .btn {
            height: 34px !important;
            padding: 6px 12px !important;
            font-size: 14px !important;
            line-height: 1.42857143 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        .navbar-form .btn i,
        .navbar-form .btn svg {
            font-size: 14px !important;
            width: 14px !important;
            height: 14px !important;
        }
        
        .navbar-form .form-control {
            height: 34px !important;
            padding: 6px 12px !important;
            font-size: 14px !important;
            line-height: 1.42857143 !important;
        }
        
        /* Fix toolbar alignment - make all buttons and inputs same height */
        .fixed-table-toolbar .form-control,
        .fixed-table-toolbar select,
        .fixed-table-toolbar input {
            height: 34px !important;
            padding: 6px 12px !important;
            font-size: 14px !important;
            line-height: 1.42857143 !important;
            vertical-align: middle !important;
        }
        
        .fixed-table-toolbar .btn,
        .fixed-table-toolbar button,
        .fixed-table-toolbar .btn-group > button {
            height: 34px !important;
            padding: 6px 12px !important;
            font-size: 14px !important;
            line-height: 1.42857143 !important;
            vertical-align: middle !important;
        }
        
        .fixed-table-toolbar .search input {
            height: 34px !important;
        }
        
        /* Make dropdown and search field same size */
        .fixed-table-toolbar .form-group select,
        .fixed-table-toolbar select.form-control {
            height: 34px !important;
            padding: 6px 12px !important;
            min-width: 100px !important;
        }
        
        /* Search Input Glow */
        .navbar-form .form-control:focus {
            background-color: #FFFFFF !important;
            box-shadow: 0 0 0 3px rgba(66, 165, 245, 0.1),
                        0 4px 16px rgba(66, 165, 245, 0.2),
                        inset 0 1px 3px rgba(0, 0, 0, 0.05) !important;
        }
        
        /* Remove global transitions - too heavy */
        
        /* Disable transition for layout properties */
        *,
        *::before,
        *::after {
            transition-property: none;
        }
        
        /* Re-enable for specific properties */
        a, button, input, select, textarea,
        .btn, .box, .card, .table tr,
        .sidebar-menu > li, .navbar .nav > li > a {
            transition: all 0.3s ease;
        }
        
        /* ================================================
           PREMIUM FINISHING TOUCHES
           ================================================ */
        
        /* Loading Spinner - Modern Style */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .spinner,
        .fa-spinner,
        .fa-circle-notch {
            animation: spin 1s linear infinite;
        }
        
        /* Alert Messages - Beautiful Style */
        .alert {
            border-radius: 12px !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
            padding: 15px 20px !important;
            font-weight: 500 !important;
            animation: slideInRight 0.4s ease-out;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #81C784 0%, #66BB6A 100%) !important;
            color: white !important;
        }
        
        .alert-info {
            background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%) !important;
            color: white !important;
        }
        
        .alert-warning {
            background: linear-gradient(135deg, #FFB74D 0%, #FFA726 100%) !important;
            color: white !important;
        }
        
        .alert-danger,
        .alert-error {
            background: linear-gradient(135deg, #E57373 0%, #EF5350 100%) !important;
            color: white !important;
        }
        
        .alert .close {
            color: white !important;
            opacity: 0.8 !important;
            transition: all 0.3s ease !important;
        }
        
        .alert .close:hover {
            opacity: 1 !important;
            transform: scale(1.2) rotate(90deg);
        }
        
        /* Breadcrumb - Modern Trail */
        .breadcrumb {
            background: transparent !important;
            padding: 12px 0 !important;
            margin-bottom: 15px !important;
        }
        
        .breadcrumb > li {
            font-size: 13px !important;
            font-weight: 500 !important;
        }
        
        .breadcrumb > li + li:before {
            content: "›" !important;
            color: #9E9E9E !important;
            padding: 0 8px !important;
            font-size: 16px !important;
        }
        
        .breadcrumb > li > a {
            color: #42A5F5 !important;
            transition: all 0.2s ease !important;
        }
        
        .breadcrumb > li > a:hover {
            color: #2196F3 !important;
            text-decoration: underline !important;
        }
        
        .breadcrumb > .active {
            color: #5A6C7D !important;
        }
        
        /* Pagination - Beautiful Buttons */
        .pagination > li > a,
        .pagination > li > span {
            border-radius: 8px !important;
            margin: 0 3px !important;
            border: 1px solid #E1E8ED !important;
            color: #5A6C7D !important;
            padding: 8px 14px !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
        }
        
        .pagination > li > a:hover {
            background: linear-gradient(135deg, #64B5F6 0%, #42A5F5 100%) !important;
            border-color: #42A5F5 !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(66, 165, 245, 0.3) !important;
        }
        
        .pagination > .active > a,
        .pagination > .active > span {
            background: linear-gradient(135deg, #64B5F6 0%, #42A5F5 100%) !important;
            border-color: #42A5F5 !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(66, 165, 245, 0.4) !important;
        }
        
        .pagination > .disabled > a,
        .pagination > .disabled > span {
            opacity: 0.5 !important;
        }
        
        /* Modal - Modern Dialog */
        .modal-content {
            border-radius: 16px !important;
            border: none !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
            animation: scaleIn 0.3s ease-out;
        }
        
        .modal-header {
            border-radius: 16px 16px 0 0 !important;
            background: linear-gradient(to bottom, #FFFFFF 0%, #F8F9FB 100%) !important;
            border-bottom: 1px solid #E8EBF0 !important;
            padding: 20px 25px !important;
        }
        
        .modal-title {
            font-weight: 600 !important;
            color: #2C3E50 !important;
            font-size: 18px !important;
        }
        
        .modal-body {
            padding: 25px !important;
        }
        
        .modal-footer {
            border-top: 1px solid #E8EBF0 !important;
            padding: 15px 25px !important;
            background-color: #FAFBFC !important;
            border-radius: 0 0 16px 16px !important;
        }
        
        /* Panel/Well - Card Style */
        .panel,
        .well {
            border-radius: 12px !important;
            border: 1px solid #E8EBF0 !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06) !important;
            background-color: #FFFFFF !important;
        }
        
        .panel-heading,
        .panel-title {
            background: linear-gradient(to bottom, #FFFFFF 0%, #F8F9FB 100%) !important;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600 !important;
            color: #2C3E50 !important;
        }
        
        /* Input Group - Modern Addon */
        .input-group-addon {
            border-radius: 6px !important;
            background-color: #F5F7FA !important;
            border-color: #E1E8ED !important;
            color: #5A6C7D !important;
            font-weight: 500 !important;
        }
        
        .input-group .form-control:first-child {
            border-radius: 6px 0 0 6px !important;
        }
        
        .input-group .form-control:last-child {
            border-radius: 0 6px 6px 0 !important;
        }
        
        /* List Group - Beautiful Items */
        .list-group-item {
            border-radius: 8px !important;
            margin-bottom: 8px !important;
            border: 1px solid #E8EBF0 !important;
            transition: all 0.3s ease !important;
        }
        
        .list-group-item:hover {
            background-color: #F8FAFB !important;
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        
        .list-group-item.active {
            background: linear-gradient(135deg, #64B5F6 0%, #42A5F5 100%) !important;
            border-color: #42A5F5 !important;
        }
        
        /* Tabs - Modern Navigation */
        .nav-tabs {
            border-bottom: 2px solid #E8EBF0 !important;
        }
        
        .nav-tabs > li > a {
            border-radius: 8px 8px 0 0 !important;
            margin-right: 5px !important;
            color: #5A6C7D !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
        }
        
        .nav-tabs > li > a:hover {
            background-color: #F8FAFB !important;
            border-color: #E8EBF0 !important;
            color: #42A5F5 !important;
        }
        
        .nav-tabs > li.active > a {
            background: linear-gradient(to bottom, #FFFFFF 0%, #F8F9FB 100%) !important;
            border-color: #E8EBF0 #E8EBF0 transparent !important;
            color: #42A5F5 !important;
            font-weight: 600 !important;
        }
        
        /* Select2 Dropdown Enhancement */
        .select2-container--default .select2-selection--single {
            border-radius: 6px !important;
            border-color: #E1E8ED !important;
            height: 38px !important;
            padding: 6px 12px !important;
        }
        
        .select2-container--default .select2-selection--single:focus {
            border-color: #42A5F5 !important;
            box-shadow: 0 0 0 3px rgba(66, 165, 245, 0.1) !important;
        }
        
        .select2-dropdown {
            border-radius: 8px !important;
            border-color: #E1E8ED !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
        }
        
        .select2-results__option--highlighted {
            background-color: #F0F7FF !important;
            color: #42A5F5 !important;
        }
        
        /* Checkbox & Radio - Material Style */
        input[type="checkbox"],
        input[type="radio"] {
            width: 18px !important;
            height: 18px !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }
        
        input[type="checkbox"]:checked,
        input[type="radio"]:checked {
            accent-color: #42A5F5 !important;
        }
        
        /* File Input - Modern Upload */
        input[type="file"] {
            padding: 10px !important;
            border-radius: 8px !important;
            border: 2px dashed #E1E8ED !important;
            background-color: #F8FAFB !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
        }
        
        input[type="file"]:hover {
            border-color: #42A5F5 !important;
            background-color: #F0F7FF !important;
        }
        
        /* Data Tables - Enhanced Styling */
        .dataTables_wrapper {
            padding: 15px !important;
        }
        
        .dataTables_filter input {
            border-radius: 20px !important;
            padding: 6px 15px !important;
            border: 1px solid #E1E8ED !important;
            margin-left: 10px !important;
        }
        
        .dataTables_filter input:focus {
            border-color: #42A5F5 !important;
            box-shadow: 0 0 0 3px rgba(66, 165, 245, 0.1) !important;
        }
        
        /* Footer - Elegant & Compact Bottom */
        footer,
        .main-footer {
            background: linear-gradient(to right, #FFFFFF 0%, #F8F9FB 100%) !important;
            border-top: 1px solid #E8EBF0 !important;
            padding: 10px 15px !important;
            color: #5A6C7D !important;
            font-size: 12px !important;
            min-height: auto !important;
        }
        
        footer a,
        .main-footer a {
            color: #42A5F5 !important;
            transition: all 0.2s ease !important;
        }
        
        footer a:hover,
        .main-footer a:hover {
            color: #2196F3 !important;
            text-decoration: underline !important;
        }
        
        /* Make footer buttons smaller and inline */
        .main-footer .btn-xs {
            padding: 3px 8px !important;
            font-size: 11px !important;
            margin: 0 2px !important;
        }
        
        .main-footer .clearfix {
            margin: 0 !important;
        }
        
        .main-footer .pull-left,
        .main-footer .pull-right {
            line-height: 24px !important;
        }
        
        /* Print Media - Clean Print */
        @media print {
            .sidebar,
            .main-header,
            .main-footer,
            .no-print {
                display: none !important;
            }
            
            .content-wrapper {
                background: white !important;
            }
            
            .box {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
        }
        
        /* Performance Optimization - Reduce motion for users who prefer it */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
            
            .box,
            .sidebar-menu > li,
            .content-wrapper {
                animation: none !important;
            }
        }
        
        /* Mobile Responsiveness - Optimize for smaller screens */
        @media (max-width: 768px) {
            .box {
                margin-bottom: 15px !important;
            }
            
            .box-header {
                padding: 8px 12px !important;
            }
            
            .box-body {
                padding: 10px !important;
            }
            
            .dashboard.small-box {
                margin-bottom: 10px !important;
            }
            
            /* Stack table controls vertically on mobile */
            .fixed-table-toolbar .pull-left,
            .fixed-table-toolbar .pull-right {
                float: none !important;
                display: block !important;
                margin-bottom: 10px !important;
            }
            
            /* Larger touch targets for mobile */
            .btn {
                min-height: 44px !important;
                padding: 10px 15px !important;
            }
            
            .table .btn-sm {
                min-height: 36px !important;
                padding: 6px 10px !important;
            }
        }
        
        /* High Contrast Mode Support */
        @media (prefers-contrast: high) {
            .box,
            .btn {
                border: 2px solid currentColor !important;
            }
        }
        
        /* Text Selection - Brand Color */
        ::selection {
            background-color: #42A5F5 !important;
            color: white !important;
        }
        
        ::-moz-selection {
            background-color: #42A5F5 !important;
            color: white !important;
        }
        
        /* Code Blocks - Developer Friendly */
        code,
        pre {
            background-color: #2C3E50 !important;
            color: #66BB6A !important;
            padding: 3px 6px !important;
            border-radius: 4px !important;
            font-family: 'Courier New', monospace !important;
        }
        
        pre {
            padding: 15px !important;
            border-radius: 8px !important;
            overflow-x: auto !important;
        }
        
        /* Image Enhancement */
        img {
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
        }
        
        img:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }
        
        /* Empty State - Beautiful Message */
        .empty-state {
            text-align: center !important;
            padding: 60px 20px !important;
            color: #9E9E9E !important;
        }
        
        .empty-state i,
        .empty-state .fa,
        .empty-state .fas {
            font-size: 64px !important;
            margin-bottom: 20px !important;
            opacity: 0.5 !important;
        }
        
        .empty-state h3 {
            color: #5A6C7D !important;
            font-weight: 600 !important;
            margin-bottom: 10px !important;
        }
        
        .empty-state p {
            color: #9E9E9E !important;
        }
        
        /* ================================================
           PERFORMANCE & UX OPTIMIZATIONS
           ================================================ */
        
        /* Smooth Scroll Behavior */
        html {
            scroll-behavior: smooth;
        }
        
        /* Focus Indicator for Keyboard Navigation */
        *:focus-visible {
            outline: 2px solid #42A5F5 !important;
            outline-offset: 2px !important;
            border-radius: 4px;
        }
        
        /* Remove focus outline for mouse users */
        *:focus:not(:focus-visible) {
            outline: none !important;
        }
        
        /* Improve link readability */
        a {
            text-decoration: none !important;
        }
        
        a:hover {
            text-decoration: underline !important;
        }
        
        /* Make buttons more tactile */
        .btn {
            cursor: pointer;
            user-select: none;
        }
        
        .btn:active {
            transform: scale(0.98);
        }
        
        /* Optimize animations for better performance */
        @media (prefers-reduced-motion: no-preference) {
            html {
                scroll-behavior: smooth;
            }
        }
        
        /* Will-change for elements that will animate */
        .box:hover,
        .btn:hover,
        .dashboard.small-box:hover {
            will-change: transform, box-shadow;
        }
        
        /* Loading State - Beautiful Skeleton */
        .loading-skeleton {
            background: linear-gradient(
                90deg,
                #f0f0f0 0%,
                #e0e0e0 50%,
                #f0f0f0 100%
            );
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 8px;
        }
        
        /* Quick Action Floating Button - Optional */
        .quick-action-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #64B5F6 0%, #42A5F5 100%);
            box-shadow: 0 4px 16px rgba(66, 165, 245, 0.4);
            color: white;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 999;
        }
        
        .quick-action-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(66, 165, 245, 0.5);
        }
        
        /* Toast Notification - Modern Alert */
        .toast-notification {
            position: fixed;
            top: 80px;
            right: 20px;
            min-width: 300px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInRight 0.3s ease-out;
            z-index: 9999;
        }
        
        .toast-notification.success {
            border-left: 4px solid #66BB6A;
        }
        
        .toast-notification.error {
            border-left: 4px solid #EF5350;
        }
        
        .toast-notification.info {
            border-left: 4px solid #29B6F6;
        }
        
        .toast-notification.warning {
            border-left: 4px solid #FFA726;
        }
        
        /* Card Hover Lift - Subtle */
        .info-box:hover,
        .small-box:hover {
            cursor: pointer;
        }
        
        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #64B5F6 0%, #42A5F5 100%);
            color: white;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 998;
            box-shadow: 0 4px 12px rgba(66, 165, 245, 0.3);
        }
        
        .back-to-top:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(66, 165, 245, 0.4);
        }
        
        .back-to-top.show {
            display: flex;
        }
        
        /* Improve Focus Visibility for Keyboard Users */
        *:focus-visible {
            outline: 2px solid #42A5F5 !important;
            outline-offset: 2px !important;
            border-radius: 4px !important;
        }
        
        /* Remove outline for mouse users */
        *:focus:not(:focus-visible) {
            outline: none !important;
        }
        
        /* Better spacing for mobile */
        @media (max-width: 768px) {
            .box {
                margin-bottom: 15px !important;
            }
            
            .dashboard.small-box {
                margin-bottom: 10px !important;
            }
            
            .quick-action-btn,
            .back-to-top {
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
            }
        }
        
        /* Skeleton loader for tables */
        .table-loading {
            position: relative;
            min-height: 200px;
        }
        
        .table-loading::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(66, 165, 245, 0.1) 50%,
                transparent 100%
            );
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        
        /* Optimize box shadow rendering */
        .box,
        .btn,
        .alert,
        .modal-content {
            backface-visibility: hidden;
            transform: translateZ(0);
        }
        
        /* Prevent layout shift from animations */
        .box,
        .sidebar-menu > li {
            transform: translateZ(0);
        }
        
        /* ============================================
           FINAL OVERRIDE - ACTION BUTTONS LIGHT BLUE
           This is the last CSS rule so it has highest priority
           ============================================ */
        
        /* Target ALL possible button variations with extreme specificity */
        body .content-wrapper table .btn-info,
        body .content-wrapper table .btn-primary,
        body .content-wrapper table .btn-warning,
        body .content-wrapper table .btn-default,
        body .content-wrapper .table .btn-info,
        body .content-wrapper .table .btn-primary,
        body .content-wrapper .table .btn-warning,
        body .content-wrapper .table .btn-default,
        body .content-wrapper .bootstrap-table .btn-info,
        body .content-wrapper .bootstrap-table .btn-primary,
        body .content-wrapper .bootstrap-table .btn-warning,
        body .content-wrapper .bootstrap-table .btn-default,
        body .content-wrapper .fixed-table-container .btn-info,
        body .content-wrapper .fixed-table-container .btn-primary,
        body .content-wrapper .fixed-table-container .btn-warning,
        body .content-wrapper .fixed-table-container .btn-default,
        body .wrapper table .btn-info,
        body .wrapper table .btn-primary,
        body .wrapper table .btn-warning,
        body .wrapper table .btn-default,
        body .wrapper .table .btn-info,
        body .wrapper .table .btn-primary,
        body .wrapper .table .btn-warning,
        body .wrapper .table .btn-default,
        body table a.btn-info,
        body table a.btn-primary,
        body table a.btn-warning,
        body table a.btn-default,
        body .table a.btn-info,
        body .table a.btn-primary,
        body .table a.btn-warning,
        body .table a.btn-default,
        body table button.btn-info,
        body table button.btn-primary,
        body table button.btn-warning,
        body table button.btn-default,
        .fixed-table-body .btn-info,
        .fixed-table-body .btn-primary,
        .fixed-table-body .btn-warning,
        .fixed-table-body .btn-default {
            background-color: #4FC3F7 !important;
            background-image: none !important;
            background: #4FC3F7 !important;
            border-color: #4FC3F7 !important;
            border: 1px solid #4FC3F7 !important;
            color: white !important;
            box-shadow: none !important;
        }
        
        body .content-wrapper table .btn-info:hover,
        body .content-wrapper table .btn-primary:hover,
        body .content-wrapper table .btn-warning:hover,
        body .content-wrapper table .btn-default:hover,
        body .content-wrapper .table .btn-info:hover,
        body .content-wrapper .table .btn-primary:hover,
        body .content-wrapper .table .btn-warning:hover,
        body .content-wrapper .table .btn-default:hover,
        body .wrapper .table .btn-info:hover,
        body .wrapper .table .btn-primary:hover,
        body .wrapper .table .btn-warning:hover,
        body .wrapper .table .btn-default:hover,
        .fixed-table-body .btn-info:hover,
        .fixed-table-body .btn-primary:hover,
        .fixed-table-body .btn-warning:hover,
        .fixed-table-body .btn-default:hover {
            background-color: #29B6F6 !important;
            background-image: none !important;
            background: #29B6F6 !important;
            border-color: #29B6F6 !important;
            color: white !important;
        }
        
        /* Keep delete button RED */
        body .content-wrapper table .btn-danger,
        body .content-wrapper .table .btn-danger,
        body .wrapper .table .btn-danger,
        .fixed-table-body .btn-danger {
            background-color: #EF5350 !important;
            background-image: none !important;
            background: #EF5350 !important;
            border-color: #EF5350 !important;
            border: 1px solid #EF5350 !important;
            color: white !important;
            box-shadow: none !important;
        }
        
        body .content-wrapper table .btn-danger:hover,
        body .content-wrapper .table .btn-danger:hover,
        body .wrapper .table .btn-danger:hover,
        .fixed-table-body .btn-danger:hover {
            background-color: #E53935 !important;
            background-image: none !important;
            background: #E53935 !important;
            border-color: #E53935 !important;
            color: white !important;
        }
    </style>

    @if (($snipeSettings) && ($snipeSettings->header_color!=''))
        <style nonce="{{ csrf_token() }}">
            /* User custom header color (if set in settings, it will override above) */
            :root { --brand-primary: {{ $snipeSettings->header_color }}; }
            .main-header .navbar, .main-header .logo {
                background-color: {{ $snipeSettings->header_color }} !important;
                background: linear-gradient(135deg, {{ $snipeSettings->header_color }} 0%, {{ $snipeSettings->header_color }} 100%) !important;
                border-color: {{ $snipeSettings->header_color }} !important;
            }

            .sidebar-menu > li:hover > a, .sidebar-menu > li.active > a {
                border-left-color: {{ $snipeSettings->header_color }} !important;
            }

            .btn-primary {
                background-color: {{ $snipeSettings->header_color }} !important;
                border-color: {{ $snipeSettings->header_color }} !important;
            }
        </style>
    @endif

    {{-- Custom CSS --}}
    @if (($snipeSettings) && ($snipeSettings->custom_css))
        <style>
            {!! $snipeSettings->show_custom_css() !!}
        </style>
    @endif


    <script nonce="{{ csrf_token() }}">
        window.snipeit = {
            settings: {
                "per_page": {{ $snipeSettings->per_page }}
            }
        };
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <script src="{{ url(asset('js/html5shiv.js')) }}" nonce="{{ csrf_token() }}"></script>
    <script src="{{ url(asset('js/respond.js')) }}" nonce="{{ csrf_token() }}"></script>


</head>

@if (($snipeSettings) && ($snipeSettings->allow_user_skin==1) && Auth::check() && Auth::user()->present()->skin != '')
    <body class="sidebar-mini skin-{{ $snipeSettings->skin!='' ? Auth::user()->present()->skin : 'blue' }} {{ (session('menu_state')!='open') ? 'sidebar-mini sidebar-collapse' : ''  }}">
@else
    <body class="sidebar-mini skin-{{ $snipeSettings->skin!='' ? $snipeSettings->skin : 'blue' }} {{ (session('menu_state')!='open') ? 'sidebar-mini sidebar-collapse' : ''  }}">
@endif


        <a class="skip-main" href="#main">{{ trans('general.skip_to_main_content') }}</a>
        <div class="wrapper">

            <header class="main-header">

                <!-- Logo -->


                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button above the compact sidenav -->
                    <a href="#" style="color: white" class="sidebar-toggle btn btn-white" data-toggle="push-menu"
                       role="button">
                        <span class="sr-only">{{ trans('general.toggle_navigation') }}</span>
                    </a>
                    <div class="nav navbar-nav navbar-left">
                        <div class="left-navblock">
                            @if ($snipeSettings->brand == '3')
                                <a class="logo navbar-brand no-hover" href="{{ config('app.url') }}">
                                    @if ($snipeSettings->logo!='')
                                        <img class="navbar-brand-img"
                                             src="{{ Storage::disk('public')->url($snipeSettings->logo) }}"
                                             alt="{{ $snipeSettings->site_name }} logo">
                                    @endif
                                    {{ $snipeSettings->site_name }}
                                </a>
                            @elseif ($snipeSettings->brand == '2')
                                <a class="logo navbar-brand no-hover" href="{{ config('app.url') }}">
                                    @if ($snipeSettings->logo!='')
                                        <img class="navbar-brand-img"
                                             src="{{ Storage::disk('public')->url($snipeSettings->logo) }}"
                                             alt="{{ $snipeSettings->site_name }} logo">
                                    @endif
                                    <span class="sr-only">{{ $snipeSettings->site_name }}</span>
                                </a>
                            @else
                                <a class="logo navbar-brand no-hover" href="{{ config('app.url') }}">
                                    {{ $snipeSettings->site_name }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            @can('index', \App\Models\Asset::class)
                                <li aria-hidden="true"{!! (request()->is('hardware*') ? ' class="active"' : '') !!}>
                                    <a href="{{ url('hardware') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=1" : ''}} tabindex="-1" data-tooltip="true" data-placement="bottom" data-title="{{ trans('general.assets') }}">
                                        <x-icon type="assets" class="fa-fw" />
                                        <span class="sr-only">{{ trans('general.assets') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('view', \App\Models\License::class)
                                <li aria-hidden="true"{!! (request()->is('licenses*') ? ' class="active"' : '') !!}>
                                    <a href="{{ route('licenses.index') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=2" : ''}} tabindex="-1" data-tooltip="true" data-placement="bottom" data-title="{{ trans('general.licenses') }}">
                                        <x-icon type="licenses" class="fa-fw" />
                                        <span class="sr-only">{{ trans('general.licenses') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('index', \App\Models\Accessory::class)
                                <li aria-hidden="true"{!! (request()->is('accessories*') ? ' class="active"' : '') !!}>
                                    <a href="{{ route('accessories.index') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=3" : ''}} tabindex="-1" data-tooltip="true" data-placement="bottom" data-title="{{ trans('general.accessories') }}">
                                        <x-icon type="accessories" class="fa-fw" />
                                        <span class="sr-only">{{ trans('general.accessories') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('index', \App\Models\Consumable::class)
                                <li aria-hidden="true"{!! (request()->is('consumables*') ? ' class="active"' : '') !!}>
                                    <a href="{{ url('consumables') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=4" : ''}} tabindex="-1" data-tooltip="true" data-placement="bottom" data-title="{{ trans('general.consumables') }}">
                                        <x-icon type="consumables" class="fa-fw" />
                                        <span class="sr-only">{{ trans('general.consumables') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('view', \App\Models\Component::class)
                                <li aria-hidden="true"{!! (request()->is('components*') ? ' class="active"' : '') !!}>
                                    <a href="{{ route('components.index') }}" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=5" : ''}} tabindex="-1" data-tooltip="true" data-placement="bottom" data-title="{{ trans('general.components') }}">
                                        <x-icon type="components" class="fa-fw" />
                                        <span class="sr-only">{{ trans('general.components') }}</span>
                                    </a>
                                </li>
                            @endcan

                            @can('index', \App\Models\Asset::class)
                                <li>
                                    <form class="navbar-form navbar-left form-horizontal" role="search"
                                          action="{{ route('findbytag/hardware') }}" method="get">
                                        <div class="col-xs-12 col-md-12">
                                            <div class="col-xs-12 form-group">
                                                <label class="sr-only" for="tagSearch">
                                                    {{ trans('general.lookup_by_tag') }}
                                                </label>
                                                <input type="text" class="form-control" id="tagSearch" name="assetTag" placeholder="{{ trans('general.lookup_by_tag') }}">
                                                <input type="hidden" name="topsearch" value="true" id="search">
                                            </div>
                                            <div class="col-xs-1">
                                                <button type="submit" id="topSearchButton" class="btn btn-primary pull-right">
                                                    <x-icon type="search" />
                                                    <span class="sr-only">{{ trans('general.search') }}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </li>
                            @endcan

                            @can('admin')
                                <li class="dropdown" aria-hidden="true">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                        {{ trans('general.create') }}
                                        <strong class="caret"></strong>
                                    </a>
                                    <ul class="dropdown-menu">
                                        @can('create', \App\Models\Asset::class)
                                            <li{!! (request()->is('hardware/create') ? ' class="active"' : '') !!}>
                                                <a href="{{ route('hardware.create') }}" tabindex="-1">
                                                    <x-icon type="assets" class="fa-fw" />
                                                    {{ trans('general.asset') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create', \App\Models\License::class)
                                            <li{!! (request()->is('licenses/create') ? ' class="active"' : '') !!}>
                                                <a href="{{ route('licenses.create') }}" tabindex="-1">
                                                    <x-icon type="licenses" class="fa-fw" />
                                                    {{ trans('general.license') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create', \App\Models\Accessory::class)
                                            <li {!! (request()->is('accessories/create') ? 'class="active"' : '') !!}>
                                                <a href="{{ route('accessories.create') }}" tabindex="-1">
                                                    <x-icon type="accessories" class="fa-fw" />
                                                    {{ trans('general.accessory') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create', \App\Models\Consumable::class)
                                            <li {!! (request()->is('consunmables/create') ? 'class="active"' : '') !!}>
                                                <a href="{{ route('consumables.create') }}" tabindex="-1">
                                                    <x-icon type="consumables" class="fa-fw" />
                                                    {{ trans('general.consumable') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create', \App\Models\Component::class)
                                            <li {!! (request()->is('components/create') ? 'class="active"' : '') !!}>
                                                <a href="{{ route('components.create') }}" tabindex="-1">
                                                    <x-icon type="components" class="fa-fw" />
                                                    {{ trans('general.component') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('create', \App\Models\User::class)
                                            <li {!! (request()->is('users/create') ? 'class="active"' : '') !!}>
                                                <a href="{{ route('users.create') }}" tabindex="-1">
                                                    <x-icon type="users" class="fa-fw" />
                                                    {{ trans('general.user') }}
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan

                            @can('admin')
                                <!-- Tasks: style can be found in dropdown.less -->
                                <?php $alert_items = ($snipeSettings->show_alerts_in_menu=='1') ? Helper::checkLowInventory() : [];
                                      $deprecations = Helper::deprecationCheck()
                                        ?>

                                <li class="dropdown tasks-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <x-icon type="alerts" />
                                        <span class="sr-only">{{ trans('general.alerts') }}</span>
                                        @if(count($alert_items) + count($deprecations))
                                            <span class="label label-danger">{{ count($alert_items) + count($deprecations)}}</span>
                                        @endif
                                    </a>
                                    <ul class="dropdown-menu">

                                        @if ((count($alert_items) + count($deprecations)) > 0)

                                            @can('superadmin')
                                                @if($deprecations)
                                                    @foreach ($deprecations as $key => $deprecation)
                                                        @if ($deprecation['check'])
                                                            <li class="header alert-warning">{!! $deprecation['message'] !!}</li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endcan

                                            @if($alert_items)
                                                <li class="header">
                                                    {{ trans_choice('general.quantity_minimum', count($alert_items)) }}
                                                </li>
                                                <li>
                                                <!-- inner menu: contains the actual data -->
                                                    <ul class="menu">
                                                        @for($i = 0; count($alert_items) > $i; $i++)
                                                            <!-- Task item -->
                                                            <li>
                                                                <a href="{{ route($alert_items[$i]['type'].'.show', $alert_items[$i]['id'])}}">
                                                                    <h2 class="task_menu">{{ $alert_items[$i]['name'] }}
                                                                        <small class="pull-right">
                                                                            {{ $alert_items[$i]['remaining'] }} {{ trans('general.remaining') }}
                                                                        </small>
                                                                    </h2>
                                                                    <div class="progress xs">
                                                                        <div class="progress-bar progress-bar-yellow"
                                                                             style="width: {{ $alert_items[$i]['percent'] }}%"
                                                                             role="progressbar"
                                                                             aria-valuenow="{{ $alert_items[$i]['percent'] }}"
                                                                             aria-valuemin="0" aria-valuemax="100">
                                                                            <span class="sr-only">
                                                                                {{ $alert_items[$i]['percent'] }}%
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <!-- end task item -->
                                                        @endfor
                                                    </ul>
                                                </li>
                                            @endif
                                        @else
                                            <li class="header">
                                                {{ trans_choice('general.quantity_minimum', 0) }}
                                            </li>

                                        @endif
{{--                                        <li class="footer">--}}
{{--                                          <a href="#">{{ trans('general.tasks_view_all') }}</a>--}}
{{--                                        </li>--}}
                                    </ul>
                                </li>
                            @endcan



                            <!-- User Account: style can be found in dropdown.less -->
                            @if (Auth::check())
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        @if (Auth::user()->present()->gravatar())
                                            <img src="{{ Auth::user()->present()->gravatar() }}" class="user-image"
                                                 alt="">
                                        @else
                                            <x-icon type="user" />
                                        @endif

                                        <span class="hidden-xs">
                                            {{ Auth::user()->display_name }}
                                            <strong class="caret"></strong>
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!-- User image -->
                                        <li {!! (request()->is('account/profile') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('view-assets') }}">
                                                <x-icon type="checkmark" class="fa-fw" />
                                                {{ trans('general.viewassets') }}
                                            </a></li>

                                        @can('viewRequestable', \App\Models\Asset::class)
                                            <li {!! (request()->is('account/requested') ? ' class="active"' : '') !!}>
                                                <a href="{{ route('account.requested') }}">
                                                    <x-icon type="checkmark" class="fa-fw" />
                                                    {{ trans('general.requested_assets_menu') }}
                                                </a></li>
                                        @endcan

                                        <li {!! (request()->is('account/accept') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('account.accept') }}">
                                                <x-icon type="checkmark" class="fa-fw" />
                                                {{ trans('general.accept_assets_menu') }}
                                            </a></li>


                                        @can('self.profile')
                                        <li>
                                            <a href="{{ route('profile') }}">
                                                <x-icon type="user" class="fa-fw" />
                                                {{ trans('general.editprofile') }}
                                            </a>
                                        </li>
                                        @endcan

                                        @if (Auth::user()->ldap_import!='1')
                                        <li>
                                            <a href="{{ route('account.password.index') }}">
                                                <x-icon type="password" class="fa-fw" />
                                                {{ trans('general.changepassword') }}
                                            </a>
                                        </li>
                                        @endif


                                        @can('self.api')
                                            <li>
                                                <a href="{{ route('user.api') }}">
                                                    <x-icon type="api-key" class="fa-fw" />
                                                     {{ trans('general.manage_api_keys') }}
                                                </a>
                                            </li>
                                        @endcan
                                        <li class="divider" style="margin-top: -1px; margin-bottom: -1px"></li>
                                        <li>

                                            <a href="{{ route('logout.get') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <x-icon type="logout" class="fa-fw" />
                                                 {{ trans('general.logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout.post') }}" method="POST" style="display: none;">
                                                <button type="submit" style="display: none;" title="logout"></button>
                                                {{ csrf_field() }}
                                            </form>

                                        </li>
                                    </ul>
                                </li>
                            @endif


                            @can('superadmin')
                                <li>
                                    <a href="{{ route('settings.index') }}">
                                        <x-icon type="admin-settings" />
                                        <span class="sr-only">{{ trans('general.admin') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </nav>
                <a href="#" style="float:left" class="sidebar-toggle-mobile visible-xs btn" data-toggle="push-menu"
                   role="button">
                    <span class="sr-only">{{ trans('general.toggle_navigation') }}</span>
                    <x-icon type="nav-toggle" />
                </a>
                <!-- Sidebar toggle button-->
            </header>

            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree" {{ \App\Helpers\Helper::determineLanguageDirection() == 'rtl' ? 'style="margin-right:12px' : '' }}>
                        @can('admin')
                            <li {!! (\Request::route()->getName()=='home' ? ' class="active"' : '') !!} class="firstnav">
                                <a href="{{ route('home') }}">
                                    <x-icon type="dashboard" class="fa-fw" />
                                    <span>{{ trans('general.dashboard') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('index', \App\Models\Asset::class)
                            <li class="treeview{{ ((request()->is('statuslabels/*') || request()->is('hardware*')) ? ' active' : '') }}">
                                <a href="#">
                                    <x-icon type="assets" class="fa-fw" />
                                    <span>{{ trans('general.assets') }}</span>
                                    <x-icon type="angle-left" class="pull-right fa-fw"/>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="{{ url('hardware') }}">
                                            <x-icon type="circle" class="text-grey fa-fw"/>
                                            {{ trans('general.list_all') }}
                                            <span class="badge">
                                                {{ (isset($total_assets)) ? $total_assets : '' }}
                                            </span>
                                        </a>
                                    </li>

                                    <?php $status_navs = \App\Models\Statuslabel::where('show_in_nav', '=', 1)->withCount('assets as asset_count')->get(); ?>
                                    @if (count($status_navs) > 0)
                                        @foreach ($status_navs as $status_nav)
                                            <li{!! (request()->is('statuslabels/'.$status_nav->id) ? ' class="active"' : '') !!}>
                                                <a href="{{ route('statuslabels.show', ['statuslabel' => $status_nav->id]) }}">
                                                    <i class="fas fa-circle text-grey fa-fw"
                                                       aria-hidden="true"{!!  ($status_nav->color!='' ? ' style="color: '.e($status_nav->color).'"' : '') !!}></i>
                                                    {{ $status_nav->name }}
                                                    <span class="badge badge-secondary">{{ $status_nav->asset_count }}</span></a></li>
                                        @endforeach
                                    @endif


                                    <li id="deployed-sidenav-option" {!! (Request::query('status') == 'Deployed' ? ' class="active"' : '') !!}>
                                        <a href="{{ url('hardware?status=Deployed') }}">
                                            <x-icon type="circle" class="text-blue fa-fw" />
                                            {{ trans('general.deployed') }}
                                            <span class="badge">{{ (isset($total_deployed_sidebar)) ? $total_deployed_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="rtd-sidenav-option"{!! (Request::query('status') == 'RTD' ? ' class="active"' : '') !!}>
                                        <a href="{{ url('hardware?status=RTD') }}">
                                            <x-icon type="circle" class="text-green fa-fw" />
                                            {{ trans('general.ready_to_deploy') }}
                                            <span class="badge">{{ (isset($total_rtd_sidebar)) ? $total_rtd_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="pending-sidenav-option"{!! (Request::query('status') == 'Pending' ? ' class="active"' : '') !!}><a href="{{ url('hardware?status=Pending') }}">
                                            <x-icon type="circle" class="text-orange fa-fw" />
                                            {{ trans('general.pending') }}
                                            <span class="badge">{{ (isset($total_pending_sidebar)) ? $total_pending_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="undeployable-sidenav-option"{!! (Request::query('status') == 'Undeployable' ? ' class="active"' : '') !!} ><a
                                                href="{{ url('hardware?status=Undeployable') }}">
                                            <x-icon type="x" class="text-red fa-fw" />
                                            {{ trans('general.undeployable') }}
                                            <span class="badge">{{ (isset($total_undeployable_sidebar)) ? $total_undeployable_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="byod-sidenav-option"{!! (Request::query('status') == 'byod' ? ' class="active"' : '') !!}><a
                                                href="{{ url('hardware?status=byod') }}">
                                            <x-icon type="x" class="text-red fa-fw" />
                                            {{ trans('general.byod') }}
                                            <span class="badge">{{ (isset($total_byod_sidebar)) ? $total_byod_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="archived-sidenav-option"{!! (Request::query('status') == 'Archived' ? ' class="active"' : '') !!}><a
                                                href="{{ url('hardware?status=Archived') }}">
                                            <x-icon type="x" class="text-red fa-fw" />
                                            {{ trans('admin/hardware/general.archived') }}
                                            <span class="badge">{{ (isset($total_archived_sidebar)) ? $total_archived_sidebar : '' }}</span>
                                        </a>
                                    </li>
                                    <li id="requestable-sidenav-option"{!! (Request::query('status') == 'Requestable' ? ' class="active"' : '') !!}><a
                                                href="{{ url('hardware?status=Requestable') }}">
                                            <x-icon type="checkmark" class="text-blue fa-fw" />
                                            {{ trans('admin/hardware/general.requestable') }}
                                        </a>
                                    </li>

                                    @can('audit', \App\Models\Asset::class)
                                        <li id="audit-due-sidenav-option"{!! (request()->is('hardware/audit/due') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('assets.audit.due') }}">
                                                <x-icon type="audit" class="text-yellow fa-fw"/>
                                                {{ trans('general.audit_due') }}
                                                <span class="badge">{{ (isset($total_due_and_overdue_for_audit)) ? $total_due_and_overdue_for_audit : '' }}</span>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('checkin', \App\Models\Asset::class)
                                    <li id="checkin-due-sidenav-option"{!! (request()->is('hardware/checkins/due') ? ' class="active"' : '') !!}>
                                        <a href="{{ route('assets.checkins.due') }}">
                                            <x-icon type="due" class="text-orange fa-fw"/>
                                            {{ trans('general.checkin_due') }}
                                            <span class="badge">{{ (isset($total_due_and_overdue_for_checkin)) ? $total_due_and_overdue_for_checkin : '' }}</span>
                                        </a>
                                    </li>
                                    @endcan

                                    <li class="divider">&nbsp;</li>
                                    @can('checkin', \App\Models\Asset::class)
                                        <li{!! (request()->is('hardware/quickscancheckin') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('hardware/quickscancheckin') }}">
                                                {{ trans('general.quickscan_checkin') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('checkout', \App\Models\Asset::class)
                                        <li{!! (request()->is('hardware/bulkcheckout') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('hardware.bulkcheckout.show') }}">
                                                {{ trans('general.bulk_checkout') }}
                                            </a>
                                        </li>
                                        <li{!! (request()->is('hardware/requested') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('assets.requested') }}">
                                                {{ trans('general.requested') }}</a>
                                        </li>
                                    @endcan

                                    @can('create', \App\Models\Asset::class)
                                        <li{!! (Request::query('Deleted') ? ' class="active"' : '') !!}>
                                            <a href="{{ url('hardware?status=Deleted') }}">
                                                {{ trans('general.deleted') }}
                                            </a>
                                        </li>
                                        <li {!! (request()->is('maintenances') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('maintenances.index') }}">
                                                {{ trans('general.maintenances') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin')
                                        <li id="import-history-sidenav-option" {!! (request()->is('hardware/history') ? ' class="active"' : '') !!}>
                                            <a href="{{ url('hardware/history') }}">
                                                {{ trans('general.import-history') }}
                                            </a>
                                        </li>
                                    @endcan
                                    @can('audit', \App\Models\Asset::class)
                                        <li id="bulk-audit-sidenav-option" {!! (request()->is('hardware/bulkaudit') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('assets.bulkaudit') }}">
                                                {{ trans('general.bulkaudit') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('view', \App\Models\License::class)
                            <li{!! (request()->is('licenses*') ? ' class="active"' : '') !!}>
                                <a href="{{ route('licenses.index') }}">
                                    <x-icon type="licenses" class="fa-fw"/>
                                    <span>{{ trans('general.licenses') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('index', \App\Models\Accessory::class)
                            <li id="accessories-sidenav-option"{!! (request()->is('accessories*') ? ' class="active"' : '') !!}>
                                <a href="{{ route('accessories.index') }}">
                                    <x-icon type="accessories" class="fa-fw" />
                                    <span>{{ trans('general.accessories') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('view', \App\Models\Consumable::class)
                            <li id="consumables-sidenav-option"{!! (request()->is('consumables*') ? ' class="active"' : '') !!}>
                                <a href="{{ url('consumables') }}">
                                    <x-icon type="consumables" class="fa-fw" />
                                    <span>{{ trans('general.consumables') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('view', \App\Models\Component::class)
                            <li id="components-sidenav-option"{!! (request()->is('components*') ? ' class="active"' : '') !!}>
                                <a href="{{ route('components.index') }}">
                                    <x-icon type="components" class="fa-fw" />
                                    <span>{{ trans('general.components') }}</span>
                                </a>
                            </li>
                        @endcan
                        {{-- Documents Module --}}
                        <li class="treeview{{ (request()->is('documents*') ? ' active' : '') }}" id="documents-sidenav-option">
                            <a href="#">
                                <i class="fas fa-file-alt fa-fw"></i>
                                <span>Documents</span>
                                <x-icon type="angle-left" class="pull-right fa-fw"/>
                            </a>
                            <ul class="treeview-menu">
                                <li{!! (request()->is('documents/asset') ? ' class="active"' : '') !!}><a href="{{ route('documents.index',['type'=>'asset']) }}"><x-icon type="circle" class="text-grey fa-fw"/> Asset</a></li>
                                <li{!! (request()->is('documents/component') ? ' class="active"' : '') !!}><a href="{{ route('documents.index',['type'=>'component']) }}"><x-icon type="circle" class="text-grey fa-fw"/> Component</a></li>
                                <li{!! (request()->is('documents/license') ? ' class="active"' : '') !!}><a href="{{ route('documents.index',['type'=>'license']) }}"><x-icon type="circle" class="text-grey fa-fw"/> License</a></li>
                                <li{!! (request()->is('documents/accessory') ? ' class="active"' : '') !!}><a href="{{ route('documents.index',['type'=>'accessory']) }}"><x-icon type="circle" class="text-grey fa-fw"/> Accessory</a></li>
                                <li{!! (request()->is('documents/consumable') ? ' class="active"' : '') !!}><a href="{{ route('documents.index',['type'=>'consumable']) }}"><x-icon type="circle" class="text-grey fa-fw"/> Consumable</a></li>
                                <li{!! (request()->is('documents/meta-defaults') ? ' class="active"' : '') !!}><a href="{{ route('documents.meta.defaults.edit') }}"><x-icon type="circle" class="text-grey fa-fw"/> Metadata Defaults</a></li>
                            </ul>
                        </li>
                        @can('view', \App\Models\PredefinedKit::class)
                            <li id="kits-sidenav-option"{!! (request()->is('kits') ? ' class="active"' : '') !!}>
                                <a href="{{ route('kits.index') }}">
                                    <x-icon type="kits" class="fa-fw" />
                                    <span>{{ trans('general.kits') }}</span>
                                </a>
                            </li>
                        @endcan

                        @can('view', \App\Models\User::class)
                                <li class="treeview{{ (request()->is('users*') ? ' active' : '') }}" id="users-sidenav-option">
                                    <a href="#" {{$snipeSettings->shortcuts_enabled == 1 ? "accesskey=6" : ''}}>
                                        <x-icon type="users" class="fa-fw" />
                                        <span>{{ trans('general.people') }}</span>
                                        <x-icon type="angle-left" class="pull-right fa-fw"/>
                                    </a>

                                    <ul class="treeview-menu">
                                        <li {!! ((request()->is('users')  && (request()->input() == null)) ? ' class="active"' : '') !!} id="users-sidenav-list-all">
                                            <a href="{{ route('users.index') }}">
                                                <x-icon type="circle" class="text-grey fa-fw fa-fw"/>
                                                {{ trans('general.list_all') }}
                                            </a>
                                        </li>
                                        <li class="{{ (request()->is('users') && request()->input('superadmins') == "true") ? 'active' : '' }}" id="users-sidenav-superadmins">
                                            <a href="{{ route('users.index', ['superadmins' => 'true']) }}">
                                                <x-icon type="superadmin" class="text-danger fa-fw"/>
                                                {{ trans('general.show_superadmins') }}
                                            </a>
                                        </li>
                                        <li class="{{ (request()->is('users') && request()->input('admins') == "true") ? 'active' : '' }}" id="users-sidenav-list-admins">
                                            <a href="{{ route('users.index', ['admins' => 'true']) }}">
                                                <x-icon type="admin" class="text-warning fa-fw"/>
                                                {{ trans('general.show_admins') }}
                                            </a>
                                        </li>
                                        <li class="{{ (request()->is('users') && request()->input('status') == "deleted") ? 'active' : '' }}" id="users-sidenav-deleted">
                                            <a href="{{ route('users.index', ['status' => 'deleted']) }}">
                                                <x-icon type="x" class="text-danger fa-fw"/>
                                                {{ trans('general.deleted_users') }}
                                            </a>
                                        </li>
                                        <li class="{{ (request()->is('users') && request()->input('activated') == "1") ? 'active' : '' }}" id="users-sidenav-activated">
                                            <a href="{{ route('users.index', ['activated' => true]) }}">
                                                <i class="fa-solid fa-person-circle-check text-success fa-fw"></i>
                                                {{ trans('general.login_enabled') }}
                                            </a>
                                        </li>
                                        <li class="{{ (request()->is('users') && request()->input('activated') == "0") ? 'active' : '' }}" id="users-sidenav-not-activated">
                                            <a href="{{ route('users.index', ['activated' => false]) }}">
                                                <i class="fa-solid fa-person-circle-xmark text-danger fa-fw"></i>
                                                {{ trans('general.login_disabled') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                        @endcan
                        @can('import')
                            <li id="import-sidenav-option"{!! (request()->is('import*') ? ' class="active"' : '') !!}>
                                <a href="{{ route('imports.index') }}">
                                    <x-icon type="import" class="fa-fw" />
                                    <span>{{ trans('general.import') }}</span>
                                </a>
                            </li>
                        @endcan

                        @can('backend.interact')
                            <li id="settings-sidenav-option" class="treeview {!! in_array(Request::route()->getName(),App\Helpers\Helper::SettingUrls()) ? ' active': '' !!}">
                                <a href="#" id="settings">
                                    <x-icon type="settings" class="fa-fw" />
                                    <span>{{ trans('general.settings') }}</span>
                                    <x-icon type="angle-left" class="pull-right fa-fw"/>
                                </a>

                                <ul class="treeview-menu">
                                    @if(Gate::allows('view', App\Models\CustomField::class) || Gate::allows('view', App\Models\CustomFieldset::class))
                                        <li {!! (request()->is('fields*') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('fields.index') }}">
                                                {{ trans('admin/custom_fields/general.custom_fields') }}
                                            </a>
                                        </li>
                                    @endif

                                    @can('view', \App\Models\Statuslabel::class)
                                        <li {!! (request()->is('statuslabels*') ? ' class="active"' : '') !!}>
                                            <a href="{{ route('statuslabels.index') }}">
                                                {{ trans('general.status_labels') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\AssetModel::class)
                                        <li {{!! (request()->is('models') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('models.index') }}">
                                                {{ trans('general.asset_models') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Category::class)
                                        <li {{!! (request()->is('categories') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('categories.index') }}">
                                                {{ trans('general.categories') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Manufacturer::class)
                                        <li {{!! (request()->is('manufacturers') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('manufacturers.index') }}">
                                                {{ trans('general.manufacturers') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Supplier::class)
                                        <li {{!! (request()->is('suppliers') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('suppliers.index') }}">
                                                {{ trans('general.suppliers') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Department::class)
                                        <li {{!! (request()->is('departments') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('departments.index') }}">
                                                {{ trans('general.departments') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Location::class)
                                        <li {{!! (request()->is('locations') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('locations.index') }}">
                                                {{ trans('general.locations') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Company::class)
                                        <li {{!! (request()->is('companies') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('companies.index') }}">
                                                {{ trans('general.companies') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view', \App\Models\Depreciation::class)
                                        <li  {{!! (request()->is('depreciations') ? ' class="active"' : '') !!}}>
                                            <a href="{{ route('depreciations.index') }}">
                                                {{ trans('general.depreciation') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan

                        @can('reports.view')
                            <li class="treeview{{ (request()->is('reports*') ? ' active' : '') }}">
                                <a href="#" class="dropdown-toggle">
                                    <x-icon type="reports" class="fa-fw" />
                                    <span>{{ trans('general.reports') }}</span>
                                    <x-icon type="angle-left" class="pull-right"/>
                                </a>

                                <ul class="treeview-menu">
                                    <li {{!! (request()->is('reports/activity') ? ' class="active"' : '') !!}}>
                                        <a href="{{ route('reports.activity') }}">
                                            {{ trans('general.activity_report') }}
                                        </a>
                                    </li>
                                    <li {{!! (request()->is('reports/custom') ? ' class="active"' : '') !!}}>
                                        <a href="{{ url('reports/custom') }}">
                                            {{ trans('general.custom_report') }}
                                        </a>
                                    </li>
                                    <li {{!! (request()->is('reports/audit') ? ' class="active"' : '') !!}}>
                                        <a href="{{ route('reports.audit') }}">
                                            {{ trans('general.audit_report') }}</a>
                                    </li>
                                    <li {{!! (request()->is('reports/depreciation') ? ' class="active"' : '') !!}}>
                                        <a href="{{ url('reports/depreciation') }}">
                                            {{ trans('general.depreciation_report') }}
                                        </a>
                                    </li>
                                    <li {{!! (request()->is('reports/licenses') ? ' class="active"' : '') !!}}>
                                        <a href="{{ url('reports/licenses') }}">
                                            {{ trans('general.license_report') }}
                                        </a>
                                    </li>
                                    <li {{!! (request()->is('ui.reports.maintenances') ? ' class="active"' : '') !!}}>
                                        <a href="{{ route('ui.reports.maintenances') }}">
                                            {{ trans('general.asset_maintenance_report') }}
                                        </a>
                                    </li>
                                    <li {{!! (request()->is('reports/unaccepted_assets') ? ' class="active"' : '') !!}}>
                                        <a href="{{ url('reports/unaccepted_assets') }}">
                                            {{ trans('general.unaccepted_asset_report') }}
                                        </a>
                                    </li>
                                    <li  {{!! (request()->is('reports/accessories') ? ' class="active"' : '') !!}}>
                                        <a href="{{ url('reports/accessories') }}">
                                            {{ trans('general.accessory_report') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        @can('viewRequestable', \App\Models\Asset::class)
                            <li{!! (request()->is('account/requestable-assets') ? ' class="active"' : '') !!}>
                                <a href="{{ route('requestable-assets') }}">
                                    <x-icon type="requestable" class="fa-fw" />
                                    <span>{{ trans('general.requestable_items') }}</span>
                                </a>
                            </li>
                        @endcan


                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->

            <div class="content-wrapper" role="main" id="setting-list">

                @if ($debug_in_production)
                    <div class="row" style="margin-bottom: 0px; background-color: red; color: white; font-size: 15px;">
                        <div class="col-md-12"
                             style="margin-bottom: 0px; background-color: #b50408 ; color: white; padding: 10px 20px 10px 30px; font-size: 16px;">
                            <x-icon type="warning" class="fa-3x pull-left"/>
                            <strong>{{ strtoupper(trans('general.debug_warning')) }}:</strong>
                            {!! trans('general.debug_warning_text') !!}
                        </div>
                    </div>
                @endif

                <!-- Content Header (Page header) -->
                <section class="content-header">


                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 0px;">

                        <style>
                            .breadcrumb-item {
                                display: inline;
                                list-style: none;
                            }
                        </style>

                            <h1 class="pull-left pagetitle" style="font-size: 22px; margin-top: 5px;">

                                @if (Breadcrumbs::has() && (Breadcrumbs::current()->count() > 1))
                                    <ul style="padding-left: 0;">

                                    @foreach (Breadcrumbs::current() as $crumbs)
                                        @if ($crumbs->url() && !$loop->last)
                                            <li class="breadcrumb-item">
                                                <a href="{{ $crumbs->url() }}">
                                                    @if ($loop->first)
                                                        <x-icon type="home" />
                                                    @else
                                                        {{ $crumbs->title() }}
                                                    @endif
                                                </a>
                                                <x-icon type="angle-right" />
                                            </li>
                                        @elseif (is_null($crumbs->url()) && !$loop->last)
                                            <li class="breadcrumb-item active">
                                                {{ $crumbs->title() }}
                                                <x-icon type="angle-right" />
                                            </li>
                                       @else
                                            <li class="breadcrumb-item active">
                                                {{ $crumbs->title() }}
                                            </li>
                                        @endif
                                    @endforeach

                                    </ul>
                                @else
                                    @yield('title')
                                @endif

                            </h1>

                                @if (isset($helpText))
                                    @include ('partials.more-info',
                                                           [
                                                               'helpText' => $helpText,
                                                               'helpPosition' => (isset($helpPosition)) ? $helpPosition : 'left'
                                                           ])
                                @endif
                                <div class="pull-right">
                                    @yield('header_right')
                                </div>

                        </div>
                    </div>
                </section>


                <section class="content" id="main" tabindex="-1" style="padding-top: 0px;">

                    <!-- Notifications -->
                    <div class="row">
                        @if (config('app.lock_passwords'))
                            <div class="col-md-12">
                                <div class="callout callout-info">
                                    {{ trans('general.some_features_disabled') }}
                                </div>
                            </div>
                        @endif

                        @include('notifications')
                    </div>


                    <!-- Content -->
                    <div id="{!! (request()->is('*api*') ? 'app' : 'webui') !!}">
                        @yield('content')
                    </div>

                </section>

            </div><!-- /.content-wrapper -->
            <footer class="main-footer hidden-print">
                <div class="clearfix" style="line-height: 20px;">
                    <div class="pull-left">
                         {!! trans('general.footer_credit') !!}
                         @if ($snipeSettings->footer_text!='')
                            {!!  Helper::parseEscapedMarkedown($snipeSettings->footer_text)  !!}
                         @endif
                    </div>
                    <div class="pull-right">
                    @if ($snipeSettings->version_footer!='off')
                        @if (($snipeSettings->version_footer=='on') || (($snipeSettings->version_footer=='admin') && (Auth::user()->isSuperUser()=='1')))
                            <strong>v{{ config('version.app_version') }}</strong>
                        @endif
                    @endif

                    @if (isset($user) && ($user->isSuperUser()) && (app()->environment('local')))
                       <a href="{{ url('telescope') }}" class="btn btn-default btn-xs" rel="noopener">Telescope</a>
                    @endif

                    @if ($snipeSettings->support_footer!='off')
                        @if (($snipeSettings->support_footer=='on') || (($snipeSettings->support_footer=='admin') && (Auth::user()->isSuperUser()=='1')))
                            <a target="_blank" class="btn btn-default btn-xs" href="https://snipe-it.readme.io/docs/overview" rel="noopener">Manual</a>
                            <a target="_blank" class="btn btn-default btn-xs" href="https://snipeitapp.com/support/" rel="noopener">Support</a>
                        @endif
                    @endif

                    @if ($snipeSettings->privacy_policy_link!='')
                        <a target="_blank" class="btn btn-default btn-xs" rel="noopener" href="{{  $snipeSettings->privacy_policy_link }}" target="_new">Privacy</a>
                    @endif
                    </div>
                </div>
            </footer>
        </div><!-- ./wrapper -->


        <!-- end main container -->

        <div class="modal modal-danger fade" id="dataConfirmModal" tabindex="-1" role="dialog" aria-labelledby="dataConfirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h2 class="modal-title" id="dataConfirmModalLabel">
                            <span class="modal-header-icon"></span>&nbsp;
                        </h2>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <form method="post" id="deleteForm" role="form" action="">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">{{ trans('general.cancel') }}</button>
                            <button type="submit" class="btn btn-outline"
                                    id="dataConfirmOK">{{ trans('general.yes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal modal-warning fade" id="restoreConfirmModal" tabindex="-1" role="dialog"
             aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="confirmModalLabel">&nbsp;</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <form method="post" id="restoreForm" role="form">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}

                            <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">{{ trans('general.cancel') }}</button>
                            <button type="submit" class="btn btn-outline"
                                    id="dataConfirmOK">{{ trans('general.yes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        {{-- Javascript files --}}
        <script src="{{ url(mix('js/dist/all.js')) }}" nonce="{{ csrf_token() }}"></script>
        <script src="{{ url('js/select2/i18n/'.Helper::mapBackToLegacyLocale(app()->getLocale()).'.js') }}"></script>

        {{-- Page level javascript --}}
        @stack('js')

        @section('moar_scripts')
        @show


        <script nonce="{{ csrf_token() }}">

            $.fn.datepicker.dates['{{ app()->getLocale() }}'] = {
                days: [
                    "{{ trans('datepicker.days.sunday') }}",
                    "{{ trans('datepicker.days.monday') }}",
                    "{{ trans('datepicker.days.tuesday') }}",
                    "{{ trans('datepicker.days.wednesday') }}",
                    "{{ trans('datepicker.days.thursday') }}",
                    "{{ trans('datepicker.days.friday') }}",
                    "{{ trans('datepicker.days.saturday') }}"
                ],
                daysShort: [
                    "{{ trans('datepicker.short_days.sunday') }}",
                    "{{ trans('datepicker.short_days.monday') }}",
                    "{{ trans('datepicker.short_days.tuesday') }}",
                    "{{ trans('datepicker.short_days.wednesday') }}",
                    "{{ trans('datepicker.short_days.thursday') }}",
                    "{{ trans('datepicker.short_days.friday') }}",
                    "{{ trans('datepicker.short_days.saturday') }}"
                ],
                daysMin: [
                    "{{ trans('datepicker.min_days.sunday') }}",
                    "{{ trans('datepicker.min_days.monday') }}",
                    "{{ trans('datepicker.min_days.tuesday') }}",
                    "{{ trans('datepicker.min_days.wednesday') }}",
                    "{{ trans('datepicker.min_days.thursday') }}",
                    "{{ trans('datepicker.min_days.friday') }}",
                    "{{ trans('datepicker.min_days.saturday') }}"
                ],
                months: [
                    "{{ trans('datepicker.months.january') }}",
                    "{{ trans('datepicker.months.february') }}",
                    "{{ trans('datepicker.months.march') }}",
                    "{{ trans('datepicker.months.april') }}",
                    "{{ trans('datepicker.months.may') }}",
                    "{{ trans('datepicker.months.june') }}",
                    "{{ trans('datepicker.months.july') }}",
                    "{{ trans('datepicker.months.august') }}",
                    "{{ trans('datepicker.months.september') }}",
                    "{{ trans('datepicker.months.october') }}",
                    "{{ trans('datepicker.months.november') }}",
                    "{{ trans('datepicker.months.december') }}",
                ],
                monthsShort:  [
                    "{{ trans('datepicker.months_short.january') }}",
                    "{{ trans('datepicker.months_short.february') }}",
                    "{{ trans('datepicker.months_short.march') }}",
                    "{{ trans('datepicker.months_short.april') }}",
                    "{{ trans('datepicker.months_short.may') }}",
                    "{{ trans('datepicker.months_short.june') }}",
                    "{{ trans('datepicker.months_short.july') }}",
                    "{{ trans('datepicker.months_short.august') }}",
                    "{{ trans('datepicker.months_short.september') }}",
                    "{{ trans('datepicker.months_short.october') }}",
                    "{{ trans('datepicker.months_short.november') }}",
                    "{{ trans('datepicker.months_short.december') }}",
                ],
                today: "{{ trans('datepicker.today') }}",
                clear: "{{ trans('datepicker.clear') }}",
                format: "yyyy-mm-dd",
                weekStart: 0
            };

            var clipboard = new ClipboardJS('.js-copy-link');

            clipboard.on('success', function(e) {
                // Get the clicked element
                var clickedElement = $(e.trigger);
                // Get the target element selector from data attribute
                var targetSelector = clickedElement.data('data-clipboard-target');
                // Show the alert that the content was copied
                clickedElement.tooltip('hide').attr('data-original-title', '{{ trans('general.copied') }}').tooltip('show');
            });

            // Reference: https://jqueryvalidation.org/validate/
            var validator = $('#create-form').validate({
                ignore: 'input[type=hidden]',
                errorClass: 'alert-msg',
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    $(element).hasClass('select2') || $(element).hasClass('js-data-ajax')
                        // If the element is a select2 then append the error to the parent div
                        ? element.parent('div').append(error)
                        // Otherwise place it after
                        : error.insertAfter(element);
                },
                highlight: function(inputElement) {
                    $(inputElement).parent().addClass('has-error');
                    $(inputElement).closest('.help-block').remove();
                },
                onfocusout: function(element) {
                    $(element).parent().removeClass('has-error');
                    return $(element).valid();
                },

            });

            $.extend($.validator.messages, {
                required: "{{ trans('validation.generic.required') }}",
                email: "{{ trans('validation.generic.email') }}"
            });


            function showHideEncValue(e) {
                // Use element id to find the text element to hide / show
                var targetElement = e.id+"-to-show";
                var hiddenElement = e.id+"-to-hide";
                var audio = new Audio('{{ config('app.url') }}/sounds/lock.mp3');
                if($(e).hasClass('fa-lock')) {
                    @if ((isset($user)) && ($user->enable_sounds))
                        audio.play()
                    @endif
                    $(e).removeClass('fa-lock').addClass('fa-unlock');
                    // Show the encrypted custom value and hide the element with asterisks
                    document.getElementById(targetElement).style.fontSize = "100%";
                    document.getElementById(hiddenElement).style.display = "none";

                } else {
                    @if ((isset($user)) && ($user->enable_sounds))
                        audio.play()
                    @endif
                    $(e).removeClass('fa-unlock').addClass('fa-lock');
                    // ClipboardJS can't copy display:none elements so use a trick to hide the value
                    document.getElementById(targetElement).style.fontSize = "0px";
                    document.getElementById(hiddenElement).style.display = "";

                 }
             }

            $(function () {
                
                // Lightweight tooltip removal - only run once
                function removeToolbarTooltips() {
                    $('.fixed-table-toolbar [title]').removeAttr('title');
                    $('.fixed-table-toolbar [data-original-title]').removeAttr('data-original-title');
                }
                
                // Remove tooltips only once on page load
                setTimeout(removeToolbarTooltips, 500);
                
                // Simple mouseenter handler without aggressive removal
                $(document).on('mouseenter', '.fixed-table-toolbar button, .fixed-table-toolbar .btn', function() {
                    $(this).removeAttr('title');
                });

                // This handles the show/hide for cloned items
                $('#use_cloned_image').click(function() {
                    if ($('#use_cloned_image').is(':checked')) {
                        $('#image_delete').prop('checked', false);
                        $('#image-upload').hide();
                        $('#existing-image').show();
                    } else {
                        $('#image-upload').show();
                        $('#existing-image').hide();
                    }
                    //$('#image-upload').hide();
                });

                // Disable tooltips on toolbar buttons
                $('.fixed-table-toolbar button, .fixed-table-toolbar .btn').each(function() {
                    $(this).attr('title', '');
                    $(this).tooltip('destroy');
                });
                
                // Invoke Bootstrap 3's tooltip
                $('[data-tooltip="true"]').tooltip({
                    container: 'body',
                    animation: true,
                });

                $('[data-toggle="popover"]').popover();
                $('.select2 span').addClass('needsclick');
                $('.select2 span').removeAttr('title');

                // This javascript handles saving the state of the menu (expanded or not)
                $('body').bind('expanded.pushMenu', function () {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('account.menuprefs', ['state'=>'open']) }}",
                        _token: "{{ csrf_token() }}"
                    });

                });

                $('body').bind('collapsed.pushMenu', function () {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('account.menuprefs', ['state'=>'close']) }}",
                        _token: "{{ csrf_token() }}"
                    });
                });

            });

            // Initiate the ekko lightbox
            $(document).on('click', '[data-toggle="lightbox"]', function (event) {
                event.preventDefault();
                $(this).ekkoLightbox();
            });
            //This prevents multi-click checkouts for accessories, components, consumables
            $(document).ready(function () {
                $('#checkout_form').submit(function (event) {
                    event.preventDefault();
                    $('#submit_button').prop('disabled', true);
                    this.submit();
                });
            });

            // Select encrypted custom fields to hide them in the asset list
            $(document).ready(function() {
                // Selector for elements with css-padlock class
                var selector = 'td.css-padlock';

                // Function to add original value to elements
                function addValue($element) {
                    // Get original value of the element
                    var originalValue = $element.text().trim();

                    // Show asterisks only for not empty values
                    if (originalValue !== '') {
                        // This is necessary to avoid loop because value is generated dynamically
                        if (originalValue !== '' && originalValue !== asterisks) $element.attr('value', originalValue);

                        // Hide the original value and show asterisks of the same length
                        var asterisks = '*'.repeat(originalValue.length);
                        $element.text(asterisks);

                        // Add click event to show original text
                        $element.click(function() {
                            var $this = $(this);
                            if ($this.text().trim() === asterisks) {
                                $this.text($this.attr('value'));
                            } else {
                                $this.text(asterisks);
                            }
                        });
                    }
                }
                // Add value to existing elements
                $(selector).each(function() {
                    addValue($(this));
                });

                // Removed heavy MutationObserver - only observe on page load
                // If dynamic content needs this, use delegated events instead
            });


        </script>

        @if ((Session::get('topsearch')=='true') || (request()->is('/')))
            <script nonce="{{ csrf_token() }}">
                $("#tagSearch").focus();
            </script>
        @endif

        </body>
</html>
