<?php
/**
 * Test LDAP Search Filter
 * Usage: php scripts/test-ldap-filter.php
 */

echo "=== Test LDAP Search Filter ===\n\n";

// LDAP Configuration
$ldapServer = 'ldap://10.10.10.101';
$ldapPort = 389;
$bindDn = 'CN=ldapbind,OU=ServiceAccounts,DC=kindairy,DC=com';
$baseDn = 'OU=Users,DC=kindairy,DC=com';

// Prompt for password
echo "Enter LDAP Bind Password: ";
$bindPassword = trim(fgets(STDIN));

if (empty($bindPassword)) {
    echo "❌ Password cannot be empty!\n";
    exit(1);
}

// Connect
echo "\nConnecting to {$ldapServer}...\n";
$ldapConn = ldap_connect($ldapServer, $ldapPort);

if (!$ldapConn) {
    echo "❌ Cannot connect to LDAP server\n";
    exit(1);
}

ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);
ldap_set_option($ldapConn, LDAP_OPT_NETWORK_TIMEOUT, 10);

// Bind
echo "Binding with: {$bindDn}\n";
$bind = @ldap_bind($ldapConn, $bindDn, $bindPassword);

if (!$bind) {
    echo "❌ Bind failed: " . ldap_error($ldapConn) . "\n";
    exit(1);
}

echo "✅ Bind successful!\n\n";

// Test different filter formats
$filters = [
    // Correct formats
    '(objectClass=user)',
    '(sAMAccountName=*)',
    '(&(objectClass=user)(objectCategory=person))',
    '(&(objectClass=user)(!(userAccountControl:1.2.840.113556.1.4.803:=2)))',
    
    // Test specific user
    '(sAMAccountName=admin)',
];

echo "Testing search filters against Base DN: {$baseDn}\n";
echo str_repeat("-", 70) . "\n\n";

foreach ($filters as $index => $filter) {
    echo "Test " . ($index + 1) . ": {$filter}\n";
    
    $search = @ldap_search(
        $ldapConn, 
        $baseDn, 
        $filter, 
        ['sAMAccountName', 'cn', 'mail', 'userAccountControl'],
        0,
        5
    );
    
    if ($search) {
        $entries = ldap_get_entries($ldapConn, $search);
        echo "  ✅ Filter valid - Found {$entries['count']} user(s)\n";
        
        if ($entries['count'] > 0) {
            for ($i = 0; $i < min(3, $entries['count']); $i++) {
                $username = $entries[$i]['samaccountname'][0] ?? 'N/A';
                $name = $entries[$i]['cn'][0] ?? 'N/A';
                $uac = $entries[$i]['useraccountcontrol'][0] ?? 'N/A';
                
                // Check if account is disabled (UAC & 2 = disabled)
                $disabled = ($uac != 'N/A' && ($uac & 2)) ? ' (DISABLED)' : '';
                
                echo "    - {$username}: {$name}{$disabled}\n";
            }
        }
    } else {
        echo "  ❌ Filter invalid: " . ldap_error($ldapConn) . "\n";
    }
    echo "\n";
}

echo str_repeat("=", 70) . "\n";
echo "✅ Test complete!\n\n";
echo "Recommended filter for Snipe-IT:\n";
echo "  LDAP Filter: sAMAccountName=%s (no parentheses)\n";
echo "  Auth Filter: (&(objectClass=user)(objectCategory=person))\n";

ldap_close($ldapConn);
