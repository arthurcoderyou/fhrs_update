<?php

namespace App\Livewire\Setting;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;
use Exception;

class WhatsappMessagingSettings extends Component
{

    public string $phone = '';
    public string $message = ''; 
  
    public function updated($fields){ 

        $this->validateOnly($fields,[
            
            'phone' => ['required', ],
            'message' => ['required', ], 
        ]);

    }

     
 
    /**
     * Handle record save
     */
    public function save()
    {

 


        $this->validate([
            
            'phone' => ['required', ],
            'message' => ['required', ], 
        ]);

        /*
        // Note: Both 'from' and 'to' numbers should be formatted as:
        // whatsapp:+CountryCodePhoneNumber (e.g., whatsapp:+123456789)
        // Get Twilio credentials and WhatsApp number from environment variables
        $twilioSid = env('TWILIO_SID');
        $twilioAuthToken = env('TWILIO_AUTH_TOKEN');
        $twilioWhatsappNumber = 'whatsapp:'.env('TWILIO_WHATSAPP_NUMBER');
        // Get the recipient's WhatsApp number and message content from the request
        $to = 'whatsapp:'.$this->phone;
        $message = $this->message;
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
            // return "Message sent successfully! SID: " . $message->sid;

            session()->flash('alert.success', "Message sent successfully! SID: " . $message->sid);
            // return redirect()->back();
            // abort(403, 'Unauthorized.');

            return redirect()->route('setting.whatsapp.edit');

        } catch (Exception $e) {
            // Catch any errors and return the error message
            // return "Error sending message: " . $e->getMessage();
              // For error message
            session()->flash('alert.error', $e->getMessage());
            // return redirect()->back();
            // abort(403, 'Unauthorized.');

            return redirect()->route('setting.whatsapp.edit');
        } 
        */

        try {
            $params=array(
                'token' => '2adokm305iyvjkbj',
                'to' => $this->phone,
                'body' => $this->message,
            );


            
            $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.ultramsg.com/instance122258/messages/chat",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => http_build_query($params),
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded"
                ),
            ));

            $response = curl_exec($curl);
            $responseData = json_decode($response, true);
            $messageId = $responseData['id'] ?? null;

            curl_close($curl);


            $statusUrl = "https://api.ultramsg.com/instance122258/messages?token=2adokm305iyvjkbj&limit=1&id={$messageId}";

            $statusCurl = curl_init();
            curl_setopt_array($statusCurl, [
                CURLOPT_URL => $statusUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ]);

            $statusResponse = curl_exec($statusCurl);
            $statusError = curl_error($statusCurl);
            curl_close($statusCurl);

            $statusData = json_decode($statusResponse, true);
 
            if ($statusError) {
                session()->flash('alert.error', "Status check failed: $statusError");
            } elseif (!empty($statusData[0]['status']) && $statusData[0]['status'] === 'sent') {
                session()->flash('alert.success', 'Message sent successfully!');
            } else {
                $status = $statusData[0]['status'] ?? 'unknown';
                // session()->flash('alert.error', "Message failed. Status: $status : $responseData ");
                session()->flash('alert.error', "Message failed. Status: $status : " . json_encode($responseData));

                ///
                // Message failed. Status: unknown : {"sent":"true","message":"ok","id":11}
                // Message failed. Status: unknown : {"sent":"true","message":"ok","id":12}





            }

            return redirect()->route('setting.whatsapp.edit');

        } catch (Exception $e) {
            // Catch any errors and return the error message
            // return "Error sending message: " . $e->getMessage();
              // For error message
            session()->flash('alert.error', $e->getMessage());
            // return redirect()->back();
            // abort(403, 'Unauthorized.');

            return redirect()->route('setting.whatsapp.edit');
        } 
      

 
    }


    

 

    public function render()
    {
        return view('livewire.setting.whatsapp-messaging-settings')
        ->layout('layouts.app'); // <--- This sets the layout!
    }
}
