<?php
namespace App\Mail;

use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WithdrawalProcessingMail extends Mailable
{
    use SerializesModels;

    public $withdrawal;
    public $user;

    public function __construct(Withdrawal $withdrawal, User $user)
    {
        $this->withdrawal = $withdrawal;
        $this->user = $user;

    }

    public function build()
    {
        return $this->subject('Withdrawal Request Received')
                    ->markdown('mail.withdrawal-processing',
                        [
                            'withdrawal' => $this->withdrawal,
                            'user' => $this->user,
                        ]
                    );
    }
}
