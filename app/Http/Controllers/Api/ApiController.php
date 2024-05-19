<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\UserApplication;
use App\Models\Partner;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Trash;
use App\Models\TrashCategory;
use App\Models\TrashPhoto;
use App\Models\TrashCategoryPhoto;
use App\Models\Transaction;
use App\Models\Vehicle;
use App\Models\Notification;
use Auth;
use DB;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function register_user(Request $request)
    {
        $rules = [
            'full_name' => 'required|string|max:100',
            'username' => 'required|unique:users',
            'phone' => 'required|min:5|max:30',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:5',
            'gender' => 'required',
            'birth_date' => 'required',
            'photo' => 'image|max:2048',
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required',
            'country' => 'required',
            'province' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user = new User();
        $user->full_name = $request->full_name;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->level = 'user';
        $user->gender = $request->gender;
        $user->birth_date = $request->birth_date;
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/user'), $imageName);
            $user->photo = $imageName;
        }
        $user->saldo = '0';
        $user->status = '1';
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->province = $request->province;
        $user->save();

        $result = [
            'message' => 'Registration successfully',
            'success' => true,
            'user' => $user
        ];

        return response()->json($result, 200);
    }

    public function login_user(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // $userApplication = UserApplication::where('user_id', $user->id)->first();

        // if (!$userApplication) {
        //     // Jika tidak ada aplikasi yang terkait dengan pengguna, Anda dapat menangani kasus ini sesuai kebutuhan
        //     throw new \Exception('No user application found.');
        // }
        // $partner = Partner::find($userApplication->partner_id);
        $result = [
            'message' => 'Login success',
            'success' => true,
            'data' => [
                'user' => $user,
                'partner' => $user->partner
            ],
            'token' => $user->createToken('login_api')->plainTextToken
        ];
        return response()->json($result, 200);
    }

    public function logout_user(Request $request)
    {
        $user = $request->user();
        DB::table('users')
            ->where('id', $user->id)
            ->update(['notif_token' => null]);
        $user->currentAccessToken()->delete();
        $result = [
            'message' => 'Logout success',
            'success' => true,
        ];
        return response()->json($result, 200);
    }

    public function getUser(Request $request, $id)
    {
        $user = User::with('partner')->findOrFail($id);

        $result = [
            'message' => 'Get user success',
            'success' => true,
            'user' => $user,
        ];
         return response()->json($result, 200);
    }
    public function getUserByPartner($partner_id)
    {
        $users = User::with('partner')
            ->where('partner_id', $partner_id)
            ->where('level', 'user')
            ->where('status_trash', '1')
            ->get();

        $result = [
            'message' => 'Get users by partner_id success',
            'success' => true,
            'users' => $users,
        ];

        return response()->json($result, 200);
    }
    public function getPartner()
    {
        $partner = Partner::with('openDays')->get();
        $result = [
            'message' => 'Get partner success ',
            'success' => true,
            'partner' => $partner,
        ];
         return response()->json($result, 200);
    }
    public function getPartnerDetails($id)
    {
        $partner = Partner::with('openDays')->find($id);

        $result = [
            'message' => 'Get detail partner success',
            'success' => true,
            'partner' => $partner,
        ];
         return response()->json($result, 200);
    }

    public function userApplication(Request $request)
    {
        $id_user = Auth::user()->id;
        $partner = $request->partner_id;

        // Check if user has existing ACCEPTED application with another partner
        $existingApplication = DB::table('user_applications')
            ->where('user_id', $id_user)
            ->where('status', 'ACCEPTED')
            ->where('partner_id', '!=' && '=', $partner)
            ->exists();

        if ($existingApplication) {
            $result = [
                'message' => 'You already have an ACCEPTED application with another partner.',
                'success' => false,
                'data' => null,
            ];
            return response()->json($result, 200);
        }

        // Create new user application
        $userApp = new UserApplication();
        $userApp->user_id = $id_user;
        $userApp->partner_id = $partner;
        $userApp->status = 'PENDING';
        $userApp->save();

        $result = [
            'message' => 'Success to apply partner',
            'success' => true,
            'data' => $userApp,
        ];
        return response()->json($result, 200);
    }

    public function getPartnerbyUser()
    {
        $userApplications = DB::table('user_applications')
        ->join('partners', 'user_applications.partner_id', '=', 'partners.id')
        ->select('partners.', 'user_applications.')
        ->where('user_applications.user_id', '=', Auth::id())
        ->get();

    $result = [
        'message' => 'Success retrieving data',
        'success' => true,
        'data' => $userApplications
    ];

    return response()->json($result, 200);
    }

    public function getNews()
    {
        $news = News::with('category')
                 ->with('partner')
                 ->get();

        $result = [
            'message' => 'success get news',
            'success' => true,
            'news' => $news
        ];

        return response()->json($news, 200);
    }
    public function getNewsDetail($id)
    {
        $news = News::with([
            'photos',
            'category'
        ])->findOrFail($id);

        $result = [
            'message' => 'success get news details',
            'success' => true,
            'news' => $news,
        ];

        return response()->json($result, 200);
    }
     //check auth
     public function check()
     {
         $user = Auth::user();
         $partners = User::with('partner')->where('id', $user->id)
             ->first();

         return response()->json([
             'success' => true,
             'message' => 'User telah diautentikasi',
             'user' => $partners,
             'partner' => $partners->partner
         ], 200);
     }

    public function postTransaction(Request $request)
    {
        $id_user = Auth::user()->id;
        $partner = $request->partner_id;
        $tpoint = $request->transaction_point;
        $session = Hash::make($request->session);
        $status = 'PENDING';

        $rules = [
            'transaction_point' => 'required|string',
            'partner_id' => 'required',
            'session' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
         // Check user's balance
        $user = User::find($id_user);
        if ($user->saldo < $tpoint) {
            return response()->json([
                'message' => 'Insufficient balance',
                'success' => false
            ], 400);
    }

        $trx = new Transaction();
        $trx->user_id = $id_user;
        $trx->partner_id = $partner;
        $trx->transaction_point = $tpoint;
        $trx->session = $session;
        $trx->status = $status;
        $trx->save();

        $result = [
            'message' => 'Transaction make success',
            'success' => true,
            'trx' => $trx
        ];

        return response()->json($result, 200);
    }


    public function getTrash()
    {
        $trash = Trash::with([
            'trash_photo',
            'trash_category'
        ])->get();

        $result = [
            'message' => 'success get trash data',
            'success' => true,
            'trash' => $trash
        ];
        return response()->json($result, 200);
    }

    public function getTrashbyPartner($partnerId)
    {
        $trash = Trash::where('partner_id', $partnerId)
            ->with(['trash_photo', 'trash_category'])
            ->get();

        $result = [
            'message' => 'success get trash data',
            'success' => true,
            'trash' => $trash
        ];

        return response()->json($result, 200);
    }


    public function pointExchange(Request $request)
    {

        $result = [
            'message' => 'success get trash data',
            'success' => true,
            'trash' => $trash
        ];
        return response()->json($result, 200);
    }
    public function update_status(Request $request)
    {
        $user = Auth::user()->id;
        $status_trash = $request->input('status_trash');
        DB::table('users')
            ->where('id', $user)
            ->update([
                'status_trash' => $status_trash,
                'updated_at' => DB::raw('now()')
            ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Status Berhasil terubah'
        ]);
    }
    public function getvehicle()
    {
        $vehicle = Vehicle::get();
        $result = [
            'success' => true,
            'data' => $vehicle,
            'message' => 'Success Mengambil kendaraan'
        ];
        return response()->json($result, 200);
    }
    public function getUserAll()
    {
        $user = User::get();
        $result = [
            'success' => true,
            'data' => $user,
            'message' => 'Success Mengambil kendaraan'
        ];
        return response()->json($result, 200);
    }
    public function getNotifbyId()
    {
        $user = Auth::user();
        $notif = Notification::where('user_id', $user->id)
                    ->with('users')
                    ->get();
        $result = [
            "success" => true,
            "notification" => $notif,
            "message" => "success mengambil notif"
        ];
        return response()->json($result, 200);
    }
    public function deleteNotifById($id)
    {
        $user = Auth::user();
        $notification = Notification::where('user_id', $user->id)
            ->where('id', $id)
            ->first();
        if (!$notification) {
            $result = [
                "success" => false,
                "message" => "Notifikasi tidak ditemukan."
            ];
            return response()->json($result, 404);
        }
        $notification->delete();

        $result = [
            "success" => true,
            "message" => "Notifikasi berhasil dihapus."
        ];
        return response()->json($result, 200);
    }

    public function updateTokenNotif(Request $request)
    {
        $user = Auth::user()->id;
        $notif_token = $request->input('notif_token');
        DB::table('users')
            ->where('id', $user)
            ->update([
                'notif_token' => $notif_token,
                'updated_at' => DB::raw('now()')
            ]);

        return response()->json([
            'status' => 'success',
            'data' => $notif_token,
            'message' => 'Sukses mengganti token device'
        ]);
    }

    public function sendNotification(Request $request)
    {
       $pushyToken = '2dbb4da1430cb2710255e3fac0e3fa2759228e8284f0b23ccba2543b96967a03';
    
        $userIds = $request->input('user_ids');
        $users = User::whereIn('id', $userIds)->get();
        $notificationData = [
            'title' => $request->input('title'),
            'message' => $request->input('message'),
        ];
    
        $successIds = [];
        $failureIds = [];
    
        foreach ($users as $user) {
            $deviceId = $user->notif_token;
    
            if ($deviceId) {
                $postData = [
                    'registration_ids' => [$deviceId],
                    'notification' => [
                        'title' => 'New Notification Driver',
                        'body' => 'Batch tersedia silahkan check',
                    ],
                    'data' => $notificationData,
                ];
    
                $headers = [
                    'Content-Type: application/json',
                ];
    
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.pushy.me/push?api_key=' . $pushyToken);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
                $response = curl_exec($ch);
                $res = json_decode($response);
                curl_close($ch);
    
                if ($res && isset($res->success)) {
                    $successIds[] = $user->id;
                } else {
                    $failureIds[] = $user->id;
                }
            } else {
                $failureIds[] = $user->id;
            }
        }
    
        $message = '';
        if (!empty($successIds)) {
            $message .= 'Notifications sent to users with IDs: ' . implode(', ', $successIds) . '. ';
        }
        if (!empty($failureIds)) {
            $message .= 'Failed to send notifications to users with IDs: ' . implode(', ', $failureIds);
        }
    
        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
    public function addNotifFirebase(Request $request)
    {
        $userIds = $request->input('user_ids');
        $firebaseDatabaseUrl = env('FIREBASE_DATABASE_URL');
    
        $notifications = [];
        $currentTime = Carbon::now();
    
        foreach ($userIds as $userId) {
            $notificationId = $this->getRandomId();
            $postData = [
                'user_id' => $userId,
                'title' => 'Tasker Sudah Bergerak',
                'message' => "Tasker telah menuju lokasi anda menggunakan",
                'time' => $currentTime->toIso8601String(),
            ];
            $ch = curl_init($firebaseDatabaseUrl . '/Notification/' . $userId . '/' . $notificationId . '.json');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
    
            if ($httpCode === 200) {
                $postData['id'] = $notificationId;
                $notifications[] = $postData;
            }
        }
    
        $result = [
            'success' => true,
            'notifications' => $notifications,
            'message' => 'Berhasil menambahkan notifikasi',
        ];
    
        return response()->json($result, 200);
    }
    
    private function getRandomId($length = 16)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        $charLength = strlen($characters);
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charLength - 1)];
        }
    
        return $randomString;
    }
    public function addNotifByUserId(Request $request)
    {
        $userIds = $request->input('user_ids');
        $subtitle = $request->input('subtitle');
        $title = $request->input('title');

        $notifications = [];
        foreach ($userIds as $userId) {
            $notification = new Notification([
                'user_id' => $userId,
                'title' => $title,
                'subtitle' => $subtitle,
            ]);
            $notification->save();

            $notifications[] = $notification;
        }

        $result = [
            'success' => true,
            'notifications' => $notifications,
            'message' => 'Berhasil menambahkan notifikasi',
        ];

        return response()->json($result, 200);
    }
}
