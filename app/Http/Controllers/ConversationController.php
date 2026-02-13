<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Auth;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:product_query'])->only('index');
    }

    public function index()
    {
        if (get_setting('conversation_system') == 1) {
            $conversations = Conversation::where('sender_id', Auth::user()->id)->orWhere('receiver_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
            return view('backend.conversations.index', compact('conversations'));
        } else {
            flash(translate('Conversation is disabled at this moment'))->warning();
            return back();
        }
    }

    public function show($id)
    {
        $conversation = Conversation::findOrFail(decrypt($id));
        if ($conversation->sender_id == Auth::user()->id) {
            $conversation->sender_viewed = 1;
        } elseif ($conversation->receiver_id == Auth::user()->id) {
            $conversation->receiver_viewed = 1;
        }
        $conversation->save();
        return view('backend.conversations.show', compact('conversation'));
    }

    # add new message
    public function storeMessage(Request $request)
    {
        $message = new Message();
        $message->conversation_id = $request->conversation_id;
        $message->user_id = Auth::user()->id;
        $message->message = $request->message;
        $message->save();
        $conversation = $message->conversation;
        if ($conversation->sender_id == Auth::user()->id) {
            $conversation->sender_viewed = "1";
            $conversation->receiver_viewed = "0";
        } elseif ($conversation->receiver_id == Auth::user()->id) {
            $conversation->sender_viewed = "0";
            $conversation->receiver_viewed = "1";
        }
        $conversation->save();
        flash(translate('Message has been sent'))->success();
        return back();
    }
	public function aiStoreSonia(Request $request)
    {
        $curl = curl_init();

        if ($request->user_role == "sonia") {
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "model": "gpt-4-turbo-preview",
                    "temperature": 0.8,
                    "messages": [
                        {"role": "system", "content": "Nama anda Sonia, \'AI CS Support\' *SonusHUB* (perusahaan energi baru). Asisten harus sopan, ramah, lucu (emot), menyesuaikan kultur indonesia (Sobat Sonus), kurs: IDR"},
                        {"role": "system", "content": "Jika ada pertanyaan produk energi baru kunjungi sonus.id atau hubungi admin."},
                        {"role": "system", "content": "Anda memiliki adik bernama Sona \'AI Engineer\'. Sona adalah CTA Energy Hack dan SonusHUB"},
                        {"role": "assistant", "content": "*SonusHUB*: PT. Tripower Solar Nusantara, lokasi: Jogja (DIY), web: sonus.id & solar-nusantara.id, Alamat: Artech Space Coworking Yogyakarta"},
                        {"role": "assistant", "content": "Energy Hack adalah acara tentang perencanaan, penganggaran, dan perhitungan PLTS oleh PINTAR (Project Indonesia Terang). Ditujukan untuk engineer, manajer energi, staff teknis, hingga mahasiswa yang berminat dalam bidang energi baru. Poster dan pendaftaran ada di indonesiaterang.id atau hubungi +6282180000575"},
                        {"role": "assistant", "content": "SonusHub adalah Platform B2B Wholesale Kelistrikan bagian dari *SonusHUB* yang akan diluncurkan. Setiap perusahaan atau toko listrik yang menjadi subscriber berkesempatan mendapat promo"},
                        {"role": "user", "content": "' . $request->message . '"}
                    ]
                }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . config('services.openai.key')
                ),
            ));
        } else {
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                "model": "gpt-4",
                "temperature": 0.2,
                "messages": [
                    {
                        "role": "system",
                        "content": "Nama anda Sona, AI Engineer dari *SonusHUB* (perusahaan energi baru). Asisten harus ramah dan bisa menjelaskan dengan detail beserta refrensinya. kurs: IDR"
                    },
                    {
                        "role": "system",
                        "content": "*SonusHUB*: PT. Tripower Solar Nusantara, lokasi: Jogja (DIY), web: sonus.id & solar-nusantara.id, Alamat: Artech Space Coworking Yogyakarta"
                    },
                    {
                        "role": "user",
                        "content": "' . $request->message . '"
                    }
                ]
            }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . config('services.openai.key'),
                ),
            ));
        }

        $response = curl_exec($curl);

        curl_close($curl);

        $res = json_decode($response, true);
        if ($res) {
			// if (Auth::check()) {
			// 	$data = Chat::create([
			// 		'user_id' => $request->user_id,
			// 		'user_role' => $request->user_role == "sonia" ? 'user' : 'user_sona',
			// 		'user_message' => $request->user_message,
			// 		'role' => $request->user_role,
			// 		'message' => @$res['choices'][0]['message']['content'],
			// 	]);

			// }
			$data = [
				'role' => $request->user_role,
				'message' => @$res['choices'][0]['message']['content'],
			];
			return response()->json([
				'success' => true,
				'data' => $data
			]);
		} else {
			return response()->json([
			'status' => 'error',
			'message' => 'Failed to get response from AI'
			]);
		}

            // if ($request->user_role == "sonia") {
            //     $data = Chat::create([
            //         'user_id' => $request->user_id,
            //         'user_role' => 'user',
            //         'user_message' => $request->user_message,
            //         'role' => 'sonia',
            //         'message' => @$res['choices'][0]['message']['content'],
            //     ]);
            //     return response()->json($data);

            // } else {
            //     $data = Chat::create([
            //         'user_id' => $request->user_id,
            //         'user_role' => 'user_sona',
            //         'user_message' => $request->user_message,
            //         'role' => 'sona',
            //         'message' => @$res['choices'][0]['message']['content'],
            //     ]);
            //     FcmUtility::send_notification($request->user_id, "Pesan dari Sona", @$res['choices'][0]['message']['content']);
            //     return response()->json($data); 
      

    }
}
