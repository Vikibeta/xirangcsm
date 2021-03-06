<?php
/**
 * The model file of mail module of XiRangCSM.
 *
 * @copyright   Copyright 2009-2011 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     mail
 * @version     $Id: model.php 1914 2011-06-24 10:11:25Z yidong@cnezsoft.com $
 * @link        http://www.zentao.net
 */
?>
<?php
class mailModel extends model
{
    private static $instance;
    private $mta;
    private $mtaType;
    private $errors = array();

    public function __construct()
    {
        parent::__construct();
        $this->app->loadClass('phpmailer', $static = true);
        $this->setMTA();
    }

    /**
     * Set MTA.
     * 
     * @access public
     * @return void
     */
    public function setMTA()
    {
        if(self::$instance == null) self::$instance = new phpmailer(true);
        $this->mta = self::$instance;
        $this->mta->CharSet = $this->config->encoding;
        $funcName = "set{$this->config->mail->mta}";
        if(!method_exists($this, $funcName)) echo $this->app->error("The MTA {$this->config->mail->mta} not supported now.", __FILE__, __LINE__, $exit = false);
        $this->$funcName();
    }

    /**
     * Set smtp.
     * 
     * @access private
     * @return void
     */
    private function setSMTP()
    {
        $this->mta->isSMTP();
        $this->mta->SMTPDebug = $this->config->mail->smtp->debug;
        $this->mta->Host      = $this->config->mail->smtp->host;
        $this->mta->SMTPAuth  = $this->config->mail->smtp->auth;
        $this->mta->Username  = $this->config->mail->smtp->username;
        $this->mta->Password  = $this->config->mail->smtp->password;
        if(isset($this->config->mail->smtp->port)) $this->mta->Port = $this->config->mail->smtp->port;
        if(isset($this->config->mail->smtp->secure) and !empty($this->config->mail->smtp->secure))$this->mta->SMTPSecure = strtolower($this->config->mail->smtp->secure);
    }

    /**
     * PHPmail.
     * 
     * @access private
     * @return void
     */
    private function setPhpMail()
    {
        $this->mta->isMail();
    }

    /**
     * Sendmail.
     * 
     * @access private
     * @return void
     */
    private function setSendMail()
    {
        $this->mta->isSendmail();
    }

    /**
     * Gmail.
     * 
     * @access private
     * @return void
     */
    private function setGMail()
    {
        $this->mta->isSMTP();
        $this->mta->SMTPDebug  = $this->config->mail->gmail->debug;
        $this->mta->Host       = 'smtp.gmail.com';
        $this->mta->Port       = 465;
        $this->mta->SMTPSecure = "ssl";
        $this->mta->SMTPAuth   = true;
        $this->mta->Username   = $this->config->mail->gmail->username;
        $this->mta->Password   = $this->config->mail->gmail->password;
    }

    /**
     * Send email
     * 
     * @param  array   $toList 
     * @param  string  $subject 
     * @param  string  $body 
     * @param  array   $ccList 
     * @access public
     * @return void
     */
    public function send($toList, $subject, $body = '', $ccList = '')
    {
        if(!$this->config->mail->turnon) return;

        /* Get realname and email of users. */
        $this->loadModel('user');
        $emails = $this->user->getRealNameAndEmails(str_replace(' ', '', $toList . ',' . $ccList));
        
        $this->clear();

        try 
        {
            $this->mta->setFrom($this->config->mail->fromAddress, $this->config->mail->fromName);
            $this->setSubject($subject);
            $tomails = $this->setTO($toList, $emails);
            $ccmails = empty($ccList) ? array() : $this->setCC($ccList, $emails);
            $this->setBody($body);
            $this->setErrorLang();
            if($tomails or $ccmails) $this->mta->send();
        }
        catch (phpmailerException $e) 
        {
            $this->errors[] = trim(strip_tags($e->errorMessage()));
        } 
        catch (Exception $e) 
        {
            $this->errors[] = trim(strip_tags($e->getMessage()));
        }
    }

    /**
     * Set to address
     * 
     * @param  array    $toList 
     * @param  array    $emails 
     * @access private
     * @return void
     */
    private function setTO($toList, $emails)
    {
        $toList = explode(',', str_replace(' ', '', $toList));
        foreach($toList as $id)
        {
            if(!isset($emails[$id]) or isset($emails[$id]->sended) or strpos($emails[$id]->email, '@') == false)
            {
                unset($emails[$id]);
                continue;
            }
            $this->mta->addAddress($emails[$id]->email, $emails[$id]->realname);
            $emails[$id]->sended = true;
        }
        return $emails;
    }

    /**
     * Set cc.
     * 
     * @param  array    $ccList 
     * @param  array    $emails 
     * @access private
     * @return void
     */
    private function setCC($ccList, $emails)
    {
        $ccList = explode(',', str_replace(' ', '', $ccList));
        if(!is_array($ccList)) return;
        foreach($ccList as $id)
        {
            if(!isset($emails[$id]) or isset($emails[$id]->sended) or strpos($emails[$id]->email, '@') == false)
            {
                unset($emails[$id]);
                continue;
            }
            $this->mta->addCC($emails[$id]->email, $emails[$id]->realname);
            $emails[$id]->sended = true;
        }
        return $emails;
    }

    /**
     * Set subject 
     * 
     * @param  string    $subject 
     * @access private
     * @return void
     */
    private function setSubject($subject)
    {
        $this->mta->Subject = stripslashes($subject);
    }

    /**
     * Set body.
     * 
     * @param  string    $body 
     * @access private
     * @return void
     */
    private function setBody($body)
    {
        $this->mta->msgHtml("$body");
    }

    /**
     * Set error lang. 
     * 
     * @access private
     * @return void
     */
    private function setErrorLang()
    {
        $this->mta->SetLanguage($this->app->getClientLang());
    }
   
    /**
     * Clear.
     * 
     * @access private
     * @return void
     */
    private function clear()
    {
        $this->mta->clearAddresses();
        $this->mta->clearAttachments();
    }

    /**
     * Is error?
     * 
     * @access public
     * @return bool
     */
    public function isError()
    {
        return !empty($this->errors);
    }

    /**
     * Get errors. 
     * 
     * @access public
     * @return void
     */
    public function getError()
    {
        $errors = $this->errors;
        $this->errors = array();
        return $errors;
    }
}
