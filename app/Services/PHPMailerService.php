<?php
namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

class PHPMailerService
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        try {
            //  MODIFY THIS
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';  
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'punayhenryl17@gmail.com';
            $this->mailer->Password = 'zbxzhxeq ktpp mxac';
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = 587;

            $this->mailer->setFrom('noreply@gmail.com', 'baranggay');

     
            $this->mailer->SMTPDebug = 0; 
            $this->mailer->Debugoutput = function($str, $level) {
                Log::debug("PHPMailer debug level {$level}: {$str}");
            };
        } catch (Exception $e) {
            Log::error('Mailer setup failed: ' . $e->getMessage());
        }
    }

    /**
     * 
     *
     * @param string
     * @param string
     * @return bool
     */
    public function sendResetLinkEmail(string $toEmail, string $resetLink): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($toEmail);
            $this->mailer->isHTML(true);

            $this->mailer->Subject = 'Reset Your Admin Password';
            $this->mailer->Body = "
                <p>Hello,</p>
                <p>You requested a password reset. Click the link below to reset your password:</p>
                <p><a href='{$resetLink}'>Reset Password</a></p>
                <p>This link will expire in 60 minutes.</p>
                <p>If you did not request this, please ignore this email.</p>
                <br>
                <p>Regards,<br>HUNTERXHUNTER</p>
            ";

            $this->mailer->send();

            return true;
        } catch (Exception $e) {
            Log::error("Reset email failed to {$toEmail}: " . $e->getMessage());
            return false;
        }
    }
}
