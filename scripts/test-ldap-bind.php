<?php
/**
 * Test LDAP Bind Credentials
 * Usage: php scripts/test-ldap-bind.php
 */

echo "=== Test LDAP Bind Connection ===\n\n";

// LDAP Configuration - EDIT THESE VALUES
$ldapServer = 'ldap://10.10.10.101';
$ldapPort = 389;

// Try different bind username formats
$bindFormats = [
    'CN=ldapbind,OU=ServiceAccounts,DC=kindairy,DC=com',  // Full DN
    'ldapbind@kindairy.com',                              // UPN format
    'KINDAIRY\\ldapbind',                                 // Domain\username
];

// Enter password here (will be hidden in production)
echo "Enter LDAP Bind Password: ";
$bindPassword = trim(fgets(STDIN));

if (empty($bindPassword)) {
    echo "❌ Password cannot be empty!\n";
    exit(1);
}

// Test connection
echo "\nTesting LDAP connection to: {$ldapServer}:{$ldapPort}\n";
echo str_repeat("-", 60) . "\n\n";

foreach ($bindFormats as $index => $bindDn) {
    echo "Test " . ($index + 1) . ": {$bindDn}\n";
    
    // Connect to LDAP
    $ldapConn = @ldap_connect($ldapServer, $ldapPort);
    
    if (!$ldapConn) {
        echo "  ❌ Cannot connect to LDAP server\n";
        echo "  Error: " . ldap_error($ldapConn) . "\n\n";
        continue;
    }
    
    // Set LDAP options
    ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);
    ldap_set_option($ldapConn, LDAP_OPT_NETWORK_TIMEOUT, 10);
    
    // Try to bind
    $bind = @ldap_bind($ldapConn, $bindDn, $bindPassword);
    
    if ($bind) {
        echo "  ✅ SUCCESS! Credentials are valid.\n";
        echo "  → Use this format in Snipe-IT: {$bindDn}\n\n";
        
        // Try to search users
        $baseDn = 'OU=Users,DC=kindairy,DC=com';
        $filter = '(objectClass=user)';
        $search = @ldap_search($ldapConn, $baseDn, $filter, ['sAMAccountName', 'cn', 'mail'], 0, 5);
        
        if ($search) {
            $entries = ldap_get_entries($ldapConn, $search);
            echo "  Found {$entries['count']} users in {$baseDn}\n";
            
            if ($entries['count'] > 0) {
                echo "  Sample users:\n";
                for ($i = 0; $i < min(3, $entries['count']); $i++) {
                    $username = $entries[$i]['samaccountname'][0] ?? 'N/A';
                    $name = $entries[$i]['cn'][0] ?? 'N/A';
                    $email = $entries[$i]['mail'][0] ?? 'N/A';
                    echo "    - {$username} ({$name}) - {$email}\n";
                }
            }
        } else {
            echo "  ⚠️  Bind successful but cannot search users\n";
            echo "  Check Base DN: {$baseDn}\n";
        }
        
        ldap_close($ldapConn);
        echo "\n" . str_repeat("=", 60) . "\n";
        echo "✅ LDAP Configuration is working!\n";
        echo "Use this Bind DN in Snipe-IT: {$bindDn}\n";
        exit(0);
    } else {
        echo "  ❌ FAILED: Invalid credentials\n";
        echo "  Error: " . ldap_error($ldapConn) . "\n\n";
    }
    
    ldap_close($ldapConn);
}

echo str_repeat("=", 60) . "\n";
echo "❌ All bind attempts failed.\n\n";
echo "Troubleshooting:\n";
echo "1. Verify password is correct for ldapbind account\n";
echo "2. Check if account is locked/disabled in AD\n";
echo "3. Verify account has permission to bind and search\n";
echo "4. Check if password has expired\n";
echo "5. Try resetting the ldapbind account password in AD\n";
