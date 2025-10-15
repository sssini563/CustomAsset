<?php
namespace App\Mail;

use App\Models\Document;
use App\Models\DocumentSignature;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocumentSignatureLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public Document $document;
    public DocumentSignature $signature;
    public string $link;

    public function __construct(Document $document, DocumentSignature $signature, string $link)
    {
        $this->document = $document;
        $this->signature = $signature;
        $this->link = $link;
    }

    public function build()
    {
        return $this->subject('Signature Request: '.$this->document->document_number)
            ->view('emails.documents.signature-link');
    }
}
