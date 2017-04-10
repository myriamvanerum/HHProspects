<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Pagina gecodeerd door Sven Gunther
 * Authex library
 * @brief functionaliteit voor sessions aan te maken en inloggen
 * @author Sven Swennen en Gunther Meert
 */
//***************************Sven Swennen********************************
class Authex {

    // +----------------------------------------------------------
    // | PhP-Project a3
    // +----------------------------------------------------------
    // | KHK - 2 TI 3 - 2015-2016
    // +----------------------------------------------------------
    // | Authex library
    // |
    // +----------------------------------------------------------
    // | Nelson Wells
    // | http://nelsonwells.net/2010/05/creating-a-simple-extensible-codeigniter-authentication-library/
    // | aangepast door Sven Swennen
    // +----------------------------------------------------------

    public function __construct() {
        $CI = & get_instance();
//        $CI->load->model('Wachtwoord_model');
//        $CI->load->model('Login_model');
//        $CI->load->model('Gebruikersnaam_model');
        $CI->load->helper('string');
    }

    /**
     * Sven Swennen wachtwoord vergeten functions
     * checken of login gegevens kloppen
     */
//    function login($emailadres, $wachtwoord) {
//
//        /**
//         *  gebruiker aanmelden met opgegeven email en wachtwoord
//         */
//        $CI = & get_instance();
//        $gebruiker = $CI->Login_model->getGebruiker($emailadres, $wachtwoord);
//
//        $CI->session->set_userdata("totaalVoorschot", 0);
//        $CI->session->set_userdata("totaalBedrag", 0);
//
//        if ($gebruiker == null) {
//            return false;
//        } else {
//            $CI->Login_model->updateLaatstAangemeld($gebruiker->id);
//            $CI->session->set_userdata('gebruiker_id', $gebruiker->id);
//            return true;
//        }
//    }
//
//    /**
//     * gebruikers id via sessions controleren
//     */
//    function loggedIn() {
//        // gebruiker is aangemeld als sessievariabele user_id bestaat
//        $CI = & get_instance();
//        if ($CI->session->userdata('gebruiker_id')) {
//            return true;
//        } else {
//            return false;
//        }
//    }
//    /**
//         *  geef user-object als gebruiker aangemeld is
//         */
//    function getUserInfo() {
//
//        $CI = & get_instance();
//        if (!$this->loggedIn()) {
//            return null;
//        } else {
//            $id = $CI->session->userdata('gebruiker_id');
//            return $CI->Login_model->get($id);
//        }
//    }
//
//    /**
//     * sessnion id verwijderen
//     */
//    function logout() {
//        // uitloggen, dus sessievariabele wegdoen
//        $CI = & get_instance();
//        $CI->load->model('Inschrijving_model');
//        $CI->Inschrijving_model->deleteBijGebruiker($CI->session->userdata('gebruiker_id'));
//        $CI->session->sess_destroy();
//    }
//
//    /**
//     * controleren of het email adres bestaat, zo ja dan een willekeurig password genereren voor de link die je aankrijgt via mail
//     */
//    function controle($emailadres) {
//        $CI = & get_instance();
//
//        if ($CI->Wachtwoord_model->email_bestaat($emailadres)) {
//            $password = sha1($emailadres);
//            $this->sendRecoverymail($emailadres, $password);
//            //$this->geefLinkWeer($emailadres, $password);
//            return true;
//        } else {
//            return false;
//        }
//    }
//
//    /**
//     * mail versturen met een link erin die gaat naar de reset_wachtwoord functie
//     */
//    function sendRecoverymail($emailadres, $password) {
//
//        $CI = & get_instance();
//        $CI->email->from('r0578968@thomasmore.be', 'Sven Swennen');
//        $CI->email->to($emailadres);
//        $CI->email->subject('Nieuw paswoord');
//        $CI->email->message('Klik op deze link voor het aanpassen van je wachtwoord: ' . anchor(base_url() . 'hhprospects.php/Wachtwoord/reset_wachtwoord/' . $emailadres . '/' . $password, 'klik hier'));
//        $CI->email->send();
//        echo $CI->email->print_debugger();
//    }
//
//    /**
//     * nieuw wachtwoord aanmaken in de db voor een gebruiker met sha1 ter beveiliging
//     */
//    function update_wachtwoord($emailadres, $wachtwoord1) {
//        $CI = & get_instance();
//        $id = $CI->Wachtwoord_model->resetPassword($emailadres, $wachtwoord1);
//        //return $id;
//    }
//
//    /**
//     * Sven Swennen gebruikersnaam vergeten
//     * kijken of het opgegeven email adres bij de gebruikersnaam_vergeten wel in de db voorkomt
//     */
//    function gebruikersnaam_controle($emailadres) {
//        $CI = & get_instance();
//
//        if ($CI->Gebruikersnaam_model->email_bestaat($emailadres)) {
//            $gebruikersnaam = $CI->Gebruikersnaam_model->getGebruikersnaam($emailadres);
//            $this->gebruikersnaam_mail($emailadres, $gebruikersnaam);
//            return true;
//        } else {
//            return false;
//        }
//    }
//
//    /**
//     * mail versturen met daarin de gebruikersnaam van het bijhorende email adres
//     */
//    function gebruikersnaam_mail($emailadres, $gebruikersnaam) {
//
//        $CI = & get_instance();
//        $CI->email->from('r0578968@student.thomasmore.be', 'Sven Swennen');
//        $CI->email->to($emailadres);
//        $CI->email->subject('Gebruikersnaam');
//        $CI->email->message('uw gebruikersnaam is ' . $gebruikersnaam->gebruikersnaam);
//        $CI->email->message('u kan op deze link klikken om terug naar de inlogpagina te gaan ' . anchor('Inloggen/inlogscherm', 'klik hier'));
//        $CI->email->send();
//        echo $CI->email->print_debugger();
//    }

}
