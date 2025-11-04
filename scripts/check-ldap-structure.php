<?php
/**
 * Check LDAP OU Structure
 * Usage: php scripts/check-ldap-structure.php
 */

echo "=== Check LDAP OU Structure ===\n\n";

// LDAP Configuration
$ldapServer = 'ldap://10.10.10.101';
$ldapPort = 389;
$bindDn = 'CN=ldapbind,OU=ServiceAccounts,DC=kindairy,DC=com';

// Try these alternatives if above doesn't work
$bindAlternatives = [
    'ldapbind@kindairy.com',
    'KINDAIRY\\ldapbind',
];

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

// Try to bind
$bind = @ldap_bind($ldapConn, $bindDn, $bindPassword);

if (!$bind) {
    echo "❌ Bind failed with DN format: {$bindDn}\n";
    echo "Trying alternative formats...\n\n";
    
    foreach ($bindAlternatives as $altDn) {
        echo "Trying: {$altDn}... ";
        $bind = @ldap_bind($ldapConn, $altDn, $bindPassword);
        if ($bind) {
            echo "✅ SUCCESS!\n";
            $bindDn = $altDn;
            break;
        } else {
            echo "❌ Failed\n";
        }
    }
    
    if (!$bind) {
        echo "\n❌ All bind attempts failed: " . ldap_error($ldapConn) . "\n";
        exit(1);
    }
}

echo "✅ Bind successful with: {$bindDn}\n\n";

// Search for OUs
$baseDnOptions = [
    'DC=kindairy,DC=com',                          // Root domain
    'OU=Users,DC=kindairy,DC=com',                 // If there's a Users parent OU
    'OU=Factory,DC=kindairy,DC=com',               // Factory OU
    'OU=Head Office,DC=kindairy,DC=com',           // Head Office OU
];

echo "Checking Base DN options:\n";
echo str_repeat("=", 70) . "\n\n";

$validBaseDns = [];

foreach ($baseDnOptions as $baseDn) {
    echo "Testing: {$baseDn}\n";
    
    // Search for users
    $filter = '(objectClass=user)';
    $search = @ldap_search(
        $ldapConn, 
        $baseDn, 
        $filter, 
        ['sAMAccountName', 'cn', 'distinguishedName'],
        0,
        10
    );
    
    if ($search) {
        $entries = ldap_get_entries($ldapConn, $search);
        $userCount = $entries['count'];
        
        if ($userCount > 0) {
            echo "  ✅ VALID - Found {$userCount} user(s)\n";
            $validBaseDns[] = $baseDn;
            
            echo "  Sample users:\n";
            for ($i = 0; $i < min(5, $userCount); $i++) {
                $username = $entries[$i]['samaccountname'][0] ?? 'N/A';
                $name = $entries[$i]['cn'][0] ?? 'N/A';
                $dn = $entries[$i]['distinguishedname'][0] ?? 'N/A';
                echo "    - {$username} ({$name})\n";
                echo "      DN: {$dn}\n";
            }
        } else {
            echo "  ⚠️  Base DN exists but no users found\n";
        }
    } else {
        $error = ldap_error($ldapConn);
        if (strpos($error, 'No such object') !== false) {
            echo "  ❌ Base DN does not exist\n";
        } else {
            echo "  ❌ Error: {$error}\n";
        }
    }
    echo "\n";
}

// Search for all OUs
echo str_repeat("=", 70) . "\n";
echo "Searching for all OUs in domain...\n\n";

$ouSearch = @ldap_search(
    $ldapConn,
    'DC=kindairy,DC=com',
    '(objectClass=organizationalUnit)',
    ['ou', 'distinguishedName'],
    0,
    50
);

if ($ouSearch) {
    $ouEntries = ldap_get_entries($ldapConn, $ouSearch);
    echo "Found {$ouEntries['count']} OUs:\n";
    
    for ($i = 0; $i < $ouEntries['count']; $i++) {
        $ouName = $ouEntries[$i]['ou'][0] ?? 'N/A';
        $ouDn = $ouEntries[$i]['distinguishedname'][0] ?? 'N/A';
        
        // Count users in this OU
        $userSearch = @ldap_list($ldapConn, $ouDn, '(objectClass=user)', ['cn'], 0, 1);
        $userCount = 0;
        if ($userSearch) {
            $userEntries = ldap_get_entries($ldapConn, $userSearch);
            $userCount = $userEntries['count'];
        }
        
        echo "  - {$ouName}: {$ouDn}";
        if ($userCount > 0) {
            echo " [{$userCount} users]";
        }
        echo "\n";
    }
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "RECOMMENDATION for Snipe-IT:\n\n";

if (count($validBaseDns) > 0) {
    if (count($validBaseDns) == 1) {
        echo "✅ Use this Base Bind DN:\n";
        echo "   {$validBaseDns[0]}\n";
    } else {
        echo "✅ Multiple valid Base DNs found. Choose based on your needs:\n\n";
        
        // Recommend the highest level one
        $recommended = $validBaseDns[0]; // Usually the first (root) is best
        echo "   RECOMMENDED (covers all OUs):\n";
        echo "   {$recommended}\n\n";
        
        echo "   Or if you want to limit to specific OUs:\n";
        for ($i = 1; $i < count($validBaseDns); $i++) {
            echo "   {$validBaseDns[$i]}\n";
        }
    }
} else {
    echo "❌ No valid Base DN found with users.\n";
    echo "Please check your AD structure.\n";
}

echo "\nLDAP Configuration for Snipe-IT:\n";
echo "  LDAP Server: {$ldapServer}\n";
echo "  LDAP Bind Username: {$bindDn}\n";
echo "  Base Bind DN: " . ($validBaseDns[0] ?? 'DC=kindairy,DC=com') . "\n";
echo "  LDAP Filter: sAMAccountName=%s\n";
echo "  LDAP Authentication query: samaccountname=\n";

ldap_close($ldapConn);
