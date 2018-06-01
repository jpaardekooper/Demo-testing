<?php
//https://stackoverflow.com/questions/15965376/how-to-configure-xampp-to-send-mail-from-localhost
if (isset($_POST["submit"])) {


    $to = $_POST["email"];
    $naam = trim($_POST["firstname"]);
    $subject = "Aanvraag afspraak door " . $naam;

    $message = "Beste " . $naam . ",\r\n
		Er is een nieuwe update voor u beschikbaar. Login op sqitsframework.nl\r\n
		Met vriendelijke groet,\r
		SqitsTeammzz";

    $headers = 'From: info@Sqitszir.com' . "\r\n" .
        'Reply-To: info@Sqitszir.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    $headers .= 'Bcc: info@Sqitszir.com' . "\r\n";



    mail($to, $subject, $message, $headers);
    echo('	
		
				
				<div class="right-panel">
					
					    <h1 id="formtitle">Message sent</h1>
					    <p id="formdesc">Your message was sent. You will quickly receive a confirmation email. If you didn\'t receive the confirmation email within 5 minutes, please check your spam folder.
					    </p>
			
				</div>
	
		');
} else {
    ?>

        <div class="right-panel">
            <h1 id="formtitle">Contact</h1>
            <p id="formdesc">Feel free to contact us regarding any questions or concerns you have. We guarantee respond to your message within 48 hours.</p>

            <div id="formcontainer">
                <form method="post">
                    <input type="text" placeholder="Your full name" required="required" name="firstname">
                    <input type="email" placeholder="Your email address" required="required" name="email">
                    <select name="product" required="required">
                        <option value="">Reason of writing</option>
                        <option value="1">Need to know</option>
                        <option value="2">Suggestion</option>
                        <option value="3">Complaint</option>
                    </select>
                    <textarea required="required" name="reason" placeholder="Your message"></textarea>
                    <br />
                    <input type="submit" name="submit" value="Submit" id="submitform">
                </form>
            </div>

        </div>

    <?php
}
?>