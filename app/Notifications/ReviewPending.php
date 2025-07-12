<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\CsrAssessment;

class ReviewPending extends Notification
{
    use Queueable;

    protected $assessment;

    public function __construct(CsrAssessment $assessment)
    {
        $this->assessment = $assessment;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('CSR Assessment Menunggu Review')
            ->line('Ada penilaian CSR baru yang menunggu review.')
            ->line('Perusahaan: ' . $this->assessment->company->name)
            ->line('Indikator: ' . $this->assessment->indicator->name)
            ->action('Review Sekarang', url('/assessments/' . $this->assessment->id))
            ->line('Terima kasih atas perhatiannya!');
    }

    public function toArray($notifiable)
    {
        return [
            'assessment_id' => $this->assessment->id,
            'company_name' => $this->assessment->company->name,
            'indicator_name' => $this->assessment->indicator->name,
            'created_at' => $this->assessment->created_at
        ];
    }
}
