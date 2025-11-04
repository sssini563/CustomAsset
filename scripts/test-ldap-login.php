<?php
/**
 * Test LDAP Login Filter
 * Usage: php scripts/test-ldap-login.php username
 */

if ($argc < 2) {
    echo "Usage: php scripts/test-ldap-login.php <username>\n";
    echo "Example: php scripts/test-ldap-login.php admin\n";
    exit(1);
}

$testUsername = $argv[1];

echo "=== Test LDAP Login Filter ===\n\n";
echo "Testing login for username: {$testUsername}\n\n";

// LDAP Configuration
$ldapServer = 'ldap://10.10.10.101';
$ldapPort = 389;
$bindDn = 'ldapbind@kindairy.com'; // Try UPN format first
$baseDn = 'DC=kindairy,DC=com';

// Prompt for bind password
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
echo "Binding with: {$bindDn}... ";
$bind = @ldap_bind($ldapConn, $bindDn, $bindPassword);

if (!$bind) {
    echo "❌ FAILED\n";
    echo "Error: " . ldap_error($ldapConn) . "\n";
    
    // Try alternative DN format
    $bindDn = "CN=ldapbind,OU=ServiceAccounts,DC=kindairy,DC=com";
    echo "Trying alternative: {$bindDn}... ";
    $bind = @ldap_bind($ldapConn, $bindDn, $bindPassword);
    
    if (!$bind) {
        echo "❌ FAILED\n";
        echo "Error: " . ldap_error($ldapConn) . "\n";
        exit(1);
    }
}

echo "✅ SUCCESS\n\n";

// Test different filter formats that Snipe-IT might use
$filterTemplates = [
    // Correct format for Snipe-IT
    'sAMAccountName=%s',
    
    // What Snipe-IT generates internally
    '(sAMAccountName=%s)',
    '(&(objectClass=user)(sAMAccountName=%s))',
    
    // Common alternatives
    'samaccountname=%s',
    '(samaccountname=%s)',
];

echo "Testing search filters for user: {$testUsername}\n";
echo str_repeat("-", 70) . "\n\n";

$successFilters = [];

foreach ($filterTemplates as $index => $template) {
    // Replace %s with actual username
    $filter = str_replace('%s', $testUsername, $template);
    
    echo "Test " . ($index + 1) . ": {$filter}\n";
    
    $search = @ldap_search(
        $ldapConn, 
        $baseDn, 
        $filter, 
        ['sAMAccountName', 'cn', 'mail', 'distinguishedName', 'userAccountControl'],
        0,
        5
    );
    
    if ($search) {
        $entries = ldap_get_entries($ldapConn, $search);
        
        if ($entries['count'] > 0) {
            echo "  ✅ SUCCESS - Found user!\n";
            $successFilters[] = $template;
            
            $user = $entries[0];
            $username = $user['samaccountname'][0] ?? 'N/A';
            $name = $user['cn'][0] ?? 'N/A';
            $email = $user['mail'][0] ?? 'N/A';
            $dn = $user['distinguishedname'][0] ?? 'N/A';
            $uac = $user['useraccountcontrol'][0] ?? 'N/A';
            
            // Check if disabled
            $isDisabled = ($uac != 'N/A' && ($uac & 2)) ? ' ⚠️ DISABLED' : '';
            
            echo "    Username: {$username}\n";
            echo "    Name: {$name}{$isDisabled}\n";
            echo "    Email: {$email}\n";
            echo "    DN: {$dn}\n";
            
            // Try to authenticate with user's credentials
            echo "\n    Testing user authentication...\n";
            echo "    Enter password for {$username}: ";
            $userPassword = trim(fgets(STDIN));
            
            if (!empty($userPassword)) {
                $userBind = @ldap_bind($ldapConn, $dn, $userPassword);
                if ($userBind) {
                    echo "    ✅ User authentication successful!\n";
                } else {
                    echo "    ❌ User authentication failed: " . ldap_error($ldapConn) . "\n";
                }
            }
        } else {
            echo "  ⚠️  Filter valid but user not found\n";
        }
    } else {
        echo "  ❌ FAILED - Bad search filter\n";
        echo "  Error: " . ldap_error($ldapConn) . "\n";
    }
    echo "\n";
}

echo str_repeat("=", 70) . "\n";
echo "RESULTS:\n\n";

if (count($successFilters) > 0) {
    echo "✅ Working filter templates:\n";
    foreach ($successFilters as $filter) {
        echo "  - {$filter}\n";
    }
    
    echo "\n";
    echo "FOR SNIPE-IT LDAP SETTINGS:\n";
    echo "  LDAP Filter: {$successFilters[0]}\n";
    echo "  LDAP Authentication query: samaccountname=\n";
    echo "  Base Bind DN: {$baseDn}\n";
} else {
    echo "❌ No working filters found.\n";
    echo "Possible issues:\n";
    echo "  1. User '{$testUsername}' doesn't exist in AD\n";
    echo "  2. User is in a different OU not covered by Base DN\n";
    echo "  3. Base DN is incorrect\n";
}

ldap_close($ldapConn);
