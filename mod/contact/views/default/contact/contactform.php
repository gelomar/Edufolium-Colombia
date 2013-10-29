<?php elgg_get_plugin_setting('email', 'contact'); 
?>

<?PHP
/*
    Contact Form from HTML Form Guide
    This program is free software published under the
    terms of the GNU Lesser General Public License.
    See this page for more info:
    http://www.html-form-guide.com/contact-form/creating-a-contact-form.html
*/

require_once("./include/fgcontactform.php");
require_once("./include/simple-captcha.php");
$email=elgg_get_plugin_setting('email','contact');
$formproc = new FGContactForm();
$sim_captcha = new FGSimpleCaptcha('scaptcha');

$formproc->EnableCaptcha($sim_captcha);

//1. Add your email address here.
//You can add more than one receipients.
 $formproc->AddRecipient($email); //<<---Put your email address here

//2. For better security. Get a random tring from this link: http://tinyurl.com/randstr
// and put it here
$formproc->SetFormRandomKey('CnRrspl1FyEylUj');


if(isset($_POST['submitted']))
{
   if($formproc->ProcessForm())
   {
        $formproc->RedirectToURL("thank-you.php");
   }
}

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">


<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Contact us</title>
      <link rel="STYLESHEET" type="text/css" href="contact.css" />
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
</head>
<body>
<!-- Form Code Start -->
<form id='contactus' action='<?php echo $formproc->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
<fieldset>
<legend>Contactar a EduFolium</legend>

<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='<?php echo $formproc->GetFormIDInputName(); ?>' value='<?php echo $formproc->GetFormIDInputValue(); ?>'/>
<input type='hidden'  class='spmhidip' name='<?php echo $formproc->GetSpamTrapInputName(); ?>' />

<label> * Campos Requeridos</label>
<div><span class='error'><?php echo $formproc->GetErrorMessage(); ?></span></div>
<fieldset>
<div class="container">
    <input name="name" id="name" maxlength="50" type="text" placeholder="Su Nombre Completo*:" required>
    <span id="contactus_name_errorloc" class="error"></span>
</div>
<div class="container">
    <input name="email" id="email" maxlength="50" type="email" placeholder="Correo Electrónico*:" required>
    <span id="contactus_email_errorloc" class="error"></span>
</div>
<div class="container">
    <input name="phone" id="phone" maxlength="15" type="text" placeholder="Número Telefónico:">
    <span id="contactus_phone_errorloc" class="error"></span>
</div>
<div class="container">
    <span id="contactus_message_errorloc" class="error"></span>
    <textarea rows="10" cols="50" name="message" id="message" placeholder="Mensaje:" required></textarea>
</div>
</fieldset>
<fieldset id='antispam'>
<legend >Pregunta Anti-spam </legend>
<span class='short_explanation'>(Por favor responda la siguiente pregunta. Esto nos ayuda a prevenir spam)</span>
<div class='container'>
    <label for='scaptcha' ><?php echo $sim_captcha->GetSimpleCaptcha(); ?></label>
    <input type='text' name='scaptcha' id='scaptcha' maxlength="10" /><br/>
    <span id='contactus_scaptcha_errorloc' class='error'></span>
</div>
</fieldset>

<div class='container'>
    <input type='submit' name='Submit' value='Submit' />
</div>

</fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->

<script type='text/javascript'>
// <![CDATA[

    var frmvalidator  = new Validator("contactus");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();
    frmvalidator.addValidation("name","req","Please provide your name");

    frmvalidator.addValidation("email","req","Please provide your email address");

    frmvalidator.addValidation("email","email","Please provide a valid email address");

    frmvalidator.addValidation("message","maxlen=2048","The message is too long!(more than 2KB!)");


    frmvalidator.addValidation("scaptcha","req","Please answer the anti-spam question");





// ]]>
</script>
</body>
</html>

