<?php 

if(!defined('DS'))
{
    define( 'DS' , DIRECTORY_SEPARATOR );
}

class SSMail
{
    public $mail = null;
    private $head_mail_content = null;
    private $footer_mail_content = null;
    private $enable_header_footer = null;
    
    
    function __construct($smtp = true)
    {
        require_once DS.'var'.DS.'www'.DS.'html'.DS.'billing'.DS.'common_function'.DS.'PHPMailer'.DS.'class.phpmailer.php';
        require_once DS.'var'.DS.'www'.DS.'html'.DS.'billing'.DS.'common_function'.DS.'PHPMailer'.DS.'class.smtp.php';
        $this->mail = new PHPMailer();
       
        //$this->mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
        if($smtp)
        {
            $this->mail->IsSMTP();
            $this->mail->Host       = "49.50.68.17";    // sets the SMTP server
            $this->mail->Port       = 25;
            $this->mail->SMTPDebug  = 2;                // enables SMTP debug information (for testing)
            // 1 = errors and messages
            // 2 = messages only
            // $this->mail->SMTPAuth   = true;         // enable SMTP authentication */
            // $this->mail->Port       = 587;          // set the SMTP port for the GMAIL server
            // $this->mail->Username   = "";               // SMTP account username
            // $this->mail->Password   = "";               // SMTP account password */
            // $mailfrom = "avtech.digi@gmail.com";
            // $this->mail->setFrom($mailfrom,"Report"); 
            // $this->mail->addReplyTo($mailfrom);

        }
        //return $this->mail;
        $this->enable_header_footer = 0;
        
        
        $this->head_mail_content = '';
        /*          <style>
            #mail_header{text-align:right;}
            #logo_container{ width:30%;display:inline-block; }
            #header_msg{display: inline-block;color: white;vertical-align: top;  padding: 21px 0px;  font-weight: bold;  font-size: 18px;}
        </style>
        <div id="mail_header" >
                <div id="logo_container"><img src="" /></div>    
        </div>' ;*/
        /*
        $this->footer_mail_content = "<style>
           div#footer_strip {background: rgb(101, 111, 118);height: 100px;margin: 10px 0px;color: white;}
           div#footer_strip_txt { padding: 44px 0 0 5px;font-size: 16px;}
       </style>
       <div id ='mail_footer' >
           <hr/>
           <div style='font-style: italic;color:lightgrey;' >
           <div style='text-align:center;' >******************************This is a system generated response******************************</div>
           Please do not reply or revert back on this mail. Any response for this mail will not be entertained.
           It is strictly advised to not modify the content of this mail. Any modification in this mail content can be considered as tampering of data.<br/>
           </div>
           
           <div id='footer_strip' >
               <div id='footer_strip_txt' >
                 
          </div>         
                   
       </div>";
       */
    }
    
    function disableHeaderFooter()
    {
        $this->enable_header_footer = 0;
    }
    
    function setHeader($txt)
    {
        $this->head_mail_content = $txt ;
        
    }

    function getHeader()
    {
        return $this->head_mail_content ;
    }
    
    
    
    function setFooter($txt)
    {
        $this->footer_mail_content = $txt ;
        
    }

    function getFooter()
    {
        return $this->footer_mail_content ;
    }
    
    
    
      /*
     * cc,bcc,to : 
     *          //Single
     *          array(array('addr' => 'mail@theshilpashetty.com' , 'name' => 'Name') )
     *          //Multiple
     *          array(
     *               '0' =>array('addr' => 'mail@ss.com' , 'name' => 'Name'),
     *               '1' =>array('addr' => 'mail@theshilpashetty.com' , 'name' => 'Name')
     *          )  
     * from : array('addr' => 'mail@theshilpashetty.com' , 'name' => 'Name');
     * attachments : //single
     *                  "Path to attachment"
     *              // Multiple
     *              array( 'path1' , 'path2' , 'path3')
     * subject : 'simple text'
     * content : can be html or plain text
     
     * $SSMail = new SSMail();
     * $SSMail->sendMail($to, $from, $subject, $content{, {$cc= array()}, {$bcc=array()}, {$attachments=array()}} )
     *  */
    function sendMail($to, $from, $subject, $content, $cc= array(), $bcc=array(), $attachments=array() )
    {
        if(!is_array($to)){ $to = array($to); }
        if(!is_array($from)){ $from = array($from); }
        if(!is_array($cc)){ $cc = array($cc); }
        if(!is_array($bcc)){ $bcc = array($bcc); }
        if(!is_array($attachments)){ $attachments = array($attachments); }
        
        if($this->enable_header_footer == 1)
        {
            $content = $this->head_mail_content. $content. $this->footer_mail_content ;
        }
        
        
       try{
       
           $this->mail->Subject    = $subject;
           $this->mail->MsgHTML($content);
     
        
            /*Adding FROM*/
             if(!empty($from))
            {
                    $email_from = trim(@$from['addr']);
                    $name_from = trim(@$from['name']);
                    $this->mail->SetFrom($email_from, $name_from);  
            }
            /**/


            /*Adding TO*/
             if(!empty($to))
            {
                $to_cnt = count($to);
                $to_counter = 0;
                for($to_counter; $to_counter < $to_cnt ;$to_counter++ )
                {   
                    $email_to = trim(@$to[$to_counter]['addr']);
                    $name_to = trim(@$to[$to_counter]['name']);
                    $this->mail->AddAddress($email_to, $name_to);  
                }
            }
            /**/


            /*Adding CC*/
             if(!empty($cc))
            {
                $cc_cnt = count($cc);
                $cc_counter = 0;
                for($cc_counter; $cc_counter < $cc_cnt ;$cc_counter++ )
                {   
                    $email_cc = trim(@$cc[$cc_counter]['addr']);
                    $name_cc = trim(@$cc[$cc_counter]['name']);

                    $this->mail->AddCC($email_cc, $name_cc);  
                }
            }
            /**/


            /* Adding BCC */
            if(!empty($bcc))
            {
                $bcc_cnt = count($bcc);
                $bcc_counter = 0;
                for($bcc_counter; $bcc_counter < $bcc_cnt ;$bcc_counter++ )
                {   
                    $email_bcc = trim(@$bcc[$bcc_counter]['addr']);
                    $name_bcc = trim(@$bcc[$bcc_counter]['name']);

                    $this->mail->AddBCC($email_bcc, $name_bcc);  
                }
            }
            /**/


            /* Adding Attachments */
            if(!empty($attachments))
            {   
                $attachments_cnt = count($attachments);
                $attachments_counter = 0;
                for($attachments_counter; $attachments_counter < $attachments_cnt ;$attachments_counter++ )
                {
                    $this->mail->AddAttachment($attachments[$attachments_counter]);  
                }
            }
            /**/

        
            //return $this->mail;
            $this->mail->Send();
            return true;
        }catch (phpmailerException $e){ return $e->errorMessage(); /*Pretty error messages from PHPMailer  */ }
        catch (Exception $e) { return $e->getMessage(); /*Boring error messages from anything else! */   }
        return false;
      }
    
    
}



/* $send = trim($_REQUEST['send'] ); */
/*
$SSMail = new SSMail();

$send = $argv[1]; 
if( empty( $send ) )
{
    return;
}


$cc= array(); $bcc=array();$attachments=array() ;
$from = array('addr' => 'noreply@theshilpashetty.com' , 'name' => 'The Shilpa Shetty APP');


$subject = 'Sample SMTP Test Mail';
$content = "<p><b>Hi User,</b><br/>"
        . "<div>Sample content body</div><br/>"
        . "<p>Thanks & Regards,<br/>SMTP Mail Server</p>"
        . "</p>";


if( $send == "1")
{
    
    echo "<br/>In SEnd : 1<br/>";
   $result =  $SSMail->sendMail(array(array('addr' => 'noreply@theshilpashetty.com' , 'name' => 'Mayur Tanwar')),
                            $from,$subject,$content);
    Var_dump($result);
}

if( $send == "2")
{
    $to = array(
        '0' => array('addr' => 'noreply@theshilpashetty.com' , 'name' => 'Mayur Tanwar'),
        '1' => array('addr' => 'noreply@theshilpashetty.com' , 'name' => 'Akshay Chavan')
        
    );
    $cc = array(array('addr' => 'noreply@theshilpashetty.com' , 'name' => 'Sandip Dalvi'));
    $bcc = array(array('addr' => 'noreply@theshilpashetty.com' , 'name' => 'Chandra Mer'));

    $attachments = "/tmp/mail/test.txt";
    
    $result =  $SSMail->sendMail($to, $from, $subject, $content, $cc, $bcc, $attachments );
    Var_dump($result);
}


if( $send == "3")
{
    $to = array(
        '0' => array('addr' => 'noreply@theshilpashetty.com' , 'name' => 'Mayur Tanwar'),
        '1' => array('addr' => 'noreply@theshilpashetty.com' , 'name' => 'Akshay Chavan')
        
    );
    $cc = array(array('addr' => 'noreply@theshilpashetty.com' , 'name' => 'Sandip Dalvi'));
    $bcc =array(array('addr' => 'noreply@theshilpashetty.com' , 'name' => 'Chandra Mer'));
    
    $attachments = array("/tmp/mail/test.txt", "/tmp/mail/Screenshot from 2015-05-11 16:16:11.png", "MetaSea Publisher API MS20140604.pdf", "/tmp/mail/CMT_For_Woo_World_200415.csv" );
    
    $result = $SSMail->sendMail($to, $from, $subject, $content, $cc, $bcc, $attachments );
    Var_dump($result);
}
*/ 
?>
