<?php

namespace App\Services;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Exception;
use Illuminate\Support\Facades\Http;

class WhatsAppService
{
   public function send()
   {
    $twilioSid = env('TWILIO_SID');
    $twilioAuthToken = env('TWILIO_AUTH_TOKEN');
    $twilioWhatsappNumber = 'whatsapp:'.env('TWILIO_WHATSAPP_NUMBER');
    // Get the recipient's WhatsApp number and message content from the request
    $to = 'whatsapp:'.auth()->user()->phone;
    $message = 'hi';
    // Create a new Twilio client using the SID and Auth Token
    $client = new Client($twilioSid, $twilioAuthToken);
    try {
     // Send the WhatsApp message using Twilio's API
     $message = $client->messages->create(
      $to,
      array(
       'from' => $twilioWhatsappNumber,
       'body' => $message
      )
     );
     // Return success message with the message SID for reference
     return "Message sent successfully! SID: " . $message->sid;
    } catch (Exception $e) {
      // Catch any errors and return the error message
     return "Error sending message: " . $e->getMessage();
    }
   }
   
}
