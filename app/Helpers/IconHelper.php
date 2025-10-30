<?php

namespace App\Helpers;

class IconHelper
{

    public static function icon($type) {
        switch ($type) {
            case 'checkout':
                return 'fa-solid fa-right-from-bracket';
            case 'checkin':
                return 'fa-solid fa-right-to-bracket';
            case 'edit':
                return 'fas fa-pen-to-square';
            case 'clone':
                return 'far fa-copy';
            case 'delete':
            case 'upload deleted':
                return 'fas fa-trash-can';
            case 'create':
                return 'fa-solid fa-circle-plus';
            case 'audit':
                return 'fa-solid fa-list-check';
            case '2fa reset':
                return 'fa-solid fa-mobile-screen';
            case 'new-user':
                return 'fa-solid fa-user-plus';
            case 'merged-user':
                return 'fa-solid fa-people-arrows';
            case 'delete-user':
                return 'fa-solid fa-user-minus';
            case 'update-user':
                return 'fa-solid fa-user-pen';
            case 'user':
                return 'fa-solid fa-user';
            case 'users':
                return 'fas fa-user-friends'; // Changed for modern people icon
            case 'restore':
                return 'fas fa-undo'; // Simpler undo icon
            case 'external-link':
                return 'fas fa-external-link-alt'; // Modern external link
            case 'email':
                return 'fa-regular fa-envelope';
            case 'phone':
                return 'fa-solid fa-phone';
            case 'mobile':
                return 'fas fa-mobile-screen-button';
            case 'long-arrow-right':
                return 'fas fa-long-arrow-alt-right';
            case 'download':
                return 'fas fa-download';
            case 'checkmark':
                return 'fas fa-check icon-white';
            case 'x':
                return 'fas fa-times';
            case 'logout':
                return 'fa fa-right-from-bracket';
            case 'admin-settings':
                return 'fas fa-sliders';
            case 'settings':
                return 'fas fa-gear';
            case 'angle-left':
                return 'fas fa-chevron-left';
            case 'angle-right':
                return 'fas fa-chevron-right';
            case 'warning':
                return 'fas fa-triangle-exclamation';
            case 'kits':
                return 'fas fa-box-archive';
            case 'assets':
            case 'asset':
                return 'fas fa-desktop'; // Changed from barcode to desktop for modern look
            case 'accessories':
            case 'accessory':
                return 'fas fa-mouse'; // Changed from keyboard to mouse for variety
            case 'components':
            case 'component':
                return 'fas fa-microchip'; // Changed from hdd to microchip for modern tech look
            case 'consumables':
            case 'consumable':
                return 'fas fa-box-open'; // Changed from tint to box-open for supplies look
            case 'licenses':
            case 'license':
                return 'fas fa-certificate'; // Changed from save to certificate for license look
            case 'requestable':
                return 'fas fa-laptop';
            case 'reports':
                return 'fas fa-chart-pie'; // Changed from chart-bar to chart-pie for variety
            case 'heart':
                return 'fas fa-heart';
            case 'circle':
                return 'fa-regular fa-circle';
            case 'circle-solid':
                return 'fa-solid fa-circle';
            case 'due':
                return 'fas fa-clock-rotate-left';
            case 'import':
                return 'fas fa-file-import';
            case 'search':
                return 'fas fa-magnifying-glass';
            case 'qrcode':
                return 'fas fa-qrcode';
            case 'alerts':
                return 'far fa-bell';
            case 'password':
                return 'fa-solid fa-lock';
            case 'api-key':
                return 'fa-solid fa-key';
            case 'nav-toggle':
                return 'fas fa-bars-staggered';
            case 'dashboard':
                return 'fas fa-chart-line'; // Changed from tachometer to chart-line for modern analytics look
            case 'info-circle':
                    return 'fas fa-info-circle';
            case 'caret-right':
                return 'fa fa-chevron-right';
            case 'caret-up':
                return 'fa fa-chevron-up';
            case 'caret-down':
                return 'fa fa-chevron-down';
            case 'arrow-circle-right':
                return 'fas fa-circle-arrow-right';
            case 'minus':
                return 'fas fa-circle-minus';
            case 'spinner':
                return 'fas fa-spinner fa-spin';
            case 'copy-clipboard':
                return 'fa-regular fa-paste';
            case 'paperclip':
                return 'fas fa-link';
            case 'files':
                return 'fa-regular fa-file-lines';
            case 'more-info':
                return 'far fa-circle-question';
            case 'calendar':
                return 'fas fa-calendar-days';
            case 'plus':
                return 'fas fa-circle-plus';
            case 'history':
                return 'fas fa-clock-rotate-left';
            case 'more-files':
                return 'fa-solid fa-laptop-file';
            case 'maintenances':
                return 'fas fa-screwdriver-wrench';
            case 'seats':
                return 'far fa-rectangle-list';
            case 'globe-us':
                return 'fas fa-earth-americas';
            case 'locked':
                return 'fas fa-lock';
            case 'unlocked':
                return 'fas fa-lock-open';
            case 'locations':
                return 'fas fa-location-dot';
            case 'location':
                return 'fas fa-location-dot';
            case 'superadmin':
            case 'admin':
                return 'fas fa-user-shield';
            case 'print':
                return 'fa-solid fa-print';
            case 'checkin-and-delete':
                return 'fa-solid fa-user-xmark';
            case 'branding':
                return 'fas fa-palette';
            case 'general-settings':
                return 'fa-solid fa-list-check';
            case 'groups':
                return 'fa-solid fa-users-rectangle';
            case 'bell':
                return 'fa-solid fa-bell';
            case 'hashtag':
                return 'fa-solid fa-hashtag';
            case 'asset-tags':
                return 'fas fa-barcode';
            case 'labels':
                return 'fas fa-tag';
            case 'ldap':
                return 'fas fa-diagram-project';
            case 'google':
                return 'fa-brands fa-google';
            case 'saml':
                return 'fas fa-right-to-bracket';
            case 'backups':
                return 'fas fa-floppy-disk';
            case 'logins':
                return 'fas fa-right-to-bracket';
            case 'oauth':
                return 'fas fa-shield-halved';
            case 'employee_num' :
                return 'fa-regular fa-id-card';
            case 'department' :
                return 'fa-solid fa-building-user';
            case 'home' :
                return 'fa-solid fa-house';
            case 'note':
            case 'notes':
                return 'fas fa-note-sticky';
        }
    }
}
