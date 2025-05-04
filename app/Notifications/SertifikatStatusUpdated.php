<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Sertifikat;

class SertifikatStatusUpdated extends Notification
{
    use Queueable;

    protected $sertifikat;

    public function __construct(Sertifikat $sertifikat)
    {
        $this->sertifikat = $sertifikat;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $status = $this->sertifikat->status === 'valid' ? 'disetujui' : 'ditolak';
        
        return (new MailMessage)
            ->subject('Status Sertifikat Anda Telah Diperbarui')
            ->line('Status sertifikat Anda telah diperbarui.')
            ->line("Sertifikat Anda telah {$status}.")
            ->when($this->sertifikat->alasan_penolakan, function ($message) {
                return $message->line('Alasan: ' . $this->sertifikat->alasan_penolakan);
            })
            ->action('Lihat Detail', route('sertifikat.show', $this->sertifikat))
            ->line('Terima kasih telah menggunakan layanan kami.');
    }
}