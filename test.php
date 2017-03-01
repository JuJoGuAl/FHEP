<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
define('LDAP_DOMAIN', 'fhep.org');
define('LDAP_HOSTNAME', '192.168.0.2');
$ldap_columns = NULL;
$ldap_connection = NULL;
$ldap_password = '224805.';
$username = 'jjgutierrez';
$ldap_username = $username.'@'.LDAP_DOMAIN;

//------------------------------------------------------------------------------
// Connect to the LDAP server.
//------------------------------------------------------------------------------
$ldap_connection = ldap_connect(LDAP_HOSTNAME);
if (FALSE === $ldap_connection){
    die("<p>Failed to connect to the LDAP server: ". LDAP_HOSTNAME ."</p>");
}

ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0); // We need this for doing an LDAP search.

if (TRUE !== ldap_bind($ldap_connection, $ldap_username, $ldap_password)){
    die('<p>Failed to bind to LDAP server.</p>');
}

//------------------------------------------------------------------------------
// Get a list of all Active Directory users.
//------------------------------------------------------------------------------
$ldap_base_dn = 'DC=fhep,DC=org';
$search_filter = "(&(objectCategory=person))";
$result = ldap_search($ldap_connection, $ldap_base_dn, $search_filter);
if (FALSE !== $result){
    $entries = ldap_get_entries($ldap_connection, $result);
    if ($entries['count'] > 0){
        $odd = 0;
        foreach ($entries[0] AS $key => $value){
            if (0 === $odd%2){
                $ldap_columns[] = $key;
            }
            $odd++;
        }
        echo '<table class="data" border="1">';
        echo '<tr>';
        $header_count = 0;
        foreach ($ldap_columns AS $col_name){
            if (0 === $header_count++){
                echo '<th class="ul">';
            }else if (count($ldap_columns) === $header_count){
                echo '<th class="ur">';
            }else{
                echo '<th class="u">';
            }
            echo $col_name .'</th>';
        }
        echo '</tr>';
        for ($i = 0; $i < $entries['count']; $i++){
            echo '<tr>';
            $td_count = 0;
            foreach ($ldap_columns AS $col_name){
                if (0 === $td_count++){
                    echo '<td class="l">';
                }else{
                    echo '<td>';
                }
                if (isset($entries[$i][$col_name])){
                    $output = NULL;
                    if ('lastlogon' === $col_name || 'lastlogontimestamp' === $col_name){
                        $output = date('D M d, Y @ H:i:s', ($entries[$i][$col_name][0] / 10000000) - 11676009600);
                    }else{
                        $output = $entries[$i][$col_name][0];
                    }
                    echo $output .'</td>';
                }
            }
            echo '</tr>';
        }
        echo '</table>';
    }
}
//ldap_unbind($ldap_connection); // Clean up after ourselves.

$attributes = array("memberof","primarygroupid");
$filter = "(&(sAMAccountName=$username))";
$result = ldap_search($ldap_connection, $ldap_base_dn, $filter, $attributes);
$entries = ldap_get_entries($ldap_connection, $result);
if($entries["count"] > 0){
  echo "memberof: ".$entries[0]['memberof'][0]."<br/>";
  echo "primarygroupid: ".$entries[0]['primarygroupid'][0]."<br/>";
  // Get groups and primary group token
    $output = $entries[0]['memberof'];
    $token = $entries[0]['primarygroupid'][0];
    
    // Remove extraneous first entry
    array_shift($output);
    
    // We need to look up the primary group, get list of all groups
    $results2 = ldap_search($ldap_connection,$ldap_base_dn,"(objectcategory=group)",array("distinguishedname","primarygrouptoken"));
    $entries2 = ldap_get_entries($ldap_connection, $results2);
    
    // Remove extraneous first entry
    array_shift($entries2);
    
    // Loop through and find group with a matching primary group token
    foreach($entries2 as $e) {
        if($e['primarygrouptoken'][0] == $token) {
            // Primary group found, add it to output array
            $output[] = $e['distinguishedname'][0];
            // Break loop
            break;
        }
    }
    echo $output;
 } else {
 echo("msg:'".ldap_error($ldap_connection)."'</br>");
 }
?>