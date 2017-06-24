<?php
/**
 *
 */
require("conn.class.php");
require('mailer/PHPMailerAutoload.php');
require("funzioni.php");
class Login{
    private $usr='';
    private $pwd='';
    private $dbConn;
    public $msg;
    private $str = PDO::PARAM_STR;
    private $int = PDO::PARAM_INT;
    function __construct(){
        $this->msg='';
        $this->dbConn = new Conn;
    }

    public function login($usr, $pwd){
        $sql = "SELECT * FROM usr where email='".$this->usr."' and attivo=1;";
        $row = $this->countRow($sql);
        if ($row>0) {
            $this->checkPwd($sql);
        }else{
            $this->msg = "Errore, la mail inserita non è presente nel database o non è scritta correttamente!";
        }
    }

    private function countRow($sql){
        $pdo = $this->dbConn->pdo();
        try {
            $row = $pdo->query($sql)->rowCount();
            return $row;
        } catch (Exception $e) {
            $this->msg =  "errore: ".$e->getMessage();
        }
    }
    private function checkPwd($sql){
        $pdo = $this->dbConn->pdo();
        $exec = $pdo->prepare($sql);
        try {
            $exec->execute();
            $utente = $exec->fetchAll(PDO::FETCH_ASSOC);
            $pwd =hash('sha512',$this->pwd . $utente[0]['salt']);
            if ($pwd === $utente[0]['pwd']) {
                $this->setSession($utente);
            }else{
                $this->msg= 'Errore, la password non è corretta!';
            }
        } catch (Exception $e) {
            $this->msg =  "errore: ".$e->getMessage();
        }
    }

    private function setSession($utente){
        $_SESSION['id']=$utente[0]['id'];
        $_SESSION['email']=$utente[0]['email'];
    }

    public function newUsr($email){
        $checkMail = $this->checkMail($email);
        if($checkMail===0){
            $genPwd = $this->genPwd();
            $pdo = $this->dbConn->pdo();
            $checkQuery = "insert into usr(email,salt,pwd) values (:email, :salt, :pwd);";
            $exec = $pdo->prepare($checkQuery);
            $exec->bindParam(":email", $email,$this->str);
            $exec->bindParam(":salt", $genPwd[0],$this->str);
            $exec->bindParam(":pwd", $genPwd[1],$this->str);
            try {
                $exec->execute();
                $oggetto = 'Nuovo account su eburum.com';
                $altBody = "Ciao,\nè stato creato un nuovo account sul sito di #Eburum - mappa di comunità, ed è stata indicata questa come mail principale, se non sei stato tu ad inviare la richiesta ignora questa mail e contatta l'amministratore del sistema all'indirizzo beppenapo@arc-team.com per segnalare una possibile violazione della tua mail.\nLa nuova password è : ".$genPwd[2]." \nTi consigliamo di cambiare la password temporanea.\n \nUn saluto dallo staff.";
                $body = file_get_contents('../mail/newUsrMail.html');
                $body = str_replace('%password%', $genPwd[2], $body);
                $out = $this->send($email,$row[0]['utente'],$oggetto,$body,$altBody);
                $this->msg=$out;
            } catch (PDOException $e) {
                $this->msg='Errore di sistema, non è stato possibile creare il nuovo account. Se di seguito visualizzi un messaggio di errore copialo e invialo a beppenapo@arc-team.com: '.$e->getMessage();
            }

        }else {
            $this->msg = 'Attenzione, la mail è già presente nel database!';
        }
    }

    private function genPwd($salt){
        $pwd = "";
        $pwdRand = array_merge(range('A','Z'), range('a','z'), range(0,9));
        for($i=0; $i < 10; $i++) {$pwd .= $pwdRand[array_rand($pwdRand)];}
        $key = '$2y$11$';
        $salt = substr(hash('sha512',uniqid(rand(), true).$key.microtime()), 0, 22);
        $password =hash('sha512',$pwd . $salt);
        return array($salt,$password,$pwd);
    }

    private function checkMail($email){
        $pdo = $this->dbConn->pdo();
        $checkQuery = "select email from usr where email = ?;";
        $exec = $pdo->prepare($checkQuery);
        $exec->bindParam(1, $email);
        try {
            $exec->execute();
            $row = $exec->fetchAll(PDO::FETCH_ASSOC);
            $count = count($row);
            return $count;
        } catch (PDOException $e) {
            $this->msg='Errore di sistema, non è stato possibile controllare la tua mail. Se di seguito visualizzi un messaggio di errore copialo e invialo a beppenapo@arc-team.com: '.$e->getMessage();
        }
    }

    private function send($email,$utente,$oggetto,$body,$altBody){
        $mail = new PHPMailer;
        $mail->isSMTP();
        //$mail->SMTPDebug = 2;
        //$mail->Debugoutput = 'html';
        $mail->Host = "smtps.aruba.it";
        $mail->Mailer = "smtp";
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@arc-team.com';
        $mail->Password = 'Arc-T3amV3';
        $mail->setFrom('info@arc-team.com', 'Arc-Team');
        $mail->addReplyTo('info@arc-team.com', 'Arc-Team');
        $mail->addAddress($email, $utente);
        $mail->Subject = $oggetto;
        $mail->isHTML(true);
        $mail->msgHTML($body, dirname(__FILE__));
        $mail->AltBody = $altBody;
        if (!$mail->send()) {
            return "Errore nell&apos;invio della mail!<br/>Se di seguito visualizzi un messaggio di errore, copialo ed invialo all&apos;amministratore di sistema - beppenapo@arc-team.com<br/>: " . $mail->ErrorInfo;
        }else {
            return "Ok, l'utente è stato creato e la nuova password è stata inviata alla mail di riferimento.";
        }
    }
}
?>
