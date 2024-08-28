<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once("../config.php");
require_once($CFG->dirroot.'/user/lib.php');

function get_firstname(): string {
    return '5ВИП19';
}

function get_lastnames(): array {
    global $CFG;
    
    $lastnames = json_decode(file_get_contents($CFG->dirroot . '/user_generator/lastname.json'));
    $firstnames = json_decode(file_get_contents($CFG->dirroot . '/user_generator/firstname.json'));
    
    $fullusernames = [];
    
    $firstnamescount = count($firstnames);
    
    foreach ($lastnames as $lastname) {
        $fullusernames[] = $lastname . ' ' . $firstnames[rand(0, $firstnamescount - 1)] . ' ' . uniqid();
    }
    
    
    return $fullusernames;
    
}

function generate_users() {
    global $CFG;
    
    $result = [];
    $lastnames = get_lastnames();
    $lastnamescount = count($lastnames);
    $emails = json_decode(file_get_contents($CFG->dirroot . '/user_generator/emails.json'));
    
    for ($counter = 0; $counter < 50; $counter++) {
        $record = new stdClass();
        $record->auth = 'manual';
        $record->username = 'username'.$counter;
        $record->firstname = get_firstname();
        $record->lastname = $lastnames[rand(0, $lastnamescount - 1)];
        $record->mnethostid = $CFG->mnet_localhost_id;
        $record->password = hash_internal_user_password('asdasdh78q23eu81221oieuyo89');
        $record->email = $emails[$counter];
        $record->confirmed = 1;
        $record->lastip = '0.0.0.0';
        $record->idnumber = '';
        $result[] = user_create_user($record, false, false);
    }
    
    return $result;
}

var_dump(generate_users());
