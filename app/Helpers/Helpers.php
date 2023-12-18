<?php

use Illuminate\Support\Facades\Auth;
use \App\Models\Message;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Staff;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;

if (!function_exists('showNotifications')) {
    function showNotifications()
    {
        $user = Auth::user();
        if (!$user) {
            return collect(); // No user logged in, return an empty collection
        }
        // Assuming you have a $userId representing the ID of the user you want notifications for
        $user = User::findOrFail($user->id);

        $notifications = $user->receivedNotifications()->get();
        return $notifications;
    }
}

if (!function_exists('showMessagesWithUsers')) {
    function showMessagesWithUsers()
    {
        showStaffsWithoutMessage();
        showDoctorsWithoutMessage();
        showUsersWithoutMessage();
        $user = Auth::user();

        if (!$user) {
            return new Collection(); // No user logged in, return an empty collection
        }
        $userId = Auth::user()->id;

        $threads = DB::select("SELECT
        `users`.`name`,
        `users`.`id`,
        `users`.`avatar`,
        COALESCE(latest_message.message_content, '') AS latest_message_content,
        SUM(CASE
            WHEN m.receiver_id = " . $userId . " AND m.is_read = 0 THEN 1
            ELSE 0
        END) AS unread
    FROM
        `users`
            LEFT JOIN
        (SELECT
            CASE
                    WHEN sender_id = " . $userId . " THEN receiver_id
                    ELSE sender_id
                END AS user_id,
                MAX(message_content) AS message_content
        FROM
            messages
        WHERE
            sender_id = " . $userId . " OR receiver_id = " . $userId . "
        GROUP BY CASE
            WHEN sender_id = " . $userId . " THEN receiver_id
            ELSE sender_id
        END) AS latest_message ON `users`.`id` = `latest_message`.`user_id`
            LEFT JOIN
        `messages` AS `m` ON `users`.`id` = `m`.`sender_id`
            OR `users`.`id` = `m`.`receiver_id`
    WHERE
        (`m`.`sender_id` = " . $userId . "
            OR `m`.`receiver_id` = " . $userId . ")
            AND `users`.`id` != " . $userId . "
    GROUP BY `users`.`id`
    ORDER BY `id` DESC");

        return $threads;
    }
}


if (!function_exists('showStaffsWithoutMessage')) {
    function showStaffsWithoutMessage()
    {
        $staff = Staff::where('user_id', auth()->id())->first();

        if ($staff) {
            $clinicId = $staff->clinic_id;

            // Get users associated with the clinic
            $usersInClinicQuery = DB::table('doctors')
                ->where('clinic_id', $clinicId)
                ->select('user_id')
                ->union(
                    DB::table('staff')
                        ->where('clinic_id', $clinicId)
                        ->select('user_id')
                );

            $usersInClinic = User::whereIn('id', $usersInClinicQuery)
                ->where('id', '!=', auth()->id())
                ->get();

            // Get IDs of users with messages involving the current user
            $authenticatedUserId = auth()->id();
            $usersWithMessages = Message::where(function ($query) use ($authenticatedUserId) {
                $query->where('receiver_id', $authenticatedUserId)
                    ->orWhere('sender_id', $authenticatedUserId);
            })
                ->pluck('receiver_id')
                ->merge(Message::where('sender_id', $authenticatedUserId)->pluck('sender_id'))
                ->unique();

            // Filter out users with messages from the clinic users
            $usersWithoutMessages = $usersInClinic->reject(function ($user) use ($usersWithMessages) {
                return $usersWithMessages->contains($user->id);
            });

            // Create messages for users without messages
            foreach ($usersWithoutMessages as $user) {
                Message::create([
                    'sender_id' => $authenticatedUserId,
                    'receiver_id' => $user->id,
                    'message_content' => 'Say Hi',
                    'is_read' => 1
                ]);
            }

            return $usersWithoutMessages;
        }
    }
}


if (!function_exists('showDoctorsWithoutMessage')) {
    function showDoctorsWithoutMessage()
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();

        if ($doctor) {
            $clinicId = $doctor->clinic_id;

            // Get users associated with the clinic
            $usersInClinicQuery = DB::table('doctors')
                ->where('clinic_id', $clinicId)
                ->select('user_id')
                ->union(
                    DB::table('doctors')
                        ->where('clinic_id', $clinicId)
                        ->select('user_id')
                );

            $usersInClinic = User::whereIn('id', $usersInClinicQuery)
                ->where('id', '!=', auth()->id())
                ->get();

            // Get IDs of users with messages involving the current user
            $authenticatedUserId = auth()->id();
            $usersWithMessages = Message::where(function ($query) use ($authenticatedUserId) {
                $query->where('receiver_id', $authenticatedUserId)
                    ->orWhere('sender_id', $authenticatedUserId);
            })
                ->pluck('receiver_id')
                ->merge(Message::where('sender_id', $authenticatedUserId)->pluck('sender_id'))
                ->unique();

            // Filter out users with messages from the clinic users
            $usersWithoutMessages = $usersInClinic->reject(function ($user) use ($usersWithMessages) {
                return $usersWithMessages->contains($user->id);
            });

            // Create messages for users without messages
            foreach ($usersWithoutMessages as $user) {
                Message::create([
                    'sender_id' => $authenticatedUserId,
                    'receiver_id' => $user->id,
                    'message_content' => 'Say Hi',
                    'is_read' => 1
                ]);
            }

            return $usersWithoutMessages;
        }
    }
}


if (!function_exists('showUsersWithoutMessage')) {
    function showUsersWithoutMessage()
    {
        $appointment = Appointment::where('user_id', auth()->id())->first();

        if ($appointment) {
            $clinicId = $appointment->clinic_id;

            // Get users associated with the clinic
            $usersInClinicQuery = DB::table('doctors')
                ->where('clinic_id', $clinicId)
                ->select('user_id')
                ->union(
                    DB::table('appointments')
                        ->where('clinic_id', $clinicId)
                        ->select('user_id')
                );

            $usersInClinic = User::whereIn('id', $usersInClinicQuery)
                ->where('id', '!=', auth()->id())
                ->get();

            // Get IDs of users with messages involving the current user
            $authenticatedUserId = auth()->id();
            $usersWithMessages = Message::where(function ($query) use ($authenticatedUserId) {
                $query->where('receiver_id', $authenticatedUserId)
                    ->orWhere('sender_id', $authenticatedUserId);
            })
                ->pluck('receiver_id')
                ->merge(Message::where('sender_id', $authenticatedUserId)->pluck('sender_id'))
                ->unique();

            // Filter out users with messages from the clinic users
            $usersWithoutMessages = $usersInClinic->reject(function ($user) use ($usersWithMessages) {
                return $usersWithMessages->contains($user->id);
            });

            // Create messages for users without messages
            foreach ($usersWithoutMessages as $user) {
                Message::create([
                    'sender_id' => $authenticatedUserId,
                    'receiver_id' => $user->id,
                    'message_content' => 'Say Hi',
                    'is_read' => 1
                ]);
            }

            return $usersWithoutMessages;
        }
    }
}
