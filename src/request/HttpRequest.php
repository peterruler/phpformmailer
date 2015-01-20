<?php
namespace ch\keepitnative\formmailer\src\request;

require_once 'Request.php';

class HttpRequest implements Request {

    private $parameters;

    public static function cleanInput($post) {
        //inputcleaning
        return \htmlentities(\strip_tags(\addslashes($post)),ENT_QUOTES,'UTF-8');
    }

    public function __construct() {

        //$this->parameters = $_REQUEST;
        $this->parameters = array_map(array(__CLASS__,'cleanInput'), $_REQUEST);
    }

    public function issetParameter($name) {
        return isset($this->parameters[$name]);
    }

    public function unsetParameter($name) {
        unset($this->parameters[$name]);
    }

    public function getParameter($name) {
        if (isset($this->parameters[$name])) {
            return $this->parameters[$name];
        }
        return null;
    }

    public function getParameterNames() {
        return array_keys($this->parameters);
    }

    public function getHeader($name) {
        $name = 'HTTP_' . strtoupper(str_replace('-', '_', $name));
        if (isset($_SERVER[$name])) {
            return $_SERVER[$name];
        }
        return null;
    }

    public function getPostData()
    {

        $msgArr = array();

        $msgArr['Email'] = $this->getParameter('email');
        $msgArr['Nachname'] = $this->getParameter('nachname');
        $msgArr['Vorname'] = $this->getParameter('vorname');
        $msgArr['Strassenr'] = $this->getParameter('strassenr');
        $msgArr['Plzort'] = $this->getParameter('plzort');
        $msgArr['Telefon'] = $this->getParameter('telefon');
        $msgArr['Bemerkungen'] = $this->getParameter('bemerkungen');

        switch ($this->getParameter('format')) :
            case 1 :
                $formatTxt = "Nur Text";
                break;
            case 2:
                $formatTxt = "Nur Bild";

                break;
            case 3:
                $formatTxt = "Bild und Text";
                break;
        endswitch;

        $msgArr['Format'] = $formatTxt;

        $msgArr['Groesse'] = $this->getParameter('groesse');

        switch ($this->getParameter('art')) :
            case 1 :
                $artTxt = "Whatever";
                break;
            case 2:
                $artTxt = "Whatelse";
                break;
        endswitch;

        $msgArr['Art'] = $artTxt;
        return $msgArr;
    }
}
?>
